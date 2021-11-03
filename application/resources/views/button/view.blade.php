@extends('layouts.app')

@section('content')
{{-- @include('partials.nav') --}}
    <div class="row">
        @include('partials.sidebar')
    
    <div class="col-md-9 ">
        
          <div class="card">
            <div class="header">
                <h2><strong>{{__('Buy')}}</strong>{{__(' Buttons')}}</h2>
                
            </div>
            <div class="body">
              <div class="table-responsive">
                <table class="table table-striped"  style="margin-bottom: 0;">
                  <thead>
                    <tr>
                      <th>{{__('Item name')}}</th>
                      <th>{{__('Price (Ounce/USD)')}}</th>
                      <th>{{__('Shipping (Ounce/USD)')}}</th>
                      <th>{{__('Quantity')}}</th>
                      <th>{{__('Button')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($getdata as $value)
                      @if($value->type == 'Buy')
                      <tr>
                        <td>{{$value->itemname}}</td>
                        <td>{{$value->price().'/'.(setting('site.silver_price') * $value->price())}}</td>
                        <td>{{$value->shipping().'/'.(setting('site.silver_price') * $value->shipping())}}</td>
                        <td>{{$value->quantity}}</td>
                        <td>
                          <a href="{{route('button.addbutton',$value->id)}}" class="btn btn-info btn-sm">View</a>
                        </td>
                      </tr>
                      @endif
                    @empty
                    <tr><td colspan="5">{{__('There are no saved buttons!')}}</td></tr>
                    @endforelse
                  </tbody>
                </table>                          
              </div> 
            </div>
          </div>

          <div class="card">
            <div class="header">
              <h2><strong>{{__('Subscribe')}}</strong>{{__(' Buttons')}}</h2>
            </div>
            <div class="body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>{{__('Item name')}}</th>
                      <th>{{__('Billing amount each cycle (Ounce/USD)')}}</th>
                      <th>{{__('Billing cycle')}}</th>
                      <th>{{__('Billing stop cycles')}}</th>
                      <th>{{__('Button')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($getdata as $value)
                      @if($value->type == 'Subscribe')
                      <tr>
                        <td>{{$value->itemname}}</td>
                        <td>{{$value->price().'/'.(setting('site.silver_price') * $value->price())}}</td>
                        <td>{{$value->billing_cycle. ' ' . $value->billing_cycle_unit}}</td>
                        <td>{{$value->billing_stop}}</td>
                        <td><a href="{{route('button.addbutton',$value->id)}}" class="btn btn-info btn-sm">View</a></td>
                      </tr>
                      @endif
                    @empty
                    <tr><td colspan="5">{{__('There are no saved buttons!')}}</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="card">
            <div class="header">
              <h2><strong>{{__('Donate')}}</strong>{{__(' Buttons')}}</h2>
            </div>
            <div class="body">
              <div class="table-responsive">
                <table class="table table-striped">
                  <thead>
                    <tr>
                      <th>{{__('Amount(ounce)')}}</th>
                      <th>{{__('Amount(USD)')}}</th>
                      <th>{{__('Purpose')}}</th>
                      <th>{{__('Button')}}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse($getdata as $value)
                      @if($value->type == 'Donate')
                      <tr>
                        <td>{{$value->price()}}</td>
                        <td>{{(setting('site.silver_price') * $value->price())}}</td>
                        <td>{{$value->description}}</td>
                        <td><a href="{{route('button.addbutton',$value->id)}}" class="btn btn-info btn-sm">View</a></td>
                      </tr>
                      @endif
                    @empty
                    <tr><td colspan="5">{{__('There are no saved buttons!')}}</td></tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
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
<script type="text/javascript">
   $('#'+$(this).data('click')).click(function(){
    alert('hello');
    $('#'+$(this).data('id')).select();
    alert($('#'+$(this).data('id')).select());
    document.execCommand('copy');
});
</script>
@endsection
@section('footer')
  @include('partials.footer')
@endsection