@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
    <div class="row">
        @include('profile.partials.sidenav')
		
		<div class="col-lg-9 ">
      @include('flash')
      <div class="card">
        <div class="header">
            <h2><strong>{{__('Credit Card')}}</strong> Info </h2>
            
        </div>
        <div class="body">
            <div class="alert alert-dark text-dark" role="alert">
              Your credit info is guaranteed security!
            </div>
            <form class="needs-validation" enctype="multipart/form-data" method="POST" action="{{route('profile.creditcard.store')}}">
            {{csrf_field()}}
            <div class="row mb-3">
              <div class="form-group owner col-md-8">
                <label for="owner">Name on Card</label>
                <input type="text" class="form-control" id="owner" name="owner" value="{{$owner}}">
              </div>
              <div class="form-group CVV col-md-4">
                <label for="cvv">CVV</label>
                <input type="number" class="form-control" id="cvv" name="cvv" value="{{$cvv}}">
              </div>
            </div>
            <div class="row mb-3">
              <div class="form-group col-md-4" id="card-number-field">
                <label for="cardNumber">Card Number</label>
                <input type="text" class="form-control" id="cardNumber" name="cardNumber" value="{{$cardNumber}}">
              </div>
              <div class="form-group col-md-4">
                <label for="company">Company</label>
                <input type="text" class="form-control" id="company" name="company" value="{{$company}}" placeholder="ex: Souveniropolis">
              </div>
              <div class="form-group col-md-4">
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" name="address" value="{{$address}}" placeholder="ex: 14 Main Street">
              </div>
            </div>
                  
            <div class="row mb-3">

              <div class="form-group col-md-6">
                <label for="city">City</label>
                <input type="text" class="form-control" id="city" name="city" value="{{$city}}" placeholder="ex: Pecan Spring">
              </div>
              <div class="form-group col-md-6">
                <label for="state">State</label>
                <input type="text" class="form-control" id="state" name="state" value="{{$state}}" placeholder="ex: TX">
              </div>
            </div>

            <div class="row mb-3">

              <div class="form-group col-md-6">
                <label for="zip">Zip</label>
                <input type="text" class="form-control" id="zip" name="zip" value="{{$zip}}" placeholder="ex:44628">
              </div>
              <div class="form-group col-md-6">
                <label for="country">Country</label>
                <input type="text" class="form-control" id="country" name="country" value="{{$country}}" placeholder="ex: USA">
              </div>
            </div>

            <hr class="mb-4">
            <input class="btn btn-primary btn-lg btn-block" type="submit" value="{{__('Save')}}"></input>
          </form>                       
            
        </div>
    </div>
          
    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection
