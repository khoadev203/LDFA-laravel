@extends('layouts.app')

@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
          @include('flash')
          <div class="card">
            <div class="header">
                <h2><strong>{{__('Money')}}</strong> {{__("Transfer")}}</h2>
            </div>
            <div class="body">
              <form action="{{route('sendMoney')}}" method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row mb-5">
                      <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label">
                        Select a QR code image to scan
                      </label>
                      <div class="col-lg-8 col-md-8 col-sm-8 col-xs-8">
                        <input type="file" id="qr-input-file" accept="image/*" capture>
                      </div>
                    </div>
                    <div class="row mb-5">
                        <label class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label">
                          Or use the camera to scan image
                        </label>
                        <div class="col-md-8" style="text-align: center;">
                          <div id="reader" width="400px" height="400px"></div>
                          <p id="camera_desc">No camera detected!</p>
                        </div>
                    </div>
                    <div class="row mb-5">
                      <label for="staticEmail" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-form-label">{{__('Silver amount(ounces):')}}</label>
                      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                        <input type="number" name="ounce" id="ounce" class="form-control" step=".01" required>
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
                          <input type="number"  step=".01" class="form-control" id="amount" name="amount" value="{{old('amount')}}" required placeholder="5.00" pattern="[0-9]+([\.,][0-9]+)?" 
                          
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
                    
                    <input type="hidden" name="price" id="price" value="{{$metalPrice}}">

                    <div class="clearfix"></div>
                    <div class="row">
                      <div class="col">
                        <input type="submit" class="btn btn-primary float-right" value="{{__('Send')}}">
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
<script src="https://rawgit.com/sitepoint-editors/jsqrcode/master/src/qr_packed.js"></script>
<script src="{{asset('assets/js/html5-qrcode.min.js')}}"></script>
<script>
  $(document).ready(function() {
    var qr_key = 'QrCode_generation';

    $( "#currency" )
      .change(function () {
        $( "#currency option:selected" ).each(function() {
          window.location.replace("{{url('/')}}/wallet/"+$(this).val());
      });
    })

    $('#amount')
      .keyup(function() {
        $('#ounce').val(Math.floor($(this).val() / $('#price').val() * 100) / 100);
      });

    $('#ounce').keyup(function() {
      $('#amount').val(Math.floor($(this).val() * $('#price').val() * 100) / 100)
    })

    // This method will trigger user permissions
    Html5Qrcode.getCameras().then(devices => {
      alert('got devices')
      /**
       * devices would be an array of objects of type:
       * { id: "id", label: "label" }
       */
      if (devices && devices.length) {
        $('#camera_desc').text('You are using a camera.')
        var cameraId = devices[0].id;
        // .. use this to start scanning.
        // console.log('cameraId', cameraId)

        const html5QrCode = new Html5Qrcode("reader");

        alert('trying to detect camera')

        html5QrCode.start(
          cameraId, 
          {
            fps: 10,    // Optional, frame per seconds for qr code scanning
            qrbox: 500  // Optional, if you want bounded box UI
          },
          (decodedText, decodedResult) => {
            // do something when code is read
            checkDecodeResult(decodedText);
          },
          (errorMessage) => {
            // parse error, ignore it.
            console.log(errorMessage)
          })
        .catch((err) => {
          // Start failed, handle it.

        });
      }
    }).catch(err => {
      // handle err
        $('#camera_desc').text('No camera detected!')
        alert('no camera detected')
    });





    // const qrCodeSuccessCallback = (decodedText, decodedResult) => {
    //     /* handle success */
    // };
    // const config = { fps: 10, qrbox: 250 };

    // // If you want to prefer front camera
    // html5QrCode.start({ facingMode: "user" }, config, qrCodeSuccessCallback);


    // File based scanning
    const fileinput = document.getElementById('qr-input-file');
    fileinput.addEventListener('change', e => {
      if (e.target.files.length == 0) {
        // No file selected, ignore 
        return;
      }

      const imageFile = e.target.files[0];
      // Scan QR Code
      html5QrCode.scanFile(imageFile, true)
      .then(decodedText => {
        // success, use decodedText
        checkDecodeResult(decodedText);
      })
      .catch(err => {
        // failure, handle it.
        console.log(`Error scanning file. Reason: ${err}`)
      });
    });

    function checkDecodeResult(decodedText)
    {
      var decodedObj = JSON.parse(atob(decodedText));
      console.log(decodedObj)
      if(decodedObj.hasOwnProperty(qr_key)) {
        alert('Detected user\'s email is ' + decodedObj[qr_key]);
        $('#email').val(decodedObj[qr_key]);
      } else {
        alert('Invalid Image!');
      }
    }
  })
  

</script>

@endsection
@section('footer')
  @include('partials.footer')
@endsection
