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
		$preparing_today = Booking::with('reservedRoom_grp.room.roomDetails')->where(function($query1) use ($today)
		{
			$query1->where('created_at','like', "%$today%")->orWhere('check_out','like',"%$today%");
		})->where('status',4)->get();
		$occupied_today = Booking::with('reservedRoom_grp.room.roomDetails')->where(function($query1) use ($today)
		{
			$query1->where('created_at','like', "%$today%")->orWhere('check_out','like',"%$today%");
		})->where('status',2)->get();
		$arrival_today = Booking::where(function($query) use ($today)
		{
			$query->where('check_in','like', "%$today%");
		})->where('status', 1)->get();
		
		$ended_today = Booking::where(function($query) use ($today)
		{
			$query->where(function($query) use ($today)
			{
				$query->where('check_out', 'like', "%$today%")
				->where(function($query1)
				{
					$query1->where('status','!=','5')->orWhere('status','!=',4);
				});
			});
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
		$today_stats = Booking::with('reservedRoom_grp.room.roomDetails')->where('created_at','like', "%$today%")->where(function($query)
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
		//var_dump($success_bookings);
		return $success_bookings;
	}
	
	public function liveMonitoring()
	{
		return View::make('adminview.monitoring.index');
	}
	public function ajaxLiveMonitoring()
	{
		$i = array();
		$today = Date('Y-m-d');

		$i['checkin'] = Date('Y-m-d');
		$i['checkout'] = new DateTime('tomorrow');
		$i['checkout'] = $i['checkout']->format('Y-m-d').' 11:59:00';
		
		$room = Room::with(array('roomQty.roomReserved' => function($query) use ($i){
			$query->where(function($query2) use($i){
				$query2->whereBetween('check_in', array($i['checkin'], $i['checkout']))
				->orWhereBetween('check_out', array($i['checkin'], $i['checkout']))
				->orWhereRaw('"'.$i["checkin"].'" between check_in and check_out')
				->orWhereRaw('"'.$i["checkout"].'" between check_in and check_out');
			})->where(function($query3)
			{
				$query3->where('status', '!=', 5)->orWhere('status', '!=', 3);
			});
		}))->get();
		foreach($room as $i => $r)
		{
			foreach($r->roomQty as $x => $r_qty)
			{
				if(count($r_qty->roomReserved) > 0)
					if($r_qty->roomReserved[0]->isOverdue())
					{
					$room[$i]->roomQty[$x]->roomReserved[0]->status=6; //means overdue
				}
			}
		}
		return $room;
	}
	public function ajaxTodayStatistics()
	{
		$today = date('Y-m-d');
		$statistics = array();
		$bookings = Booking::where('created_at','like', "%$today%")->get();
		$bookings1 = Booking::where('updated_at', 'like', "%$today%")->get();
		$arrival_today  = Booking::with('reservedRoom_grp.room.roomDetails')->where(function($query) use ($today)
		{
			$query->where('check_in','like', "%$today%");
		})->where('status', 1)->get();
		$ended_today = Booking::where(function($query) use ($today)
		{
			$query->where(function($query) use ($today)
			{
				$query->where('check_out', 'like', "%$today%")
				->where(function($query1)
				{
					$query1->where('status','!=','5')->orWhere('status','!=',4);
				});
			});
		})->get();
		/*$statistics['success'] = Booking::with('reservedRoom_grp.room.roomDetails')->where('created_at','like', "%$today%")->where(function($query)
		{
			$query->where('status', '=', 1)->orWhere('status', '=', 2);
		})->get();*/
$statistics['departure'] = $ended_today;
$statistics['arrival'] = $arrival_today;
$statistics['success'] = $bookings->filter(function($item)
{
	return $item->isSuccess();
});
$statistics['success'] = array_flatten($statistics['success']);
$statistics['overdue'] = $ended_today->filter(function($item)
{
	return $item->isOverdue();
});
$statistics['overdue'] = array_flatten($statistics['overdue']);
$statistics['pending'] = $bookings->filter(function($item)
{
	return $item->isPending();
});
$statistics['pending'] = array_flatten($statistics['pending']);
$statistics['preparing'] = $bookings->filter(function($item)
{
	return $item->isPreparing();
});
$statistics['preparing'] = array_flatten($statistics['preparing']);
$statistics['cancelled'] = $bookings->filter(function($item)
{
	return $item->isCancelled();
});
$statistics['cancelled'] = array_flatten($statistics['cancelled']);
$statistics['occupied'] = $bookings->filter(function($item)
{
	return $item->isOccupied();
});
$statistics['occupied'] = array_flatten($statistics['occupied']);
return $statistics;
}
public function ajax_todayBookingPending()
{
	$today = date('Y-m-d');
	$today_stats = Booking::with('reservedRoom_grp.room.roomDetails')->where('created_at','like', "%$today%")->where('status','0')->get();
	$cpage = 'dashboard';
	$bookings = [];
	foreach($today_stats as $stats)
	{
		array_push($bookings, $stats);
	}
	return $bookings;
}
public function ajax_todayBookingOccupied()
{
	$today = date('Y-m-d');
	$today_stats = Booking::with('reservedRoom_grp.room.roomDetails')->where(function($query1) use ($today)
	{
		$query1->where('created_at','like', "%$today%")->orWhere('check_out','like',"%$today%");
	})->where('status',2)->get();
	$cpage = 'dashboard';
	$bookings = [];
	foreach($today_stats as $stats)
	{
		array_push($bookings, $stats);
	}
	return $bookings;
}
public function ajax_todayBookingPreparing()
{
	$today = date('Y-m-d');
	$today_stats = Booking::with('reservedRoom_grp.room.roomDetails')->where(function($query1) use ($today)
	{
		$query1->where('created_at','like', "%$today%")->orWhere('check_out','like',"%$today%");
	})->where('status',4)->get();
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
	$today_stats = Booking::with('reservedRoom_grp.room.roomDetails')->where('cancelled_at','like', "%$today%")->where('status',5)->get();
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
	$today_stats = Booking::with('reservedRoom_grp.room.roomDetails')->where(function($query) use ($today)
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
	$today_stats = Booking::with('reservedRoom_grp.room.roomDetails')->where(function($query) use ($today)
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
public function todayBookingOccupied()
{
	$cpage = 'dashboard';
	return View::make('adminview.dashboard.occupied_bookings', compact('cpage'));
}
public function todayBookingPreparing()
{
	$cpage = 'dashboard';
	return View::make('adminview.dashboard.preparing_bookings', compact('cpage'));
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