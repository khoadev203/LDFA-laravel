<!doctype html>
<html class="no-js" lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ setting('site.site_name') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{asset('landing/favicon.ico')}}" type="image/x-icon"> <!-- Favicon-->    
    <link rel="stylesheet" href="{{asset('landing/css/normalize.min.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/jquery.fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/flexslider.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/styles.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/queries.css')}}">
    <link rel="stylesheet" href="{{asset('landing/css/etline-font.css')}}">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/plyr@3.5.4/dist/plyr.css" />
    <script src="https://cdn.jsdelivr.net/npm/plyr@3.5.4/dist/plyr.min.js"></script>
     {{--<script src="/assets/js/plyr-plugin-thumbnail.js"></script>--}}

    <link rel="stylesheet" href="{{asset('landing/bower_components/animate.css/animate.min.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <!-- <script src="{{asset('landing/landing/js/vendor/modernizr-2.8.3-respond-1.4.2.min.js')}}"></script> -->
    <style>

        .intro-icon {
            display: block;
            vertical-align: middle;
            padding: 6px 0 0 0;
            width: 100%;
            text-align: center;
        }
        .intro-content {
            display: inline-block;
            width: 100%;
        }
        .fixed {
            background-color: white;
        }
        .btn-white:hover, .btn-white:focus {
            color: white;
            border-color: #fff;
            background: #fff;
        }
        a.login:hover{
            color: #373D4A !important;
        }
        .support-btn {
            position: fixed;
            background: #0295d8;
            bottom: 12px;
            right: 12px;
            font-size: 13px;
            font-weight: 600;
            z-index: 9;
            transition: 0.5s all;
        }
        .support-btn:hover{
            background: #fff;
            color: #0295d8;
        }
        .submit-btn input {
            border: 0;
            background-color:#0295d8;
            color: #fff;
            font-size: 15px;
            padding: 13px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.5s all;
        }
        .submit-btn input:focus{
            outline: 0;
        }
        button.close {
            position: absolute;
            right: 10px;
            top: 10px;
            background-color: #0295d8;
            opacity: 1;
            font-weight: normal;
            color: #fff;
            font-size: 26px;
            height: 40px;
            display: inline-flex;
            width: 40px;
            align-items: center;
            justify-content: center;
            border-radius: 50px;
            z-index: 9;
            transition: 0.5s;
        }
        .modal-header {
            min-height: 0;
            padding: 0;
            border-bottom: 0;
        }
        .modal-body {
            position: relative;
            padding: 65px 30px 20px;
        }
        .intro-video-container {
            width: 512px;
            margin-top: 100px;
            margin-bottom: 30px;
            display: inline-block;
        }

        .plyr--video {
            border-radius: 15px;
        }

        #topo-content {
            padding-top: 13%!important;
        }

        .btn.btn-info:hover {
            border-color: black;
        }

        .hero-content {
            padding-right: 478px;
        }

        .hero-content .btn {
            float: right;
        }

        @media(max-width:1200px) {
            header ul.primary-nav {
                margin: 0 0 0 5px;
            }
            header {
                width: 92%;
                margin: 0 auto;
            }
            .btn-small {
                padding: 8px 20px;
            }
        }

        @media(max-width: 1440px) {
            .landing-ticker-container {
                margin-bottom: 0;
                position: relative;
                bottom: 130px;
            }
            .hero {
                min-height: 725px;
            }
            .hero-strip {
                margin-top: -130px;
            }
            .hero-content {
                padding-right: 320px;
            }
            .intro {
                position: relative;
                top: -130px;
            }
        }

        @media(max-width: 991px) {
            .hero .hero-content {
                padding-top: 41%;
                padding-left: 10px;
                padding-right: 100px;
            }
            .hero h2 {
                font-size: 17px;
            }
            .hero h1 {
                font-size: 35px;
            }
        }


        body.modal-open {
            padding-right: 0px!important;
        }


    </style>
