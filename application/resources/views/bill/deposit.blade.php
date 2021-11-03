@extends('layouts.app')
@section('styles')

@endsection
@section('content')
<style type="text/css">
    .hide{
    display:none;
}
</style>
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
            <div class="card">
              <div class="header">
                <h2>{{__('Add funds to your wallet with') }}<strong>{{__(' Echeck')}}</strong></h2>
              </div>
            <div class="body">
                
                <div class="row">
                    <div class="details col-lg-12 col-md-12" id="buy_form">                        
                        <div class="card bg-light">

                            <div class="body">
                                <form accept-charset="UTF-8" action="{{route('deposit.echeck.request')}}" class="require-validation" id="payment-form" method="post">
                                    {{ csrf_field() }}
                                    @include('flash')
                                    <div class='form-row mb-3'>
                                        <div class='col'>
                                            <label class='control-label'> {{__('Amount')}}(USD)</label> 
                                            <input type="number" name="amount" id="amount" aria-label="Search" class="form-control" step=".01">
                                        </div>
                                        <div class='col'>
                                            <label class='control-label'> {{__('Amount')}}(Ounce)</label> 
                                            <input type="number" name="ounce_amount" id="ounce_amount" aria-label="Search" class="form-control" min="1" step=".01">
                                        </div>
                                    </div>

                                    <p>Premium cost: $<span id="label_premium">0</span></p>
                                    <p>Printing fee: $<span id="label_fee">0</span></p>
                                    <p>You will be billed $<span id="label_usd_paypal">0</span>!</p>
                                    <hr>

                                    <div class='form-row mb-3'>
                                        <div class='col'>
                                            <label class='control-label'> {{__('Check Number')}}</label> 
                                            <input type="number" value="{{$user->bank_checknum}}" name="number" class="form-control" min="1" required>
                                        </div>
                                    </div>

                                    <div class='form-row mb-3'>
                                        <div class='col form-group'>
                                            <label class='control-label'>{{__('Phone')}}</label> 
                                            <input autocomplete='off' name="phonenumber" value="{{$user->phonenumber}}" class='form-control' placeholder='' size='4'
                                                type='text' required>
                                        </div>
                                    </div>

                                    <div class='form-row mb-3'>
                                        <div class='col form-group'>
                                            <label class='control-label'>{{__('Mailing Address')}}</label> 
                                            <input autocomplete='off' name="address" value="{{$user->card_address}}" class='form-control' placeholder='' size='4'
                                                type='text' required>
                                        </div>
                                    </div>

                                    <div class='form-row mb-3'>
                                        <div class='col form-group'>
                                            <label class='control-label'>{{__('Bank Name')}}</label> 
                                            <input autocomplete='off' name="bank_name" value="{{$user->bank_name}}" class='form-control card-cvc' placeholder='' size='4'
                                                type='text' required>
                                        </div>
                                    </div>

                                    <div class='form-row mb-3'>
                                        <div class='col form-group'>
                                            <label class='control-label'>{{__('Bank Account Number')}}</label> 
                                            <input name="bank_account" value="{{$user->bank_accountnum}}" class='form-control' size='4' type='text' placeholder="The sender's bank account" minlength="4" required>
                                        </div>
                                    </div>

                                    <div class='form-row mb-3'>
                                        <div class='col form-group '>
                                            <label class='control-label'>{{__('Bank Routing Number')}}</label> 
                                            <input name="bank_routing" value="{{$user->bank_routingnum}}" autocomplete='off' class='form-control card-number' minlength="9" maxlength="9" type='text' placeholder="The sender's bank routing number" required="">
                                        </div>
                                    </div>

                                    <div class='form-row mb-3'>
                                        <div class='col'>
                                            <label class='control-label'> {{__('Memo')}}</label> 
                                            <input type="text" name="memo" aria-label="Search" class="form-control" placeholder="Brief description of the purpose of the check" required>
                                        </div>
                                    </div>

                                    <div class='form-row'>
                                        <div class='col form-group'>
                                            <button class='form-control btn btn-primary submit-button'
                                                type='submit' style="margin-top: 10px;">ADD FUNDS</button>
                                        </div>
                                    </div>
                                    <input type="hidden" name="price" id="price" value="{{setting('site.silver_price')}}">
                                    <input type="hidden" name="fixed_fee" id="fixed_fee" value="5">
                                    <input type="hidden" name="percentage_fee" id="percentage_fee" value="0">
                                    <input type="hidden" name="premium" id="premium" value="{{setting('money-transfers.premium')}}">
                                    <input type="hidden" name="gross_amount" id="gross_amount">
                                </form>
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


@section('footer')
  @include('partials.footer')
@endsection