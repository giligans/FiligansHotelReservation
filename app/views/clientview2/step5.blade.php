@extends('layout.master2')
@section('controller')
homeController
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
				<button type="button" class="btn btn-default btn-circle" disabled="disabled">1</button>
				<p>Checking availability</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle" disabled="disabled">2</button>
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
				<button type="button" class="btn btn-success btn-circle" disabled="disabled">5</button>
				<p>DONE</p>
			</div>
		</div>
	</div>
</div>

<div class="row" style='margin-top:30px'>
	<div style='max-width:960px;margin:0 auto'>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<center>
				<h2 style='font-family:"Oswald";float:right'>DONE</h2>
				<div class="clearfix"></div>
				<small style='float:right'>You have choosen Single room for dates.</small>
				<div class="clearfix"></div>
				<small style='float:right'>January 29, 2015 to January 30, 2015</small>
			</center>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style='border-left:1px solid #d8d8d8;margin-top:20px'>
			<CENTER>
				<H4>Your Reservation Code is</H4>
				<h1 style='font-family:"Oswald";text-transform:uppercase'> {{ Session::get('code') }}</h1>
			</CENTER>

			<P style='text-align:center;margin-top:20px'>You can also check your email for the Reservation Code. If you have any inquiries, feel free to call us on 8700 or visit our <a href='#'>Contact</a> page. </P>

			<h3 style='font-family:Open Sans;text-align:center'>Thank you and have a nice day!</h3>
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
	}).controller('homeController', ['$scope', function($scope){
	//	alert('hey')
}])
</script>
@stop