<?php

class DiscountsController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /discounts
	 *
	 * @return Response
	 */
	public function index()
	{
		$cpage = 'discount';
		$membership = Discount::where('type',1)->get();

		return View::make('adminview.discount.index', compact('cpage', 'membership'));
	}

	public function makeDiscountType()
	{
		$cpage ='discounts';
		$i = Input::all();
		$discount = new Discount;
		$discount->name = $i['name'];
		$discount->type = $i['type'];
		$discount->description = $i['description'];
		if(isset($i['type'])==1)
		{
			$discount->code = strtolower($i['code']);
		}else
		{
			$discount->code = null;
		}
		$discount->save();
	}


	public function makeCustomerDiscount()
	{
		$i = Input::all();
		$exp_date = null;
		if($i['expiration'] < 1)
		{
			$i['expiration'] = $i['expiration']*10;
			$exp_date = Carbon::now()->addMonths($i['expiration']);
		}else
		{
			$exp_date = Carbon::now()->addYears($i['expiration']);
		}
		

		$customer_discount = new CustomerDiscount;
		$customer_discount->discount_id = $i['type'];
		if(!isset($i['customer_id']) || $i['customer_id']=='')
		{
			return Redirect::to('adminsite/discount')->with('error', 'Failed to set discount to a customer as you haven\'t specified a customer name');
		}
		$customer_discount->customer_id = $i['customer_id'];
		$customer_discount->expiration = $exp_date;
		try {

			if($customer_discount->save())
			{
				return Redirect::to('adminsite/discount')->with('success', 'You have successfuly set a customer discount.');
			}

		} catch ( Illuminate\Database\QueryException $e) {
			return Redirect::to('adminsite/discount')->with('error', $e->errorInfo[2]); 
		}

		//$customer_discount->discount_id
	}
	/**
	 * Show the form for creating a new resource.
	 * GET /discounts/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /discounts
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 * GET /discounts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /discounts/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /discounts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /discounts/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}