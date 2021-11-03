@extends('layouts.app')
@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
            @include('flash')
            <div class="card">
                <div class="header">
                    <h2><strong>{{__('My Deposits ')}}</strong> {{__("by Authorize.net")}}</h2>
                
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                              <tr>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Name on Card')}}</th>
                                <th>{{__('Transaction ID')}}</th>
                                <th>{{__('Response Code')}}</th>
                                <th>{{__('Auth ID')}}</th>
                                <th>{{__('Message Code')}}</th>
                                <th>{{__('Quantity')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse($checks as $check)
                                <tr>
                                    <td>{{$check->created_at}}</td>
                                    <td>{{$check->amount}}</td>
                                    <td>{{$check->name_on_card}}</td>
                                    <td>{{$check->transaction_id}}</td>
                                    <td>{{$check->response_code}}</td>
                                    <td>{{$check->auth_id}}</td>
                                    <td>{{$check->message_code}}</td>
                                    <td>{{$check->quantity}}</td>
                                </tr>
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