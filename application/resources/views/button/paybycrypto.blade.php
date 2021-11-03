@extends('layouts.app')
@section('content')
{{--  @include('partials.nav')  --}}
<div class="row">
   @include('partials.sidebar')
   <div class="col-md-9 " style="padding-right: 0">
      @include('partials.flash')
  
      <div class="" id="firstload">
        <div class="col-md-12">
           <div class="card mb-0">
              <div class="header">
              </div>
              <div class="body">
                <div class="body">
              <form action="{{route('depositepay',$request)}}" method="post" enctype="multipart/form-data" >
                    {{csrf_field()}}
                    <div class="row mb-5">
                      <div class="col">
                        <div class="form-group {{ $errors->has('merchant_site_url') ? ' has-error' : '' }}">
                            <label for="deposit_currency">{{  __('Deposit Currency')  }}</label>
                            <select class="form-control" id="deposit_currency" name="deposit_currency">
                              @forelse($currencies as $method)
                                  <option value="{{$method->id}}" >{{$method->name}}</option>
                              @empty
                              @endforelse
                            </select>
                        </div>
                      </div> 
                      
                      <input type="hidden" name="amount" value="{{$amount}}">
                    </div>
                     <div class="col" style="display: none;">
                        <div class="form-group {{ $errors->has('merchant_site_url') ? ' has-error' : '' }}">
                          <div class="form-group">
                            <label for="deposit_method">{{__('Deposit Method')}}</label>
                            <select class="form-control" id="deposit_method" name="deposit_method">
                              @forelse($methods as $method)
                                  <option value="{{$method->id}}" @if($method->name == $current_method->name) selected @endif>{{$method->name}}</option>
                              @empty


                              @endforelse
                            </select>
                            @if ($errors->has('deposit_method'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('deposit_method') }}</strong>
                              </span>
                          @endif
                          </div>
                        </div>
                      </div>
                    <div class="clearfix"></div>
                    <div class="row mb-5">
                      <div class="col">
                        <div class="form-group {{ $errors->has('message') ? ' has-error' : '' }}">
                          <label for="message">{{__('Message to the reviewer')}} </label>
                          <textarea name="message" id="message" cols="30" rows="10" class="form-control" placeholder="{{__('Message to the reviewer')}}" style="border: 1px solid #eeee;"></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row bm-5">
                      <div class="col">
                        <div class="form-group {{ $errors->has('deposit_screenshot') ? ' has-error' : '' }}">
                          <label for="deposit_screenshot">{{$current_method->name}} {{__('Transaction Receipt Screenshot')}}</label>
                          <input type="file" class="form-control" id="deposit_screenshot" name="deposit_screenshot" value="{{ old('merchant_logo') }}" required>
                          @if ($errors->has('deposit_screenshot'))
                              <span class="help-block">
                                  <strong>{{ $errors->first('deposit_screenshot') }}</strong>
                              </span>
                          @endif 
                        </div>
                      </div>
                    </div>
                    <div class="row mb-5">
                      <div class="col mt-5 ">
                        <input type="submit" class="btn btn-primary float-right" value="{{__('Save Deposit')}}">
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </form>                          
                
            </div>
              </div>
           </div>
        </div>
      </div>
     
   </div>
</div>

@endsection
@section('footer')
@include('partials.footer')
@endsection