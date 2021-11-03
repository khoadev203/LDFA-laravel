@extends('layouts.app')
@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
            @include('flash')
            <div class="card">
                <div class="header">
                    <h2><strong>{{__('My Bill ')}}</strong> {{__("Checks")}}</h2>
                
                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table m-b-0">
                            <thead>
                              <tr>
                                <th>{{__('Date')}}</th>
                                <th>{{__('Check Number')}}</th>
                                <th>{{__('Payee')}}</th>
                                <th>{{__('Amount')}}</th>
                                <th>{{__('Account Number')}}</th>
                                <th>{{__('Phone Number')}}</th>
                                <th>{{__('Note')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Action')}}</th>
                              </tr>
                            </thead>
                            <tbody>
                                @forelse($checks as $check)
                                <tr>
                                    <td>{{$check->created_at}}</td>
                                    <td>{{$check->check_number}}</td>
                                    <td>{{$check->payee}}</td>
                                    <td>{{$check->amount}}</td>
                                    <td>{{$check->account_num}}</td>
                                    <td>{{$check->phone_num}}</td>
                                    <td>{{$check->note}}</td>
                                    <td>
                                        @if($check->status == 1)
                                            <span class="badge badge-pill badge-primary">Completed</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">Voided</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($check->executer_id == Auth::user()->id)
                                        <a href="{{route('viewcheck', $check->id)}}" class="btn btn-primary btn-sm">View</a>
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