@extends('layout.admin2')
@section('controller')
indexRoomCtrl 
@stop
@section('content')
<div class="page-header" style='margin-top:-20px'>
	<h2 style='font-family:Open Sans;'>Room Management
		<a class="btn btn-success pull-right" href='{{ URL::to("adminsite/room/create")  }}'>Create new room</a>
	</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">Room Management</a>
	</li>
	
	<li class="active">Index</li>
</ol>


<div class="well well-sm" ng-show='rooms.length===0 && hideloading' ng-cloak>
	No rooms to display.
</div>



<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
	<center ng-hide='hideloading'>
		<label>Loading list. Please wait...</label>
		<div class="clearfix">
		</div>
		<img src='{{ URL::to("images/loader.gif") }}'>
	</center>
	<table style='text-align:center' class="table table-striped table-hover" ng-show='hideloading' ng-cloak>
		<thead>
			<tr>
				<th>#</th>
			
				<th>Name</th>
				<th>Quantity</th>
				<th>Max <br>Adult</th>
				<th>Available</th>
				<th>Max Children</th>
				<th>Price</th>
				<th>Action</th>
				
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat='r in rooms'>
				<td ng-bind='$index+1'></td>
				<td ng-bind='r.name'></td>
				<td ng-bind='r.room_qty.length'></td>
			
				<td ng-bind='r.max_adults'></td>
				<td></td>
			<td ng-bind='r.max_children'></td>
				<td ng-bind='r.price | currency:"₱"'></td>
				<td>
					<a class="btn btn-xs btn-warning" href='/adminsite/room/[[ r.id ]]/update'><span class="glyphicon glyphicon glyphicon-edit"></a>
					<a href='{{ URL::to("/adminsite/room/") }}/[[ r.id ]]' class="btn btn-xs btn-info"><span class="glyphicon glyphicon glyphicon-info-sign"></a>
				</td>
			</tr>
		</tbody>
	</table>
	
</div>
<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">

	<div class="panel panel-primary" ng-cloak>
		<div class="panel-heading">
			<h3 class="panel-title">Room Search</h3>
		</div>
		<div class="panel-body">
			<input type='text' class='form-control' placeholder='Enter room number' ng-model='room_q'>
			<div class="clearfix">
				
			</div>
			<button type="button" class="btn btn-large btn-block btn-primary" style='margin-top:10px' ng-click='searchRoom()'>Search</button>
		</div>
	</div>
</div>
@stop
@section('scripts')
{{ HTML::script('admin/asset/js/chart/chart.min.js') }}
{{ HTML::script('admin/asset/js/chart/angular-chart.js') }}
{{ HTML::script('admin/asset/js/room.js') }}
@stop