<?php

class RoomImage extends \Eloquent {
	protected $fillable = [];
	protected $table = 'room_images';

	public function photo(){
		return $this->hasOne('Photos', 'id', 'image_id');
	}
}