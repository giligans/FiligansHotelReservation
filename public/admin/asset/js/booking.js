angular.module('adminApp', ['ui.bootstrap','angularFileUpload','angularMoment', 'angularUtils.directives.dirPagination','bgf.paginateAnything', 'ngRoute'], function ($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
}).factory('bookingFactory', ['$http', function($http){
	return {
		checkMembership : function(membership_id)
		{
			return $http.get('/checkmembership/'+membership_id);
		},
		getBookingList : function()
		{
			return $http.get('/adminsite/getbookinglist');
		},
		updateBooking : function(data, otherinfo)
		{
			var info = {
				status : data.status,
				cancelled_remarks : data.cancelled_remarks,
				paid : data.paid,
				savethis:otherinfo.savethis,
				price_addition : otherinfo.price_addition,
				price_deduction : otherinfo.price_deduction,
				bookingremarks : otherinfo.bookingremarks
			}

			return $http.post('/adminsite/booking/'+data.id+'/update', info);
		},
		proceedPayment : function(data)
		{
			var info =
			{
				paid : data.paid
			}
			return $http.post('/adminsite/booking/'+data.id+'/payment', info);
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
		bookingStep2 : function(data, quantity, bookingId)
		{
			var booking_info = {
				checkin : data.checkin,
				checkout : data.checkout,
				quantity : quantity,
			}
			if(bookingId)
			{
				return $http.post('/adminsite/room/'+data.room_id+'/step2?bookingId='+bookingId, booking_info);
			}
			else
			{
				return $http.post('/adminsite/room/'+data.room_id+'/step2', booking_info);
			}
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
		getBookingInfo : function(data)
		{
			return $http.post('/adminsite/getbookinginfo/'+data);
		},
		bookingStep3 : function(data, id)
		{
			console.log('this is just a test',data);
			var customer_info = null;

			if(data.membership_id)
			{
				
				customer_info = {
					booking_id : id,
					membership_id : data.membership_id,
					firstname : data.firstname,
					lastname : data.lastname,
					address : data.address,
					contact_no : data.contact_no
				}
			}else
			{
				
				customer_info = {
					booking_id : id,

					firstname : data.firstname,
					lastname : data.lastname,
					/*address : data.address,
					contact_no : data.contact_no*/
				}
			}
			console.log('this is just a test',customer_info);
			return $http.post('/adminsite/currentbooking/save', customer_info);
		}
	}
}]).controller('bookingController', ['$scope', 'bookingFactory','$timeout','$location', function($scope, bookingFactory, $timeout, $location){
	/*for table*/

	$scope.url='/adminsite/getbookinglist'
	$scope.urlParams = {
		query : '',
		orderBy: 'updated_at',
		enddate: '',
		startdate: '',
		pending : false,
		paid : false,
		occupied : false,
		ended : false,
		preparing : false,
		test: 'test',
		cancelled : false,
		overdue : false
	}
	$scope.execSearch = function(data)
	{
		$scope.urlParams.query = data.raw;
		$scope.urlParams.enddate = data.enddate;
		$scope.urlParams.startdate = data.startdate;

		$scope.urlParams.pending = angular.copy(data.status[0]);
		$scope.urlParams.paid = data.status[1];
		$scope.urlParams.occupied = data.status[2];
		$scope.urlParams.ended = data.status[3];
		$scope.urlParams.preparing = data.status[4];
		$scope.urlParams.cancelled = data.status[5];
		$scope.urlParams.overdue = data.status[6];

		console.log($scope.urlParams, 'search executed');
	}
	
	$scope.clearSearch = function()
	{
		$scope.searchQuery = 
		{
			raw : '',
			startdate : '',
			enddate : '',
			status : {
				0 : false,
				1 : false,
				2 : false,
				3 : false,
				4 : false,
				5 : false,
				6 : false
			}
		}
	}

	$scope.searchQuery = 
	{
		raw : '',
		startdate : '',
		enddate : '',
		status : {
			0 : false,
			1 : false,
			2 : false,
			3 : false,
			4 : false,
			5 : false,
			6 : false
		}
	}
	$scope.membershipMessage = null;
	$scope.membership = null;
	$scope.isMember = null;
	$scope.validateMembership = function()
	{
		$scope.membershipMessage = 'Validating...'
		bookingFactory.checkMembership($scope.membership_id).success(function(data)
		{
			if(data.code!=1)
			{

				$scope.isMember=false;

			}else
			{
				$scope.customer = angular.copy(data.membership);
				$scope.isMember=true;
			}
			$scope.membershipMessage = angular.copy(data.content);

		}).error(function()
		{
			$scope.membershipMessage='Something went wrong. Please try again later.'
			$scope.discounted = false;
		})
	}
	$scope.bookingremarks='';
	$scope.price_deduction =0;
	$scope.price_addition =0;
	$scope.orderQuery = 'updated_at';
	$scope.urlParams.orderBy = angular.copy($scope.orderQuery);
	$scope.$watch('orderQuery', function(newVal, oldVal)
	{
		if(newVal!=oldVal)
		{
			$scope.urlParams.orderBy = newVal;
		}
	});

	$scope.loading_table=true;
	$scope.$on('pagination:loadPage', function (event, status, config) {
// config contains parameters of the page request
$scope.loading_table= false;
});
	$scope.$on('pagination:loadStart', function (event, status, config) {
	// config contains parameters of the page request
	$scope.loading_table=true;
});

	/*$scope.$watch('searchQuery', function(newVal, oldVal)
	{
		$scope.urlParams.query = angular.copy(newVal);
	});*/


$scope.perPage = parseInt($location.search().perPage, 10) || 5;
$scope.page = parseInt($location.search().page, 10) || 0;
$scope.clientLimit = 250;
$scope.$watch('page', function(page) { $location.search('page', page); });
$scope.$watch('perPage', function(page) { $location.search('perPage', page); });
$scope.$on('$locationChangeSuccess', function() {
	var page = +$location.search().page,
	perPage = +$location.search().perPage;
	if(page >= 0) { $scope.page = page; };
	if(perPage >= 0) { $scope.perPage = perPage; };
});

/*table*/
$scope.empty=false;
loadBookingList();
$scope.roomSearch ='';
$scope.advs = [];
$scope.invoiceInfo = []; //invoice information
$scope.insufficientFund = false;
$scope.selected_invoiceInfo= null;
$scope.bookingInfo =
{
	bookingId : false,
	rooms : [],
	info : []
} //this variable contains rooms that has been booked.
$scope.pendingBookingId = null; //this field is
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
$scope.testarr  = [
{
	name : 'test'
},
{
	name:'test2'
}
]
$scope.$watch('invoiceInfo', function(newVal, oldVal)
{
	if(newVal.paid != oldVal.paid)
	{
		$scope.invoiceInfo.change = newVal.paid - newVal.price;
	}
},true);
$scope.proceedPayment = function()
{
	$scope.loading = true;
	bookingFactory.proceedPayment($scope.invoiceInfo).success(function(data)
	{
		if(data==1)
		{
			$timeout(function()
			{
				$scope.loading=false;
				window.location.reload(true);
			},500)
		}else
		{
			$scope.insufficientFund = true;
		}

	}).error();
}
$scope.saveCustomerInformation = function()
{
	if($scope.isMember)
	{
		$scope.customer.membership_id = angular.copy($scope.membership_id);		
	}
	console.log('customer', $scope.customer);
	bookingFactory.bookingStep3($scope.customer, $scope.currentBooking).success(function(data)
	{
		$scope.loading = true;
		$scope.displayform2 = false;
		
		bookingFactory.getBookingInfo($scope.bookingInfo.bookingId).success(function(data)
		{
			$scope.invoiceInfo = angular.copy(data);
			_.map($scope.invoiceInfo.reserved_room_grp, function(data)
			{
			})
			console.log($scope.invoiceInfo, 'details of invoice')
		}).error();
		$timeout(function()
		{
			$scope.loading= false;
$scope.displayform3 = true; //payment form
},500);


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
$scope.$watch('anonymous', function(newVal, oldVal)
{
	if(newVal != oldVal)
	{
		$scope.membership = null;
		$scope.isMember = null;
		$scope.customer =
		{
			firstname : 'n/a',
			lastname : 'n/a',
			address : 'n/a',
			
			contact_no : 'n/a'
		}
	}
})
$scope.viewInvoice = function(data)
{
	$scope.selected_invoiceInfo = angular.copy(data);
	$('#invoice').modal('show');
}
$scope.newBookingModal = function()
{
$scope.invoiceInfo = []; //invoice information
$scope.insufficientFund = false;
$scope.moreRooms = false;
$scope.currentBooking =null; //this will be used after creating a new booking
$scope.available = null; //
$scope.displayform=true; //this is for the first form
$scope.displayform2=false; //this is for the second form
$scope.displayform3 = false;
$scope.availability = {
	checkin : moment().format('YYYY[-]MM[-]DD'),
	checkout :  moment().add(1, 'days').format('YYYY[-]MM[-]DD'),
	display_checkout : moment().add(1, 'days').format('YYYY[-]MM[-]DD')
}
$scope.nights=1;  $scope.quantity = 1; $scope.availability.room_id = 0;
$scope.$watch('availability.checkin', function(newVal, oldVal){
	if($scope.nights>1){
		$scope.availability.display_checkout = moment(newVal).add(1, 'days').format('YYYY[-]MM[-]DD');
		$scope.availability.checkout = moment(newVal).add(1, 'days').format('YYYY[-]MM[-]DD');
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
		$scope.availability.checkout =moment($scope.availability.checkin).add(newVal, 'days').format('YYYY[-]MM[-]DD');
		$scope.availability.display_checkout = moment($scope.availability.checkin).add(newVal, 'days').format('YYYY[-]MM[-]DD');
		console.log($scope.availability.display_checkout);
	}else if(newVal==1){
		$scope.availability.checkout = moment($scope.availability.checkin).add(1, 'days').format('YYYY[-]MM[-]DD');
		$scope.availability.display_checkout = moment($scope.availability.checkin).add(1, 'days').format('YYYY[-]MM[-]DD');
	}
// console.log($scope.availability.checkout)
})

$('#newBooking').modal('show');
}
$scope.addMoreRoom = function()
{
	var bookedRooms = angular.copy($scope.bookingInfo.rooms);
	var bookingId = $scope.bookingInfo.bookingId || false;
	$scope.loading=true;
	$scope.moreRooms = true; 
	$scope.available = 5;
	bookingFactory.bookingStep2($scope.availability, $scope.quantity, $scope.bookingInfo.bookingId).success(function(data)
	{
		bookedRooms.push(data.rooms);
		$scope.bookingInfo =
		{
			rooms : bookedRooms,
			bookingId : data.booking_id
		}
	}).error();
	$timeout(function()
	{
		$scope.loading=false;
	},500);
}

$scope.executePayment = function()
{
	
}

$scope.publishBooking = function()
{
	$scope.loading=true;
//this will proceed to customer information
bookingFactory.bookingStep2($scope.availability, $scope.quantity, $scope.bookingInfo.bookingId).success(function(data)
{
	$scope.bookingInfo.bookingId = angular.copy(data.booking_id);
	$scope.currentBooking = angular.copy(data.booking_id);
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
	var otherinfo = {
		savethis : (($scope.price_addition !=0 || $scope.price_deduction !=0) && $scope.bookingremarks !='') ? true : false,
		price_addition: $scope.price_addition,
		price_deduction:$scope.price_deduction,
		bookingremarks : $scope.bookingremarks
	}

	bookingFactory.updateBooking($scope.updateBooking,otherinfo).success(function(data){
		var i = $scope.booking.length;
		while(i!=0)
		{
			i--;
			if($scope.booking[i].id == data.id)
			{
				$scope.price_addition=0;
				$scope.price_deduction=0;
				$scope.bookingremarks='';

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
				console.log('booking',$scope.booking)
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
			console.log(data, 'data');
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