@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.__('LDAdmin Balance'))

@php use App\User; 
@endphp
@section('page_header')
    <h1 class="page-title">
        {{ __('Redeem') }}

    </h1>
<div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
<table class="table table-striped database-tables">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Userid</th>
            <th>Ounce</th>
            <th>Date</th>
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
            <?php $username = User::where('id',$table->user_id)->select('name')->first();?>
           {{$username->name}}
        </td>
        <td>
           {{$table->ounce}}
        </td>
        <td>
           {{$table->created_at->format('Y-m-d h:i:sa')}}
        </td>
        <td>
           <a href="{{ route('confirm_redeem',base64_encode(serialize($table->id))) }}"><button class="btn btn-success">Confirm</button></a>
           <a href="{{route('reject_redeem', base64_encode(serialize($table->id)))}}" class="btn btn-dark btn-sm">Reject</a>
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