</head>
<body id="top" >
    <section class="hero">
        <img src="{{asset('landing/img/logo-small.png')}}" class="hero-logo">
        <section class="navigation">
            <header>
                <div class="header-content">
                    <div class="logo"><a href="{{url('/')}}"><img src="{{setting('site.welcome_page_logo_url')}}" alt="infinio logo"></a></div>
                    <div class="header-nav">
                        <nav>
                            <ul class="primary-nav">
                                <li><a href="{{url('/')}}">HOME</a></li>
                                <li><a href="{{url('page/8')}}">FEES</a></li>
                                <li><a href="{{url('page/6')}}">FAQ</a></li>
                                <li><a href="{{url('page/5')}}">Privacy Policy</a></li>
                                <li><a href="{{url('page/4')}}">Terms Of Use</a></li>
                                <li><a href="{{url('page/3')}}">About Us</a></li>
                            </ul>
                            
                             @if (Route::has('login'))
                            <ul class="member-actions">
                                    @if (Auth::check())
                                        <li>
                                            <a href="{{ route('logout') }}" class="btn-white btn-small" onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">{{ __('Logout') }} 
                                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
                                            </a>
                                        </li>
                                        @if(Auth::user()->isAdministrator())
                                             <li><a href="{{ url('/admin') }} " class="btn-white btn-small">{{('Admin')}}</a></li>
                                        @endif
                                        <li><a href="{{ url('/home') }} " class="btn-white btn-small">{{('My')}} {{ setting('site.site_name') }}</a></li>

                                    @else
                                        <li><a href="{{ url('/register') }}" class="btn-white btn-small">{{__('Register')}}</a></li>
                                        <li><a href="{{ url('/login') }}" class="btn-white btn-small">{{__('Log in')}}</a></li>
                                    @endif
                            </ul>
                            @endif
                        </nav>
                    </div>
                    <div class="navicon">
                        <a class="nav-toggle" href="#"><span></span></a>
                    </div>
                </div>
            </header>
        </section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-9 col-md-offset-1">
                    <div class="hero-content text-left">
                        <h1><b>{{setting('site.site_name')}} <br> Financial Association</b></h1>

                        
                        <h2 style="line-height: 110%;font-style: italic; font-weight: bold; width: fit-content;">
                            "Security without Liberty is called prison."<br>
                            <span style="float: right;">--Benjamin Franklin</span><br>
                            "Money without value is called theft."<br>
                            <span style="float: right;">--Bernard von NotHaus</span><br>
                            Protect your purchasing power with the Liberty Dollar.
                        </h2>

                        </br>
                            @if (Auth::check())
                               <center> <a href="{{url('/')}}/home" class="btn btn-fill btn-large">dashboard</a>
                            @else
                               <a href="{{url('/')}}/register" class="btn btn-outline-black btn-large">Get Started</a></center>
                            @endif
                        
                        <!-- <a href="../html/dark/index.html" target="_blank" class="btn btn-accent btn-large btn-margin-right">Dark Version</a>
                        <a href="../html/left-menu/index.html" target="_blank" class="btn btn-accent btn-large">Left Sidebar</a>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="down-arrow floating-arrow"><a href="#"><i class="fa fa-angle-down"></i></a></div>
    </section>

    <div class="alert alert-info landing-ticker-container"style="margin-bottom: 0;">
        <marquee width="100%" direction="left" class="landing-ticker" >
            {{__(' Liberty Dollar - The Original Stablecoin.')}} CURRENT SPOT SILVER PRICE PER OUNCE- ${{setting('site.silver_price')}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{__('Liberty Dollar - The Original Stablecoin.')}} CURRENT SPOT SILVER PRICE PER OUNCE- ${{setting('site.silver_price')}} 
        </marquee>
    </div>

    <section class="intro">
        <div class="container">
            <div class="row">
                <div class="intro-video-container" style="float: left;">
                    <video preload="metadata" width="512" height="288" id="intro-video1" controls playsinline>
                      <source src="landing/bernardintro1.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>

                <div class="intro-video-container" style="float:right;">
                    <video width="512" height="288" id="intro-video2" controls playsinline  data-poster="landing/img/waynehicks.jpg">
                      <source src="landing/WayneIntro.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            
                                    {{--<div class="row" style="margin-bottom: 50px">
                                        <div class="col-lg-8">
                                            <h2 style="margin-top: 100px; margin-bottom: 80px;">Accept LDFA Silver Online Immediately<br> with our Merchant Tools!</h2>
                                            <div class="row">
                                                <div class="col-md-6 intro-feature">
                                                    <div class="intro-icon">
                                                        <span data-icon="&#xe046;" class="icon"></span>
                                                    </div>
                                                    <div class="intro-content last">
                                                        <h5 class="text-center">Start Accepting LDFA Silver Payments Instantly</h5>
                                                        <p>You can register for an account and start accepting LDFA Silver in just minutes!</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 intro-feature">
                                                    <div class="intro-icon">
                                                        <span data-icon="&#xe037;" class="icon"></span>
                                                    </div>
                                                    <div class="intro-content">
                                                        <h5 class="text-center">Instant Payment Notifications</h5>
                                                        <p>You are notified instantly via e-mail when someone sends LDFA Silver to your account.</p>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 intro-feature">
                                                    <div class="intro-icon">
                                                        <span data-icon="&#xe048;" class="icon"></span>
                                                    </div>
                                                    <div class="intro-content last">
                                                        <h5 class="text-center">Sell Online</h5>
                                                        <p>You can accept LDFA Silver via email on your website and many other ways. We are here to help you get paid in Silver and make real money while you protect your wealth and spending power!</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 intro-feature">
                                                    <div class="intro-icon">
                                                        <span data-icon="&#xe032;" class="icon"></span>
                                                    </div>
                                                    <div class="intro-content">
                                                        <h5 class="text-center">Mobile Ready!</h5>
                                                        <p>Conduct all your LDFA business on your Android or iOS devices, as well as on a computer with our Moobile Ready site.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <img src="landing/img/use_app.png" class="img-responsive" style="margin-top: 120px;"><br>
                                            <img src="landing/img/refer_friends.png" class="img-responsive">
                                        </div>
                                    </div>
                                <div class="row">
                                        <div class="col-md-4 intro-feature">
                                            <div class="intro-icon">
                                                <span data-icon="&#xe033;" class="icon"></span>
                                            </div>
                                            <div class="intro-content">
                                                <h5 class="text-center">Free Account Registration</h5>
                                                <p>LDFA Silver is Genuine Sound Money backed by .999 Fine Silver! Digital Warehouse Receipts are legally negotiable anywhere in the world.</p>
                                                
                                            </div>
                                        </div>                
                                        <div class="col-md-4 intro-feature">
                                            <div class="intro-icon">
                                                <span data-icon="&#xe046;" class="icon"></span>
                                            </div>
                                            <div class="intro-content last">
                                                <h5 class="text-center">Start Accepting LDFA Silver Payments Instantly</h5>
                                                <p>You can register for an account and start accepting LDFA Silver in just minutes!</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 intro-feature">
                                            <div class="intro-icon">
                                                <span data-icon="&#xe030;" class="icon"></span>
                                            </div>
                                            <div class="intro-content">
                                                <h5 class="text-center">Send and Receive LDFA Silver</h5>
                                                <p>You can send and receive LDFA Silver by email, a great way to pay and get paid in SILVER!</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4 intro-feature">
                                            <div class="intro-icon">
                                                <span data-icon="&#xe037;" class="icon"></span>
                                            </div>
                                            <div class="intro-content">
                                                <h5 class="text-center">Instant Payment Notifications</h5>
                                                <p>You are notified instantly via e-mail when someone sends LDFA Silver to your account.</p>
                                                
                                            </div>
                                        </div>                
                                        <div class="col-md-4 intro-feature">
                                            <div class="intro-icon">
                                                <span data-icon="&#xe047;" class="icon"></span>
                                            </div>
                                            <div class="intro-content last">
                                                <h5 class="text-center">Earn With Our Free Referral Program</h5>
                                                <p>Open an account today and be automatically enrolled in our free affiliate program that pays you in LDF Silver, three levels deep, for referring new Members.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 intro-feature">
                                            <div class="intro-icon">
                                                <span data-icon="&#xe031;" class="icon"></span>
                                            </div>
                                            <div class="intro-content">
                                                <h5 class="text-center">Variety of Loading Options</h5>
                                                <p>You can purchase Silver to secure your LDFA Digital Warehouse Receipts Account with PayPal, credit/debit card, bank wire, ACH, Direct Deposit or check through the U.S. Mail, or CONTACT US about other options.</p>
                                            </div>
                                        </div>
                                    </div>
                        
                                    <div class="row">
                                        <div class="col-md-4 intro-feature">
                                            <div class="intro-icon">
                                                <span data-icon="&#xe035;" class="icon"></span>
                                            </div>
                                            <div class="intro-content">
                                                <h5 class="text-center">Redemption Options</h5>
                                                <p>You can redeem your Silver at any time, withdraw paper Warehouse Receipts to use locally, or sell it back at the current SPOT Price instantly, with cash sent to your bank account or Debit Card in minutes.</P>
                                                
                                            </div>
                                        </div>                
                                        <div class="col-md-4 intro-feature">
                                            <div class="intro-icon">
                                                <span data-icon="&#xe048;" class="icon"></span>
                                            </div>
                                            <div class="intro-content last">
                                                <h5 class="text-center">Sell Online</h5>
                                                <p>You can accept LDFA Silver via email on your website and many other ways. We are here to help you get paid in Silver and make real money while you protect your wealth and spending power!</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 intro-feature">
                                            <div class="intro-icon">
                                                <span data-icon="&#xe032;" class="icon"></span>
                                            </div>
                                            <div class="intro-content">
                                                <h5 class="text-center">Mobile Ready!</h5>
                                                <p>Conduct all your LDFA business on your Android or iOS devices, as well as on a computer with our Moobile Ready site.</p>
                                            </div>
                                        </div>
                                    </div>--}}
        </div>

        <!-- Modal -->
        <div class="modal fade customer_support" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              </div>
              <div class="modal-body">
                 <form action="{{route('support_email')}}" method="post">
                {{csrf_field()}}
                     <div class="form-group">
                         <label for="fname">Enter Your Name :</label><br>
                         <input type="text" class="form-control" id="name" name="name" value="John">
                     </div>
                     <div class="form-group">
                         <label for="email">Enter Your Email :</label><br>
                         <input type="email" class="form-control" id="email" name="email" value="John@gmail.com">
                     </div>
                     <div class="form-group">
                         <label for="message">Type Your Message Here :</label><br>
                         <textarea id="message" class="form-control" value="Message" name="message"></textarea>
                     </div>

                        <div class="form-group" style="display:none;">
                         <label for="faxonly">Fax Only
                          <input type="checkbox" name="faxonly" id="faxonly" />
                         </label>
                        </div>

                     <div class="form-group submit-btn">
                         <input type="submit" value="Submit">
                     </div>
                 </form>
              </div>
            </div>
          </div>
        </div>
        <div id="refNoteModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
        <!--       <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Terms & Agreement</h4>
              </div> -->
              <div class="modal-body">
                <p class="text-center">{{$referral_note}}</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">Close</button>
              </div>
            </div>

          </div>
        </div>
    </section>

    {{--
    <section class="features section-padding" id="features">
        <div class="container">
            <div class="row">
                <div class="col-md-5 col-md-offset-7">
                    <div class="feature-list">
                        <h3>{{setting('site.site_name')}} Financial Association will drive your product forward</h3>
                        <p>Present your product, start up, or portfolio in a beautifully modern way. Turn your visitors in to clients.</p>
                        <ul class="features-stack">
                            <li class="feature-item">
                                <div class="feature-icon">
                                    <span data-icon="&#xe03e;" class="icon"></span>
                                </div>
                                <div class="feature-content">
                                    <h5>Responsive Design</h5>
                                    <p>{{setting('site.site_name')}} Financial Association is global and will look great on any device.</p>
                                </div>
                            </li>
                            <li class="feature-item">
                                <div class="feature-icon">
                                    <span data-icon="&#xe040;" class="icon"></span>
                                </div>
                                <div class="feature-content">
                                    <h5>User Design</h5>
                                    <p>{{setting('site.site_name')}} Financial Association takes advantage of common design patterns, allowing for a seamless experience for users of all levels.</p>
                                </div>
                            </li>
                            <li class="feature-item">
                                <div class="feature-icon">
                                    <span data-icon="&#xe03c;" class="icon"></span>
                                </div>
                                <div class="feature-content">
                                    <h5>Clean and Re-Usable code</h5>
                                    <p>Download and re-use the {{setting('site.site_name')}} open source code for any other project you like.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="device-showcase">
            <div class="devices">
                <div class="ipad-wrap wp1"></div>
                <div class="iphone-wrap wp2"></div>
            </div>
        </div>
        <div class="responsive-feature-img"><img src="{{asset('landing/img/devices.png')}}" alt="responsive devices"></div>
    </section>
    <section class="features-extra section-padding" id="assets">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="feature-list">
                        <h3>Main Features</h3>
                        <p>The best script for building the modern web fintech application.</p>
                        <ul class="main_features">
                            <li>--  Bootstrap 4 Stable</li>
                            <li>--  E-commerce</li>
                            <li>--  Unlimited ( Withdrawal / Deposit ) Methods</li>
                            <li>--  ( Send / Receive ) Money</li>
                            <li>--  ( Create / Load ) Vouchers</li>
                            <li>--  6 Color Skins</li>
                            <li>--  Currency Exchange</li>
                            <li>--  Unlimited Currencies</li>
                            <li>--  Earn by transaction fees</li>
                            <li>--  Crossbrowser</li>
                            <li>--  User Roles</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="macbook-wrap wp3"></div>
        <div class="responsive-feature-img"><img src="{{asset('landing/img/macbook-pro.png')}}" alt="responsive devices"></div>
    </section>
    --}}

    <section class="hero-strip section-padding">
        <div class="container">
            <div class="col-md-12 text-center">
                <h2>Get Your Account with <br>Liberty Dollar Financial Association Today!</h2>
                <a href="{{url('/')}}/register" class="btn btn-ghost btn-accent btn-large">GET STARTED NOW!</a>                
            </div>
        </div>
    </section>
    <section class="to-top">
        <div class="container">
            <div class="row">
                <div class="to-top-wrap">
                    <a href="#top" class="top"><i class="fa fa-angle-up"></i></a>
                </div>
            </div>
        </div>
    </section>
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <div class="footer-links">
                        <ul class="footer-group">
                            <li><a href="{{url('page/6')}}">FAQ</a></li>
                            <li><a href="{{url('page/9')}}">Cancellation/Refund Policy</a></li>
                            <li><a href="{{url('page/4')}}">Terms Of Use</a></li>
                            <li><a href="{{url('page/3')}}">About Us</a></li>
                        </ul>
                        <p>Copyright © 2021 <a href="#">{{setting('site.site_name')}} Financial Association</a></p>
                    </div>
                </div>
                <div class="social-share">
                    <p>Share {{setting('site.site_name')}} Financial Association with your friends</p>
                    <a href="https://libertynet.nl" style="display: inline-block;text-align: center;margin-right: 20px;border-radius: 3px;font-size: 22px;">
                        <img src="{{asset('landing/img/libertynet_app_icon.png')}}" style="height: 60px;border-radius: 3px;margin-top: -5px;">
                    </a>
                    <a href="#" class="twitter-share"><i class="fa fa-twitter"></i></a>
                    <a href="#" class="facebook-share"><i class="fa fa-facebook"></i></a>
                </div>
            </div>
        </div>
    </footer>

    

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="{{asset('landing/js/vendor/jquery-1.11.2.min.js')}}"><\/script>')</script>    
    <script src="{{asset('landing/js/jquery.fancybox.pack.js')}}"></script>
    <script src="{{asset('landing/js/vendor/bootstrap.min.js')}}"></script>
    <script src="{{asset('landing/js/scripts.js')}}"></script>
    <script src="{{asset('landing/js/jquery.flexslider-min.js')}}"></script>
    <script src="{{asset('landing/bower_components/classie/classie.js')}}"></script>
    <script src="{{asset('landing/bower_components/jquery-waypoints/lib/jquery.waypoints.min.js')}}"></script>


    <script>
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/59f5afbbbb0c3f433d4c5c4c/default';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
        })();
    </script>
    <script>
        document.addEventListener('ready', event => {
            const player = new Plyr('#intro-video1');
            const player2 = new Plyr('#intro-video2')
        });
      
    $(document).ready(function() {

        var showPopup = function(){
          $('#refNoteModal').modal('show');
        }

        @if($referral_note != '')

        setTimeout(showPopup, 2000);

        @endif
    })
    </script>
   <!-- Button trigger modal -->
<button type="button" id="mymodal" class="btn btn-primary btn-lg support-btn" data-toggle="modal" data-target="#myModal">
  support
</button>

</body>
</html>

