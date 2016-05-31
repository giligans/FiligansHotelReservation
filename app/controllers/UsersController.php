<?php
class UsersController extends \BaseController {
	/**
	* Display a listing of the resource.
	* GET /users
	*
	* @return Response
	*/
	public function index()
	{
		$users = User::all();
		$cpage = 'usermgt';
		return View::make('adminview.user.index', compact('cpage', 'users'));
	}
	/**
	* Show the form for creating a new resource.
	* GET /users/create
	*
	* @return Response
	*/

	public function account(){
		$cpage = 'account';
		return View::make('adminview.account.index', compact('cpage'));
	}
	public function create()
	{
		//
	}
	/**
	* Store a newly created resource in storage.
	* POST /users
	*
	* @return Response
	*/

	public function changeAccountInformation(){
		/*ERROR
		0 - Something went wrong.
		1 - success.
		2 - Please fill up all fields.
		*/
		$i = Input::all();
		$u = User::where('id', Auth::id())->first();
		
		if(!empty($u)){
			$u->firstname = $i['firstname'];
			$u->lastname = $i['lastname'];
			$u->username = $i['username'];
			if($u->save()){
				$a = new Activity;
				$a->actor = Auth::id();
				$a->location=1;
				$a->logs = 'Updated '.$u->firstname.' '.$u->lastname.' account information.';
				$a->save();
				return $u;

			}else{
				return '0';
			}
		}else{
			return '0';
		}
		//return $i;

	}
	public function changePassword($id){
		/*ERROR
		0 - Something went wrong
		1 - success
		2 - wrong password
		3 - password mismatch
		*/
		$i = Input::all();
		if (Hash::check($i['password'], Auth::user()->password)){
			if($i['newPassword'] == $i['confirmPassword']){
				$u = User::where('id', Auth::id())->first();
				if(!empty($u)){
					$u->password = Hash::make($i['newPassword']);
					if($u->save()){
						$a = new Activity;

						$a->actor = Auth::id();
						$a->location=1;
						$a->logs = 'Updated password.';
						$a->save();

						return '1';
					}else{
						return '0';
					}
				}else{
					return '0';
				}
			}else{
				return '3';
			}
			
		}else{
			return '2';
		}
		//return $i;
	}
	public function store()
	{
		$i  = Input::all();
		$u = new User;
		$u->firstname = $i['firstname'];
		$u->lastname = $i['lastname'];
		$u->username = $i['username'];
		$u->password = Hash::make(strtolower($i['lastname']));
		$u->role = $i['role'];
		if($u->save())
		{
		
			$a = new Activity;
			$a->actor = Auth::id();
			$a->location=1;
			$a->logs = 'Created a new user: '.$u->firstname.' '.$u->lastname;
			$a->save();
			return $u;
		}else{
			return '0'; //means something went wrong.
		}
		//return $i;
	}
	/**
	* Display the specified resource.
	* GET /users/{id}
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
	* GET /users/{id}/edit
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
	* PUT /users/{id}
	*
	* @param  int  $id
	* @return Response
	*/
	public function update($id)
	{
		$u = User::where('id', $id)->first();
		if(!empty($u)){
			$i  = Input::all();
			$u->firstname = $i['firstname'];
			$u->lastname = $i['lastname'];
			$u->role = $i['role'];
			if($u->save())
			{
				$a = new Activity;
				$a->actor = Auth::id();
				$a->location=1;
				$a->logs = 'Updated '.$u->firstname.' '.$u->lastname.' account information.';
				$a->save();

				return $u;
			}else{
			return '0'; //means something went wrong.
		}
	}
	

}
	/**
	* Remove the specified resource from storage.
	* DELETE /users/{id}
	*
	* @param  int  $id
	* @return Response
	*/
	
	public function destroy($id)
	{
		$user = User::where('id',$id)->first();
		if(!empty($user)){
			$a = new Activity;
				$a->actor = Auth::id();
				$a->location=1;
				$a->logs = 'Deleted '.$user->firstname.' '.$user->lastname.' account.';
				$a->save();
			$user->delete();
		}else{
			return '0';
		}
	}
}