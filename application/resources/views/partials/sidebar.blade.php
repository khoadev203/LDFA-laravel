 <div class="col-md-3">
    <div class="card">
        <div class="header">
            <h2><strong>{{__('Silver ')}}</strong> {{ __('Balance')}}</h2>
        </div>
        <div class="body">
            <h2 style="margin-bottom: 0;">{{ \App\Helpers\Money::instance()->value(Auth::user()->balance, 'Ounce') }}</h2>
            <a href="{{route('withdrawal.form')}}" class="btn btn-primary btn-round bg-blue">{{__('Sell')}}</a>

        </div>
    </div>
    <div class="card ">
        <!-- overflowhidden -->
        <div class="header">
            <h2><strong>{{ Auth::user()->currentCurrency()->name }}</strong> {{ __('Balance')}}</h2>
        </div>
        <div class="body">
            <small></small> 
            <h2 style="margin-bottom: 0;">${{ \App\Helpers\Money::instance()->value(Auth::user()->balance * setting('site.silver_price')) }}</h2>
        </div>
    </div>
    @if(Route::is('home'))

    @if(!empty($myEscrows))
    
    @foreach($myEscrows as $escrow)

        <div class="card">
            <div class="header">
                <h2><strong>On Hold</strong> #{{$escrow->id}}</h2>
                <ul class="header-dropdown">
                    <li class="remove">
                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h3 class="mb-0 pb-0">
               -  {{ \App\Helpers\Money::instance()->value( $escrow->gross, $escrow->currency_symbol )}}       
                </h3>
                Escrow money to  <a href="{{url('/')}}/escrow/{{$escrow->id}}"><span class="text-primary">{{$escrow->toUser->name}}</span></a> <br> 
                <form action="{{url('/')}}/escrow/release" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="eid" value="{{$escrow->id}}">
                    <input type="submit" class="btn btn-sm btn-round btn-primary btn-simple" value="{{_('Release')}}">
                    
                </form>
            </div>
        </div>

    @endforeach
    
    @endif 
    
    @if(!empty($toEscrows))
    
    @foreach($toEscrows as $escrow)

        <div class="card">
            <div class="header">
                <h2><strong>On Hold</strong> #{{$escrow->id}}</h2>
                <ul class="header-dropdown">
                    <li class="remove">
                        <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                    </li>
                </ul>
            </div>
            <div class="body">
                <h3 class="mb-0 pb-0">
                +  {{ \App\Helpers\Money::instance()->value( $escrow->gross, $escrow->currency_symbol )}}       
                </h3>
                Escrow money from <a href="{{url('/')}}/escrow/{{$escrow->id}}"><span class="text-primary">{{$escrow->User->name}}</span></a> 
                <form action="{{url('/')}}/escrow/refund" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="eid" value="{{$escrow->id}}">
                    <input type="submit" class="btn btn-sm btn-round btn-danger btn-simple" value="{{_('refund')}}">
                </form>
            </div>
        </div>

    @endforeach
    
    @endif 
 
    @endif
 
    @if(Auth::user()->isAdministrator() or Auth::user()->is_ticket_admin )
    <div class="card hidden-sm">
        <div class="header">
            <h2><strong>Admin</strong> area</h2>
            <ul class="header-dropdown">
                <li class="remove">
                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                </li>
            </ul> 
        </div>
        <div class="body">
                   <h5 class="card-title">Howdy Mr. admin {{Auth::user()->name}}</h5>
                <p class="card-text">In this section you have links that are only visible to admins.</p>
                 <div class="list-group mb-2">
                    <a href="{{ route('makeVouchers') }}" class="list-group-item list-group-item-action {{ (Route::is('makeVouchers') ? 'active' : '') }}">{{__('Generate Vouchers')}}</a>
                    @if (Auth::user()->is_ticket_admin)
                        <a href="{{ url('ticketadmin/tickets') }}" class="list-group-item list-group-item-action {{ (Route::is('support') ? 'active' : '') }}">{{__('Manage Tickets')}}</a>
                    @endif
                   <!--  @if(Auth::user()->isExchangeRole())
                        <a href="{{ url('/') }}/update_rates" class="list-group-item list-group-item-action ">{{__('Update Exchange Rates')}}</a>
                    @endif -->
                </div>
                <a href="{{url('/')}}/admin" class="btn btn-primary btn-round">Go to admin dashboard</a>                  
            
        </div>
    </div> 
    @endif
     @if(Route::is('home'))
     <div class="card hidden-sm">
        <div class="header">
            <h2><strong>Report</strong> area</h2>
            <ul class="header-dropdown">
                <li class="remove">
                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                </li>
            </ul>
        </div>
        <div class="body">
                   <h5 class="card-title">Create/Download the reports</h5>
                 <div class="list-group mb-2">
                    <a href="{{ route('view_report') }}" class="list-group-item list-group-item-action {{ (Route::is('view_report') ? 'active' : '') }}">{{__('View Created Reports')}}</a>
                </div> 
                <a href="{{route('create.reports')}}" class="btn btn-primary btn-round">Create Reports</a>                  
            
        </div>
    </div> 
    @endif
    @if(!Route::is('exchange.form'))
     
    <div class="list-group">
        {{--
        <a href="{{ route('home') }}" class="list-group-item list-group-item-action {{ (Route::is('home') ? 'active' : '') }}">Transactions</a>
        <a href="{{url('/')}}/exchange/first/0/second/0"  class="list-group-item list-group-item-action  {{ (Route::is('exchange.form') ? 'active' : '') }}">Exchange</a>
        <a href="{{route('sendMoneyForm')}}" class="list-group-item list-group-item-action {{ (Route::is('sendMoneyForm') ? 'active' : '') }}">Send Money</a>
        <a href="{{route('mydeposits')}}"  class="list-group-item list-group-item-action {{ (Route::is('mydeposits') ? 'active' : '') }}">Deposits</a>
        <a href="{{route('withdrawal.index')}}"  class="list-group-item list-group-item-action  {{ (Route::is('withdrawal.index') ? 'active' : '') }}">Withdrawals</a>
        
        <a class="list-group-item list-group-item-action {{ (Route::is('profile.info') ? 'active' : '') }}" href="{{route('profile.info')}}">{{__('Profile')}}</a>
        <a href="{{url('/')}}/my_tickets"  class="list-group-item list-group-item-action {{ (Route::is('support') ? 'active' : '') }}">{{__('Support')}}</a>
        @if(!Auth::user()->isAdministrator())
        <a href="{{url('/')}}/my_vouchers"  class="list-group-item list-group-item-action {{ (Route::is('my_vouchers') ? 'active' : '') }}">{{__('Vouchers')}}</a>
        @endif
        <a href="{{ route('mymerchants') }}" class="list-group-item list-group-item-action {{ (Route::is('mymerchants') ? 'active' : '') }}">{{__('Developers API')}}</a>
        --}}
    </div>
    @endif
</div>