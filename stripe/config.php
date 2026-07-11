<?php
require_once('vendor/autoload.php');

$stripe = [
  "secret_key"      => "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",
  "publishable_key" => "pk_live_51Ja6OoC2ByG0tJyNJYFqUIvn6xwIvmMU8zhhtBzpInrpXEwJLSbkNxuYNjLTn1gK4mgzlCdOCtGYgiiQWV8Nhu1200lt75UK4W",
];

//$stripe = [
//  "secret_key"      => "sk_test_51Ja6OoC2ByG0tJyN1OKdigPapcEvTXvluaj1UZyxqBqv92fMay7DuZdvE2B8x06M13MUVUltHr7Hv36v4c79gsiT00LNibf2ci",
//  "publishable_key" => "pk_test_51Ja6OoC2ByG0tJyNjFA3fJdzwfBpwDPjlHH5YNNboCmmA0mxXL1NQsqCjLGO3g7hlBL01CHsgGWyKrsiZSKA46jl00NmXwNSSe",
//];

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>