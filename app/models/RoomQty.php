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

	

	public function getRoomNoAttribute($value)
	{
		if(strlen($value)===0)
		{
			return '000';
		}
		if(strlen($value) === 1)
		{
			return '00'.$value;
		}else if(strlen($value)==2)
		{
			return '0'.$value;
		}else
		{
			return $value;
		}
	}
}