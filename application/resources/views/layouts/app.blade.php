<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('page') - {{ setting('site.site_name') }}</title>

    <!-- Styles -->
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="https://fonts.gstatic.com">
            <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">  --}}

    <!-- Styles -->
    {{-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> --}}
    
   {{--  <link rel="icon" href="favicon.ico" type="image/x-icon"> <!-- Favicon--> --}}

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-jvectormap-2.0.3.min.css')}}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/morris.min.css')}}" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="{{ asset('assets/css/main.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/color_skins.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-select.min.css')}}">
    

    <style type="text/css">
        @media print{@page {size: landscape}}

        .jqstooltip { position: absolute;left: 0px;top: 0px;visibility: hidden;background: rgb(0, 0, 0) transparent;background-color: rgba(0,0,0,0.6);filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000);-ms-filter: "progid:DXImageTransform.Microsoft.gradient(startColorstr=#99000000, endColorstr=#99000000)";color: white;font: 10px arial, san serif;text-align: left;white-space: nowrap;padding: 5px;border: 1px solid white;box-sizing: content-box;z-index: 10000;}
        .jqsfield { color: white;font: 10px arial, san serif;text-align: left;}
        .bitcoin .body {position: absolute;word-break: break-all;}
        .remove{cursor: pointer;}
        .top_navbar{border-bottom: none }
        .navbar-nav>li>a .label-count{position: unset;}
        .menu_dark .sidebar {box-shadow: none !important;}
        @impersonating
        .top_navbar{background:#fff;}
        section.content::before{background:#fff;}
        .menu_dark .sidebar {background: #fff;box-shadow: none !important;}
        .navbar-nav>li>a .label-count {background-color: #50d38a;color: #fff;}
        .navbar-logo .navbar-brand span {color: #50d38a;}
        @endImpersonating

        .notify-details {
            margin-bottom: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .pullDown {
            max-width: 280px;
        }

        .noti-icon-badge {
            display: inline-block;
            position: absolute;
            top: 22px;
            right: 6px;
            border-radius: 50%;
            height: 7px;
            width: 7px;
            background-color: #fa5c7c;
        }
    </style>
    @yield('styles')


    @include('partials.footerstyles')

    <script src="{{ asset('js/vue.min.js') }}"></script>
</head>
<body class="{{setting('site.color_theme')}} menu_dark" id="app">
<div class="page-loader-wrapper">
    <div class="loader">
        <div class="m-t-30"><img class="zmdi-hc-spin" src="{{asset('assets/images/logo.svg')}}" width="48" height="48" alt="sQuare"></div>
        <p>Please wait...</p>        
    </div>
</div>
<!-- Overlay For Sidebars -->
<div class="overlay"></div>
@include('layouts.topnavbar')
@include('layouts.aside')
<section class="content">
    <div class="container">
        <div class="row cleatfix">
            <div class="col-lg-12">
                 @yield('pre_content')
            </div>
        </div>

        @auth
        <div class="row clearfix">
            <div class="col-lg-12">
                <div class="card">
                    <div class="header">
                        <h2><strong>{{__('Active')}}</strong> {{__('Currency')}}</h2>
                        <ul class="header-dropdown">
                            <li class="remove">
                                <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                            </li>
                        </ul>
                    </div>
                    <div class="body block-header">
                        <div class="row">
                            <div class="col">
                                <h2>{{ Auth::user()->currentCurrency()->name }} </h2>
                                <ul class="breadcrumb p-l-0 p-b-0 ">
                                    <li class="breadcrumb-item"><a href="{{url('/')}}"><i class="icon-home"></i></a></li>
                                    <li class="breadcrumb-item ">
                                        <span class="text-primary">{{ Auth::user()->currentCurrency()->code }} ({{ Auth::user()->currentCurrency()->symbol }})</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="col">
                                @if(Auth::user()->isAdministrator())
                                <h2>{{__('Registered Members:')}}<span class="text-success ml-2 registered-users"></span></h2>
                                @endif
                                <h2>{{__('Silver Price')}}: {{setting('site.silver_price')}} {{Auth::user()->currentCurrency()->symbol}}/ounce</h2>
                            </div>

                            <div class="col text-right">
                               <a href="{{route('deposit.credit')}}" class="btn btn-primary btn-round  float-right  m-l-10">{{__('Make Deposit')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endauth

        @yield('content')
{{--        @auth
        <div class="row clearfix">
           @if(count(Auth::user()->wallets()))
                @foreach(Auth::user()->wallets() as $someWallet)
                <div class="col hidden-xs hidden-sm">
                    <div class="card info-box-2">
                        <div class="header" style="padding-bottom: 0">
                            <h2><strong>{{ $someWallet->currency->name }}</strong> {{ __('Balance')}}</h2>
                            <ul class="header-dropdown">
                                <li class="remove">
                                    <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                                </li>
                            </ul>
                        </div>
                        <div class="body" style="padding-top: 0">
                            <div class="content">
                                <div class="number">{{ \App\Helpers\Money::instance()->value($someWallet->amount, $someWallet->currency->symbol) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        @endauth--}}
    </div>
      <!-- Scripts -->
    @yield('footer')
</section>
    <!-- Jquery Core Js --> 
    <script src="{{ asset('assets/js/libscripts.bundle.js') }}"></script> <!-- Lib Scripts Plugin Js ( jquery.v3.2.1, Bootstrap4 js) --> 
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="{{ asset('assets/js/vendorscripts.bundle.js')}}"></script> <!-- slimscroll, waves Scripts Plugin Js -->
    <script src="{{ asset('assets/js/morrisscripts.bundle.js')}}"></script><!-- Morris Plugin Js -->
    <script src="{{ asset('assets/js/jvectormap.bundle.js')}}"></script> <!-- JVectorMap Plugin Js -->
    <script src="{{ asset('assets/js/knob.bundle.js')}}"></script> <!-- Jquery Knob-->
    <script src="{{ asset('assets/js/mainscripts.bundle.js')}}"></script>
    <script src="{{ asset('assets/js/infobox-1.js')}}"></script>
    <script src="{{ asset('assets/js/index.js')}}"></script>
    @yield('js')
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
    <script src="{{ asset('assets/js/form-validation.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            getNotifications();
            @auth
            @if(Auth::user()->isAdministrator())
            getUserCount();
            
            setInterval(function(){ getUserCount(); }, 5000);
            @endif
            @endauth

            function getUserCount()
            {
                $.get("{{url('api/count_users')}}", function(res, status){
                    if(res.success) {
                        $('.registered-users').text(res.data)
                    }
                });
            }

            function getNotifications()
            {
                $.get("{{route('notifications.getrecent')}}", function(res) {
                    if(res.length > 0) {
                        for (var i = res.length - 1; i >= 0; i--) {
                            console.log(res[i])
                            $('.notifications .dropdown-menu').append(
                                '<li>' +
                                    '<a href="/notifications/view/' + res[i].id + '">' +
                                        '<p class="notify-details mx-4">' +
                                            res[i].data.subject +
                                            '<small class="text-muted d-block">' +
                                                res[i].created_diff +
                                            '</small>' +
                                        '</p>' +
                                    '</a>' +
                                '</li>'
                                )
                        }
                        $('.notifications .dropdown-menu').append(
                            '<li>' +
                                '<a href="{{route('notifications')}}" class="text-center text-primary">' +
                                    'View All' +
                                '</a>' +
                            '</li>')
                        $('.notifications .noti-icon-badge').removeClass('d-none');

                    } else {
                        $('.notifications .dropdown-menu').append(
                            '<li>' +
                                '<p class="notify-details m-4">No new notifications!</p>' +
                            '</li>'
                            )
                    }

                })
            }

            $('select').on('change', function(e){
                console.log('changed')
                $(this).dropdown("toggle")
            })
        })
    </script>
</body>
</html>
