angular.module('adminApp', ['ui.bootstrap','angularFileUpload'], function ($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
})
.factory('accountFactory', ['$http', function($http){
	return {
		test : function(){
			alert('hey')
		},
		changePassword : function(data, id){
			console.log(data);
			var info = {
				password : data.password,
				newPassword : data.newPassword,
				confirmPassword : data.confirmPassword
			}
			return $http.post('/adminsite/'+id+'/changepassword', info);	
		},
		deactivateAccount : function(){
			return $http.post('/adminsite/deactivateaccount');
		},
		changeAccountInformation : function(data, id){
			var info = {
				firstname : data.firstname,
				lastname : data.lastname,
				username : data.username
			}
			return $http.post('/adminsite/'+id+'/changeaccountinformation', info);
		}
	}
}]).controller('accountController', ['$scope','accountFactory','$timeout','$interval', function($scope, accountFactory, $timeout, $interval){
		/*ERROR
		0 - Something went wrong
		1 - success
		2 - wrong password
		3 - password mismatch
		*/
		var interval = null;
		$scope.deactivateAccount = function(){
			swal({
				title: "Are you sure?",
				text: "This will cause your account to be deleted permanently.",
				type: "error",
				showCancelButton: true,
				confirmButtonClass: 'btn-danger',
				confirmButtonText: 'Deactivate Account'
			}, function(isConfirm){
				if(isConfirm){
					$scope.countdown = 10;
					 interval = $interval(function(){
						$scope.countdown--;
						if($scope.countdown==10){
							$scope.deactivatemode=true;  			}
						}, 1000);
					$scope.$watch('countdown', function(newValue, oldValue){
						if(newValue<=0){
							$interval.cancel(interval);
							interval = 10;
						}

					})
				}
			});
		}
		$scope.cancelDeactivate = function(){
			$interval.cancel(interval);
			$scope.countdown=10;
		}
		$scope.changepassworderror = null;
		$scope.changeaccountinfo=null;
		$scope.updatePassword = function(){
			accountFactory.changePassword($scope.changepassword, $scope.user.id).success(function(data){
			//alert('hey')
			if(data==1){
				$scope.updatedpassword = true;
				$timeout(function(){
					$scope.updatedpassword = false;
				},3000)
				$('#modal-id').modal('hide');
			}else if(data==0){
				$scope.changepassworderror = 'Oops! Something went wrong. Try refreshing the page.'
			}else if(data==2){
				$scope.changepassworderror = 'The current password that you entered is invalid.'
			}else if(data==3){
				$scope.changepassworderror = 'Password Mismatch. Please reenter your new password.'
			}
		}).error();
		}

		$scope.updateAccountInformation = function(){
			accountFactory.changeAccountInformation($scope.user, $scope.user.id).success(function(data){
				$scope.updatemode=false;
				if(data!=0){
					$scope.user= angular.copy(data);
					$scope.updatedaccount = true;
					$timeout(function()
					{
						$scope.updatedaccount=false;
					},3000)
				}
			}).error();
		}
	}])
