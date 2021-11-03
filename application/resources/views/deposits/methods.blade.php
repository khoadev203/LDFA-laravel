@extends('layouts.app')


@section('content')
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " >

          <div class="card" >
            <div class="header">
                <h2><strong>{{  __('Automatic Deposit Methods') }}</strong></h2>
                
            </div>
            <div class="body">
              @if(setting('payment-gateways.seamless_chex') == 1)
			        <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{url('/')}}/storage/imgs/seamless_arslanaslam.png" alt="Generic placeholder image" style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">SEAMLESS CHEX </strong><a href="{{url('/')}}/buyvoucher/seamless" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              @endif
              
              @if(setting('payment-gateways.enable_stripe') == 1)
              <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{url('/')}}/storage/imgs/xNyqTMuGhvfDAQGIpWxfWrz9K49MEpYlvWJgLPeG.jpeg" alt="Generic placeholder image" style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">Stripe </strong><a href="{{url('/')}}/buyvoucher/stripe" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              @endif
              @if(setting('payment-gateways.enable_paypal') == 1)
              <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{url('/')}}/storage/imgs/8rciiMbLu2wKiZ8pScxIVIQvwmWnCxSJeZbZg9uC.png" alt="Generic placeholder image"  style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">PayPal </strong><a href="{{url('/')}}/buyvoucher/paypal" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              @endif
	            @if(setting('payment-gateways.square_payments') == 1)
              <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{url('/')}}/storage/imgs/square_api.jpeg" alt="Generic placeholder image" style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">Credit/Debit Card (Square Payments) </strong><a href="{{url('/')}}/buyvoucher/square" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              @endif
              @if(setting('payment-gateways.enable_paystack') == 1 )
              <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{url('/')}}/storage/imgs/smOMNQbvaoIgP8Y2TcA6DfgAdVdWsXe1Caww3aYV.png" alt="Generic placeholder image" style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">Paystack </strong><a href="{{url('/')}}/buyvoucher/paystack" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              @endif
              
              <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{url('/')}}/storage/imgs/anet-logo-white.svg" alt="Generic placeholder image"  style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">Pay With Major Credit/Debit Cards </strong><a href="{{route('authorizenet.pay')}}" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>

              <div class="media border border-radius" style="border-radius: 6px">
                <i class="icon-envelope my-auto mr-3 text-center" style="width: 45px;"></i>
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">Pay With Electronic Check (may cause delays)</strong><a href="{{route('deposit.echeck')}}" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>

            </div>
          </div>

          <div class="card" >
            <div class="header">
              <h2><strong>Direct Deposit Form</strong></h2>
            </div>
            <div class="body">
              <a href="{{ route('deposit.downloadfile') }}">Download the form and fill info</a><br><br>
              <p>You can mail a check, cashier's check or money order to:</p>
              <p>Liberty Dollar Financial Association
                  520  Folly Road, Ste 25, PMB 284
                  Charleston SC 29412</p>
              <p><b>NOTE: WE CANNOT ACCEPT THIRD-PARTY CHECKS.</b></p>
            </div>
          </div>

          <div class="card" >
            <div class="header">
              <h2><strong>Wire Transfer </strong>Information</h2>
            </div>
            <div class="body">
              <div class="row">
                <div class="col-md-2">Beneficiary:</div>
                <div class="col-md-10">Liberty Dollar Financial Trust</div>
              </div>
              <div class="row">
                <div class="col-md-2">Bank Name:</div>
                <div class="col-md-10">Renasant Bank</div>
              </div>
              <div class="row">
                <div class="col-md-2">Address:</div>
                <div class="col-md-10">463 W Duvall St.</div>
              </div>
              <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-10">Lake City FL 32055 </div>
              </div>
              <div class="row">
                <div class="col-md-2">Routing #:</div>
                <div class="col-md-10">084201294</div>
              </div>
              <div class="row">
                <div class="col-md-2">Account #:</div>
                <div class="col-md-10">8010785393</div>
              </div>
              <br><br>
              <p>Please Notify Us Of Your Incoming Wire Deposit(admin@ldfa.nl)</p>
            </div>
          </div>

          {{--
           <div class="card" >
            <div class="header">

                <h2><strong>{{  __('Manual Deposit Methods') }}</strong>@if(env('APP_DEMO')) *Registered by admin @endif</h2>

                
            </div>
            <div class="body">
              @forelse($methods as $method)
                <div class="media border border-radius" style="border-radius: 6px">
                <img class="align-self-center mr-3" src="{{$method->thumb}}" alt="Generic placeholder image"  style="width: 45px;">
                <div class="media-body">
                  <p><strong class="title pt-2 float-left">{{$method->name}}</strong><a href="{{url('/')}}/addcredit/{{$method->id}}" class="btn btn-primary float-right mr-1">Add Credit</a></p>
                </div>
              </div>
              @empty

              @endforelse

            </div>
          </div>
          --}}
        </div>
    </div>

@endsection
