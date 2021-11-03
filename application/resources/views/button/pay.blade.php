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
            <h2><strong>Pay</strong> for product</h2>
          </div>
          <div class="body">
            <div class="alert alert-warning mb-3" role="alert">
              Here is your payment info!
            </div>
            <form action="{{route('paymoney', $button->id)}}" type="post">
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
                  <tr>
                    <td>Price(Ounce/USD):</td>
                    <td>{{$button->price()}}/{{$button->price() * setting('site.silver_price')}}</td>
                  </tr>
                  <tr>
                    <td>Shipping(Ounce/USD):</td>
                    <td>{{$button->shipping()}}/{{$button->shipping() * setting('site.silver_price')}}</td>
                  </tr>
                  <tr>
                    <td>Total:</td>
                    <td>
                      {{$button->price + $button->shipping}}/{{($button->price + $button->shipping) * setting('site.silver_price')}}
                      <input type="hidden" name="amount" value="{{$button->price + $button->shipping}}">
                    </td>
                  </tr>
                </tbody>
              </table>
              <input type="submit" value="Confirm Payment" class="btn btn-primary">
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