
<aside id="leftsidebar" class="sidebar h_menu">
    <div class="container">
        <div class="row clearfix">
            <div class="col-12">
                <div class="menu">
                    <ul class="list">
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                        <li class="header">MAIN</li>

                        <li class="{{ (Route::is('home') || Route::is('mydeposits') || Route::is('withdrawal.index') || Route::is('billchecks.index') || Route::is('calculator') ? 'active open' : '') }}"> 
                            <a href="javascript:void(0);" class="menu-toggle"><i class="icon-grid"></i><span>{{__('Main Account')}}</span></a>
                            <ul class="ml-menu">
                                <li><a href="{{ route('home') }}"><span>{{__('Overview')}}</span></a></li>
                                <li><a href="{{ route('mydeposits') }}"><span>{{__('My Deposits')}}</span></a></li>
                                <li><a href="{{ route('withdrawal.index') }}"><span>{{__('My Withdrawals')}}</span></a></li>
                                <li><a href="{{ route('billchecks.index') }}"><span>{{__('My Bills')}}</span></a></li>
                                <li><a href="{{ route('calculator') }}"><span>{{__('Calculator')}}</span></a></li>
                                <li><a href="{{ route('purchasehistory') }}"><span>{{__('Purchase History')}}</span></a></li>
                                
                                <li><a href="{{ route('subscriptions') }}"><span>{{__('Subscriptions')}}</span></a></li>

                                <li><a href="{{ route('donations') }}"><span>{{__('Donations')}}</span></a></li>
                                <li><a href="{{route('my_cert_orders')}}"><span>Certificate Orders</span></a></li>

                                <li><a href="{{route('coin.myorders')}}"><span>Coin Orders</span></a></li>

                            </ul>
                        </li>

                        <li class="{{ (Route::is('mytdaccs') ? 'active open' : '') }}"> 
                            <a href="{{ route('mytdaccs') }}" class="menu-toggle"><i class="icon-grid"></i><span>{{__('TD Accounts')}}</span></a>
                            
                            {{--<ul class="ml-menu">
                            @forelse($tdaccounts as $tdaccount)
                                <li><a href="{{route('tdaccounts', [$tdaccount->id])}}"><span>{{$tdaccount->name}}</span></a></li>
                            @empty
                                <li>No subaccounts are available!</li>
                            @endforelse
                            </ul>--}}
                        </li>

                        <li class="{{ (Route::is('redeem') || Route::is('buy_certificate') || Route::is('my_cert_orders') || Route::is('sendMoneyForm') || Route::is('requestMoneyForm') || Route::is('escrow') ? 'active open' : '') }}"> 
                            <a href="#" class="menu-toggle"><i class="icon-diamond"></i><span>{{__('New Transactions')}}</span></a>
                            <ul class="ml-menu">
                                <li><a href="{{route('sendMoneyForm')}}"><span>{{__('Send Payment')}}</span></a></li>
                                <li><a href="{{route('requestMoneyForm')}}"><span>{{__('Request Payment')}}</span></a></li>
                                <li><a href="{{route('escrow')}}"><span>{{__('Escrow')}}</span></a></li>
                                <li><a href="{{route('post.withdrawal')}}"><span>{{__('Request Withdrawal')}}</span></a></li>
                                <li><a href="{{route('buy_certificate')}}"><span>Order Certificates</span></a></li>
                                <li><a href="{{route('redeem')}}"><span>{{__('Redeem')}}</span></a></li>
                                <li><a href="{{route('paybill')}}"><span>{{__('Pay Bills')}}</span></a></li>
                                <li><a href="{{route('coin.order')}}"><span>{{__('Order Coin')}}</span></a></li>
                            </ul>
                        </li>

                        <li class="{{ (Route::is('affiliatedetails') || Route::is('downlines') || Route::is('banners') ? 'active open' : '') }}">
                            <a href="javascript:void(0);" class="menu-toggle"><i class="icon-layers"></i><span>Affiliate Program</span></a>
                            <ul class="ml-menu">
                                <li><a href="{{route('affiliatedetails')}}"><span>Program Details</span></a></li>
                                <li><a href="{{route('downlines')}}"><span>Your Downline</span></a></li>
                                <li><a href="{{route('banners')}}"><span>Our Banners</span></a></li>
                            </ul>
                        </li>

                        {{--
                        <li class="{{ (Route::is('mymerchants') ? 'active open' : '') }}"> 
                            <a href="{{ route('mymerchants') }}"><i class="icon-speedometer"></i><span>
                            {{__('Developers API')}}</span></a>
                        </li>--}}
                       
                        <li class="{{ (Route::is('button.index') ? 'active open' : '') }}">
                            <a href="javascript:void(0);" class="menu-toggle"><i class="icon-mouse"></i><span>Buttons</span></a>
                            <ul class="ml-menu">
                                <li><a href="{{route('button.index')}}"><span>{{__('Add Buttons')}}</span></a></li>
                                <li><a href="{{route('button.view')}}"><span>View Saved buttons</span></a></li>
                            </ul>
                        </li>

                        <li class="{{ (Route::is('page/10') ? 'active open' : '') }}"> 
                            <a href="{{url('page/10')}}"><i class="icon-arrow-up"></i><span>
                            {{__('Branch Office')}}</span></a>
                        </li>

                        <li>
                            <a href="javascript:void(0);" class="menu-toggle">
                                <i class="icon-support"></i><span>Communications</span>
                            </a>
                            <ul class="ml-menu">
                                <li><a href="{{route('messages')}}">Message</a></li>
                                <li><a href="{{url('my_tickets')}}">Support Ticket</a></li>
                                <li><a href="{{route('notifications')}}">Notifications</a></li>
                            </ul>
                        </li>

                        {{--
                        @if(!Auth::user()->isAdministrator())
                        <li class="{{ (Route::is('my_vouchers') ? 'active open' : '') }}"> 
                            <a href="{{url('/')}}/my_vouchers"><i class="icon-speedometer"></i><span>
                            {{__('Vouchers')}}</span></a>
                        </li>
                        @endif
                        --}}


                        {{--
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="icon-grid"></i><span>App</span></a>
                            <ul class="ml-menu">
                                <li><a href="mail-inbox.html">Inbox</a></li>
                                <li><a href="chat.html">Chat</a></li>
                                <li><a href="events.html">Calendar</a></li>
                                <li><a href="file-dashboard.html">File Manager</a></li>
                                <li><a href="contact.html">Contact list</a></li>
                                <li><a href="blog-dashboard.html">Blog</a></li>
                                <li><a href="app-ticket.html">Support Ticket</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="icon-basket-loaded"></i><span>Ecommerce</span></a>
                            <ul class="ml-menu">
                                <li><a href="ec-dashboard.html">Dashboard</a></li>
                                <li><a href="ec-product.html">Products</a></li>
                                <li><a href="ec-product-detail.html">Product Detail</a></li>
                                <li><a href="ec-product-List.html">Product List</a></li>
                                <li><a href="ec-product-order.html">Orders</a></li>
                                <li><a href="ec-product-cart.html">Cart</a></li>
                                <li><a href="ec-checkout.html">Checkout</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="javascript:void(0);" class="menu-toggle"><i class="icon-layers"></i><span>UI Elements</span></a>
                            <ul class="ml-menu">
                                <li><a href="ui-kit.html">UI KIT</a></li>                    
                                <li><a href="ui-alerts.html">Alerts</a></li>                    
                                <li><a href="ui-collapse.html">Collapse</a></li>
                                <li><a href="ui-colors.html">Colors</a></li>
                                <li><a href="ui-dialogs.html">Dialogs</a></li>
                                <li><a href="ui-icons.html">Icons</a></li>                    
                                <li><a href="ui-listgroup.html">List Group</a></li>
                                <li><a href="ui-mediaobject.html">Media Object</a></li>
                                <li><a href="ui-modals.html">Modals</a></li>
                                <li><a href="ui-notifications.html">Notifications</a></li>                    
                                <li><a href="ui-progressbars.html">Progress Bars</a></li>
                                <li><a href="ui-rangesliders.html">Range Sliders</a></li>
                                <li><a href="ui-sortablenestable.html">Sortable & Nestable</a></li>
                                <li><a href="ui-tabs.html">Tabs</a></li>
                                <li><a href="ui-waves.html">Waves</a></li>
                            </ul>
                        </li>
                        <li class="header">FORMS, CHARTS, TABLES</li>
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="icon-doc"></i><span>Forms</span></a>
                            <ul class="ml-menu">
                                <li><a href="form-basic.html">Basic Elements</a></li>
                                <li><a href="form-advanced.html">Advanced Elements</a></li>
                                <li><a href="form-examples.html">Form Examples</a></li>
                                <li><a href="form-validation.html">Form Validation</a></li>
                                <li><a href="form-wizard.html">Form Wizard</a></li>
                                <li><a href="form-editors.html">Editors</a></li>
                                <li><a href="form-upload.html">File Upload</a></li>
                                <li><a href="form-img-cropper.html">Image Cropper</a></li>
                                <li><a href="form-summernote.html">Summernote</a></li>
                            </ul>
                        </li>
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="icon-tag"></i><span>Tables</span></a>
                            <ul class="ml-menu">                        
                                <li><a href="table-normal.html">Normal Tables</a></li>
                                <li><a href="table-jquerydatatable.html">Jquery Datatables</a></li>
                                <li><a href="table-editable.html">Editable Tables</a></li>                                
                                <li><a href="table-color.html">Tables Color</a></li>
                                <li><a href="table-filter.html">Tables Filter</a></li>
                            </ul>
                        </li>            
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="icon-bar-chart"></i><span>Charts</span></a>
                            <ul class="ml-menu">
                                <li><a href="morris.html">Morris</a></li>
                                <li><a href="flot.html">Flot</a></li>
                                <li><a href="chartjs.html">ChartJS</a></li>
                                <li><a href="sparkline.html">Sparkline</a></li>
                                <li><a href="jquery-knob.html">Jquery Knob</a></li>
                            </ul>
                        </li>
                        <li class="header">EXTRA COMPONENTS</li>                    
                        <li><a href="javascript:void(0);" class="menu-toggle"><i class="icon-puzzle"></i><span>Widgets</span></a>
                            <ul class="ml-menu">
                                <li><a href="widgets-app.html">Apps Widgetse</a></li>
                                <li><a href="widgets-data.html">Data Widgetse</a></li>
                                <li><a href="widgets-chart.html">Chart Widgetse</a></li>
                            </ul>
                        </li>
                        <li> <a href="javascript:void(0);" class="menu-toggle"><i class="icon-lock"></i><span>Auth</span></a>
                            <ul class="ml-menu">
                                <li><a href="sign-in.html">Sign In</a></li>
                                <li><a href="sign-up.html">Sign Up</a></li>
                                <li><a href="forgot-password.html">Forgot Password</a></li>
                                <li><a href="404.html">Page 404</a></li>
                                <li><a href="403.html">Page 403</a></li>
                                <li><a href="500.html">Page 500</a></li>
                                <li><a href="503.html">Page 503</a></li>
                                <li><a href="page-offline.html">Page Offline</a></li>
                                <li><a href="locked.html">Locked Screen</a></li>
                            </ul>
                        </li>
                        <li> <a href="javascript:void(0);" class="menu-toggle"><i class="icon-folder-alt"></i><span>Pages</span></a>
                            <ul class="ml-menu">
                                <li><a href="blank.html">Blank Page</a></li>
                                <li><a href="teams-board.html">Teams Board</a></li>
                                <li><a href="projects.html">Projects List</a></li>
                                <li><a href="image-gallery.html">Image Gallery</a></li>
                                <li><a href="profile.html">Profile</a></li>
                                <li><a href="timeline.html">Timeline</a></li>
                                <li><a href="horizontal-timeline.html">Horizontal Timeline</a></li>
                                <li><a href="pricing.html">Pricing</a></li>
                                <li><a href="invoices.html">Invoices</a></li>
                                <li><a href="faqs.html">FAQs</a></li>
                                <li><a href="search-results.html">Search Results</a></li>
                                <li><a href="helper-class.html">Helper Classes</a></li>
                            </ul>
                        </li>
                        <li> <a href="javascript:void(0);" class="menu-toggle"><i class="icon-map"></i><span>Maps</span></a>
                            <ul class="ml-menu">
                                <li><a href="map-google.html">Google Map</a></li>
                                <li><a href="map-yandex.html">YandexMap</a></li>
                                <li><a href="map-jvectormap.html">jVectorMap</a></li>
                            </ul>
                        </li> --}}
                        @endguest               
                    </ul>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Right Sidebar -->
<aside id="rightsidebar" class="right-sidebar">
    <div class="slim_scroll">
        <div class="card">
            <h6>Demo Skins</h6>
            <ul class="choose-skin list-unstyled">
                <li data-theme="purple">
                    <div class="purple"></div>
                </li>                   
                <li data-theme="blue">
                    <div class="blue"></div>
                </li>
                <li data-theme="cyan">
                    <div class="cyan"></div>
                </li>
                <li data-theme="green" class="active">
                    <div class="green"></div>
                </li>
                <li data-theme="orange">
                    <div class="orange"></div>
                </li>
                <li data-theme="blush">
                    <div class="blush"></div>
                </li>
            </ul>
        </div>
        <div class="card theme-light-dark">
            <h6>Left Menu</h6>
            <button class="btn btn-default btn-block btn-round btn-simple t-light">Light</button>
            <button class="btn btn-default btn-block btn-round t-dark">Dark</button>
        </div> 
    </div>
</aside>