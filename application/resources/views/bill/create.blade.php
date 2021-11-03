@extends('layouts.app')
@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
          @include('flash')
          <div class="card">
            <div class="header">
                <h2><strong>{{__('BILLING')}}</strong> {{__("FORM")}}</h2>
            </div>
            <div class="body">
              <form method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                <h5>Direct Print</h5>
                <p>You can print out the check to deliver or mail it. Your account will be charged $2.00 for this service.</p>
                <h5>Order Print</h5>
                <p>Enter the information below and we will print and mail the check for you within one business day.<br>Your account will be charged $3.50 for this service.</p>

                <div class="clearfix"></div>
                <div class="row g-2">
                  <div class="col-md-12 mb-3">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="PrintType" id="PrintType1" value="direct" checked="">
                      <label class="form-check-label" for="PrintType1">Direct Print</label>
                    </div>
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="PrintType" id="PrintType2" value="order">
                      <label class="form-check-label" for="PrintType2">Order Print</label>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="name" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('Payee')}}</label>
                      <input type="text" class="form-control" id="name" name="name"  required placeholder="John">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="amount" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('Amount')}}</label>
                      <input type="number" class="form-control" id="amount" name="amount"  required placeholder="5.00">
                    </div>
                  </div>

                  <div class="form-group col-md-12">
                    <label for="address" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__("Payee's Address")}}</label>
                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Company address"></textarea>
                  </div>

                  <div class="form-group col-md-6">
                    <label for="account" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('Account Number')}}</label>
                    <input type="number" class="form-control" id="account" name="account"  required placeholder="4242 4242 4242 4242">
                  </div>

                  <div class="form-group col-md-6">
                    <label for="amount" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('Telephone Number')}}</label>
                    <input type="text" class="form-control" id="phonenumber" name="phonenumber"  required placeholder="">
                  </div>

                  <div class="form-group col-md-12">
                    <label for="amount" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 col-form-label">{{__('Note')}}</label>
                    <textarea class="form-control" id="note" name="note" rows="3" placeholder="Reason for check"></textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <input type="submit" class="btn btn-primary float-right" value="{{__('Create Check')}}">
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