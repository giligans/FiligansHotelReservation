<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>title Page</title>
	<style type="text/css">

		body
		{
			background-image:url('/images/loginbg.png');
		}
		.container{
			/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#f9fcf7+0,f5f9f0+100;L+Green+3D */
			background: rgb(249,252,247); /* Old browsers */
			background: -moz-radial-gradient(center, ellipse cover, rgba(249,252,247,1) 0%, rgba(245,249,240,1) 100%); /* FF3.6-15 */
			background: -webkit-radial-gradient(center, ellipse cover, rgba(249,252,247,1) 0%,rgba(245,249,240,1) 100%); /* Chrome10-25,Safari5.1-6 */
			background: radial-gradient(ellipse at center, rgba(249,252,247,1) 0%,rgba(245,249,240,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f9fcf7', endColorstr='#f5f9f0',GradientType=1 ); /* IE6-9 fallback on horizontal gradient */
			border:2px solid #d8d8d8;
			width:450px !important;

			margin:0 auto;
			margin-top:100px;
			padding:50px 10px 50px 10px;
		}

		.form-control
		{
			border:2px solid #B3B3B3 !important;
		}
		.form-item
		{
			margin-bottom:10px;
		}

	</style>
	<!-- Bootstrap CSS -->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	
</head>
<body>

	<div class="container">
	<center>
	<span class="glyphicon glyphicon-glyphicon glyphicon-briefcase" aria-hidden="true" style='font-size:50px;color:rgb(156, 189, 156)'></span>
		<h1 Style='margin:0 0 20px 0;color:rgb(113, 187, 113)'>get started...</h1>
		</center>

		@if(Session::has('error'))
			<div class="alert alert-danger" style='margin:10px'>
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Error!</strong> {{ Session::get('error') }}
			</div>
			@endif
		<form class="form-signin" action='{{ URL::to("login") }}' method='POST'>	
			<div class='form-item'>
				<label>Enter your username</label>
				<input type="text" class="form-control" name='username' placeholder="Enter username" required="" autofocus="">
			</div>
			<div class='form-item'>
				<label>Enter your password</label>
				<input type="password" class="form-control" name='password' placeholder="Enter password" required="">
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">
				<span class="glyphicon glyphicon-glyphicon glyphicon-log-in" aria-hidden="true"></span> Sign In
			</button>
			
		</form>

	</div>
	<!-- jQuery -->
	<script src="//code.jquery.com/jquery.min.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
</body>
</html>