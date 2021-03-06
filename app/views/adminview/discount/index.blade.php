@extends('layout.admin2')
@section('controller')
indexCtrl
@stop
@section('styles')
<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css'>
@stop
@section('content')

<!-- view discount -->


<div class="modal fade" id="modal-view-discount" style='z-index:10000'>
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title">View discount </h4> 
			</div>
			<div class="modal-body">
				<table class='table table-hover'>
					<tr>
						<td style='border-top:0'>
							Discount Name
						</td>
						<td style='border-top:0' ng-bind='selectedDiscount.name'>
							
						</td>
					</tr>

					<tr>
						<td>
							Type
						</td>
						<td ng-bind='selectedDiscount.type_str'>
							
						</td>
					</tr>
					<tr>
						<td>
							Code
						</td>
						<td ng-bind='selectedDiscount.code'>
							
						</td>
					</tr>

					<tr>
						<td>
							Effect 
						</td>
						<td ng-bind='selectedDiscount.effect_str'>
							
						</td>
					</tr>
					<tr>
						<td>
							Description
						</td>
						<td ng-bind='selectedDiscount.description'>
							
						</td>
					</tr>
					<tr>
						<td>
							Updated at
						</td>
						<td ng-bind='selectedDiscount.updated_at_str'>
							
						</td>
					</tr>
					<tr>
						<td>
							Created at
						</td>
						<td ng-bind='selectedDiscount.created_at_str'>
							
						</td>
					</tr>
					
				</table>
			</div>
			<div class="modal-footer">
			<a ng-href='/adminsite/discount/[[ selectedDiscount.id]]/show' class="btn btn-primary">View more information</a>
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

			</div>
		</div>
	</div>
