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
				if($r->roomReserved->count()==0){
					$available_rooms++;
				}
			}
			$room = $room->toArray();
			$room1['quantity'] = $room;
			$room1['available_rooms']=$available_rooms;
			$cpage = 'booking';
			return View::make('clientview.booking.index', compact('cpage','available_rooms','room_details'));
		}else{
			return Redirect::to('/');
		}
	}
	/**
	* Show the form for creating a new resource.
	* GET /booking/create
	*
	* @return Response
	*/
	public function searchList()
	{
		$i = Input::all();
		$query = Booking::with('reservedRoom.room.roomDetails')->whereBetween('check_in', array($i['startdate'], $i['enddate']))
		->orWhereBetween('check_out', array($i['startdate'], $i['enddate']))
		->orWhereRaw('"'.$i["startdate"].'" between check_in and check_out')
		->orWhereRaw('"'.$i["enddate"].'" between check_in and check_out')
		->where('status','!=',5)->get();
		return $query;
	}
	public function thisYearList()
	{
		$today = date("Y");
		$booking_recent = ReservedRoom::with('room.roomDetails2')->whereRaw('YEAR(check_in) = '.$today)->get();
		$room = Room::with('roomQty.roomReserved')->select('id','name')->get();
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
	public function bookingList(){
		$booking_recent = Booking::with('reservedRoom.room.roomDetails')->get();
		//$booking_recent = ReservedRoom::with('room.roomDetails')->get();
		if(!empty($booking_recent)){
			return $booking_recent;
		}else{
			return '0';
		}
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
		$booking = Booking::where('id', $id)->with('reservedRoom.room.roomDetails')->first();
		//$booking = ReservedRoom::where('id', $id)->with('room.roomDetails')->first();
		$old_status= $booking->status;
		if(!empty($booking))
		{
			$booking->status = $i['status'];
			if($i['status']==5)
			{
				$booking->cancelled_at = $today;
				$booking->paid=0;
				$booking->cancelled_remarks = $i['cancelled_remarks'];
			}else if($i['status']==1){
				$booking->paid = $i['paid'];
			}else{
				$booking->paid=0;
				$booking->cancelled_remarks = '';
				$booking->cancelled_at = '0000-00-00 00:00:00';
			}
			if($booking->save())
			{
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