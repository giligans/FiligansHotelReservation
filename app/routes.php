<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/




Route::get('/', function()
{
	$cpage = 'home';
	/*return View::make('clientview.index', compact('cpgae'));*/ // this will output the first layout
	return View::make('clientview2.index', compact('cpage')); // this will output the second layout
});

//Route::get('booking' ,'BookingController@index');
Route::get('contact', function(){
	$cpage = 'contact';
	// return View::make('clientview.contact', compact('cpage')); //this will output the first layout
	return View::make('clientview2.contact', compact('cpage')); //this will output the second layout
});
Route::get('gallery', function(){
	$cpage = 'gallery';
	return View::make('clientview2.gallery', compact('cpage'));
});

Route::get('checkmembership/{membership_id}', 'CustomersController@checkMembership');
Route::post('checkcode/{code}', 'DiscountsController@checkCode');
Route::get('services', function(){
	$cpage = 'services';
	return View::make('clientview2.services', compact('cpage'));
});

Route::get('about', function(){
	$cpage = 'about';
	return View::make('clientview2.about', compact('cpage'));
});

Route::get('features_and_services', function(){
	$cpage = 'features_and_services';
	return View::make('clientview2.features_services', compact('cpage'));
});

Route::get('booking', function(){
	Session::forget('reservation');
	$cpage = 'booking.step1';
	return View::make('clientview2.booking.step1', compact('cpage'));
});

Route::post('booking/step1', 'BookingController@clientBookingStep1');

Route::get('booking/step2', 'BookingController@getClientBookingStep2');

Route::post('booking/step2/direct', 'BookingController@clientBookingStep2Direct');

Route::post('booking/step2', 'BookingController@clientBookingStep2');

Route::get('booking/step3', 'BookingController@getClientBookingStep3');

Route::post('booking/step3', 'BookingController@clientBookingStep3');

Route::get('booking/step4', 'BookingController@clientBookingStep4');

Route::post('booking/payment', array(
	'as' => 'payment',
	'uses' => 'PaypalController@postPayment',
	));
// this is after make the payment, PayPal redirect back to your site

Route::get('payment/status', array(
	'as' => 'payment.status',
	'uses' => 'PaypalController@getPaymentStatus',
	));

Route::post('booking/step5', 'BookingController@clientBookingStep5');

Route::get('booking/step5', function(){
	$cpage = 'booking.step5';
	return View::make('clientview2.booking.step5', compact('cpage'));
});

Route::get('payment_done/{payum_token}', array('as' => 'payment_done', 'uses' => 'PaymentController@done'));

Route::get('room', function(){
	$cpage = 'room';
	$room = Room::with('roomQty','roomImages.photo')->get();
	//return $room;
	return View::make('clientview2.room.index', compact('room','cpage')); //this will output the second layout
});

Route::get('testpaypal', 'PaypalController@prepareExpressCheckout');

Route::get('room1', function(){
	$cpage = 'room';
	return View::make('clientview.room', compact('cpage'));
});

Route::post('reservation/proceed', function(){
	$i = Input::all();
	Session::put('checkin', $i['checkin']);
	Session::put('checkout', $i['checkout']);
	Session::put('reserved_room_id', $i['id']);
	return $i;
});



Route::get('room/{id}', function($id){
	$room = Room::where('id',$id)->with('roomQty','roomImages.photo')->first();
	$cpage = 'room';

	if(!empty($room)){
		return View::make('clientview2.room.show', compact('room', 'cpage'));
	}

	return Redirect::to('room');
});

Route::post('room/{id}/availability', function($id){
	$i = Input::all();
	$i['checkin'] = date('Y-m-d 12:00:00', strtotime($i['checkin']));
	$i['checkout']=date('Y-m-d 11:59:59', strtotime('+'.$i['nights'].' day', strtotime($i['checkin'])));

	$available_rooms = 0;
	$room1= [];
	//$roomDetails = Room::where('id')->first();
	$room = RoomQty::where('room_id', $id)->with(array('roomReserved' => function($query) use ($id ,$i){
		$query->where(function($query2) use($id, $i){
			$query2->whereBetween('check_in', array($i['checkin'], $i['checkout']))
			->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
			->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
			->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
		})->where(function($query3)
		{
			$query3->where('status', '!=', 5)->where('status', '!=', 3);
		});
	}))->where('status',1)->get();
	
	foreach($room as $r)
	{
		if($r->roomReserved->count()==0){
			$available_rooms++;
		}
	}

	$room = $room->toArray();
	$room1['quantity'] = $room;
	$room1['available_rooms']=$available_rooms;
	$reservation = [];
	$reservation['quantity'] = $i['quantity'];
	$reservation['checkin'] = $i['checkin'];
	$reservation['checkout'] = $i['checkout'];
	$reservation['display_checkout'] =$i['checkout'];
	$reservation['room_id'] = $id;
	if($available_rooms >= $i['quantity']){
		$reservation['status'] = 1; // means available
		return $reservation;
	}else{
		$reservation['status'] = 0; // means unavailable :(
			return $reservation;
		}
	});

