var app = angular.module('adminApp', ['ui.bootstrap','bgf.paginateAnything', 'ngRoute'], function($interpolateProvider)
{
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
})
.factory('discountFactory', function($http){
	return {
		deleteDiscount : function(id)
		{
			return $http.post('/adminsite/discount/'+id+'/delete')
		},
		removeCustomer : function(id)
		{
			return $http.post('/adminsite/discount/customer/'+id+'/delete');
		}
	};
})
.controller('indexCtrl', ['$scope','$location','discountFactory', function($scope, $location, discountFactory)
{
	/*table*/
	$scope.loading=true;
	$scope.$on('pagination:loadPage', function (event, status, config) {
// config contains parameters of the page request
$scope.loading= false;

});
	$scope.$on('pagination:loadStart', function (event, status, config) {
// config contains parameters of the page request
$scope.loading=true;

});
	$scope.url = '/adminsite/discount/ajax';
	$scope.urlParams = {
		query : '',
		orderBy : '',
		token : 0
	}
	$scope.orderBy = 'created_at';
	$scope.deleteDiscount = function(data)
	{
		var prompt = confirm('Are you sure you want to delete this row?');
		if(prompt)
		{
			discountFactory.deleteDiscount(data.id).success(function(data){
				$scope.urlParams.token = Math.random();
				alert('Successfuly deleted.')
			}).error();

		}
		
	}
	$scope.viewDiscount = function(data)
	{

		$scope.selectedDiscount = angular.copy(data);
		$('#modal-view-discount').modal('show');
	}

	$scope.updateDiscount = function(data)
	{
		$scope.selectedDiscount = angular.copy(data);
		$('#modal-update-discount').modal({
			backdrop: 'static',
			keyboard: false
		})
	}
	$scope.$watch('orderBy', function(newVal, oldVal)
	{
		if(newVal!=oldVal)
		{
			$scope.urlParams.orderBy = angular.copy(newVal);
		}
	})
	$scope.$watch('query', function(newVal, oldVal)
	{
		if(newVal != oldVal)
		{
			$scope.urlParams.query = angular.copy(newVal);	
		}
	})
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
	/*end of table*/
	$scope.newcoupon =
	{
		name : '',
		type : null,
		code : '',
		description : ''
	}
	/*searching user */
	$('#search-user').keyup(function()
	{
		searchUser($(this).val());
//1_.debounce(searchUser,1000)
})
	var searchUser = function(query)
	{
		if(query=='')
		{
			$('#search-user-results').html('');
/*	$('#search-user').blur(function()
{

})*/
}
$.get('/adminsite/customer/search/'+query, function(data)
{
	$('#search-user-results').html('');
	var html = null;
	if(data.length>0)
	{
		_.map(data, function(data1)
		{
			if(data1.current_discount == null)
			{
				html = "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 search-item' style='background-color:rgb(191, 255, 191);white-space: nowrap;overflow:hidden;text-overflow: ellipsis;cursor:pointer;border:2px solid #1DC155;height:30px;margin-top:3px;padding:5px' data-customer-name='"+data1.fullname+"' data-customer-id='"+data1.membership_id+"'> "+data1.fullname+"	("+data1.membership_id+")</div>"
				$('#search-user-results').append($(html));
			}else
			{
				html = "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 already-registered' data-current-discount='"+data1.current_discount.name+"' style='background-color:#d8d8d8;white-space: nowrap;overflow:hidden;width:400px;text-overflow: ellipsis;cursor:not-allowed;border:2px solid maroon;color:maroon;height:30px;margin-top:3px;padding:5px' data-customer-name='"+data1.fullname+"' data-customer-id='"+data1.membership_id+"'> "+data1.fullname+"	("+data1.membership_id+") | member of "+data1.current_discount.name+"</div>"
				$('#search-user-results').append($(html));
			}
			
		})
}else
{
	html = "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12' style='cursor:pointer;border:2px solid #d8d8d8;height:30px;margin-top:3px;padding:5px;color:red'> No results found. </div>"
	$('#search-user-results').html($(html));
}

})
}

$(document).on('click','.already-registered', function()
{
	alert($(this).attr('data-customer-name')+" has ongoing  \""+$(this).attr('data-current-discount')+"\". You can update/delete the customer's current discount membership to re-enroll to other discount terms.")
});

$(document).on('click', '.search-item', function()
{
	$('#search-user').hide();
	$('#search-user-results').hide();
	$('#customer-id').val($(this).attr('data-customer-id'))
	var html = $(this).attr('data-customer-name')+' <button type="button" class="btn btn-xs btn-warning change-customer">Change</button>';
	$('#selected-user').html(html);
	$('#selected-user').show();
})
$('#set-customer-discount').click(function()
{
	$('#customer-id').val('');
	$('#search-user').show();
	$('#search-user-results').html('').show();
	$('#selected-user').hide();
	$('#set-customer-discount-form').trigger('reset');
	$('#modal-set-customer-discount').modal({
		backdrop: 'static',
		keyboard: false
	})
})
$('#new-discount').click(function()
{
	$('#modal-discount').modal({
		backdrop: 'static',
		keyboard: false
	})
})
$(document).on('click', '.change-customer', function()
{
	$('#customer-id').val('');
	$('#search-user').show();
	$('#search-user-results').show();
	$('#selected-user').hide();
})
$('.discount-type').on('change', function()
{
	if(this.value==0 && this.value!='')
	{
		$('.coupon-field').show();
	}else
	{

		$('.txtCoupon').val('');
		$('.txtCoupon').removeAttr('required');
		console.log($('.txtCoupon').val(), 'value of coupon field')
		$('.coupon-field').hide();
	}
})
}]).controller('showCtrl', ['$scope','$location','discountFactory','const_discount_id', function($scope, $location, discountFactory,const_discount_id)
{
	/*for tables*/
	$scope.url = '/adminsite/discount/'+const_discount_id+'/ajax';
	$scope.urlParams = {
		query : '',
		orderBy : 'created_at',
		token : 0
	}

	$scope.removeCustomer = function(id)
	{
		var con = window.confirm('Are you sure you want to unsubscribe this customer?')
		if(con)
		{
			discountFactory.removeCustomer(id).success(function()
			{
				$scope.urlParams.token = Math.random()
				alert('You have successfuly unsubscribe the customer.')
			})
		}
		
	}
	$scope.orderBy = 'created_at';
	$scope.$watch('orderBy', function(newVal, oldVal)
	{
		$scope.urlParams.orderBy = angular.copy(newVal);
	});
	$scope.$watch('query', function(newVal, oldVal)
	{
		if(newVal != oldVal)
		{
			$scope.urlParams.query = angular.copy(newVal);	
		}
	})

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

}]);