@extends('layouts.app')

@section('styles')
<style type="text/css">
    .bootstrap-select .dropdown-toggle:focus {
        outline: none!important;
    }
    .input-group-append .btn-group .btn-round {
        border-radius: 0!important;
    }
    .input-group .form-control {
        border-right: solid 1px #e3e3e3;
        border-radius: 0;
    }
</style>
@endsection

@section('content')

    <div class="row">

        @if(Auth::check())
        @include('partials.sidebar')
        
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
        @else
        <div class="col-md-12 " style="padding-right: 0" id="#sendMoney">
        @endif


          @include('flash')
          <div class="card">
            <div class="header">
                <h2><strong>{{__('Exchange Rate ')}}</strong> {{__("Calculator")}}</h2>
            </div>
            <div class="body">
                <p><b>Liberty Dollar Silver Certificates</b> are lawful <b>Warehouse Receipts</b> and can be used as a medium of exchange anywhere in the world. Each one represents legal title to a specific amount of .999 fine silver bullion. Any Certificate or group of Certificates that total one or more whole ounces can be redeemed for the physical silver on demand. </p>
                <p>In local use today {{date("Y/m/d")}}, the USD value for each Certificate is as follows:</p>

                <ul class="list-group mb-3">
                  <li class="list-group-item">1/10 Ounce = ${{number_format(setting('site.silver_price') * 0.1 + 0.25, 2, ".", ",")}}</li>

                  <li class="list-group-item">1/4 Ounce = ${{number_format(setting('site.silver_price') * 0.25 + 0.65, 2, ".", ",")}}</li>
                  <li class="list-group-item">1 Ounce = ${{number_format(setting('site.silver_price') + 2.5, 2, ".", ",")}}</li>
                  <li class="list-group-item">2 Ounces = ${{number_format(setting('site.silver_price') * 2 + 5.0, 2, ".", ",")}}</li>
                  <li class="list-group-item">5 Ounces = ${{number_format(setting('site.silver_price') * 5 + 12.5, 2, ".", ",")}}</li>
                </ul>

                <div class="input-group mb-3 d-none">
                  <input type="number" class="form-control" placeholder="Amount of currency" aria-label="Amount of currency" aria-describedby="button-addon2" id="amtcurrency">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon1">USD</span>
                  </div>
                </div>
                <div class="input-group mb-3 d-none">
                  <input type="number" class="form-control" placeholder="Amount of silver" aria-label="Amount of silver" aria-describedby="basic-addon2" id="amtsilver">
                  <div class="input-group-append">
                    <span class="input-group-text" id="basic-addon2">LD</span>
                  </div>
                </div>
                <input type="hidden" name="usdprice" id="usdprice" value="{{setting('site.silver_price')}}">

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
        updateStatus();

        $('#amtcurrency').keyup(function() {
            updateStatus();
        })

        $('#amtsilver').keyup(function() {
            updateStatus(true)
        })

        function updateStatus(update_primary = false)
        {
            var spot = parseFloat($('#usdprice').val());
            var spot_plus = 3.0;
            var price = spot + spot_plus;

            $('.label-price').text('$' + price)

            if(update_primary)
                updateCurrencyAmount(spot + spot_plus)
            else
                updateSilverAmount(spot + spot_plus)
        }

        function updateSilverAmount(price)
        {
            if($('#amtcurrency').val() >= 0)
            {
                $('#amtsilver').val(Math.floor($('#amtcurrency').val() * 25 * 100 / price) / 100);
            }
        }

        function updateCurrencyAmount(price)
        {
            if($('#amtsilver').val() >= 0)
            {
                $('#amtcurrency').val(Math.floor($('#amtsilver').val() * 100 * price / 25) / 100);
            }
        }
    })
</script>
@endsection