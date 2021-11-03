<script >
var withdrawal_form = new Vue({
	el: '#withdrawal_form',
	data:{
		total: 0,
		total_ounce: 0
	},
	methods: {
		totalize : function(evt){
		  	@if(Auth::user()->currentCurrency()->is_crypto == 1 )
                this.total =  (evt.target.value - ( (({{$current_method->percentage_fee}}/100) * evt.target.value)  )).toFixed(8);
      	 	@else
      	 		this.total =  (evt.target.value - ( (({{$current_method->percentage_fee}}/100) * evt.target.value) + {{$current_method->fixed_fee}} )).toFixed(2);
           	@endif

			this.total_ounce = (evt.target.value / {{setting('site.silver_price')}}).toFixed(2);
		}
	}
});
</script>