@extends('layout.master')
@section('content')
<style type="text/css">
    .hide-bullets {
        list-style:none;
        margin-left: -40px;
        margin-top:20px;
    }
    h3 {
        font-family: Open Sans;
        margin:3px;
    }
    table  .right{
        text-align:right;
    }
</style>
<div class="container">
    <div id="main_area">
        <!-- Slider -->
        <div class="row">
            <div class="col-xs-12" id="slider">
                <!-- Top part of the slider -->
                <div class="row">
                    <div class="col-sm-8" id="carousel-bounding-box">
                        <div class="carousel slide" id="myCarousel">
                            <!-- Carousel items -->
                            <div class="carousel-inner">
                                @foreach($room->roomImages as $images)
                                <div class="active item" data-slide-number="0">
                                    <img src="{{ URL::to('image/full_image/'.$images->photo->filename) }}">
                                </div>
                                @endforeach
                                
                            </div><!-- Carousel nav -->
                            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>
                    <div class="col-sm-4" id="carousel-text">
                        <table style='width:100%;margin-top:50px;'>
                            <tr>
                                <td class='right'><h3><span>R</span>oom Type: </h3></td>
                                <td><h3><label>Single</label></h3></td>
                            </tr>
                            <tr>
                                <td class='right'><h3><span>P</span>rice: </h3></td>
                                <td><h3><label>Single</label> </h3></td>
                            </tr>
                            <tr>
                                <td class='right'><h3><span>N</span>o of bed: </h3></td>
                                <td><h3><label>Single</label></h3></td>
                            </tr>
                        </table>
                        <div class="clearfix">
                        </div>
                        <button type="button" class="btn btn-danger btn-block" style='margin-top:10px;'>Check availability</button>
                    </div>
                    
                </div>
            </div>
        </div><!--/Slider-->
        <div class="row hidden-xs" id="slider-thumbs">
            <!-- Bottom switcher of slider -->
            <ul class="hide-bullets">
                @foreach($room->roomImages as $images)
                <li class="col-sm-2">
                    <a class="thumbnail" id="carousel-selector-0"><img src="{{ URL::to('image/small/'.$images->photo->filename) }}"></a>
                </li>
                @endforeach
                
            </ul>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                {{ $room->full_desc }}
            </div>
        </div>
    </div>
</div>
@stop