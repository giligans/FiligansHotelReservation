'use strict';

angular.module('giligansApp', [], function($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]')
})
.factory('indexFactory', ['', function(){
	return function name(){
		
	};
}])
.controller('indexCtrl', ['$scope', function($scope){

}]);