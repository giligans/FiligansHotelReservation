@extends('layout.admin2')
@section('styles')
<style type="text/css">
	.upperfirst::first-letter {
		text-transform: uppercase;
	}
</style>
@stop
@section('controller')
bookingController
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
						<td ng-bind='displayBooking.checkindate'> </td>
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
					<tr ng-show='displayBooking.status==5'>
						<td>Cancelled at:</td>
						<td ng-bind='displayBooking.cancelled_at'>  </td>
					</tr>
					<tr ng-show='displayBooking.status==5'>
						<td>Cancelled Remarks</td>
						<td ng-bind='displayBooking.cancelled_remarks'> </td>
					</tr>
					<tr>
						<td>Price</td>
						<td ng-bind='displayBooking.price | currency: "P"'></td>
					</tr>

					<tr>
						<td>Paid</td>
						<td ng-bind='displayBooking.paid | currency: "P"'></td>
					</tr>
					<tr>
						<td>Reservation Code</td>
						<td ng-bind='displayBooking.code'> </td>
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
						<td ng-bind='displayBooking.datecreated'></td>
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
<div class="modal fade" id="updateBooking" style='z-index:10000' ng-cloak>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Update booking</h4>
			</div>
			<div class="modal-body">
				Status: <select name="" id="input" class="form-control" required="required" ng-model='updateBooking.status'>
				<option value="0">Pending</option>
				<option value="1">Paid</option>
				<option value="5">Cancelled</option>
			</select>
			<div class="clearfix" style='margin:10px;'>
			</div>
			<div ng-show='updateBooking.status==5'>
				Remarks: <textarea class='form-control'ng-model='updateBooking.cancelled_remarks' ></textarea>
			</div>
			<div ng-show='updateBooking.status==1'>
				<table class="table">
					<tr>
						<td>
							Subtotal
						</td>
						<td>
							<label ng-bind='updateBooking.price -(updateBooking.price * 0.12) | currency: "P "'>100</label>
						</td>
					</tr>
					<tr>
						<td>
							Total	
						</td>
						<td>
							<label ng-bind='updateBooking.price | currency:"P "'>100</label>
						</td>
					</tr>
					<tr>
						<td>Customer Paid: </td>
						<td>
							<input type='text' class='form-control' ng-model='updateBooking.paid' valid-number>
						</td>
					</tr>
					<tr>
						<td>
							Change: 
						</td>
						<td>
							<label ng-bind='(updateBooking.paid - updateBooking.price) | currency : "P "'></label>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="button" class="btn btn-primary" ng-click='saveChanges()' ng-disabled='(updateBooking.status==5 && (updateBooking.cancelled_remarks==null || updateBooking.cancelled_remarks=="")) || (updateBooking.status==1 && paid==false)'>Save changes</button>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="page-header" style='margin-top:-20px'>
	<div class="modal fade" id="newBooking" style='z-index:10000'>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">New Booking</h4>
				</div>
				<div class="modal-body">
					<center ng-show='loading'>
						<label>Loading list. Please wait...</label>
						<div class="clearfix">
						</div>
						<img src='{{ URL::to("images/loader.gif") }}'>
					</center>
					<div class="well" ng-show='displayform==true && available==1 && displayform2==false &&loading==false'>
						<center>
							The room is available!  <button type="button" class="btn btn-xs btn-block btn-primary" style='margin-top:10px' ng-click='proceedStep2()'>Proceed</button>
						</center>
					</div>
					<div class="well" ng-show='displayform==true && available==0 && displayform2==false'>
						<center>
							This room is unavailable.
						</center>
					</div>
					<table class="table table-hover" ng-hide='loading || displayform==false'>
						<tr style='border-top:0px'>
							<td>
								Room Type
							</td>
							<td>

								<select name="" id="input" class="form-control" required="required" ng-model='availability.room_id'>
									<option value='0'> Select a room</option>
									@foreach($r as $room)
									<option value='{{ $room->id }}'> {{ $room->name }}</option>
									@endforeach
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Check in
							</td>
							<td>
								<input type='text' class='form-control checkin' ng-model='availability.checkin'>
							</td>
						</tr>
						<tr>
							<td>
								nights
							</td>
							<td>
								<input type='text' class='form-control' ng-model='nights' valid-number>
							</td>
						</tr>
						<tr>
							<td>	
								no of rooms
							</td>
							<td>
								<input type='text' class='form-control' ng-model='quantity' valid-number>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								<button type="button" class="btn btn-large btn-block btn-danger" ng-click='checkAvailability()'>Check availability</button>
							</td>
						</tr>
					</table>
					<div class="alert alert-success" ng-show='displayform2'>
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong>Success</strong> Fill up customer information
					</div>
					<table class="table  table-hover" ng-show='displayform2'>
						<tr>
							<td>Firstname</td>
							<td>
								<input type='text' class='form-control' ng-model='customer.firstname'>
							</td>
						</tr>
						<tr>
							<td>Last name</td>
							<td>
								<input type='text' class='form-control' ng-model='customer.lastname'>
							</td>
						</tr>
						<tr>
							<td>Address</td>
							<td>
								<input type='text' class='form-control' ng-model='customer.address'>
							</td>
						</tr>
						<tr>
							<td>Contact no</td>
							<td>
								<input type='text' class='form-control' ng-model='customer.contact_no' valid-number>
							</td>
						</tr>
						<tr>
							<td></td>
							<td><button type="button" class="btn btn-large btn-block btn-primary" ng-click="saveCustomerInformation()">Update Customer Information</button></td>
						</tr>
					</table>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<h2 style='font-family:Open Sans;'>Booking List <button type="button" class="btn btn-success pull-right" ng-click='newBookingModal()'>Create new booking</button></h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">Booking List</a>
	</li>
	<li class="active">Index</li>
