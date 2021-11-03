@extends('layouts.app')

@section('content')
    <div class="row">
        @include('partials.sidebar')
    
    <div class="col-md-9 ">
          @include('flash')
          @if($deposits->total()>0)
          <div class="card">
            <div class="header">
                <h2><strong>{{__('My Deposits')}}</strong></h2>
                
            </div>
            <div class="body">
              <div class="table-responsive">
                <table class="table table-striped"  style="margin-bottom: 0;">
                  <thead>
                    <tr>
                      <th>{{__('Date')}}</th>
                      <th>{{__('Method')}}</th>
                      <th>{{__('Gross')}}</th>
                      <th>{{__('Fee')}}</th>
                      <th>{{__('Net')}}</th>
                      <th>{{__('Message')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($deposits as $deposit)
                      <tr>
                        <td>
                          {{$deposit->created_at}}<br>
                          @include('deposits.partials.status')
                        </td>
                        <td>{{$deposit->deposit_type}}</td>
                        <td>{{$deposit->gross()}}</td>
                        <td>{{$deposit->fee()}}</td>
                        <td>{{$deposit->net()}}</td>
                        <td>{{$deposit->message}}</td>
                      </tr>
                    @empty
                    
                    @endforelse
                  </tbody>
                </table>                          
              </div> 
            </div>
            @if($deposits->LastPage() != 1)
              <div class="footer">
                  {{$deposits->links()}}
              </div>
            @else
            @endif
        </div>
          @endif

      </div>

    </div>

@endsection

@section('footer')
  @include('partials.footer')
@endsection