angular.module('adminApp', ['ui.bootstrap'], function($interpolateProvider)
{
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
}).controller('indexCtrl', ['$scope', function($scope)
{	

	
	$('#new-customer').click(function()
	{
		$('#modal-new-customer').modal('show');
	})
}])