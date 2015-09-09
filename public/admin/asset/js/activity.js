angular.module('adminApp', ['ui.bootstrap','angularUtils.directives.dirPagination'], function ($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
})
.factory('activityFactory', ['$http', function($http){
	return {
		getActivityLogs : function()
		{
			return $http.get('/adminsite/activity/logs');
		}
	}
}]).controller('activityController', ['$scope','$timeout','activityFactory', function($scope, $timeout, activityFactory){
	loadActivity();
	$scope.per_page = 10;
	$scope.filter = {};
	function noFilter(filterObj) {
        for (var key in filterObj) {
            if (filterObj[key]) {
                return false;
            }
        }
        return true;
    }   
    $scope.filterByActivity = function (activity) {
        return $scope.filter[activity.location] || noFilter($scope.filter);
    };

	function loadActivity()
	{
		activityFactory.getActivityLogs().success(function(data)
		{
			$scope.activities = angular.copy(data)
			$timeout(function()
			{
				$scope.hideloading=true;
			},1000)
		}).error();
	}
}]).filter('reverse', function() {
  return function(items) {
    return items.slice().reverse();
  };
});