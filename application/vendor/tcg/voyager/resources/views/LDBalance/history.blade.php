@extends('voyager::master')

@section('page_title', __('voyager::generic.viewing').' '.__('LDAdmin Balance'))


@section('page_header')
    <h1 class="page-title">
        {{ __('LDFAdmin Balance') }}

    </h1>
<div class="page-content container-fluid">
        <div class="row">
            <div class="col-md-12">
<table class="table table-striped database-tables">
    <thead>
        <tr>
            <th>Sno</th>
            <th>Amount</th>
            <th>Invested Currency Type</th>
            <th>Conversion Amount</th>
            <th>Description</th>
            <th>Date</th>
        </tr>
    </thead>
<?php $i=1; ?>
@foreach($getdata as $table)
    <tr>
        <td>
           {{$i}}
        </td>
        <td>
           {{$table->amount}}
        </td>
        <td>
           {{$table->type}}
        </td>
        <td>
           {{$table->other_currency_amount}}
        </td>


        <td><textarea rows="3" cols="50">{{strip_tags($table->description)}}</textarea></td>

        <td>
           {{$table->created_at->format('Y-m-d h:i:sa')}}
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

