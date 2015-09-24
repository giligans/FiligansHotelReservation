<?php

class ReservedRoom extends \Eloquent {
	protected $fillable = [];
	protected $table = 'reserved_rooms';
	protected $appends = ['nights'];
	
	public function room(){
		return $this->belongsTo('RoomQty','room_id', 'id');
	}

	public function getTaxPriceAttribute()
	{

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