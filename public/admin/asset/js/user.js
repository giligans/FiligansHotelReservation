angular.module('adminApp', ['ui.bootstrap'], function ($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
})
.factory('userFactory', ['$http', function($http){
	return {
		test : function()
		{
			alert('hey')
		},
		addUser : function(data){
			var info = {
				firstname : data.firstname,
				lastname : data.lastname,
				username : data.username,
				role : data.role
			}
			return $http.post('/adminsite/user/create', info);
		},
		deleteUser : function(id){
			return $http.post('/adminsite/user/'+id+'/delete');
		},
		updateUser : function(data){
			var info = {
				firstname : data.firstname,
				lastname : data.lastname,
				role : data.role
			}
			return $http.post('/adminsite/user/'+data.id+'/update', info);
		},
	};
}]).controller('userController', ['$scope','userFactory','$timeout', function($scope, userFactory, $timeout){
//alert('hey')
$scope.closeModal = function(){
	$('#modal-id').modal('hide');
	$('#updateUser').modal('hide');
	$scope.user = null;
}
$scope.updateUser = function(data,indexrow){
	var index= indexrow;
	$scope.updateuser = angular.copy(data);
	$scope.updateuser.indexrow = indexrow;
	$('#updateUser').modal('show');
	//console.log($scope.updateuser)
}
$scope.triggerUpdateUser = function(index){
	userFactory.updateUser($scope.updateuser).success(function(data){
		if(data!=0){
			$scope.updatedrow = true;
			$timeout(function(){
				$scope.updatedrow=false;
			},3000);
			$('#updateUser').modal('hide');
			$scope.users[$scope.updateuser.indexrow] = data;

			
		}
		
	}).error();
}
$scope.deleteuser = function(data, index){
	swal({
		title: "Are you sure?",
		text: "You are about to delete the acount of \n \""+data.firstname+" "+data.lastname+"\"",
		type: "error",
		showCancelButton: true,
		confirmButtonClass: 'btn-danger',
		confirmButtonText: 'Danger!'
	}, function(isConfirm){
		if(isConfirm){
			userFactory.deleteUser(data.id).success(function(){
				$scope.users.splice(index,1);
				$scope.deletedrow = true;
				$timeout(function(){
					$scope.deletedrow=false;
				},3000)
			}).error();
		}else{
			
		}
	})
}
$scope.createUser = function(){
	$scope.disableCreate = true;
	userFactory.addUser($scope.user).success(function(data){
		if(data!=0){
			$('#modal-id').modal('hide');
			$scope.user = null;
			$scope.disableCreate = false;
			$scope.successCreate = true;
			$timeout(function(){
				$scope.successCreate = false;
			},3000)

		}
		$scope.users.push(data);
	}).error(function(){
	});
}
}])