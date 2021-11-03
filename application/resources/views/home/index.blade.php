@extends('layouts.app')

@section('content')

    <div class="row clearfix">
        @include('partials.sidebar')
		
		<div class="col-md-9 " >
			<div class="card">
				<div class="header">
					<h2>Your referral link</h2>
				</div>
				<div class="body">
					<div class="row mt-3">
						<label class="col-md-4">
							Home Page:
						</label>
						<a class="col-md-8" href="{{Auth::user()->getReferralLinkAttribute()}}" target="_blank">{{Auth::user()->getReferralLinkAttribute()}}</a>
						
					</div>
					<div class="row mt-3">
						<label class="col-md-4">
							Special Invitation:
						</label>
						<a href="{{Auth::user()->getReferralLinkAttributeSecondary()}}" target="_blank" class="col-md-8">{{Auth::user()->getReferralLinkAttributeSecondary()}}</a>
					</div>
					<div class="row mt-3">
						<label class="col-md-4">
							TEOTW
						</label>
						<a href="{{Auth::user()->getReferralLinkAttributeThird()}}" target="_blank" class="col-md-8">{{Auth::user()->getReferralLinkAttributeThird()}}</a>
					</div>
					<div class="row mt-3">
						<label class="col-md-4">
							Invitation to webinar
						</label>
						<a href="https://ldrep.nl/webinar/{{Auth::user()->name}}" target="_blank" class="col-md-8">https://ldrep.nl/webinar/{{Auth::user()->name}}</a>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="header">
					<h2>Your referrer</h2>
				</div>
				<div class="body">
					@if(count($referrer) > 0)
						<p>Username: {{$referrer[0]['name']}}</p>
						<p>Email: {{$referrer[0]['email']}}</p>
					@else
						NA
					@endif
				</div>
			</div>
        	@include('partials.flash')

        	@include('home.partials.requests')

	        @include('home.partials.transactions_to_confirm')
	        
	        @include('home.partials.transactions')

    	</div> 

    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection

@section('js')
<script type="text/javascript">
	$(document).ready(function() {
		$('.user-account table img').each(function() {
		    var image = new Image();
		    var url_image = $(this).attr('src');
		    image.src = url_image;

		    if (image.width == 0) {//if image does not exist
		        url_image = '{{Request::root()}}/storage/users/default.png';
		        $(this).attr('src', url_image)
		    }
		})

	})
</script>
@endsection