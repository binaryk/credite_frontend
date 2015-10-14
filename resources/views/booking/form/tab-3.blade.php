
<div class="tab-pane" id="tab3">

	<h3 class="block">Provide your billing and credit card details</h3>
	

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			<h6>Pay with card</h6>
	        <form action="{!! route('booking.pay.online') !!}" method="post">
	            <script src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
	                    data-key="{!!  \Config::get('stripe')['publishable_key'] !!}"
	                    data-amount="5000" data-description="One year's subscription"></script>
	        </form>
			</div>
		</div>

		<div class="col-md-6 pay-card" style="display: none;">
			{!! $data['steps']['records']['pay_cash'] !!}
		</div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<img src="{{ asset('img/stripe/stripe.png') }}">
		</div>
	</div>
</div>
