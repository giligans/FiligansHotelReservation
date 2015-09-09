angular.module('adminApp', ['ui.bootstrap','angularFileUpload','chart.js'], function ($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
}).factory('indexFactory', ['$http', function($http){
	return {
		
	};
}]).controller('indexCtrl', ['$scope','$timeout', function($scope, $timeout){
	//alert('hey');

	$scope.labels = ['12AM', '2AM', '4AM', '6AM', '8AM', '10AM', '12PM', '2PM', '4PM', '6PM', '8PM', '10PM'];
	$scope.series = ['Series A', 'Series B'];
	$scope.data = [
	[65, 59, 80, 81, 56, 55, 40],
	[28, 48, 40, 19, 86, 27, 90],
	[28, 48, 40, 19, 86, 27, 90],
	[28, 48, 40, 19, 86, 27, 90]
	];
}])