</ol>
<center ng-hide='hideloading'>
	<label>Loading list. Please wait...</label>
	<div class="clearfix">
	</div>
	<img src='{{ URL::to("images/loader.gif") }}'>
</center>
<div class="alert alert-success" ng-show='success' ng-cloak>
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<strong>Success</strong> Booking of <label>[[ updateBooking.firstname+' '+updateBooking.lastname ]]</label> has been updated.
</div>
<table class="table table-hover"  ng-cloak style='margin:0px' ng-cloak ng-show='hideloading'>
	<tr>
		<td>
			<input type='text' class='form-control searchDate' placeholder='Start Date' ng-model='advs.startDate'>
		</td>
		<td>
			<input type='text' class='form-control searchDate' placeholder='End Date' ng-model='advs.endDate'>
		</td>
		<td>
			<button type="button" class="btn btn-primary" ng-click='advanceSearch()'>Search</button>
		</td>
	</tr>
</table>
<div class="checkbox" style='padding:5px;margin:5px' ng-cloak ng-show='hideloading'>
	<label>	
		<input type="checkbox" value="" ng-model='toggleAdvance'>
		Advance Search 
	</label>
</div>
<div class="clearfix">
</div>
<select name="" id="input" class="form-control" required="required" style='margin-top:5px;margin-bottom:10px;' ng-model='per_page' ng-cloak>
	<option value="10">Displaying 10 per page.</option>
	<option value="25">Displaying 25 per page.</option>
	<option value="50">Displaying 50 per page.</option>
	<option value="100">Displaying 100 per page.</option>
</select>
<div class="clearfix">
</div>
<table class="table table-hover" ng-show='toggleAdvance' ng-cloak>
	<tr>
		<td><input type='text' class='form-control' placeholder='Search query' ng-model='search'></td>
		<td>
			<div class="checkbox">
				<label style=''>
					<input type="checkbox" ng-value="1" ng-model='filter[1]'>
					<span class="label label-success">Paid</span>
				</label>
				<label>
					<input type="checkbox" value="0" ng-model='filter[0]'>
					<span class="label label-warning">Pending</span>
				</label>
				<label>
					<input type="checkbox" value="5" ng-model='filter[5]'>
					<span class="label label-danger">Cancelled</span>
				</label>
			</div>
		</td>
	</tr>
</table>
<div class="well" ng-show='empty' ng-cloak>
	No results to display
</div>
<table class="table table-hover table-bordered  table-striped" ng-show='hideloading && empty==false' ng-cloak>
	<thead>
		<tr>
			<th>#</th>
			<th>Customer Name</th>
			<th>R. Code</th>
			<th>Check-in</th>
			<th>No. of nights</th>
			<th>status</th>
			<th>Created at</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
	<!-- <tr ng-repeat='b in booking'>
		<td></td>
	</tr> -->
	<tr dir-paginate='b in booking | filter:search | filter:filterByBooking  | itemsPerPage : per_page |reverse '>
		<td> [[ $index+1]] </td>
		<td><span class='upperfirst' ng-bind='b.firstname'></span> <span class='upperfirst' ng-bind='b.lastname'></span></td>
		<td ng-bind='b.code'></td>
		
		<td ng-bind='b.checkindate'></td>
		<td ng-bind='b.nights' style='width:50px;text-align:center'>
		</td>
		<td>
			<span class="label label-success" ng-show='b.status==1'>Paid</span>
			<span class="label label-warning" ng-show='b.status==0'>Pending</span>
			<span class="label label-danger" ng-show='b.status==5'>Cancelled</span>
		</td>
		<td ng-bind='b.datecreated'> </td>
		<td>
			<button type="button" class="btn btn-xs btn-warning" ng-click='updateModal(b)'>		<span class="glyphicon glyphicon glyphicon-edit"></span></button>
			<button type="button" class="btn btn-xs btn-primary" ng-click='viewBooking(b)'>		<span class="glyphicon glyphicon glyphicon-info-sign"></span></button>
		</td>
	</tr>
</tbody>
</table>
<dir-pagination-controls template-url='/adminsite/template/pagination'></dir-pagination-controls>
@stop
@section('scripts')
<script type="text/javascript">
	$('.checkin').datepicker({
		format: 'yyyy-mm-dd',
		startDate: '0d'
	})
	$('.searchDate').datepicker({
		format: 'yyyy-mm-dd',
											//startDate: '0d'
										})
</script>
{{ HTML::script('admin/asset/js/booking.js') }}
@stop