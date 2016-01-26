
<div class="tab-pane" id="tab3">

	<h3 class="block">Provide your billing and credit card details</h3>
	

	<div class="row">
		<div class="col-md-6">
			<div class="form-group">
			<h6>Pay with card</h6>
			<button type="button" id="customButton" class="stripe-button-el btn btn-success" style="visibility: visible;"><span>Pay with Card</span></button>
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
	<input type="hidden" name="booking_price" value="{!! $destination['price'] !!}">
</div>

@section('custom-scripts')
	@parent
	<script>
        stripe = new App.Payment.Stripe("{!!  \Config::get('stripe')['publishable_key'] !!}", "{!! isset($price) !!}")
        stripe.init();
        stripe.handers();

	</script>
@endsection