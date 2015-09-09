@extends('layout.admin')
@section('content')
<div class="row">
	<div class="col-lg-12">
		<div class="page-header">
			<h1>Room Management
			<button type="button" class="btn btn-primary pull-right">		<span class="glyphicon glyphicon glyphicon-plus"></span> Create new room</button>
			</h1>
		
			
		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="navbar navbar-default bootstrap-admin-navbar-thin">
			<ol class="breadcrumb bootstrap-admin-breadcrumb">
				<li>
					<a href="#">Room Management</a>
				</li>
				<li class='active'>Index
				</li>

			</ol>
		</div>
	</div>
</div>
<hr style='margin:0px;'>


<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<div class="well well-sm">
			No rooms to display. <a href='#'>Create One?</a>
		</div>
	</div>
</div>
@stop