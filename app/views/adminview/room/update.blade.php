@extends('layout.admin2')
@section('controller')
createRoomCtrl
@stop
@section('content')
<style type="text/css">
	.hiddenfile {
		width: 0px;
		height: 0px;
		overflow: hidden;
	}
	.dropzone { border: dotted 3px lightgray;
		min-height:100px;
		margin-top:10px;
		
	}
	span .required{
		color:green;
	}
	.nv-file-over { border: dotted 3px red; }
</style>
<div class="page-header" style='margin-top:-20px'>
	<h2 style='font-family:Open Sans;'>Room Management
	</h2>
</div>
<ol class="breadcrumb">
	<li>
		<a href="#">Room Management</a>
	</li>
	<li> <a href='{{ URL::to("adminsite/room/".$room->id) }}'> Room ID: {{ $room->id }} </a></li>
	<li class="">Update information</li>
</ol>
<input type='hidden' ng-init='room={{ $room }}'>
<form action="{{ URL::to('adminsite/room/'.$room->id.'/update')}}" method="POST" role="form">
	<div class="form-group">
		<label for="">Type</label> <small style='color:gray'>(The name of the room. <span class='req'>Required Field</span>)</small>
		<input type="text" class="form-control" ng-model='room.name' name='name' id="" placeholder="Input field">
	</div>
	<div class="form-group">
		<label for="">Short Description</label><small style='color:gray'>(This will be the preview description of the room. <span class='required'>Required Field</span>)</small>
		<textarea class='form-control' ng-model='room.short_desc' name='short_desc'></textarea>
	</div>
	<div class="form-group">
		<label for="">Full Description</label><small style='color:gray'>(This will be the full description of the room. <span class='required'>Required Field</span>)</small>
		<textarea class='form-control' ng-model='room.full_desc' name='full_desc'></textarea>
	</div>
	<div class="form-group">
		<label for="">Max Adults</label><small style='color:gray'>(The maximum capacity for adults per room <span class='required'>Required Field</span>)</small>
		<input type="text" name="max_adults" ng-model='room.max_adults' id="input" class="form-control" value="" length='2' required="required"  title="">
	</div>
	<div class="form-group">
		<label for="">Max Children</label><small style='color:gray'>(The maximum capacity for children per room. <span class='required'>Required Field</span>)</small>
		<input type="text" name="max_children" ng-model='room.max_children' id="input" class="form-control" value="" length='2' required="required"  title="">
	</div>

	<div class="form-group">
		<label for="">Beds</label><small style='color:gray'>(The number of beds per room. <span class='required'>Required Field</span>)</small>
		<input type="text" name="beds" ng-model='room.beds' id="input" class="form-control" value="" required="required"  title="">
	</div>
	<div class="form-group">
		<label for="">Bathrooms</label><small style='color:gray'>(The number of bathrooms per room. <span class='required'>Required Field</span>)</small>
		<input type="text" name="bathrooms" ng-model='room.bathrooms' id="input" class="form-control" value="" required="required" title="">
	</div>
	<div class="form-group">
		<label for="">Room Area</label><small style='color:gray'>(The room area of the room. <span class='required'>Not required</span>)</small>
		<input type="text" name="area" ng-model='room.area' id="input" class="form-control" value="" required="required"  title="">
	</div>
	<div class="form-group">
		<label for="">Price</label><small style='color:gray'>(The price per room. <span class='required'>Required Field</span>)</small>
		<input type="text" name="price" ng-model='room.price' id="input" class="form-control" value="" required="required"  title="">
	</div>
	<hr>	<label>Images: </label><small style='color:gray'>(The images of room. <span class='required'>Required Field</span>)</small><br>

<div style='padding:10px;'>

<div style='float:left;margin:10px;' ng-repeat='i in room.room_images' ng-show='room.room_images.length>0'>
<img ng-src='/image/small/[[ i.photo.filename]]' alt='loading image'>
<div style='height:10px;width;100px;text-align:center;background-color:black;height:20px;' ng-click='update_deleteImage($index)'><a href=''>delete image</a></div>
</div>

</div>
<div class="clearfix"></div>
	<button type="button" class="btn btn-success" id='fileinput'>Add Photo</button>
	<div class="well dropzone" nv-file-over="" nv-file-drop='' uploader="uploader">
		<center style='margin-top:10px'>DROP THE IMAGES HERE</center>
	</div>
	<div class="form-group hiddenfile">
		<input type="file" uploader='uploader' id='fileInput_img' nv-file-select="" multiple/>
	</div>
	<div ng-repeat='item in uploader.queue' style=''>
		<div ng-show="uploader.isHTML5" ng-thumb="{ file: item._file, height: 100 }" style='float:left;border:1px solid #d8d8d8;margin:5px;'></div>
		<div class="progress-bar" role="progressbar" ng-style="{ 'width': item.progress + '%' }"></div>
		
	</div>
	<div class="clearfix"></div>
	<div class="alert alert-warning" ng-show='uploader.queue.length>0'>
		<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
		Upload first the image before you submit the form.
	</div>
	<input type='hidden' name='images' ng-value='room.images' ng-model='room.images'>
	<button type="button" class="btn btn-warning"  ng-click='uploader.uploadAll()' ng-disabled='uploader.queue.length==0'>UPLOAD</button>
	<button type='button' ng-click='updateRoom()' class="btn btn-primary" style='display:inline-block' ng-disabled='uploader.queue.length>0 || disablecreate'>Submit</button>

</form>

@stop
@section('scripts')
{{ HTML::script('admin/asset/js/room.js') }}
{{ HTML::script('admin/asset/js/uploadpreview.js') }}
<script type="text/javascript">
	$("#fileinput").click(function(){
		$("#fileInput_img").click();
	});
</script>
@stop