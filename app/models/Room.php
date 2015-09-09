<?php

class Room extends \Eloquent {
	protected $fillable = [];
	public function roomQty(){
		return $this->hasMany('RoomQty', 'room_id','id');
	}

	public function roomImages(){
		return $this->hasMany('RoomImage', 'room_id', 'id');
	}
}