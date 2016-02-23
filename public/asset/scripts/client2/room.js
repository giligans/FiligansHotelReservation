'use strict';
angular.module('giligansApp', ['ui.bootstrap','angularMoment'], function($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]')
}).factory('roomFactory', ['$http', function($http){
	return {
		checkAvailability : function(data){
			var info = {
				checkin : moment(data.checkin).format('YYYY[-]MM[-]DD'),
				checkout: moment(data.checkout).format('YYYY[-]MM[-]DD'),
				quantity : data.quantity,
				nights : data.nights,
				display_checkout : moment(data.display_checkout).format('YYYY[-]MM[-]DD')
			}
			return $http.post('/room/'+data.room_id+'/availability', info);
		}
	};
}]).controller('roomController', ['$scope','roomFactory','$timeout', function($scope, roomFactory, $timeout){
	$scope.availability = {
		checkin : moment().format('YYYY[-]MM[-]DD'),
		checkout : moment().format('YYYY[-]MM[-]DD'),
		display_checkout : moment().add(1, 'days').format('L'),
		quantity: 1,
		room_id:0
	}
	$scope.nights = 1;
	
	$scope.checkAvailability = function(){
		$scope.available = 1;
		$scope.reservation = null;
		if($scope.availability.room_id!=0){
			$scope.loading = true;
			$scope.availability.nights = $scope.nights;
			roomFactory.checkAvailability($scope.availability).success(function(data){
				if(data.status==1){
					console.log(data);
					$scope.reservation = angular.copy(data);
					$scope.reservation.info = {
						room_id : $scope.availability.room_id,
						quantity : $scope.availability.quantity,
					}
					$timeout(function(){
						$scope.displayform = false;
						$scope.loading=false;
					}, 1000)
				}else{
					$timeout(function(){
						$scope.loading=false;
						$scope.available = 0;
					}, 1000)
				}
			}).error();
		}else{
			alert('Select a room type first!')
		}
	}
	$scope.$watch('availability.checkin', function(newVal, oldVal){
		if($scope.nights>1){
			$scope.availability.checkout = moment(newVal).add($scope.nights, 'days').format('YYYY[-]MM[-]DD');
			$scope.availability.display_checkout = moment(newVal).add($scope.nights, 'days').format('YYYY[-]MM[-]DD');
		}else if($scope.nights==1){
			$scope.availability.display_checkout = moment(newVal).add(1, 'days').format('YYYY[-]MM[-]DD');
			$scope.availability.checkout = moment(newVal).format('YYYY[-]MM[-]DD');
		}
	});
	$scope.$watch('nights', function(newVal, oldVal){

		if(newVal<1){
			$scope.nights=1;
		}
		if(newVal>1){
			$scope.availability.checkout = moment($scope.availability.checkin).add(newVal-1, 'days').format('YYYY[-]MM[-]DD');
			$scope.availability.display_checkout = moment($scope.availability.checkin).add(newVal, 'days').format('YYYY[-]MM[-]DD');
			console.log($scope.availability.display_checkout);
		}else if(newVal==1){
			$scope.availability.checkout = moment($scope.availability.checkin).format('YYYY[-]MM[-]DD');
			$scope.availability.display_checkout = moment($scope.availability.checkin).add(1, 'days').format('YYYY[-]MM[-]DD');
		}
// console.log($scope.availability.checkout)
})
}])