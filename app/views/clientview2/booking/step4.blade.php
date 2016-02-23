@extends('layout.master2')
@section('controller')
bookingController
@stop
@section('styles')

<style type="text/css">
	.stepwizard-step p {
		margin-top: 10px;
	}
	.stepwizard-row {
		display: table-row;
	}
	.stepwizard {
		display: table;
		width: 100%;
		position: relative;
	}
	.stepwizard-step button[disabled] {
		opacity: 1 !important;
		filter: alpha(opacity=100) !important;
	}
	.stepwizard-row:before {
		top: 14px;
		bottom: 0;
		position: absolute;
		content: " ";
		width: 100%;
		height: 1px;
		background-color: #ccc;
		z-order: 0;
	}
	input.fail
	{
		border:2px solid red;
	}
	input.success
	{
		border:2px solid green;
	}

	label.success
	{
		color:green;
	}

	label.fail
	{
		color:Red;
	}
	.stepwizard-step {
		display: table-cell;
		text-align: center;
		position: relative;
	}
	.btn-circle {
		width: 30px;
		height: 30px;
		text-align: center;
		padding: 6px 0;
		font-size: 12px;
		line-height: 1.428571429;
		border-radius: 15px;
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
</style>
@stop
@section('content')
<div class="row">
	<div class="stepwizard">
		<div class="stepwizard-row">
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle">1</button>
				<p>Checking availability</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle">2</button>
				<p>Choosing rooms</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle" disabled="">3</button>
				<p>Customer Information</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-primary btn-circle" disabled="disabled">4</button>
				<p>Payment</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle" disabled="disabled">5</button>
				<p>DONE</p>
			</div>
		</div>
	</div>
</div>
<div class="row" style='margin-top:30px'>
	<div style='max-width:960px;margin:0 auto'>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<center>
				<h2 style='font-family:"Oswald";float:right'>Please fill up the form.</h2>
				<div class="clearfix"></div>
				<small style='float:right'>You have choosen rooms(s)
					@foreach(Session::get('reservation')['reservation_room'] as $rooms)
					<span class="label label-primary" style='font-size:12px;'> {{ $rooms['room_details']['name'] }}({{ $rooms['quantity']}})</span>
					@endforeach
					for dates.</small>
					<div class="clearfix"></div>
					<small style='float:right'> You're check-in will be on <span style='color:red'> <?php echo date("D, d M Y", strtotime(Session::get('reservation')['checkin'])); ?> </span> <br>and you will be checkout <br> on <span style='color:red'> <?php echo date("D, d M Y", strtotime(Session::get('reservation')['display_checkout'])); ?> </span> by 12:00 NN.	</small>

				</center>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style='border-left:1px solid #d8d8d8;margin-top:20px'>
				<div class="row">
					<div class="col-xs-6">
						<address>
							<strong>Billed To:</strong><br>
							{{ Session::get('reservation.customerinformation')['firstname'] }} {{ Session::get('reservation.customerinformation')['lastname'] }}<br>
						</address>
						<address>
							<strong>Customer Information:</strong><br>
							<p>
								Address: {{ Session::get('reservation.customerinformation')['address'] }}
							</p>
							<p>Contact Number: {{ Session::get('reservation.customerinformation')['contact_no'] }} </p>
							<p>Email Address:  {{ Session::get('reservation.customerinformation')['email'] }} </p>
						</address>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title"><strong>Reservation summary</strong></h3>
							</div>
							<div class="panel-body">
								<div class="table-responsive">
									<table class="table table-condensed" id='invoice-table'>
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
											<!-- foreach ($order->lineItems as $line) or some such thing here -->
											<?php
											$total = 0;
											?>
											@foreach(Session::get('reservation')['reservation_room'] as $rooms)
											<?php
											$total +=$rooms['room_details']['price'] * $rooms['quantity'] * Session::get('reservation.nights');
											?>
											<tr>
												<td>{{{ $rooms['room_details']['name'] }}}</td>
												<td>{{{ $rooms['room_details']['price'] }}}</td>
												<td class="text-center">{{{ Session::get('reservation.nights') }}}</td>
												<td class="text-center">{{{ $rooms['quantity'] }}}</td>
												<td class="text-right">{{ $rooms['room_details']['price'] * $rooms['quantity'] * Session::get('reservation.nights') }}</td>
											</tr>
											@endforeach

											<tr style='border-top:2px solid #777'>
												<td colspan=4 style='text-align:right;font-weight:bold'>Sub total</td>
												
												<td style='text-align:right'>P{{ number_format($total,2) }}

												</td>
											</tr>
											@if(Session::has('reservation.customerdiscount'))
											<tr>
												<td colspan=4 style='text-align:right;font-weight:bold'>Membership Discount</td>
												
												<td style='text-align:right'>-P{{ number_format(Session::get('reservation.customerdiscountprice'),2) }}</td>
											</tr>
											@endif
											<tr id='total-amount'>
												<td colspan=4 style='text-align:right;font-weight:bold'>Total Price</td>
												<input type='hidden' id='subtotal' value="{{ number_format(computeDiscount($total, Session::get('reservation.customerdiscountprice')),2) }}">

												<td style='text-align:right' id='total-amount-val'>P{{ number_format(computeDiscount($total, Session::get('reservation.customerdiscountprice')),2) }}</td>
											</tr>

										</tbody>
									</table>
								</div>
								<form action='{{ URL::to("booking/payment") }}' method="POST">
									<!-- <textarea class='form-control' placeholder='Remarks'></textarea> -->
									<label class='pull-left'>Discount Code </label>
									<!-- <button type="button" ng-show='discounted' class="pull-right btn btn-xs btn-success"><span class="glyphicon glyphicon-glyphicon glyphicon-check" aria-hidden="true"></span> Use this Code</button> -->
									<input name='discountCode' type='text' ng-class='{"success": discounted && discounted!=null, "fail": discounted==false && discounted!=null }' ng-model='discountCode' class='form-control' placeholder='Enter a code'>
									<label  ng-class='{"success": discounted && discounted!=null, "fail": discounted==false && discounted!=null }' style='display:block' ng-show='discountedMessage!=null' ng-bind='discountedMessage'>

									</label>

									<label style='display:block'>
										<input type="checkbox" value="" ng-model='terms' required>
										Agree to terms and condition.
									</label>

									<button type="submit" class="btn btn-large btn-block btn-primary" ng-disabled='terms==false'>Proceed to checkout (via Paypal)</button>
								</form>
								<div class="checkbox">

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop
@section('scripts')
<script type="text/javascript">
	angular.module('giligansApp', [], function($interpolateProvider){
		$interpolateProvider.startSymbol('[[');
		$interpolateProvider.endSymbol(']]');
	}).factory('bookingFactory', function($http)
	{
		return{
			checkCode : function(code)
			{
				return $http.post('/checkcode/'+code);
			}
		}
	})
	.controller('bookingController', ['$scope','bookingFactory', function($scope, bookingFactory){
		$scope.discounted = null;
		$scope.discountedMessage = null;
		$scope.terms = false;
		$scope.discountedMessage = null;
		//var total_amount = parseInt($('#subtotal').val());

		$scope.$watch('discountCode', function(newVal,oldVal)
		{
			
			if(oldVal != newVal)
			{

				if(newVal.length > 5)
				{
					$scope.discountedMessage = 'verifiying code...'
					bookingFactory.checkCode(newVal).success(function(data)
					{
						console.log(data);
						if(data.code!=1)
						{
							
							$scope.discounted=false;
							$('#total-amount-val').html('P '+$('#subtotal').val())
							$('.coupon-discount').remove();
						}else
						{
							$("<tr class='coupon-discount'><td colspan=4 style='text-align:right;font-weight:bold'>Coupon Discount </td><td style='text-align:right'>-"+data.discount.effect_str+"</td></tr>").insertBefore('#total-amount')
							//$('#total-amount').prepend('<tr><td colspan=4>test</td><td>0</td>')
							if(data.discount.effect_type=='0')
							{

								total_amount = parseInt($('#subtotal').val()) - data.discount.effect;
							}else
							{
								total_amount = parseInt($('#subtotal').val()) -  parseInt($('#subtotal').val()) * (data.discount.effect / 100);
							}
							$('#total-amount-val').html('P '+total_amount)
							$scope.discounted=true;
						}
						$scope.discountedMessage = angular.copy(data.content);

					}).error(function()
					{
						$scope.discountedMessage='Something went wrong. Please try again later.'
						$('.coupon-discount').remove();
						$scope.discounted = false;
					})
				}else
				{
					$('#total-amount-val').html('P '+$('#subtotal').val())
					$scope.discounted = false;
					$('.coupon-discount').remove();
					$scope.discountedMessage = null;
				}
			}

		})
}])
</script>
@stop