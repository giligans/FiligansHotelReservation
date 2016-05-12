<?php
class BookingController extends \BaseController {
	/**
	* Display a listing of the resource.
	* GET /booking
	* 
	* @return Response
	*/	
	public function index()
	{
		if(Session::has('checkin') && Session::has('checkout') && Session::has('reserved_room_id')){
			$checkin = Session::get('checkin');
			$checkout = Session::get('checkout');
			$room_id = Session::get('reserved_room_id');
			$room_details = Room::where('id', $room_id)->select('id','name','price')->first();
			$available_rooms = 0;
			$room1 = [];
			//$roomDetails = Room::where('id')->first();
			$room = RoomQty::where('room_id', Session::get('reserved_room_id'))->with(array('roomReserved' => function($query){
				$query->whereBetween('check_in', array(Session::has('checkin'), Session::has('checkout')))
				->orWhereBetween('check_out', array(Session::has('checkin'), Session::has('checkout')))
				->orWhereRaw('"'.Session::has('checkin').'" between check_in and check_out')
				->orWhereRaw('"'.Session::has('checkout').'" between check_in and check_out')
				->where('status','!=',5);
			}))->get();	
			
			foreach($room as $r)
			{
				if($r->roomReserved->count()==0 && $r->status==1){
					$available_rooms++;
				}
			}
			
			$room = $room->toArray();
			$room1['quantity'] = $room;
			$room1['available_rooms']=$available_rooms;
			$cpage = 'booking';
			return View::make('clientview.booking.index', compact('cpage','available_rooms','room_details'));
		}
		else
		{
			return Redirect::to('/');
		}
	}

	/**
	* Show the form for creating a new resource.
	* GET /booking/create
	*
	* @return Response
	*/
	/*walk in payment*/
	/*cash payment only*/

	public function payment($id)
	{
		$i = Input::all();
		$b = Booking::where('id', $id)->first();
		if(!empty($b))
		{
			if($i['paid'] >= $b->price)
			{
				$b->paid = $i['paid'];
				$b->status = 1;
				$b->save();
				return 1;
			}
			else
			{
				return 0;
			}
		}
	}

	/*REQUEST TYPE IS GET*/

	public function getClientBookingStep2()
	{
		$cpage = 'booking.step2';
		$room = null;

		if(Session::has('reservation.checkin') && Session::has('reservation.checkout')){
			$i = [];
			$checkin = null;
			$checkout = null;
			$i['checkin'] = Session::get('reservation.checkin'). ' 12:00:00';
			$i['checkout'] = Session::get('reservation.checkout'). ' 11:59:00';
			$available_rooms = 0;
			$room = Room::with(array('roomQty.roomReserved' => function($query) use ($i){
				$query->where(function($query2) use($i){
					$query2->whereBetween('check_in', array($i['checkin'], $i['checkout']))
					->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
					->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
					->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
				})->where(function($query3)
				{
					$query3->where('status', '!=', 5)->where('status', '!=', 3);
				});
			}, 'roomQty' => function($query4)
			{
				$query4->where('status', 1);
			}))->get();
		}
		return View::make('clientview2.booking.step2', compact('cpage','room'));

	}	

	public function getClientBookingStep3()
	{
		$cpage = 'booking.step3';
		return View::make('clientview2.booking.step3', compact('cpage'));

	}

	/*REQUEST TYPE IS POST*/
	public function clientBookingStep1()
	{
		$i = Input::all();

		if(Input::has('checkin') && Input::has('checkout')){
			$checkin = Carbon::parse(Input::get('checkin'));
			$checkout = Carbon::parse(Input::get('checkout'));
			if($checkin->gte($checkout))
			{
				return Redirect::to('booking')->with('error','Check-out date must be greater than Check-in date.');
			}
			Session::put('reservation.checkin', $i['checkin']);
			Session::put('reservation.checkout', $i['checkout']);
			Session::put('reservation.display_checkout',  $i['checkout']);
			return Redirect::to('booking/step2');
		}
	}

