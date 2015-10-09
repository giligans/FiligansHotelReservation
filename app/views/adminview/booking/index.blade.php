@extends('layout.admin2')
@section('styles')
<style type="text/css">
	.upperfirst::first-letter {
		text-transform: uppercase;
	}
	.invoice-title h2, .invoice-title h3 {
		display: inline-block;
	}
	.table > tbody > tr > .no-line {
		border-top: none;
	}
	.table > thead > tr > .no-line {
		border-bottom: none;
	}
	.table > tbody > tr > .thick-line {
		border-top: 2px solid;
	}
	.loading-table
	{
		opacity: 0.5;
	}

	.margin-xs
	{
		margin:2px;
	}
	address
	{
		margin-bottom:0;
	}
	.inline-block 
	{
		display:inline-block;
	}
</style>
@stop
@section('controller')
bookingController
@stop
@section('content')
<div class="modal fade" id="invoice" style='z-index:10000'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Invoice for booking # <span  ng-bind='selected_invoiceInfo.id'></span></h4>
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
									<address style='margin-bottom:10px'>
										<strong>Payment Method:</strong><br>
										<span ng-bind='selected_invoiceInfo.payment_type' style='text-transform:uppercase'></span>
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
									<address>
										<strong>Reservation Code</strong><br>
										<span ng-bind='selected_invoiceInfo.code'></span><br><br>
									</address>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-6">
									
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
				<h4 class="modal-title">Booking of <span ng-bind='displayBooking.firstname'></span> <span ng-bind='displayBooking.lastname'></span></h4>
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
				<option value="2" ng-show='updateBooking.status==1'>Occupied</option>
				<option value="4">Preparing</option>
				<option value="3" ng-show='updateBooking.status==2 || updateBooking.status==4'>Ended</option>
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
						<td>X
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
							<div class="">
								The room is available!
							</div>
							<div class="col-md-6">
								<button type="button" class="btn btn-sm btn-block btn-primary" style='margin-top:10px' ng-click='addMoreRoom()'><span class="glyphicon glyphicon-glyphicon glyphicon-plus" aria-hidden="true"></span> Add more rooms </button>
							</div>
							<div class="col-md-6">
								<button type="button" class="btn btn-sm btn-block btn-primary" style='margin-top:10px' ng-click='publishBooking()'> <span class="glyphicon glyphicon-glyphicon glyphicon-ok" aria-hidden="true"></span> Proceed to checkout</button>
							</div>
							<div class="clearfix">
							</div>
						</center>
					</div>
					<div class="well" ng-show='displayform==true && available==0 && displayform2==false'>
						<center>
							This room is unavailable.
						</center>
					</div>
					<div ng-show='displayform3'>
						<!-- paymentform -->
						<div class="container" style='width:100%;margin-top:-30px'>
							<div class="row">
								<div class="col-xs-12">
									<div class="invoice-title">
										<h2>Invoice</h2><h3 class="pull-right">Booking # <span  ng-bind='invoiceInfo.id'></span></h3>
									</div>
									<hr>
									<div class="row">
										<div class="col-xs-6">
											<address>
												<strong>Billed To:</strong><br>
												<span ng-bind='invoiceInfo.firstname+" "+invoiceInfo.lastname'></span><br>
												
											</address>
										</div>
										<div class="col-xs-6 text-right">
											<address>
												<strong>Check in</strong><br>
												<span ng-bind='invoiceInfo.checkindate'></span><br><br>
											</address>
											<address>
												<strong>Check out</strong><br>
												<span ng-bind='invoiceInfo.checkoutdate'></span><br><br>
											</address>
										</div>
										
									</div>
									<div class="row">
										<div class="col-xs-6">
											<address>
												<strong>Payment Method:</strong><br>
												CASH
											</address>
										</div>
										<div class="col-xs-6 text-right">
											<address>
												<strong>Booking date:</strong><br>
												<span ng-bind='invoiceInfo.datecreated'></span><br><br>
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
														<tr ng-repeat='item in invoiceInfo.reserved_room_grp'>
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
															<td class='text-center' ng-bind='invoiceInfo.datecreated'></td>
															<td class='text-center'>Hotel Accomodation</td>
															<td class='text-center' ng-bind='invoiceInfo.price'>100</td>
															<td class='text-center'>0</td>
														</tr>
														
														<tr>
															<td colspan=2>&nbsp;</td>
															<td style='text-align:center;font-weight:bold;border-top:2px solid #777'>Balance</td>
															<td style='text-align:center;font-weight:bold;border-top:2px solid #777' ng-bind='invoiceInfo.price'></td>
														</tr>
													</tbody>
												</table>
											</div>
											<!-- <textarea class='form-control' placeholder='Remarks'></textarea> -->
											<div class="well">
												<div class="alert alert-danger" ng-show='insufficientFund'>
													<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
													<strong>Ooops!</strong> Insufficient fund.
												</div>
												<div class="input-group" style='margin-bottom:10px'>
													<span class="input-group-addon">P </span>
													<input type="text" ng-model='invoiceInfo.paid' class="form-control" placeholder='Customer paid' aria-label="Amount (to the nearest dollar)">
													<span class="input-group-addon">.00</span>
												</div>
												<input type='text' class='form-control' placeholder='Discount Coupon/Membership' style='margin-bottom:10px'>
												<input type='text' ng-model='invoiceInfo.change' disabled="" placeholder='Change' class='form-control' style='margin-bottom:10px'>
												<button type="button" class="btn btn-primary btn-block" ng-click='proceedPayment()'> Proceed to payment</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- payment form -->
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
						<tr ng-hide='moreRooms'>
							<td>
								Check in
							</td>
							<td>
								<input type='text' class='form-control checkin' ng-model='availability.checkin'>
							</td>
						</tr>
						<tr ng-hide='moreRooms'>
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
					<div class="well" style='font-weight:bold;' ng-show='displayform2'>
						Membership ID 
						<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style='padding:2px'>
							<input type='text' class='form-control'  placeholder="Please enter the customer's membership ID"> 
						</div>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style='padding:2px'>
							<button type="button" class="btn btn-primary">Validate</button>
						</div>
						<div class="clearfix">
							
						</div>
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
							<td>
								
							</td>	<td>
							<div class="checkbox">
								<label>
									<input type="checkbox" value="" ng-model='anonymous'>
									Anonymous Booking ( Customer information will not be recorded. )
								</label>
							</div>
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



