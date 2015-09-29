<?php

class Booking extends \Eloquent {
	protected $fillable = [];
	protected $appends = ['datecreated','checkindate','checkoutdate', 'nights','change'];



	
	public function getChangeAttribute()
	{
		return 0;
	}
	public function getDatecreatedAttribute()
	{
		$newDate = date("F j, Y", strtotime($this->created_at));
		return $newDate;
	}

	public function getNightsAttribute()
	{
		$ci = $this->check_in;
		$co = $this->check_out->addMinutes(2);
		$nights = $ci->diffInDays($co);
		return $nights;
	}

	public function isSuccess()
	{
		return $this->status == 2 || $this->status == 1;
	}

	public function isPending()
	{
		return $this->status==5;
	}

	public function isPreparing()
	{
		return $this->status==4;
	}
	public function isCancelled()
	{
		return $this->status==5;
	}
	public function isOccupied()
	{
		return $this->status==2;
	}
	public function isOverdue()
	{
		$today = Carbon::now();
		
			if($today->gt($this->check_out))
			{
				return true;
			}
		
		return false;
	}



	public function getCheckindateAttribute()
	{
		$newDate = date("F j, Y", strtotime($this->check_in));
		return $newDate;
	}

	public function getCheckoutdateAttribute()
	{
		$newDate = date("F j, Y", strtotime($this->check_out));
		return $newDate;
	}

	public function reservedRoom()
	{
		return $this->hasMany('ReservedRoom','booking_id','id');
	}

	public function reservedRoom_grp()
	{
		return $this->hasMany('ReservedRoom','booking_id','id')->select(DB::raw('*, sum(price) as price, count(*) as quantity'))->groupBy('room_type')->groupBy('booking_id');
	}

	public function getCheckOutAttribute($value){
		return Carbon::parse($value);
	}

	public function getCheckInAttribute($value){
		return Carbon::parse($value);
	}
	
}