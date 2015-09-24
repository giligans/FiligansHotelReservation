angular.module('adminApp', ['ui.bootstrap','chart.js'], function ($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
}).factory('dashboardFactory', ['$http', function($http){
	return {
		getSuccessBooking : function()
		{
			return $http.get('/adminsite/dashboard/success_booking/ajax');
		},
		getPendingBooking : function()
		{
			return $http.get('/adminsite/dashboard/pending_booking/ajax');
		},
		getOccupiedBooking : function()
		{
			return $http.get('/adminsite/dashboard/occupied_booking/ajax');
		},
		getPreparingBooking : function()
		{
			return $http.get('/adminsite/dashboard/preparing_booking/ajax');
		},
		getEndedBooking : function()
		{
			return $http.get('/adminsite/dashboard/ended_booking/ajax');
		},
		getCancelledBooking : function()
		{
			return $http.get('/adminsite/dashboard/cancelled_booking/ajax'); 
		},
		getArrivallBooking : function()
		{
			return $http.get('/adminsite/dashboard/arrival/ajax'); 
		},
		getDeparture : function()
		{
			return $http.get('/adminsite/dashboard/departure/ajax'); 
		},
		updateBooking : function(data)
		{
			var info = {
				status : data.status,
				cancelled_remarks : data.cancelled_remarks
			}
			return $http.post('/adminsite/booking/'+data.id+'/update', info);
		}
	};
}]).controller('dashboardController', ['$scope','dashboardFactory', function($scope, dashboardFactory){

}])
/*for success bookings today at dashboard page.*/
.controller('successController', ['$scope','dashboardFactory','$timeout', function($scope, dashboardFactory, $timeout){
	$scope.viewBooking = function(details){
		$scope.displayBooking = angular.copy(details);
		$('#viewModal').modal('show');
	}
	$scope.viewInvoice = function(data)
	{
		$scope.selected_invoiceInfo = angular.copy(data);
		$('#invoice').modal('show');
	}

	$scope.updateBookingBtn = function(data){
		
		$scope.updateBooking = angular.copy(data);
		$scope.updateBooking.paid = $scope.updateBooking.paid || 0;
		$scope.$watch('editBooking.paid', function(newVal, oldVal){
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

		dashboardFactory.updateBooking($scope.editBooking).success(function(data){
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
			$('#updateModal').modal('hide');
		}).error();

	}

	loadSuccessBooking();
	function loadSuccessBooking()
	{
		dashboardFactory.getSuccessBooking().success(function(data)
		{
			$scope.booking = angular.copy(data);

			var checkout = null;
			var checkin = null;
			
			$timeout(function()
			{
				$scope.hideloading=true;
			},1000)
		}).error();

	}
}])
.controller('pendingController', ['$scope','dashboardFactory','$timeout', function($scope, dashboardFactory, $timeout){
	$scope.viewBooking = function(details){
		$scope.displayBooking = angular.copy(details);
		$('#viewModal').modal('show');
	}
	$scope.viewInvoice = function(data)
	{
		$scope.selected_invoiceInfo = angular.copy(data);
		$('#invoice').modal('show');
	}

	$scope.updateBookingBtn = function(data){
		
		$scope.updateBooking = angular.copy(data);
		$scope.updateBooking.paid = $scope.updateBooking.pai || 0;
		$scope.$watch('editBooking.paid', function(newVal, oldVal){
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

		dashboardFactory.updateBooking($scope.editBooking).success(function(data){
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
			$('#updateModal').modal('hide');
		}).error();

	}

	loadPendingBooking();
	function loadPendingBooking()
	{
		dashboardFactory.getPendingBooking().success(function(data)
		{
			$scope.booking = angular.copy(data);

			var checkout = null;
			var checkin = null;
			
			$timeout(function()
			{
				$scope.hideloading=true;
			},1000)
		}).error();

	}
}])

.controller('occupiedController', ['$scope','dashboardFactory','$timeout', function($scope, dashboardFactory, $timeout){
	$scope.viewBooking = function(details){
		$scope.displayBooking = angular.copy(details);
		$('#viewModal').modal('show');
	}
	$scope.viewInvoice = function(data)
	{
		$scope.selected_invoiceInfo = angular.copy(data);
		$('#invoice').modal('show');
	}

	$scope.updateBookingBtn = function(data){
		
		$scope.updateBooking = angular.copy(data);
		$scope.updateBooking.paid = $scope.updateBooking.paid || 0;
		$scope.$watch('editBooking.paid', function(newVal, oldVal){
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

		dashboardFactory.updateBooking($scope.editBooking).success(function(data){
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
			$('#updateModal').modal('hide');
		}).error();

	}

	loadOccupiedBooking();
	function loadOccupiedBooking()
	{
		dashboardFactory.getOccupiedBooking().success(function(data)
		{
			$scope.booking = angular.copy(data);

			var checkout = null;
			var checkin = null;
			
			$timeout(function()
			{
				$scope.hideloading=true;
			},1000)
		}).error();

	}
}])

.controller('preparingController', ['$scope','dashboardFactory','$timeout', function($scope, dashboardFactory, $timeout){
	$scope.viewBooking = function(details){
		$scope.displayBooking = angular.copy(details);
		$('#viewModal').modal('show');
	}
	$scope.viewInvoice = function(data)
	{
		$scope.selected_invoiceInfo = angular.copy(data);
		$('#invoice').modal('show');
	}
	
	$scope.updateBookingBtn = function(data){
		
		$scope.updateBooking = angular.copy(data);
		$scope.updateBooking.paid = $scope.updateBooking.paid || 0;
		$scope.$watch('editBooking.paid', function(newVal, oldVal){
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

		dashboardFactory.updateBooking($scope.editBooking).success(function(data){
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
			$('#updateModal').modal('hide');
		}).error();

	}

	loadPreparingBooking();
	function loadPreparingBooking()
	{
		dashboardFactory.getPreparingBooking().success(function(data)
		{
			$scope.booking = angular.copy(data);

			var checkout = null;
			var checkin = null;
			
			$timeout(function()
			{
				$scope.hideloading=true;
			},1000)
		}).error();

	}
}])

.controller('endedController', ['$scope','dashboardFactory','$timeout', function($scope, dashboardFactory, $timeout){
	$scope.viewBooking = function(details){
		$scope.displayBooking = angular.copy(details);
		$('#viewModal').modal('show');
	}
	$scope.updateBooking = function(details)
	{
		$scope.editBooking = angular.copy(details);
		$('#updateModal').modal('show');
	}
	$scope.saveChanges = function(){
		dashboardFactory.updateBooking($scope.editBooking).success(function(data){
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
			$('#updateModal').modal('hide');
		}).error();
	}
	loadPendingBooking();
	function loadPendingBooking()
	{
		dashboardFactory.getPendingBooking().success(function(data)
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
				
			}
			$timeout(function()
			{

				$scope.hideloading=true;
			},1000)
		}).error();
	}
}])


.controller('cancelledController', ['$scope','dashboardFactory','$timeout', function($scope, dashboardFactory, $timeout){
	$scope.viewBooking = function(details){
		$scope.displayBooking = angular.copy(details);
		$('#viewModal').modal('show');
	}
	$scope.viewInvoice = function(data)
	{
		$scope.selected_invoiceInfo = angular.copy(data);
		$('#invoice').modal('show');
	}

	$scope.updateBookingBtn = function(data){
		
		$scope.updateBooking = angular.copy(data);
		$scope.updateBooking.paid = $scope.updateBooking.paid || 0;
		$scope.$watch('editBooking.paid', function(newVal, oldVal){
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

		dashboardFactory.updateBooking($scope.editBooking).success(function(data){
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
			$('#updateModal').modal('hide');
		}).error();

	}

	loadCancelledBooking();
	function loadCancelledBooking()
	{
		dashboardFactory.getCancelledBooking().success(function(data)
		{
			$scope.booking = angular.copy(data);

			var checkout = null;
			var checkin = null;
			
			$timeout(function()
			{
				$scope.hideloading=true;
			},1000)
		}).error();

	}
}])
.controller('arrivalController', ['$scope','dashboardFactory','$timeout', function($scope, dashboardFactory, $timeout){
	$scope.viewBooking = function(details){
		$scope.displayBooking = angular.copy(details);
		$('#viewModal').modal('show');
	}
	$scope.viewInvoice = function(data)
	{
		$scope.selected_invoiceInfo = angular.copy(data);
		$('#invoice').modal('show');
	}

	$scope.updateBookingBtn = function(data){
		$scope.updateBooking = angular.copy(data);
		$scope.updateBooking.paid = $scope.updateBooking.paid || 0;
		$scope.$watch('editBooking.paid', function(newVal, oldVal){
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
		dashboardFactory.updateBooking($scope.editBooking).success(function(data){
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
			$('#updateModal').modal('hide');
		}).error();
	}

	loadArrivalBooking();
	function loadArrivalBooking()
	{
		dashboardFactory.getArrivallBooking().success(function(data)
		{
			$scope.booking = angular.copy(data);

			var checkout = null;
			var checkin = null;
			
			$timeout(function()
			{
				$scope.hideloading=true;
			},1000)
		}).error();

	}
}])

