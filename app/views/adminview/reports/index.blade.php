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
	<h2 style='font-family:Open Sans;'>Reports <small>
		@if(isset($_GET['filtertype']))
		@if($_GET['filtertype']==0)
		(View reports for year {{ (isset($_GET['year1'])) ? $_GET['year1'] : 'null'  }})
		@else
		(Comparison of reports from year {{ (isset($_GET['year1'])) ? $_GET['year1'] : 'null'}} to year {{ (isset($_GET['year2'])) ? $_GET['year2'] : 'null' }})
		@endif
		@else
		({{ date('Y') }})
		@endif

	</small></h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">Reports</a>
	</li>
	
	<li class="active">Index</li>
</ol>
<hr>

<button type="button" class="btn btn-primary" style='margin-bottom:10px;float:right' ng-click='showfilter=!showfilter' ng-hide='showfilter'> <span class="glyphicon glyphicon-glyphicon glyphicon-cog" aria-hidden="true"></span> Add filter</button>
<div class="clearfix">
</div>
<div class="well" ng-show='showfilter'>
	<form name='filter' method='GET' action='/adminsite/reports'>
		<div class="radio">
			<label>
				<input type="radio" name="filtertype" id="input" value="0" ng-model='filtersetting' checked="checked">
				View
			</label>

			<label>
				<input type="radio" name="filtertype" id="input" value="1" ng-model='filtersetting'>
				Compare
			</label>
		</div>
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<select name="year1" ng-model='year1' id="input" class="form-control" required="required">
				<option value="0">Select Year</option>
				@foreach($years as $y)
				<option value="{{ $y }}"> {{ $y }} </option>
				@endforeach
			</select>
		</div>

		<div class="ng-cloak col-xs-6 col-sm-6 col-md-6 col-lg-6" >

			<select name="year2" ng-model='year2' id="input" class="form-control" required="required" ng-show='filtersetting==1'>
				<option value="0">Select other Year</option>
				@foreach($years as $y)
				<option value="{{ $y }}"> {{ $y }} </option>
				@endforeach
			</select>
		</div>
		<div class="clearfix">

		</div>
		<button  type="submit" ng-click='submitFilter()' ng-disabled='year1==0 || (filtersetting==1 && year2==0)' class="btn btn-primary" style='margin:15px'>Filter Report</button>
		<div class="clearfix">

		</div>
	</form>
</div>

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
				
				@if(isset($_GET['filtertype']))
				@if($_GET['filtertype']!=1)
				<h2 class='text-center' style='color:#777'>{{ ((isset($_GET['year1']))) ? $_GET['year1'] : date('Y') }}</h2>
				<canvas id="bar" legend="legend" class="chart chart-bar" data="success_booking.data"
				labels="labels" series='success_booking.series' ng-show='hideloading' ng-cloak></canvas> 
				@else
				<h2 class='text-center' style='color:#777'>{{ ((isset($_GET['year1']))) ? $_GET['year1'] : date('Y') }}</h2>
				<canvas id="bar" legend="legend" class="chart chart-bar" data="compare_booking.year1.data"
				labels="labels" series='compare_booking.year1.series' ng-show='hideloading' ng-cloak></canvas> 
				@endif
				@else
				<h2 class='text-center' style='color:#777'>{{ ((isset($_GET['year1']))) ? $_GET['year1'] : date('Y') }}</h2>
				<canvas id="bar" legend="legend" class="chart chart-bar" data="success_booking.data"
				labels="labels" series='success_booking.series' ng-show='hideloading' ng-cloak></canvas> 
				@endif
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
						@if(isset($_GET['filtertype']))
						@if($_GET['filtertype']!=1)
						<tr ng-repeat='s in success_booking.series'>
							<th ng-bind='s'></th>

							<td ng-repeat='count in success_booking.data[$index] track by $index'> [[ count ]]</td>
						</tr> 
						@else
						<tr ng-repeat='s in compare_booking.year1.series'>
							<th ng-bind='s'></th>

							<td ng-repeat='count in compare_booking.year1.data[$index] track by $index'> [[ count ]]</td>
						</tr> 
						@endif
						@else
						<tr ng-repeat='s in success_booking.series'>
							<th ng-bind='s'></th>

							<td ng-repeat='count in success_booking.data[$index] track by $index'> [[ count ]]</td>
						</tr> 
						@endif
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>

