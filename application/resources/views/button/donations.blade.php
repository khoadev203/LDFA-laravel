@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
  <div class="row">
    @include('partials.sidebar')
    
    <div class="col-md-9 ">
        @include('partials.flash')
        <div class="card user-account">
          <div class="header">
              <h2><strong>{{__('My Donations')}}</strong></h2>
          </div>
          <div class="body">
            <div class="table-responsive">
              <table class="table table-striped"  style="margin-bottom: 0;">
                <thead>
                  <tr>
                    <th>{{__('Date')}}</th>
                    <th>{{__('Donate to')}}</th>
                    <th>{{__('Amount (Ounce)')}}</th>
                    <th>{{__('Amount (USD)')}}</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($donations as $value)
                    @if( ! is_null($value->Button))
                    <tr>
                      <td>{{$value->created_at}}</td>
                      <td>
                        <img src="{{$value->User->avatar}}" class="rounded">
                        {{$value->User->name}}
                      </td>
                      <td>{{$value->Button->price()}}</td>
                      <td>{{$value->metal_price * $value->Button->price}}</td>
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