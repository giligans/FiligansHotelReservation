@extends('layout.admin2')
@section('controller')
indexCtrl
@stop
@section('styles')
<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css'>
@stop
@section('content')
<div class="page-header" style='margin-top:-20px'>
	<h2 style='font-family:Open Sans;'>Settings</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">Settings</a>
	</li>
	
	<li class="active">Index</li>
</ol>
<div class="row">
	<form action="" method="POST" role="form">

		<div class="form-group">
			<label for="">Telephone Number</label>
			<input type="text" class="form-control" id="" placeholder="Input field">
		</div>
		<div class="form-group">
			<label for="">Email Address</label>
			<input type="text" class="form-control" id="" placeholder="Input field">
		</div>

		<div class="form-group">
			<label for="">Terms and Conditions</label>
			<textarea class='form-control'></textarea>
		</div>


		<button type="submit" class="btn btn-primary">Submit</button>
	</form>
</div>
@stop
@section('scripts')
<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular-sanitize.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular.min.js'></script>
{{ HTML::script('admin/asset/js/index.js') }}
@stop