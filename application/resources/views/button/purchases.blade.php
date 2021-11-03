@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
  <div class="row">
    @include('partials.sidebar')
    
    <div class="col-md-9 ">
        @include('partials.flash')
        <div class="card user-account">
          <div class="header">
              <h2><strong>{{__('My Purchases')}}</strong></h2>
          </div>
          <div class="body">
            <div class="table-responsive">
              <table class="table table-striped"  style="margin-bottom: 0;">
                <thead>
                  <tr>
                    <th>{{__('Merchant')}}</th>
                    <th>{{__('Item Name')}}</th>
                    <th>{{__('Item options')}}</th>
                    <th>{{__('Quantity')}}</th>

                    <th>{{__('Amount (Ounce)')}}</th>
                    <th>{{__('Amount (USD)')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($purchases as $value)
                    @if( ! is_null($value->Button))
                    <tr>
                      <td>
                        <img src="{{$value->Merchant->avatar}}" class="rounded">
                        {{$value->Merchant->name}}
                      </td>
                      <td>{{$value->Button->itemname}}</td>
                      @php
                        $options = json_decode($value->json_data);
                      @endphp

                      <td>
                        @forelse($options as $key=>$option)
                          {{$key}}: {{$option}}
                        <br>
                        @empty
                        @endforelse
                      </td>

                      <td>{{$value->Button->quantity}}</td>
                      <td>{{$value->gross}}</td>
                      <td>{{$value->metal_price * $value->gross}}</td>
                    </tr>
                    @endif
                  @empty
                  
                  @endforelse
                </tbody>
              </table>                          
            </div> 
          </div>
        </div>
    </div>

  </div>

@endsection

@section('footer')
  @include('partials.footer')
@endsection