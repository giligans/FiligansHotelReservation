<?php

class Activity extends \Eloquent {
	protected $fillable = [];

	public function actor()
	{
		return $this->belongsTo('User','actor', 'id');
	}
}