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
</style>
@stop
@section('content')
<div class="row">
	<div class="stepwizard">
		<div class="stepwizard-row">
			<div class="stepwizard-step">
				<button type="button" class="btn btn-primary btn-circle">1</button>
				<p>Checking availability</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle">2</button>
				<p>Choosing rooms</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
				<p>Customer Information</p>
			</div> 
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle" disabled="disabled">4</button>
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
			<h2 style='font-family:"Oswald";float:right'>Check availability </h2>
			<small class="pull-right">Pick a date to proceed checking room availability.</small>
		</center>
	</div>

		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style='margin-top:20px;border-left:1px solid #d8d8d8'>
		@if(Session::has('error'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Ooop!</strong> {{ Session::get('error') }}
			</div>
		@endif
		<div class="form-group">
			<form action='{{ URL::to("booking/step1") }}' method='POST'>
				<label>Check in date</label>
			<input type='text' class='form-control checkin' placeholder='Your Check-in Date'  value="{{ date('Y-m-d') }}" name='checkin' required>
			</div>
			<div class="form-group">
			<label>Check out date</label>
			<input type='text' class='form-control checkout' placeholder='Your Check-in Date'  value="{{ date('Y-m-d', strtotime('+1 day'))}}" name='checkout' required>
			</div>
	
			<div class="form-group">
				<button type="submit" class="btn btn-large btn-block btn-danger">Check availability</button>
			</div>
		</div>
		</form>

	
	</div>
</div>



@stop

@section('scripts')

<script type="text/javascript">
	$('.checkin').datepicker({
		format: 'yyyy-mm-dd',
		startDate: '0d'
	})

	$('.checkout').datepicker({
		format: 'yyyy-mm-dd',
		startDate: '0d'
	})
</script>
{{ HTML::script('asset/scripts/client2/booking.js') }}

@stop