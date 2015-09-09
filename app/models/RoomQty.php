<?php

class RoomQty extends \Eloquent {
	protected $fillable = [];
	protected $table = 'room_qty';

	public function roomDetails(){
		return $this->belongsTo('Room', 'room_id', 'id');
	}
	public function roomDetails2(){
		return $this->belongsTo('Room', 'room_id', 'id')->select('id','name','price','created_at','short_desc','max_adults','max_children','beds','bathrooms','area','updated_at');
	}

	public function roomPrice()
	{
		return $this->belongsto('Room', 'room_id', 'id')->select('id','price');
	}

	public function roomReserved(){
		return $this->hasMany('ReservedRoom', 'room_id','id');
	}
}