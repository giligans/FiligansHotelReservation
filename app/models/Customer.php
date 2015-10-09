<?php

class Customer extends \Eloquent {

	protected $fillable = [];
	protected $primaryKey = 'membership_id';
	protected $appends = ['current_discount','fullname','created_at_str', 'updated_at_str'];

	public function  getCurrentDiscountAttribute()
	{
		$customer_discount = CustomerDiscount::where('customer_id', $this->membership_id)
		->join('discounts','discounts.id', '=','discounts_customers.discount_id')->get();
		if(count($customer_discount)>0)
		{
			foreach($customer_discount as $c)
			{
				$dt = Carbon::parse($c->expiration);
				if($c->expiration->diffInDays() > 0)
				{
					return $c;
				}
			}
		}
		//return $customer_discount;

	}

	public function discounts()
	{
		return $this->hasMany('CustomerDiscount', 'customer_id', 'membership_id');
	}

	public function getFullnameAttribute()
	{
		return $this->firstname.' '.$this->lastname;
	}

	public function getCreatedAtStrAttribute()
	{
		$date = Carbon::parse($this->created_at);
		$date = $date->diffForHumans();
		return $date;
	}
	public function getUpdatedAtStrAttribute()
	{
		$date = Carbon::parse($this->updated_at);
		$date = $date->diffForHumans();
		return $date;
	}
	public function generateCustomerId()
	{
		$stop = null;	
		$customer_id = null;

		do
		{
			$customer_id = rand(1111111,999999).'-'.Carbon::now()->year; //7 digit customer id
			$customer = Customer::where('membership_id', $customer_id)->first();
			if($customer && !empty($customer))
			{
				$stop = true;
				return $customer_id;
			}
		}
		while($stop=false);
		return $customer_id;

	}

}