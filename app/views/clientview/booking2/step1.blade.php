@extends('layout.master')
@section('styles')
{{ HTML::style('asset/styles/datepicker.css') }}
@stop
@section('content')
<div>s</div>
@stop
@section('scripts')

{{ HTML::script('asset/scripts/bootstrap-datepicker.js')}}



<script type="text/javascript">
	$('#date1').datepicker({
    
    });
</script>
@stop