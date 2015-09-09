@extends('layout.admin2')
@section('styles')
{{ HTML::style('admin/asset/css/chart/chart.css') }}
<style type="text/css">

	/*Panel tabs*/
	.panel-tabs {
		position: relative;
		bottom: 30px;
		clear:both;
		border-bottom: 1px solid transparent;
	}

	.panel-tabs > li {
		float: left;
		margin-bottom: -1px;
	}

	.panel-tabs > li > a {
		margin-right: 2px;
		margin-top: 4px;
		line-height: .85;
		border: 1px solid transparent;
		border-radius: 4px 4px 0 0;
		color: #ffffff;
	}

	.panel-tabs > li > a:hover {
		border-color: transparent;
		color: #ffffff;
		background-color: transparent;
	}

	.panel-tabs > li.active > a,
	.panel-tabs > li.active > a:hover,
	.panel-tabs > li.active > a:focus {
		color: #fff;
		cursor: default;
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		border-radius: 2px;
		background-color: rgba(255,255,255, .23);
		border-bottom-color: transparent;
	}


</style>
@stop
@section('controller')
reportController
@stop
@section('content')
<div class="page-header" style='margin-top:-20px'>
	<h2 style='font-family:Open Sans;'>Reports</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">Reports</a>
	</li>
	
	<li class="active">Index</li>
</ol>
<hr>
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Reports of number of bookings have been made this year.</h3>
		<span class="pull-right">
			<!-- Tabs -->
			<ul class="nav panel-tabs">
				<li class="active"><a href="#tab1" data-toggle="tab">Graphical Representation</a></li>
				<li><a href="#tab2" data-toggle="tab">Tabular Data</a></li>

			</ul>
		</span>
	</div>
	<div class="panel-body">
		<div class="tab-content">
			<div class="tab-pane active" id="tab1">
				<center ng-hide='hideloading'>

					<div class="clearfix">
					</div>
					<img src='{{ URL::to("images/loader.gif") }}'>
				</center>
				<canvas id="bar" legend="legend" class="chart chart-bar" data="success_booking.data"
				labels="labels" series='success_booking.series' ng-show='hideloading' ng-cloak></canvas> 
			</div>
			<div class="tab-pane" id="tab2">
				<center ng-hide='hideloading'>

					<div class="clearfix">
					</div>
					<img src='{{ URL::to("images/loader.gif") }}'>
				</center>

				<table class="table table-condensed table-hover">
					<thead>
						<tr>
							<th></th>
							<th ng-repeat='l in labels' ng-bind='l'> </th>

						</tr>
					</thead>
					<tbody>

						<tr ng-repeat='s in success_booking.series'>
							<th ng-bind='s'></th>

							<td ng-repeat='count in success_booking.data[$index] track by $index'> [[ count ]]</td>
						</tr> 
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Sales report of online bookings.</h3>
		<span class="pull-right">
			<!-- Tabs -->
			<ul class="nav panel-tabs">
				<li class="active"><a href="#tab5" data-toggle="tab">Graphical Representation</a></li>
				<li><a href="#tab6" data-toggle="tab">Tabular Data</a></li>

			</ul>
		</span>
	</div>
	<div class="panel-body">
		<div class="tab-content">
			<div class="tab-pane active" id="tab5">
				<center ng-hide='hideloading'>

					<div class="clearfix">
					</div>
					<img src='{{ URL::to("images/loader.gif") }}'>
				</center>
				<canvas id="line" class="chart chart-line" data="data"
				labels="labels" legend="true" series="series"
				click="onClick" ng-cloak>
			</canvas>  
		</div>
		<div class="tab-pane" id="tab6">
			<center ng-hide='hideloading'>

				<div class="clearfix">
				</div>
				<img src='{{ URL::to("images/loader.gif") }}'>
			</center>

			<table class="table table-bordered table-hover">
				
				<tbody>
					<tr ng-repeat='l in labels'>
						<th ng-bind='l'></th>
						<td ng-bind='data[0][$index] | currency:"P"'></td>
					</tr>
					

				</tbody>
			</table>
		</div>

	</div>
</div>
</div>

<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Sales report showing walk-in applicant</h3>
		<span class="pull-right">
			<!-- Tabs -->
			<ul class="nav panel-tabs">
				<li class="active"><a href="#tab3" data-toggle="tab">Graphical Representation</a></li>
				<li><a href="#tab4" data-toggle="tab">Tabular Data</a></li>

			</ul>
		</span>
	</div>
	<div class="panel-body">
		<div class="tab-content">
			<div class="tab-pane active" id="tab3">
				<center ng-hide='hideloading'>

					<div class="clearfix">
					</div>
					<img src='{{ URL::to("images/loader.gif") }}'>
				</center>
				<canvas id="line" class="chart chart-line" data="data2"
				labels="labels" legend="true" series="series2"
				click="onClick" ng-cloak>
			</canvas>  
		</div>
		<div class="tab-pane" id="tab4">
			<center ng-hide='hideloading'>

				<div class="clearfix">
				</div>
				<img src='{{ URL::to("images/loader.gif") }}'>
			</center>
			<table class="table table-bordered table-hover">
				<tbody>
					<tr ng-repeat='l in labels'>
						<th ng-bind='l'></th>
						<td ng-bind='data2[0][$index] | currency:"P"'></td>
					</tr>
				</tbody>
			</table>
		</div>

	</div>
</div>
</div>





@stop

@section('scripts')
{{ HTML::script('admin/asset/js/chart/chart.min.js') }}
{{ HTML::script('admin/asset/js/chart/angular-chart.js') }}

{{ HTML::script('admin/asset/js/report.js')}}
<script type="text/javascript">
	

</script>
@stop