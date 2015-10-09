<?php

class CustomerDiscount extends \Eloquent {
	protected $fillable = [];
	protected $table = 'discounts_customers';
	protected $appends = ['status_str', 'status_bool', 'created_at_str', 'expiration_str'];
	public function getExpirationAttribute($value)
	{
		return Carbon::parse($value);
	}

	public function getCreatedAtStrAttribute()
	{
		return $this->created_at->format('Y-m-d');
	}
	public function getExpirationStrAttribute()
	{
		return $this->expiration->format('Y-m-d');
	}

	public function customer()
	{
		return $this->belongsTo('Customer', 'customer_id', 'membership_id');	
	}
	public function discountDetails()
	{
		return $this->belongsTo('Discount', 'discount_id', 'id');
	}
	public function getStatusStrAttribute()
	{
		return ($this->expiration->diffInDays() < 1) ? 'expired' : 'on-going';
	}
	public function getFullnameAttribute()
	{
		return $this->firstname.' '.$this->lastname;
	}
	public function showFullname()
	{
		array_push($this->appends,'fullname');
	}
	public function getStatusBoolAttribute()
	{
		return ($this->expiration->diffInDays() < 1) ? 0 : 1;
	}

	
}

