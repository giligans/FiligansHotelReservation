@extends('layout.master2')
@section('controller')
homeController
@stop
@section('styles')
{{ HTML::style('asset/styles/jquery.fancybox.css') }}
<style type="text/css">
	
	.heading::first-letter {
		font-size: 150%;
		color: red;
	} 


</style>
@stop
@section('content')
<div class="row" style='padding:10px'>
	<h2 style="font-family: 'Oswald', sans-serif;">Gallery</h2>
	<hr>
	<p>
		At Pals Hotel, good things come
		together to whip up a worry-free
		hotel experience. With great location,
		affordable pricing, clean and secure
		rooms, and the full assistance of our
		staff, guests are able to make the
		most out of their stay in Palawan.
		At the end of a long day, when it’s
		time to rest your head, our no-frills
		accommodation and well-trained
		personnel will give you
		more time to relax and
		unwind comfortably.
	</p>
	<hr>
</div>	



<div class="row">
  <div class='list-group gallery'>
    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
        <a class="thumbnail fancybox" rel="ligthbox" href="{{ URL::to('image/full_image/1.jpg') }}">
            <img class="img-responsive" alt="" src="{{ URL::to('image/large/1.jpg') }}" />
            <div class='text-right'>
                <small class='text-muted'>Image Title</small>
            </div> <!-- text-right / end -->
        </a>
    </div> <!-- col-6 / end -->

    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
        <a class="thumbnail fancybox" rel="ligthbox" href="{{ URL::to('image/full_image/2.jpg') }}">
            <img class="img-responsive" alt="" src="{{ URL::to('image/large/2.jpg') }}" />
            <div class='text-right'>
                <small class='text-muted'>Image Title</small>
            </div> <!-- text-right / end -->
        </a>
    </div> <!-- col-6 / end -->


    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
        <a class="thumbnail fancybox" rel="ligthbox" href="{{ URL::to('image/full_image/3.jpg') }}">
            <img class="img-responsive" alt="" src="{{ URL::to('image/large/3.jpg') }}" />
            <div class='text-right'>
                <small class='text-muted'>Image Title</small>
            </div> <!-- text-right / end -->
        </a>
    </div> <!-- col-6 / end -->


    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
        <a class="thumbnail fancybox" rel="ligthbox" href="{{ URL::to('image/full_image/4.jpg') }}">
            <img class="img-responsive" alt="" src="{{ URL::to('image/large/4.jpg') }}" />
            <div class='text-right'>
                <small class='text-muted'>Image Title</small>
            </div> <!-- text-right / end -->
        </a>
    </div> <!-- col-6 / end -->


    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
        <a class="thumbnail fancybox" rel="ligthbox" href="{{ URL::to('image/full_image/5.jpg') }}">
            <img class="img-responsive" alt="" src="{{ URL::to('image/large/5.jpg') }}" />
            <div class='text-right'>
                <small class='text-muted'>Image Title</small>
            </div> <!-- text-right / end -->
        </a>
    </div> <!-- col-6 / end -->


    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
        <a class="thumbnail fancybox" rel="ligthbox" href="{{ URL::to('image/full_image/6.jpg') }}">
            <img class="img-responsive" alt="" src="{{ URL::to('image/large/6.jpg') }}" />
            <div class='text-right'>
                <small class='text-muted'>Image Title</small>
            </div> <!-- text-right / end -->
        </a>
    </div> <!-- col-6 / end -->

    <div class='col-sm-4 col-xs-6 col-md-3 col-lg-3'>
        <a class="thumbnail fancybox" rel="ligthbox" href="{{ URL::to('image/full_image/7.jpg') }}">
            <img class="img-responsive" alt="" src="{{ URL::to('image/large/7.jpg') }}" />
            <div class='text-right'>
                <small class='text-muted'>Image Title</small>
            </div> <!-- text-right / end -->
        </a>
    </div> <!-- col-6 / end -->


</div> <!-- list-group / end -->
</div> <!-- row / end -->



@stop
@section('scripts')

{{ HTML::script('asset/scripts/client2/jquery.fancybox.js') }}
<script type="text/javascript">

	$(document).ready(function(){
    //FANCYBOX
    //https://github.com/fancyapps/fancyBox
    $(".fancybox").fancybox({
    	openEffect: "none",
    	closeEffect: "none"
    });
});



	angular.module('giligansApp', [], function($interpolateProvider){
		$interpolateProvider.startSymbol('[[');
		$interpolateProvider.endSymbol(']]');
	}).controller('homeController', ['$scope', function($scope){
	//	alert('hey')
}])
</script>
@stop