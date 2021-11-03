@extends('layouts.app')
@section('styles')

@endsection
@section('content')
<style type="text/css">
    .hide{
    display:none;
}
</style>
    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 ">
            <div class="card">
            <div class="body">
                
                <div class="row">
                    <div class="preview col-lg-12 col-md-12">
                        <div class="preview-pic tab-content">
                            <div class="tab-pane active show" id="product_1" style="text-align: center; padding-top: 20px">
                                <img src="{{url('/')}}/storage/imgs/seamlesschex.png" class="img-fluid" style="width: 50%">
                            </div>
                            
                        </div>
                                       
                    </div>
                    <div class="details col-lg-12 col-md-12" id="buy_form">
                        <h3 class="product-title m-b-0">{{__('Add funds to your wallet with Seamless Chex') }}</h3>                        
                        
                        <div class="card bg-light mt-5">

                            <div class="body">
                                <form accept-charset="UTF-8" action="{{url('buyvoucher/seamless')}}" class="require-validation"id="payment-form" method="post">
                                    {{ csrf_field() }}
                                    @include('flash')
                                    <div class='form-row mb-3'>
                                        <div class='col'>
                                            <label class='control-label'> {{__('Check Number')}}</label> 
                                            <input type="number" value="" name="number" class="form-control" min="1" required>
                                        </div>
                                    </div>
                                    
                                    <div class='form-row mb-3'>
                                        <div class='col'>
                                            <label class='control-label'> {{__('Amount')}}($)</label> 
                                            <input type="number" value="1" name="amount" aria-label="Search" class="form-control" min="2">
                                        </div>
                                    </div>

                                    <div class='form-row mb-3'>
                                        <div class='col form-group'>
                                            <label class='control-label'>{{__('Bank Name')}}</label> 
                                            <input autocomplete='off' name="bank_name" class='form-control card-cvc' placeholder='' size='4'
                                                type='text' required>
                                        </div>
                                    </div>

                                    <div class='form-row mb-3'>
                                        <div class='col form-group'>
                                            <label class='control-label'>{{__('Bank Account Number')}}</label> 
                                            <input name="bank_account" class='form-control' size='4' type='text' placeholder="The sender's bank account" minlength="4" required>
                                        </div>
                                    </div>

                                    <div class='form-row mb-3'>
                                        <div class='col form-group '>
                                            <label class='control-label'>{{__('Bank Routing Number')}}</label> 
                                            <input name="bank_routing" autocomplete='off' class='form-control card-number' minlength="9" type='text' placeholder="The sender's bank routing number" required="">
                                        </div>
                                    </div>

                                    <div class='form-row mb-3'>
                                        <div class='col'>
                                            <label class='control-label'> {{__('Memo')}}</label> 
                                            <input type="text" name="memo" aria-label="Search" class="form-control" placeholder="Brief description of the purpose of the check" required>
                                        </div>
                                    </div>

                                    <div class='form-row'>
                                        <div class='col form-group'>
                                            <button class='form-control btn btn-primary submit-button'
                                                type='submit' style="margin-top: 10px;">ADD FUNDS</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>
    
@endsection
@section('js')

@endsection


@section('footer')
  @include('partials.footer')
@endsection