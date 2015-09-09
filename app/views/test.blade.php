@extends('layout.master2')
@section('controller')
testController
@stop

@section('content')
<form action="/testlang" method="POST" role="form">
	[[ test ]]
	<legend>Form title</legend>

	<div class="form-group">
		<label for="">label</label>
		<input type="text" name='uname' class="form-control" id="" placeholder="Input field">
		<input type='checkbox' name='select[]' value='1'>
		<input type='checkbox' name='select[]' value='2'>
		<input type='hidden' name='test[0][quantity]' value='1'>
		<input type='hidden' name='test[0][price]' value='2'>
		<input type='hidden' name='test[0][somehting]' value='3'>
	</div>

	

	<button type="submit" class="btn btn-primary">Submit</button>
</form>
@stop

@section('scripts')
<script type="text/javascript">
	angular.module('giligansApp', [], function($interpolateProvider){
		$interpolateProvider.startSymbol('[[');
		$interpolateProvider.endSymbol(']]');
	}).controller('testController', ['$scope', function($scope){
		$scope.test = [1,2,3];
		$scope.test.push(1);
	}])
</script>
@stop