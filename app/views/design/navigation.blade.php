<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Title Page</title>

	<!-- Bootstrap CSS -->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	{{ HTML::style('asset/styles/responsiveslides.css') }}
	<!-- Latest compiled and minified JS -->
	<script src="//code.jquery.com/jquery.js"></script>
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Oswald' rel='stylesheet' type='text/css'>
	{{ HTML::script('asset/scripts/responsiveslides.min.js') }}
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
	<style type="text/css">
		.container-content{
			max-width:960px;
			margin:0 auto;
			padding:10px;
			padding-top:0px;
			-webkit-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
			-moz-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
			box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
		}
	</style>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
		</head>
		<body style='background: url({{ URL::to("images/background/texture3.png") }})'>
			<div class='container' style='width:100%'>
				<div class="row" style='min-height:50px;'>

					<div class="row" style='background: url({{ URL::to("images/background/texture4.png") }});min-height:30px'>
						<div class="container">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style='padding:0px'>
								<button type="button" class="btn btn-xs btn-success pull-right" style='margin:5px;margin-left:10px'>RESERVE ROOM</button>
								<span style='color:white;font-size:20px;font-family:Open Sans' class='pull-right'>Call us at 8700 for inquiry</span> 
							</div>
						</div>
					</div>
					<div class="row">

						<nav class="navbar navbar-default hidden-xs hidden-sm" role="navigation">
							<div class="container">
								<div style='height:100px;width:300px;background:url({{ URL::to("images/background/texture2.png") }});position:absolute;top:-35px;padding:15px;padding-top:0px;-webkit-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
								-moz-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
								box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);'>

								<a href='{{ URL::to("/")}}'><img src="http://www.giligansrestaurant.com/site/images/gililogo.png"></a>
							</div>
							<!-- Brand and toggle get grouped for better mobile display -->

							<ul class="nav navbar-nav navbar-right">
								<li><a href="#">Home</a></li>
								<li><a href="#">Rooms</a></li>
								<li><a href="#">Features and Services</a></li>
								<li><a href="#">About</a></li>
								<li><a href="#">Contact</a></li>

							</ul>
						</div><!-- /.navbar-collapse -->
					</div>
				</nav>

				<nav class="navbar navbar-default visible-xs visible-sm" role="navigation">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div style='height:100px;width:100%;background:url({{ URL::to("images/background/texture2.png") }});padding-left:20px;padding-top:0px;-webkit-box-shadow: 0px 3px 18px -1px rgba(0,0,0,0.75);
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

				<!-- Collect the nav links, forms, and other content for toggling -->
				<div class="collapse navbar-collapse navbar-ex1-collapse">

					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Home</a></li>
						<li><a href="#">Rooms</a></li>
						<li><a href="#">Features and Services</a></li>
						<li><a href="#">About</a></li>
						<li><a href="#">Contact</a></li>

					</ul>
				</div><!-- /.navbar-collapse -->
			</nav>


		</div>
	</div>

</div>
<div class="container-content" style='margin-top:20px;background-color:White'>
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
							<img src="{{ URL::to('images/test/1.jpg') }}" alt="">

						</li>
						<li>
							<img src="{{ URL::to('images/test/2.jpg') }}" alt="">
						</li>
						<li>
							<img src="{{ URL::to('images/test/3.jpg') }}" alt="">

						</li>
					</ul>

				</div>
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style='background-color:black;padding:10px'>
				<div class="row">
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<input type='text' class='form-control' placeholder='Check in date'>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" >
						<input type='text' class='form-control' placeholder='No of nights'>
					</div>
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
						<button type="button" class="btn btn-large btn-block btn-danger">Check Room Availability</button>
					</div>
				</div>
				<!--
				<p style='color:white'>
					"Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum."
				</p> -->

			</div>
		</div>
	</div>

	<div class="container-content" style='min-height:100px;background-color:white;margin-top:10px;padding:20px;margin-bottom:30px' >
		<h2 style="font-family: 'Oswald', sans-serif;">Rooms</h2>
		<hr style='border-top:2px solid #d8d8d8'>

	</div>
	<!-- jQuery -->

	<!-- Bootstrap JavaScript -->


</body>
</html>

