@extends('layouts.app')

@section('styles')
<link href="{{asset('assets/css/jquery-ui-1.10.4.custom.min.css')}}" rel="stylesheet">
<link href="{{asset('assets/css/jHTree.css')}}"rel="stylesheet">
@endsection

@section('content')

    <div class="row clearfix">
        @include('partials.sidebar')
		
		<div class="col-md-9 " >
			<div class="card">
				<div class="header">
					<h2>My Referrals</h2>
				</div>
				<div class="body">

					<div id="tree"></div>
				</div>
			</div>

    	</div>

    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection

@section('js')
<script src="{{asset('assets/js/jquery-ui-1.10.4.custom.min.js')}}"></script>
<script src="{{asset('assets/js/jQuery.jHTree.js')}}"></script>
<script type="text/javascript">
	/*
	var myData = [{
	  "head":"A",
	  "id":"aa",
	  "contents":"A Contents<br>asf",
	  "children": [
	    {
	      "head":"A-1",
	      "id":"a1",
	      "contents":"A-1 Contents",
	      "children": [
	        {
	        	"head":"A-1-1",
	        	"id":"a11",
	        	"contents":"A-1-1 Contents" 
	        }
	      ]
	    },
	    {
	      "head":"A-2",
	      "id":"a2",
	      "contents":"A-2 Contents",
	      "children": [
	        {"head":"A-2-1","id":"a21","contents":"A-2-1 Contents" },
	        {"head":"A-2-2","id":"a22","contents":"A-2-2 Contents" }
	      ]
	    }
	  ]
	}]*/

	var url = location.origin + '/getdownlines';

    $.ajax({
        url: url,
        type: 'GET',
        // dataType: 'json',
        success: function(res){
        	console.log('response', res)
			$("#tree").jHTree({
			  callType:'obj',
			  structureObj: res,
			  zoomer:false,
			  dragger:false,
			  nodeDropComplete:function (event, data) {
			    //----- Do Something @ Server side or client side -----------
			    //alert("Node ID: " + data.nodeId + " Parent Node ID: " + data.parentNodeId);
			    //-----------------------------------------------------------
			  }
			});
        }
    });



</script>
@endsection
