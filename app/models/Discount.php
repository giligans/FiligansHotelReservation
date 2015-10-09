<?php

class Discount extends \Eloquent {
	protected $fillable = [];
	protected $appends = array('type_str', 'created_at_str', 'updated_at_str', 'used_str', 'effect_str');
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

	public function subscribers()
	{
		return $this->hasMany('CustomerDiscount', 'discount_id', 'id');
	}
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
		return $this->updated_at->diffForHumans();
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