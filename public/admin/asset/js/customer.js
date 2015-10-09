angular.module('adminApp', ['ui.bootstrap','bgf.paginateAnything', 'ngRoute'], function($interpolateProvider)
{
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
})
.factory('customerFactory', function($http){
	return {
		deleteCustomer : function(id)
		{
			return $http.post('/adminsite/customer/'+id+'/delete');
		}
	}
})
.controller('indexCtrl', ['$scope','$location','customerFactory', function($scope, $location, customerFactory)
{
	$scope.loading=true;
	$scope.$on('pagination:loadPage', function (event, status, config) {
// config contains parameters of the page request
$scope.loading= false;

});
	$scope.$on('pagination:loadStart', function (event, status, config) {
// config contains parameters of the page request
$scope.loading=true;

});

	$scope.updateCustomer = function(data)
	{

		$scope.selectedCustomer = angular.copy(data);
		$('#modal-update-customer').modal('show');
	}

	$scope.deleteCustomer = function(data)
	{
		var confirm = window.confirm('Are you sure you want to delete this customer?');
		if(confirm)
		{
			customerFactory.deleteCustomer(data).success(function()
			{
				$scope.urlParams.token = Math.random();
			}).error();
		}
	}

	$('#new-customer').click(function()
	{
		$('#customer-form').trigger('reset');
		$('#modal-new-customer').modal('show');
	})
	/*pagination of table*/
	$scope.url = '/adminsite/customer/ajax';
	$scope.urlParams = {
		query : '',
		token : 0
	}
	$scope.$watch('searchQuery', function(newVal, oldVal)
	{
		$scope.urlParams.query = angular.copy(newVal);
	});

	$scope.perPage = parseInt($location.search().perPage, 10) || 5;
	$scope.page = parseInt($location.search().page, 10) || 0;
	$scope.clientLimit = 250;
	$scope.$watch('page', function(page) { $location.search('page', page); });
	$scope.$watch('perPage', function(page) { $location.search('perPage', page); });
	$scope.$on('$locationChangeSuccess', function() {
		var page = +$location.search().page,
		perPage = +$location.search().perPage;
		if(page >= 0) { $scope.page = page; };
		if(perPage >= 0) { $scope.perPage = perPage; };
	});
	/*end of pagination of table*/
}])