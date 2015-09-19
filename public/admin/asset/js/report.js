'use strict';
var filigansapp = angular.module('adminApp', ['ui.bootstrap','chart.js'], function ($interpolateProvider){
    $interpolateProvider.startSymbol('[[');
    $interpolateProvider.endSymbol(']]');
}).factory('reportFactory', ['$http','filtersetting', function($http, filtersetting){
    return {
        getBookingData : function()
        {
            if(filtersetting.type=='0' || filtersetting.type=='1')
            {
                return $http.get('/adminsite/reservation/list/ajax?filtertype='+filtersetting.type+'&year1='+filtersetting.year1+'&year2='+filtersetting.year2);
            }
            else{
                return $http.get('/adminsite/reservation/list/ajax')
            }
        }
    };
}]).controller('reportController', ['$scope','reportFactory','$timeout','filtersetting', function($scope, reportFactory, $timeout, filtersetting){
$scope.filtersetting = 0; // initial settings of the filter
$scope.year1=0;
$scope.year2=0;

$scope.submitFilter = function()
{

}
$scope.labels = moment.monthsShort();    
$scope.success_booking ={
    series : [],
    data : []
}

$scope.compare_booking = 
{
    year1 : 
    {
        series : [],
        data : []
    },
    year2 : 
    {
        series : [],
        data : []
    }

}
/*ONLINE SALES*/
if(filtersetting.filtertype==0)
{
  $scope.series = [filtersetting.year1];  
}else
{
    $scope.series = [filtersetting.year1,filtersetting.year2];
}

$scope.data = [];

/*WALK-IN SALES*/
if(filtersetting.filtertype==0)
{
  $scope.series2 = [filtersetting.year1];  
}else
{
    $scope.series2 = [filtersetting.year1,filtersetting.year2];
}

$scope.data2 = [];

var success_series = [];
var success_series2 = [];
var success_data = []; //for year 1
var success_data2 = []; //for year 2

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
        console.log(data);
        var datas = [];
        if(data!=0){
            var i = data.length;
            var year1_count=0,year2_count=0;
            if(filtersetting.type==1)
            {
                var year1_count=data.year1.length || 0;
                var year2_count=data.year2.length || 0;
            }

            var count = 0;
            /*ONLINE BOOKING SALES*/
            var p_jan = 0;
            var p_feb=0, p_mar=0, p_apr=0, p_may=0, p_jun=0, p_jul=0, p_aug=0, p_sep=0, p_oct=0, p_nov=0, p_dec=0;
            
            /*To be used in comparing previous years*/
            var p2_jan = 0;
            var p2_feb=0, p2_mar=0, p2_apr=0, p2_may=0, p2_jun=0, p2_jul=0, p2_aug=0, p2_sep=0, p2_oct=0, p2_nov=0, p2_dec=0;
            

            /*WALK IN SALES*/
            var w_jan = 0;
            var w_feb=0, w_mar=0, w_apr=0, w_may=0, w_jun=0, w_jul=0, w_aug=0, w_sep=0, w_oct=0, w_nov=0, w_dec=0;

            /*To be used in comparing previous years*/
            var w2_jan = 0;
            var w2_feb=0, w2_mar=0, w2_apr=0, w2_may=0, w2_jun=0, w2_jul=0, w2_aug=0, w2_sep=0, w2_oct=0, w2_nov=0, w2_dec=0;

            if(filtersetting.type!=1)
            {

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
                            if(data[i].room_qty[x].room_reserved[y].status==1 || data[i].room_qty[x].room_reserved[y].status==3 || data[i].room_qty[x].room_reserved[y].status==2)
                            {
                                var checkin = moment(data[i].room_qty[x].room_reserved[y].check_in.date).month();

                                if(checkin==0)
                                {
                                    b_jan++;
                                 // console.log(b_jan)
                                 if(data[i].room_qty[x].room_reserved[y].code=='N/A')
                                 {
                                    w_jan += parseInt(data[i].room_qty[x].room_reserved[y].price);
                                }else{
                                    console.log(data[i].room_qty[x].room_reserved[y])
                                    p_jan += parseInt(data[i].room_qty[x].room_reserved[y].price);
                                }

                            }else if(checkin==1){

                                b_feb++;
                                if(data[i].room_qty[x].room_reserved[y].code=='N/A')
                                {
                                    w_feb += parseInt(data[i].room_qty[x].room_reserved[y].price); 
                                }else{
                                   p_feb += parseInt(data[i].room_qty[x].room_reserved[y].price); 
                               }

                           }
                           else if(checkin==2){
                            b_mar++;
                            if(data[i].room_qty[x].room_reserved[y].code=='N/A')
                            {

                                w_mar+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }else{
                                p_mar+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }
                        }
                        else if(checkin==3){
                            b_apr++;
                            if(data[i].room_qty[x].room_reserved[y].code=='N/A')
                            {
                                w_apr+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }else{
                             p_apr+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                         }
                     }
                     else if(checkin==4){
                        b_may++;
                        if(data[i].room_qty[x].room_reserved[y].code=='N/A')
                        {
                            w_may+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                        }else{
                         p_may+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                     }
                 }else if(checkin==5){
                    b_jun++;
                    if(data[i].room_qty[x].room_reserved[y].code=='N/A')
                    {
                        w_jun+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                    }else{
                     p_jun+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                 }
             }else if(checkin==6){
                b_jul++;
                if(data[i].room_qty[x].room_reserved[y].code=='N/A')
                {
                    w_jul+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                }else{
                    p_jul+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                }
            }else if(checkin==7){
                b_aug++;
                if(data[i].room_qty[x].room_reserved[y].code=='N/A')
                {
                    w_aug+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                }else{
                    p_aug+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                }
            }else if(checkin==8){
                b_sep++;
                if(data[i].room_qty[x].room_reserved[y].code=='N/A')
                {
                    w_sep+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                }else{

                 p_sep+=parseInt(data[i].room_qty[x].room_reserved[y].price);
             }
         }else if(checkin==9){
            b_oct++;
            if(data[i].room_qty[x].room_reserved[y].code=='N/A')
            {
                w_oct+=parseInt(data[i].room_qty[x].room_reserved[y].price);
            }else{
                p_oct+=parseInt(data[i].room_qty[x].room_reserved[y].price);
            }
        }else if(checkin==10){
            b_nov++;
            if(data[i].room_qty[x].room_reserved[y].code=='N/A')
            {
                w_nov+=parseInt(data[i].room_qty[x].room_reserved[y].price);
            }else{
             p_nov+=parseInt(data[i].room_qty[x].room_reserved[y].price);
         }
     }
     else if(checkin==11){
        b_dec++;
        if(data[i].room_qty[x].room_reserved[y].code=='N/A')
        {   
            w_dec+=parseInt(data[i].room_qty[x].room_reserved[y].price);
        }else{
         p_dec+=parseInt(data[i].room_qty[x].room_reserved[y].price);
     }
 }

 /*if(data[i].room_qty[x].room_reserved[y].o)*/
}
} //end while
}// end of if(filtersetting.type!=1)
var data_bookings = [b_jan, b_feb, b_mar, b_apr, b_may, b_jun, b_jul, b_aug, b_sep, b_oct, b_nov, b_dec];
var data_profit = [p_jan, p_feb, p_mar, p_apr, p_may, p_jun, p_jul, p_aug, p_sep, p_oct, p_nov, p_dec]; //online sales
var data_profit2 = [w_jan, w_feb, w_mar, w_apr, w_may, w_jun, w_jul, w_aug, w_sep, w_oct, w_nov, w_dec]; //walk-in sales
var data_profit3 = [data_profit, data_profit2];
console.log('testtesst')
console.log(data_profit3)
success_data.push(data_bookings);
} // end of first if


}else
{

 while(year1_count!=0)
 {
    count++;
    var b_jan = 0;
    var b_feb=0, b_mar=0, b_apr=0, b_may=0, b_jun=0, b_jul=0, b_aug=0, b_sep=0, b_oct=0, b_nov=0, b_dec=0;

    var b2_jan = 0;
    var b2_feb=0, b2_mar=0, b2_apr=0, b2_may=0, b2_jun=0, b2_jul=0, b2_aug=0, b2_sep=0, b2_oct=0, b2_nov=0, b2_dec=0;

    var data_bookings = [];
    year1_count--;
    success_series.push(data.year1[year1_count].name)
    var x = data.year1[year1_count].room_qty.length;
    while(x!=0)
    {
        x--;
        var y = data.year1[year1_count].room_qty[x].room_reserved.length;
        while(y!=0)
        {
            y--;
            if(data.year1[year1_count].room_qty[x].room_reserved[y].status==1 || data.year1[year1_count].room_qty[x].room_reserved[y].status==3 || data.year1[year1_count].room_qty[x].room_reserved[y].status==2)
            {
                var checkin = moment(data.year1[year1_count].room_qty[x].room_reserved[y].check_in.date).month();

                if(checkin==0)
                {
                    b_jan++;
                                 // console.log(b_jan)
                                 if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
                                 {
                                    w_jan += parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                                }else{
                                    console.log(data.year1[year1_count].room_qty[x].room_reserved[y])
                                    p_jan += parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                                }

                            }else if(checkin==1){

                                b_feb++;
                                if(data.year[year1_count].room_qty[x].room_reserved[y].code=='N/A')
                                {
                                    w_feb += parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price); 
                                }else{
                                   p_feb += parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price); 
                               }

                           }
                           else if(checkin==2){
                            b_mar++;
                            if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
                            {

                                w_mar+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                            }else{
                                p_mar+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                            }
                        }
                        else if(checkin==3){
                            b_apr++;
                            if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
                            {
                                w_apr+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                            }else{
                             p_apr+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                         }
                     }
                     else if(checkin==4){
                        b_may++;
                        if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
                        {
                            w_may+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                        }else{
                         p_may+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                     }
                 }else if(checkin==5){
                    b_jun++;
                    if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
                    {
                        w_jun+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                    }else{
                     p_jun+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                 }
             }else if(checkin==6){
                b_jul++;
                if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
                {
                    w_jul+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                }else{
                    p_jul+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                }
            }else if(checkin==7){
                b_aug++;
                if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
                {
                    w_aug+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                }else{
                    p_aug+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                }
            }else if(checkin==8){
                b_sep++;
                if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
                {
                    w_sep+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
                }else{

                 p_sep+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
             }
         }else if(checkin==9){
            b_oct++;
            if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
            {
                w_oct+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
            }else{
                p_oct+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
            }
        }else if(checkin==10){
            b_nov++;
            if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
            {
                w_nov+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
            }else{
             p_nov+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
         }
     }
     else if(checkin==11){
        b_dec++;
        if(data.year1[year1_count].room_qty[x].room_reserved[y].code=='N/A')
        {
            w_dec+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
        }else{
         p_dec+=parseInt(data.year1[year1_count].room_qty[x].room_reserved[y].price);
     }
 }

 /*if(data[i].room_qty[x].room_reserved[y].o)*/
}
} //end while
}// end of if(filtersetting.type!=1)
var year1_data_bookings = [b_jan, b_feb, b_mar, b_apr, b_may, b_jun, b_jul, b_aug, b_sep, b_oct, b_nov, b_dec];
success_data.push(year1_data_bookings);
} //end of while