	public function clientBookingStep2Direct()
	{
		$i = Input::all();
		$rooms = [];
	//return $i;
		$count = 0;
		foreach($i['reservation_room'] as $room){
			$count++;
			$r = Room::where('id', $room['room_id'])->select('id','name','price')->first();
			$i['reservation_room'][$count-1]['room_details'] = $r;
			array_push($rooms, $r);
		}
		Session::put('reservation', $i);

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
				})->where(function($query3)
				{
					$query3->where('status', '!=', 5)->where('status', '!=', 3);
				});
			}))->where('room_id', $room_id)->where('status',1)->get();

			foreach($room_qty as $available)
			{
				if($available->roomReserved== '[]' || count($available->roomReserved) == 0)
				{
					array_push($available_rooms, $available);
				}
			}
			if(count($available_rooms) < $rooms['quantity'])
			{
				return Redirect::to('booking/step2')->with('error', 'Some rooms you booked is not available');
			}
		} 

		return Redirect::to('booking/step3');

	}

	public function clientBookingStep2()
	{
		$i = Input::all();
		$x = [];
		$room_reservation['reservation_room'] = [];
		$i['checkin'] = Session::get('reservation.checkin'). ' 12:00:00';
		$i['checkout'] = Session::get('reservation.checkout'). ' 11:59:00';
		$room_reservation['checkin'] = Session::get('reservation.checkin'). ' 12:00:00';
		$room_reservation['checkout'] = Session::get('reservation.checkout'). ' 11:59:00';
		$room_reservation['display_checkout'] = Session::get('reservation.display_checkout');

		foreach($i['rooms'] as $r){
			if($r['quantity']>0){
				array_push($room_reservation['reservation_room'], $r);
			}
		}
		$count = 0;
		$rooms = [];
		foreach($room_reservation['reservation_room'] as $room){
			$count++;
			$r = Room::where('id', $room['room_id'])->select('id','name','price')->first();
			$room_reservation['reservation_room'][$count-1]['room_details'] = $r;
			array_push($rooms, $r);
		}
		Session::put('reservation', $room_reservation);

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
				})->where(function($query3)
				{
					$query3->where('status', '!=', 5)->where('status', '!=', 3);
				});
			}))->where('room_id', $room_id)->where('status',1)->get();

			foreach($room_qty as $available)
			{
				if($available->roomReserved== '[]' || count($available->roomReserved) == 0)
				{
					array_push($available_rooms, $available);
				}
			}
			if(count($available_rooms) < $rooms['quantity'])
			{
				return Redirect::to('booking/step2')->with('error', 'Some rooms you booked is not available');
			}
		} 
		return Redirect::to('booking/step3');
	}

	public function clientBookingStep3()
	{
		/*
	foreach(Session::get('reservation')['reservation_room'] as $rooms)
	{
	
		$room_id = $rooms['room_details']['id'];
		$available_rooms = [];
		$room_qty = RoomQty::with(array('roomPrice','roomReserved'=>function($query) use($i, $room_id){
			$query->where(function($query2) use ($i, $room_id){
				$query2->whereBetween('check_in', array($i['checkin'], $i['checkout']))
				->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
				->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
				->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
			})->where(function($query3)
			{
				$query3->where('status', '!=', 5)->orWhere('status', '!=', 3);
			});
		}))->where('room_id', $room_id)->where('status',1)->get();

		foreach($room_qty as $available)
		{
			if($available->roomReserved== '[]' || count($available->roomReserved) == 0)
			{
				array_push($available_rooms, $available);
			}
		}
		if(count($available_rooms) < $rooms['quantity'])
		{
			return Redirect::to('booking/step2')->with('error', 'Some rooms you booked is not available');
		}
	} 
*/
	$i = Input::all();
	if(isset($i['membership_id']))
	{
		$membership = Customer::where('membership_id',$i['membership_id'])->first();
		if($membership)
		{
			Session::forget('reservation.customerdiscount');
			//unset(Session::get('reservation.customerdiscount'));
			Session::put('reservation.customerdiscount',$membership->current_discount);
		}
	}
	Session::forget('reservation.customerinformation');
	Session::put('reservation.customerinformation', $i);
		//return Session::get('reservation.customerinformation')['firstname'];
	return Redirect::to('booking/step4');

}

public function clientBookingStep4()
{
		/*foreach(Session::get('reservation')['reservation_room'] as $rooms)
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
			})->where(function($query3)
			{
				$query3->where('status', '!=', 5)->orWhere('status', '!=', 3);
			});
		}))->where('room_id', $room_id)->where('status',1)->get();

		foreach($room_qty as $available)
		{
			if($available->roomReserved== '[]' || count($available->roomReserved) == 0)
			{
				array_push($available_rooms, $available);
			}
		}
		if(count($available_rooms) < $rooms['quantity'])
		{
			return Redirect::to('booking/step2')->with('error', 'Some rooms you booked is not available');
		}
	} */


	try
	{

		$data =
		$total_price = 0;
		foreach(Session::get('reservation')['reservation_room'] as $reservation)
		{

			$total_price+=$reservation['room_details']['price'];
		}

		if(Session::has('reservation.customerdiscount'))
		{
			$discount = new Discount;
			Session::put('reservation.customerdiscountprice', $discount->calculateDiscount(1000, Session::get('reservation')['customerdiscount']['effect'], Session::get('reservation')['customerdiscount']['effect_type']));
		}
		
		$ci = new Carbon(Session::get('reservation')['checkin']);
		$co = new Carbon(Session::get('reservation')['checkout']);
		$diff = $co->addMinutes(1)->diff($ci)->days;

		Session::put('reservation.nights', $diff);
		$cpage = 'booking.step4';
		return View::make('clientview2.booking.step4', compact('cpage'));

	}
	catch(exception $e)
	{
		return $e;
		Session::forget('reservation');
		return Redirect::to('booking')->with('error', 'Something went wrong. Please try again.');
	}
}

