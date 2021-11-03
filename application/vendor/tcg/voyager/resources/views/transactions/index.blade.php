@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.__('LDAdmin Balance'))

@php use App\User; 
@endphp
@section('page_header')
    <h1 class="page-title">
        {{ __('Pending Transactions') }}

    </h1>
<div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
<table class="table table-striped database-tables">
    <thead>
        <tr>
          <th>Sno</th>
          <th >{{__('Date')}}</th>
          <th class="hidden-xs">{{__('Name')}}</th>
          <th class="hidden-xs">{{__('Gross')}}</th>
          <th class="hidden-xs">{{__('Fee')}}</th>
          <th>{{__('Net')}}</th>
          <th>{{__('Metal Amount')}}</th>
          <th>{{__('Action')}}</th>
        </tr>
    </thead>
<?php $i=1; ?>
@foreach($getdata as $transaction)
    <tr>
        <td>
           {{$i}}
        </td>
    <td>{{$transaction->created_at->format('d M Y')}} <br> @include('home.partials.status')</td>
      <td class="hidden-xs"> @include('home.partials.name')</td>
      <td class="hidden-xs">{{$transaction->gross()}}</td>
      <td class="hidden-xs">{{$transaction->fee()}}</td>
      <td>{{$transaction->net()}}</td>
      <td>{{$transaction->metal_value()}}</td>
      <td><a href="{{ route('confirm_transactions',base64_encode(serialize($transaction->id))) }}"><button class="btn btn-success">Confirm</button></a></td>
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

