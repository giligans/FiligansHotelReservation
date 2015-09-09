'use strict';
angular.module('giligansApp', ['ui.bootstrap','angularMoment'], function($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]')
}).factory('bookingFactory', ['$http', function($http){
	return {
		checkAvailability : function(data){
			var info = {
				checkin : moment(data.checkin).format('YYYY[-]MM[-]DD'),
				checkout: moment(data.checkout).format('YYYY[-]MM[-]DD')
			}
			return $http.post('/room/'+data.id+'/availability', info);

		},
	}
}]).controller('bookingController', ['$scope','bookingFactory', function($scope, bookingFactory){

	function checkAvailability(data){
		console.log()
		bookingFactory.checkAvailability(data).success(function(data){
			console.log(data)
		}).error();
		
	}
	$scope.rooms=1;
	$scope.$watch('room', function(newVal, oldVal){	
		checkAvailability(newVal);
		$scope.displayInfo =  {
			checkin : moment($scope.room.checkin).format('dddd, MMMM Do YYYY'),
			checkout : moment($scope.room.checkout).add(1,'days').format('dddd, MMMM Do YYYY'),
			price : newVal.price,

		}
		var checkin = moment($scope.room.checkin);
		var checkout = moment($scope.room.checkout);
		console.log(checkin)
		
		var nights = checkout.diff(checkin, 'days');
		if(nights==0){
			$scope.nights = 1;
		}else{
			$scope.nights = nights;
		}
	})
	$scope.addrooms = function(){
		$scope.rooms++;
	}
	$scope.subrooms = function(){
		$scope.rooms--;
	}
	$scope.$watch('rooms', function(newVal, oldVal){
		if(newVal < 1){
			$scope.rooms=1;
		}
		$scope.displayInfo.price = $scope.room.price*newVal;
	});
	$scope.changebooking = function(){
		swal({
			title: "Are you sure?",
			text: "You will be redirected back to choosing rooms.",
			type: "warning",
			showCancelButton: true,
			confirmButtonClass: 'btn-warning',
			confirmButtonText: 'Change Booking'
		});
	}
}]).directive('validNumber', function() {
	return {
		require: '?ngModel',
		link: function(scope, element, attrs, ngModelCtrl) {
			if(!ngModelCtrl) {
				return; 
			}

			ngModelCtrl.$parsers.push(function(val) {
				if (angular.isUndefined(val)) {
					var val = '';
				}
				var clean = val.replace( /[^0-9]+/g, '');
				if (val !== clean) {
					ngModelCtrl.$setViewValue(clean);
					ngModelCtrl.$render();
				}
				return clean;
			});
			element.bind('keypress', function(event) {
				if(event.keyCode === 32) {
					event.preventDefault();
				}
			});
		}
	};
});