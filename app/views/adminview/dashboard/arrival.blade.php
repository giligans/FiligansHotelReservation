@extends('layout.admin2')
@section('controller')
arrivalController
@stop
@section('styles')
{{ HTML::style('admin/asset/css/chart/chart.css') }}
@stop
@section('content')

<div class="modal fade" id="viewModal" style='z-index:10000'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Booking of <span ng-bind='displayBooking.firstname'></span> <span ng-bind='displayBooking.lastname'></span></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover">
					<tr>
						<td>Room Number: </td>
						<td ng-bind='displayBooking.room.room_no'></td>
					</tr>
					<tr>
						<td>Check In: </td>
						<td ng-bind='displayBooking.check_in.date'> </td>
					</tr>
					<tr>
						<td>Nights</td>
						<td ng-bind='displayBooking.nights'></td>
					</tr>
					<tr>
						<td>Room Type</td>
						<td>
								<span class="label label-primary" ng-repeat='r in displayBooking.reserved_room' ng-bind='r.room.room_details.name' style='margin:3px;'></span>
						</td>
					</tr>
					<tr>
						<td>Status</td>
						<td>
							<span class="label label-success" ng-show='displayBooking.status==1'>Paid</span>

							<span class="label label-warning" ng-show='displayBooking.status==0'>Pending</span>

							<span class="label label-danger" ng-show='displayBooking.status==5'>Cancelled</span>
						</td>
					</tr>
					<tr>
						<td>Reservation Code</td>
						<td> </td>
					</tr>
					<tr>
						<td>Address</td>
						<td ng-bind='displayBooking.address'></td>
					</tr>
					<tr>
						<td>Email Address</td>
						<td ng-bind='displayBooking.email_address'></td>
					</tr>
					<tr>
						<td>Contact No. </td>
						<td ng-bind='displayBooking.contact_number'> </td>
					</tr>
					<tr>
						<td>Created At</td>
						<td ng-bind='displayBooking.created_at'></td>
					</tr>
					<tr>
						<td>Last Updated</td>
						<td ng-bind='displayBooking.updated_at'></td>
					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary">Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="updateModal" style='z-index:10000'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Booking of <span ng-bind='displayBooking.firstname'></span> <span ng-bind='displayBooking.lastname'></span></h4>
			</div>
			<div class="modal-body">
				Status:
				<select name="" id="input" class="form-control" required="required" ng-model='editBooking.status'>
					<option value="0">Pending</option>
					<option value="1">Paid</option>
					<option value="5">Cancelled</option>
				</select>
			<div class="clearfix" style='margin:10px;'>
			</div>
			<div ng-show='editBooking.status==5'>
			Remarks: <textarea class='form-control'ng-model='editBooking.cancelled_remarks' ></textarea>
			</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" ng-click='saveChanges()' ng-disabled='updateBooking.status==5 && editBooking.cancelled_remarks==null || editBooking.cancelled_remarks==""'>Save changes</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="page-header" style='margin-top:-20px'>
	<h2 style='font-family:Open Sans;'>Arrival for today</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">Dashboard</a>
	</li>
	<li class="active">Arrival</li>
</ol>
<div class="row">
	<center ng-hide='hideloading'>
		<label>Loading list. Please wait...</label>
		<div class="clearfix">
		</div>
		<img src='{{ URL::to("images/loader.gif") }}'>
	</center>
	<div class="well" ng-show='booking.length==0 && hideloading' ng-cloak>
		No data to display
	</div>
	<table ng-show='hideloading && booking.length>0' class='table table-bordered table-hover' ng-cloak>
		<thead>
			<tr>
				<th>#</th>
				<th>Customer Name</th>
				<th style='width:100px'>Reservation Code</th>
				<th>Check In</th>
				<th>Nights</th>
				<th>Status</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat='b in booking'>
				<td ng-bind='$index+1'></td>
				<td>
					<span ng-bind='b.firstname'></span>
					<span ng-bind='b.lastname'></span>
				</td>
				<td>H23SD</td>
				<td ng-bind='b.check_in.date'></td>
				<td ng-bind='b.nights'></td>
				<td>
					
					<span class="label label-success" ng-show='b.status==1'>Paid</span>
					
					<span class="label label-warning" ng-show='b.status==0'>Pending</span>
					
					<span class="label label-danger" ng-show='b.status==5'>Cancelled</span>
					
				</td>
				<td><div class="btn-group">
					<button type="button" class="btn btn-xs btn-warning" ng-click='updateBooking(b)'>Update</button>
					<button type="button" class="btn btn-xs btn-primary" ng-click='viewBooking(b)'>View</button>
					
				</div></td>
			</tr>
		</tbody>
	</table>
</div>
@stop
@section('scripts')
{{ HTML::script('admin/asset/js/chart/chart.min.js') }}
{{ HTML::script('admin/asset/js/chart/angular-chart.js') }}
{{ HTML::script('admin/asset/js/dashboard.js') }}
@stop