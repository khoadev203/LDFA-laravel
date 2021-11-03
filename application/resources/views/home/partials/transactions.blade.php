@if($transactions->total() > 0)

<style type="text/css">
  .dollar_design {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #3eacff;
    width: 38px;
    height: 38px;
    border-radius: 50px;
    color: #fff;
    font-weight: bold;
    font-size: 15px;
  }
</style>
<div class="card user-account">
          <div class="header">
              <h2><strong>Complete</strong>Transactions</h2>
              {{--
              <ul class="header-dropdown">
                  <li class="dropdown"> <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <i class="zmdi zmdi-more"></i> </a>
                      <ul class="dropdown-menu dropdown-menu-right slideUp float-right">
                          <li><a href="javascript:void(0);">Action</a></li>
                          <li><a href="javascript:void(0);">Another action</a></li>
                          <li><a href="javascript:void(0);">Something else</a></li>
                      </ul>
                  </li>
                  <li class="remove">
                      <a role="button" class="boxs-close"><i class="zmdi zmdi-close"></i></a>
                  </li>
              </ul>
              --}}
          </div>
          <div class="body">
              <div class="table-responsive">
                  <table class="table m-b-0">
                      <thead>
                          <tr>
                              <th></th>
                              <th>{{__('Id')}}</th>
                              <th >{{__('Date')}}</th>
                              <th class="hidden-xs">{{__('Name')}}</th>
                              <th class="hidden-xs">{{__('Gross')}}</th>
                              <th class="hidden-xs">{{__('Fee')}}</th>
                              <th class="hidden-xs">{{__('Premium Cost')}}</th>
                              <th>{{__('Net')}}</th>
                              <th class="hidden-xs">{{__('Silver Price')}}</th>
                              <th>{{__('Metal Amount')}}</th>
                          </tr>
                      </thead>
                      @forelse($transactions as $transaction)
                        <tr>

                                <td><img src="{{$transaction->thumb()}}" alt="" class="rounded" loading="lazy"></td>
 
                                {{--<td><span class="dollar_design">{{$transaction->Currenciesymbol()}}</span></td>--}}


                          <td>{{$transaction->id}}{{--<br><a href="#" class="button">view</a>--}}</td>
                          <td>{{$transaction->created_at}} <br> @include('home.partials.status')</td>
                          <td class="hidden-xs"> @include('home.partials.name')</td>
                          <td class="hidden-xs">{{$transaction->gross()}}</td>
                          <td class="hidden-xs">{{$transaction->fee()}}</td>
                          <td class="hidden-xs">{{$transaction->premium_cost > 0 ? $transaction->premium_cost():''}}</td>
                          <td>{{$transaction->net()}}</td>
                          <td class="hidden-xs">{{$transaction->silver_price > 0 ? $transaction->silver_price: ''}}</td>
                          <td>{{$transaction->metal_value()}}</td>
                        </tr>
                    @empty
                    
                    @endforelse
                  </table>
              </div>
          </div>
          @if($transactions->LastPage() != 1)
        <div class="footer">
            {{$transactions->links()}}
        </div>
      @else
      @endif
</div>

@endif