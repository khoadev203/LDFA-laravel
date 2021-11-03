@extends('layouts.app')

@section('styles')
<style type="text/css">
    .table tbody tr td, .table tbody th td {
        white-space: initial;
    }
</style>
@endsection

@section('content')
<div class="row clearfix">
    @include('partials.sidebar')
	<div class="col-md-9 ">
        @include('flash')
		<div class="card">
			<div class="header">
				<h2><strong>Terms Deposit</strong> Accounts</h2>
			</div>
			<div class="body">
                <table class="table m-b-0">
                    <thead>
                        <tr>
                            <th>{{__('Name')}}</th>
                            <th>{{__('Balance')}}</th>
                            <th>{{__('Action')}}</th>
                            <th>{{__('Description')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tdaccounts as $tdaccount)
                        <tr>
                            <td>{{$tdaccount->name}}</td>
                            <td>
                                {{$tdaccount->getUserBalance(Auth::user()->id)}}
                            </td>
                            <td><a href="{{route('tdaccounts', $tdaccount->id)}}" class="btn btn-primary">{{__('Manage')}}</a></td>
                            <td>{{$tdaccount->description}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card">
            <div class="header">
                <h2><strong>Loan Application </strong> Form</h2>
            </div>
            <div class="body">
                <form method="post" action="{{route('applyLoan')}}">
                    @csrf
                    <div class="row form-group mb-2">
                        <label for="amount" class="col-lg-3 text-right">Amount</label>
                        <div class="col-lg-3">
                            <input type="number" step=".01" name="amount" id="amount" class="form-control" placeholder="Ounce" required>
                            <small id="amountHelp" class="form-text text-muted">Input ounce amount.</small>
                        </div>
                        <div class="col-lg-3 offset-lg-1">
                            <input type="number" step=".01" name="usd_amount" id="usd_amount" class="form-control" placeholder="USD" required>
                            <small id="usd_amountHelp" class="form-text text-muted">Input USD amount.</small>
                        </div>
                    </div>

                    <div class="row form-group mb-2">
                        <label for="name" class="col-lg-3 text-right">Name</label>
                        <div class="col-lg-7">
                            <input type="text" name="name" class="form-control" value="{{Auth::user()->first_name.' '.Auth::user()->last_name}}" required>
                        </div>
                    </div>
                    <div class="row form-group mb-2">
                        <label for="address" class="col-lg-3 text-right">Address</label>
                        <div class="col-lg-7">
                            <input type="text" name="address" class="form-control" required>
                        </div>
                    </div>
                    <div class="row form-group mb-2">
                        <label for="contact" class="col-lg-3 text-right">Phone or Skype ID</label>
                        <div class="col-lg-7">
                            <input type="text" name="contact" class="form-control" value="{{Auth::user()->phonenumber}}" required>
                        </div>
                    </div>
                    <div class="row form-group mb-2">
                        <label for="purpose" class="col-lg-3 text-right">Purpose of Loan</label>
                        <div class="col-lg-7">
                            <input type="text" name="purpose" class="form-control" required>
                        </div>
                    </div>
                    <div class="row form-group mb-2">
                        <label for="time" class="col-lg-3 text-right">Best time to call</label>
                        <div class="col-lg-7">
                            <input type="text" name="time" class="form-control" placeholder="e.g: I'm free Monday 3pm-6pm, Tuesday 11am-2pm, and Friday after 3pm" required>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <input type="hidden" name="price" id="price" value="{{setting('site.silver_price')}}">
                    <div class="row">
                      <div class="col-lg-10 text-center">
                        <input type="submit" class="btn btn-primary float-right" value="{{__('Submit')}}">
                      </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function() {
        $('#usd_amount').keyup(function() {
            $('#amount').val(Math.floor($(this).val() / $('#price').val() * 100) / 100);
          });

        $('#amount').keyup(function() {
          $('#usd_amount').val(Math.floor($(this).val() * $('#price').val() * 100) / 100)
        });
    })
</script>
@endsection