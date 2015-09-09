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
	{	$cpage = 'home';
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

Route::post('booking/step1', function(){
	$i = Input::all();
	if(isset($i['checkin']) && isset($i['checkout'])){
			//return $i;
		Session::put('reservation.checkin', $i['checkin']);
		Session::put('reservation.checkout', $i['checkout']);
		Session::put('reservation.display_checkout', $i['display_checkout']);
		return Redirect::to('booking/step2');
	}
});

Route::get('booking/step2', function(){
	$cpage = 'booking.step2';
	if(Session::has('reservation.checkin') && Session::has('reservation.checkout')){
		$i = [];
		$i['checkin'] = Session::get('reservation.checkin');
		$i['checkout'] = Session::get('reservation.checkout');
			//return $i;
		$available_rooms = 0;
		$room = Room::with(array('roomQty.roomReserved' => function($query) use ($i){
			$query->where(function($query2) use($i){
				$query2->whereBetween('check_in', array($i['checkin'], $i['checkout']))
				->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
				->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
				->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
			})->where('status','!=',5);
		}))->get();
			//eturn $room1;
	}else{
	}
	//return $room;
	return View::make('clientview2.booking.step2', compact('cpage','room'));
});

Route::post('booking/step2/direct', function(){
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
	return Redirect::to('booking/step3');
});



Route::post('booking/step2', function(){
	$i = Input::all();
	$x = [];
	$room_reservation['reservation_room'] = [];
	$room_reservation['checkin'] = Session::get('reservation.checkin');
	$room_reservation['checkout'] = Session::get('reservation.checkout');
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
		//return Session::get('reservation');
	return Redirect::to('booking/step3');
});

Route::get('booking/step3', function(){

	$cpage = 'booking.step3';
	return View::make('clientview2.booking.step3', compact('cpage'));

});

Route::post('booking/step3', function(){
	$i = Input::all();
	Session::put('reservation.customerinformation', $i);
		//return Session::get('reservation.customerinformation')['firstname'];
	return Redirect::to('booking/step4');
});

Route::get('booking/step4', function(){
	$ci = new Carbon(Session::get('reservation')['checkin']);
	$co = new Carbon(Session::get('reservation')['display_checkout']);	
	$diff = $co->diff($ci)->days;
	Session::put('reservation.nights', $diff);
	$cpage = 'booking.step4';
	return View::make('clientview2.booking.step4', compact('cpage'));
});

Route::post('booking/payment', array(
'as' => 'payment',
'uses' => 'PaypalController@postPayment',
));
// this is after make the payment, PayPal redirect back to your site
Route::get('payment/status', array(
'as' => 'payment.status',
'uses' => 'PaypalController@getPaymentStatus',
));


Route::post('booking/step5', function()
{
	//return Session::get('reservation');
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
});

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


Route::get('testquery', function(){
	$r = ReservedRoom::whereBetween('check_in', array('2014-12-07 00:00:00', '2014-12-08 00:00:00'))
	->orWhereBetween('check_out', array('2014-12-10 00:00:00', '2014-12-08 00:00:00'))
	->orWhereRaw('"2014-12-07 00:00:00" between check_in and check_out')
	->orWhereRaw('"2014-12-10 00:00:00" between check_in and check_out')->get();
	return $r;
});
Route::get('room/{id}', function($id){
	$room = Room::where('id',$id)->with('roomQty','roomImages.photo')->first();
	$cpage = 'room';
	if(!empty($room)){
		return View::make('clientview2.room.show', compact('room', 'cpage'));
	}
});
Route::post('room/{id}/availability', function($id){
	$i = Input::all();
	$available_rooms = 0;
	$room1= [];
	//$roomDetails = Room::where('id')->first();
	$room = RoomQty::where('room_id', $id)->with(array('roomReserved' => function($query) use ($id ,$i){
		$query->where(function($query2) use($id, $i){
			$query2->whereBetween('check_in', array($i['checkin'], $i['checkout']))
			->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
			->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
			->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
		})->where('status','!=',5);
	}))->get();
	
	foreach($room as $r)
	{
//$available_rooms = $r;
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
	$reservation['display_checkout'] = $i['display_checkout'];
	$reservation['room_id'] = $id;
	if($available_rooms >= $i['quantity']){
		$reservation['status'] = 1; // means available
		return $reservation;
	}else{
		$reservation['status'] = 0; // means unavailable :(
		//return 'quantity: "'.$i['quantity'].'" available rooms:"'. $available_rooms.'"';
			return $reservation;
		}
	//$room->roomsavailable = $available_rooms;
	//$room = $room->toJson();
	//return $room1;
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
	return $room;
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
Route::get('testqueue', function()
{
	Queue::push('DoSomething');
	return 'Done';
});



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
	}
});

Route::group(array('prefix'=>'adminsite', 'before' => 'auth'), function(){

	Route::get('/', 'DashboardController@index');
	Route::get('template/pagination', function()
	{
		return View::make('template.pagination');
	});
	/*FOR PULLING DATA VIA AJAX*/
	Route::get('activity/logs', 'ActivitiesController@logs');
	Route::get('dashboard/success_booking/ajax', 'DashboardController@ajax_todayBookingSuccess');
	Route::get('dashboard/cancelled_booking/ajax', 'DashboardController@ajax_todayBookingCancelled');
	Route::get('dashboard/pending_booking/ajax', 'DashboardController@ajax_todayBookingPending');
	Route::get('dashboard/arrival/ajax', 'DashboardController@ajax_todayArrival');
	Route::get('dashboard/departure/ajax', 'DashboardController@ajax_todayDeparture');
	
	Route::get('dashboard/success_booking', 'DashboardController@todayBookingSuccess');
	Route::get('dashboard/cancelled_booking', 'DashboardController@todayBookingCancelled');
	Route::get('dashboard/pending_booking', 'DashboardController@todayBookingPending');
	Route::get('dashboard/arrival', 'DashboardController@todayArrival');
	Route::get('dashboard/departure', 'DashboardController@todayDeparture');

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
	Route::post('booking/{id}/update', 'BookingController@update');
	Route::post('currentbooking/save', function()
	{
		$i = Input::all();
		foreach($i['booking_id'] as $id)
		{
			$r = ReservedRoom::where('id', $id)->first();
			if(!empty($r)) {
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