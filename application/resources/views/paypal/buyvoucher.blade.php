@extends('layouts.app')

@section('content')
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
            @include('flash')
        	<div class="card">
            <div class="body">
                <row class="clearfix"> 
                    @if(env('APP_DEMO'))
                        <div class="alert alert-info">
                            <p><strong>Heads up!</strong> Use the above PayPal Credentials for demo testing.</p>
                            <strong>Email : </strong> pixelotetm-buyer@gmail.com<br>
                            <strong>Password :</strong> 12345678
                        </div>
                    @endif
                </row>
                <div class="row">
                    <div class="preview col-lg-4 col-md-12">
                        <div class="preview-pic tab-content">
                            <div class="tab-pane active show" id="product_1">
                            	<img src="{{url('/')}}/storage/imgs/N7EVK0hQpVT3p0PrB95QIufkOOOmKXQ2WqiO2sPi.png" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="details col-lg-8 col-md-12" id="buy_form">
                        <h3 class="product-title">{{__('Add funds to your wallet with your PayPal') }}</h3>                        
                        
                        <div class="action">
                          <form class="d-flex justify-content-left" method="post" action="{{route('paypal_button_success')}}" id="deposit_form">
                            <div class="row mb-5">
                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label for="message">{{__('Value')}}(Ounce)</label>
                                        <input type="number" name="ounce_amount" id="ounce_amount" aria-label="Search" class="form-control" style="width: 100px" v-on:keyup="totalize"  v-on:change="totalize" >
                                        <small id="ounce_amountHelp" class="form-text text-muted">Ounce amount to be credited to your account.</small>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group ">
                                        <label for="message">{{__('Value')}}(USD)</label>
                                        <input type="number" name="amount" id="amount" aria-label="Search" class="form-control" style="width: 100px" v-on:keyup="totalize"  v-on:change="totalize" >
                                        <small id="amountHelp" class="form-text text-muted">USD amount to deposit.</small>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    Premium cost: $<span id="label_premium">0</span>
                                </div>

                                <div class="col-lg-12">
                                    Paypal Processing fee: $<span id="label_fee">0</span>
                                </div>

                                <div class="col-lg-12">
                                    $<span id="label_usd_paypal">0</span> will be deducted from your Paypal account!
                                </div>


                                <input type="hidden" name="price" id="price" value="{{setting('site.silver_price')}}">
                                <input type="hidden" name="fixed_fee" id="fixed_fee" value="{{setting('merchant.merchant_fixed_fee')}}">
                                <input type="hidden" name="percentage_fee" id="percentage_fee" value="{{setting('merchant.merchant_percentage_fee')}}">
                                <input type="hidden" name="premium" id="premium" value="{{setting('money-transfers.premium')}}">
                                <input type="hidden" name="gross_amount" id="gross_amount">
                                <div class="col-lg-12 mt-3">
                                    {{csrf_field()}}
                                    <!--input type="hidden" name="product_id" value="18">
                                    <input class="btn btn-primary btn-round waves-effect" value="{{__('Purchase')}}" type="submit"-->
                                    <div id="paypal-button-container"></div>

                                </div>
                            </div>
                           
                          </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    
@endsection
@section('js')
<script src="https://www.paypal.com/sdk/js?client-id=AXlcGozjIWSeMODRq4O7RgFOZqfjKTeFdsELUYXwc68AdNJl47bJJUB7Ps5dGYBqxnFAHtq3QmXlwcxB&currency=USD"></script>
<!--
    sandbox client-id=AXlcGozjIWSeMODRq4O7RgFOZqfjKTeFdsELUYXwc68AdNJl47bJJUB7Ps5dGYBqxnFAHtq3QmXlwcxB
-->
    <script type="text/javascript">
        $(document).ready(function() {
            $('#paypal-button-container').empty();
            paypal.Buttons({

                // Sets up the transaction when a payment button is clicked
                createOrder: function(data, actions) {
                  return actions.order.create({
                    purchase_units: [{
                      amount: {
                        value: parseFloat($('#gross_amount').val()) // Can reference variables or functions. Example: `value: document.getElementById('...').value`
                      }
                    }]
                  });
                },

                // Finalize the transaction after payer approval
                onApprove: function(data, actions) {
                  return actions.order.capture().then(function(orderData) {
                        // Successful capture! For dev/demo purposes:
                            console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                            var transaction = orderData.purchase_units[0].payments.captures[0];

                            // if(transaction.status == 'COMPLETED') {
                            if(orderData.status == 'COMPLETED') {
                                var form = $('#deposit_form');
                                form.submit();
                            }

                            // alert('Transaction '+ transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');

                        // When ready to go live, remove the alert and show a success message within this page. For example:
                        // var element = document.getElementById('paypal-button-container');
                        // element.innerHTML = '';
                        // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                        // Or go to another URL:  actions.redirect('thank_you.html');
                    });
                }
            }).render('#paypal-button-container');
        
            var price = parseFloat($('#price').val());
            var premium = parseFloat($('#premium').val());
            var fixed_fee = parseFloat($('#fixed_fee').val());
            var percent_fee = parseFloat($('#percentage_fee').val());

            $('#amount').on('keyup keypress blur change', function() {
                var ounce = $(this).val() / price;
                $('#ounce_amount').val(ounce.toFixed(2));
                UpdateLabels();
              });

            $('#ounce_amount').on('keyup keypress blur change', function() {
                var usd = $(this).val() * price;
                $('#amount').val(usd.toFixed(2));
                UpdateLabels();
            });

            function UpdateLabels()
            {
                var ounce = parseFloat($('#ounce_amount').val());
                var gross = (ounce * (price + premium) + fixed_fee) / (1 - (percent_fee / 100));
                var fee = gross * percent_fee / 100 + fixed_fee;
                var premium_cost = ounce * premium;

                $('#label_premium').text(premium_cost.toFixed(2));
                $('#label_fee').text(fee.toFixed(2));
                $('#label_usd_paypal').text(gross.toFixed(2));
                $('#gross_amount').val(gross.toFixed(2));
            }
        })
      
    </script>
@endsection


@section('footer')
  @include('partials.footer')
@endsection