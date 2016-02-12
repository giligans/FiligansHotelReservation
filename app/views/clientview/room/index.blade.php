@extends('layout.master')
@section('controller')
roomController
@stop
@section('styles')
{{ HTML::style('asset/styles/datepicker.css') }}
<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
@stop
@section('content')
<style type="text/css">
	h3{
		font-family:'Open Sans'
	}
	.roomtitle::first-letter, .pageheading::first-letter {
		color:red;
	}
	.pageheading {
		font-family: Open Sans;
		margin-left:20px;

	}
	table td{
		padding:5px;
	}
</style>
<div style='width:100%;padding:10px'>
	<h2 style="font-family: 'Oswald', sans-serif;">Rooms</h2>
	<hr>
</div>
<div class="modal fade" id="availability">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="modal-title">Check the room availability for room type:<span> [[ roomAvailability.name ]]</span></h3>
			</div>
			<div class="modal-body">
				<div ng-show='step1'>
					<center>Number of room</center>
					<div class="input-group number-spinner">
						<span class="input-group-btn">
							<button class="btn btn-default" data-dir="dwn" ng-click='subnight()'><span class="glyphicon glyphicon-minus"></span></button>
						</span>
						<input type="text" class="form-control text-center"  ng-model='nights'>
						<span class="input-group-btn">
							<button class="btn btn-default" data-dir="up" ng-click='addnight()'><span class="glyphicon glyphicon-plus"></span></button>
						</span>
					</div>
				</div>
				<p>
				</p>
				<p>
				</p>

				<table ng-hide='loading'>
					<thead>
						<tr>
							<th style='width:50%'>Check in:</th>
							<th style='width:50%'>No. of nights:</th>
						</tr>
					</thead>
					<tbody>
						<tr>

							<td><input type="text" class="input-sm form-control checkin" name="start" placeholder='Check In' ng-model='room.checkin'/></td>
							<td>
								<div class="input-group number-spinner">
									<span class="input-group-btn">
										<button class="btn btn-default" data-dir="dwn" ng-click='subnight()'><span class="glyphicon glyphicon-minus"></span></button>
									</span>
									<input type="text" class="form-control text-center"  ng-model='nights'>
									<span class="input-group-btn">
										<button class="btn btn-default" data-dir="up" ng-click='addnight()'><span class="glyphicon glyphicon-plus"></span></button>
									</span>
								</div>
							</td>
						</tr>
					</tbody>

				</table>

				<!-- <div class="alert alert-warning" style='margin-top:10px;margin-bottom:0px' ng-hide='loading || available==null'>
					<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
					You are about to stay for about <span class="label label-primary" ng-bind='nights'>1</span>  night(s) on <label class="label label-primary" ng-bind='displayInfo.checkin'>January 2, 2014</label> and will be checkout on <label class="label label-primary" ng-bind='displayInfo.checkout'>January 3</label> at 12 noon.
				</div> -->
				<div class="alert" ng-class='{"alert-success":available!=false, "alert-danger":available==false }'style='margin:10px;' ng-hide='loading || available==null'>

					<strong>Available!</strong> There are <span ng-bind='available'></span> rooms available. <label> <a href='' class='btn btn-success' ng-click='proceedReservation()'>Proceed to Reservation</a></label>
				</div>
				<center ng-show='loading'>
					<img src='{{ URL::to("images/loader.gif") }}'>
					<center>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-danger" ng-click='triggerCheckAvailability()' ng-disabled='loading || disableBtn'>		<span class="glyphicon glyphicon glyphicon-calendar" style='color:gold'></span> Check Availability</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<div class="container container-pad" id="property-listings"> 
			<div class="row">
				@foreach($room as $r)

				<div class="col-sm-12 col-xs-12 col-md-6 col-lg-6"> 

					<!-- Begin Listing: 609 W GRAVERS LN-->
					<div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing">
						<div class="media">
							<a class="pull-left" href="#" target="_parent">
								<img src="{{ URL::to('image/medium/'.$r->roomImages[0]->photo->filename.'/') }}" class='img-responsive img-thumbnail' style=''></a>

								<div class="clearfix visible-sm"></div>

								<div class="media-body fnt-smaller">
									<a href="#" target="_parent"></a>

									<h4 class="media-heading">
										<a href="#"> {{ $r->name}}</a><small class="pull-right">(<a href='' ng-click='checkAvailability({{ $r }})'>		<span class="glyphicon glyphicon glyphicon-zoom-in"></span> Check room availability</a>) </small></h4>


										<ul class="list-inline mrg-0 btm-mrg-10 clr-535353">
											<li>{{ $r->price }}</li>

											<li style="list-style: none">|</li>

											<li>{{ $r->max_children }} children </li>

											<li style="list-style: none">|</li>

											<li> {{ $r->max_adult }} adult</li>
										</ul>

										<p>

											{{ $r->short_desc }}
										</p><span class="fnt-smaller fnt-lighter fnt-arial">Features
										<span class="label label-info">Label</span></span>
									</div>
								</div>
							</div><!-- End Listing-->



						</div><!-- End row -->

						@endforeach
					</div>
				</div>
				@stop
				@section('scripts')
				{{ HTML::script('asset/scripts/client/room.js') }}
				{{ HTML::script('asset/scripts/moment.js') }}
				{{ HTML::script('asset/scripts/angular-moment.min.js') }}
				{{ HTML::script('asset/scripts/bootstrap-datepicker.js')}}

				<script type="text/javascript">
					$('.checkin').datepicker({
						format: 'mm/dd/yyyy',
						startDate: '-3d'
					})
				</script>
				@stop