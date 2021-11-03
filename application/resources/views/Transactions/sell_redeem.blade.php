@extends('layouts.app')
@section('content')

    <div class="row">
      @include('partials.sidebar')
      <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
        @include('flash')
        <div class="card">
          <div class="header">
              <h2><strong>{{__('BUY')}}</strong> {{__(" CERTIFICATES FROM YOUR ACCOUNT")}}</h2>
              
          </div>
          <div class="body">
            <form action="{{route('buy_certificate')}}" method="post" enctype="multipart/form-data">
              {{csrf_field()}}

              <p>We have appropriated the Liberty Dollar Network Silver Certificates for use with LDFA. Please be aware that each of these is denominated NOT in US Dollar value, but in Liberty Dollar value. Liberty Dollar Certificates are fixed at 25 Liberty Dollars to an ounce of silver. Each Certificate is also marked on the reverse with the specific amount of silver it represents.</p>
              <p>
                These certificates are available in exchange for silver in your account. They are priced in US Dollars for the specific amount of silver they represent. Each ounce of silver represented sells for SPOT plus $1 USD, and smaller denominations are priced accordingly.</p>                
              <center>
                <div class="row my-5">
                  <label class="col-md-3 col-form-label">Shipping/Mailing Address:</label>
                  <div class="col-md-9">
                    <input type="text" name="address" id="address" class="form-control" required>
                  </div>
                </div>

                <div class="row mb-2">                       
                  <div class="col-md-6">
                    <img src="{{ asset('application/public/assets/images/silver_certificates/10th.jpg')}}" height="100px"><br>
                    <p>This Certificate conveys title to one-tenth of an ounce of .999 fine silver.</p>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="cert10th" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('One Tenth Ounce Certificate')}}</label>
                    <input type="number" class="form-control" id="cert10th" name="certificates[v10th]" pattern="[0-9]+([\,][0-9]+)?" value="0" data-toggle="tooltip" data-placement="right" title="(SPOT+${{$fee}}) divided by 10">
                  </div>
                </div>

                <div class="row mb-2">                       
                  <div class="col-md-6">
                    <img src="{{ asset('application/public/assets/images/silver_certificates/4th.jpg')}}" height="100px"><br>
                    <p>This Certificate conveys title to one-fourth of an ounce of .999 fine silver.</p>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="cert4th" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('One Fourth Ounce Certificate.')}}</label>
                    <input type="number" class="form-control" id="cert4th" name="certificates[v4th]"  pattern="[0-9]+([\,][0-9]+)?" value="0" data-toggle="tooltip" data-placement="right" title="(SPOT+${{$fee}}) divided by 4">
                  </div>
                </div>

                <div class="row mb-2">                       
                  <div class="col-md-6">
                    <img src="{{ asset('application/public/assets/images/silver_certificates/2nd.jpg')}}" height="100px"><br>
                    <p>This Certificate conveys title to one-half of an ounce of .999 fine silver.</p>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="cert2nd" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('One-half Ounce Certificate')}}</label>
                    <input type="number" class="form-control" id="cert2nd" name="certificates[v2nd]"  pattern="[0-9]+([\,][0-9]+)?" value="0" data-toggle="tooltip" data-placement="right" title=" (SPOT+${{$fee}}) divided by 2">
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-6">
                    <img src="{{ asset('application/public/assets/images/silver_certificates/1.jpg')}}" height="100px"><br>
                    <p>This Certificate conveys title to one ounce of .999 fine silver.</p>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="cert1" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('One Ounce Certificate')}}</label>
                    <input type="number" class="form-control" id="cert1" name="certificates[v1]"  pattern="[0-9]+([\,][0-9]+)?" value="0" data-toggle="tooltip" data-placement="right" title="SPOT+${{$fee}}">
                  </div>
                </div>

                <div class="row mb-2">                       
                  <div class="col-md-6">
                    <img src="{{ asset('application/public/assets/images/silver_certificates/2.jpg')}}" height="100px"><br>
                    <p>This Certificate conveys title to two ounces of .999 fine silver.</p>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="cert2" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('Two Ounces Certificate')}}</label>
                    <input type="number" class="form-control" id="cert2" name="certificates[v2]"  pattern="[0-9]+([\,][0-9]+)?" value="0" data-toggle="tooltip" data-placement="right" title=" (SPOT+${{$fee}}) times 2">
                  </div>
                </div>

                <div class="row mb-2">
                  <div class="col-md-6">
                    <img src="{{ asset('application/public/assets/images/silver_certificates/5.jpg')}}" height="100px"><br>
                    <p>This Certificate conveys title to five ounces of .999 fine silver.</p>
                  </div>
                  <div class="form-group col-md-4">
                    <label for="cert5" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('Five Ounces Certificate')}}</label>
                    <input type="number" class="form-control" id="cert5" name="certificates[v5]"  pattern="[0-9]+([\,][0-9]+)?" value="0" data-toggle="tooltip" data-placement="right" title="(SPOT+${{$fee}}) times 5">
                  </div>
                </div>

                <input type="hidden" name="price" id="price" value="{{$metalPrice}}">
                <input type="hidden" name="fee" id="fee" value="{{$fee}}">
              </center>
              <h2 class="px-5">Total Cost: <span id="totalCost"></span></h2>
              <div class="row">
                <div class="col">
                  <input type="submit" class="btn btn-primary float-right" value="{{__('Buy')}}">
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
    $('[data-toggle="tooltip"]').tooltip();
    CalculateCost();

    function CalculateCost()
    {
      var fee = $('#fee').val();
      var spot = $('#price').val();
      var price = parseFloat(fee) + parseFloat(spot);

      console.log('price', price)
      console.log(parseFloat($('#cert10th').val()) / 10)
      console.log(parseFloat($('#cert4th').val()) / 4)
      console.log(parseFloat($('#cert2nd').val()) / 2)
      console.log(parseFloat($('#cert1').val()))
      console.log(parseFloat($('#cert2').val()) * 2)
      console.log(parseFloat($('#cert5').val()) * 5)

      console.log('total', parseFloat($('#cert10th').val()) / 10 +
        parseFloat($('#cert4th').val()) / 4 +
        parseFloat($('#cert2nd').val()) / 2 +
        parseFloat($('#cert1').val()) +
        parseFloat($('#cert2').val()) * 2 +
        parseFloat($('#cert5').val()) * 5)
      console.log('price*total', price * (parseFloat($('#cert10th').val()) / 10 +
        parseFloat($('#cert4th').val()) / 4 +
        parseFloat($('#cert2nd').val()) / 2 +
        parseFloat($('#cert1').val()) +
        parseFloat($('#cert2').val()) * 2 +
        parseFloat($('#cert5').val()) * 5))

      var cost = (price * (parseFloat($('#cert10th').val()) / 10 +
        parseFloat($('#cert4th').val()) / 4 +
        parseFloat($('#cert2nd').val()) / 2 +
        parseFloat($('#cert1').val()) +
        parseFloat($('#cert2').val()) * 2 +
        parseFloat($('#cert5').val()) * 5)).toFixed(2);
      $('#totalCost').text(cost)
    }

    $('input').on('keyup blur change', function() {
      CalculateCost()

    })
  })
</script>
@endsection