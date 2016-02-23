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


	public function ajaxCustomers()
	{
		$cpage = 'customers';
		$i = Input::all();
		$arr = [];
		$arr = getallheaders();
		$count = Customer::all()->count();
		
		if(isset($arr['Range']))
		{
			$response_array = array();
			$response_array['Accept-Ranges'] = 'items';
			$response_array['Range-Unit'] = 'items';
			$response_array['Content-Ranges'] = 'items '.$arr['Range'].'/'.$count;
			$arr = explode('-', $arr['Range']);
			$items = $arr[1] - $arr[0]+1;
			$skip = $arr[0];
			$skip = ($skip < 0) ? 0 : $skip;
			$c = null;
			if(isset($_GET['query']) && $_GET['query'] != '')
			{
				$query = $_GET['query'];
				$c = Customer::where('membership_id', 'LIKE', "%$query%")
				->orWhereRaw("concat_ws(' ',firstname,lastname) LIKE '%$query%'")
				->orWhere('firstname', 'LIKE', "%$query")
				->orWhere('lastname', 'LIKE', "%$query%")->skip($skip)->take($items)->get();
			}else
			{
				$c = Customer::skip($skip)->take($items)->get();
			}
			
			$response = Response::make($c, 200);
			$response->header('Content-Range',$response_array['Content-Ranges'])
			->header('Accept-Ranges', 'items')->header('Range-Unit', 'items')->header('Total-Items', $count)
			->header('Flash-Message','Now showing pages '.$arr[0].'-'.$arr[1].' out of '.$count);
			return $response;
		}
		
		$c = Customer::all();
		$response = Response::make($c, 200);

		$response->header('Content-Ranges', 'test');
		return $response;

	/*	$c = Customer::all();
	return $c;*/
}
	public function checkMembership($membership_id)
	{
		$membership = new Customer;
		$output = array();
		if($membership = $membership->validateMembership($membership_id))
		{
			
				$output['code'] = 1;
				$output['content'] = 'Membership is available';
				$output['membership'] = $membership->toArray();
			return json_encode($output);
		}

		$output['code'] = '0';
		$output['content'] = 'This membership isn\'t available';
		return json_encode($output);
	}
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
		$cpage = 'customer';
		$customer = Customer::with('discounts.discountDetails')->where('membership_id', $id)->first();
		if($customer)
		{
			return View::make('adminview.customer.show', compact('cpage','customer'));
		}
		
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
	public function update()
	{
		$i = Input::all();
		$customer = Customer::where('membership_id', $i['membership_id'])->first();
		if($customer)
		{
			$customer->firstname = $i['firstname'];
			$customer->lastname = $i['lastname'];
			$customer->address = $i['address'];
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
		

		
		
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /customers/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)
	{
		$c = Customer::where('membership_id', $id)->first();
	
		if($c)
		{
			$c->delete();
		}
	}

}