'use strict';
angular.module('adminApp', ['ui.bootstrap','chart.js'], function ($interpolateProvider){
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
}).factory('reportFactory', ['$http', function($http){
    return {
        getBookingData : function()
        {
            return $http.get('/adminsite/reservation/list/ajax');
        }
    };
}]).controller('reportController', ['$scope','reportFactory','$timeout', function($scope, reportFactory, $timeout){

   $scope.labels = moment.monthsShort();    
   $scope.success_booking ={
    series : [],
    data : []
   }


  $scope.series = ['Series A'];
  $scope.data = [

    
  ];


   var success_series = [];
   var success_data = [];

   $scope.cancelled_booking ={
    series : [],
    data : []
   }
   var cancelled_series = [];
   var cancelled_data = [];


   $scope.legend=true;
 
   $scope.chartdata  = [];
   var rows = [];
   var count_r = [];
   var count_r2 = [];
   reservationList();

   function reservationList()
   {
    reportFactory.getBookingData().success(function(data)
    {
       var datas = [];
        if(data!=0){
            var i = data.length;
            var count = 0;

                 //var p_jan = 0;
                 //var p_feb=0, p_mar=0, p_apr=0, p_may=0, p_jun=0, p_jul=0, p_aug=0, p_sep=0, p_oct=0, p_nov=0, p_dec=0;
              
            while(i!=0)
            {
                count++;
                 var b_jan = 0;
                 var b_feb=0, b_mar=0, b_apr=0, b_may=0, b_jun=0, b_jul=0, b_aug=0, b_sep=0, b_oct=0, b_nov=0, b_dec=0;
  
                var data_bookings = [];
                i--;
                success_series.push(data[i].name)
                var x = data[i].room_qty.length;
                while(x!=0)
                {
                    x--;
                    var y = data[i].room_qty[x].room_reserved.length;
                    while(y!=0)
                    {
                        y--;
                        if(data[i].room_qty[x].room_reserved[y].status==1)
                        {
                            var checkin = moment(data[i].room_qty[x].room_reserved[y].check_in.date).month();
                          
                            if(checkin==0)
                            {

                                b_jan++;
                                 // console.log(b_jan)
                                 p_jan += parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }else if(checkin==1){
                                b_feb++;
                                p_feb += parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }
                            else if(checkin==2){
                                b_mar++;
                                p_mar+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }
                            else if(checkin==3){
                                b_apr++;
                                 p_apr+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }
                            else if(checkin==4){
                                b_may++;
                                 p_may+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }else if(checkin==5){
                                b_jun++;
                                 p_jun+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }else if(checkin==6){
                                b_jul++;
                                p_jul+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }else if(checkin==7){
                                b_aug++;
                                p_aug+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }else if(checkin==8){
                                b_sep++;
                                 p_sep+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }else if(checkin==9){
                                b_oct++;
                                p_oct+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }else if(checkin==10){
                                b_nov++;
                                 p_nov+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }
                            else if(checkin==11){
                                b_dec++;
                                 p_dec+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }

                           /*if(data[i].room_qty[x].room_reserved[y].o)*/
                        }
                    }
                }
                var data_bookings = [b_jan, b_feb, b_mar, b_apr, b_may, b_jun, b_jul, b_aug, b_sep, b_oct, b_nov, b_dec];
             //   var data_profit = [p_jan, p_feb, p_mar, p_apr, p_may, p_jun, p_jul, p_aug, p_sep, p_oct, p_nov, p_dec];
            ;
                success_data.push(data_bookings);
            }
           // console.log(data);
            console.log(datas);
            $timeout(function()
            {
                $scope.hideloading=true;
            },1000);
            $scope.success_booking.series = success_series;
            $scope.success_booking.series = success_series;
            $scope.success_booking.data = success_data;
               // $scope.data.push(data_profit)
                console.log($scope.data);
        }
     
        // console.log(count_r);
    }).error();
}

}])