
<div class="tab-pane" id="tab3">

	<h3 class="block">Provide your billing and credit card details</h3>
	<div class="form-group">
        <form action="{!! route('booking.pay.online') !!}" method="post">
            <script src="https://checkout.stripe.com/v2/checkout.js" class="stripe-button"
                    data-key="{!!  \Config::get('stripe')['publishable_key'] !!}"
                    data-amount="5000" data-description="One year's subscription"></script>
        </form>
	</div>
</div>
