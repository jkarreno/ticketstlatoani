<?php
    //Inicio la sesion 
    session_start();

    include("gp/conexion.php");

    require(dirname(__FILE__) . '/openpay/Openpay.php');

    Openpay::setId('mskbfzpej69y7rgqveqn');
    Openpay::setApiKey('sk_9e70cba9e5bd4a55b4d53e72fda60cdc');

    $openpay = Openpay::getInstance('mskbfzpej69y7rgqveqn', 'sk_9e70cba9e5bd4a55b4d53e72fda60cdc');

    //datos del comprador
    $ResCliente=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE id='".$_SESSION["id"]."' LIMIT 1"));


$customer = array(
     'name' => $ResCliente["Nombre"],
     'last_name' => $ResCliente["Apellido"],
     'phone_number' => $ResCliente["Telefono"],
     'email' => $ResCliente["CorreoE"]);

$chargeRequest = array(
    "method" => "card",
    'amount' => $_GET["total"],
    'description' => 'Compra de tickets de eventos',
    'customer' => $customer,
    'send_email' => false,
    'confirm' => false,
    'redirect_url' => 'http://ticketstlatoani.xyz/comprado.php')
;

$charge = $openpay->charges->create($chargeRequest);

//print_r($charge);

//echo $charge->serializableData["payment_method"]->url;

header("Location: ".$charge->serializableData["payment_method"]->url);
?>