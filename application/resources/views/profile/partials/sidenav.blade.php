<div class="col-md-3">
    <div class="list-group">
        <a href="{{url('/')}}"  class="list-group-item list-group-item-action {{ (Route::is('home') ? 'active' : '') }}">{{__('Home')}}</a>
        <a href="{{url('/')}}/profile/info"  class="list-group-item list-group-item-action {{ (Route::is('profile.info') ? 'active' : '') }}">{{__('Personal Info')}}</a>
        <a href="{{ route('profile.identity') }}" class="list-group-item list-group-item-action {{ (Route::is('profile.identity') ? 'active' : '') }}">{{__('Proof of Identity')}}</a>
        <a href="{{ route('profile.newpassword') }}" class="list-group-item list-group-item-action {{ (Route::is('profile.newpassword') ? 'active' : '') }}">{{__('Change Password')}}</a>
        <a href="{{url('/')}}/profile/creditcard" class="list-group-item list-group-item-action">Credit/Debit Card Info</a>
        <a href="{{url('/')}}/profile/bankinfo" class="list-group-item list-group-item-action">Bank Account Info</a>
    </div>
</div>