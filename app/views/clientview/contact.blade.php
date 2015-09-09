@extends('layout.master')
@section('content')
<div
style="background-image:url('http://t3.gstatic.com/images?q=tbn:ANd9GcSCEU2GeCLPvXNm_C9AqKvu2lT-lnluJ_jAuAO14lrh6H-UZbFL');background-size:cover;height:100px;margin-top:-40px;padding-top:40px;padding-left:10px;">
	<h1 style='color:white;font-family:Open Sans'>Contact Us</h1>
</div>
<div class="container">
	<div class="row">
        <div class="con-md-8">
        	<iframe width="100%" height="350" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.co.uk/maps?f=q&source=s_q&hl=en&geocode=&q=15+Springfield+Way,+Hythe,+CT21+5SH&aq=t&sll=52.8382,-2.327815&sspn=8.047465,13.666992&ie=UTF8&hq=&hnear=15+Springfield+Way,+Hythe+CT21+5SH,+United+Kingdom&t=m&z=14&ll=51.077429,1.121722&output=embed"></iframe>
    	</div>
    	
      	<div class="col-md-4">
    		<h2>Snail mail</h2>
    		<address>
    			<strong>Hythe Window Cleaning</strong><br>
    			15 Springfield Way<br>
    			Hythe<br>
    			Kent<br>
    			United Kingdon<br>
    			CT21 5SH<br>
    			<abbr title="Phone">P:</abbr> 01234 567 890
    		</address>
    	</div>

    	<div class="col-md-8" style='margin-top:00px'>

<form id="contact" method="post" class="form" role="form">
<h3 style='font-family:Open Sans;margin-bottom:10px;'>Feel free to message us if you have any concerns.</h3>
<div class="row">

<div class="col-xs-6 col-md-6 form-group">
<input class="form-control" id="name" name="name" placeholder="Name" type="text" required autofocus />
</div>
<div class="col-xs-6 col-md-6 form-group">
<input class="form-control" id="email" name="email" placeholder="Email" type="email" required />
</div>
</div>
<textarea class="form-control" id="message" name="message" placeholder="Message" rows="5"></textarea>
<br />
<div class="row">
<div class="col-xs-12 col-md-12 form-group">
<button class="btn btn-primary pull-right" type="submit">Submit</button>
</form>
</div>
    </div>
</div>
@stop