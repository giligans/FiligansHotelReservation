@extends('layout.master2')
@section('controller')
bookingController
@stop
@section('styles')
<style type="text/css">
	
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
				<button type="button" class="btn btn-default btn-circle">1</button>
				<p>Checking availability</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle">2</button>
				<p>Choosing rooms</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-primary btn-circle" disabled="disabled">3</button>
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
				<h2 style='font-family:"Oswald";float:right'>Please fill up the form.</h2>
				<div class="clearfix"></div>
				<small style='float:right'>You have choosen room(s)
					@foreach(Session::get('reservation')['reservation_room'] as $rooms)
					<span class="label label-primary" style='font-size:12px;'> {{ $rooms['room_details']['name'] }}({{ $rooms['quantity']}})</span>
					@endforeach
					for dates.</small>
					<div class="clearfix"></div>
					<small style='float:right'> You're check-in will be on <span style='color:red'> <?php echo date("D, d M Y", strtotime(Session::get('reservation')['checkin'])); ?> </span> <br>and you will be checkout <br> on <span style='color:red'> <?php echo date("D, d M Y", strtotime(Session::get('reservation')['display_checkout'])); ?> </span> by 12:00 NN.	</small>

				</center>
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style='border-left:1px solid #d8d8d8;margin-top:20px'>


				<form action="{{ URL::to('booking/step3	') }}" method="POST" role="form">


					<div class="form-group container-fluid">
						<div class="row">
							<label for="">Membership ID ( Not Required )</label>
						</div>
						<div class="row">
							<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style='padding-left:0;padding-right:3px;'>
								<input name='membership_id' type="text" class="form-control" id=""  placeholder="Enter your Membership ID" ng-model='membership_id'  ng-class='{"success": isMember && isMember!=null, "fail": isMember==false && isMember!=null }'>	
							</div>
							<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" style='padding-right:0;padding-left:3px;'>
								<button type="button" class="btn btn-large btn-block btn-success" ng-click='validateMembership()'>Validate</button>
							</div>
						</div>
						<div class="row" style='padding-top:5px;'>
							<label  ng-show='membershipMessage!=null' ng-bind='membershipMessage' ng-class='{"success": isMember && isMember!=null, "fail": isMember==false && isMember!=null }'>
								
							</label>
							<label>
								<button type="button" class="btn btn-xs btn-primary" ng-show=''>Use this?</button>
							</label>
						</div>
					</div>

					<div class="form-group">
						<label for="">Firstname</label>
						<input type="text" ng-readonly='isMember' ng-value='membership.firstname' class="form-control" id="" name='firstname' required placeholder="Enter your firstname. Required.">
					</div>
					<div class="form-group">
						<label for="">Lastname</label>
						<input type="text" ng-readonly='isMember' ng-value='membership.lastname' class="form-control" id="" name='lastname' required placeholder="Enter your Lastname. Required.">
					</div>
				<!-- <div class="form-group">
					<label for="">Lastname</label>
					<input type="text" class="form-control" id="" placeholder="Enter your name. Required.">
				</div> -->
				<div class="form-group">
					<label for="">Address</label>
					<textarea class='form-control' ng-model='membership.address' ng-readonly='isMember' required name='address' placeholder='Enter your address. Required'></textarea>
				</div>
				<div class="form-group">
					<label for="">Contact Number:</label>
					<input type="text" class="form-control" ng-value='membership.contact_no' ng-readonly='isMember' name='contact_no' required id="" placeholder="Enter your contact no. Required.">
				</div>
				<div class="form-group">
					<label for="">Email address</label>
					<input type="email" class="form-control" ng-value='membership.email' ng-readonly='isMember' name='email' required id="" placeholder="Enter your valid email address. Your reservation code will be sent to your email address.">
				</div>
				

				<button type="submit" class="btn btn-primary">Submit</button>
			</form>

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
			checkMembership : function(membership_id)
			{
				return $http.get('/checkmembership/'+membership_id);
			}
		}
	})
	.controller('bookingController', ['$scope','bookingFactory', function($scope, bookingFactory){
		$scope.membershipMessage = null;
		$scope.membership = null;
		$scope.isMember = null;
		$scope.validateMembership = function()
		{
			$scope.membershipMessage = 'Validating...'
			bookingFactory.checkMembership($scope.membership_id).success(function(data)
			{
				if(data.code!=1)
				{

					$scope.isMember=false;

				}else
				{
					$scope.membership = angular.copy(data.membership);
					$scope.isMember=true;
				}
				$scope.membershipMessage = angular.copy(data.content);

			}).error(function()
			{
				$scope.membershipMessage='Something went wrong. Please try again later.'
				$scope.discounted = false;
			})
		}

	}])
</script>
@stop