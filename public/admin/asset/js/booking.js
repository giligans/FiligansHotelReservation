angular.module('adminApp', ['ui.bootstrap','angularFileUpload','angularMoment', 'angularUtils.directives.dirPagination'], function ($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
}).factory('bookingFactory', ['$http', function($http){
	return {
		getBookingList : function()
		{
			return $http.get('/adminsite/getbookinglist');
		},
		updateBooking : function(data)
		{
			var info = {
				status : data.status,
				cancelled_remarks : data.cancelled_remarks,
				paid : data.paid
			}
			return $http.post('/adminsite/booking/'+data.id+'/update', info);
		},
		checkAvailability : function(data,quantity)
		{
			var a_info = {
				checkin : data.checkin,
				checkout : data.checkout,
				quantity : quantity,
			}
			return $http.post('/adminsite/room/'+data.room_id+'/availability', a_info);
		},
		bookingStep2 : function(data, quantity)
		{
			var booking_info = {
				checkin : data.checkin,
				checkout : data.checkout,
				quantity : quantity,
			}
			return $http.post('/adminsite/room/'+data.room_id+'/step2', booking_info);
		},
		advanceSearch : function(data)
		{
			var query_info = {
				startdate : data.startDate,
				enddate : data.endDate,
				room: data.r_room,
				status : data.r_status
			}
			return $http.post('/adminsite/getbookinglist/search', query_info);
		},
		bookingStep3 : function(data, id)
		{
			console.log(data);
			var customer_info = {
				booking_id : id,
				firstname : data.firstname,
				lastname : data.lastname,
				address : data.address,
				contact_no : data.contact_no
			}
			return $http.post('/adminsite/currentbooking/save', customer_info);
		}
	}
}]).controller('bookingController', ['$scope', 'bookingFactory','$timeout', function($scope, bookingFactory, $timeout){
	$scope.empty=false;
	loadBookingList();
	$scope.roomSearch ='';
	$scope.advs = [];
	$scope.per_page = 10;
	$scope.viewBooking = function(details){
		$scope.displayBooking = angular.copy(details);
		$('#viewModal').modal('show');
	}

	$scope.filter = {};
	function noFilter(filterObj) {
		for (var key in filterObj) {
			if (filterObj[key]) {
				return false;
			}
		}
		return true;
	}   
	$scope.filterByBooking = function (booking) {
		return $scope.filter[booking.status] || noFilter($scope.filter);
	};
	$scope.saveCustomerInformation = function()
	{
		bookingFactory.bookingStep3($scope.customer, $scope.currentBooking).success(function(data)
		{
			$('newBooking').modal('hide');
			window.location.reload();
		})
	}
	$scope.advs.startDate = moment().format('YYYY[-]MM[-]DD')
	$scope.advs.endDate = moment().format('YYYY[-]MM[-]DD')
	$scope.advs.r_room = 2; //means default;
	$scope.advs.r_status =2; // means default
	$scope.advanceSearch = function()
	{
		$scope.hideloading=false;
		bookingFactory.advanceSearch($scope.advs).success(function(data){
			$scope.booking = data;
			$timeout(function(){
				$scope.hideloading=true;
				if(data!=0)
				{
					
					var counter = $scope.booking.length;
					var checkout = null;
					var checkin = null;
					while(counter>0)
					{
						counter--;
						checkin = moment($scope.booking[counter].check_in.date);
						checkout = moment($scope.booking[counter].check_out.date);
						$scope.booking[counter].nights = checkout.diff(checkin, 'days')+1;
					}
					console.log($scope.booking)
					$scope.empty = false;
				}else{
					$scope.empty = true;
				}
			}, 1000);
		}).error();
		
	}
	$scope.newBookingModal = function()
	{	
		$scope.currentBooking =null; //this will be used after creating a new booking
		$scope.available = null; //
		$scope.displayform=true; //this is for the first form
		$scope.displayform2=false; //this is for the second form
		$scope.availability = {
			checkin : moment().format('YYYY[-]MM[-]DD'),
			checkout : moment().format('YYYY[-]MM[-]DD'),
			display_checkout : moment().add(1, 'days').format('YYYY[-]MM[-]DD')
		}
		$scope.nights=1;  $scope.quantity = 1; $scope.availability.room_id = 0;
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

		$('#newBooking').modal('show');
	}
	$scope.proceedStep2 = function()
	{
		$scope.loading=true;
		//this will proceed to customer information
		bookingFactory.bookingStep2($scope.availability, $scope.quantity).success(function(data)
		{
			$scope.currentBooking = angular.copy(data);
			$timeout(function()
			{
				$scope.loading=false;
				$scope.displayform=false;
				$scope.displayform2=true;
			},1000)
		}).error();
	}
	$scope.reloadBookingList = function(){
		loadBookingList();
	}
	$scope.updateModal = function(data){
		$scope.updateBooking = angular.copy(data);
		$scope.updateBooking.paid = 0;
		$scope.$watch('updateBooking.paid', function(newVal, oldVal){
			if(newVal != ""){
				//alert(newVal);
				if(parseFloat($scope.updateBooking.paid) < $scope.updateBooking.price)
				{
					$scope.paid = false;	
				}else{
					$scope.paid=true;
				}
			}else{
				//alert('hey')
				$scope.paid=false;
			}
		});	
		$('#updateBooking').modal('show');
	}
	$scope.saveChanges = function(){
		bookingFactory.updateBooking($scope.updateBooking).success(function(data){

			var i = $scope.booking.length;
			while(i!=0)
			{
				i--;
				if($scope.booking[i].id == data.id)
				{
					$scope.booking[i] = angular.copy(data);
					$scope.success=true;
					$timeout(function(){
						$scope.success = false;
					},3000)
				}
			}
			$('#updateBooking').modal('hide');
		}).error();
	}
	function loadBookingList(){
		bookingFactory.getBookingList().success(function(data){
			$timeout(function(){
				$scope.hideloading=true;
				if(data!=0)
				{
					$scope.booking = angular.copy(data);
					var counter = $scope.booking.length;
					var checkout = null;
					var checkin = null;
					while(counter>0)
					{
						counter--;
						checkin = moment($scope.booking[counter].check_in.date);
						checkout = moment($scope.booking[counter].check_out.date);
						$scope.booking[counter].nights = checkout.diff(checkin, 'days')+1;
					}
					console.log($scope.booking)
				}else{
					$scope.empty = true;
				}
			}, 1000);
		}).error(function()
		{
$scope.error = 1; //means something went wrong. probably network issues.
})
	}
	$scope.checkAvailability = function(){
		$scope.displayform = false;
		$scope.reservation = null;
		if($scope.availability.room_id!=0){
			$scope.loading = true;
			bookingFactory.checkAvailability($scope.availability, $scope.quantity).success(function(data){
				if(data.status==1){
					console.log(data);
					$scope.reservation = angular.copy(data);
					$scope.reservation.info = {
						room_id : $scope.availability.room_id,
						quantity : $scope.availability.quantity,
					}
					$timeout(function(){
						$scope.displayform = true;
						$scope.loading=false;
						$scope.available = 1;
					}, 1000)
				}else{
					$timeout(function(){
						$scope.displayform = true;
						$scope.loading=false;
						$scope.available = 0;
					}, 1000)
				}

			}).error();
		}else{
			$scope.available = null;
			$scope.displayform=true;
			$scope.displayform2=false;
			alert('Select a room type first!')
		}
	}
}]).filter('reverse', function() {
	return function(items) {
		return items.slice().reverse();
	};
})
.directive('validNumber', function() {

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