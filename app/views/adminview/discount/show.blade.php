@extends('layout.admin2')
@section('controller')
showCtrl
@stop
@section('styles')
<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css'>
@stop
@section('content')

<!-- view discount -->
<div class="page-header" style='margin-top:-20px'>
	<h2 style='font-family:Open Sans;'>Discount Manager
	</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="/adminsite/discount">Discount Manager</a>
	</li>
	<li class="active">View Discount</li>
</ol>

<div class="row" style='padding:10px'>
	<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8" style='padding:0'>
		<div class="container-fluid">
			<div class="well well-sm" style=''>
				List of subscribers on this discount type.
			</div>
			<div class="row" style='padding:5px;' ng-cloak>
				<div style='float:right;margin-top:10px;'>
				<input type='text' ng-model='query' class='form-control' style='border:2px solid #d8d8d8' placeholder='Search name / customer ID'>
				</div>
				<bgf-pagination
				page="page"
				per-page="perPage"
				client-limit="clientLimit"
				url="url"
				url-params = 'urlParams'
				link-group-size="2"
				collection="items">
			</bgf-pagination>

			<table class="table table-hover">
				<thead>
					<tr>
						<th style='width:23%;text-align:center'>Customer ID</th>
						<th style='width:27%;text-align:center'>Name</th>
						<th style='width:20%;text-align:Center' class='text-center'>Date <br>Registered</th>
						<th style='width:20%;text-align:center'>Expiration</th>
						<th style='width:10%;text-align:center'>Action</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat='i in items'>
						<td class='text-align:center' ng-bind='i.membership_id'></td>
						<td class='text-center' class='text-align:center' ng-bind='i.firstname+" "+i.lastname'></td>
						<td class='text-align:center' ng-bind='i.created_at_str'></td>
						<td class='text-align:center' ng-bind='i.expiration_str'></td>
						<td>
							<center>
								<button ng-click='removeCustomer(i.id)' type="button" class="btn btn-xs btn-danger">
									<span  class="glyphicon glyphicon-glyphicon glyphicon-remove-sign" aria-hidden="true"></span>
									Remove
								</button>
							</center>
						</td>
					</tr>
					<tr ng-show='items <= 0'>
						<td class='text-center' style='font-weight:bold;color:red' colspan='5'>No results to display.</td>
					</tr>
				</tbody>
			</table>

			<div class="row" style='padding:5px;' ng-cloak>
				<bgf-pagination
				page="page"
				per-page="perPage"
				client-limit="clientLimit"
				url="url"
				url-params = 'urlParams'
				link-group-size="2"
				collection="items">
			</bgf-pagination>
		</div>
	</div>
</div>
</div>
<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" >
	<div style='border-radius:10px;min-height:200px;border:2px solid #d8d8d8;padding:10px'>
		<div class='container-fluid'>
			<div class="row">
				<label style='color:blue'>Discount Details</label>
			</div>
			<div class="row" style=''>
				<label> Name </label>
				<p>{{ $d->name }}</p>
			</div>
			<div class="row">
				<label> Type </label>
				<p>{{ $d->type_str }}</p>
			</div>
			<div class="row">
				<label> Effect </label>
				<p>{{ $d->effect_str}}</p>
			</div>
			<div class="row">
				<label> Description </label>
				<p>{{ $d->description }}</p>
			</div>
			<div class="row">
				<label> Created at </label>
				<p>{{ $d->created_at_str }}</p>
			</div>
			<div class="row">
				<label> Updated at </label>
				<p> {{ $d->updated_at_str }}</p>
			</div>
		</div>

	</div>
</div>

</div>
</div>
@stop
@section('scripts')
<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular-sanitize.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular.min.js'></script>
{{ HTML::script('admin/asset/js/discount.js') }}
<script type="text/javascript">
	
	app.constant('const_discount_id', {{ $d->id }});
</script>
@stop