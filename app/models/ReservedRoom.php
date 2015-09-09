<?php

class ReservedRoom extends \Eloquent {
	protected $fillable = [];
	protected $table='reserved_rooms';


	public function room(){
		return $this->belongsTo('RoomQty','room_id', 'id');
	}

	public function getCheckOutAttribute($value){
		return Carbon::parse($value);
	}
	
	public function getCheckInAttribute($value){
		return Carbon::parse($value);
	}
	
	
}