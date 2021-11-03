@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.__('LDAdmin Balance'))


@section('page_header')
    <h1 class="page-title">
        {{ __('LDFAdmin Balance') }}

    </h1>

<style type="text/css">
	.mce-edit-area iframe {
	    height: 200px !important;
	}
</style>
<!-- form start -->
<form role="form" class="form-edit-add" action="{{route('voyager.LDBalance.index')}}"
method="POST" enctype="multipart/form-data">
<!-- PUT Method if we are editing -->

<!-- CSRF TOKEN -->
{{csrf_field()}}

<div class="panel-body">


<!-- Adding / Editing -->

<!-- GET THE DISPLAY OPTIONS -->

<div class="form-group  col-md-12 " >
  <label class="control-label" for="name">Select Amount Type</label><br>
  <div class="row amount_radio_btn">
    <div class="col-md-2" style="margin: 0;">
       <input type="radio" id="dollar" name="type" value="dollar" checked="checked" onclick="myFunction()"> 
       <label for="dollar">Other Currency</label>
    </div>
    <div class="col-md-2" style="margin: 0;">
        <input type="radio" id="ounce" name="type" value="ounce" onclick="myFunction()"> 
        <label for="ounce">Ounce</label>
    </div>
  </div>

  <p style="display: none;color: red;" id="selecttext">Please Select Amount Type</p>

</div>
<div class="form-group  col-md-12 " >
<label class="control-label" for="name">Amount to invest</label>
<input  required  type="number" class="form-control" name="amount"
placeholder="5.00" pattern="[0-9]+([\.,][0-9]+)?"
value="" onchange="myFunction()" id="amount">
<input type="hidden" name="rate" id="rate" value="{{$rate}}">
 

</div>
<div class="form-group  col-md-12 " >
<label class="control-label" for="name" id="amt">Amount</label>
<input   type="number" class="form-control" name="fixedamount"
value="" id="fixedamount" readonly="">
</div>
<div class="form-group  col-md-12 " >

<label class="control-label" for="name">Description (Optional)</label>
<textarea class="form-control richTextBox" name="description" id="richtexthow_to">
</textarea>

</div>

<div class="panel-footer form-group ">
<button type="submit" class="btn btn-primary save">Save</button>
</div>

</div>

</form>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script>
function myFunction() {
  var x = document.getElementById("amount").value;
  if(x != ''){
  var ele = document.querySelector('input[name="type"]:checked').value;
  var rate = document.getElementById('rate').value;
  if ($('input[name=type]:checked').length > 0) {
  	document.getElementById("selecttext").style.display = "none";
    if(ele == 'dollar'){
    	var val = (x) / rate;
    	document.getElementById('fixedamount').value =val;
    	document.getElementById("amt").innerHTML = "Amount in ounce";
    }else{
    	var val = (x) * rate;
    	document.getElementById('fixedamount').value =val;
    	document.getElementById("amt").innerHTML = "Amount in other Currency";
    }
}else{
	document.getElementById("selecttext").style.display = "block";
}
}
}
</script>
@stop
@section('content')


@stop

