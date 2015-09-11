<?php

class RoomController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /room
	 *
	 * @return Response
	 */
	public function index()
	{
		$room = Room::with('roomQty','roomImages.photo')->get();
		//return $room;
		$cpage = 'roommgt';
		return View::make('adminview.room.indexs', compact('cpage'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /room/create
	 *
	 * @return Response
	 */
	public function availability_admin($id)
	{
		$i = Input::all();

		$available_rooms = 0;
		$room1= [];
	//$roomDetails = Room::where('id')->first();
		$room = RoomQty::where('room_id', $id)->with(array('roomReserved' => function($query) use ($id ,$i){
			$query->where(function($query2) use($i){
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
		//$reservation['display_checkout'] = $i['display_checkout'];
		$reservation['room_id'] = $id;
		if($available_rooms >= $i['quantity']){
		$reservation['status'] = 1; // means available
		return $reservation;
	}else{
		$reservation['status'] = 0; // means unavailable :(
			return $reservation;
		}

	}

	public function allRooms(){
		$room = Room::with('roomQty','roomImages.photo')->get();
		return $room;
	}
	/*VALIDATION OF ROOM NUMBER*/
	public function validate($id){
		$r = RoomQty::where('room_no',$id)->first();
		if(empty($r)){
			return '1';
		}else{
			return '0';
		}
	}
	/*THIS WILL ADD QUANTITY TO THE ROOM*/
	public function addRoom($id){
		$input = Input::all();
		foreach($input as $i){
			$r = new RoomQty;
			$r->room_id = $id;
			$r->room_no = $i['room_no'];
			$r->save();
		}	
		$room = Room::whereId($id)->first();
		$a = new Activity;
		$a->location=2;
		$a->actor = Auth::id();
		$a->logs = 'Added a room to: '.$room->name;
		$a->save();
	}
	public function deleteSpecific($id){
		$r = RoomQty::where('id', $id);
		$r->delete();

	}	
	public function bookingStep2($id)
	{

		$i = Input::all(); 
		$total_price = null;
		$tax = null;
	$count = 0; //for test
	$count1 = 0; //for test
	$booked_room = []; //all picked rooms from available rooms
	$booked_room_id = [];
	//foreach(Session::get('reservation')['reservation_room'] as $rooms){
	$count++;
	$room_id = $id;
	$available_rooms = [];
	$room_qty = RoomQty::with(array('roomPrice','roomReserved'=>function($query) use($i, $room_id){
		$query->where(function($query2) use($i, $room_id){
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
	if(!empty($available_rooms))
	{
		for($counter = 0; $counter<$i['quantity']; $counter++){
			array_push($booked_room, $available_rooms[$counter]);
		}
	}else{
			return '0'; //not available
		}
		
	//} //end of foreach
		$total_price = 0;

		$new_booking = new Booking;
		$new_booking->firstname = 'WALK-IN';
		$new_booking->lastname = 'WALK-IN';
		$new_booking->address = 'WALK-IN';
		$new_booking->contact_number = '000';
		$new_booking->check_in = $i['checkin'];
		$new_booking->check_out = $i['checkout'];
		$new_booking->email_address = 'WALK-IN';
		$new_booking->code='N/A';
		$new_booking->status = 0; 
		$new_booking->save();
		foreach($booked_room as $b)
		{
			$ci = new Carbon($i['checkin']);
			$co = new Carbon($i['checkout']);
			$total_nights = $co->diff($ci)->days;
			$total_nights+=1;
			$total_price += $total_nights * $b->roomPrice->price;
			$total_price2 = $total_nights * $b->roomPrice->price;
			$tax = $total_price2 * 0.12;
			$total_price2+=$tax;
			$reserveRoom = new ReservedRoom;
			$reserveRoom->room_id = $b->id;
			$reserveRoom->booking_id = $new_booking->id;
			$reserveRoom->check_in = $i['checkin'];
			$reserveRoom->check_out = $i['checkout'];
			$reserveRoom->code='N/A';
			/*$reserveRoom->firstname = 'WALK-IN';
			$reserveRoom->lastname = 'WALK-IN';*/
			$reserveRoom->price = $total_price2;
			/*$reserveRoom->address = 'WALK-IN';
			$reserveRoom->contact_number = '000';
			$reserveRoom->email_address = 'WALK-IN';*/
			$reserveRoom->status = '0';
			if($reserveRoom->save())
			{
				array_push($booked_room_id,	$reserveRoom->id);
			}
		}
		$new_booking->price = $total_price;
		$new_booking->save();
//	return Session::get('reservation');
	//return $booked_room;
	//return $counter;
	//return $room_qty1;
		return $booked_room_id;
	}

	public function create()
	{
		
	}
	/**
	 * Store a newly created resource in storage.
	 * POST /room
	 *
	 * @return Response
	 */

	//$images = RoomImage::where('room_id', $id)->delete();			


	public function store()
	{	/*VARIABLES
		$r = room
		$i = all inputs
		$rq = Room Quantity
		***************/
		$r = new Room;
		$i = Input::all();
		$r->name = $i['name'];
		$r->short_desc = $i['short_desc'];
		$r->full_desc = $i['full_desc'];
		$r->max_adults = $i['max_adults'];
		$r->max_children = $i['max_children'];
		$r->beds = $i['beds'];
		$r->bathrooms = $i['bathrooms'];
		$r->area = $i['area'];
		$r->price = $i['price'];
		if($r->save()){
			$a = new Activity;
			$a->location=2;
			$a->actor = Auth::id();
			$a->logs = 'Created a room: '.$r->name;
			$a->save();

			$x= $i['no_of_rooms'];
			while($x!=0){
				$x--;
				$rq = new RoomQty;
				$rq->room_id =$r->id;
				$rq->save();	
			}
			if(isset($i['images']) || (!empty($i['images']))){
				if(is_array($i['images'])){
					foreach($i['images'] as $image){
						$upload = new RoomImage;
						$upload->room_id = $r->id;
						$upload->image_id =  $image['photo']['id'];
						$upload->save();
					}
				}else{

				}
			}
			return $r;
			
		}else{
			return '0';
		}
	}
	/**
	 * Display the specified resource.
	 * GET /room/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		$cpage = 'room';
		$today = Date('Y-m-d');
		//return $today;
		$room = Room::with(array('roomQty.roomReserved' => function($query) use($today){
			$query->where(function($query2) use($today){
				$query2->whereBetween('check_in', array($today, $today))
				->orWhereBetween('check_out', array($today, $today))
				->orWhereRaw('"'.$today.'" between check_in and check_out')
				->orWhereRaw('"'.$today.'" between check_in and check_out');

			})->where('status','!=', 5);
			
		}, 'roomImages.photo'))->where('id', $id)->first();
		//return $room->roomQty;
		//return $room;
		return View::make('adminview.room.show', compact('cpage', 'room'));
	}
	/**
	 * Show the form for editing the specified resource.
	 * GET /room/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		/*VARIABLES
		$r = room
		$i = all inputs
		$rq = Room Quantity
		***************/
		$r = Room::where('id', $id)->first();
		if(!empty($r)){
			$i = Input::all();
			$r->name = $i['name'];
			$r->short_desc = $i['short_desc'];
			$r->full_desc = $i['full_desc'];
			$r->max_adults = $i['max_adults'];
			$r->max_children = $i['max_children'];
			$r->beds = $i['beds'];
			$r->bathrooms = $i['bathrooms'];
			$r->area = $i['area'];
			$r->price = $i['price'];
			if($r->save()){
				$a = new Activity;
				$a->actor = Auth::id();
				$a->location=2;
				$a->logs = 'Updated room information of room type: '.$r->name;
				$a->save();
				$images = RoomImage::where('room_id', $id)->delete();			
				if(isset($i['images']) || (!empty($i['images']))){
					if(is_array($i['images'])){
						foreach($i['images'] as $image){
							$upload = new RoomImage;
							$upload->room_id = $r->id;
							$upload->image_id = $image['photo']['id'];
							$upload->save();
						}
					}else{

					}
				}
				return $r;

			}else{
				return '0';
			}
		}
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /room/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	/* THIS WILL UPDATE A SPECIFIC ROOM*/
	public function updateSpecific($id){
		$i = Input::all();
		$r = RoomQty::where('id', $id)->first();
		if(!empty($r)){
			$r->room_no = $i['room_no'];
			if($r->save()){

				return $r;
			}else{
				return '0';//means failed
			}
		}
	}
	public function update($id)
	{
		$cpage = 'roommgt';
		$room = Room::where('id', $id)->with('roomImages.photo')->first();

		if(!empty($room)) return View::make('adminview.room.update', compact('cpage','room'));
	}
	/**
	 * Remove the specified resource from storage.
	 * DELETE /room/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$room = Room::whereId($id)->first();
		if($room->delete()){
			$a = new Activity;
			$a->location=2;
			$a->actor = Auth::id();
			$a->logs = 'Deleted room: '.$room->name;
			$a->save();
		}
		
	}

	/*
	CHECK THE ROOM AVAILABILITY
	*/
	public function availability(){

		$i = Input::all();
		if(isset($i['checkin']) && isset($i['checkout'])){
			return $i;

		//return $i;
			$available_rooms = 0;
			$room1 = Room::with(array('roomQty.roomReserved' => function($query) use ($i){
				$query->where(function($query2) use ($i){
					$query2->whereBetween('check_in', array($i['checkin'], $i['checkout']))
					->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
					->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
					->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
				})->where('status','!=',5);
			}))->get();
			return $room1;
		}
	}
		/*$room = RoomQty::with(array('roomReserved' => function($query) use ($i){
			$query->whereBetween('check_in', array($i['checkin'], $i['checkout']))
			->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
			->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
			->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
		}))->get();
		foreach($room as $r)
		{
			if(empty($r->roomReserved)){
				$available_rooms++;
			}
		}*/

		/*$i = Input::all();
		$dt = Carbon::parse($i['checkin']);
		$dt2 = Carbon::parse($i['checkout']);
		$final = $dt->diffInDays($dt2);
		$query = ReservedRoom::where(function($q) use ($i){
			$q->where('check_in', '<=', $i['checkin']);
			
		})->get();
		if($query->count() == 0){
			$nr = new ReservedRoom;
			$nr->room_id=1;
			$nr->check_in = $i['checkin'];
			$nr->check_out = $i['checkout'];
			$nr->save();
		}else{
			return $query;
		}
	
		return $final;*/

	}