<?php
  require_once('./config.php');

  $token  = $_POST['stripeToken'];
  $email  = $_POST['stripeEmail'];

  $customer = \Stripe\Customer::create([
      'email' => $email,
      'source'  => $token,
  ]);

  $charge = \Stripe\Charge::create([
      'customer' => $customer->id,
      'amount'   => 35000,
      'currency' => 'mxn',
  ]);

  echo '<h1>Cupón comprado por $350.00!</h1>';

  print_r($charge);
?>