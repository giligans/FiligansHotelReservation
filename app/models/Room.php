<?php
use Cviebrock\EloquentSluggable\SluggableInterface;
use Cviebrock\EloquentSluggable\SluggableTrait;
class Room extends \Eloquent {
	protected $fillable = [];
	protected $sluggable = [
        'build_from' => 'name',
        'save_to'    => 'slug',
    ];

	public function roomQty(){
		return $this->hasMany('RoomQty', 'room_id','id');
	}

	public function roomImages(){
		return $this->hasMany('RoomImage', 'room_id', 'id');
	}
}