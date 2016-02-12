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
			}else
			{
				return 0;
			}
		}
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
			}else
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

	public function bookingList(){

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
			{
				/*query variables*/
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
					})
					->orderBy("$orderBy" , 'DESC')
					->skip($skip)->take($items)->get();
				}else
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