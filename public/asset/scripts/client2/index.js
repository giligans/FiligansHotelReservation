'use strict';
angular.module('giligansApp', ['ui.bootstrap','angularMoment'], function($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]')
}).factory('bookingFactory', ['$http', function($http){
	return {
		test : function(){
			alert('hey')
		}
	};
}]).factory('indexFactory', ['$http', function($http){
	return {
		
	};
}]).controller('indexCtrl', ['$scope', 'indexFactory', function($scope, indexFactory){
	
}])