</div>
<!-- end view discount -->
<div class="modal fade" id="modal-update-discount" style='z-index:10000'>
	<div class="modal-dialog">
		<form method='POST' action='{{ URL::to("adminsite/discount/type/update") }}'>
			<input type='hidden' name='discount_id' ng-value='selectedDiscount.id'>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">Create new discount</h4>
				</div>
				<div class="modal-body">
					<table class="table table-hover">
						<tr >
							<td style='border-top:0'>Name</td>
							<td style='border-top:0'><input type='text' ng-model='selectedDiscount.name' required name='name' class='form-control' placeholder='name of discount'></td>
						</tr>
						<tr>
							<td style='border-top:0'>Type </td>
							<td style='border-top:0'>
								
								<select name="type" ng-model='selectedDiscount.type' required class="discount-type form-control" required="required">
									<option value="">Select type of discount</option>
									<option value="0">Coupon</option>
									<option value="1">Membership</option>
								</select>
							</td>
						</tr>
						<tr>
							<td style='border-top:0'>
								Effect
							</td>
							<td style='border-top:0'>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style='padding:0'>

									<div class="radio">
										<label>
											<input type="radio" required value='0' ng-model='selectedDiscount.effect_type' name="effect_type" id="input" value="">
											Fixed
										</label>
										<label>
											<input type="radio" value='1' ng-model='selectedDiscount.effect_type' required name="effect_type" id="input" value="">
											Percentage
										</label>
									</div>

								</div>
								<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
									<input type='text' class='form-control' name='effect' ng-model='selectedDiscount.effect' required placeholder='e.g. 500.'>
								</div>
							</td>
						</tr>
						<tr class='coupon-field' ng-show='selectedDiscount.type==0'>
							<td>Code<br>
								<div style='color:red;width:150px;'>You can't enter multiple codes on edit mode.</div></td>
								<td>

									<input type='text' ng-model='selectedDiscount.code' required name='code' class='txtCoupon form-control' placeholder='Coupon code'>
								</td>
							</tr>
							<tr >
								<td style='border-top:0'>Description</td>
								<td style='border-top:0'>
									<textarea class='form-control' required ng-model='selectedDiscount.description' name='description' placeholder='Description of discount'></textarea>
								</td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="modal fade" id="modal-discount" style='z-index:10000'>
		<div class="modal-dialog">
			<form method='POST' action='{{ URL::to("adminsite/discount/type/create") }}'>
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Create new discount</h4>
					</div>
					<div class="modal-body">
						<table class="table table-hover">
							<tr >
								<td style='border-top:0'>Name</td>
								<td style='border-top:0'><input type='text' required name='name' class='form-control' placeholder='name of discount'></td>
							</tr>

							<tr >
								<td style='border-top:0'>Type </td>
								<td style='border-top:0'>
									<select name="type" required class="discount-type form-control" required="required">
										<option value="">Select type of discount</option>
										<option value="0">Coupon</option>
										<option value="1">Membership</option>
									</select>
								</td>
							</tr>
							<tr>
								<td style='border-top:0'>
									Effect
								</td>
								<td style='border-top:0'>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style='padding:0'>

										<div class="radio">
											<label>
												<input type="radio" required name="effect_type" id="input" value="" checked="checked">
												Fixed
											</label>
											<label>
												<input type="radio" required name="effect_type" id="input" value="">
												Percentage
											</label>
										</div>

									</div>
									<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style='padding:0'>
										<input type='text' class='form-control' name='effect' required placeholder='e.g. 500.'>
									</div>
								</td>
							</tr>
							<tr class='coupon-field' style='display:none'>
								<td>Code
									<div style='color:green;width:150px;'>
										You can enter multiple codes by using a ";" seperator
									</div></td>
									<td>
										<input type='text' required name='code'  class='form-control txtCoupon' placeholder='Coupon code'>
									</td>
								</tr>
								<tr >
									<td style='border-top:0'>Description</td>
									<td style='border-top:0'>
										<textarea class='form-control' required name='description' placeholder='Description of discount'></textarea>
									</td>
								</tr>
							</table>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save changes</button>
						</div>
					</div>
				</form>
			</div>
		</div>



		<div class="modal fade" id="modal-set-customer-discount" style='z-index:10000'>	
			<div class="modal-dialog">
				<div class="modal-content">
					<form id='set-customer-discount-form' method='post' action='/adminsite/discount/customers-discounts/create'>
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h4 class="modal-title">Set customer discount</h4>
						</div>
						<div class="modal-body">
							@if(count($membership)==0)
							<div class="well" style='text-align:Center'>
								Please create first a discount with <b>membership</b> type 
							</div>
							@else

							<table class="table tables-hover">
								<tr>
									<td style='border-top:0'>Customer Name</td>
									<td style='border-top:0;width:75%'><input autocomplete='off' id='search-user' placeholder='Please enter customer name or customer id' type='text' class='form-control'>
										<div style='width:100%;padding:5px;display:none' id='selected-user'>

										</div>
										<input type='hidden' id='customer-id' name='customer_id' value='' required>
										<div id='search-user-results' style='width:100%;'>
										</div>
									</td>
								</tr>
								<tr>
									<td>Membership type</td>
									<td>
										<select name="type" id="input" class="form-control" required="required">
											<option value="">Membership type</option>
											@foreach($membership as $m)
											<option value="{{ $m->id }}">{{ $m->name }}</option>
											@endforeach
										</select>
									</td>
								</tr>
								<tr>
									<td>
										Expiration
									</td>
									<td>
										<select name="expiration" id="input" class="form-control" required="required">
											<option value="">Select expiration</option>
											<option value="0.5">6 months</option>
											<option value="1">1 years</option>
											<option value="2">5 years</option>
											<option value="999">Unlimited</option>
										</select>
									</td>
								</tr>
							</table>

							@endif
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							@if(count($membership)!=0)<button type="submit" class="btn btn-primary">Save changes</button>@endif
						</div>
					</form>
				</div>

			</div>
		</div>

		<div class="modal fade" id="modal-customer-discount">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title">Modal title</h4>
					</div>
					<div class="modal-body">

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<button type="button" class="btn btn-primary">Save changes</button>
					</div>
				</div>
			</div>
		</div>
		<div class="page-header" style='margin-top:-20px'>
			<h2 style='font-family:Open Sans;'>Discount Manager
				<button type="button" id='set-customer-discount' class="btn btn-warning pull-right" style='margin:5px;margin-bottom:10px;'>Set customer discount</button>
				<button type="button" id='new-discount' class="btn btn-success pull-right" style='margin:5px;margin-bottom:10px;'>Add new discount</button>

			</h2>
		</div>
		<ol class="breadcrumb">
			<li>
				<a href="#">Discount Manager</a>
			</li>
			<li class="active">Index</li>
		</ol>

		<div class="row">
			@if(Session::has('error'))
			<div class="alert alert-danger">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Error!</strong> {{ Session::get('error') }}
			</div>
			@elseif(Session::has('success'))

			<div class="alert alert-success">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				<strong>Success</strong>  {{ Session::get('success') }}
			</div>
			@endif

			<div style='float:right;margin-right:10px;'>
				Order by: 
				<select name="" style='border:2px solid #d8d8d8' id="input" class="form-control" required="required" ng-model='orderBy'>
					<option value="created_at">Created_at</option>
					<option value="name">Name</option>
					<option value="code">Code</option>
					<option value="type">Type</option>
					<option value="used">Used</option>
				</select>
			</div>

			<div style='float:right;margin-right:10px;margin-top:20px;'>
				<input type='text' ng-model='query' class='form-control' style='border:2px solid #d8d8d8' placeholder='enter discount name / code'> 
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
		<table class="table table-striped table-hover">
			<thead>
				<tr>
					<th style='width:20%'>Discount Name</th>
					<th style='width:15%'>Type</th>
					<th style='width:10%'>Code</th>
					<th style='width:15%'>Used</th>
					<th style='width:20%'>Created at</th>
					<th style='width:20%'>Action</th>
				</tr>
			</thead>
			<tbody>
				<tr ng-repeat='i in items'>
					<td ng-bind='i.name'></td>
					<td ng-bind='i.type_str'></td>
					<td ng-bind='i.code'></td>
					<td ng-bind='i.used_str'></td>
					<td ng-bind='i.created_at_str'></td>
					<td> 
						<button ng-click='updateDiscount(i)' type="button" class="btn btn-xs btn-warning" style='margin:3px;'>
							<span class="glyphicon glyphicon-glyphicon glyphicon-edit" aria-hidden="true"></span>
						</button>
						<button type="button" ng-click='deleteDiscount(i)' class="btn btn-xs btn-danger">
							<span class="glyphicon glyphicon-glyphicon glyphicon-remove-circle" aria-hidden="true"></span>
						</button>
						<button type="button" ng-click='viewDiscount(i)' class="btn btn-xs btn-primary">
							<span class="glyphicon glyphicon-glyphicon glyphicon-info-sign" aria-hidden="true"></span>
						</button>
					</td>

				</tr>
			</tbody>
		</table>
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
@stop
@section('scripts')
<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular-sanitize.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular.min.js'></script>
{{ HTML::script('admin/asset/js/discount.js') }}
@stop