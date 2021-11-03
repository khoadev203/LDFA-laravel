@extends('layouts.app')
@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
          @include('flash')
          <div class="card">
            <div class="header">
                <h2>{{__('Notification!')}}</strong></h2>
            </div>
            <div class="body">
              <table class="table">
                <tbody>
                  <tr>
                    <td>Subject</td>
                    <td>{{$notification->data['subject']}}</td>
                  </tr>
                  <tr>
                    <td>Message</td>
                    <td style="white-space: break-spaces;">{{$notification->data['message']}}</td>
                  </tr>
                  <tr>
                    <td>Notified At</td>
                    <td>{{$notification->created_at->diffForHumans()}}</td>
                  </tr>
                </tbody>
              </table>              
            </div>
          </div>
          
        </div>
    </div>
@endsection
@section('footer')
@include('partials.footer')
@endsection