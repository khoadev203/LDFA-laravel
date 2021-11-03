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
                <h4><strong>Add your button to your webpage</strong></h4>
                <p>You've just created customised HTML code for your button. The final step is to copy the code from this page and paste it into your website.</p>
                  <b>Copy the button code:</b>
                  <p>1. Click <b>Select Code.</b></p>
                  <p>2. Right-click and copy the selected code. For Mac users, hold down the "control" key and click to copy the code.</p>
                  <p>If you're working with a website developer, you can paste the button code into an email and send it to your developer now.</p>
                  <p><b>Paste the button code in your website:</b></p>
                  <p>The code must be pasted in the "code" view where you can view and edit HTML.</p>
                  <p>1. In your website editor or admin page, open the page you want to add your button to.</p>
                  <p>2. Look for an option to view or edit HTML.</p>
                  <p>3. Find the section of the page where you want your button to appear.</p>
                  <p>4. Right-click and paste your button code into the HTML. For Mac users, hold down the "control" key and click to paste the code.</p>
                  <p>5. Save and publish the page. (Please note, the preview function in your editor may not display the button code correctly.)</p>
                  <p>6. est the button to make sure it links to a PayPal payment page.</p>

                   <div class="offset-md-2 col-md-8">
                  <p class="mb-6 p-3 bg-secondary text-white word-break banner-text" style="white-space: inherit;">
                    <button class="btn btn-sm btn-success btn-copy" data-toggle="tooltip" data-placement="top" title="Copy to clipboard">Copy</button>
                    <span class="text-to-copy">
                      &lt;form action="{{URL::to('/api/v1/processPayment.php')}}/@if($data['type']=='Buy')pay @elseif($data['type']=='Subscribe')subscribe @elseif($data['type']=='Donate')donate @endif" method="get" target="_top"&gt;</br>
                        &lt;input type="hidden" name="hosted_button_id" value="{{base64_encode(serialize($data->id))}}"&gt;</br>

                        @forelse($dropdowns as $key=>$item)
                        &lt;select name="item[{{$item['name']}}]"&gt;<br>
                          @forelse($item['options'] as $option)
                          &lt;option value="{{$option}}"&gt;{{$option}}&lt;/option&gt;<br>                          
                          @empty
                          @endforelse
                        &lt;/select&gt;<br>
                        @empty
                        @endforelse

                        &lt;input type="submit" name="Submit"&gt;</br>
                      &lt;/form&gt;
                    </span>
                  </p>
                </div>
              </div>
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