<!DOCTYPE html>
<html lang="" ng-app='giligansApp'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title', 'Filigans | Make Reservations Online')</title>
	<!-- Bootstrap CSS -->
	<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet"> -->
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
	{{ HTML::style('asset/styles/responsiveslides.css') }}
	<!-- Latest compiled and minified JS -->	
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://lipis.github.io/bootstrap-sweetalert/lib/sweet-alert.css">
	{{ HTML::style('asset/styles/datepicker.css') }}
	@yield('styles')
	<style type="text/css">
		[ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
			display: none !important;
		}
		
		.container-content{
			max-width:960px;
			margin:0 auto;
			padding:10px;
			padding-top:0px;
			-webkit-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
			-moz-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
			box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
		}
		.footer {
			position: fixed;
			bottom: 0;
			color:white;
			width: 100%;
			height: 60px;
			background :url({{ URL::to("images/background/texture4.png") }});
		}
	</style>
	
</head>
@yield('initializeData')
<body style='background: url({{ URL::to("images/background/texture3.jpg") }})' ng-controller='@yield("controller")'>
	<div class='loadingIndicator' style='width:100%;height:100%;position:absolute;top:0;left:0;'>
		<div style='width:100%;height:100%;position:fixed;top:0;left:0;background-color:black;z-index:10000;opacity:0.5'>
		</div>
		<div style='padding-top:100px;position:relative;z-index:20000;'>
			<center>
				<h3 class='text-center' style='color:white;'> Loading...</h3>
				<img src='{{ URL::to("images/loader2.gif") }}'>
			</center>
		</div>
	</div>
	<div class='container-fluid'>
		<div class="row">
			<div class="row" style='background: url({{ URL::to("images/background/texture4.jpg") }});min-height:30px'>
				<div class="container">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style='padding:0px'>
						<a  href='{{ URL::to("booking") }}' class="btn btn-xs btn-success pull-right" style='margin:5px;margin-left:10px'>RESERVE ROOM</a>
						<span style='color:white;font-size:20px;font-family:Open Sans' class='pull-right'>Call us at 8700 for inquiry</span>
					</div>
				</div>
			</div>
			<div class="row">
				<nav class="navbar navbar-default hidden-xs hidden-sm" role="navigation">
					<div class="container">
						<div style='height:100px;width:300px;background:url({{ URL::to("images/background/texture2.jpg") }}) black;position:absolute;top:-35px;padding:15px;padding-top:0px;-webkit-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
						-moz-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
						box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);'>
						<a href='{{ URL::to("/")}}'><img src="http://www.giligansrestaurant.com/site/images/gililogo.png"></a>
					</div>
					<!-- Brand and toggle get grouped for better mobile display -->
					<ul class="nav navbar-nav navbar-right">
						<li><a href="{{ URL::to('/')}}">Home</a></li>
						<li><a href="{{ URL::to('room')}}">Rooms</a></li>
						<li><a href="{{ URL::to('gallery')}}">Gallery</a></li>
						<li><a href="{{ URL::to('services')}}">Services</a></li>
						<li><a href="{{ URL::to('about')}}">About</a></li>
						<li><a href="{{ URL::to('contact')}}">Contact</a></li>
					</ul>
				</div><!-- /.navbar-collapse -->
			</nav>
		</div>
		<nav class="navbar navbar-default visible-xs visible-sm" role="navigation">
			<!-- Brand and toggle get grouped for better mobile display -->
			<div style='height:100px;width:100%;background:url({{ URL::to("images/background/texture2.png") }}) black;padding-left:20px;padding-top:0px;-webkit-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
			-moz-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
			box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);'>
			<a href='{{ URL::to("/")}}'><img class='img-responsive' src="http://www.giligansrestaurant.com/site/images/gililogo.png"></a>
		</div>
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Giligans Hotel</a>
		</div>
		
		<div class="collapse navbar-collapse navbar-ex1-collapse">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="#">Home</a></li>
				<li><a href="#">Rooms</a></li>
				<li><a href="#">Features and Services</a></li>
				<li><a href="#">About</a></li>
				<li><a href="#">Contact</a></li>
			</ul>
		</div>
	</nav>
</div>
</div>
</div>
@if($cpage =='home')
<div class="container-fluid container-content" style='margin-top:10px;background-color:White'>
	<div class="row" style='padding:10px;padding-top:5px'>
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style='padding:0px'>
			<div class="callbacks_container">
									<!-- 	<div style='position:absolute;height:50px;width:100%;z-index:1000;top:50px;'>
											<div style='position:Absolute;height:50px;width:100%;background-color:black;opacity:0.4'>
											</div>
											<div style='position:absolute;z-index:1000;height:50px;width:100%;color:white'>
											</div>
										</div> -->
										<ul class="rslides" id="slider4">
											<li>
												<img src="{{ URL::to('image/full_image/1.jpg') }}" alt="">
											</li>
											<li>
												<img src="{{ URL::to('image/full_image/2.jpg') }}" alt="">
											</li>
											<li>
												<img src="{{ URL::to('image/full_image/3.jpg') }}" alt="">
											</li>
										</ul>
									</div>
								</div>
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style='background-color:black;padding:10px'>
									<div class="row">
										<form action='{{ URL::to("booking/step1") }}' method='POST'>
											<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
												<input type='text' class='form-control checkin' placeholder='Your Check-in Date' value="{{ date('Y-m-d')}}" name='checkin' required>
											</div>
											<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" >
												<input type='text' class='form-control checkout' placeholder='Your Check-out Date' value="{{ date('Y-m-d', strtotime('+1 day'))}}" name='checkout' required>
											</div>
											<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
												<button type="submit" class="btn btn-large btn-block btn-danger">Check Room Availability</button>
											</div>
										</form>
									</div>
								<!--
								<p style='color:white'>
									"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
								</p> -->
							</div>
						</div>
					</div>
					@endif
					<div class="container-content" style='min-height:100px;background-color:white;margin-top:10px;padding:20px;margin-bottom:30px'>
						
						@yield('content')
					</div>
					<!-- <footer class="footer">
						<div class="container" style='width:960px'>
							sdfs
						</div>
					</footer> -->
					<script src="//code.jquery.com/jquery.min.js"></script>
					<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/angularjs/1.2.28/angular.min.js'></script>
					{{ HTML::script('asset/scripts/ui-bootstrap-tpls-0.12.0.min.js') }}
					{{ HTML::script('asset/scripts/responsiveslides.min.js') }}
					{{ HTML::script('asset/scripts/moment.js') }}
					{{ HTML::script('asset/scripts/angular-moment.min.js') }}
					{{ HTML::script('asset/scripts/bootstrap-datepicker.js')}}
					<script src="http://lipis.github.io/bootstrap-sweetalert/lib/sweet-alert.js"></script>
					<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
					<script>
						$(function () {
							$("#slider4").responsiveSlides({
								maxwidth: 960,
								pager: false,
								//nav: true,
								speed: 500,
								namespace: "callbacks",
								before: function () {
									$('.events').append("<li>before event fired.</li>");
								},
								after: function () {
									$('.events').append("<li>after event fired.</li>");
								}
							});
						});
					</script>
					@yield('scripts')
					<script type="text/javascript">
						$(document).ready(function () {
							setTimeout(function()
							{
								$('.loadingIndicator').fadeOut();
							},500)
						});
					</script>
				</body>
				</html>