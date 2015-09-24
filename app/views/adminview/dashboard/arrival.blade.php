@extends('layout.admin2')
@section('controller')
arrivalController
@stop
@section('styles')
{{ HTML::style('admin/asset/css/chart/chart.css') }}
<style type="text/css">
	
	address
	{
		margin-bottom:0;
	}
</style>
@stop
@section('content')


<div class="modal fade" id="invoice" style='z-index:10000'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Invoice for booking # </h4>
			</div>
			<div class="modal-body">
				
				<div class="container" style='width:100%;margin-top:-30px'>
					<div class="row">
						<div class="col-xs-12">
							<div class="invoice-title">
								<h2>Invoice</h2><h3 class="pull-right">Booking # <span  ng-bind='selected_invoiceInfo.id'></span></h3>
							</div>
							<hr>
							<div class="row">
								<div class="col-xs-6">
									<address>
										<strong>Billed To:</strong><br>
										<span ng-bind='selected_invoiceInfo.firstname+" "+selected_invoiceInfo.lastname'></span><br>
									</address>
									<address style='margin-top:10px'>
										<strong>Billing date:</strong><br>
										<span ng-bind='selected_invoiceInfo.datecreated'></span><br><br>
									</address>
								</div>

								<div class="col-xs-6 text-right">
									<address>
										<strong>Check in</strong><br>
										<span ng-bind='selected_invoiceInfo.checkindate'></span><br><br>
									</address>

									<address>
										<strong>Check out</strong><br>
										<span ng-bind='selected_invoiceInfo.checkoutdate'></span><br><br>
									</address>
								</div>

							</div>
							<div class="row">
								<div class="col-xs-6">
									<address style='margin-bottom:10px'>
										<strong>Payment Method:</strong><br>
										<span ng-bind='selected_invoiceInfo.payment_type' style='text-transform:uppercase'></span>
									</address>
								</div>
								
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12" style='padding:0'>
							<div class="panel panel-default">
								<div class="panel-heading">
									<h3 class="panel-title"><strong>Reservation summary</strong></h3>
								</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-condensed">
											<thead>
												<tr>
													<td><strong>Room Type</strong></td>
													<td class="text-center"><strong>Price</strong></td>
													<td class="text-center"><strong>Nights</strong></td>
													<td class="text-center"><strong>Quantity</strong></td>
													<td class="text-right"><strong>Price</strong></td>
												</tr>
											</thead>
											<tbody>
												<tr ng-repeat='item in selected_invoiceInfo.reserved_room_grp'>
													<td ng-bind='item.room.room_details.name'>Single</td>
													<td ng-bind='item.room.room_details.price'>100</td>
													<td ng-bind='item.nights' class="text-center">1</td>
													<td class="text-center" ng-bind='item.quantity'>1</td>
													<td class="text-right" ng-bind='item.price'>100</td>
												</tr>
												<tr>
													<td colspan=4 style='text-align:right;font-weight:bold'>Total</td>
													<td style='text-align:right'>500</td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- <textarea class='form-control' placeholder='Remarks'></textarea> -->
								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12" style='padding:0'>
							<div class="panel panel-default">

								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-condensed">
											<thead>
												<tr style='borer:1px solid #777'>
													<td style='width:25%' class='text-center'><strong>Date</strong></td>
													<td class="text-center" style='width:45%'><strong>Description</strong></td>
													<td class="text-center" style='width:20%'><strong>Charges</strong></td>
													<td class="text-center" style='width:20%;'><strong>Credits</strong></td>

												</tr>
											</thead>
											<tbody>
												<tr >
													<td class='text-center' ng-bind='selected_invoiceInfo.datecreated'></td>
													<td class='text-center'>Hotel Accomodation</td>
													<td class='text-center' ng-bind='selected_invoiceInfo.price'>100</td>
													<td class='text-center' ng-bind='selected_invoiceInfo.paid'>0</td>
												</tr>
												<tr>
													<td colspan=2>&nbsp;</td>
													<td style='text-align:center;font-weight:bold;border-top:2px solid #777'>Balance</td>
													<td style='text-align:center;font-weight:bold;border-top:2px solid #777' ng-bind='selected_invoiceInfo.price - selected_invoiceInfo.price'></td>
												</tr>
											</tbody>
										</table>
									</div>
									<!-- <textarea class='form-control' placeholder='Remarks'></textarea> -->
								</div>
							</div>
						</div>
					</div>


				</div>



			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="viewModal" style='z-index:10000'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Booking # <span ng-bind='displayBooking.id'></span></h4>
			</div>
			<div class="modal-body">
				<table class="table table-hover">

					<tr>

						<td>Room Type / <br>Room Number</td>
						<td>
							<span class="label label-primary" ng-repeat='r in displayBooking.reserved_room_grp' ng-bind='r.room.room_details.name +"(# "+ r.room.room_no+")"' style='margin:3px;'></span>
						</td>
					</tr>
					<tr>
						<td>
							Name: 
						</td> 
						<td>
							<span ng-bind='displayBooking.firstname'></span> <span ng-bind='displayBooking.lastname'></span>
						</td>
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
						<td>Status</td>
						<td>
							<span class="label label-success" ng-show='displayBooking.status==1'>Paid</span>
							<span class="label label-warning" ng-show='displayBooking.status==0'>Pending</span>
							<span class="label label-dangser" ng-show='displayBooking.status==5'>Cancelled</span>
							<span class="label label-danger" ng-show='displayBooking.status==2'>Occupied</span>
							<span class="label label-info" ng-show='displayBooking.status==4'>Preparing</span>
							<span class="label label-primary" ng-show='displayBooking.status==3'>Ended</span>
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
				<option value="2" ng-show='updateBooking.status==1 || updateBooking.status==2'>Occupied</option>
				<option value="4">Preparing</option>
				<option value="3" ng-show='updateBooking.status==2 || updateBooking.status==4 || updateBooking.status==3'>Ended</option>
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
	<h2 style='font-family:Open Sans;'>Arrival bookings today</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">Dashboard</a>
	</li>
	<li class="active">Arrival Bookings</li>
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
				<td ng-bind='b.checkindate'></td>
				<td ng-bind='b.nights'></td>
				<td>
					
					<span class="label label-success" ng-show='b.status==1'>Paid</span>
					<span class="label label-warning" ng-show='b.status==0'>Pending</span>
					<span class="label label-danger" ng-show='b.status==5'>Cancelled</span>
					<span class="label label-danger" ng-show='b.status==2'>Occupied</span>
					<span class="label label-info" ng-show='b.status==4'>Preparing</span>
					<span class="label label-primary" ng-show='b.status==3'>Ended</span>
					
				</td>
				<td><div class="btn-group">
					<button type="button" class="btn btn-xs btn-warning" ng-click='updateBookingBtn(b)'>Update</button>
					<button type="button" class="btn btn-xs btn-primary" ng-click='viewBooking(b)'>View</button>
					<button type="button" class="btn btn-xs btn-info" ng-click='viewInvoice(b)'>Invoice</button>
					
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