<div class="well" ng-show='empty' ng-cloak>
	No results to display
</div>
<div class="well" ng-show='advancesearch'>
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		<div class='container-fluid'>
			<div class="row" style='padding:3px;'>
				<input type='text' ng-model='searchQuery.raw' class='form-control' placeholder='Custome name / Booking ID / Code'>
			</div>
			<div class="row">

				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style='padding:3px;'>
					<input type='text' ng-model='searchQuery.startdate' class='checkin form-control' placeholder='Enter Starting Date'>
				</div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style='padding:3px;' >
					<input type='text' ng-model='searchQuery.enddate' class='checkin form-control' placeholder='Enter Ending Date'>
				</div>
			</div>

			<div class="row">
				<div class="checkbox inline-block">
					<label>
						<input type="checkbox" ng-model='searchQuery.status[0]'value="">
						Pending
					</label>
				</div>
				<div class="checkbox inline-block">
					<label>
						<input type="checkbox" ng-model='searchQuery.status[1]'value="">
						Paid
					</label>
				</div>
				<div class="checkbox inline-block">
					<label>
						<input type="checkbox" ng-model='searchQuery.status[2]'value="">
						Occupied
					</label>
				</div>

				<div class="checkbox inline-block">
					<label>
						<input type="checkbox" ng-model='searchQuery.status[4]'value="">
						Preparing
					</label>
				</div>
				<div class="checkbox inline-block">
					<label>
						<input type="checkbox" ng-model='searchQuery.status[3]'value="">
						Ended
					</label>
				</div>
				<div class="checkbox inline-block">
					<label>
						<input type="checkbox" ng-model='searchQuery.status[5]'value="">
						Cancelled
					</label>
				</div>
				<div class="checkbox inline-block">
					<label>
						<input type="checkbox" ng-model='searchQuery.status[6]'value="">
						Overdue
					</label>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<button type="button" ng-click='execSearch(searchQuery)' class="btn btn-primary btn-block">Search Query</button>
		<button type="button" ng-click='clearSearch()' class="btn btn-warning btn-block">Clear Search</button>
	</div>
	<div class="clearfix">

	</div>
