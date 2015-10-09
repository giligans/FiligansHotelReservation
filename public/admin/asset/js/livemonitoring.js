angular.module('liveMonitoringApp', [], function($interpolateProvider)
{
	$interpolateProvider.startSymbol('[[');
	$interpolateProvider.endSymbol(']]');
}).factory('liveMonitoringFactory', function($http){
	return {
		test : function(){
			alert('test');
		},
		loadRooms : function()
		{
			return $http.get('/adminsite/monitoring/ajax');
		},
		loadStatistics : function()
		{
			return $http.get('/adminsite/todaystatistics/ajax');
		}
	};
}).controller('indexCtrl', ['$scope', 'liveMonitoringFactory','$timeout','$interval', function($scope, liveMonitoringFactory, $timeout, $interval)
{
	$scope.rooms = [];
	$scope.statistics = [];
	function loadRooms()
	{
		liveMonitoringFactory.loadRooms().success(function(data)
		{
			$scope.rooms = angular.copy(data);
			$.map($scope.rooms, function(rooms, i)
			{
				var available =0, unavailable=0;
				$.map(rooms.room_qty, function(val, o)
				{

					var statusStr = '';
					if(val.room_reserved.length > 0)
					{
						var intStatus = parseInt(val.room_reserved[0].status);
						switch(intStatus)
						{
							case 0: statusStr='Pending';
							break;
							case 1: statusStr='Unavailable';
							break;
							case 2: statusStr='Occupied';
							break;
							case 3: statusStr='Ended';
							break;
							case 4: statusStr='Preparing';
							break;
							case 5: statusStr='Cancelled'
							break;
							case 6: statusStr='Overdue!'
							break;
							default : statusStr='Unavailable';
							break;
						}


						$scope.rooms[i].room_qty[o].room_reserved[0].statusStr = statusStr;
						if(val.room_reserved[0].status !=5 || val.room_reserved[0].status !=3)
						{
							unavailable++;

						}else
						{
							available++;
						}
					}
					else
					{
						available++;
					}
				})
				$scope.rooms[i].available = available;
				$scope.rooms[i].unavailable = unavailable;

			})
console.log($scope.rooms);
})
}
function loadStatistics()
{
	liveMonitoringFactory.loadStatistics().success(function(data)
	{
		$scope.statistics = angular.copy(data);
		console.log(data, 'datas');
	});
}
$scope.processBooking = function(data)
{
	if(data.room_reserved.length > 0 && (data.room_reserved[0].status!=5 || data.room_reserved[0].status!=3))
	{
		alert('occupied')
	}else
	{
		alert('avialble')
	}
}
$interval(function()
{
	loadRooms();
	loadStatistics();
},500)

}])