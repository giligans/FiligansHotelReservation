angular.module('adminApp', ['ui.bootstrap'], function($interpolateProvider)
{
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
}).controller('indexCtrl', ['$scope', function($scope)
{
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
	/*$('#search-user').blur(function()
	{
		$('#search-user-results').html('');
	})
*/
$('.search-item').on('click', function()
{
	alert('test')
})
var searchUser = function(query)
{
	if(query=='')
	{
		$('#search-user').blur(function()
		{
			$('#search-user-results').html('');
		})

	}
	$.get('/adminsite/customer/search/'+query, function(data)
	{
		$('#search-user-results').html('');
		_.map(data, function(data1)
		{
			var html = "<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12 search-item' style='cursor:pointer;border:2px solid #d8d8d8;height:30px;margin-top:3px;padding:5px'> "+data1.fullname+"	</div>"
			$('#search-user-results').append($(html));
		})
	})
}


$('#create-coupon').submit(function(e)
{

})


$('#set-customer-discount').click(function()
{
	$('#modal-set-customer-discount').modal('show');
})

$('#new-discount').click(function()
{
	$('#modal-discount').modal('show');

})

$('#discount-type').on('change', function()	
{
	if(this.value==0 && this.value!='')
	{

		$('#coupon-field').show();
	}else
	{

		$('#txtCoupon').val('');
		$('#txtCoupon').removeAttr('required');
		console.log($('#txtCoupon').val(), 'value of coupon field')
		$('#coupon-field').hide();
	}
})

}])