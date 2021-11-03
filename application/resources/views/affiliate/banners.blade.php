@extends('layouts.app')

@section('content')

    <div class="row clearfix">
        @include('partials.sidebar')
		
		<div class="col-md-9 " >
			<div class="card">
				<div class="header">
					<h2>AFFILIATE PROGRAM ADVERTISING CODE</h2>
				</div>
				<div class="body">
					<p class="text-center">Your affiliate link is:</p>
					<p class="text-center"><a href="{{Auth::user()->getReferralLinkAttribute()}}" target="_blank">{{Auth::user()->getReferralLinkAttribute()}}</a></p>
					<h5 class="text-center">COPY & PASTE AFFILIATE CODE:</h5>
					<div class="row">
						<div class="offset-md-2 col-md-8">
							<p class="mb-3 p-3 bg-secondary text-white word-break banner-text">
								<button class="btn btn-sm btn-success btn-copy" data-toggle="tooltip" data-placement="top" title="Copy to clipboard">Copy</button>
								<span class="text-to-copy">&lt;a href="{{Auth::user()->getReferralLinkAttribute()}}"&gt;&lt;img src="{{asset('storage/imgs/banners/1.jpg')}}" width="490" height="80" border="0"&gt;&lt;/a&gt;</span>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 pull-center">
							<a href="{{Auth::user()->getReferralLinkAttribute()}}">
		                      <img src="{{asset('storage/imgs/banners/1.jpg')}}" class="rounded mx-auto d-block" border="0">
		                    </a>
	                    </div>
					</div>

					<hr>
					<div class="row">
						<div class="offset-md-2 col-md-8">
							<p class="mb-3 p-3 bg-secondary text-white word-break banner-text">
								<button class="btn btn-sm btn-success btn-copy" data-toggle="tooltip" data-placement="top" title="Copy to clipboard">Copy</button>
								<span class="text-to-copy">&lt;a href="{{Auth::user()->getReferralLinkAttribute()}}"&gt;&lt;img src="{{asset('storage/imgs/banners/dollar-02.jpg')}}" width="250" height="250" border=0&gt;&lt;/a&gt;</span>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 pull-center">
							<a href="{{Auth::user()->getReferralLinkAttribute()}}">
		                      <img src="{{asset('storage/imgs/banners/dollar-02.jpg')}}" class="rounded mx-auto d-block" border="0">
		                    </a>
	                    </div>
					</div>
										
					<hr>
					<div class="row">
						<div class="offset-md-2 col-md-8">
							<p class="mb-3 p-3 bg-secondary text-white word-break banner-text">
								<button class="btn btn-sm btn-success btn-copy" data-toggle="tooltip" data-placement="top" title="Copy to clipboard">Copy</button>
								<span class="text-to-copy">&lt;a href="{{Auth::user()->getReferralLinkAttribute()}}"&gt;&lt;img src="{{asset('storage/imgs/banners/dollar-03.jpg')}}" width="250" height="250" border=0&gt;&lt;/a&gt;</span>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 pull-center">
							<a href="{{Auth::user()->getReferralLinkAttribute()}}">
		                      <img src="{{asset('storage/imgs/banners/dollar-03.jpg')}}" class="rounded mx-auto d-block" border="0">
		                    </a>
	                    </div>
					</div>
										
					<hr>
					<div class="row">
						<div class="offset-md-2 col-md-8">
							<p class="mb-3 p-3 bg-secondary text-white word-break banner-text">
								<button class="btn btn-sm btn-success btn-copy" data-toggle="tooltip" data-placement="top" title="Copy to clipboard">Copy</button>
								<span class="text-to-copy">&lt;a href="{{Auth::user()->getReferralLinkAttribute()}}"&gt;&lt;img src="{{asset('storage/imgs/banners/dollar-04.jpg')}}" width="125" height="125" border=0&gt;&lt;/a&gt;</span>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 pull-center">
							<a href="{{Auth::user()->getReferralLinkAttribute()}}">
		                      <img src="{{asset('storage/imgs/banners/dollar-04.jpg')}}" class="rounded mx-auto d-block" border="0">
		                    </a>
	                    </div>
					</div>
										
					<hr>
					<div class="row">
						<div class="offset-md-2 col-md-8">
							<p class="mb-3 p-3 bg-secondary text-white word-break banner-text">
								<button class="btn btn-sm btn-success btn-copy" data-toggle="tooltip" data-placement="top" title="Copy to clipboard">Copy</button>
								<span class="text-to-copy">&lt;a href="{{Auth::user()->getReferralLinkAttribute()}}"&gt;&lt;img src="{{asset('storage/imgs/banners/dollar-05.jpg')}}" width="125" height="175" border=0&gt;&lt;/a&gt;</span>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 pull-center">
							<a href="{{Auth::user()->getReferralLinkAttribute()}}">
		                      <img src="{{asset('storage/imgs/banners/dollar-05.jpg')}}" class="rounded mx-auto d-block" border="0">
		                    </a>
	                    </div>
					</div>
										
					<hr>
					<div class="row">
						<div class="offset-md-2 col-md-8">
							<p class="mb-3 p-3 bg-secondary text-white word-break banner-text">
								<button class="btn btn-sm btn-success btn-copy" data-toggle="tooltip" data-placement="top" title="Copy to clipboard">Copy</button>
								<span class="text-to-copy">&lt;a href="{{Auth::user()->getReferralLinkAttribute()}}"&gt;&lt;img src="{{asset('storage/imgs/banners/dollar-06.jpg')}}" width="768" height="60" border=0&gt;&lt;/a&gt;</span>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 pull-center">
							<a href="{{Auth::user()->getReferralLinkAttribute()}}">
		                      <img src="{{asset('storage/imgs/banners/dollar-06.jpg')}}" class="rounded mx-auto d-block" border="0">
		                    </a>
	                    </div>
					</div>
										
					<hr>
					<div class="row">
						<div class="offset-md-2 col-md-8">
							<p class="mb-3 p-3 bg-secondary text-white word-break banner-text">
								<button class="btn btn-sm btn-success btn-copy" data-toggle="tooltip" data-placement="top" title="Copy to clipboard">Copy</button>
								<span class="text-to-copy">&lt;a href="{{Auth::user()->getReferralLinkAttribute()}}"&gt;&lt;img src="{{asset('storage/imgs/banners/dollar-13.jpg')}}" width="125" height="175" border=0&gt;&lt;/a&gt;</span>
							</p>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 pull-center">
							<a href="{{Auth::user()->getReferralLinkAttribute()}}">
		                      <img src="{{asset('storage/imgs/banners/dollar-13.jpg')}}" class="rounded mx-auto d-block" border="0">
		                    </a>
	                    </div>
					</div>

					<hr>
					<div class="row">
						<div class="offset-md-2 col-md-8">
							<p class="mb-3 p-3 bg-secondary text-white word-break banner-text">
								<button class="btn btn-sm btn-success btn-copy" data-toggle="tooltip" data-placement="top" title="Copy to clipboard">Copy</button>
								<span class="text-to-copy">&lt;a href="{{Auth::user()->getReferralLinkAttribute()}}"&gt;&lt;img src="{{asset('storage/imgs/banners/dollar-09.jpg')}}" width="768" height="90" border=0&gt;&lt;/a&gt;</span>
							</p>
						</div>
					</div>
					<div class="row mb-5">
						<div class="col-md-12 pull-center">
							<a href="{{Auth::user()->getReferralLinkAttribute()}}">
		                      <img src="{{asset('storage/imgs/banners/dollar-09.jpg')}}" class="rounded mx-auto d-block" border="0">
		                    </a>
	                    </div>
					</div>

					<hr>
					<div class="row">
						<div class="col-md-12 pull-center">
							<video class="mx-auto d-block" preload="metadata" width="512" height="288" id="intro-video1" controls playsinline>
		                      	<source src="{{url('landing/The_Great_Reset3.mp4')}}" type="video/mp4">
		                        Your browser does not support the video tag.
		                    </video>
						</div>
					</div>

<!-- 					<div class="row">
						<div class="col-md-12 pull-center">
							<div class="mx-auto d-block" style="width: 512px; height: 288px;">
								<iframe width="512" height="288" src="https://youtu.be/0KkqUDk2a5I">
								</iframe>
							</div>
						</div>
					</div> -->

					
				</div>
			</div>
    	</div>
    </div>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('[data-toggle="tooltip"]').tooltip();
		$('.btn-copy').hide();

		$('.banner-text').hover(function(){
			$(this).children('.btn-copy').show();
		})

		$('.banner-text').mouseleave(function(){
			$(this).children('.btn-copy').hide();
		})

		$('.btn-copy').click(function(){			
			copyToClipboard($(this).parent('.banner-text').children('.text-to-copy'));
			// $(this).hide();
		}) 
	});

	function copyToClipboard(element) {
	  var $temp = $("<input>");
	  $("body").append($temp);
	  $temp.val(element.text()).select();
	  document.execCommand("copy");
	  $temp.remove();
	}
</script>
@endsection

@section('footer')
	@include('partials.footer')
@endsection