public function clientBookingStep5()
{
	//return Session::get('reservation');
	$tax = null;
	$total_price = null;
	$i = []; 
	$i['checkin'] = Session::get('reservation')['checkin'].' 12:00:00';
	$i['checkout'] = Session::get('reservation')['checkout']. '11:59:00';
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
			})->where(function($query3)
			{
				$query3->where('status', '!=', 5)->where('status', '!=', 3);
			});

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
			/*$reserveRoom->check_in = $i['checkin'];
			$reserveRoom->check_out = $i['checkout'];
			$reserveRoom->firstname = $customerinformation['firstname'];
			$reserveRoom->lastname = $customerinformation['lastname'];
			$reserveRoom->address = $customerinformation['address'];
			$reserveRoom->contact_number = $customerinformation['contact_no'];
			$reserveRoom->email_address = $customerinformation['email'];*/
			$reserveRoom->save();
		}
	}
	$tax = $total * 0.12;
	$total = $total + $tax;
	$new_booking->price = $total;
	$new_booking->save();
	return Redirect::to('booking/step5');
}


public function searchList()
{
	$i = Input::all();
	$query = Booking::with('reservedRoom.room.roomDetails','remarksHistory')->whereBetween('check_in', array($i['startdate'], $i['enddate']))
	->orWhereBetween('check_out', array($i['startdate'], $i['enddate']))
	->orWhereRaw('"'.$i["startdate"].'" between check_in and check_out')
	->orWhereRaw('"'.$i["enddate"].'" between check_in and check_out')
	->where('status','!=',5)->get();
	return $query;	
}

public function searchBooking($id)
{
	$query = Booking::with('reservedRoom_grp.room.roomDetails','remarksHistory')->where('id', $id)->first();
	if(!empty($query))
	{
		return $query;
	}
}

public function thisYearList()
{	
	$today = date("Y");
	if(isset($_GET['filtertype']))
	{
		if($_GET['filtertype']!=1)
		{
			$today = (isset($_GET['year1'])) ? $_GET['year1'] :  date("Y");
			$room = Room::with('roomQty')->with(array('roomQty.roomReserved' => function($query) use ($today)
			{
				$query->whereRaw('YEAR(check_in) = '.$today);
			}))->select('id','name')->get();
			$output = [];
			return $room;
		}
		else
		{
			$year1 = (isset($_GET['year1'])) ? $_GET['year1'] :  date("Y");
			$year2 = (isset($_GET['year2'])) ? $_GET['year2'] :  date("Y");

			$year1_result = Room::with('roomQty')->with(array('roomQty.roomReserved' => function($query) use ($year1)
			{
				$query->whereRaw('YEAR(check_in) = '.$year1);
			}))->select('id','name')->get();

			$year2_result = Room::with('roomQty')->with(array('roomQty.roomReserved' => function($query) use ($year2)
			{
				$query->whereRaw('YEAR(check_in) = '.$year2);
			}))->select('id','name')->get();

			$result = array();
			$result['year1'] = $year1_result;
			$result['year2'] = $year2_result;
			return $result;
		}
	}
	$booking_recent = ReservedRoom::with('room.roomDetails2')->whereRaw('YEAR(check_in) = '.$today)->get();
	$room = Room::with('roomQty')->with(array('roomQty.roomReserved' => function($query) use ($today)
	{
		$query->whereRaw('YEAR(check_in) = '.$today);
	}))->select('id','name')->get();
	$output = [];
	return $room;
	if(!empty($booking_recent)){
		$output['booking'] = $booking_recent;
		$output['rooms'] = $room;
		return $output;
	}else{
		return '0';
	}
}

