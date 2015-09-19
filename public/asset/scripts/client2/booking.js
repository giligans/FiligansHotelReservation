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
}]).controller('bookingController', ['$scope', 'bookingFactory', function($scope, bookingFactory){
	//bookingFactory.test();
  $scope.availability = {
    checkin : moment().format('YYYY[-]MM[-]DD'),
    checkout : moment().add(1, 'days').format('YYYY[-]MM[-]DD'),
    display_checkout : moment().add(1, 'days').format('YYYY[-]MM[-]DD')
  }
  $scope.nights=1;
  $scope.$watch('availability.checkin', function(newVal, oldVal){
    if($scope.nights>1){
     $scope.availability.checkout = moment(newVal).add($scope.nights, 'days').format('YYYY[-]MM[-]DD');
     $scope.availability.display_checkout = moment(newVal).add($scope.nights, 'days').format('YYYY[-]MM[-]DD');
   }else if($scope.nights==1){
     $scope.availability.display_checkout = moment(newVal).add(1, 'days').format('YYYY[-]MM[-]DD');
     $scope.availability.checkout = moment(newVal).add(1, 'days').format('YYYY[-]MM[-]DD');

   }

 });
  $scope.$watch('nights', function(newVal, oldVal){
    if(newVal<1){
      $scope.nights=1;
    }
    if(newVal>1){
      $scope.availability.checkout = moment($scope.availability.checkin).add(newVal, 'days').format('YYYY[-]MM[-]DD');
      $scope.availability.display_checkout = moment($scope.availability.checkin).add(newVal, 'days').format('YYYY[-]MM[-]DD');


    }else if(newVal==1){
      $scope.availability.checkout = moment($scope.availability.checkin).add(1, 'days').format('YYYY[-]MM[-]DD');
      $scope.availability.display_checkout = moment($scope.availability.checkin).add(1, 'days').format('YYYY[-]MM[-]DD');

    }
   // console.log($scope.availability.checkout)
 })


}]).
directive('validNumber', function() {

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