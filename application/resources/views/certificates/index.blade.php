@extends('layouts.app')

@section('content')
    <div class="row clearfix">
        @include('partials.sidebar')
		
		<div class="col-md-9">
			<div class="card">
				<div class="header">
					<h2><strong>Pending</strong> Orders</h2>
				</div>
				<div class="body">
					<div class="table-responsive">
						<table class="table m-b-0">
		                    <thead>
		                        <tr>
		                        	<th>Date</th>
		                        	<th>Type</th>
		                        	<th>Quantity</th>
		                        	<th>Currency</th>
		                        	<th>Currency Amount</th>
		                        	<th>Net</th>
		                        	<th>Fee</th>
		                        	<th>Metal Amount</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                    	@forelse($pending_orders as $order)
		                    	<tr>
		                    		<td>{{$order->created_at}}</td>
		                    		<td>{{$order->cert_type}}</td>
		                    		<td>{{$order->quantity}}</td>
		                    		<td>{{$order->currency->symbol}}</td>
		                    		<td>{{$order->currency_amount}}</td>
		                    		<td>{{$order->currency_net}}</td>
		                    		<td>{{$order->currency_fee}}</td>
		                    		<td>{{$order->metal_amount}}</td>
		                    	</tr>
		                    	@empty
                    
                    			@endforelse
		                    </tbody>
		                </table>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="header">
					<h2><strong>Complete</strong> Orders</h2>
				</div>
				<div class="body">
					<div class="table-responsive">
						<table class="table m-b-0">
		                    <thead>
		                        <tr>
		                        	<th>Date</th>
		                        	<th>Type</th>
		                        	<th>Quantity</th>
		                        	<th>Currency</th>
		                        	<th>Currency Amount</th>
		                        	<th>Net</th>
		                        	<th>Fee</th>
		                        	<th>Metal Amount</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                    	@forelse($complete_orders as $order)
		                    	<tr>
		                    		<td>{{$order->created_at}}</td>
		                    		<td>{{$order->cert_type}}</td>
		                    		<td>{{$order->quantity}}</td>
		                    		<td>{{$order->currency->symbol}}</td>
		                    		<td>{{$order->currency_amount}}</td>
		                    		<td>{{$order->currency_net}}</td>
		                    		<td>{{$order->currency_fee}}</td>
		                    		<td>{{$order->metal_amount}}</td>
		                    	</tr>
		                    	@empty
                    
                    			@endforelse
		                    </tbody>
		                </table>
					</div>
				</div>
			</div>
    	</div> 

    </div>
@endsection

@section('footer')
	@include('partials.footer')
@endsection
