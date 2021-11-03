@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
    <div class="row">
        @include('profile.partials.sidenav')
		
		<div class="col-lg-9 ">
            @include('flash')
            <div class="card">
                <div class="header">
                    <h2><strong>{{__('Bank Account ')}}</strong> Info </h2>
                </div>
                <div class="body">
                    <form class="needs-validation" enctype="multipart/form-data" method="POST" action="{{route('profile.bankinfo.store')}}">
                        {{csrf_field()}}
                        <div class="form-row mb-3">
                            <div class="col">
                                <label class="control-label"> Check Number</label> 
                                <input type="number" value="{{$user->bank_checknum}}" name="number" class="form-control" min="1">
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col form-group">
                                <label class="control-label">Bank Name</label> 
                                <input autocomplete="off" name="bank_name" class="form-control card-cvc" placeholder="" size="4" type="text" value="{{$user->bank_name}}">
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col form-group">
                                <label class="control-label">Bank Account Number</label> 
                                <input name="bank_account" class="form-control" size="4" type="text" placeholder="The sender's bank account" minlength="4" value="{{$user->bank_accountnum}}">
                            </div>
                        </div>
                        <div class="form-row mb-3">
                            <div class="col form-group ">
                                <label class="control-label">Bank Routing Number</label> 
                                <input name="bank_routing" autocomplete="off" class="form-control card-number" minlength="9" maxlength="9" type="text" placeholder="The sender's bank routing number" value="{{$user->bank_routingnum}}">
                            </div>
                        </div>
                        <hr class="mb-4">
                        <input class="btn btn-primary btn-lg btn-block" type="submit" value="{{__('Save')}}"/>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection
