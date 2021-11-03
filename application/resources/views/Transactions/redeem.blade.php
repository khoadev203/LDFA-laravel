@extends('layouts.app')
@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
          @include('flash')
          <div class="card">
            <div class="header">
                <h2><strong>{{__('REDEEM')}}</strong> {{__("FROM YOUR ACCOUNT")}}</h2>
                
            </div>
            <div class="body">
              <form action="{{route('redeem')}}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <center>
                  <h4>Redeem</h4>
                </center>

                <h5 >How many ounces do you want to Redeem?</h5>
                <p>Our Redemption Silver at this time is the Pyromet Silver  Cards. Each card sells for SPOT from your account, plus a $3 manufacturing fee. Please note that it can take up to 5 weeks for delivery due t the current backorder situation with our suppliers.</p>
                <center>
                <div class="row mb-12">
                 
                  <div class="col">
                    <img src="{{ asset('application/public/assets/images/silver_card.png')}}" height="100px">
                  </div>

                </div>
                <div class="clearfix"></div>
                 <div class="form-group col-md-4">
                    <label for="amount" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('Silver amount(ounces)')}}</label>
                      <input type="number" class="form-control" id="ounce" name="ounce" value="{{old('ounce')}}" required placeholder="1" pattern="[0-9]+([\,][0-9]+)?" value="0">
                  </div>
                <input type="hidden" name="price" id="price" value="{{$metalPrice}}">
                </center>
                <div class="row">
                  <div class="col">
                    <input type="submit" class="btn btn-primary float-right" value="{{__('Redeem')}}">
                  </div>
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