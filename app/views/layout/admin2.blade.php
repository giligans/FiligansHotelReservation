<!DOCTYPE html>
<html lang="" ng-app='adminApp'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title','Admin Site')</title>
	<!-- Bootstrap CSS -->

	<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
	{{ HTML::style('admin/asset/css/spacelab.css') }}
	<!-- 	<link rel="stylesheet" type="text/css" href="http://bootswatch.com/spacelab/bootstrap.min.css"> -->

	<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300' rel='stylesheet' type='text/css'>
	<script src="http://lipis.github.io/bootstrap-sweetalert/lib/sweet-alert.js"></script>
	<link rel="stylesheet" href="http://lipis.github.io/bootstrap-sweetalert/lib/sweet-alert.css">
	{{ HTML::style('admin/asset/css/admin.css') }}
	{{ HTML::style('asset/styles/datepicker.css') }}
	@yield('styles')
	<style type="text/css">
		[ng\:cloak], [ng-cloak], .ng-cloak {
			display: none !important;
		}
		.nav-sidebar {
			width: 100%;
			padding: 8px 0;
			border-right: 1px solid #ddd;
		}
		.nav-sidebar a {
			color: #333;
			-webkit-transition: all 0.08s linear;
			-moz-transition: all 0.08s linear;
			-o-transition: all 0.08s linear;
			transition: all 0.08s linear;
			-webkit-border-radius: 4px 0 0 4px;
			-moz-border-radius: 4px 0 0 4px;
			border-radius: 4px 0 0 4px;
		}
		.nav-sidebar .active a {
			cursor: default;
			background-color: #428bca;
			color: #fff;
			text-shadow: 1px 1px 1px #666;
		}
		.nav-sidebar .active a:hover {
			background-color: #428bca;
		}
		.nav-sidebar .text-overflow a,
		.nav-sidebar .text-overflow .media-body {
			white-space: nowrap;
			overflow: hidden;
			-o-text-overflow: ellipsis;
			text-overflow: ellipsis;
		}
		/* Right-aligned sidebar */
		.nav-sidebar.pull-right {
			border-right: 0;
			border-left: 1px solid #ddd;
		}
		.nav-sidebar.pull-right a {
			-webkit-border-radius: 0 4px 4px 0;
			-moz-border-radius: 0 4px 4px 0;
			border-radius: 0 4px 4px 0;
		}
	</style>
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
			<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
			<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
			<![endif]-->
		</head>
		@yield('initializeData')
		<body style='background-image:url({{ URL::to("images/background/texture_admin2.png") }})' ng-controller='@yield("controller")'>
			<nav class="navbar navbar-inverse" style='border-radius:0;
			-webkit-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.75);
			-moz-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.75);
			box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.75);'>
			<div class="container">
				<a class="navbar-brand" href="#">Hotel Backend Panel</a>
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#">Logout</a></li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">You are logged in as admin <b class="caret"></b></a>
						<ul class="dropdown-menu">
							<li><a href="{{ URL::to('adminsite/account')}}">My Account</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</nav>
		<div class="container" style='min-height:200px;background-color:white;padding-top:10px;margin-top:-10px;
		margin-bottom:20px;padding-bottom:20px;
		-webkit-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.75);
		-moz-box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.75);
		box-shadow: 0px 0px 18px 0px rgba(0,0,0,0.75);
		'>
		<div class="row">
			@if($cpage != 'account')
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
				<nav class="nav-sidebar">
					<ul class="nav">
						<li
						@if($cpage == 'account')
						class="active"
						@endif
						><a href="{{ URL::to('adminsite') }}">		<span class="glyphicon glyphicon glyphicon-dashboard"></span> Dashboard</a></li>
						<li
						@if($cpage == 'usermgt')
						class="active"
						@endif
						><a href="{{ URL::to('adminsite/user') }}">		<span class="glyphicon glyphicon glyphicon-user"></span>  User Management</a></li>
						<li
						@if($cpage == 'roommgt')
						class="active"
						@endif
						><a href="{{ URL::to('adminsite/room') }}">	<span class="glyphicon glyphicon glyphicon-credit-card"></span> Room Management</a></li>
						<li
						@if($cpage == 'discount')
						class="discounts"
						@endif
						><a href="{{ URL::to('adminsite/room') }}">	<span class="glyphicon glyphicon glyphicon-credit-card"></span> Discounts </a></li>

						<li
						@if($cpage == 'booklst')
						class="active"
						@endif
						><a href="{{ URL::to('adminsite/booking') }}">	<span class="glyphicon glyphicon glyphicon-list-alt"></span> Booking List</a></li>
						<li
						@if($cpage == 'activity')
						class="active"
						@endif
						><a href="{{ URL::to('adminsite/activity') }}">	<span class="glyphicon glyphicon glyphicon glyphicon-eye-open"></span> Activity Logs</a></li>
						<li
						@if($cpage == 'reports')
						class="active"
						@endif
						><a href="{{ URL::to('adminsite/reports') }}">		<span class="glyphicon glyphicon glyphicon-briefcase"></span> Reports</a></li>
						<li
						@if($cpage == 'settings')
						class="active"
						@endif
						><a href="{{ URL::to('adminsite/settings') }}">		<span class="glyphicon glyphicon glyphicon glyphicon-cog"></span> Settings</a></li>
						<li class="nav-divider"></li>
						<li><a href="javascript:;"><i class="glyphicon glyphicon-off"></i> Sign out</a></li>
					</ul>
				</nav>
			</div>
			@else
			@yield('accountcontent')
			@endif
			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" style='margin-left:0px'>
				@yield('content')	
			</div>
		</div>
	</div>
	<!-- jQuery -->
	<script src="//code.jquery.com/jquery.min.js"></script>
	<!-- Bootstrap JavaScript -->
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>
	<script type="text/javascript" src='http://underscorejs.org/underscore-min.js'></script>
	<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/angularjs/1.2.28/angular.min.js'></script>
	{{ HTML::script('asset/scripts/moment.js') }}
	{{ HTML::script('asset/scripts/angular-moment.min.js') }}
	{{ HTML::script('asset/scripts/ui-bootstrap-tpls-0.12.0.min.js') }}
	{{ HTML::script('admin/asset/js/admin.js') }}
	{{ HTML::script('admin/asset/js/angular-file-upload.min.js') }}
	{{ HTML::script('asset/scripts/bootstrap-datepicker.js')}}
	{{ HTML::script('admin/asset/js/dirPagination.js') }}
	@yield('scripts')
</body>
</html>