/*
var data_bookings = [b_jan, b_feb, b_mar, b_apr, b_may, b_jun, b_jul, b_aug, b_sep, b_oct, b_nov, b_dec];
var data_profit = [p_jan, p_feb, p_mar, p_apr, p_may, p_jun, p_jul, p_aug, p_sep, p_oct, p_nov, p_dec]; //online sales
var data_profit2 = [w_jan, w_feb, w_mar, w_apr, w_may, w_jun, w_jul, w_aug, w_sep, w_oct, w_nov, w_dec]; //walk-in sales

*/
console.log('data one ')
console.log(success_data);


while(year2_count!=0)
{
    count++;
    var b2_jan = 0;
    var b2_feb=0, b2_mar=0, b2_apr=0, b2_may=0, b2_jun=0, b2_jul=0, b2_aug=0, b2_sep=0, b2_oct=0, b2_nov=0, b2_dec=0;

    var data_bookings = [];
    year2_count--;
    success_series2.push(data.year2[year2_count].name)
    var x = data.year2[year2_count].room_qty.length;
    while(x!=0)
    {
        x--;
        var y = data.year2[year2_count].room_qty[x].room_reserved.length;
        while(y!=0)
        {
            y--;
            if(data.year2[year2_count].room_qty[x].room_reserved[y].status==1 || data.year2[year2_count].room_qty[x].room_reserved[y].status==2 || data.year2[year2_count].room_qty[x].room_reserved[y].status==3)
            {
                var checkin = moment(data.year2[year2_count].room_qty[x].room_reserved[y].check_in.date).month();

                if(checkin==0)
                {
                    b2_jan++;
                                 // console.log(b_jan)
                                 if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
                                 {
                                    w2_jan += parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                                }else{
                                    console.log(data.year2[year2_count].room_qty[x].room_reserved[y])
                                    p2_jan += parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                                }

                            }else if(checkin==1){

                                b2_feb++;
                                if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
                                {
                                    w2_feb += parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price); 
                                }else{
                                   p2_feb += parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price); 
                               }

                           }
                           else if(checkin==2){
                            b2_mar++;
                            if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
                            {

                                w2_mar+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                            }else{
                                p2_mar+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                            }
                        }
                        else if(checkin==3){
                            b2_apr++;
                            if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
                            {
                                w2_apr+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                            }else{
                             p2_apr+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                         }
                     }
                     else if(checkin==4){
                        b2_may++;
                        if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
                        {
                            w2_may+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                        }else{
                         p2_may+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                     }
                 }else if(checkin==5){
                    b2_jun++;
                    if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
                    {
                        w2_jun+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                    }else{
                     p2_jun+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                 }
             }else if(checkin==6){
                b2_jul++;
                if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
                {
                    w2_jul+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                }else{
                    p2_jul+=parseInt(data[i].room_qty[x].room_reserved[y].price);
                }
            }else if(checkin==7){
                b2_aug++;
                if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
                {
                    w2_aug+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                }else{
                    p2_aug+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                }
            }else if(checkin==8){
                b2_sep++;
                if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
                {
                    w2_sep+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
                }else{

                 p2_sep+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
             }
         }else if(checkin==9){
            b2_oct++;
            if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
            {
                w2_oct+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
            }else{
                p2_oct+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
            }
        }else if(checkin==10){
            b2_nov++;
            if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
            {
                w2_nov+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
            }else{
             p2_nov+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
         }
     }
     else if(checkin==11){
        b2_dec++;
        if(data.year2[year2_count].room_qty[x].room_reserved[y].code=='N/A')
        {
            w2_dec+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
        }else{
         p2_dec+=parseInt(data.year2[year2_count].room_qty[x].room_reserved[y].price);
     }
 }

 /*if(data[i].room_qty[x].room_reserved[y].o)*/
}
} //end while
}// end of if(filtersetting.type!=1)
var year2_data_bookings = [b2_jan, b2_feb, b2_mar, b2_apr, b2_may, b2_jun, b2_jul, b2_aug, b2_sep, b2_oct, b2_nov, b2_dec];
success_data2.push(year2_data_bookings);
} //end of while

