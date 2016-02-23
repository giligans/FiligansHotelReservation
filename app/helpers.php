<?php

function somethingOrOther()
{
    return (mt_rand(1,2) == 1) ? 'something' : 'other';
}

function computeDiscount($price=null, $discount=null, $discount2=0)
{
if($price != null || $discount !=null)
{
	$price = (int) $price;
	$discount = (int) $discount;

	return $price - $discount - $discount2;
}
return false;

}
?>
