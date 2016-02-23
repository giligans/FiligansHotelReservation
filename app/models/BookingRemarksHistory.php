<?php

class BookingRemarksHistory extends \Eloquent {
	protected $fillable = [];
	protected $table = 'booking_remarks_history';
	protected $appends = ['datecreated'];

	public function getDatecreatedAttribute()
	{
		$newDate = date("F j, Y", strtotime($this->created_at));
		return $newDate;
	}
}