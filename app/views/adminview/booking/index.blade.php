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
	.margin-xs
	{
		margin:2px;
	}
	address
	{
		margin-bottom:0;
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
													<input type="checkbox" value="4" ng-model='filter[4]'>
													<span class="label label-info">Preparing</span>
												</label>
												<label>
													<input type="checkbox" value="2" ng-model='filter[2]'>
													<span class="label label-primary">Occupied</span>
												</label>
												<label>
													<input type="checkbox" value="3" ng-model='filter[3]'>
													<span class="label label-primary">Ended</span>
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
											<td> [[ $index+1 ]] </td>
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
												<button type="button" class="btn margin-xs btn-xs btn-warning" ng-click='updateModal(b)'>		<span class="glyphicon glyphicon glyphicon-edit"></span></button>
												<button type="button" class="btn margin-xs btn-xs btn-primary" ng-click='viewBooking(b)'>		<span class="glyphicon glyphicon glyphicon-info-sign"></span></button>
												<button type="button" class="btn margin-xs btn-xs btn-info" ng-click='viewInvoice(b)'><span class="glyphicon glyphicon-glyphicon glyphicon-align-right" aria-hidden="true"></span> </button>
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