<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Title Page</title>

	<!-- Bootstrap CSS -->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	{{ HTML::style('asset/styles/style.css') }}
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
		</head>
		<body style='height:100%;'>
			<nav class="navbar navbar-default" role="navigation">
				<!-- Brand and toggle get grouped for better mobile display -->
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Giligans <span>HOTEL</span></a>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li><a href="#">HOME</a></li>
							<li><a href="#">ROOMS</a></li>
							<li><a href="#">FACILITIES</a></li>
							<li><a href="#">GALLERY</a></li>
							<li><a href="#">MAP</a></li>
							<li><button type="button" class="btn btn-success" style='margin-top:10px;'>BOOK NOW</button></li>
						</ul>
					</div><!-- /.navbar-collapse -->
				</div>
			</nav>
			<div class="" style='margin-top:-20px;'>
				<div class="row">
					<!-- Carousel -->
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<!-- <ol class="carousel-indicators">
							<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic" data-slide-to="2"></li>
						</ol> -->
						<!-- Wrapper for slides -->
						<div class="carousel-inner">
							<div class="item active">
								<img src="http://unsplash.s3.amazonaws.com/batch%209/barcelona-boardwalk.jpg" alt="First slide">
								<!-- Static Header -->

							</div>
							<div class="item">
								<img src="http://unsplash.s3.amazonaws.com/batch%209/barcelona-boardwalk.jpg" alt="Second slide">
								<!-- Static Header -->

							</div>
							<div class="item">
								<img src="http://unsplash.s3.amazonaws.com/batch%209/barcelona-boardwalk.jpg" alt="Third slide">
								<!-- Static Header -->

							</div>
						</div>

						<!-- Controls -->
			<!-- <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
		    	<span class="glyphicon glyphicon-chevron-left"></span>
			</a>
			<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
		    	<span class="glyphicon glyphicon-chevron-right"></span>
		    </a> -->
		</div><!-- /carousel -->

	</div>
	<div class="header-text hidden-xs">
		<div class="col-md-12 text-center">
			<h2 style='text-transform:uppercase;color:rgba(218, 49, 49, 1);font-weight:700'>
				Stay, Play & Party
				<br>in Style
			</h2>

			<h3>
				NEED A ROOM? MAKE A RESERVATION
				
			</h3>
			<br>
			<div class="">
				<a class="btn btn-theme btn-sm btn-min-block" href="#">Login</a><a class="btn btn-theme btn-sm btn-min-block" href="#">Register</a></div>
			</div>
		</div><!-- /header-text -->
		
</div>
	</div>

	<!-- jQuery -->
	<script src="//code.jquery.com/jquery.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/angularjs/1.2.27/angular.min.js'></script>
	{{ HTML::script('asset/scripts/ui-bootstrap-tpls-0.12.0.min.js') }}
	<script type="text/javascript">
		angular.module('hotelApp', ['ui.bootstrap'], function($interpolateProvider){
			$interpolateProvider.startSymbol('[[');
			$interpolateProvider.endSymbol(']]');
		})
		.controller('homeCtrl', ['$scope', function($scope){
		}])
	</script>
</body>
</html>