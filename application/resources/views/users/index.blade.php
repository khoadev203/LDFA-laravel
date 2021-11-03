@extends('layouts.app')

@section('content')

    <div class="row clearfix">
        @include('partials.sidebar')
		
		<div class="col-md-9 " >
        	@include('partials.flash')
        	
        	@if($users->total() > 0)

        	<div class="card user-account">
				<div class="header">
				  <h2><strong>Registered</strong> Users</h2>
				  {{--
				  <ul class="header-dropdown">
				      <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
				          <ul class="dropdown-menu dropdown-menu-right slideUp float-right">
				              <li><a href="javascript:void(0);">Action</a></li>
				              <li><a href="javascript:void(0);">Another action</a></li>
				              <li><a href="javascript:void(0);">Something else</a></li>
				          </ul>
				      </li>
				      <li class="remove">
				          <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
				      </li>
				  </ul>
				  --}}
				</div>
				<div class="body">
				<div class="table-responsive">
				  <table class="table m-b-0">
				      <thead>
				          <tr>
				              <th>{{__('Avatar')}}</th>
				              <th >{{__('name')}}</th>
				              <th class="hidden-xs">{{__('email')}}</th>
				              <th class="hidden-xs">{{__('Phonenumber')}}</th>
				              <th class="hidden-xs">{{__('Impersonate')}}</th>
							  <th>{{__('Status')}}</th>
							  <th>{{__('Verified')}}</th>
							  <th>{{__('Action')}}</th>
				          </tr>
				      </thead>
				      @forelse($users as $user)
				        <tr>
				          <td><img src="{{$user->avatar()}}" alt="" class="rounded" loading="lazy"></td>
				          <td>{{$user->name}}</td>
				          <td class="hidden-xs"> {{$user->email}}</td>
				          <td class="hidden-xs">{{$user->whatsapp}}</td>
				          <td class="hidden-xs"><a href="{{url('/')}}/impersonate/user/{{$user->id}}">Impersonate</a></td>
						  <td>{{$user->getAccountStatus()}}</td>
						  <td>
						  @if($user->isActivated())
						  	{{__('Yes')}}
						  @else
						  	{{__('No')}}
						  @endif
						  </td>
						  <td>
						  	@if( ! $user->isSuspended())
							  	<a href="{{route('suspenduser', [$user->id])}}" class="btn btn-danger text-light mr-2">Suspend</a>
							@else
								<a href="{{route('recoveruser', [$user->id])}}" class="btn btn-success text-light mr-2">Recover</a>
							@endif
							@if( !$user->isActivated())
								<a href="{{route('verifyuser', [$user->id])}}" class="btn btn-success text-light mr-2">Verify</a>
							@endif
						  </td>
				        </tr>
				    @empty
				    
				    @endforelse
				  </table>
				</div>
				</div>
				@if($users->LastPage() != 1)
				<div class="footer">
					{{$users->links()}}
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
