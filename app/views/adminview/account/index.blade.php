@extends('layout.admin2')
@section('controller')
accountController
@stop
@section('title')
My Profile
@stop
@section('accountcontent')

<style type="text/css">
	
	#accountinfo td{
		padding:5px;
	}
	#changepassword td{
		padding:5px;
	}
</style>


<div class="modal fade" id="modal-id" style='z-index:10000'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Change Password</h4>
			</div>
			<div class="modal-body">

				<div class="alert alert-danger" style='margin-top:10px;margin-botom:10px' ng-show='changepassworderror!=null'>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					[[ changepassworderror ]]
				</div>
				<table id='changepassword'>
					<tr>
						<td style='width:150px'>Current password</td>
						<td> <input type='password' class='form-control' ng-model='changepassword.password'></td>
					</tr>

					<tr>
						<td style='width:150px'>New password</td>
						<td> <input type='password' class='form-control' ng-model='changepassword.newPassword'></td>
					</tr>
					<tr>
						<td style='width:150px'>Confirm password</td>
						<td> <input type='password' class='form-control' ng-model='changepassword.confirmPassword'></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" ng-click='updatePassword()'>Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style='min-height:200px;border-right:1px solid #d8d8d8;padding-left:10px;'>
	<center>
		@if(Auth::user()->role==1)
		<img src='{{ URL::to("upload/admin.jpeg") }}' style='margin:0 auto'>
		@else
		<img src='{{ URL::to("upload/receptionist.jpeg") }}' style='margin:0 auto'>
		@endif
		<div class="clearfix">
		</div>
		<table id='accountinfo'>
			<tr>
				<td><label>Account Role:</label> </td>
				<td>
					@if(Auth::user()->role==1)
					<span class="label label-danger">ADMIN</span>
					@else
					<span class="label label-warning">RECEPTIONIST</span>
					@endif
				</td>
			</tr>
			<tr>
				<td><label>Last Updated:</label>  </td>
				<td> {{ Auth::user()->updated_at }}</td>
			</tr>
			<tr>
				<td colspan=2> <button type="button" class="btn btn-danger" ng-click='deactivateAccount()' ng-hide='countdown<10'>Deactivate account</button>
					<div class="well" style='margin-top:10px' ng-show='countdown<10'>
						Your account will be deactivated after [[ countdown ]] seconds. <button type="button" class="btn btn-xs btn-warning" ng-click='cancelDeactivate()'>cancel</button>
					</div>
				</td>

			</tr>
		</table>
	</center>
</div>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style='height:200px;padding-right:10px;' ng-cloak>
	<input type='hidden' ng-init='user={{ Auth::user() }}'>
	<form action="" method="POST" role="form">
		<legend style='padding-bottom:10px'>User Information

			
		<button type="button" class="btn btn-sm btn-warning pull-right" style='margin-left:3px' ng-click='updatemode=!updatemode' ng-init='updatemode=false' ng-hide='updatemode' style='' >Update Account</button>	
			<a data-toggle="modal" href='#modal-id' class="btn btn-info btn-sm pull-right" ng-hide='updatemode'>Update Password</a>
			<button type="button"  class="btn btn-sm btn-success pull-right" ng-show='updatemode' style='margin-left:3px;margin-bottom:3px' ng-click='updateAccountInformation()'>Update</button><button type="button" class="btn btn-sm btn-default pull-right" style='margin-right:3px;margin-bottom:3px' ng-show='updatemode' ng-click='updatemode=!updatemode'>Cancel	</button>
		</legend> 
		<div class="alert alert-success" ng-show='updatedpassword'>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Success!</strong> Your password has been successfully changed.
		</div>
		<div class="alert alert-success" ng-show='updatedaccount'>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Success!</strong> Your account information has been successfully changed.
		</div>
		<div class="form-group">
			<label for="">Firstname </label>
			<input type="text" ng-model='user.firstname' class="form-control" id="" placeholder="Enter Firstname" ng-disabled='updatemode==false'>
		</div>
		<div class="form-group">
			<label for="">Lastname </label>
			<input type="text" ng-model='user.lastname'class="form-control" id="" placeholder="Enter Lastname" ng-disabled='updatemode==false'>
		</div>
		<div class="form-group">
			<label for="">Username </label>
			<input type="text" class="form-control" ng-model='user.username' id="" placeholder="Enter Username" ng-disabled='updatemode==false'>
		</div>




	</form>
</div>
@stop
@section('scripts')
{{ HTML::script('admin/asset/js/account.js') }}
@stop			