<?php

class Discount extends \Eloquent {
	protected $fillable = [];
	protected $appends = array('type_str', 'created_at_str', 'updated_at_str', 'used_str', 'effect_str');
	
	private $errors;
	public function validate($data)
	{
        // make a new validator object
		$v = Validator::make($data, $this->rules);
        // return the result
		return $v->passes();
	}

	public function calculateDiscount($price=null, $effect=null, $type=null)
	{


		if($price!=null && $effect!=null && $type!=null)
		{
			if($type=='1')
			{

				return ($price * ($effect/100));
			}else
			{
				
				return  $effect;
			}
		}
		return 0;
		
	}


	public function getCodeAttribute($value)
	{
		if($value=='' || $value==null)
		{
			return 'N/A';
		}else
		{
			return strtoupper($value);
		}
	}

	public function validateCode($code)
	{
		$discount = Parent::where('code', $code)->first();
		if($discount)
		{
			return $discount;
		}

		return false;
	}
	public function subscribers()
	{
		return $this->hasMany('CustomerDiscount', 'discount_id', 'id');
	}
	/*public function */
	public function getEffectAttribute($value)
	{
		if($this->effect_type == 1)
		{
			if($value > 100)
			{
				return 100;
			}else
			{
				return $value;
			}
		}
		return $value;
	}
	public function getEffectStrAttribute()
	{
		
		if($this->effect_type == 1)
		{
			return $this->effect.'%';
		}else
		{
			return 'P'.number_format($this->effect,2);
		}
	}


	public function getUpdatedAtStrAttribute()
	{

		return $this->updated_at;
	}

	/*public function set*/
	public function getUsedStrAttribute()
	{
		return ($this->used == '' || $this->used == null) ? 'Available' : $this->used;
	}
	public function getCreatedAtStrAttribute()
	{
		$created_at = Carbon::parse($this->created_at);
		return $created_at->diffForHumans();
	}
	public function getTypeStrAttribute()
	{
		return ($this->type == 0) ? 'Coupon' : 'Membership';
	}
}