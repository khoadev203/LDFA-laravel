@extends('layouts.app')

@section('content')

  <div class="row clearfix">
    @include('partials.sidebar')

		<div class="col-md-9 ">

  		@include('flash')

			<div class="card">
				<div class="header">
					<h2><strong>Current Status</strong></h2>
				</div>
				<div class="body">
					@if(is_null($tdaccount_user))
					<div class="row">
						<div class="col-sm-3">Joined At:</div>
						<div class="col-sm-9">NA</div>
					</div>
					<div class="row">
						<div class="col-sm-3">Term Joined:</div>
						<div class="col-sm-9">NA</div>
					</div>
					<div class="row">
						<div class="col-sm-3">Expiration Date:</div>	
						<div class="col-sm-9">NA</div>
					</div>
					<div class="row">
						<div class="col-sm-3">Balance:</div>
						<div class="col-sm-9">0.00 ounce(s)</div>
					</div>
					@else
					<div class="row">
						<div class="col-sm-3">Joined At:</div>
						<div class="col-sm-9">{{$tdaccount_user->created_at}}</div>
					</div>
					<div class="row">
						<div class="col-sm-3">Term Joined:</div>
						<div class="col-sm-9">{{$tdaccount_user->term_joined}} {{__(' months')}}</div>
					</div>
					<div class="row">
						<div class="col-sm-3">Expiration Date:</div>	
						<div class="col-sm-9">{{$tdaccount_user->expiration_date()}}</div>
					</div>
					<div class="row">
						<div class="col-sm-3">Balance:</div>
						<div class="col-sm-9">{{$tdaccount_user->balance}} {{__(' ounce(s)')}}</div>
					</div>
					@endif
				</div>
			</div>

			<div class="card">
				<div class="header">
					<h2><strong>Deposit</strong></h2>
				</div>
				<div class="body">
					<form action="{{route('tdaccounts.deposit')}}" method="post">
						{{csrf_field()}}

						@if(is_null($tdaccount_user))
						<div class="form-group row">
							<label for="amount" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label">{{__('Choose the term:')}}</label>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					      <select name="term_joined" class="form-control">
									@foreach($terms as $term)
									<option value="{{$term}}">{{$term}}</option>
									@endforeach
								</select>
							</div>
							<label class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								{{__('This is only a one time process.')}}
							</label>
						</div>
						@endif

						<div class="row mb-5">
							<label for="staticEmail" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label">{{__('Silver amount(ounces):')}}</label>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
								<input type="number" name="ounce" id="ounce" class="form-control"  readonly required>
							</div>
						</div>

						<div class="form-group row">
							<label for="amount" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label">Amount({{Auth::user()->currentCurrency()->symbol}}):</label>
							<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					        	<input type="number" class="form-control" id="amount" name="amount" step=".01" min=".01" required>
							</div>
						</div>

						<input type="hidden" name="price" id="price" value="{{setting('site.silver_price')}}">
						<input type="hidden" name="tdaccount_id" value="{{$tdaccount->id}}">
						<div class="row">
							<div class="col-sm-12 text-right">
								<button type="submit" class="btn btn-primary btn-round mb-2">Deposit</button>								
							</div>							
						</div>
					</form>
				</div>
			</div>

			@if( ! is_null($tdaccount_user))
				@if($tdaccount_user->balance > 0)
				<div class="card">
					<div class="header">
						<h2><strong>Withdraw</strong>(Penalty rate: {{$tdaccount->penalty_rate}}%)</h2>
					</div>
					<div class="body">
						<form action="{{route('tdaccounts.withdraw')}}" method="post">
							{{csrf_field()}}

							<div class="row mb-5">
								<label for="staticEmail" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label">{{__('Silver amount(ounces):')}}</label>
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
									<input type="number" name="ounce" id="withdrawal_ounce" class="form-control" max="{{$tdaccount_user->balance}}"  readonly required>
								</div>
								<p class="col-lg-12 card-text" id="actual_withdrawal_ounces_info"></p>
							</div>

							<div class="form-group row">
								<label for="amount" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label">Amount({{Auth::user()->currentCurrency()->symbol}}):</label>
								<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						        	<input type="number" class="form-control" id="withdrawal_amount" name="amount" step=".01" min=".01" required>
								</div>
							</div>

							<input type="hidden" name="price" id="withdrawal_price" value="{{setting('site.silver_price')}}">
							<input type="hidden" name="tdaccount_id" value="{{$tdaccount->id}}">
							<input type="hidden" name="penalty_rate" value="{{$tdaccount->penalty_rate}}">
							<div class="row">
								<div class="col-sm-12 text-right">
									<button type="submit" class="btn btn-primary btn-round mb-2">Withdraw</button>
								</div>							
							</div>
						</form>
					</div>
				</div>
				@endif
			@endif

			@include('tdaccounts.partials.transactions')

			<div class="card">
				<div class="header">
					<h2>About {{$tdaccount->name}}</h2>
				</div>
				<div class="body">
					<div class="row">
						<div class="col-sm-3">Term:</div>
						<div class="col-sm-9">{{$tdaccount->terms_month}} months</div>
					</div>
					<div class="row">
						<div class="col-sm-3">Interest Rate:</div>
						<div class="col-sm-9">{{$tdaccount->interest_rate}} %</div>
					</div>
					<div class="row">
						<div class="col-sm-3">Risk Factor:</div>
						<div class="col-sm-9">{{$tdaccount->risk_factor}}</div>
					</div>
					<div class="row">
						<div class="col-sm-3">Maximum Cap:</div>
						<div class="col-sm-9">{{$tdaccount->maximum_cap}}{{__(' $')}}</div>
					</div>
					<div class="row">
						<div class="col-sm-3">Description:</div>
						<div class="col-sm-9">{{$tdaccount->description}}</div>
					</div>
				</div>
			</div>

  	</div>

  </div>
@endsection

@section('js')
<script>
$('#amount')
  .keyup(function() {
    $('#ounce').val(Math.floor($(this).val() / $('#price').val() * 100) / 100);
});

$('#withdrawal_amount')
  .keyup(function() {
  	var ounce = Math.ceil($(this).val() / $('#withdrawal_price').val() * 100) / 100;
    $('#withdrawal_ounce').val(ounce);
    $('#actual_withdrawal_ounces_info').text( Math.ceil(ounce * 94) / 100 + 'ounces will be transferred to the main account!');
});
</script>
@endsection

@section('footer')
	@include('partials.footer')
@endsection