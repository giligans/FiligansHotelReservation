<?php

class Booking extends \Eloquent {
	protected $fillable = [];
	protected $appends = ['datecreated','checkindate'];

	public function getDatecreatedAttribute()
	{
		$newDate = date("F j, Y", strtotime($this->created_at));
		return $newDate;
	}

	public function getCheckindateAttribute()
	{
		$newDate = date("F j, Y", strtotime($this->created_at));
		return $newDate;
	}

	public function reservedRoom()
	{
		return $this->hasMany('ReservedRoom','booking_id','id');
	}

	public function getCheckOutAttribute($value){
		return Carbon::parse($value);
	}

	public function getCheckInAttribute($value){
		return Carbon::parse($value);
	}
	
}