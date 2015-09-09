@extends('layout.admin2')
@section('controller')
userController
@stop
@section('content')
<!-- INITIALIZE USER DATA TO DISPLAY IN THE TABLE -->
<input type='hidden' ng-init='users={{ $users }}'>
<!-- MODAL FOR CREATING NEW USER -->
<div class="modal fade" id="modal-id" style='z-index:10000'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Create new user</h4>
			</div>
			<div class="modal-body">
				<table>
					<tr><td style='width:75px'>
						Name
					</td>
					<td style='padding:5px;'><input type='text' placeholder='Firstname' ng-model='user.firstname' class='form-control'></td><td><input type='text' placeholder='Lastname' ng-model='user.lastname' class='form-control'></td></tr>
					<tr><td>
						Username
					</td>
					<td style='padding:5px' colspan="2">
						<input type='text' class='form-control' placeholder='Username' ng-model='user.username'>
					</td></tr>
					<tr>
						<td>Role</td>
						<td colspan="2" style='padding:5px'>
							<select name="" id="input" class="form-control" required="required" ng-model='user.role' ng-init='user.role = 0'>
								<option value="0">Select Role</option>
								<option value='1'>Admin</option>
								<option value='2'>Receptionist</option>
							</select>
						</td>
					</tr>
				</table>
				<div class="well" style='margin-top:10px;'>
					<div class="alert alert-warning">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>NOTE:</strong> The password will be set to user's lastname by default. The user can change it by logging in the account.
					</div>
					<span class="label label-danger">Admin</span> - Have full access to the backend including Dashboard, Room Management, User Management, Booking List, and Reports.<br>
					<br>
					<span class="label label-warning">Receptionist</span> - Have a limited access to the backend. Can only access the Dashboard, Booking List, and the reports.
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" ng-click='closeModal()'>Close</button>
				<button type="button" class="btn btn-primary" ng-click='createUser()'>Create user</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- MODAL FOR UPDATE -->
<div class="modal fade" id="updateUser" style='z-index:10000'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Create new user</h4>
			</div>
			<div class="modal-body">
				<table>
					<tr><td style='width:75px'>
						Name
					</td>
					<td style='padding:5px;'><input type='text' placeholder='Firstname' ng-model='updateuser.firstname' class='form-control'></td><td><input type='text' placeholder='Lastname' ng-model='updateuser.lastname' class='form-control'></td></tr>
					<tr>
						<td>Role</td>
						<td colspan="2" style='padding:5px'>
							<select name="" id="input" class="form-control" required="required" ng-model='updateuser.role' ng-init='updateuser.role = 0'>
								<option value="0">Select Role</option>
								<option value='1'>Admin</option>
								<option value='2'>Receptionist</option>
							</select>
						</td>
					</tr>
				</table>
				<div class="well" style='margin-top:10px;'>
					<span class="label label-danger">Admin</span> - Have full access to the backend including Dashboard, Room Management, User Management, Booking List, and Reports.<br>
					<br>
					<span class="label label-warning">Receptionist</span> - Have a limited access to the backend. Can only access the Dashboard, Booking List, and the reports.
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" ng-click='closeModal()'>Close</button>
				<button type="button" class="btn btn-primary" ng-click='triggerUpdateUser(updateuser.index)'>Update User</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="page-header" style='margin-top:-20px'>
	<h2 style='font-family:Open Sans;'>User Mangement
		<button type="button" class="btn btn-success pull-right" data-toggle="modal" href='#modal-id'>Create new user</button>
	</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">User Mangement</a>
	</li>
	<li class="active">Index</li>
</ol>
<div class="row" ng-cloak>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="well well-sm" ng-show='users.length==0'>
			No users data to display
		</div>
		<div class="alert alert-success" ng-show='successCreate'>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Success!</strong> You have successfully created a new user.
		</div>
		<div class="alert alert-success" ng-show='deletedrow'>
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			<strong>Success!</strong> You have successfully deleted the user.
		</div>

		<table class="table table-hover table-striped">
			<thead>
				<tr>

					<th>ID No</th>
					<th>Firstname</th>
					<th>Lastname</th>
					<th style='width:20px'>Role</th>
					<th>created at</th>
					<th>last updated</th>
					<th>Last login</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat='u in users'>

					<td ng-bind='u.id'></td>
					<td ng-bind='u.firstname'></td>
					<td ng-bind='u.lastname'></td>
					<td>
						<span class="label label-danger" ng-show='u.role==1'>ADMIN</span>
						<span class="label label-warning" ng-show='u.role==2'>RECEPTIONIST</span>
					</td>
					<td ng-bind='u.created_at'></td>
					<td ng-bind='u.updated_at'></td>
					<td> [[ (u.last_login == null ) ? "No Login" : u.last_login ]]</td>
					<td><button type="button" class="btn btn-xs btn-warning" ng-click='updateUser(u, $index)'>Update</button>
						<button type="button" class="btn btn-xs btn-danger" ng-disabled='u.role==1' ng-click='deleteuser(u, $index)'>Delete</button>
					</td>

				</tr>
			</tbody>
		</table>

	</div>
</div>
@stop
@section('scripts')
{{ HTML::script('admin/asset/js/user.js') }}
@stop