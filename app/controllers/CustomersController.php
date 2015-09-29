<?php

class CustomersController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /customers
	 *
	 * @return Response
	 */
	public function index()
	{
		$cpage = 'customers';
		return View::make('adminview.customer.index', compact('cpage'));
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /customers/create
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /customers
	 *
	 * @return Response
	 */
	public function store()
	{

		
		$i = Input::all();
		$customer = new Customer;
		$customer->membership_id = $this->generateCustomerId();
		$customer->pin = Carbon::now()->year;
		$customer->firstname = $i['firstname'];
		$customer->lastname = $i['lastname'];
		$customer->address = $i['address'];
		if(isset($i['email']))
		{
			$customer->email = $i['email'];
		}
		$customer->contact_no = $i['contact_no'];
		try {

			if($customer->save())
			{
				return Redirect::to('adminsite/customer')->with('success_create', 'true');
			}

		} catch ( Illuminate\Database\QueryException $e) {
			return Redirect::to('adminsite/customer')->with('error', $e->errorInfo[2]); 
		}
		
	}

	/**
	 * Display the specified resource.
	 * GET /customers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */



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


	public function searchCustomer($search)
	{
		$arr = []; //empty array;
		$customer = Customer::whereRaw("concat_ws(' ',firstname,lastname) LIKE '%$search%'")->orWhere('firstname', 'LIKE', "%$search%")
		->orWhere('lastname', 'LIKE', "%$search%")
		->orWhere('membership_id', 'LIKE', "%$search%")
		->select(DB::raw('*, concat(firstname," ",lastname) as fullname'))->get();
		if($customer)
		{
			return $customer;
		}
		
		return  $arr;
	}	

	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /customers/{id}/edit
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
	 * PUT /customers/{id}
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
	 * DELETE /customers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}