@if(isset($_GET['filtertype']))
@if($_GET['filtertype']==1)
<div class="panel panel-primary">
	<div class="panel-heading">
		<h3 class="panel-title">Reports of number of bookings have been made this year.</h3>
		<span class="pull-right">
			<!-- Tabs -->
			<ul class="nav panel-tabs">
				<li class="active"><a href="#tab99" data-toggle="tab">Graphical Representation</a></li>
				<li><a href="#tab100" data-toggle="tab">Tabular Data</a></li>

			</ul>
		</span>
	</div>
	<div class="panel-body">
		<div class="tab-content">
			<div class="tab-pane active" id="tab99">
				<center ng-hide='hideloading'>

					<div class="clearfix">
					</div>
					<img src='{{ URL::to("images/loader.gif") }}'>
				</center>
				
				@if(isset($_GET['filtertype']))
				@if($_GET['filtertype']!=1)
				<h2 class='text-center' style='color:#777'>{{ ((isset($_GET['year1']))) ? $_GET['year1'] : date('Y') }}</h2>
				<canvas id="bar" legend="legend" class="chart chart-bar" data="success_booking.data"
				labels="labels" series='success_booking.series' ng-show='hideloading' ng-cloak></canvas> 
				@else
				<h2 class='text-center' style='color:#777'>{{ ((isset($_GET['year2']))) ? $_GET['year2'] : date('Y') }}</h2>
				<canvas id="bar" legend="legend" class="chart chart-bar" data="compare_booking.year2.data"
				labels="labels" series='compare_booking.year2.series' ng-show='hideloading' ng-cloak></canvas> 
				@endif
				@else
				<h2 class='text-center' style='color:#777'>{{ ((isset($_GET['year1']))) ? $_GET['year1'] : date('Y') }}</h2>
				@endif
			</div>
			<div class="tab-pane" id="tab100">
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

						<tr ng-repeat='s in compare_booking.year2.series'>
							<th ng-bind='s'></th>

							<td ng-repeat='count in compare_booking.year2.data[$index] track by $index'> [[ count ]]</td>
						</tr> 
					</tbody>
				</table>
			</div>

		</div>
	</div>
</div>
@endif
@endif

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
				@if(isset($_GET['filtertype']))
				@if($_GET['filtertype']==1)
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>{{ (isset($_GET['year1'])) ? $_GET['year1'] : date('Y')  }}</th>
						<th>{{ (isset($_GET['year2'])) ? $_GET['year2'] : date('Y')  }}</th>
					</tr>
				</thead>
				@endif
				@endif
				<tbody>

					<tr ng-repeat='l in labels'>
						<th ng-bind='l'></th>
						<td ng-bind='data[0][$index] | currency:"P"'></td>
						@if(isset($_GET['filtertype']))
						@if($_GET['filtertype']==1)
						<td ng-bind='data[1][$index] | currency:"P"'></td>
						@endif
						@endif
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
				@if(isset($_GET['filtertype']))
				@if($_GET['filtertype']==1)
				<thead>
					<tr>
						<th>&nbsp;</th>
						<th>{{ (isset($_GET['year1'])) ? $_GET['year1'] : date('Y')  }}</th>
						<th>{{ (isset($_GET['year2'])) ? $_GET['year2'] : date('Y')  }}</th>
					</tr>
				</thead>
				@endif
				@endif
				<tbody>

					<tr ng-repeat='l in labels'>
						<th ng-bind='l'></th>
						<td ng-bind='data2[0][$index] | currency:"P"'></td>
						@if(isset($_GET['filtertype']))
						@if($_GET['filtertype']==1)
						<td ng-bind='data2[1][$index] | currency:"P"'></td>
						@endif
						@endif
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
	var filterinfo = 
	{
		type : '{{ (isset($_GET['filtertype'])) ? $_GET['filtertype'] : null }}',
		year1 : '{{ (isset($_GET['year1'])) ? $_GET['year1'] : date('Y')  }}',
		year2 : '{{ (isset($_GET['year2'])) ? $_GET['year2'] : date('Y')  }}'
	}
	filigansapp.constant('filtersetting', filterinfo)

</script>

@stop