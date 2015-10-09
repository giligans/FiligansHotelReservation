<!DOCTYPE html>
<html lang="" ng-app='liveMonitoringApp'>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Filigans Hotel Reservation Live Monitoring</title>
	<!-- Bootstrap CSS -->
	<link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet">
	<style type="text/css">
		.available
		{
			border:2px solid green;color:green;
		}
		.available .item
		{
			background-color:green;
		}

		.pending 
		{
			border:2px solid red;color:gold;
		}
		.pending .item
		{
			background-color:gold;
		}
		.overdue
		{
			border:2px solid black;color:black;
		}
		.overdue .item
		{
			background-color:black;
		}
		.unavailable
		{
			border:2px solid red;color:red;
		}
		.unavailable .item
		{
			background-color:red;
		}
	</style>
</head>
<body ng-controller='indexCtrl'>

	<!-- modals -->

	<!-- end of modals -->
	<div class="container-fluid">
		<div class="row">
			<nav class="navbar navbar-default" role="navigation">
				<div class="container">
					<!-- Brand and toggle get grouped for better mobile display -->
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">Filigans Hotel Reservation Live Monitoring</a>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse navbar-ex1-collapse">
						<ul class="nav navbar-nav">
							<li><a href="/adminsite">Back to Adminsite</a></li>
							<li><a href="/adminsite/booking">Create booking</a></li>
						</ul>
						<!-- <ul class="nav navbar-nav navbar-right">
							<li><a href="#">Link</a></li>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown">Dropdown <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
									<li><a href="#">Separated link</a></li>
								</ul>
							</li>
						</ul> -->
					</div><!-- /.navbar-collapse -->
				</div>
			</nav>
		</div>
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8" style='padding-lef;'>
				<h2 style='text-shadow: 3px 1px 5px rgba(150, 150, 150, 1);color:maroon;'>Rooms
				<input type='text' class='form-control' style='border:2px solid #d8d8d8' placeholder='Search Room' ng-model='searchRoom'>
				</h2>
				<hr style='margin:5px;' >
				<div ng-repeat='room in rooms | filter:searchRoom' style='width:230px;margin:3px;border:2px solid #355798;padding:5px;float:left;'>
					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" >
						<h4 ng-bind='room.name'>Room Type</h5>
						</div>

						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style='background-color:green;height:30px;color:white;padding:5px;text-align:center' ng-bind='room.available'>

						</div>
						<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2" style='background-color:red;height:30px;color:white;padding:5px;text-align:center' ng-bind='room.unavailable'>

						</div>
						<div class="clearfix">

						</div>
						<div ng-click='processBooking(r)' ng-class="{'available': r.room_reserved.length==0 || r.room_reserved.length > 0 && (r.room_reserved[0].status==5 || r.room_reserved[0].status==3), 'unavailable' : r.room_reserved.length > 0 && (r.room_reserved[0].status==1 || r.room_reserved[0].status==2 ), 'pending' : r.room_reserved.length > 0 && r.room_reserved[0].status==0, 'overdue' : r.room_reserved.length > 0 && r.room_reserved[0].status==6 }" ng-repeat='r in room.room_qty' style='cursor:pointer;font-weight:bold;margin-top:2px;'>
							<div class="container-fluid">
								<div  class='row' style='height:30px;display:block;'>
									<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 item" style='text-align:center;color:white;padding:3px;'>
										RM<span ng-bind='r.room_no'>100</span> 
									</div>
									<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 text-center" style='padding:3px; text-shadow:
									-1px -1px 0 #444,
									1px -1px 0 #444,
									-1px 1px 0 #444,
									1px 1px 0 #444;'>
									<span ng-bind='r.room_reserved[0].statusStr || "Available"'> </span>
								</div>

							</div>
							<div class="row clearfix" ng-hide='r.room_reserved.length == 0 || r.room_reserved.length >0 && (r.room_reserved[0].status==5 || r.room_reserved[0].status==3 )' style='text-align:center;background-color:#d8d8d8;border-top:2px solid #444;margin-top:-4px;color:#444;font-weight:100;color:red'>

								C/O: <span ng-bind='r.room_reserved[0].checkoutdate'></span> 
							</div>
						</div>
						<!-- <div style='display:block;border-top: solid #777;height:20px;width:100%;margin-top:-4px;background-color:#d8d8d8;text-align:center;color:#444;font-weight:100;color:maroon'>
							
					</div> -->

				</div>
				
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4" style='height:500px;border-left:2px solid #d8d8d8'>
			
			<h2 style='text-shadow: 3px 1px 5px rgba(150, 150, 150, 1);color:maroon;'>Statistics <small>Today</small></h2>
			<hr style='margin:5px;'>
			<div style='margin-top:3px;border:2px solid #d8d8d8;height:40px;font-weight:bold;font-size:20px;color:#444'>
				<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center" style='color:rgb(130, 207, 244);padding:5px;height:100%;background-color:#d8d8d8; text-shadow:
				-1px -1px 0 #444,
				1px -1px 0 #444,
				-1px 1px 0 #444,
				1px 1px 0 #444;'>

				<span ng-bind='statistics.success.length'>00</span>
			</div>
			<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style='padding:5px;'>
				Successful Bookings

			</div>
		</div>
		<div style='margin-top:3px;border:2px solid #d8d8d8;height:40px;font-weight:bold;font-size:20px;color:#444'>
			<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center" style='color:rgb(130, 207, 244);padding:5px;height:100%;background-color:#d8d8d8; text-shadow:
			-1px -1px 0 #444,
			1px -1px 0 #444,
			-1px 1px 0 #444,
			1px 1px 0 #444;'>
			<span ng-bind='statistics.pending.length'>00</span>
		</div>
		<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style='padding:5px;'>
			Pending Bookings

		</div>
	</div>


	<div style='margin-top:3px;border:2px solid #d8d8d8;height:40px;font-weight:bold;font-size:20px;color:#444'>
		<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center" style='color:rgb(130, 207, 244);padding:5px;height:100%;background-color:#d8d8d8; text-shadow:
		-1px -1px 0 #444,
		1px -1px 0 #444,
		-1px 1px 0 #444,
		1px 1px 0 #444;'>
		<span ng-bind='statistics.arrival.length'>00</span>
	</div>
	<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style='padding:5px;'>
		Arrival Bookings

	</div>
