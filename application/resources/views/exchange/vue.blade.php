<script >
var withdrawal_form = new Vue({
	el: '#exchange_form',
	data:{
		total: 0,
		rate: {{$exchange}}
	},
	methods: {
		@if( $secondCurrency->is_crypto == 1 )
			exchange : function(evt){ 
				this.total =  (evt.target.value * this.rate).toFixed(8); 
			}
		@else
			exchange : function(evt){ 
				this.total =  (evt.target.value * this.rate).toFixed(2); 
			}
		@endif



	}
});
</script>