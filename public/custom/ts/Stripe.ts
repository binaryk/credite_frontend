module App.Payment{
    declare var $;
    declare var StripeCheckout;
    declare var Number;

    export class Stripe{
        handler : any;
        payer   : any;
        constructor(
            public key,
            public fromRequest
        ){}

        init = () => {
            this.handler = StripeCheckout.configure({
                key: this.key,
                locale: 'auto',
                token: function(token) {
                    console.log(token);
                    $('#submit_form').submit();
                }
            });
        }

        handers = ():any =>{
            var self = this;
            $('#customButton').on('click', function(e) {
                // Open Checkout with further options
                var transfer_price = $('[name=booking_price]').val();
                var return_50      = self.fromRequest ? 0 : $('#return_50').is(':checked');
                var meet_up        = self.fromRequest ? 0 :$('#meet_and_greet').is(':checked');
                transfer_price     = Number.parseFloat(transfer_price);
                if( meet_up ){
                    transfer_price += 5;
                }
                if(return_50){
                    transfer_price += transfer_price / 2;
                }
                console.log(transfer_price);
                self.handler.open({
                    name: 'Pay transfer',
                    amount: transfer_price * 100,
                    currency: 'GBP'
                });
                e.preventDefault();
            });
            // Close Checkout on page navigation
            $(window).on('popstate', function() {
                this.handler.close();
            });
        }
    }
}