@extends('layout.master2')
@section('controller')
roomController
@stop
@section('styles')
<style type="text/css">
    /**** LAYOUT ****/
    .list-inline>li {
        padding: 0 10px 0 0;
    }
    .container-pad {
        padding: 30px 15px;
    }
    /**** MODULE ****/
    .bgc-fff {
        background-color: #fff!important;
    }
    .box-shad {
        -webkit-box-shadow: 1px 1px 0 rgba(0,0,0,.2);
        box-shadow: 1px 1px 0 rgba(0,0,0,.2);
    }
    .brdr {
        border: 1px solid #ededed;
    }
    /* Font changes */
    .fnt-smaller {
        font-size: .9em;
    }
    .fnt-lighter {
        color: #bbb;
    }
    /* Padding - Margins */
    .pad-10 {
        padding: 10px!important;
    }
    .mrg-0 {
        margin: 0!important;
    }
    .btm-mrg-10 {
        margin-bottom: 10px!important;
    }
    .btm-mrg-20 {
        margin-bottom: 20px!important;
    }
    /* Color  */
    .clr-535353 {
        color: #535353;
    }
    /**** MEDIA QUERIES ****/
    @media only screen and (max-width: 991px) {
        #property-listings .property-listing {
            padding: 5px!important;
        }
        #property-listings .property-listing a {
            margin: 0;
        }
        #property-listings .property-listing .media-body {
            padding: 10px;
        }
    }
    @media only screen and (min-width: 992px) {
        #property-listings .property-listing img {
            max-width: 180px;
        }
    }
</style>
@stop
@section('content')
<div class="row" style='padding:10px'>
    <h2 style="font-family: 'Oswald', sans-serif;">Rooms</h2>
    <hr style='border-top:2px solid #d8d8d8;'>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
        
        <div class="" id="property-listings">
            <div class="col-sm-12">
                @foreach($room as $r)
                <!-- Begin Listing: 609 W GRAVERS LN-->
                <div class="brdr bgc-fff pad-10 box-shad btm-mrg-20 property-listing">
                    <div class="media">
                        <a class="pull-left" href="#" target="_parent">
                            <img alt="image" class="img-responsive  " src="{{ URL::to('image/medium/'.$r->roomImages[0]->photo->filename) }} "></a>
                            <div class="clearfix visible-sm"></div>
                            <div class="media-body fnt-smaller">
                                <a href="#" target="_parent"></a>
                                <h4 class="media-heading">
                                    <a href="#" target="_parent"> {{{ $r->name }}} <small class="pull-right"><span class="label label-danger">P  {{{ $r->price }}} </span></small></a></h4>
                                    <ul class="list-inline mrg-0 btm-mrg-10 clr-535353">
                                        <li>Max Adult(s): {{{ $r->max_adults }}}</li>
                                        <li style="list-style: none">|</li>
                                        <li>Max Children: {{{ $r->max_children }}}</li>
                                        <li style="list-style: none">|</li>
                                        <li>{{{ $r->beds }}} Beds</li>
                                    </ul>
                                    <p class="hidden-xs"> {{{ $r->short_desc }}}...</p><span class="fnt-smaller fnt-lighter fnt-arial">Courtesy of HS Fox & Roach-Chestnut Hill
                                    Evergreen</span>
                                </div>
                            </div>
                        </div><!-- End Listing-->
                        @endforeach
                    </div><!-- End container -->
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div ng-show='displayform==false'>
                            <form method='POST' action="{{ URL::to('booking/step2/direct') }}">
                                <input type='hidden' name='reservation_room[0][quantity]' ng-value='reservation.quantity'>
                                <input type='hidden' name='reservation_room[0][room_id]' ng-value='reservation.room_id'>
                                <input type='hidden' name='checkin' ng-value='reservation.checkin'>
                                <input type='hidden' name='checkout' ng-value='reservation.checkout'>
                                <input type='hidden' name='display_checkout' ng-value='reservation.display_checkout'>
                                <div class="well">
                                    The room is available! <button type="submit" class="btn btn-xs btn-primary">Proceed</button> or <button type="button" class="btn btn-xs btn-block btn-danger" style='margin-top:10px' ng-click='displayform=true'>Back to form</button>
                                </div>
                            </form>
                        </div>
                        <div class="alert alert-warning" ng-show='available==0'>
                            <center>
                                The room is not available. Select another room.
                            </center>
                        </div>
                        <div ng-hide='loading || displayform==false'>
                            <div class="form-group">
                                <label for="" style='font-family:"Open Sans"'>Check in date</label>
                                <input type="text" class="form-control checkin" id="" ng-model='availability.checkin' placeholder="Your check in date">
                            </div>
                            <div class="form-group">
                                <label for="">No. of nights</label>
                                <input type="text" class="form-control" id="" placeholder="Number of nights" ng-model='nights' onkeypress="return isNumber(event)" maxlength='2'>
                            </div>
                            <div class="form-group">
                                <label for="">No. of rooms</label>
                                <input type="text" class="form-control" id="" placeholder="How many rooms you need?" ng-model='availability.quantity' onkeypress="return isNumber(event)" maxlength='2'>
                            </div>
                            <div class="form-group">
                                <label for="">Room Type</label>
                                <select name="" id="input" class="form-control" required="required" ng-model='availability.room_id'>
                                    <option value="0">Select Room</option>
                                    @foreach($room as $r)
                                    <option value='{{ $r->id }}'> {{{ $r->name }}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <button type="button" class="btn btn-large btn-block btn-danger" ng-click='checkAvailability()'>Check availability</button>
                            </div>
                        </div>
                        <div ng-show='loading' style='padding:10px'>
                            <center>
                                <img src='{{ URL::to("images/loader.gif") }}'>
                            </center>
                        </div>
                        <p style='font-family:Open Sans;'>If problem persist, feel free to call us on 8700 or visit our <a href='#'>contact</a> page</p>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-body" style='font-family:Open Sans'>
                        At <strong>Giligans Hotel</strong>, good things come
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
                    </div>
                </div>
            </div>
        </div>
        @stop
        @section('scripts')
        {{ HTML::script('asset/scripts/client2/room.js') }}
        <script type="text/javascript">
            $('.checkin').datepicker({
                format: 'mm/dd/yyyy',
                startDate: '-3d'
            })
        </script>
        <script type="text/javascript">
            function isNumber(evt) {
                evt = (evt) ? evt : window.event;
                var charCode = (evt.which) ? evt.which : evt.keyCode;
                if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                    return false;
                }
                return true;
            }
        </script>
        @stop