@extends('layouts.app')
@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
          @include('flash')
          <div class="card">
            <div class="header">
                <h2>{{__('Notifications')}}</strong></h2>
            </div>
            <div class="body">
              <table class="table">
                <thead>
                  <tr>
                    <th>Subject</th>
                    <th>Message</th>
                    <th>Notified at</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($notifications as $notify)
                  <tr>
                    <td>{{$notify->data['subject']}}</td>
                    <td style="white-space: break-spaces;">{{$notify->data['message']}}</td>
                    <td>{{$notify->created_at->diffForHumans()}}</td>
                    <td>
                      @if(Auth::user()->isAdministrator())
                        <form action="{{route('notifications.delete')}}" method="post">
                          @csrf
                          <input type="hidden" name="subject" value="{{$notify->data['subject']}}">
                          <input type="hidden" name="message" value="{{$notify->data['message']}}">
                          <input type="submit" class="btn btn-danger" value="Delete">
                            
                        </form>
                      @else
                        <a href="{{route('notifications.show', $notify->id)}}" class="btn btn-success me-2">View</a>
                      @endif
                    </td>
                  </tr>
                  @empty
                  <tr>
                    <td colspan="2">No notifications!</td>
                  </tr>
                  @endforelse
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