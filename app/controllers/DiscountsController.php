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

	public function checkCode($code)
	{
		

		$discount = new Discount;

		$output = array();
		//return $discount->validateCode($code);
		if($discount->validateCode($code))
		{


			if($discount->validateCode($code)->used==null)
			{
				//return $discount->validateCode($code);
				$output['code'] = 1;
			//$output['display'] = 'This code is avail'
				$output['content'] = 'This code is available';
				$output['discount'] = $discount->validateCode($code)->toArray();
				//return $discount;
			}else
			{
				//return $discount->validateCode($code);
				$output['code'] = 5;
			//$output['display'] = 'This code is avail'
				$output['content'] = 'This code isn\'t available';
				$output['discount'] = $discount->validateCode($code);
			}

			return json_encode($output);
		}

		$output['	code'] = '0';
		$output['content'] = 'This code isn\'t available';
		return json_encode($output);
	}
	public function makeDiscountType()
	{
		$cpage ='discounts';
		$i = Input::all();
		$validator = Validator::make($i,
			array(
				'name' => 'min:3|required',
				'description' => 'min:5|required',
				//'code' => 'alpha_num|min:6|unique:discounts'
				));
		$error_output=null;

		//$discount = Discount::where('id', $i['discount_id'])->first();
		
		if($validator->fails())
		{
			$error_array = $validator->messages()->toArray();

			foreach($error_array as $errors)
			{
				$error_output.=' '.$errors[0];
			}
			return Redirect::to('adminsite/discount')->with('error',$error_output);
		}

		if(isset($i['type']) && $i['type'] == 0)
		{
			$codes = explode(';', $i['code']);
			try {
				foreach($codes as $code)
				{
					$discount = new Discount;
					$discount->name = $i['name'];
					$discount->type = $i['type'];
					$discount->effect_type = $i['effect_type'];
					$discount->effect = $i['effect'];
					$discount->description = $i['description'];
					$discount->code = $code;
					$discount->save();
				}
			}
			
			catch ( Illuminate\Database\QueryException $e) {
				return Redirect::to('adminsite/discount')->with('error', $e->errorInfo[2]);
			}
			return Redirect::to('adminsite/discount')->with('success', 'You have successfuly set a customer discount.');
		}else
		{
			$discount = new Discount;
			$discount->name = $i['name'];
			$discount->type = $i['type'];
			$discount->effect_type = $i['effect_type'];
			$discount->effect = $i['effect'];
			$discount->description = $i['description'];
			$discount->code = null;
			try {
				if($discount->save())
				{
					return Redirect::to('adminsite/discount')->with('success', 'You have successfuly set a customer discount.');
				}
			} catch ( Illuminate\Database\QueryException $e) {
				return Redirect::to('adminsite/discount')->with('error', $e->errorInfo[2]);
			}
		}
		
	}
	public function deleteDiscount($id)
	{
		$d = Discount::where('id', $id)->first();
		if($d)
		{
			$d->delete();
		}
	}
	public function ajaxDiscounts()
	{
		$i = Input::all();
		$arr = [];
		$arr = getallheaders();
		$count = null;
		
		if(isset($arr['Range']))
		{
			$response_array = array();
			$range = $arr['Range'];
			$response_array['Accept-Ranges'] = 'items';
			$response_array['Range-Unit'] = 'items';
			
			$arr = explode('-', $arr['Range']);
			$items = $arr[1] - $arr[0]+1;
			$skip = $arr[0];
			$skip = ($skip < 0) ? 0 : $skip;
			$c = null;
			if(isset($_GET['query']))
			{
				$query = $_GET['query'];
				if($_GET['orderBy'] != '')
				{
					$orderBy = $_GET['orderBy'];
					$count = Discount::where('name', 'LIKE', "%$query%")
					->orWhere('code', 'LIKE', "%$query%")
					->get()->count();
					$c=Discount::where('name', 'LIKE', "%$query%")
					->orWhere('code', 'LIKE', "%$query%")->orderBy("$orderBy", 'DESC')->skip($skip)->take($items)->get();
				}else
				{
					$count = Discount::where('name', 'LIKE', "%$query%")
					->orWhere('code', 'LIKE', "%$query%")
					->get()->count();
					$c=Discount::where('name', 'LIKE', "%$query%")
					->orWhere('code', 'LIKE', "%$query%")->skip($skip)->take($items)->get();
				}
			}else
			{
				$count = Discount::all()->count();
				$c = Discount::skip($skip)->take($items)->get();
			}
			
			$response = Response::make($c, 200);
			$response_array['Content-Ranges'] = 'items '.$range.'/'.$count;
			$response->header('Content-Range',$response_array['Content-Ranges'])
			->header('Accept-Ranges', 'items')->header('Range-Unit', 'items')->header('Total-Items', $count)
			->header('Flash-Message','Now showing pages '.$arr[0].'-'.$arr[1].' out of '.$count);
			return $response;
		}
		$c = Customer::all();
		$response = Response::make($c, 200);
		$response->header('Content-Ranges', 'test');
		return $response;
	}
	public function updateDiscount()
	{
		$i = Input::all();
		if(isset($i['code']))
		{
			$code = strtolower($i['code']);
			if($code == 'n/a' || $code =='')
			{
				$i['code'] = '';
			}
		}
		

		$rules = array(
			'name' => 'min:3|required',
			'description' => 'min:5|required',
			'code' => 'sometimes|alpha_num|min:6|unique:discounts,code,'.$i['discount_id']
			);
		$validator = Validator::make($i,
			$rules);
		//return $rules;
		$error_output=null;

		$discount = Discount::where('id', $i['discount_id'])->first();
		
		if($validator->fails())
		{
			$error_array = $validator->messages()->toArray();

			foreach($error_array as $errors)
			{
				$error_output.=' '.$errors[0];
			}
			return Redirect::to('adminsite/discount')->with('error',$error_output);
		}
		if($discount)
		{
			$discount->name = $i['name'];
			$discount->type = $i['type'];
			$discount->effect_type = $i['effect_type'];
			$discount->effect = $i['effect'];
			$discount->description = $i['description'];
			$discount->code = $i['code'];
			try {
				if($discount->save())
				{
					return Redirect::to('adminsite/discount')->with('success', 'You have successfuly updated customer discount.');
				}
			} catch ( Illuminate\Database\QueryException $e) {
				return Redirect::to('adminsite/discount')->with('error', $e->errorInfo[2]);
			}
		}
		
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
		$cpage = 'discount';
		$d = Discount::where('id', $id)->first();
		if($d)
		{
			return View::make('adminview.discount.show', compact('cpage','d'));
		}
	}
	public function ajaxCustomerDiscounts($id)
	{
		$cpage = 'customers';
		$i = Input::all();
		$arr = [];
		$arr = getallheaders();
		$count = null;
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
				$count = $c =CustomerDiscount::join('customers', 'customers.membership_id', '=','discounts_customers.customer_id')
				->where(function($customer) use ($query) {
					$customer->where('customers.membership_id', 'LIKE', "%$query%")
					->orWhereRaw("concat_ws(' ',customers.firstname,customers.lastname) LIKE '%$query%'")
					->orWhere('customers.firstname', 'LIKE', "%$query")
					->orWhere('customers.lastname', 'LIKE', "%$query%");
				})
				->where('discount_id', $id)
				->get()->count();
				$c =CustomerDiscount::join('customers', 'customers.membership_id', '=','discounts_customers.customer_id')
				->where(function($customer) use ($query){
					$customer->where('customers.membership_id', 'LIKE', "%$query%")
					->orWhereRaw("concat_ws(' ',customers.firstname,customers.lastname) LIKE '%$query%'")
					->orWhere('customers.firstname', 'LIKE', "%$query")
					->orWhere('customers.lastname', 'LIKE', "%$query%");
				})
				->where('discount_id', $id)
				->skip($skip)->take($items)->get();
			}else
			{
				$count = CustomerDiscount::where('discount_id', $id)->get()->count();
				$c = CustomerDiscount::where('discount_id', $id)->join('customers', 'customers.membership_id', '=','discounts_customers.customer_id')->skip($skip)->take($items)->get();
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
	public function deleteCustomerDiscounts($id)
	{
		$cd = CustomerDiscount::where('id', $id)->first();
		if($cd)
		{
			$cd->delete();
			return 'success';
		}
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