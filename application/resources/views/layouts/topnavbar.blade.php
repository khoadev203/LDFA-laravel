<nav class="top_navbar">
    <div class="container">
        <div class="row clearfix">
            <div class="col-12">
                @include('cookieConsent::index')
            </div>
        </div>
        <div class="row clearfix">
            <div class="col-12">
                <div class="navbar-logo">
                    <a href="javascript:void(0);" class="bars"></a>
                    <a class="navbar-brand" href="{{ url('/') }}">
                        @impersonating

                        @else
                        <img src="{{ setting('site.logo_url') }}" height="42" alt="{{ setting('site.site_name') }}">
                        @endImpersonating
                        <span class="m-l-10">@if(setting('site.enable_text_logo')){{ setting('site.site_name') }}@endif</span>
                    </a>
                </div>
                @auth
                <ul class="nav navbar-nav">
                    @impersonating
                    <li class="dropdown task ">
                      <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="icon-user"></i>
                            <span class="label-count">{{__('Impersonated')}}</span>
                        </a>  
                    </li>
                    @endImpersonating
                    <li class="dropdown notifications">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="icon-bell"></i>
                            <span class="noti-icon-badge d-none"></span>
                        </a>
                        <ul class="dropdown-menu pullDown">
                            <li>
                                <h6 class="m-3">Notifications</h6>
                                <hr class="mb-0">
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown task ">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <i class="icon-wallet"></i>
                            <span class="label-count">{{Auth::user()->currentCurrency()->symbol}}</span>
                        </a>
                    </li> 
                    <li class="dropdown profile">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button">
                            <img src="{{Auth::user()->avatar()}}" alt="" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu pullDown">
                            <li>
                                <div class="user-info">
                                    <h6 class="user-name m-b-0">{{Auth::user()->name}}</h6>
                                    @if(Auth::user()->verified == 1 )
                                    <p class="user-position"><span class="badge badge-success ml-0 mt-3">Verified</span></p>
                                    @else
                                    <p class="user-position"><a class="" href="{{url('/')}}/resend/activationlink"><span class="badge badge-danger ml-0 mt-3">Verify your email</span></a></p>
                                    @endif
                                    <hr>
                                </div>
                            </li>                            
                            <li>
                                <a href="{{route('profile.info')}}"><i class="icon-user m-r-10"></i> <span>{{__('Profile')}}</span> </a>
                            </li>
                            <li>
                                <a href="{{url('/')}}/blog"><i class="icon-directions m-r-10"></i><span>{{__('Tutorials')}}</span></a>
                            </li>                            
                            <li><a href="{{url('/')}}/my_tickets"><i class="icon-lock m-r-10"></i><span>{{__('Support')}}</span></a></li>
                            @impersonating
                            <li>
                                <a href="{{ route('impersonate.leave') }}"><i class="icon-power m-r-10"></i><span>{{__('Leave impersonation')}}</span></a>
                            </li>
                            @endImpersonating
                            <li><a  href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="icon-power m-r-10"></i><span>    {{ __('Logout') }}</span></a><form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form></li>
                        </ul>
                    </li>
                    {{-- <li><a href="javascript:void(0);" class="js-right-sidebar"><i class="icon-equalizer"></i></a></li> --}}
                </ul>
                @endauth
            </div>
        </div>        
    </div>
</nav> --}}