public function bookingList()
{
	$arr = [];
	$arr = getallheaders();
	$b = null;
	$count = null;
	if(isset($arr['Range']))
	{ 
		$response_array = array();
		$response_array['Accept-Ranges'] = 'items';
		$range = $arr['Range'];
		$response_array['Range-Unit'] = 'items';
		$arr = explode('-', $arr['Range']);
		$items = $arr[1] - $arr[0]+1;
		$skip = $arr[0];
		$skip = ($skip < 0) ? 0 : $skip;
		$c = null;
		if(isset($_GET['query']))
			{	/*query variables*/
				$query = $_GET['query'];
				$startdate = $_GET['startdate'];
				$enddate = ($_GET['enddate']=='') ? date('Y-m-d') : $_GET['enddate'];
				$status_arr = array();
				if($_GET['pending']=='true')
				{
					array_push($status_arr, 0);
				}
				if($_GET['paid']=='true')
				{
					array_push($status_arr, 1);
				}
				if($_GET['occupied']=='true')
				{
					array_push($status_arr,  2);
				}
				if($_GET['ended']=='true')
				{
					array_push($status_arr, 3);
				}
				if($_GET['preparing']=='true')
				{
					array_push($status_arr, 4);
				}
				if($_GET['cancelled']=='true')
				{
					array_push($status_arr, 5);
				}
				if($_GET['overdue']=='true')
				{
					array_push($status_arr, 6);
				}
				$status_arr = (count($status_arr) > 0 ? $status_arr : array(0,1,2,3,4,5,6) );
				/*end of query variables*/
				$count = Booking::with('reservedRoom_grp.room.roomDetails','remarksHistory')
				->where('id', 'LIKE', "%$query%")
				->orWhereRaw("concat_ws(' ',firstname,lastname) LIKE '%$query%'")	
				->orWhere('firstname', 'LIKE', "%$query%")
				->orWhere('lastname', 'LIKE', "%$query%")
				->orWhere('code', 'LIKE', "%$query%")
				->get()->count();

				if(isset($_GET['orderBy']) && $_GET['orderBy'] != '')
				{
					$orderBy = $_GET['orderBy'];
					$count = Booking::with('reservedRoom_grp.room.roomDetails','remarksHistory')
					->where(function($query1) use ($query){
						$query1->where('id', 'LIKE', "%$query%")
						->orWhereRaw("concat_ws(' ',firstname,lastname) LIKE '%$query%'")
						->orWhere('firstname', 'LIKE', "%$query%")
						->orWhere('lastname', 'LIKE', "%$query%")
						->orWhere('code', 'LIKE', "%$query%");
					})
					->where(function($date) use ($startdate, $enddate)
					{
						$date->whereBetween('check_in', array($startdate, $enddate))
						->orWhereBetween('check_out', array($startdate, $enddate))
						->orWhereRaw('"'.$startdate.'" between check_in and check_out')
						->orWhereRaw('"'.$enddate.'" between check_in and check_out');
					})
					->where(function($status) use ($status_arr)
					{
						$status->whereIn('status', $status_arr);
					})->get()->count();

					$b = Booking::with('reservedRoom_grp.room.roomDetails','remarksHistory')
					->where(function($query1) use ($query){
						$query1->where('id', 'LIKE', "%$query%")
						->orWhereRaw("concat_ws(' ',firstname,lastname) LIKE '%$query%'")
						->orWhere('firstname', 'LIKE', "%$query%")
						->orWhere('lastname', 'LIKE', "%$query%")
						->orWhere('code', 'LIKE', "%$query%");
					})
					->orWhere(function($date) use ($startdate, $enddate)
					{
						$date->whereBetween('check_in', array($startdate, $enddate))
						->orWhereBetween('check_out', array($startdate, $enddate))
						->orWhereRaw('"'.$startdate.'" between check_in and check_out')
						->orWhereRaw('"'.$enddate.'" between check_in and check_out');
					})
					->where(function($status) use ($status_arr)
					{
						$status->whereIn('status', $status_arr);
					})
					->orderBy("$orderBy" , 'DESC')
					->skip($skip)->take($items)->get();
				}
				else
				{
					$orderBy = $_GET['orderBy'];
					$count = Booking::all()->count();
					$b = Booking::with('reservedRoom_grp.room.roomDetails','remarksHistory')
					->where('id', 'LIKE', "%$query%")
					->orWhereRaw("concat_ws(' ',firstname,lastname) LIKE '%$query%'")
					->orWhere('firstname', 'LIKE', "%$query%")
					->orWhere('lastname', 'LIKE', "%$query%")
					->orWhere('code', 'LIKE', "%$query%")
					->skip($skip)->take($items)->get();
				}
				$response = Response::make($b, 200);
				$response_array['Content-Ranges'] = 'itemss '.$range.'/'.$count;
				$response->header('Content-Range',$response_array['Content-Ranges'])
				->header('Accept-Ranges', 'items')->header('Range-Unit', 'items')->header('Total-Items', $count)
				->header('Flash-Message','Now showing pages '.$arr[0].'-'.$arr[1].' out of '.$count);
				return $response;
			}else
			{
				$count = Booking::all()->count();
				if(isset($_GET['orderBy']) && $_GET['orderBy'] != '')
				{
					$orderBy = $_GET['orderBy'];
					$b = Booking::with('reservedRoom_grp.room.roomDetails','remarksHistory')
					->orderBy("$orderBy", 'DESC')->skip($skip)->take($items)->get();
				}else
				{
					$b = Booking::with('reservedRoom_grp.room.roomDetails','remarksHistory')->skip($skip)->take($items)->get();
				}
			}
			$response = Response::make($b, 200);
			$response_array['Content-Ranges'] = 'items '.$range.'/'.$count;
			$response->header('Content-Range',$response_array['Content-Ranges'])
			->header('Accept-Ranges', 'items')->header('Range-Unit', 'items')->header('Total-Items', $count)
			->header('Flash-Message','Now showing pages '.$arr[0].'-'.$arr[1].' out of '.$count);
			return $response;
		}

		$b = Booking::all();
		$response = Response::make($b, 200);
		$response->header('Content-Ranges', 'test');
		return $response;
	}

	public function create()
	{
		//
	}
	/**
	* Store a newly created resource in storage.
	* POST /booking
	* @return
	* @return Response
	*/
	public function store()
	{	
		//
	}
	/**
	* Display the specified resource.
	* GET /booking/{id}
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id)
	{
		//
		//
		//
		//
	}
	/**
	* Show the form for editing the specified resource.
	* GET /booking/{id}/edit
	*
	* @param  int  $id
	* @return Response
	*/
	public function edit($id)
	{
		//
	}
	/**
	* Update the specified resource in storage.
	* PUT /booking/{id}
	*	
	*	
	*	
	* @param  int  $id
	* @return Response
	*/

	public function bookingStatus($status)
	{
		if($status==1)
		{
			return 'paid';
		}else if($status==0){
			return 'pending';
		}else if($status==5){
			return 'cancelled';
		}
	}
	
	public function update($id)
	{
		$today = date("Y-m-d H:i:s");
		$i = Input::all();
		$bookingRemarks = '';
		$addition = 0;
		$deduction = 0;
		if($i['savethis']==true)
		{
			$addition -= $i['price_addition'];
			$deduction += $i['price_deduction'];
		}
		$booking = Booking::where('id', $id)->with('reservedRoom.room.roomDetails')->first();
		//$booking = ReservedRoom::where('id', $id)->with('room.roomDetails')->first();
		$old_status= $booking->status;
		$current_price = $booking->price;
		$current_price += $addition + $deduction;

		if(!empty($booking))
		{
			$booking->status = $i['status'];
			if($i['status']==5)
			{
				$booking->cancelled_at = $today;
				$booking->paid=0;
				$booking->price = 0;
				$booking->cancelled_remarks = $i['cancelled_remarks'];
			}else if($i['status']==1){
				$booking->paid = $i['paid'];
			}else{
				//$booking->paid=0;
				$booking->price = $current_price;
				$booking->cancelled_remarks = '';
				$booking->cancelled_at = '0000-00-00 00:00:00';
			}
			if($booking->save())
			{
				if($i['savethis']==true)
				{
					$newBookingRemarks  = new BookingRemarksHistory;
					$newBookingRemarks->additional =$addition;
					$newBookingRemarks->deduction =$deduction;
					$newBookingRemarks->remarks = $i['bookingremarks'];
					$newBookingRemarks->booking_id = $id;
					$newBookingRemarks->save();
				}

				$roomReserved = ReservedRoom::where('booking_id', $booking->id)->get();
				foreach($roomReserved as $rr)
				{
					$rr->status = $i['status'];
					$rr->save();
				}

				$a = new Activity;
				$a->actor = Auth::id();
				$a->location=3;
				$a->logs = 'Updated booking ID of:'.$booking->id.' by '.$booking->firstname.' '.$booking->lastname.' from '.$this->bookingStatus($old_status).' to '.$this->bookingStatus($booking->status); //before to after status.
				$a->save();
				return $booking;
			}else{
				return '0'; //means failed
			}
		}
	}
	/**
	* Remove the specified resource from storage.
	* DELETE /booking/{id}
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{
		//
	}
}