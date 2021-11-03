@extends('layouts.app')
@section('content')
{{--  @include('partials.nav')  --}}
<div class="row">
   @include('partials.sidebar')
   <div class="col-md-9 " style="padding-right: 0">
      @include('partials.flash')
      <div class="col-md-12">
        <div class="card mb-0">
          <div class="header">
            <h2><strong>Donate</strong></h2>
          </div>
          <div class="body">
            <form action="{{route('donate')}}" method="post">
              @csrf
              <h4 class="text-center">Donate to {{$donate_to}}</h4>
              <h5 class="text-center">{{$button->description}}</h5>
              <h2 class="text-center">$<span>{{$button->price() * setting('site.silver_price')}}</span></h2>
              <h3 class="text-center">{{$button->price()}} ounce(s)</h3>
              {{--
              <div class="text-center mb-5">
                <input type="number" name="amount" class="form-control w-50 d-inline">
                ounces
              </div>
              --}}
              <div class="text-center">
                <input type="hidden" name="button_id" value="{{$button->id}}">
                <input type="submit" value="Donate" class="btn btn-primary">
              </div>
            </form>
          </div>
        </div>
      </div>
   </div>
</div>

@endsection
@section('footer')
@include('partials.footer')
@endsection