@extends('layout.master2')
@section('controller')
homeController
@stop
@section('content')

<div class="modal fade" id="book-this-room">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">Book for this room  <small>Booking of a day start at 12:00 PM and end at 11:59 AM of the day</small></h4>
			</div>
			<div class="modal-body">
				<div style='width:100%;height:100%;padding:10px;' ng-show='loading'>
					<center> 
						<img src='/images/loader2.gif'>
					</center>
				</div>
				<div class="alert alert-warning" ng-show='notAvailable'>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					<strong>Room Unavailable</strong> Please pick another room / schedule.
				</div>

				<div ng-show='hideForm'>
					<form method='POST' action="{{ URL::to('booking/step2/direct') }}">
						<input type='hidden' name='reservation_room[0][quantity]' ng-value='reservation.quantity'>
						<input type='hidden' name='reservation_room[0][room_id]' ng-value='reservation.room_id'>
						<input type='hidden' name='checkin' ng-value='reservation.checkin'>
						<input type='hidden' name='checkout' ng-value='reservation.checkout'>
						<input type='hidden' name='display_checkout' ng-value='reservation.display_checkout'>
						<div class="well">
							The room is available! <button type="submit" class="btn btn-xs btn-primary">Proceed</button> or <button type="button" class="btn btn-xs btn-danger" style='' ng-click='hideForm=false'>Back to form</button>
						</div>
					</form>
				</div>

				<table class="table table-hover" ng-hide='hideForm'>
					<tr>
						<td>
							Date
						</td>
						<td>
							<input type='text' ng-model='date' class='checkin form-control' ng-init='date="{{ date("Y-m-d") }}"' value='{{ date("Y-m-d") }}'>
						</td>
					</tr>
					<tr>
						<td>
							Nights
						</td>

						<td>
							<select ng-init='nights=1' ng-model='nights' name="" id="input" class="form-control" required="required">

								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
								<option value="8">8</option>
								<option value="9">9</option>
								<option value="10">10</option>
								<option value="11">11</option>
								<option value="12">12</option>
								<option value="13">13</option>
								<option value="14">14</option>
								<option value="15">15</option>
							</select>
						</td>
					</tr>
					<tr>
						<td>
							No. of rooms
						</td>
						<td>
							<select ng-init='rooms=1' ng-model='rooms' name="" id="input" class="form-control" required="required">

								<option value="1">1</option>
								<option value="2">2</option>
								<option value="3">3</option>
								<option value="4">4</option>
								<option value="5">5</option>
								<option value="6">6</option>
								<option value="7">7</option>
							</td>
						</tr>


					</tr>
				</table>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary" ng-click='checkAvailability(date,nights,rooms)'>Check Availability</button>
			</div>
		</div>
	</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-5 col-lg-5">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<img class='img-responsive' src="/image/large/{{ $room->roomImages[0]->photo->filename}}">	
			</div>
			@foreach($room->roomImages as $image)
			<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" style='padding:10px;'>
				<img class='img-responsive' src="/image/large/{{ $image->photo->filename }}">	
			</div>
			@endforeach
			<!-- <div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" style='padding:10px;'>
				<img class='img-responsive' src="/image/large/{{ $room->roomImages[0]->photo->filename}}">	
			</div>
			<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" style='padding:10px;'>
				<img class='img-responsive' src="/image/large/{{ $room->roomImages[0]->photo->filename}}">	
			</div>
			<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" style='padding:10px;'>
				<img class='img-responsive' src="/image/large/{{ $room->roomImages[0]->photo->filename}}">	
			</div><div class="col-xs-6 col-sm-6 col-md-4 col-lg-4" style='padding:10px;'>
				<img class='img-responsive' src="/image/large/{{ $room->roomImages[0]->photo->filename}}">	
			</div>
		-->
	</div>
</div>
</div>
<div class="col-xs-12 col-sm-12 col-md-7 col-lg-7">
	<p style='font-family:Open Sans;font-size:40px;margin:0;float:left;'>{{ $room->name }} </p>
	<button type="buttont" ng-click='bookThisRoom()' class="btn btn-success pull-right" style='margin:10px;'><span class="glyphicon glyphicon-glyphicon glyphicon-send" aria-hidden="true"></span> Book this room </button>
	<div class="clearfix">

	</div>
	<p style='font-family:Open Sans;font-size:30px;margin:0;color:green'>P {{ $room->price; }}</p>
	<P style='font-famoly:Open Sans;font-size:15px;color:#444'>Max Adult(s): 2 | Max Children: 0 | Bed(s): 0</P>
	<p>
		{{ $room->full_desc}}
	</p>
</div>

<div class="clearfix">
	
</div>		
@stop

@section('scripts')
<script type="text/javascript">
	$('.checkin').datepicker({
		format: 'yyyy-mm-dd',
		startDate: '0d'
	})
</script>
<script type="text/javascript">
	angular.module('giligansApp', [], function($interpolateProvider){
		$interpolateProvider.startSymbol('[[');
		$interpolateProvider.endSymbol(']]');
	}).controller('homeController', ['$scope','$http', function($scope, $http){
	//	alert('hey')
	$scope.hideForm = false;
	$scope.notAvailable = false;
	$scope.loading = false;
	$scope.reservation = null;
	$scope.bookThisRoom = function()
	{
		$('#book-this-room').modal('show')
	}
	$scope.booking = null;

	$scope.checkAvailability = function(date, nights, rooms)
	{
		$scope.loading = true;
		console.log(date,nights, rooms)
		$scope.booking = {
			checkin: date,
			nights : nights,
			quantity : rooms
		}
		$http.post('/room/{{ $room->id }}/availability', $scope.booking).success(function(data)
		{
			$scope.loading = false;
			console.log(data);
			if(data.status==0)
			{
				
				$scope.notAvailable = true;
				$scope.hideForm = false;
			}else
			{
				$scope.reservation = angular.copy(data);
				$scope.notAvailable = false;
				$scope.hideForm = true;
			}
		}).error(function()
		{
			$scope.loading = false;;
		});
	}
	
}])
</script>
@stop