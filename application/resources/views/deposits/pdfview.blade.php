<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style type="text/css">
      @font-face 
      {
        font-family: 'micregular';
        src: url('../assets/fonts/Micr/micrenc.ttf') format('truetype');
        
      }
      body {
        font-family: none;
      }
      .font-micr-regular {
          font-family: "micregular" !important;
          font-size: 32px;
          font-style: normal;
          -webkit-font-smoothing: antialiased;
          -webkit-text-stroke-width: 0.2px;
          -moz-osx-font-smoothing: grayscale;
      }
    </style>
  </head>
  <body>

      {{--<table style="width: 100%;">
        <tbody>
          <tr>
            <td colspan="3">
              <h5 style="text-transform: uppercase;">{{$user->email}}</h5>
            </td>
            <td colspan="3">
              <h4 style="text-align: right; font-weight: bold;">{{$check_number}}</h4>
            </td>
          </tr>
          <tr>
            <td colspan="5">
              <h3 style="text-transform: uppercase;">{{$request->bank_name}}</h3>
            </td>
            <td width="10%">
              <h5 style="text-align: right; text-decoration: underline;">{{date("d/m/Y")}}</h5>
            </td>
          </tr>
          <tr>
            <td width="10%">
              Pay To The<br>Order Of
            </td>
            <td colspan="4">
              <h3 style="font-weight: bold; margin-bottom: 0;text-decoration: underline;">Liberty Dollar Financial Association</h3>
            </td>
            <td style="border: solid;">
              <h3 style="font-weight: bold; margin-bottom: 0; text-align: right;">${{$request->amount}}</h3>
            </td>
          </tr>
          <tr>
            <td colspan="5" style="border-bottom: solid;">
              <h3 style="font-weight: bold; margin-bottom: 0;">Pay Exactly {{$written_amt}} Dollars and No Cents</h3>
            </td>
            <td></td>
          </tr>
          <tr>
            <td>
              <h4>Memo</h4>
            </td>
            <td colspan="3" >
              <h5>{{$request->memo}}</h5>
            </td>
            <td>
              <h5>SIGNATURE NOT REQURIED</h5>
              <div>
                <p>Payment has been authorized by the depositor.
                Payee to hold you harmless for payment of this document.
                This document shall be deposited only to credit of payee.
                Absence of endorsement is guaranteed by payee's bank.</p>
              </div>
            </td>
          </tr>
          <tr>
            <td colspan="4">
              <h4 class="font-micr-regular">
                {{$request->bank_account}} {{$request->bank_routing}}
              </h4>
            </td>
            <td colspan="2">
              <h4 class="font-micr-regular">
                {{$check_number}}
              </h4>
            </td>
          </tr>
        </tbody>
      </table>
            --}}

    <div class="container mt-5 mb-3 border p-3" id="check-container">
      <div class="row mb-3">
        <div class="col-6">
          <h5 class="text-uppercase">
            @if(property_exists($json_arr, "user_name"))
              {{$json_arr->user_name}}
            @else
              {{$json_arr->user_email}}
            @endif
          </h5>

          @if(property_exists($json_arr, "address"))
          <h4 class="text-uppercase">{{$json_arr->address}}</h4>
          @endif
          @if(property_exists($json_arr, "phonenumber"))
          <h4 class="text-uppercase">{{$json_arr->phonenumber}}</h4>
          @endif
        </div>
        <div class="col-6">
          <h5 class="text-end fw-bold">{{$json_arr->bank_name}} {{$json_arr->check_number}}</h5>
          <br>
          <h5 class="text-end text-decoration-underline">{{$deposit->created_at}}</h5>
        </div>
      </div>

      <div class="row mb-3">
        <label class="col fs-5" style="line-height: normal;">
          Pay To The<br> Order Of
        </label>
        <div class="col-8 border-bottom border-dark border-2 me-2">
          <div class="row align-items-end h-100">
            <div class="col">
              <h5 class="fw-bold">Liberty Dollar Financial Association</h5>          
            </div>
          </div>
        </div>
        <div class="col border border-dark border-1">
          <div class="row align-items-end h-100">
            <div class="col">
              <h5 class="fw-bold fs-2 mb-0 text-end">${{$deposit->gross_without_symbol()}}</h5>
            </div>
          </div>
        </div>
      </div>

      <h5 class="border-bottom border-dark border-2 px-3 me-5 fw-bold text-capitalize">Pay Exactly {{$written_amt}} Dollars 00 Cents</h5>

      <div class="row mb-3">
        <div class="col">
          <h5 class="mt-4">Memo</h5>
        </div>
        <div class="col-5">
          <h5 class="fs-4 border-dark border-bottom border-2 mt-4">{{$deposit->message}}</h5>          
        </div>
        <div class="col-6">
          <h5 class="text-center fw-bold mt-4" style="text-transform: uppercase;">SIGNATURE NOT REQURIED</h5>
          <div class="container fs-5">
            <p class="mb-0">This draft authorized electronically by depositor.</p>
          </div>
        </div>
      </div>

      <div class="row">
        <h5 class="col-6 text-center font-micr-regular fw-bold">
          A{{$json_arr->bank_routing}}A C{{$json_arr->bank_account}}C
        </h5>
        <h5 class="col-6 font-micr-regular fw-bold">
          {{$json_arr->check_number}}
        </h5>
      </div>
    </div>
    <div class="container">
      <button class="btn btn-primary" id="btn-print">Print</button>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="{{ asset('assets/js/jQuery.print.min.js') }}"></script>
    <script type="text/javascript">
      $(document).ready(function() {
        $('#btn-print').click(function() {
          $("#check-container").print(/*options*/);
        })
      })

    </script>
  </body>
</html>