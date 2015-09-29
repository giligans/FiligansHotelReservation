<?php

class CustomerDiscount extends \Eloquent {
	protected $fillable = [];
	protected $table = 'discounts_customers';
	protected $appends = ['status_str', 'status_bool'];
	public function getExpirationAttribute($value)
	{
		return Carbon::parse($value);
	}

	public function getStatusStrAttribute()
	{
		return ($this->expiration->diffInDays() < 1) ? 'expired' : 'on-going';
	}
	public function getStatusBoolAttribute()
	{
		return ($this->expiration->diffInDays() < 1) ? 0 : 1;
	}

	
}

