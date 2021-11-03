@extends('layouts.app')

@section('styles')
<style type="text/css">
	@media print {
	   .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12 {
	        float: left;
	   }
	   .col-lg-12 {
	        width: 100%;
	   }
	   .col-lg-11 {
	        width: 91.66666667%;
	   }
	   .col-lg-10 {
	        width: 83.33333333%;
	   }
	   .col-lg-9 {
	        width: 75%;
	   }
	   .col-lg-8 {
	        width: 66.66666667%;
	   }
	   .col-lg-7 {
	        width: 58.33333333%;
	   }
	   .col-lg-6 {
	        width: 50%;
	   }
	   .col-lg-5 {
	        width: 41.66666667%;
	   }
	   .col-lg-4 {
	        width: 33.33333333%;
	   }
	   .col-lg-3 {
	        width: 25%;
	   }
	   .col-lg-2 {
	        width: 16.66666667%;
	   }
	   .col-lg-1 {
	        width: 8.33333333%;
	   }
	}
	.bank-title {
		font-size: xx-large;
	}
</style>
@endsection

@section('content')
	<div class="row">
        <div class="col-lg-12 " style="padding-right: 0">
	        <div class="card">
	            <div class="header">
	                <h2><strong>{{__('CHECK')}}</strong></h2>
	            </div>
	            <div class="body">
	            	<div id="check-container">
		            	<div class="row mb-2">
						<!-- 	<div class="col-lg-10">
		            			<label class="mb-0"><b>Carrie K. Lynn</b></label><br>
		            			<label class="mb-0">1234 Main Street</label><br>
		            			<label>Anytown, US 12345</label>
		            		</div> -->
		            		<div class="col-lg-1 pr-0 my-auto">
		            			<img src="{{asset('landing/img/logo-small.png')}}" class="img-responsive">
		            		</div>
		            		<div class="col-lg-2 my-auto pl-0">
		            			<label class="logo-text mb-0">Liberty Dollar Financial Association</label>
		            		</div>
		            		<div class="col-lg-7"></div>
		            		<div class="col-lg-2">
		            			<label class="check-number">{{$check_number}}</label>
		            		</div>
		            		<div class="col-lg-2 text-center"><label class="digital-draft">Digital Draft</label></div>
		            	</div>
		            	<div class="row mb-2">
		            		<div class="col-lg-8"><label class="bank-title">Renasant Bank</label></div>
		            		<div class="col-lg-4"><label class="check-date">DATE &nbsp;&nbsp;&nbsp;&nbsp;{{$date}}</label></div>
		            	</div>
		            	<div class="row mb-4">
		            		<div class="col-lg-2 my-auto">
		            			<label class="mb-0">PAY TO THE ORDER OF</label>
		            		</div>
		            		<div class="col-lg-7 my-auto">
		            			<div class="organization-type border-bottom text-center">{{$payee}}</div>
		            		</div>
		            		<div class="col-lg-3">
		            			<label class="dollar-amount">$</label>
		            			<label class="dollar-amount dollar-value">{{$amount}}</label>
		            		</div>
		            	</div>

		            	<div class="row mb-4">
		            		<label class="col-lg-7 border-bottom text-center">
		            			{{$written_amt}}
		            		</label>
		            		<label class="col-lg-3 border-bottom text-right">DOLLARS</label>

		            		<div class="col-lg-2"></div>
		            	</div>

		            	<div class="row mb-2">
		            		<div class="col-lg-6">
		            			<div class="border-bottom">
		            				<label class="mb-0">FOR {{$note}}</label>
		            			</div>
		            		</div>
		            		<div class="col-lg-6">
		            			<div class="border-bottom signature">
		            				<img src="{{asset('assets/images/kathysig.png')}}" class="img-signature">
		            				<label class="mb-0 text-right">MP</label>
		            			</div>
		            		</div>
		            	</div>
		            	<div class="row mb-2">
		            		<div class="col-lg-12">
		            			<div class="numbers-container font-Micr-Regular">
		            				<label class="mr-2">A084201294</label>
		            				<label>C8010785393</label>
		            			</div>
		            		</div>
		            	</div>
		            </div>
	            	<div class="mb-2">
	            		<a href="#" class="btn btn-success" id="btn-print">Print</a>
	            		<a href="#" class="btn btn-secondary">Email</a>
	            	</div>
	            </div>
	        </div>
	    </div>
    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection

@section('js')
	<script src="{{ asset('assets/js/jQuery.print.min.js') }}"></script>
	<script type="text/javascript">
		$('#btn-print').click(function() {
			$("#check-container").print(/*options*/);
		})
	</script>
@endsection