Route::post('room/availability', function($id){
	$i = Input::all();
	$available_rooms = 0;
	$room = RoomQty::with(array('roomReserved' => function($query) use ($i){
		$query(function($query2) use($i){
			$query2->whereBetween('check_in', array($i['checkin'], $i['checkout']))
			->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
			->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
			->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
		})->where('status','!=',5);
	}))->get();
	foreach($room as $r)
	{
		if(empty($r->roomReserved)){
			$available_rooms++;
		}
	}
	//return $room;
	return $available_rooms;
});

/*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*/
/*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*/
/*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*/
/*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*/
/*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*/
Route::post('testupload', function(){
	$i = Input::all();
	$name = Input::file('file')->getClientOriginalName();
	$name = md5($name.Carbon::now());
	$image= $image2= Image::make($i['file']->getRealPath());
	$image->save(public_path('upload').'/'.$name.'.jpg');
	$upload = new Photos;
	$upload->filename = $name.'.jpg';
	$photo = [];
	$photo['image'] = 'image';
	if($upload->save())
	{
		$photo['photo'] = $upload;
		return $photo;
	}
			//	return $image;
});
/*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*/
/*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*/
/*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*/
/*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*/
/*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*//*DONT DELETE!!!*/


Route::post('room/availability', 'RoomController@availability');
/*Route::get('test2', function(){
	return View::make('design.one');
});
Route::get('test3', function(){
	return View::make('design.two');
});
Route::get('test4', function(){
	return View::make('design.three');
});
Route::get('test5', function(){
	return View::make('design.four');
});
Route::get('test5/room', function(){
	return View::make('design.four-room');
});
Route::get('testnavigation', function(){
	return View::make('design.navigation');
});
Route::get('test6', function(){
	return View::make('design.five');
});*/

/*ADMIN VIEW HERE*/
Route::get('login', function(){
	return View::make('adminview.login');
});
Route::get('logout', function()
{
	Auth::logout();
	return Redirect::to('/login');
});

Route::post('login', function(){
	$i = Input::all();
	if (Auth::attempt(array('username' => $i['username'], 'password' => $i['password'])))
	{
		return Redirect::intended('adminsite');
	}else
	{
		return Redirect::back()->with('error', 'Incorrect username or password');
	}
});

