<?php

class ReservedRoom extends \Eloquent {
	protected $fillable = [];
	protected $table = 'reserved_rooms';
	protected $appends = ['nights','checkindate','checkoutdate'];
	
	public function getCheckindateAttribute()
	{
		$newDate = date("F j, Y h:i:s a", strtotime($this->check_in));
		return $newDate;
	}

	public function getCheckoutdateAttribute()
	{
		$newDate = date("F j, Y h:i:s a", strtotime($this->check_out));
		return $newDate;
	}

	public function room(){
		return $this->belongsTo('RoomQty','room_id', 'id');
	}

	public function getTaxPriceAttribute()
	{

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


	public function getNightsAttribute()
	{
		$ci = $this->check_in;
		$co = $this->check_out->addMinutes(2);
		$nights = $ci->diffInDays($co);
		return $nights;
	}

	public function getPriceAttribute($value)
	{
		return round($value,2);
	}
	



	public function getCheckOutAttribute($value){
		return Carbon::parse($value);
	}
	
	public function getCheckInAttribute($value){
		return Carbon::parse($value);
	}
	
	
}