</div>

<div style='float:right;'>
	<label>Order by: </label>
	<select name="" style='border:2px solid #d8d8d8' ng-model='orderQuery' id="input" class="form-control" required="required">
		<option value="id">B. ID</option>
		<option value="firstname">Firstname</option>
		<option value="lastname">Lastname</option>

		<option value="check_in">Check In</option>
		<option value="created_at">Created at</option>
		<option value="updated_at">Updated at</option>
	</select>
</div>
<div style='float:right;margin-right:20px;margin-top:30px'>
	<div class="checkbox">
		<label>
			<input type="checkbox" ng-model='advancesearch' value="">
			Toggle advance search
		</label>
	</div>
</div>

<bgf-pagination
page="page"
per-page="perPage"
client-limit="clientLimit"
url="url"
url-params = 'urlParams'
link-group-size="2"
collection="items">
</bgf-pagination ng-show='items'>
<table class="table table-hover table-bordered  table-striped" ng-class='{"loading-table" : loading_table  }' ng-show='hideloading && empty==false' ng-cloak>
	<thead>
		<tr>
			<th class='text-center' style='width:10%'> B.ID</th>
			<th style='width:20%'>Customer Name</th>
			<th style='width:10%'>R. Code</th>
			<th style='width:15%'>Check-in</th>
			<th style='width:10%'>No. of nights</th>
			<th style='width:10%'>status</th>
			<th style='width:10%'>Created at</th>
			<th style='width:15%;'>Action</th>
		</tr>
	</thead>
	<tbody>
										<!-- <tr ng-repeat='b in booking'>
												<td></td>
											</tr> -->
											<tr ng-repeat='b in items'>
												<td ng-bind='b.id'> </td>
												<td><span class='upperfirst' ng-bind='b.firstname'></span> <span class='upperfirst' ng-bind='b.lastname'></span></td>
												<td ng-bind='b.code'></td>
												
												<td ng-bind='b.checkindate'></td>
												<td ng-bind='b.nights' style='width:50px;text-align:center'>
												</td>
												<td>
													<span class="label label-success" ng-show='b.status==1'>Paid</span>
													<span class="label label-warning" ng-show='b.status==0'>Pending</span>
													<span class="label label-danger" ng-show='b.status==5'>Cancelled</span>
													<span class="label label-primary" ng-show='b.status==2'>Occupied</span>
													<span class="label label-info" ng-show='b.status==4'>Preparing</span>
													<span class="label label-primary" ng-show='b.status==3'>Ended</span>
												</td>
												<td ng-bind='b.datecreated'> </td>
												<td>
													<button type="button" class="btn margin-xs btn-xs btn-warning" ng-click='updateModal(b)' style='margin:1px;'>		<span class="glyphicon glyphicon glyphicon-edit"></span></button>
													<button type="button" class="btn margin-xs btn-xs btn-primary" ng-click='viewBooking(b)' style='margin:1px;'>		<span class="glyphicon glyphicon glyphicon-info-sign"></span></button>
													<button type="button" class="btn margin-xs btn-xs btn-info" ng-click='viewInvoice(b)' style='margin:1px;'><span class="glyphicon glyphicon-glyphicon glyphicon-align-right" aria-hidden="true"></span> </button>
												</td>
											</tr>
										</tbody>
									</table>
									<bgf-pagination
									page="page"
									per-page="perPage"
									client-limit="clientLimit"
									url="url"
									url-params = 'urlParams'
									link-group-size="2"
									collection="items">
								</bgf-pagination>
								@stop
								@section('scripts')
								<script type="text/javascript">
									$('.checkin').datepicker({
										format: 'yyyy-mm-dd',
										
									})
									$('.searchDate').datepicker({
										format: 'yyyy-mm-dd',
																			//startDate: '0d'
																		})
																	</script>
																	{{ HTML::script('admin/asset/js/booking.js') }}
																	@stop