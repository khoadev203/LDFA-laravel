@extends('layouts.app')
@section('styles')
.hide{
    display:none;
}
@endsection
@section('content')
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
        	<div class="card">
            <div class="body">
                <row class="clearfix">
                    @if($_ENV['APP_DEMO'])
                        <div class="alert alert-info">
                            <p><strong>Heads up!</strong> Use the above Credit Card for demo testing.</p>
                            <strong>Card Number : </strong> 4111 1111 1111 1111<br>
                            <strong>CVC</strong> 111<br>
                            <strong>Expiration</strong> 10/2021<br>
                        </div>
                    @endif
                    @include('flash')
                </row>
                <div class="row">
                    <div class="preview col-lg-4 col-md-12">
                        <div class="preview-pic tab-content">
                            <div class="tab-pane active show" id="product_1">
                            	<img src="{{url('/')}}/storage/imgs/square_api.jpeg" class="img-fluid">
                            </div>
                            
                        </div>
                                       
                    </div>
                    <div class="details col-lg-8 col-md-12" id="buy_form">
                        <h3 class="product-title m-b-0">{{__('Add funds to your wallet with your Credit Card') }}</h3>                        
                        
                        <div class="card bg-light mt-5">
			    
                            <div class="body">
                                <script type="text/javascript" src="https://js.squareupsandbox.com/v2/paymentform"></script>
				<script type="text/javascript" src="https://www.ldfa.nl/api/v1/assets/vendor/square_files/sqpaymentform.js"></script>
                		<link rel="stylesheet" type="text/css" href="https://www.ldfa.nl/api/v1/assets/vendor/square_files/sqpaymentform-basic.css">
				<form accept-charset="UTF-8" action="{{url('/')}}/buyvoucher/square" class="require-validation" data-cc-on-file="false" id="nonce-form" method="post">
				      <fieldset>
					<strong>Card Number</strong>
					<div id="sq-card-number"></div>

					<div class="third">
					  <strong>Expiration</strong>
					  <div id="sq-expiration-date"></div>
					</div>

					<div class="third">
					  <strong>CVV</strong>
					  <div id="sq-cvv"></div>
					</div>

					<div class="third">
					  <strong>Postal</strong>
					  <div id="sq-postal-code"></div>
					</div>
				      </fieldset>

				      <button id="sq-creditcard" class="button-credit-card" onclick="requestCardNonce(event)">Deposit Now</button>
				      <br>
				      <br>

				      <div id="error"></div>

				      <!--
					After a nonce is generated it will be assigned to this hidden input field.
				      -->
				      <input type="hidden" id="card-nonce" name="nonce" value="">
				    </form>
				  </div> <!-- end #sq-ccbox -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    
@endsection
@section('js')
    <script>
		 document.addEventListener("DOMContentLoaded", function(event) {
			if (SqPaymentForm.isSupportedBrowser()) {
			  paymentForm.build();
			  paymentForm.recalculateSize();
			}
		});
        </script>
@endsection


@section('footer')
  @include('partials.footer')
@endsection
