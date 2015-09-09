@extends('layout.master2')
@section('styles')
<style type="text/css">
	
	.stepwizard-step p {
		margin-top: 10px;
	}
	.stepwizard-row {
		display: table-row;
	}
	.stepwizard {
		display: table;
		width: 100%;
		position: relative;
	}
	.stepwizard-step button[disabled] {
		opacity: 1 !important;
		filter: alpha(opacity=100) !important;
	}
	.stepwizard-row:before {
		top: 14px;
		bottom: 0;
		position: absolute;
		content: " ";
		width: 100%;
		height: 1px;
		background-color: #ccc;
		z-order: 0;
	}
	.stepwizard-step {
		display: table-cell;
		text-align: center;
		position: relative;
	}
	.btn-circle {
		width: 30px;
		height: 30px;
		text-align: center;
		padding: 6px 0;
		font-size: 12px;
		line-height: 1.428571429;
		border-radius: 15px;
	}
</style>
@stop
@section('content')
<div class="row">
	<div class="stepwizard">
		<div class="stepwizard-row">
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle">1</button>
				<p>Checking availability</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle">2</button>
				<p>Choosing rooms</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-primary btn-circle" disabled="disabled">3</button>
				<p>Customer Information</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle" disabled="disabled">4</button>
				<p>Payment</p>
			</div>
			<div class="stepwizard-step">
				<button type="button" class="btn btn-default btn-circle" disabled="disabled">5</button>
				<p>DONE</p>
			</div>
		</div>
	</div>
</div>
<div class="row" style='margin-top:30px'>
	<div style='max-width:960px;margin:0 auto'>
		<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
			<center>
				<h2 style='font-family:"Oswald";float:right'>Please fill up the form.</h2>
				<div class="clearfix"></div>
				<small style='float:right'>You have choosen room(s)
					@foreach(Session::get('reservation')['reservation_room'] as $rooms)
				<span class="label label-primary" style='font-size:12px;'> {{ $rooms['room_details']['name'] }}({{ $rooms['quantity']}})</span>
				@endforeach
			for dates.</small>
				<div class="clearfix"></div>
				<small style='float:right'> You're check-in will be on <span style='color:red'> <?php echo date("D, d M Y", strtotime(Session::get('reservation')['checkin'])); ?> </span> <br>and you will be checkout <br> on <span style='color:red'> <?php echo date("D, d M Y", strtotime(Session::get('reservation')['display_checkout'])); ?> </span> by 12:00 NN.	</small>

			</center>
		</div>
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style='border-left:1px solid #d8d8d8;margin-top:20px'>


		<form action="" method="POST" role="form">
				
			
				<div class="form-group">
					<label for="">Firstname</label>
					<input type="text" class="form-control" id="" name='firstname' required placeholder="Enter your firstname. Required.">
				</div>
				<div class="form-group">
					<label for="">Lastname</label>
					<input type="text" class="form-control" id="" name='lastname' required placeholder="Enter your Lastname. Required.">
				</div>
				<!-- <div class="form-group">
					<label for="">Lastname</label>
					<input type="text" class="form-control" id="" placeholder="Enter your name. Required.">
				</div> -->
				<div class="form-group">
					<label for="">Address</label>
					<textarea class='form-control' required name='address' placeholder='Enter your address. Required'></textarea>
				</div>
				<div class="form-group">
					<label for="">Contact Number:</label>
					<input type="text" class="form-control" name='contact_no' required id="" placeholder="Enter your contact no. Required.">
				</div>
					<div class="form-group">
					<label for="">Email address</label>
					<input type="email" class="form-control" name='email' required id="" placeholder="Enter your valid email address. Your reservation code will be sent to your email address.">
				</div>
				
			
				<button type="submit" class="btn btn-primary">Submit</button>
			</form>

		</div>




	</div>
</div>
@stop