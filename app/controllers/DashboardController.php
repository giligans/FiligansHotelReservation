<?php
class DashboardController extends \BaseController {
	/**
	* Display a listing of the resource.
	* GET /dashboard
	*
	* @return Response
	*/

	private $check_in =  null;
	private $check_out = null;

	public function __construct()
	{
		$dateToday = date('Y-m-d');
		$this->check_in = $dateToday.' 12:00:00';
		$this->check_out = $dateToday.' 11:59:00';
	}

	public function index()
	{
		$cpage = 'dashboard';
		$booking_recent = Booking::take(10)->get();
		$booking_recent_arr = array();
		foreach($booking_recent as $br)
		{
			array_push($booking_recent_arr, $br);
		}
		$booking_recent = array_reverse($booking_recent_arr);
		$today = date('Y-m-d');
		$check_in_time = $this->check_in;
		$check_out_time = $this->check_out;
		$yesterday = date('Y-m-d',strtotime("-1 days"));
		$today_stats = Booking::where('created_at','like', "%$today%")->get();
		$cancelled_today = Booking::where('status', 5)->where('cancelled_at', '>=', $today)->get();
		$pending_today = Booking::where('created_at','>=', $today)->where('status', 0)->get();
		$preparing_today = Booking::where('updated_at','like', "%$today%")->where('status', 4)->get();
		$occupied_today = Booking::where('updated_at','>=', "%$today%")->where('status', 2)->get();
		$arrival_today = Booking::where(function($query) use ($today)
		{
			$query->where('check_in','like', "%$today%");
		})->where('status', 1)->get();
		
		$ended_today = Booking::where('updated_at','like', "%$today%")->where(function($query) use ($today)
		{
			$query->where('status', 3)->orWhere('check_out', 'like', "%$today%" );
		})->get();
		
		$cancelled = $cancelled_today->count();
		$bookings = 0;
		$arrival = $arrival_today->count();
		$departure = $ended_today->count();
		$pending = $pending_today->count();
		$failed = 0;
		$occupied = $occupied_today->count();
		$preparing = $preparing_today->count();
		$today = 0;
		$profit_today = null;
		foreach($today_stats as $stats)
		{
			if($stats->check_out->isYesterday() && $stats->status==1){
				//$departure++;
			}
			if($stats->created_at->isToday() && ($stats->status==1 || $stats->status==2))
			{
				$bookings++;	
				$profit_today += $stats->price;
			}
		}
	//return $today_stats;
		return View::make('adminview.dashboard.index', compact('cpage','booking_recent','cancelled','bookings','pending','preparing','occupied','arrival','profit_today','departure','today_stats'));
	}

	public function ajax_todayBookingSuccess()
	{

		$today = date('Y-m-d');
		$today_stats = Booking::with('reservedRoom.room.roomDetails')->where('created_at','like', "%$today%")->where(function($query)
			{
				$query->where('status', '=', 1)->orWhere('status', '=', 2);
			})->get();
		$cpage = 'dashboard';
		$success_bookings = [];

		foreach($today_stats as $stats)
		{	
			
			array_push($success_bookings, $stats);
			
		//return 'hey';
		//
		}
		return $success_bookings;	
	}

	public function ajax_todayBookingPending()
	{
		$today = date('Y-m-d');
		$today_stats = Booking::with('reservedRoom.room.roomDetails')->where('created_at','like', "%$today%")->where('status','0')->get();
		$cpage = 'dashboard';
		$bookings = [];
		
		foreach($today_stats as $stats)
		{	
			
			array_push($bookings, $stats);
			
		}
		return $bookings;
	}

	public function ajax_todayBookingCancelled()
	{
		$today = date('Y-m-d');
		$today_stats = Booking::with('reservedRoom.room.roomDetails')->where('cancelled_at','like', "%$today%")->where('status',5)->get();
		$cpage = 'dashboard';
		$bookings = [];
		foreach($today_stats as $stats)
		{
			
			array_push($bookings, $stats);
			
		}
		return $bookings;
	}

	public function ajax_todayArrival()
	{
		$today = date('Y-m-d');
		$today_stats = Booking::with('reservedRoom.room.roomDetails')->where(function($query) use ($today)
		{
			$query->where('check_in','like', "%$today%");
		})->where('status', 1)->get();
		$cpage = 'dashboard';
		$bookings = [];
		foreach($today_stats as $stats)
		{	
			
			array_push($bookings, $stats);
			
		}
		return $bookings;
	}
	public function ajax_todayDeparture()
	{
		$today = date('Y-m-d');
		$today_stats = Booking::with('reservedRoom.room.roomDetails')->where('updated_at','like', "%$today%")->where(function($query) use ($today)
		{
			$query->where('status', 3)->orWhere(function($query) use ($today)
			{
				$query->where('check_out', 'like', "%$today%")->where(function($query1)
				{
					$query1->where('status','!=','5')->orWhere('status','!=',4);
				});
			});
		})->get();
		$cpage = 'dashboard';
		$bookings = [];
		
		foreach($today_stats as $stats)
		{	
			
			array_push($bookings, $stats);
			
		}
	//return $today;
		return $bookings;
	}



	public function todayBookingSuccess()
	{

		$today = date('Y-m-d');
	//$today_stats = ReservedRoom::where('created_at','>', $today)->get();
		$today_stats = Booking::where('created_at','>', $today)->get();
		$cpage = 'dashboard';
		return View::make('adminview.dashboard.success_bookings', compact('cpage','success_bookings'));
	}
	public function todayBookingPending()
	{
		$cpage = 'dashboard';
		return View::make('adminview.dashboard.pending_bookings', compact('cpage'));
	}
	public function todayBookingCancelled()
	{
		$cpage = 'dashboard';
		return View::make('adminview.dashboard.cancelled_bookings', compact('cpage'));
	}
	public function todayArrival()
	{
		$cpage = 'dashboard';
		return View::make('adminview.dashboard.arrival', compact('cpage'));
	}
	public function todayDeparture()
	{
		$cpage = 'dashboard';
		return View::make('adminview.dashboard.departure', compact('cpage'));
	}
	/**
	* Show the form for creating a new resource.
	* GET /dashboard/create
	*
	* @return Response
	*/
	public function create()
	{
		//
	}
	/**
	* Store a newly created resource in storage.
	* POST /dashboard
	*
	* @return Response
	*/
	public function store()
	{
		//
	}
	/**
	* Display the specified resource.
	* GET /dashboard/{id}
	*
	* @param  int  $id
	* @return Response
	*/
	public function show($id)
	{
		//
	}
	/**
	* Show the form for editing the specified resource.
	* GET /dashboard/{id}/edit
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
	* PUT /dashboard/{id}
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($id)
	{
		//
	}
	/**
	* Remove the specified resource from storage.
	* DELETE /dashboard/{id}
	*
	* @param  int  $id
	* @return Response
	*/
	public function destroy($id)
	{
		//
	}
}