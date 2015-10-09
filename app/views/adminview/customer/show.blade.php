@extends('layout.admin2')
@section('controller')
indexCtrl
@stop
@section('styles')
<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css'>
<style type="text/css">
	.loading 
	{
		opacity: 0.5;
	}
</style>
@stop
@section('content')
<div class="page-header" style='margin-top:-20px'>
	<h2 style='font-family:Open Sans;'>Customers


	</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="/adminsite/customer">Customers</a>
	</li>

	<li class="active">View customer info</li>
</ol>

<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
			<div class="container-fluid">
				<div class="row"></div>
			</div>
		</div>
		<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

			<div class="container-fluid" style='border:2px solid #d8d8d8;border-radius:10px;padding:20px;'>
				<div class="row">
					<label style='color:blue'>Customer Information</label>
				</div>
				<div class="row">
					<label>Membership ID</label>
					<p> {{ $customer->membership_id }}</p>
				</div>
				<div class='row'>
					<label>Name</label>
					<p> {{ $customer->fullname }}</p>
				</div>

				<div class='row'>
					<label>Address</label>
					<p> {{ $customer->address }}</p>
				</div>

				<div class='row'>
					<label>Contact no</label>
					<p>{{ $customer->contact_no }}</p>
				</div>
				<div class='row'>
					<label>Email</label>
					<p>{{ $customer->email }}</p>
				</div>
				<div class="row">
					<label>
						Member since
					</label>
					<p> {{ $customer->created_at_str }}</p>
				</div>
				<div class="row">
					<label>Discounts aquired</label>
					@if(count($customer->discounts) > 0)
					@foreach($customer->discounts as $cd)
					<p>{{ $cd->discountDetails->name }} </p>
					@endforeach
					@else
					<p>No data to display.</p>
					@endif
				</div>
			</div>
		</div>
	</div>
</div>

<!-- modals here -->

@stop
@section('scripts')
<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular-sanitize.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular.min.js'></script>
{{ HTML::script('admin/asset/js/customer.js') }}
@stop