Route::group(array('prefix'=>'adminsite', 'before' => 'auth'), function(){

	Route::get('/', 'DashboardController@index');
	Route::get('template/pagination', function()
	{
		return View::make('template.pagination');
	});

	Route::get('monitoring', 'DashboardController@liveMonitoring');
	Route::get('monitoring/ajax', 'DashboardController@ajaxLiveMonitoring');
	Route::get('todaystatistics/ajax', 'DashboardController@ajaxTodayStatistics');
	
	Route::get('customer', 'CustomersController@index');
	Route::get('customer/{id}/show', 'CustomersController@show');
	Route::get('customer/ajax', 'CustomersController@ajaxCustomers');
	Route::get('customer/search/{search}', 'CustomersController@searchCustomer');
	Route::post('customer/create', 'CustomersController@store');
	Route::post('customer/{id}/delete', 'CustomersController@delete');
	Route::post('customer/update', 'CustomersController@update');
	Route::get('discount', 'DiscountsController@index');
	Route::get('discount/{id}/show' ,'DiscountsController@show');
	Route::get('discount/type', 'DiscountsController@listDiscountType');
	Route::get('discount/customers', 'DiscountController@listCustomer');
	Route::get('discount/customer-discounts', 'DiscountsController@makeCustomerDiscounts');
	
	Route::get('discount/{id}/ajax', 'DiscountsController@ajaxCustomerDiscounts');
	Route::get('discount/ajax', 'DiscountsController@ajaxDiscounts');
	Route::post('discount/customer/{id}/delete', 'DiscountsController@deleteCustomerDiscounts');
	Route::post('discount/type/create', 'DiscountsController@createType');
	Route::post('discount/type/update', 'DiscountsController@updateDiscount');
	Route::post('discount/type/create', 'DiscountsController@makeDiscountType');
	Route::post('discount/customers-discounts/create', 'DiscountsController@makeCustomerDiscount');
	Route::post('discount/{id}/delete', 'DiscountsController@deleteDiscount');


	/*FOR PULLING DATA VIA AJAX*/

	Route::get('activity/logs', 'ActivitiesController@logs');
	Route::get('dashboard/success_booking/ajax', 'DashboardController@ajax_todayBookingSuccess');
	Route::get('dashboard/cancelled_booking/ajax', 'DashboardController@ajax_todayBookingCancelled');
	Route::get('dashboard/pending_booking/ajax', 'DashboardController@ajax_todayBookingPending');
	Route::get('dashboard/arrival/ajax', 'DashboardController@ajax_todayArrival');
	Route::get('dashboard/departure/aPassword::sendReminder(user, token, callback)jax', 'DashboardController@ajax_todayDeparture');
	Route::get('dashboard/occupied_booking/ajax', 'DashboardController@ajax_todayBookingOccupied');
	Route::get('dashboard/preparing_booking/ajax', 'DashboardController@ajax_todayBookingPreparing');
	Route::get('dashboard/success_booking', 'DashboardController@todayBookingSuccess');
	Route::get('dashboard/cancelled_booking', 'DashboardController@todayBookingCancelled');
	Route::get('dashboard/pending_booking', 'DashboardController@todayBookingPending');
	Route::get('dashboard/arrival', 'DashboardController@todayArrival');
	Route::get('dashboard/departure', 'DashboardController@todayDeparture');
	Route::get('dashboard/occupied', 'DashboardController@todayBookingOccupied');
	Route::get('dashboard/preparing', 'DashboardController@todayBookingPreparing');

	Route::get('reservation/list/ajax', 'BookingController@thisYearList');
	Route::get('activity', 'ActivitiesController@index');
	Route::get('room', 'RoomController@index');
	Route::get('room/all', 'RoomController@allrooms');
	Route::get('room/search/{query}', function($query){
		$r = RoomQty::where('room_no', $query)->first();

		if(!empty($r)){

			$room_id = $r->room_id;

			$rooms = Room::with('roomQty','roomImages.photo')->where('id', $room_id)->get();
			//return 'heyt';
			return $rooms;
		}else{
			return '0';
		}
		return 'hey';
	});
	Route::get('user', 'UsersController@index');
	Route::post('user/create', 'UsersController@store');
	Route::post('user/{id}/delete', 'UsersController@destroy');
	Route::post('user/{id}/update', 'UsersController@update');
	Route::get('settings', function(){
		$cpage = 'settings';
		return View::make('adminview.settings.index', compact('cpage'));
	});
	Route::get('booking', function(){
		$cpage = 'booklst';
		$r = Room::select('id','name')->get();
		return View::make('adminview.booking.index', compact('cpage', 'r'));
	});

	Route::get('getbookinglist', 'BookingController@bookingList');
	Route::post('getbookinglist/search', 'BookingController@searchList');
	Route::post('getbookinginfo/{id}', 'BookingController@searchBooking');
	Route::post('booking/{id}/update', 'BookingController@update');
	Route::post('booking/{id}/payment', 'BookingController@payment');
	Route::post('currentbooking/save', function()
	{
		$i = Input::all();
		return $i;
		$membershipDiscount = null;
		if(isset($i['membership_id']))
		{
			$membership = Customer::where('membership_id',$i['membership_id'])->first();
			if($membership)
			{
				$membershipDiscount = $membership->current_discount;
			}
		}

		$booking = Booking::where('id', $i['booking_id'])->first();
		if($booking)
		{

			$booking->firstname = $i['firstname'];
			$booking->lastname = $i['lastname'];
			$booking->address = $i['address'];
			$booking->contact_number = $i['contact_no'];
			$booking->status = 1;
			$booking->save();
			$reservation = ReservedRoom::where('booking_id', $i['booking_id'])->get();
			if(count($reservation) > 0) {
				foreach($reservation as $r)
				{
					$r->firstname = $i['firstname'];
					$r->lastname = $i['lastname'];
					$r->address = $i['address'];
					$r->contact_number = $i['contact_no'];
					$r->status = 1;
					if($r->save())
					{

					}
				}
			}
			return $i;
		}
		
	});
	Route::get('reports', 'ReportsController@index');

	Route::get('room/create', function(){
		$cpage = 'roommgt';
		return View::make('adminview.room.create', compact('cpage'));
	});
	Route::post('room/create', 'RoomController@store');
	Route::get('room/{id}', 'RoomController@show');
	Route::post('room/{id}/availability', 'RoomController@availability_admin');
	Route::post('room/{id}/step2', 'RoomController@bookingStep2');
	Route::post('room/{id}/booked', 'RoomController@availability_admin');
	Route::get('room/{id}/update', 'RoomController@update');
	Route::post('room/{id}/addroom', 'RoomController@addroom');
	Route::get('room/{id}/validate', 'RoomController@validate');
	Route::post('room/{id}/deletespecific', 'RoomController@deletespecific');
	Route::post('room/{id}/delete', 'RoomController@delete');
	Route::post('room/{id}/updatespecific', 'RoomController@updateSpecific');
	Route::post('room/{id}/update', 'RoomController@edit');
	Route::get('account', 'UsersController@account');
	Route::post('{id}/changepassword', 'UsersController@changePassword');
	Route::post('{id}/changeaccountinformation', 'UsersController@changeAccountInformation');
});