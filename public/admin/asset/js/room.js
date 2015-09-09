/**
*  Admin App Module
*
* Description
*/
var app = angular.module('adminApp', ['ui.bootstrap','angularFileUpload'], function ($interpolateProvider){
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
})
.filter('range', function() {
	return function(input, total) {
		total = parseInt(total);
		for (var i=0; i<total; i++)
			input.push(i);
		return input;
	};
})
.factory('roomFactory', ['$http', function($http){
	return {
		createRoom : function(data){
			var info = {
				name : data.name,
				short_desc : data.short_desc,
				full_desc : data.full_desc,
				max_adults : data.max_adults,
				max_children : data.max_children,
				beds : data.beds,
				bathrooms: data.bathrooms,
				area : data.area,
				price:data.price,
				no_of_rooms : data.no_of_rooms,
				images : data.images
			}
			return $http.post('/adminsite/room/create', info);
		},
		updateRoom : function(data, id){
			var info = {
				name : data.name,
				short_desc : data.short_desc,
				full_desc : data.full_desc,
				max_adults : data.max_adults,
				max_children : data.max_children,
				beds : data.beds,
				bathrooms: data.bathrooms,
				area : data.area,
				price:data.price,
				no_of_rooms : data.no_of_rooms,
				images : data.images
			}
			return $http.post('/adminsite/room/'+data.id+'/update', info);
		},
		validateRoomNo : function(data){
			return $http.get('/adminsite/room/'+data+'/validate');
		},
		deleteSpecificRoom : function(id){
			return $http.post('/adminsite/room/'+id+'/deletespecific');
		},
		addRoom : function(room_id, data){
			
			return $http.post('/adminsite/room/'+room_id+'/addroom', data);
		},
		deleteRoom : function(id)
		{
			return $http.post('/adminsite/room/'+id+'/delete');
		},
		updateRoomNo : function(data){
			return $http.post('/adminsite/room/'+data.id+'/updatespecific', data);
		},
		loadAllRooms : function(data){
			return $http.get('/adminsite/room/all');
		},
		searchRoomNo : function(data)
		{
			return $http.get('/adminsite/room/search/'+data);
		}
	};
}])
.controller('indexRoomCtrl', ['$scope','roomFactory','$timeout', function($scope, roomFactory, $timeout){

	loadRooms();
	
	$scope.searchRoom = function()
	{
		$scope.hideloading=false;
		if(_.isUndefined($scope.room_q))
		{
			roomFactory.loadAllRooms().success(function(data){
			$scope.rooms = angular.copy(data);
			$timeout(function()
			{
				$scope.hideloading=true;
			},1000);
			$scope.loadingrooms = true;

		}).error(function(){
//some errors.
});
		
		}else{
		roomFactory.searchRoomNo($scope.room_q).success(function(data){
			$scope.rooms = angular.copy(data);
			$timeout(function()
			{
				$scope.hideloading=true;
			},1000);
		}).error();
		}
	}
	function loadRooms(){
		roomFactory.loadAllRooms().success(function(data){
			$scope.rooms = angular.copy(data);
			$timeout(function()
			{
				$scope.hideloading=true;
			},1000);
			$scope.loadingrooms = true;

		}).error(function(){
//some errors.
});
	}
//alert('hey')
}])
.controller('roomCtrl', ['$scope','roomFactory','$timeout','room_id', function($scope, roomFactory, $timeout, room_id){
	$scope.roomSearch = "";
	$scope.addRoomsInfo = []; 

	
	$scope.$watch('quantity', function(){
		$scope.addRoomsInfo = [];
		var sampledata = [];
		var quantity = parseInt($scope.quantity);
		for(var i=quantity;i>0;i--){
			var info = {
				indexing : i,
				validation:0,
				room_no : null,
			}
			$scope.addRoomsInfo.push(info);

		}
		console.log($scope.addRoomsInfo.length)
	})
	console.log($scope.addRoomsInfo);
	$scope.addRoomModal = function(){
		$('#addRoom').modal('show');
	}
	/*Saving room details ( this will add more rooms to a certain room type )*/
	$scope.saveRoom = function(id){
		roomFactory.addRoom(id, $scope.addRoomsInfo).success(function(data){
			console.log(data);
		}).error(function(){

		});
	}

	/*VALIDATION FOR ROOM THE already exist*/
	$scope.validateRoomNo = function(data){
	/*VALIDATION RULES
0 = UNAVAILABLE
1 = AVAILABLE
2 = LOADING
5 = ERROR
*/
var index = data;
console.log($scope.addRoomsInfo);
_.debounce(validateRoomNumber($scope.addRoomsInfo[data].room_no), 2000);
function validateRoomNumber(data){
	console.log('data :'+index);
	$scope.addRoomsInfo[index].validation = 2;
	roomFactory.validateRoomNo(data).success(function(data){
		if(data!=5){
			$scope.addRoomsInfo[index].validation = data;
		}
	}).error(function(){
		$scope.addRoomsInfo[index].validation = 0;
	});
}
}

$scope.updateRoomModal = function(data, index){
	$scope.updateroom = angular.copy(data);
	$scope.updateroom.indexrow = index;
	$('#updateRoom').modal('show');
	console.log($scope.updateroom)
}
/*THIS WILL UPDATE  A SPECIFIC ROOM.*/
$scope.updateSpecificRoom = function(){
	roomFactory.updateRoomNo($scope.updateroom).success(function(data){
if(data!=0){ //0 means fail
	$scope.room_qty[$scope.updateroom.indexrow] = angular.copy(data);_
	$('#updateRoom').modal('hide');
}
}).error();
}

$scope.deleteRoom = function()
{
	swal({
		title: "Are you sure?",
		text: "You want to delete this room? \n",
		type: "error",
		showCancelButton: true,
		confirmButtonClass: 'btn-danger',
		confirmButtonText: 'Delete!'
	}, function(isConfirm){
		if(isConfirm){
			var deleteRoom = null;

			var i = 0;
			for(i=$scope.room_qty.length;i>0;i--){
				//console.log($scope.room_qty[i-1].room_reserved.length)
				if($scope.room_qty[i-1].room_reserved.length!=0)
				{
					deleteRoom=false;

				}else{
					deleteRoom=true;
				}
			}
			if(deleteRoom==false)
			{
				alert('You can\'t delete this because some rooms are occupied or booked')
			}else{
				roomFactory.deleteRoom(room_id).success(function()
				{
					$scope.loading=true;
					$timeout(function()
					{
						window.location = '/adminsite/room'
					},1000)

				}).error();
			}
		}else{
			
		}
	})
}
$scope.deleteSpecificRoom = function(data, index){
	swal({
		title: "Are you sure?",
		text: "You room number \n"+data.room_no,
		type: "error",
		showCancelButton: true,
		confirmButtonClass: 'btn-danger',
		confirmButtonText: 'Delete!'
	}, function(isConfirm){
		if(isConfirm){
			roomFactory.deleteSpecificRoom(data.id).success(function(){
				$scope.room_qty.splice(index,1);
				$scope.deletedrow = true;
				$timeout(function(){
					$scope.deletedrow=false;
				},3000)
			}).error();
		}else{
			
		}
	})
}

}])
.controller('createRoomCtrl', ['$scope','FileUploader','roomFactory', function($scope, FileUploader, roomFactory){
	$scope.images = [];
	$scope.createRoom = function(){
		$scope.disablecreate = true;
		var room_info = {
			name : $scope.name,
			short_desc : $scope.short_desc,
			full_desc : $scope.full_desc,
			max_adults : $scope.max_adults,
			max_children : $scope.max_children,
			beds : $scope.beds,
			bathrooms : $scope.bathrooms,
			area : $scope.area,
			price : $scope.price,
			no_of_rooms : $scope.no_of_rooms,
			images : $scope.images
		}
		roomFactory.createRoom(room_info).success(function(data){
//console.log(data.id)
window.location = '/adminsite/room/'+data.id;
$scope.disablecreate = false;
}).error(function(){
})
}
/*for update room*/
$scope.update_deleteImage = function(index){
	var room_images = angular.copy($scope.room.room_images);
	room_images.splice(index,1);
	$scope.room.room_images = angular.copy(room_images);
}
$scope.create_deleteImage = function(index){
	var room_images = angular.copy($scope.images);
	room_images.splice(index,1);
	$scope.images = angular.copy(room_images);
}
$scope.updateRoom = function(){
	console.log($scope.room.room_images)
	$scope.disablecreate = true;
	var room_info = {
		id : $scope.room.id,
		name : $scope.room.name,
		short_desc : $scope.room.short_desc,
		full_desc : $scope.room.full_desc,
		max_adults : $scope.room.max_adults,
		max_children : $scope.room.max_children,
		beds : $scope.room.beds,
		bathrooms : $scope.room.bathrooms,
		area : $scope.room.area,
		price : $scope.room.price,
			//no_of_rooms : $scope.room.no_of_rooms,
			images : $scope.room.room_images
		}
		roomFactory.updateRoom(room_info).success(function(data){
//console.log(data)
window.location = '/adminsite/room/'+data.id;
$scope.disablecreate = false;
}).error(function(){
})
}


var roomimages = [];
var uploader = $scope.uploader = new FileUploader({
	url: '/testupload'
});
uploader.filters.push({
	name: 'imageFilter',
	fn: function(item /*{File|FileLikeObject}*/, options) {
		var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
		return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
	}
});
uploader.onCompleteItem = function(fileItem, response, status, headers) {
//console.info('onCompleteItem', fileItem, response, status, headers);
roomimages.push(response);
console.log(roomimages)
$scope.images = angular.copy(roomimages);
if(!_.isUndefined($scope.room))
{	
	$scope.u_images = angular.copy($scope.room.room_images);
	console.log($scope.u_images)
	$scope.u_images.push(response);
	$scope.room.room_images = angular.copy($scope.u_images);
	console.log(response);

}


};
uploader.onCompleteAll = function() {
	$scope.uploader.queue = [];
	console.log($scope.uploader.queue.length)
};
console.info('uploader', uploader);
}]);