@extends('layouts.app')

@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
          @include('flash')
          <div class="card">
            <div class="header">
                <h2><strong>{{__('Request')}}</strong> {{__("Money")}}</h2>
                
            </div>
            <div class="body">
              <form action="{{route('requestMoney')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row mb-5">
                      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label">{{__('Silver amount(ounces):')}}</label>
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input type="number" name="ounce" id="ounce" class="form-control"  readonly required>
                      </div>
                    </div> 

                    <div class="row">
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                      <div class="form-group {{ $errors->has('merchant_site_url') ? ' has-error' : '' }}">
                        <div class="form-group">
                          <label for="deposit_method">{{__('Currency')}} [ <span class="text-primary">{{Auth::user()->currentCurrency()->code}}</span> ]</label>
                          <select class="form-control" id="currency" name="currency">
                            <option value="{{ Auth::user()->currentCurrency()->id }}" data-value="{{ Auth::user()->currentCurrency()->id}}" selected>{{ Auth::user()->currentCurrency()->name }} </option>
                            @forelse($currencies as $currency)
                                <option value="{{$currency->id}}" data-value="{{$currency->id}}">{{$currency->name}}</option>
                            @empty


                            @endforelse
                          </select>
                          @if ($errors->has('currency'))
                            <span class="help-block">
                                <strong>{{ $errors->first('currency') }}</strong>
                            </span>
                        @endif
                        </div>
                      </div>
                </div>
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <div class="form-group {{ $errors->has('amount') ? ' has-danger' : '' }}">
                          <label for="amount">{{__('Amount')}}</label>
                          <input type="number" class="form-control" id="amount" name="amount" value="{{old('amount')}}" required placeholder="5.00" pattern="[0-9]+([\.,][0-9]+)?" 
                            
                           @if(Auth::user()->currentCurrency()->is_crypto == 1 )
                            step="0.00000001" 
                           @else
                            step="0.01" 
                           @endif
                          >
                           @if ($errors->has('amount'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('amount') }}</strong>
                                </div>
                            @endif
                        </div>
                      </div>
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <label for="email">{{__('User email')}}</label>
                        <div class="input-group {{ $errors->has('email') ? ' has-danger' : '' }}">
                            <span class="input-group-addon"><i class="zmdi zmdi-email"></i></span>
                            <input type="text" class="form-control email" id="email" name="email" placeholder="Ex: example@example.com" required >
                             @if ($errors->has('email'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </div>
                            @endif
                        </div>
                      </div>
                    </div>

                    <input type="hidden" name="price" id="price" value="{{$metalPrice}}">

                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col">
                        <div class="form-group {{ $errors->has('description') ? ' has-danger' : '' }}">
                          <label for="description">{{__('Note for Recepient')}}</label>
                          <textarea class="form-control" rows="5" id="description" name="description" placeholder="{{__('Write a note...')}}" required></textarea>
                           @if ($errors->has('description'))
                                <div class="form-control-feedback">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </div>
                            @endif
                        </div>
                      </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col">
                        <input type="submit" class="btn btn-primary float-right" value="{{__('Request')}}">
                      </div>
                    </div>
                    <div class="clearfix"></div>
                  </form>                        
                
            </div>
          </div>
            
        </div>
    </div>
@endsection
@section('js')
<script>
$( "#currency" )
  .change(function () {
    $( "#currency option:selected" ).each(function() {
      window.location.replace("{{url('/')}}/wallet/"+$(this).val());
  });
})

$('#amount')
  .change(function() {
    $('#ounce').val(Math.floor($(this).val() / $('#price').val() * 100) / 100);
  });
</script>

@endsection
@section('footer')
  @include('partials.footer')
@endsection
