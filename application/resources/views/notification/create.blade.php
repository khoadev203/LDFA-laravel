@extends('layouts.app')
@section('content')

    <div class="row">
        @include('partials.sidebar')
        <div class="col-md-9 " style="padding-right: 0" id="#sendMoney">
          @include('flash')
          <div class="card">
            <div class="header">
                <h2>{{__('Add New ')}} <strong>{{__("Notification")}}</strong></h2>
            </div>
            <div class="body">
              <form method="post" enctype="multipart/form-data">
                    {{csrf_field()}}
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <div class="form-group">
                      <label class="form-label">Subject</label>
                      <input name="subject" class="form-control">
                    </div>
                  </div>
                  <div class="col-md-12 mb-3">
                    <div class="form-group">
                      <label class="form-label">Message</label>
                      <textarea name="message" class="form-control"></textarea>
                    </div>
                  </div>


                  <h4 class="col-md-12 mb-3">
                    Select user types to send notification
                  </h4>
                  <div class="col-md-4 mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="usertype" id="radioAdmin" value="admins">
                      <label class="form-check-label" for="radioAdmin">All Administrators</label>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="usertype" id="radioMember" value="members" checked>
                      <label class="form-check-label" for="radioMember">All Members</label>
                    </div>
                  </div>
                  <div class="col-md-4 mb-3">
                    @if($users->count() > 0)

                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="usertype" id="radioCustom" value="custom">
                        <label class="form-check-label" for="radioCustom">Search and choose users</label>
                      </div>

                      <div class="form-group mb-3">
                        <select id="recipients_select" name="recipients_select" multiple>
                        @foreach($users as $user)
                          <option value="{{ $user->id }}">{!!$user->name!!}</option>
                        @endforeach
                        </select>

                        <div class="d-none">
                        @foreach($users as $user)
                          <label title="{{ $user->name }}">
                            <input type="checkbox" class="chk_recipients" name="recipients[]" value="{{ $user->id }}">
                              {!!$user->name!!}
                          </label>
                        @endforeach
                        </div>
                      </div>
                    @endif
                  </div>
                </div>
                <div class="row">
                  <div class="col">
                    <input type="submit" class="btn btn-primary float-right" value="{{__('Add')}}">
                  </div>
                </div>
              </form>                        
              
            </div>
          </div>
          
        </div>
    </div>
@endsection
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/css/slimselect.css')}}">
<style type="text/css">
  .dropdown-menu.show {
      display: none;
  }
  .dropdown-toggle {
    display: none;
  }
</style>
@endsection
@section('js')
<script src="{{ asset('assets/js/slimselect.min.js')}}"></script>

<script type="text/javascript">
  $(document).ready(function() {
    new SlimSelect({
      select: '#recipients_select',
      onChange: (sel_users) => {
        console.log(sel_users)
        $('.chk_recipients').prop('checked', false);
        $('.chk_recipients').each(function() {
            for (var i = sel_users.length - 1; i >= 0; i--) {
                if(sel_users[i].value == $(this).val()) {
                    $(this).prop('checked', true);
                }
            }
        })
      }
    });
  })
</script>
@endsection


@section('footer')
@include('partials.footer')
@endsection