<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
  <head>
    <title>Liberty Dollar</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=PT+Sans+Caption:400,700%7CPT+Sans+Narrow:400,700">
    <link rel="stylesheet" href="{{asset('assets_modern/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('assets_modern/css/fonts.css')}}">
    <link rel="stylesheet" href="{{asset('assets_modern/css/style.css')}}">
    <style>
      .ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} 
      html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}
      .bg-image-1 {
        background-position: 0% 0%;
      }

      .marquee {
          margin: 0 auto;
          white-space: nowrap;
          overflow: hidden;
          position: absolute;
          width: 100%;
          font-size: x-large;
      }

      .marquee span {
        display: inline-block;
        padding-left: 100%;
        animation: marquee 20s linear infinite;
      }

      .marquee2 {
          margin-top: 0px!important;
      }
      .marquee2 span {
        animation-delay: 10s;
      }

      @keyframes  marquee {
        0% {
          transform: translate(0, 0);
        }
        100% {
          transform: translate(-100%, 0);
        }
      }
    
    </style>
  </head>
  <body>
    <div class="ie-panel">
        <a href="http://windows.microsoft.com/en-US/internet-explorer/">
            <img src="{{('assets_modern/images/ie8-panel/warning_bar_0000_us.jpg')}}" height="42" width="820" alt="You are using an outdated browser. For a faster, safer browsing experience, upgrade for free today.">
        </a>
    </div>
    <div class="preloader">
      <div class="preloader-body">
        <div class="cssload-container">
          <div class="cssload-speeding-wheel"></div>
        </div>
        <p>Loading...</p>
      </div>
    </div>
    <div class="page">
      <header class="section page-header">
        <!--RD Navbar-->
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-collapse-toggle rd-navbar-fixed-element-1" data-rd-navbar-toggle=".rd-navbar-collapse"><span></span></div>
            <div class="rd-navbar-aside-outer rd-navbar-collapse">
              <div class="rd-navbar-aside">
                {{--<a class="span icon icon-custom-1 fa-sign-in icon-lg-custom icon-white icon-circle" href="#"></a>--}}
                <span class="rd-navbar-phone">
                  <span class="icon icon-white fa-phone icon-lg-custom"></span>
                  <a class="link-white" href="tel:#">888-421-6181</a>
                </span>
                  <a class="btn btn-white link-white" href="#">
                    Log In</span>
                  </a>
                  <a class="btn btn-primary link-white" href="#">
                    <span>Register</span>
                  </a>
              </div>
            </div>
            <div class="rd-navbar-main-outer">
              <div class="rd-navbar-main">
                <div class="rd-navbar-main-wrapper d-flex align-items-center">
                  
                  <!--RD Navbar Panel-->
                  <div class="rd-navbar-panel">
                    <!--RD Navbar Toggle-->
                    <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                    <!--RD Navbar Brand-->
                    <div class="rd-navbar-brand">
                      <!--Brand--><a class="brand" href="{{url('/')}}"><img class="brand-logo-dark" src="{{('assets_modern/images/logo-default-30x33.png')}}" alt="" width="15" height="16"/><img class="brand-logo-light" src="{{('assets_modern/images/logo-default-30x33.png')}}" alt="" width="15" height="16"/></a>
                    </div>
                  </div>
                  
                  <div class="rd-navbar-main-element">
                    <div class="rd-navbar-nav-wrap">
                      <ul class="rd-navbar-nav">
                        <li class="rd-nav-item active">
                            <a class="rd-nav-link" href="#home">Home</a>
                        </li>
                        <li class="rd-nav-item">
                            <a class="rd-nav-link" href="#about">About</a>
                        </li>
                        <li class="rd-nav-item">
                            <a class="rd-nav-link" href="#testimonials">Testimonials</a>
                        </li>
                        <li class="rd-nav-item">
                            <a class="rd-nav-link" href="#solution">
                                Defeat Inflation
                            </a>
                        </li>
                        <li class="rd-nav-item">
                            <a class="rd-nav-link" href="#contacts">Contacts</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
                <div class="rd-navbar-info-inner">
                  {{--<a class="span icon icon-custom-1 fa-sign-in icon-lg-custom icon-white icon-circle" href="#"></a>--}}
                  
                  <span class="rd-navbar-phone">
                    <span class="icon icon-white fa-phone icon-lg-custom"></span>
                    <a class="link-white" href="tel:#">
                      <!-- +1<sup>959</sup>603 6035 --> 
                      888-421-6181
                    </a>
                  </span>
                  <a class="btn btn-white link-white" href="{{route('login')}}">
                    <span>Log In</span>
                  </a>
                  <a class="btn btn-primary link-white" href="{{route('register')}}">
                    <span>Register</span>
                  </a>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>
      <!--Main Section-->
      <section class="section section-md bg-image bg-image-1" id="home" >
        <div class="container">
          <div class="row text-center text-md-left">
            <div class="col-lg-7">
                <a class="brand" href="#">
                    <img class="img-responsive" src="{{asset('landing/img/logo-landing.png')}}" alt=""/>
                </a>
              <h3 class="mb-3">
                <b>Private Money For Private People</b>
              </h3>
              <h4 class="{{--text-gray-700--}}">
                You can live in the Private or the Public Sphere. If you choose the Public, you have chosen to live under public rules and laws. If you choose the Private, many of those rules are no longer applicable.
              </h4>
            </div>
          </div>
          <div class="row row-30 text-center">
            <div class="col-12 col-sm-6 text-sm-left">
              <a class="btn btn-primary link-white" href="{{route('register')}}">
                <span class="icon fa-comments-o icon-lg"></span>
                <span>Get Started</span>
              </a>
            </div>
            {{--<div class="col-12 col-sm-6 text-sm-right">
              <ul class="list-inline">
                <li><a class="icon icon-default fa-twitter icon-custom icon-lg icon-black" href="#"></a></li>
                <li><a class="icon icon-default fa-facebook icon-custom icon-lg icon-black" href="#"></a></li>
                <li><a class="icon icon-default fa-linkedin icon-custom icon-lg icon-black" href="#"></a></li>
                <li><a class="icon icon-default fa-google-plus icon-custom icon-lg icon-black" href="#"></a></li>
              </ul>
            </div>--}}
          </div>
        </div>
      </section>
      <hr>

      <div class="alert alert-link landing-ticker-container pb-4">
        <p class="marquee">
          <span> Liberty Dollar - The Original Stablecoin. CURRENT SPOT SILVER PRICE PER OUNCE- $24.43</span>
        </p>
        <p class="marquee marquee2">
          <span> Liberty Dollar - The Original Stablecoin. CURRENT SPOT SILVER PRICE PER OUNCE- $24.43</span>
        </p>
      </div>
      <hr>
      <!-- Saving Solutions-->
      <section class="section section-md-2 section-sm-bottom-80" id="solution">
        <div class="container">
          <h2>Liberty Dollar Solutions To Money Problems</h2>
          <p>The Liberty Dollar is the most stable solution to many of the financial problems we face today.</p>
          <div class="row row-50">
            <div class="col-lg-4 jumbotron-custom">
              <div class="unit unit-middle unit-spacing-xs unit-align-center unit-md-align-left unit-horizontal">
                <div class="unit-left">
                  <div class="icon-group"><span class="icon icon-xl icon-default fl-great-icon-set-credit95"></span><span class="icon icon-xl icon-info fl-great-icon-set-credit95"></span></div>
                </div>
                <div class="unit-body">
                  <h3 class="font-sec font-weight-regular text-uppercase offset-md-top--7">Liberty Dollars Are Private Money</h3>
                </div>
              </div>
              <div class="jumbotron-wrap">
                <div class="jumbotron-inner">
                  <p class="inset-xl-right-60">
                    LDFA is a Private Membership Association<br>
                    According to US Law per the Supreme Court, Members of a PMA may contract among themselves freely, without government regulation and interference. You can use Liberty Dollars as money in your private transactions.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-lg-4 jumbotron-custom">
              <div class="unit unit-middle unit-spacing-xs unit-align-center unit-md-align-left unit-horizontal">
                <div class="unit-left">
                  <div class="icon-group"><span class="icon icon-xl icon-default fl-great-icon-set-user156"></span><span class="icon icon-xl icon-info fl-great-icon-set-user156"></span></div>
                </div>
                <div class="unit-body">
                  <h3 class="font-sec font-weight-regular text-uppercase offset-md-top--7">Private Money For Private People</h3>
                </div>
              </div>
              <div class="jumbotron-wrap">
                <div class="jumbotron-inner">
                  <p class="inset-xl-right-60">
                    PMA Protects Its Members<br>
                    A PMA is not required to reveal any information about its Members. This does NOT mean, however, that being a Member absolves you of responsibility for taxes or other government regulations to which you may be subject.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-lg-4 jumbotron-custom">
              <div class="unit unit-middle unit-spacing-xs unit-align-center unit-md-align-left unit-horizontal">
                <div class="unit-left">
                  <div class="icon-group"><span class="icon icon-xl icon-default fl-great-icon-set-diamond37"></span><span class="icon icon-xl icon-info fl-great-icon-set-diamond37"></span></div>
                </div>
                <div class="unit-body">
                  <h3 class="font-sec font-weight-regular text-uppercase offset-md-top--7">Private Money Is The Future</h3>
                </div>
              </div>
              <div class="jumbotron-wrap">
                <div class="jumbotron-inner">
                  <p class="inset-xl-right-60">
                    Inflation Destroys Personal Wealth<br>
                    Liberty Dollars preserve your spending power and help your family to thrive no matter how badly the economy may suffer from the ravages of inflation and rampant government spending. Your money will grow and retain your spending power.
                  </p>
                </div>
              </div>
            </div>
          </div>

          <div class="row row-50">
            <div class="col-lg-4 jumbotron-custom">
              <div class="unit unit-middle unit-spacing-xs unit-align-center unit-md-align-left unit-horizontal">
                <div class="unit-left">
                  <div class="icon-group"><span class="icon icon-xl icon-default fl-great-icon-set-lightbulb52"></span><span class="icon icon-xl icon-info fl-great-icon-set-lightbulb52"></span></div>
                </div>
                <div class="unit-body">
                  <h3 class="font-sec font-weight-regular text-uppercase offset-md-top--7">Liberty Dollars Beat Inflation</h3>
                </div>
              </div>
              <div class="jumbotron-wrap">
                <div class="jumbotron-inner">
                  <p class="inset-xl-right-60">The Value-Holding Power of Silver Preserves Your Spending Power Inflation is coming, and it's unavoidable. Keeping your money in silver means keeping your spending power, as the price of silver rises along with all other commodities.</p>
                </div>
                {{--<a class="btn btn-default btn-lg" href="#">Learn More</a>--}}
              </div>
            </div>
            <div class="col-lg-4 jumbotron-custom">
              <div class="unit unit-horizontal unit-middle unit-spacing-sm unit-align-center unit-md-align-left">
                <div class="unit-left">
                  <div class="icon-group"><span class="icon icon-xl icon-default fl-great-icon-set-circular264"></span><span class="icon icon-xl icon-info fl-great-icon-set-circular264"></span></div>
                </div>
                <div class="unit-body">
                  <h3 class="font-sec font-weight-regular text-uppercase offset-md-top--7">Liberty Dollars Build Wealth</h3>
                </div>
              </div>
              <div class="jumbotron-wrap">
                <div class="jumbotron-inner">
                  <p class="inset-xl-right-60">The Rising Price Of Silver Means Your Value Is Secure Whether you are saving for retirement, for a major purchase or just for a rainy day, keeping your money in a Liberty Dollar Term Deposit Account means building more value for the future.</p>
                </div>{{--<a class="btn btn-default btn-lg" href="#">Learn More</a>--}}
              </div>
            </div>
            <div class="col-lg-4 jumbotron-custom">
              <div class="unit unit-horizontal unit-bottom unit-spacing-xs unit-spacing-sm unit-align-center unit-md-align-left">
                <div class="unit-left">
                  <div class="icon-group"><span class="icon icon-xl icon-default fl-great-icon-set-wallet32"></span><span class="icon icon-xl icon-info fl-great-icon-set-wallet32"></span></div>
                </div>
                <div class="unit-body">
                  <h3 class="font-sec font-weight-regular text-uppercase offset-md-top--7">Manage Your Liberty Dollars</h3>
                </div>
              </div>
              <div class="jumbotron-wrap">
                <div class="jumbotron-inner">
                  <p class="inset-xl-right-60">With Our Smartphone Apps and Secure Website. Pay your bills from your account, sell silver back to us at any time, or use the Point-Of-Sale functions to accept Liberty Dollars in your store, office, at home or anywhere else.</p>
                </div>
                {{--<a class="btn btn-default btn-lg" href="#">Learn More</a>--}}
              </div>
            </div>
          </div>

          <h2 class="mt-5">Use The Liberty Dollar</h2>
          <div class="row row-50">
            <div class="col-lg-4 jumbotron-custom">
              <div class="unit unit-middle unit-spacing-xs unit-align-center unit-md-align-left unit-horizontal">
                <div class="unit-left">
                  <div class="icon-group"><span class="icon icon-xl icon-default fa-bank"></span><span class="icon icon-xl icon-info fa-bank"></span></div>
                </div>
                <div class="unit-body">
                  <h3 class="font-sec font-weight-regular text-uppercase offset-md-top--7">For Your Savings</h3>
                </div>
              </div>
              <div class="jumbotron-wrap">
                <div class="jumbotron-inner">
                  <p class="inset-xl-right-60">
                    The Power Of Silver<br>
                    Silver preserves your spending power like nothing else can, and means your savings literally grow. Don't alow inflation to steal away your wealth in its invisible taxation.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-lg-4 jumbotron-custom">
              <div class="unit unit-middle unit-spacing-xs unit-align-center unit-md-align-left unit-horizontal">
                <div class="unit-left">
                  <div class="icon-group"><span class="icon icon-xl icon-default fa-paper-plane-o"></span><span class="icon icon-xl icon-info fa-paper-plane-o"></span></div>
                </div>
                <div class="unit-body">
                  <h3 class="font-sec font-weight-regular text-uppercase offset-md-top--7">For Your Peace Of Mind</h3>
                </div>
              </div>
              <div class="jumbotron-wrap">
                <div class="jumbotron-inner">
                  <p class="inset-xl-right-60">
                    Sound Money Means Sound Sleep<br>
                    You can rest easy, knowing that as a Member of LDFA, your money is as sound as it can ever be, safely secured in .999 fine silver bullion that will last.
                  </p>
                </div>
              </div>
            </div>

            <div class="col-lg-4 jumbotron-custom">
              <div class="unit unit-middle unit-spacing-xs unit-align-center unit-md-align-left unit-horizontal">
                <div class="unit-left">
                  <div class="icon-group"><span class="icon icon-xl icon-default fa-handshake-o"></span><span class="icon icon-xl icon-info fa-handshake-o"></span></div>
                </div>
                <div class="unit-body">
                  <h3 class="font-sec font-weight-regular text-uppercase offset-md-top--7">For Your Business</h3>
                </div>
              </div>
              <div class="jumbotron-wrap">
                <div class="jumbotron-inner">
                  <p class="inset-xl-right-60">
                    Private Money Means Private Business<br>
                    Using the Power of Silver in a Private Membership Association means working in a new market with new kinds of business built on Privacy and Honesty.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>

      {{--<section class="section section-md-2 section-sm-bottom-80">
        <div class="container">

        </div>
      </section>--}}
      <!-- About-->
      <section class="section section-md-3 context-dark bg-image bg-image-2" id="about">
        <div class="container">
          <div class="row row-40 flex-md-row-reverse justify-content-md-end">
            <div class="col-md-4 text-center align-self-md-center offset-md-1">
              <div class="image-wrap"><img class="img-responsive img-rounded" src="{{asset('assets_modern/images/waynebernard.gif')}}" alt="" width="346" height="404"/>
              </div>
            </div>
            <div class="col-md-7 col-lg-6 text-center text-md-left">
              <h1>About</h1>
              <h4>We Are The Liberty&reg;Dollar</h4>
              <p>
                The Liberty Dollar Financial Association (LDFA) is based on nearly fifty years of monetary research and the culmination of three years of designing, developing and testing a market-driven monetary model by Bernard von NotHaus and Wayne Hicks.
              </p>
              <a class="btn btn-primary btn-lg" href="{{url('page/3')}}">Read More</a>
            </div>
          </div>
        </div>
      </section>
      <!-- Testimonials-->
      <section class="section section-md-3 bg-gray-100" id="testimonials" data-type="anchor">
        <div class="container">
          <h1 class="text-center">Testimonials</h1>
          <div class="blockquote-wrapper bg-white">
            <div class="row row-20 row-md-0 text-sm-left">
              <div class="col-xl-4 quote-wrap">
                <blockquote class="quote">
                  <div class="unit unit-middle unit-xs-horizontal">
                    <div class="unit-left"><img class="img-responsive icon-circle" src="{{asset('storage/imgs/CharlesZ.jpg')}}" alt="" width="138" height="138"/>
                    </div>
                    <div class="unit-body text-left-custom">
                      <h4 class="font-weight-regular text-uppercase font-sec text-spacing-50 text-height-1">Charles<br>Z.</h4>
                      {{--<div class="quote-status">Managing Director</div>
                                                                  <h4 class="quote-title">
                                                                    <cite class="text-lg-wrap">Financial Times</cite>
                                                                  </h4>--}}
                    </div>
                  </div>
                  <div class="quote-caption">
                    <q>
                      I am glad that Liberty Dollar Financial Association (ldfa) has come along. I have been looking for some place where I can hold silver in an account or hold the real silver in my hand from the same source. I find this in LDFA. An extra benefit is the ability to convert the silver to other fiat currencies. I may never use this benefit but I have it if I need to. I am looking for like minded individuals to share this idea with.
                    </q>
                  </div>
                  <ul class="list-inline list-inline-lg">
                    <li><a class="icon icon-primary fa-twitter icon-xs" href="#"></a></li>
                    <li><a class="icon icon-primary fa-facebook icon-xs" href="#"></a></li>
                  </ul>
                </blockquote>
              </div>
              <div class="col-xl-4 quote-wrap offset-lg-top-0">
                <blockquote class="quote">
                  <div class="unit unit-middle unit-xs-horizontal">
                    <div class="unit-left"><img class="img-responsive icon-circle" src="{{asset('storage/imgs/RobertO.jpg')}}" alt="" width="138" height="138"/>
                    </div>
                    <div class="unit-body text-left-custom">
                      <h4 class="font-weight-regular text-uppercase font-sec text-spacing-50 text-height-1">Robert<br>O.</h4>
                      {{--<div class="quote-status">Director</div>
                                                                  <h4 class="quote-title">
                                                                    <cite>
                                                                      Risktec
                                                                      Solutions Ltd
                                                                    </cite>
                                                                  </h4>--}}
                    </div>
                  </div>
                  <div class="quote-caption">
                    <q>&nbsp;As an adolescent I was intrigued by the coin collections of my family and friends, so I started my own. Then I found the American Liberty Dollar and saw what happened to Bernard, but about three (3) years ago I started working on bringing back a metals backed currency. I reached out to Bernard von NotHaus for his blessing, and he connected me with Wayne & Kathy Hicks. I've been working with Bernard, Wayne & Kathy ever since.</span></q>
                  </div>
                  <ul class="list-inline list-inline-lg">
                    <li><a class="icon icon-primary fa-facebook icon-xs" href="#"></a></li>
                  </ul>
                </blockquote>
              </div>
              <div class="col-xl-4 quote-wrap offset-lg-top-0">
                <blockquote class="quote">
                  <div class="unit unit-middle unit-xs-horizontal">
                    <div class="unit-left"><img class="img-responsive icon-circle" src="{{asset('storage/imgs/meme.jpg')}}" alt="" width="138" height="138"/>
                    </div>
                    <div class="unit-body text-left-custom">
                      <h4 class="font-weight-regular text-uppercase font-sec text-spacing-50 text-height-1">Mark <br>M.</h4>
                      {{--<div class="quote-status">CEO</div>
                                                                  <h4 class="quote-title">
                                                                    <cite>BPW Global</cite>
                                                                  </h4>--}}
                    </div>
                  </div>
                  <div class="quote-caption">
                    <q>
                      Truly outstanding!<br>
                      That's the folks at LDFA and the Liberty Network. From the friendly, knowledgeable and professional support staff to all the financial features and benefits of being an LDFA member, you just can't find anything remotely comparable. They help me to protect, save and even make money with pure silver and that's got me excited for the future. The Liberty Network is not only a social platform for free speech but a hub for business, education, entertainment and so many other opportunities. I would say that you just have to check it out yourself.
                    </q>
                  </div>
                  <ul class="list-inline list-inline-lg">
                    <li><a class="icon icon-primary fa-facebook icon-xs" href="#"></a></li>
                  </ul>
                </blockquote>
              </div>
            </div>
          </div>
          {{--<a class="btn btn-default btn-lg" href="#">See All Testimonials</a>--}}
        </div>
      </section>
      <!-- Financial Planning-->
      <section class="section-md-2 bg-primary context-dark" id="financial-planning">
        <div class="container">
          <h1 class="text-center text-lg-left">The World Has Changed In Ways <br class="d-none d-xl-block">We Never Imagined</h1>
          <div class="row row-20 justify-content-center">
            <div class="col-sm-9 col-lg-6">
              <div class="embed-responsive embed-responsive-16by9 embed-responsive-custom">
                <video controls>
                    <source src="{{asset('assets_modern/The End of the World.mp4')}}" type="video/mp4">
                  Your browser does not support the video tag.
                </video>
                {{--<iframe class="embed-responsive-item" data-src="https://www.youtube.com/embed/8fYSrVrEaNU" allowfullscreen=""></iframe>--}}

              </div>
            </div>
            <div class="col-sm-8 col-lg-6 text-md-left text-center offset-top-30 offset-lg-top-10">
              <h4>The Coming Hyperinflation and Monetary Reset Will Destroy Your Spending Power</h4>
              <p class="text-height-large">
                The Liberty Dollar is  now, and has always been, the greatest means of preserving your personal wealth.
              </p>
              <p>Using the power of Silver to maintain parity with other commodities, you can protect your money from the coming economic disaster. As a Member of the Liberty Dollar Financial Association, you can use Sound Money while the rest of the world is foundering in a sea of insolvency and value-less currency.</p>
              <a class="btn btn-white btn-lg" href="{{route('register')}}">Open Your LDFA Account Today</a>
            </div>
          </div>
        </div>
      </section>
      <!-- Contacts-->
      <section class="section section-md-3" id="contacts" data-type="anchor">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-sm-10 col-lg-5 col-xl-6 text-center text-lg-left">
              <h1>Sign Up</h1>
              <h4 class="text-gray-700 offset-lg-top-90">Get subscriber only insights &amp; news<br class="d-none d-xl-block">delivered by LDFA</h4>
              <!-- RD Mailform-->
              <form class="rd-mailform rd-mailform-custom" data-form-output="form-output-global" data-form-type="contact" method="post" action="bat/rd-mailform.php">
                <div class="form-group">
                  <label class="form-label" for="contact-email">Enter your E-mail</label>
                  <input class="form-control" id="contact-email" type="email" name="email" data-constraints="@Required @Email">
                </div>
                <button class="btn btn-primary btn-lg" type="submit">Subscribe</button>
              </form>
            </div>
            <div class="col-lg-7 col-xl-6 offset-top-60 offset-lg-top-0">
              <h1 class="text-center text-lg-left">Contacts</h1>
              <address class="contact-info text-center text-lg-left">
                <dl>
                  <dt><span class="fa-envelope icon-default icon icon-lg"></span><span>E-mail:</span></dt>
                  <dd><a class="link-black" href="mailto:#">admin@ldfa.nl</a></dd>
                </dl>
                <dl>
                  <dt><span class="fa-phone icon-default icon icon-lg"></span><span>Telephone:</span></dt>
                  <dd><a class="link-black" href="tel:#">888-421-6181</a></dd>
                </dl>
                <dl>
                  <dt><span class="fa-map-marker icon-default icon icon-lg"></span><span>Address:</span></dt>
                  <dd><a class="link-black" href="#">520 Folly Road,<br>Ste 25, MB 284 <br> Charleston SC 29412</a></dd>
                </dl>
              </address>
            </div>
          </div>
        </div>
      </section>
      <!-- Page Footer-->
      <footer class="page-footer">
        <div class="container">
          <div class="row row-40">
            <div class="col-lg-4 text-center text-sm-left">
                <a class="footer-brand" href="{{url('/')}}">
                    <img class="img-responsive" src="{{('assets_modern/images/logo-default-30x33.png')}}" alt=""/>
                </a>
              <p class="copyright inset-xl-right-50">Copyright &copy;&nbsp;<span class="copyright-year"></span><span>&nbsp; | &nbsp;</span><a href="{{url('page/5')}}">Privacy Policy</a>
                <!-- {%FOOTER_LINK}-->
              </p>
              <p class="inset-xl-right-50">
                LDFA Services and Products are only available to Active Members of the Liberty Dollar Financial Association. 
              </p>
              <p class="inset-xl-right-50">As a Private Membership Association, LDFA contracts with its Members Only to provide them with Inflation-fighting services and Alternative Monetary Products.</p>
            </div>
            <div class="col-lg-8 text-center text-sm-left">
              <div class="row row-30">
                <div class="col-sm-4">
                  <h3 class="font-sec text-uppercase font-weight-regular">ABOUT</h3>
                  <ul class="list">
                    <li><a href="{{url('page/8')}}">FEES</a></li>
                    <li><a href="{{url('page/6')}}">FAQ</a></li>
                    <li><a href="{{url('page/4')}}">TERMS OF USE</a></li>
                    <li><a href="{{url('page/3')}}">ABOUT US</a></li>
                  </ul>
                </div>
                <div class="col-sm-4">
                  <h3 class="font-sec text-uppercase font-weight-regular">PRIVATE MONEY</h3>
                  <ul class="list">
                    <li><a href="#">Wealth Preservation</a></li>
                    <li><a href="#">Retirement Savings Plans</a></li>
                    <li><a href="#">Peer To Peer Lending</a></li>
                    <li><a href="#">Private Estate Planning</a></li>
                  </ul>
                </div>
                <div class="col-sm-4">
                  <h3 class="font-sec text-uppercase font-weight-regular">BENEFITS OF MEMBERSHIP</h3>
                  <ul class="list">
                    <li><a href="#">Wealth Management</a></li>
                    <li><a href="#">
                        Retirement &amp; College Savings
                        Business Owners</a></li>
                    <li><a href="#">Term Deposit Accounts</a></li>
                    <li><a href="#">Local Community Money</a></li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <div class="snackbars" id="form-output-global"></div>
    <script src="{{('assets_modern/js/core.min.js')}}"></script>
    <script src="{{('assets_modern/js/script.js')}}"></script>
  </body>
</html>