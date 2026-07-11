<?php

    require(dirname(__FILE__) . '/openpay/Openpay.php');

    Openpay::setId('aa5ggrrtptd1wtjslhye');
    Openpay::setApiKey('sk_9e70cba9e5bd4a55b4d53e72fda60cdc');

    $openpay = Openpay::getInstance('aa5ggrrtptd1wtjslhye', 'sk_9e70cba9e5bd4a55b4d53e72fda60cdc');



    $customer = array(
        "id" => "aa5ggrrtptd1wtjslhye",
        "name" => "Juan Carlos",
        "email"=> "jckarreno@yahoo.com.mx");

    $chargeRequest = array(
        'method' => 'card',
        'source_id' => 'kj4rfhrlcxhc8b356550',
        'amount' => 100,
        'currency' => 'MXN',
        'description' => 'Compra de boletos',
        'order_id' => 'bol-0001',
        'device_session_id' => $_POST["deviceIdField"],
        'customer' => $customer);

    $charge = $openpay->charges->create($chargeRequest);

   //print_r($customer);

   echo $charge->id.'<br />'.$charge->authorization;


    echo '<p>'.$_POST["deviceIdField"];

?>