var year1_data_profit = [p_jan, p_feb, p_mar, p_apr, p_may, p_jun, p_jul, p_aug, p_sep, p_oct, p_nov, p_dec]; //online sales
var year1_data_profit2 = [w_jan, w_feb, w_mar, w_apr, w_may, w_jun, w_jul, w_aug, w_sep, w_oct, w_nov, w_dec]; //walk-in sales


var year2_data_profit = [p2_jan, p2_feb, p2_mar, p2_apr, p2_may, p2_jun, p2_jul, p2_aug, p2_sep, p2_oct, p2_nov, p2_dec]; //online sales
var year2_data_profit2 = [w2_jan, w2_feb, w2_mar, w2_apr, w2_may, w2_jun, w2_jul, w2_aug, w2_sep, w2_oct, w2_nov, w2_dec]; //walk-in sales

var compare_profit1 = [year1_data_profit, year2_data_profit];
var compare_profit2 = [year1_data_profit2, year2_data_profit2];
console.log(data_profit3)

console.log(data_profit);

}
           // console.log(data);
           console.log(datas);
           $timeout(function()
           {
            $scope.hideloading=true;
        },1000);

           if(filtersetting.type!=1)
           {
             console.log('compare datas');
             $scope.success_booking.series = success_series;
             console.log($scope.success_booking.series);
             $scope.success_booking.data = success_data;
             $scope.data.push(data_profit);
             $scope.data2.push(data_profit2);

         }
         else{
            console.log('compare data');
            console.log(success_data);
            $scope.compare_booking.year1.series = success_series;
            $scope.compare_booking.year1.data = success_data;
            $scope.compare_booking.year2.series = success_series2;
            $scope.compare_booking.year2.data = success_data2;
            angular.copy(compare_profit1, $scope.data);
            angular.copy(compare_profit2, $scope.data2);
            $scope.compare_booking.year2 = 
            {
                series : success_series2,
                data : success_data2
            }
            console.log('compare')
            console.log($scope.compare_booking)
        }
    }


        // console.log(count_r);
    }).error();
}


}])