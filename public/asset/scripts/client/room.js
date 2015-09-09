'use strict';

angular.module('giligansApp', ['ui.bootstrap','angularMoment'], function($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
}).factory('roomFactory', ['$http', function($http){
	return {
		checkAvailability : function(id,data){

			var info = {
				checkin : moment(data.checkin).format('YYYY[-]MM[-]DD'),
				checkout: moment(data.checkout).format('YYYY[-]MM[-]DD')
			}

			return $http.post('/room/'+id+'/availability', info);

		},
		proceedReservation : function(data){
			var info = {
				checkin : moment(data.checkin).format('YYYY[-]MM[-]DD'),
				checkout: moment(data.checkout).format('YYYY[-]MM[-]DD'),
				id : data.id
			}
			return $http.post('/reservation/proceed', info);
		}
	};
}]).controller('roomController', ['$scope','roomFactory','$timeout', function($scope, roomFactory, $timeout){
	

	var checkRoomAvailability = function(id)
	{
		roomFactory.checkAvailability(id, $scope.room).success(function(data){
			if(data!=0){

				$timeout(function(){
					if(data.available_rooms==0){
						$scope.available=false;
					}else{
						$scope.available=data.available_rooms;
					}
					//console.log(data);
					$scope.loading=false;	
				},1000)
			}

			
		}).error
	}
	$scope.addnight = function(){
		$scope.nights++;
	}
	$scope.subnight = function(){
		$scope.nights--;
	}

	$scope.proceedReservation = function(){
		roomFactory.proceedReservation($scope.room).success(function(data){
			$timeout(function(){
				$scope.loading=true;
				window.location.href='/booking'
			})
			console.log(data)
		}).error();
	}

	$scope.checkAvailability = function(data){
		$scope.available=null;
		$scope.displayInfo = {
			checkin : moment().format('L'),
			checkout : moment().format('L'),
		}
		$scope.nights = 1;
		$scope.room = {
			checkin : moment().format('L'),
			id : data.id,
			checkout : moment().format('L'),
		}
		$scope.$watch('room.checkin', function(newVal, oldVal){
			$scope.displayInfo.checkout = moment($scope.room.checkin).add($scope.nights, 'days').format('dddd, MMMM DD YYYY');
			$scope.displayInfo.checkin = moment(newVal).format('dddd, MMMM DD YYYY')
			if(newVal==null || newVal==''){
			//alert('hey')
			$scope.room.checkin=moment().format('L');
		}
	});
		$scope.$watch('nights', function(newVal, oldVal){
			if(newVal>1){
				$scope.room.checkout = moment($scope.room.checkin).add(newVal, 'days').format('dddd, MMMM DD YYYY');
			}else if(newVal==1){
				$scope.room.checkout = moment($scope.room.checkin).add(0, 'days').format('dddd, MMMM DD YYYY');
			}
			$scope.displayInfo.checkout = moment($scope.room.checkin).add(newVal, 'days').format('dddd, MMMM DD YYYY');
			if(newVal==null || newVal=='' || newVal<=0){
				$scope.nights = 1;
			}	
			$scope.room.checkout
		})

		$scope.roomAvailability = angular.copy(data);
		$('#availability').modal('show');
	}
	$scope.triggerCheckAvailability = function(){
		$scope.loading = true;
		checkRoomAvailability($scope.roomAvailability.id);
	}


}])