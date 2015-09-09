<!DOCTYPE html>
<html lang="" ng-app='giligansApp'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Title Page</title>
	<!-- Bootstrap CSS -->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
	<script src="http://lipis.github.io/bootstrap-sweetalert/lib/sweet-alert.js"></script>
	<link rel="stylesheet" href="http://lipis.github.io/bootstrap-sweetalert/lib/sweet-alert.css">
	{{ HTML::style('asset/styles/style.css') }}
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
			<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
			@yield('styles')
			<style type="text/css">
				body {
					padding-top: 20px;
				}
				#availability h4	{
					color:white;
					font-family: Open Sans;
				}
				h3 span{
					color:Red;
					text-transform: uppercase;
				}
				.footer {
					padding-top: 40px;
					padding-bottom: 40px;
					margin-top: 40px;
					border-top: 1px solid #eee;
				}
				/* Main marketing message and sign up button */
				.jumbotron {
					border-radius: 0px;
					background-image:url('https://phgcdn.com/images/uploads/MLAEH/corporatemasthead/grand-hotel-excelsior_masthead.jpg');
					background-size:cover;
				}
				
				/* Customize the nav-justified links to be fill the entire space of the .navbar */
				.nav-justified {
					background-color: #eee;
					border: 1px solid #ccc;
					border-radius: 0px;
				}
				.nav-justified > li > a {
					padding-top: 15px;
					padding-bottom: 15px;
					margin-bottom: 0;
					font-weight: bold;
					color: #777;
					text-align: center;
					background-color: #e5e5e5; /* Old browsers */
						/*	background-image: -webkit-gradient(linear, left top, left bottom, from(#f5f5f5), to(#e5e5e5));
					background-image: -webkit-linear-gradient(top, #f5f5f5 0%, #e5e5e5 100%);
					background-image:      -o-linear-gradient(top, #f5f5f5 0%, #e5e5e5 100%);
					background-image: -webkit-gradient(linear, left top, left bottom, from(top), color-stop(0%, #f5f5f5), to(#e5e5e5));
					background-image:         linear-gradient(top, #f5f5f5 0%, #e5e5e5 100%);
					filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f5f5', endColorstr='#e5e5e5',GradientType=0 ); /* IE6-9 */
					background-repeat: repeat-x; /* Repeat the gradient */
					border-bottom: 1px solid #d5d5d5;
				}
				.nav-justified > .active > a,
				.nav-justified > .active > a:hover,
				.nav-justified > .active > a:focus {
					background-color: #ddd;
					background-image: none;
					-webkit-box-shadow: inset 0 3px 7px rgba(0,0,0,.15);
					box-shadow: inset 0 3px 7px rgba(0,0,0,.15);
				}
				.nav-justified > li:first-child > a {
					/*border-radius: 5px 5px 0 0;*/
				}
				.nav-justified > li:last-child > a {
					border-bottom: 0;
					/*border-radius: 0 0 5px 5px;*/
				}
				@media (min-width: 768px) {
					.container {
						width:960px;
					}
					.nav-justified {
						max-height: 52px;
					}
					.nav-justified > li > a {
						border-right: 1px solid #d5d5d5;
						border-left: 1px solid #fff;
					}
					.nav-justified > li:first-child > a {
						border-left: 0;
						/*border-radius: 5px 0 0 5px;*/
					}
					.nav-justified > li:last-child > a {
						border-right: 0;
						border-radius: 0 5px 5px 0;
					}
				}
				/* Responsive: Portrait tablets and up */
				@media screen and (min-width: 768px) {
					/* Remove the padding we set earlier */
					.masthead,
					.marketing,
					.footer {
						padding-right: 0;
						padding-left: 0;
					}
				}</style>
			</head>
			@yield('initializeData')
			<body style='background-image: url({{ URL::to("images/background/texture1.png")}} )' ng-controller='@yield("controller")'>
				<div class="container" style='background-image: url("{{ URL::to("images/background/texture3.png")}} ") black;margin-top:-20px;padding:30px;
				-webkit-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
				-moz-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
				box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);'>
				<div class="row" style=''>
					<a href='{{ URL::to("/")}}'><img src="http://www.giligansrestaurant.com/site/images/gililogo.png">
					</a>
					<div class='pull-right' style='padding:10px;margin-top:10px;'>
						<div class="row" style="font-family:Open Sans;font-size:25px;text-align:right">
							Book online or call us <span style='color:Red'>1800-528-8512</span>
						</div>
						<div class="row">
							<small class='pull-right'>Some City, Some Address</small>
						</div>
					</div>
				</div>
				@if($cpage != 'booking')
				<div class="masthead">
					<div role="navigation">
						<ul class="nav nav-justified">
							<li><a href="#">Home</a></li>
							<li><a href="#">About Us</a></li>
							<li><a href="#">Rooms</a></li>
							<li><a href="#">Services</a></li>
							<li><a href="#">Restaurant</a></li>
							<li><a href="#">Maps</a></li>
							<li><a href="#">Booking</a></li>
							<!-- <li><a href="#">BOOKING</a></li> -->
						</ul>
					</div>
				</div>
				@endif
				<!-- Jumbotron -->
				@yield('header')	
			</div>
			<div class="container" style='background-color:white;
			-webkit-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
			-moz-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
			box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);'>
			<!-- Example row of columns -->
			<div class="row" style='margin-top:20px;'>
				@yield('content')
					<!-- <div class="col-lg-4">
									<h2>Safari bug warning!</h2>
									<p class="text-danger">As of v8.0, Safari exhibits a bug in which resizing your browser horizontally causes rendering errors in the justified nav that are cleared upon refreshing.</p>
									<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
									<p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
					</div>
					<div class="col-lg-4">
									<h2>Heading</h2>
									<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
									<p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
					</div>
					<div class="col-lg-4">
									<h2>Heading</h2>
									<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
									<p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
					</div>
					<div class="col-lg-4">
									<h2>Heading</h2>
									<p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
									<p><a class="btn btn-primary" href="#" role="button">View details &raquo;</a></p>
								</div> -->
							</div>
							<!-- Site footer -->
							<footer class="footer">
								<p>&copy; GILIGANS PH 2014
									<span class='pull-right'>Contact us: <span style='color:red'>1800-528-8512 </span></p>
								</footer>
							</div> <!-- /container -->
							<!-- jQuery -->
							<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
							<!-- Bootstrap JavaScript -->
							<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
							<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/angularjs/1.2.28/angular.min.js'></script>
							{{ HTML::script('asset/scripts/ui-bootstrap-tpls-0.12.0.min.js') }}
							@yield('scripts')
						</body>
						</html>