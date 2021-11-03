@extends('layouts.app')
@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
            @include('flash')
            <div class="card">
                <div class="header">
                    <h2> {{__("My ")}}<strong>{{__(' Coin Orders')}}</strong></h2>
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Shipping Address</th>
                                    <th>Quantity</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                <tr>
                                    <td>{{$order->created_at}}</td>
                                    <td>{{$order->name}}</td>
                                    <td>{{$order->email}}</td>
                                    <td>{{$order->shipping_address}}</td>
                                    <td>{{$order->quantity}}</td>
                                    <td>{{$order->price}}</td>
                                    <td>{{$order->quantity * $order->price}}</td>
                                    <td>
                                        @if($order->status == 'Completed')
                                            <span class="badge badge-pill badge-primary">Completed</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">Pending</span>
                                        @endif
                                    </td>
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