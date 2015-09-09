@extends('layout.admin2')
@section('controller')
activityController
@stop
@section('content')
<div class="page-header" style='margin-top:-20px'>
	<h2 style='font-family:Open Sans;'>Activity Log

	</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">Activity Log</a>
	</li>
	
	<li class="active">Index</li>
</ol>

<center ng-hide='hideloading'>
		<label>Loading list. Please wait...</label>
		<div class="clearfix">
		</div>
		<img src='{{ URL::to("images/loader.gif") }}'>
	</center>
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
<input type='text' class='form-control' ng-model='searchQuery'>

	</div>
	<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
		<div class="checkbox">
		
			<label>
				<input type="checkbox" value="" ng-model='filter[1]'>
				User Page
			</label>

			<label>
				<input type="checkbox" value="" ng-model='filter[2]'>
				Room Page
			</label>

			<label>
				<input type="checkbox" value="" ng-model='filter[3]'>
				Booking Page
			</label>

		</div>
	</div>
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<select name="" id="input" class="form-control" required="required" style='margin-top:5px;margin-bottom:10px;' ng-model='per_page' ng-cloak>
	<option value="10">Displaying 10 per page.</option>
	<option value="25">Displaying 25 per page.</option>
	<option value="50">Displaying 50 per page.</option>
	<option value="100">Displaying 100 per page.</option>
</select>
	</div>

<table class="table table-bordered table-hover" ng-show='hideloading' ng-cloak>
	<thead>
		<tr>
			<th>#</th>
			<th>Actor</th>
			<th style='min-width:100px'>Log</th>
			<TH>Location</TH>
			<th>Initiated at</th>
		</tr>

	</thead>
	<tbody>
		<tr dir-paginate='a in activities | reverse | filter: searchQuery | filter : filterByActivity | itemsPerPage : per_page'>
			<td ng-bind='$index+1'></td>
			<td ng-bind='a.actor.firstname+" "+a.actor.lastname'></td>
			<td ng-bind='a.LOGS'></td>
			<td>
				<span class="label label-danger" ng-show='a.location==1'>User</span>
				<span class="label label-success" ng-show='a.location==3'>Booking</span>
				<span class="label label-warning" ng-show='a.location==2'>Room</span>
				<span class="label label-info" ng-show='a.location==4'>Report</span>
			</td>
			<td ng-bind='a.created_at'></td>
		</tr>
	</tbody>
</table>
<dir-pagination-controls template-url='/adminsite/template/pagination'></dir-pagination-controls>
@stop
@section('scripts')
{{ HTML::script('admin/asset/js/activity.js') }}
@stop