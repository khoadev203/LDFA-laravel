@extends('layouts.app')

@section('content')
{{--  @include('partials.nav')  --}}
  <div class="row">
        @include('partials.sidebar')
		
		<div class="col-md-9 " style="padding-right: 0">
 
    @include('partials.flash')

    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
            <div class="text-center">
              <a href="{{route('button.createbutton', 'Donate')}}" class="btn btn-warning btn-round mb-3">{{__('Donate')}}</a>
              <p>Accept one-time and recurring donations with a custom Donate button, shareable link.</p>
            </div>            
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body text-center">
              <a href="{{route('button.createbutton','Subscribe')}}" class="btn btn-warning btn-round mb-3">{{__('Subscribe')}}</a>
              <p>Set up recurring charges of the same amount for your goods and services.</p>
          </div>
        </div>
      </div>

      <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <a href="{{route('button.createbutton','Buy')}}" class="btn btn-warning btn-round mb-3">{{__('Buy Now')}}</a>
                <p>Make it easy to buy one or more of a single item.</p>

            </div>
        </div>
      </div>
    </div>
  </div>

@endsection
@section('footer')
  @include('partials.footer')
@endsection