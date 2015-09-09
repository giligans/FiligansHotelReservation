<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
class PaypalController extends BaseController
{

    private $_api_context;
    public function __construct()
    {
// setup PayPal api context
        $paypal_conf = Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }



    public function postPayment()
    {

        $payer = new Payer();
        $i = []; 
        $i['checkin'] = Session::get('reservation')['checkin'];
        $i['checkout'] = Session::get('reservation')['checkout'];
        $i['total_nights'] = Session::get('reservation')['nights'];
        $total_price = 0;
        $tax_price = 0;
//return Session::get('reservation');

//return Session::get('reservation')['reservation_room'][0]['room_details']['price'];
        $payer->setPaymentMethod('paypal');


        /*$roomKey variable for indexing the $rooms array.*/
        foreach(Session::get('reservation')['reservation_room'] as $roomKey=>$rooms)
        {

         $total_price+=$rooms['room_details']['price'] * $i['total_nights'] * $rooms['quantity'];


         $room_id = $rooms['room_details']['id'];
         $available_rooms = [];
         $room_qty = RoomQty::with(array('roomPrice','roomReserved'=>function($query) use($i, $room_id){
            $query->where(function($query2) use ($i, $room_id){
                $query2->whereBetween('check_in', array($i['checkin'], $i['checkout']))
                ->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
                ->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
                ->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
            })->where('status','!=',5);

        }))->where('room_id', $room_id)->get();
         foreach($room_qty as $available)
         {       
            if($available->roomReserved== '[]')
            {
              $item[$roomKey] = new Item();
             $item[$roomKey]->setName($rooms['room_details']['name']) // item name
             ->setDescription("Room \"".$rooms['room_details']['name']."\". P ".$rooms['room_details']['price']." per night (".$i['total_nights']." nights)")
             ->setCurrency('PHP')
             ->setQuantity($rooms['quantity'])
             ->setPrice($rooms['room_details']['price']*$i['total_nights']); 
         }
     }

    } //end of foreach


    /*gathering the items*/
    $item_list = new ItemList();
    $item_list->setItems($item);
//return $total_price;
    $tax_price = $total_price*0.12;


    /*set tax*/
    $details = new Details();
    $details
    ->setTax($tax_price)
    ->setSubtotal($total_price);
    $total_price += $tax_price;

    /*computing the amout*/
    $amount = new Amount();
    $amount->setCurrency('PHP')
    ->setDetails($details)
    ->setTotal($total_price);

    /*creation of transaction starts here*/
    $transaction = new Transaction();
    $transaction->setAmount($amount)
    ->setItemList($item_list)
    ->setDescription('Filigans Hotel Reservation');
    $redirect_urls = new RedirectUrls();
$redirect_urls->setReturnUrl(URL::route('payment.status')) // Specify return URL
->setCancelUrl(URL::route('payment.status'));
$payment = new Payment();
$payment->setIntent('Sale')
->setPayer($payer)
->setRedirectUrls($redirect_urls)
->setTransactions(array($transaction));
try {
    $payment->create($this->_api_context);
} catch (\PayPal\Exception\PPConnectionException $ex) {
    if (\Config::get('app.debug')) {
        echo "Exception: " . $ex->getMessage() . PHP_EOL;
        $err_data = json_decode($ex->getData(), true);
        exit;
    } else {
        die('Some error occur, sorry for inconvenient');
    }
}
foreach($payment->getLinks() as $link) {
    if($link->getRel() == 'approval_url') {
        $redirect_url = $link->getHref();
        break;
    }
}
// add payment ID to session
Session::put('paypal_payment_id', $payment->getId());
if(isset($redirect_url)) {
// redirect to paypal
    return Redirect::away($redirect_url);
}
return Redirect::route('original.route')
->with('error', 'Unknown error occurred');
}


public function getPaymentStatus()
{
// Get the payment ID before session clear
    $payment_id = Session::get('paypal_payment_id');
// clear the session payment ID
    Session::forget('paypal_payment_id');
    if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
        return Redirect::route('original.route')
        ->with('error', 'Payment failed');
    }
    $payment = Payment::get($payment_id, $this->_api_context);
// PaymentExecution object includes information necessary 
// to execute a PayPal account payment. 
// The payer_id is added to the request query parameters
// when the user is redirected from paypal back to your site
    $execution = new PaymentExecution();
    $execution->setPayerId(Input::get('PayerID'));
//Execute the payment
    $result = $payment->execute($execution, $this->_api_context);
    /*echo '<pre>';print_r($result);echo '</pre>';exit; // DEBUG RESULT, remove it later*/

if ($result->getState() == 'approved') { // payment made

    $tax = null;
    $total_price = null;
    $i = []; 
    $i['checkin'] = Session::get('reservation')['checkin'];
    $i['checkout'] = Session::get('reservation')['checkout'];
    $customerinformation = Session::get('reservation.customerinformation');

    $count = 0; //for test
    $count1 = 0; //for test
    $booked_room = []; //all picked rooms from available rooms
    $new_booking = new Booking;
    $new_booking->firstname = $customerinformation['firstname'];
    $new_booking->lastname = $customerinformation['lastname'];
    $new_booking->address = $customerinformation['address'];
    $new_booking->contact_number = $customerinformation['contact_no'];
    $new_booking->email_address = $customerinformation['email'];
    $new_booking->check_in = $i['checkin'];
    $new_booking->check_out = $i['checkout'];
    $new_booking->save();
    foreach(Session::get('reservation')['reservation_room'] as $rooms)
    {
        $count++;
        $room_id = $rooms['room_details']['id'];
        $available_rooms = [];
        $room_qty = RoomQty::with(array('roomPrice','roomReserved'=>function($query) use($i, $room_id){
            $query->where(function($query2) use ($i, $room_id){
                $query2->whereBetween('check_in', array($i['checkin'], $i['checkout']))
                ->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
                ->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
                ->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
            })->where('status','!=',5);

        }))->where('room_id', $room_id)->get();
        foreach($room_qty as $available)
        {       
            if($available->roomReserved== '[]')
            {
                array_push($available_rooms, $available);
            }
        }
        for($counter = 0; $counter<$rooms['quantity']; $counter++){
            array_push($booked_room, $available_rooms[$counter]);
        }
    } //end of foreach
    
    $total = 0;

    if(!empty($booked_room))
    {
        foreach($booked_room as $b)
        {   
            $total += $b->roomPrice->price * Session::get('reservation.nights');
            $tax = $total * 0.12;
            $total = $total + $tax;
            $reserveRoom = new ReservedRoom;
            $reserveRoom->booking_id = $new_booking->id;
            $reserveRoom->room_id = $b->id;
            $reserveRoom->price = $total;
            $reserveRoom->check_in = $i['checkin'];
            $reserveRoom->check_out = $i['checkout'];
            
            $reserveRoom->firstname = $customerinformation['firstname'];
            $reserveRoom->lastname = $customerinformation['lastname'];
            $reserveRoom->address = $customerinformation['address'];
            $reserveRoom->contact_number = $customerinformation['contact_no'];
            $reserveRoom->email_address = $customerinformation['email'];
            $reserveRoom->save();

        }
    }
    $tax = $total * 0.12;

    $total = $total + $tax;
    $new_booking->price = $total;
    $new_booking->paid = $total;
    $new_booking->status=1;
    $date = date('Ymd'); 
    $code = Str::random(5).$date;
    $new_booking->code = $code;
    $new_booking->save();
    Session::forget('reservation');
    return Redirect::to('booking/step5')->with('code', $code);


}
return 'error in payment';
}


}