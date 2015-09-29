@extends('layout.admin2')
@section('controller')
indexCtrl
@stop
@section('styles')
<link rel='stylesheet prefetch' href='http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.min.css'>
@stop
@section('content')


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
								<select name="type" required id="discount-type" class="form-control" required="required">
									<option value="">Select type of discount</option>
									<option value="0">Coupon</option>
									<option value="1">Membership</option>
								</select>
							</td>
						</tr>
						<tr id='coupon-field' style='display:none'>
							<td>Code</td>
							<td>
								<input type='text' required name='code' id='txtCoupon' class='form-control' placeholder='Coupon code'>
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
						<td style='border-top:0'><input id='search-user' type='text' class='form-control' required>
							<input type='hidden' name='customer_id' value=''>
							<div id='search-user-results'>
								
							</div>
							


						</td>

					</tr>
					<tr>
						<td>Membership type</td>
						<td>
							<select name="" id="input" class="form-control" required="required">
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
							<select name="" id="input" class="form-control" required="required">
								<option value="">Select expiration</option>
								<option value="0.5">6 months</option>
								<option value="1">1 years</option>
								<option value="2">5 years</option>
								<option value="2">Unlimited</option>
							</select>
						</td>
					</tr>
				</table>

				@endif
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				@if(count($membership)!=0)<button type="button" class="btn btn-primary">Save changes</button>@endif
			</div>
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
	<h2 style='font-family:Open Sans;'>Discount Manager</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">Discount Manager</a>
	</li>
	<li class="active">Index</li>
</ol>
<div class="row" style='padding-right:10px;'>
	<button type="button" id='set-customer-discount' class="btn btn-warning pull-right" style='margin:3px;'>Set customer discount</button>
	<button type="button" id='new-discount' class="btn btn-success pull-right" style='margin:3px;'>Add new discount</button>

</div>
<div class="row"></div>
@stop
@section('scripts')
<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular-sanitize.min.js'></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/textAngular/1.2.2/textAngular.min.js'></script>
{{ HTML::script('admin/asset/js/discount.js') }}
@stop