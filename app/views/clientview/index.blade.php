@extends('layout.master')
@section('header')
<div class="jumbotron" style='border-radius:0' style="" ng-controller='indexCtrl'>
	<div class="row">
		<div class='col-md-offset-9 col-md-3 col-sm-12' id='availability' style='padding:0px'>
			<div style='position:absolute;width:100%;height:100%;background-color:black;opacity:0.4'>
			</div>
			<div style='position:relative;position:relative;z-index:1000;'>
				<h4 style='width:100%;background-color:rgb(18, 19, 18);padding:10px;margin-top:-10px'>Room Booking</h4>
				<form method='POST' action='{{ URL::to("room/availability") }}'>
					<div style='padding:10px;padding-top:0px'>
						<label style='color:white;font-family:Open Sans'>Check
							<!-- <span style='color:rgb(83, 255, 83)'>IN</span> -->
							<span class="label label-success" style='letter-spacing: 5px;'>IN</span>
						</label>
						<input type="date" class='form-control' placeholder='Pick a date'  id="input" name='checkin' class="form-control" required="required" title="">
						<label style='font-family:Open Sans;color:white'>Check
							<!-- <span style='color:rgb(255, 54, 54)'>OUT</span> -->
							<span class="label label-danger">OUT</span>
						</label>
						<input type="date"  id="input" class="form-control" name='checkout' required="required" title="">
						<button type="submit" class="btn btn-large btn-block btn-success" style='margin-top:10px;font-family:Open Sans;text-shadow: 4px 2px 2px rgba(154, 150, 150, 0.97);'>		CHECK AVAILABILITY</button>								
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<div class="row" style='padding:10px;background-color:white;margin:0px;margin-top:-30px;-webkit-box-shadow: 0px 10px 23px -8px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 10px 23px -8px rgba(0,0,0,0.75);
box-shadow: 0px 10px 23px -8px rgba(0,0,0,0.75);'>
<h3 style='font-family:Open Sans'>Website slogan</h3>
<small>"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."</small><button type="button" class="btn btn-sm btn-primary" style='margin-left:10px;'>Read More</button>
</div>
@stop
@section('content')
<div class="col-xs-12 col-sm-12  col-lg-4">
	<img src="{{ URL::to('images/room/room1.jpg') }}" class='img-responsive img-thumbnail' style=''>
	<h3 style='margin:5px;font-family:Open Sans'><span>S</span>ervices</h3>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<img src="{{ URL::to('images/room/room2.jpg') }}" class='img-responsive img-thumbnail' style=''>
	<h3 style='margin:5px;font-family:Open Sans'><span>S</span>ervices</h3>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>
<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
	<img src="{{ URL::to('images/room/room3.jpg') }}" class='img-responsive img-thumbnail' style=''>
	<h3 style='margin:5px;font-family:Open Sans'><span>S</span>ervices</h3>
	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
</div>

</div>
@stop
@section('scripts')
{{ HTML::script('asset/scripts/client/index.js') }}
@stop