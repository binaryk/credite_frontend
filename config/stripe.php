<?php
require_once( app_path() . '/stripe/vendor/autoload.php');

$stripe = array(
    "secret_key"      => "sk_test_mGFpC7M51LzKATUghK3w7Yz4",
    "publishable_key" => "pk_test_FlwfB10GbKMMnTRLp1HHxHKK"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);

return $stripe;
