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
            <h2><strong>Subscribe</strong></h2>
          </div>
          <div class="body">
            <div class="alert alert-warning mb-3" role="alert">
              Here is your subscription info!
            </div>
            <form action="{{route('add_subscription')}}" method="post">
              @csrf
              <table class="table mb-3">
                <tbody>
                  <tr>
                    <td>Item Name:</td>
                    <td>{{$button->itemname}}</td>
                  </tr>
                    @forelse($items as $key=>$value)
                    <tr>
                      <td>{{$key}}:</td>
                      <td>{{$value}}</td>
                    </tr>
                    @empty
                    @endforelse
                    <input type="hidden" name="json_data" value="{{json_encode($items)}}">
                    <input type="hidden" name="button_id" value="{{$button->id}}">
                  <tr>
                    <td>Billing Amount(Ounce/USD):</td>
                    <td>{{$button->price()}}/{{$button->price() * setting('site.silver_price')}}</td>
                  </tr>
                  <tr>
                    <td>Billing Cycle</td>
                    <td>{{$button->billing_cycle.' '.$button->billing_cycle_unit}}</td>
                  </tr>
                  <tr>
                    <td>Billing Stop</td>
                    <td>{{$button->billing_stop}}</td>
                  </tr>
                </tbody>
              </table>
              <input type="submit" value="Subscribe" class="btn btn-primary">
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