</div>

<div style='margin-top:3px;border:2px solid #d8d8d8;height:40px;font-weight:bold;font-size:20px;color:#444'>
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center" style='color:rgb(130, 207, 244);padding:5px;height:100%;background-color:#d8d8d8; text-shadow:
	-1px -1px 0 #444,
	1px -1px 0 #444,
	-1px 1px 0 #444,
	1px 1px 0 #444;'>
	<span ng-bind='statistics.occupied.length'>00</span>
</div>
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style='padding:5px;'>
	Occupied Bookings

</div>
</div>

<div style='margin-top:3px;border:2px solid #d8d8d8;height:40px;font-weight:bold;font-size:20px;color:#444'>
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center" style='color:rgb(130, 207, 244);padding:5px;height:100%;background-color:#d8d8d8; text-shadow:
	-1px -1px 0 #444,
	1px -1px 0 #444,
	-1px 1px 0 #444,
	1px 1px 0 #444;'>
	<span ng-bind='statistics.departure.length'>00</span>
</div>
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style='padding:5px;'>
	Departure Bookings

</div>
</div>

<div style='margin-top:3px;border:2px solid #d8d8d8;height:40px;font-weight:bold;font-size:20px;color:#444'>
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center" style='color:rgb(130, 207, 244);padding:5px;height:100%;background-color:#d8d8d8; text-shadow:
	-1px -1px 0 #444,
	1px -1px 0 #444,
	-1px 1px 0 #444,
	1px 1px 0 #444;'>
	<span ng-bind='statistics.preparing.length'>00</span>
</div>
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style='padding:5px;'>
	Preparing Bookings

</div>
</div>


<div style='margin-top:3px;border:2px solid #d8d8d8;height:40px;font-weight:bold;font-size:20px;color:#444'>
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center" style='color:rgb(130, 207, 244);padding:5px;height:100%;background-color:#d8d8d8; text-shadow:
	-1px -1px 0 #444,
	1px -1px 0 #444,
	-1px 1px 0 #444,
	1px 1px 0 #444;'>
	<span ng-bind='statistics.cancelled.length'>00</span>
</div>
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style='padding:5px;'>
	Cancelled Bookings

</div>
</div>


<div style='margin-top:3px;border:2px solid #d8d8d8;height:40px;font-weight:bold;font-size:20px;color:#444'>
	<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-center" style='color:rgb(130, 207, 244);padding:5px;height:100%;background-color:#d8d8d8; text-shadow:
	-1px -1px 0 #444,
	1px -1px 0 #444,
	-1px 1px 0 #444,
	1px 1px 0 #444;'>
	<span ng-bind='statistics.overdue.length'>00</span>
</div>
<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style='padding:5px;'>
	Overdue Booking

</div>
</div>




</div>
</div>
</div><!-- end of container fluid -->
<!-- jQuery -->
<script src="//code.jquery.com/jquery.min.js"></script>
<!-- Bootstrap JavaScript -->
<script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src='https://ajax.googleapis.com/ajax/libs/angularjs/1.2.28/angular.min.js'></script>
{{ HTML::script('admin/asset/js/livemonitoring.js') }}
</body>
</html>