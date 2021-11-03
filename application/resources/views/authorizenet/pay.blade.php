@extends('layouts.app')
@section('content')

@php
    $months = array(1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Aug', 9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dec');
@endphp

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
          @include('flash')
          	<div class="card">
	            <div class="header">
	                <h2><strong>{{__('Authorize.net')}}</strong></h2>
	            </div>
	            <div class="body">
					<form id="payment-card-info" method="post" action="{{ route('authorizenet.dopay') }}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6" >
                                <label for="amount">USD Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" min="1" value="{{ old('amount') }}" step=".01" required>
                            </div>

                            <div class="form-group col-md-6" >
                                <label for="ounce_amount">Ounce Amount</label>
                                <input type="number" class="form-control" id="ounce_amount" name="ounce_amount" min="0.1" step=".01" required>
                            </div>

                            <div class="col-lg-12">
                                Premium cost: $<span id="label_premium">0</span>
                            </div>

                            <div class="col-lg-12">
                                Processing fee: $<span id="label_fee">0</span>
                            </div>

                            <div class="col-lg-12">
                                $<span id="label_usd_paypal">0</span> will be deducted from your Credit Card!
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="form-group owner col-md-4">
                                <label for="owner">Name on Card</label>
                                <input type="text" class="form-control" id="owner" name="owner" value="{{ $user->card_owner }}" required>
                            </div>
                            <div class="form-group CVV col-md-4">
                                <label for="cvv">CVV</label>
                                <input type="number" class="form-control" id="cvv" name="cvv" value="{{ $user->card_cvv }}" required>
                            </div>
                            <div class="form-group col-md-4" id="card-number-field">
                                <label for="cardNumber">Card Number</label>
                                <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="{{ $user->card_number }}" required>
                            </div>
                        </div>

                        <label>Expiration Date</label><br>

                        <div class="row">
                            <div class="form-group col-md-3" id="expiration-date">
                                <select class="form-control mb-3" id="expiration-month" name="expiration-month" style="float: left; width: 100px; margin-right: 10px;">
                                    @foreach($months as $k=>$v)
                                        <option value="{{ $k }}" {{ old('expiration-month') == $k ? 'selected' : '' }}>{{ $v }}</option>                                                        
                                    @endforeach
                                </select>  
                                
                            </div>

                            <div class="form-group col-md-3">
                            	<select class="form-control" id="expiration-year" name="expiration-year"  style="float: left; width: 100px;">
                                    
                                    @for($i = date('Y'); $i <= (date('Y') + 15); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>            
                                    @endfor
                                </select>
                            </div>

                            <div class="form-group col-md-6" id="credit_cards" style="margin-top: 22px;">
                                <img src="{{ asset('assets/images/visa.jpg') }}" id="visa">
                                <img src="{{ asset('assets/images/mastercard.jpg') }}" id="mastercard">
                                <img src="{{ asset('assets/images/amex.jpg') }}" id="amex">
                            </div>
                        </div>
                        
                        <label>Customer's Bill To Address</label>
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="firstName">First Name</label>
                                <input type="text" class="form-control" id="firstName" name="firstName" value="{{ $user->first_name }}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="lastName">Last Name</label>
                                <input type="text" class="form-control" id="lastName" name="lastName" value="{{ $user->last_name }}" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="company">Company</label>
                                <input type="text" class="form-control" id="company" name="company" value="{{ $user->card_company }}" placeholder="ex: Souveniropolis" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="{{ $user->card_address }}" placeholder="ex: 14 Main Street" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="city">City</label>
                                <input type="text" class="form-control" id="city" name="city" value="{{ $user->card_city }}" placeholder="ex: Pecan Spring" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="state">State</label>
                                <input type="text" class="form-control" id="state" name="state" value="{{ $user->card_state }}" placeholder="ex: TX" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="zip">Zip</label>
                                <input type="text" class="form-control" id="zip" name="zip" value="{{ $user->card_zip }}" placeholder="ex:44628" required>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="country">Country</label>
                                <input type="text" class="form-control" id="country" name="country" value="{{ $user->card_country }}" placeholder="ex: USA" required>
                            </div>
                        </div>
                        <br/>

                        <input type="hidden" name="price" id="price" value="{{setting('site.silver_price')}}">
                        <input type="hidden" name="fixed_fee" id="fixed_fee" value="{{setting('merchant.merchant_fixed_fee')}}">
                        <input type="hidden" name="percentage_fee" id="percentage_fee" value="{{setting('merchant.merchant_percentage_fee')}}">
                        <input type="hidden" name="premium" id="premium" value="{{setting('money-transfers.premium')}}">
                        <input type="hidden" name="gross_amount" id="gross_amount">

                        <div class="form-group" id="pay-now">
                            <button type="submit" class="btn btn-success themeButton" id="confirm-purchase">Confirm Payment</button>
                        </div>
                    </form>
	            </div>
          	</div>
        </div>
    </div>
@endsection
@section('footer')
@include('partials.footer')
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
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