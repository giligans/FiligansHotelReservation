@extends('layout.master')
@section('initializeData')
<input type='hidden' ng-init='room=0'>
@stop
@section('controller')
bookingController
@stop
@section('content')
<style type="text/css">
</style>
<input type='hidden' ng-init='room = {
checkin : "{{ Session::get("checkin") }}",
checkout : "{{ Session::get("checkout") }}",
price : "200"
}'>
<div class="row">
	<div class="container">
		<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
			
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<h3 class="panel-title">Booking Information <button type="button" class="btn btn-xs btn-warning" ng-click='changebooking()'>Change</button></h3>
				</div>
				<div class="panel-body" style='padding-top:0px;padding-bottom:0px'>
					<div class="row" style='font-family:Open Sans;font-size:20px'>
						<div class="col-xs-2 col-sm-2 col-md-3 col-lg-2" style='background-color:#d8d8d8'>
							<p>Booking : </p>
							<p>Arriving : </p>
							<p>Departing : </p>
							<p>No of Room : </p>
							<p>Per night: </p>
							<p>Total : </p>
							
						</div>
						<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
							<p>Room type <span style='color:red'>{{ $room_details->name }}</span>, for <span style='color:red' ng-bind='nights'>2</span> nights.</p>
							<p ng-bind='displayInfo.checkin'></p>
							<p ng-bind='displayInfo.checkout'></p>
							<p></p>
							<div class="input-group number-spinner" style='max-width:300px;'>
								<span class="input-group-btn">
									<button class="btn btn-default" data-dir="dwn" ng-click='subrooms()'><span class="glyphicon glyphicon-minus"></span></button>
								</span>
								<input type="text" class="form-control text-center"  ng-model='rooms'>
								<span class="input-group-btn">
									<button class="btn btn-default" data-dir="up" ng-click='addrooms()'><span class="glyphicon glyphicon-plus"></span></button>
								</span>
							</div>
						</p>
						<p ng-bind='room.price | currency:"P"'></p>
						<p ng-bind='displayInfo.price | currency:"P"'></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
		
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title">Personal Information</h3>
			</div>
			<div class="panel-body" style='padding-top:0px;padding-bottom:0px'>
				<div class="row" style='font-family:Open Sans;font-size:20px'>
					<div class="col-xs-2 col-sm-2 col-md-3 col-lg-2" style='background-color:#d8d8d8'>
						<p>Guest Name: </p>
						<p>Email : </p>
						<p>Phone  : </p>
						<p>Address : </p>
						
					</div>
					<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
						<p style='margin:0px;padding:3px'><input type='text' required class='form-control' placeholder='Firstname Lastname'></p>
						<p style='margin:0px;padding:3px'><input type='text' required class='form-control' placeholder='your_email@email.com'></p>
						<p style='margin:0px;padding:3px'><input type='text' required class='form-control' placeholder='09XX XXX XXXX'></p>
						<p style='margin:0px;padding:3px'>
							<textarea class='form-control' placeholder='Full Address'></textarea>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3 class="panel-title"> Payment</h3>
			</div>
			<div class="panel-body" style='padding-top:0px;padding-bottom:0px'>
				<div class="row" style='font-family:Open Sans;font-size:20px'>
					<div class="col-xs-2 col-sm-2 col-md-3 col-lg-2" style='background-color:#d8d8d8'>
						<p>Card Number</p>
						<p>Expiry Month</p>
						<p>Expiry Year </p>
						<p>CV </p>
						
					</div>
					<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
						<p style='margin:0px;padding:3px'><input type='text' class='form-control' placeholder='Enter A valid credit card number'></p>
						<p style='margin:0px;padding:3px'><input type='text' class='form-control' placeholder='Expiry Month'></p>
						<p style='margin:0px;padding:3px'><input type='text' class='form-control' placeholder='Expriy Year'></p>
						<p style='margin:0px;padding:3px'>
							<textarea class='form-control' placeholder='CV'></textarea>
						</p>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-body">
				<CENTER><label>TERMS AND CONDITIONS</label></CENTER>
				<p></p>
				<p>....</p>
			</div>
		</div>
		<div class="col-xs-offset-1 col-sm-offset-1 col-md-offset-3 col-lg-offset-3">
			
			<div class="checkbox" >
				<label>
					<input type="checkbox" value="" ng-model='proceed'>
					<span style='font-family:Open Sans; font-size:20px'>agree with the terms and conditions</span> <button type="button" class="btn btn-sm btn-primary" ng-disabled='!proceed'>Proceed to checkout</button>
				</label>
			</div>
			
		</div>
	</div>
</div>
</div>
@stop
@section('scripts')
{{ HTML::script('asset/scripts/moment.js') }}
{{ HTML::script('asset/scripts/angular-moment.min.js') }}
{{ HTML::script('asset/scripts/client/booking.js') }}
@stop