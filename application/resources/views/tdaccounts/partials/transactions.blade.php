@if(! is_null($transactions))
<div class="card">
    <div class="header">
        <h2><strong>Money Flow </strong>History</h2>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table m-b-0">
                <thead>
                    <tr>
                        <th>{{__('Created At')}}</th>
                        <th>{{__('Amount')}}</th>
                        <th>{{__('Currency')}}</th>
                        <th>{{__('Ounce')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>{{$transaction->created_at}}</td>
                        <td>{{$transaction->amount}}</td>
                        <td>{{$transaction->currency()->first()->symbol}}</td>
                        <td>{{$transaction->metal_value}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif