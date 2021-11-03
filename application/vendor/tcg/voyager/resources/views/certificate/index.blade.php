@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.__('LDAdmin Balance'))

@php use App\User; 
@endphp

@section('page_header')
    <h1 class="page-title">
        {{ __('Buy Certificates') }}

    </h1>
    <div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <table class="table table-striped database-tables">
                    <thead>
                        <tr>
                            <th>Sno</th>
                            <th>User</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Currency</th>
                            <th>Currency Amount</th>
                            <th>Net</th>
                            <th>Fee</th>
                            <th>Metal Amount</th>
                            <th>Date</th>
                            <th>Shipping Address</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                <?php $i=1; ?>
                @foreach($getdata as $table)
                    <tr>
                        <td>
                           {{$i}}
                        </td>
                        <td>
                           {{$table->user->name}}
                        </td>
                        <td>{{$table->cert_type}}</td>
                        <td>
                           {{$table->quantity}}
                        </td>
                        <td>{{$table->currency->symbol}}</td>
                        <td>{{$table->currency_amount}}</td>
                        <td>{{$table->currency_net}}</td>
                        <td>{{$table->currency_fee}}</td>
                        <td>{{$table->metal_amount}}</td>
                        <td>
                           {{$table->created_at}}
                        </td>
                        <td>{{$table->shipping_address}}</td>
                        <td>
                           <a href="{{ route('confirm_certificate', base64_encode(serialize($table->id))) }}"><button class="btn btn-success btn-sm">Confirm</button></a>
                           <a href="{{ route('reject_certificate', base64_encode(serialize($table->id)))}}" class="btn btn-dark btn-sm">Reject</a>
                        </td>
                    </tr>
                    <?php $i++; ?>
                @endforeach
                </table> 
            </div>
        </div>
    </div>
@stop
@section('content')


@stop

