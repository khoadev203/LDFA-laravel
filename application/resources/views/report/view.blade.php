@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
    <div class="row">
        @include('partials.sidebar')
		
		<div class="col-md-9 ">
        
	        @if($getdata->total()>0)
          <div class="card">
            <div class="header">
                <h2><strong>{{__('My Created Reports')}}</strong></h2>
                
            </div>
            <div class="body">
              <div class="table-responsive">
                <table class="table table-striped"  style="margin-bottom: 0;">
                  <thead>
                    <tr>
                      <th>{{__('Sno')}}</th>
                      <th>{{__('Date Range')}}</th>
                      <th>{{__('Action')}}</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php $i=1; ?>
                    @foreach($getdata as $value)
                      <tr>
                        <td>{{$i}}</td>
                        <td>{{$value->daterange}}</td>
                        <td><a href="{{route('download_csv',$value->id)}}" class="btn btn-info">{{__('Download')}}</a></td>
                      </tr>
                    <?php $i++; ?>
                    @endforeach
                  </tbody>
                </table>                          
              </div> 
            </div>
            @if($getdata->LastPage() != 1)
              <div class="footer">
                  {{$getdata->links()}}
              </div>
            @endif
        </div>
          @endif

    	</div>

    </div>

@endsection
@section('footer')
  @include('partials.footer')
@endsection