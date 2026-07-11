<?php
date_default_timezone_set('America/Mexico_City');
//Inicio la sesion 
session_start();

if($_SESSION["autentificado"]!="SI")
{
    header("Location: login.php?error=2"); 
}

include("gp/conexion.php");
include("funciones.php");
require_once('stripe/config.php');

$token  = $_POST['stripeToken'];
$email  = $_POST['stripeEmail'];

$customer = \Stripe\Customer::create([
    'email' => $email,
    'name' => $_SESSION["nombre"],
    'source'  => $token,
]);

$charge = \Stripe\Charge::create([
    'customer' => $customer->id,
    'amount'   => $_SESSION["totalstripe"],
    'currency' => 'mxn',
]);

$cargo = $charge->id;

//guardar boletos
foreach ($_SESSION["carrito"] as $value)
{
    mysqli_query($conn, "INSERT INTO carrito (idevento, iduser, numboletos, costounitario, subtotal, descuento, total, fecha, estatus, idtransaccion)
                                        VALUES ('".$value[0]."', '".$_SESSION["id"]."', '".$value[2]."', '".$value[3]."', '".$value[4]."', '".$value[6]."',
                                                '".number_format($value[5],2)."', '".date("Y-m-d h:m:s")."', '1', '".$cargo."')") or die(mysqli_error($conn));

    $idticket=mysqli_insert_id($conn);                                                
}

?>
<html>
<head>
	<meta charset="UTF-8" />
	<title>comediatropolis</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	
	
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="estilos/estilos.css">
	<link rel="stylesheet" href="estilos/estilos_index.css">
	<link rel="stylesheet" href="estilos/estilos_carrito.css">
	
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://kit.fontawesome.com/2df1cf6d50.js" crossorigin="anonymous"></script>
	<script src="js/codigo.js"></script>

</head>
<body>
    <header>
        <div class="menu_bar">
				<a href="#" class="bt-menu"><span class="fa fa-bars"></span><?php echo $_SESSION["nombre"];?> </a>
			</div>
			
			<nav>
				
				<ul>
                    <li><a href="index.php"><i class="fa fa-home"></i></a></li>
                    <li class="submenu">
						<a href="#">Categorías<span class="caret fa fa-caret-down"></span></a>
						<ul class="children">
                            <li><a href="index.php">Todas</a></li>
                        <?php
                            $ResCategorias=mysqli_query($conn, "SELECT * FROM cat_eventos ORDER BY Nombre ASC");
                            while($RResCat=mysqli_fetch_array($ResCategorias))
                            {
                                echo '<li><a href="index.php?cat='.$RResCat["Id"].'">'.$RResCat["Nombre"].'</a></li>';
                            }
                        ?>
						</ul>
					</li>

					<?php
						if($_SESSION["autentificado"]=="SI")
						{
							echo '<li class="submenu"><a href="#">Mi Cuenta<span class="caret fa fa-caret-down"></span></a>
								<ul class="children">
									<li><a href="registracuenta.php">Editar</a></li>
									<li><a href="logout.php">Salir</a></li>
								</ul>
							</li>';
						}
						else
						{
							echo '<li class="submenu"><a href="#">Mi Cuenta<span class="caret fa fa-caret-down"></span></a>
								<ul class="children">
									<li><a href="login.php">Ingresar</a></li>
									<li><a href="registracuenta.php">Registrarme</a></li>
								</ul>
							</li>';
						}
					?>
					<li><a href="carrito.php"><i class="fas fa-shopping-cart"></i></a></li>
				</ul>
			</nav>
    </header>

    <?php
            if($_SESSION["autentificado"] == "SI")
            {
                $ResU=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM usuarios WHERE id='".$_SESSION["id"]."' LIMIT 1"));

                echo '<div class="bienvenido">
                    <p>'.$ResU["Nombre"].'</p>
                </div>';
            }
    ?>

<section class="carrito">
        <div class="pago_ok">
            <h1>Tu pago fue registrado</h1>
            <h2>Puedes descargar tus boletos <a href="imprime_boletos.php?id=<?php echo $idticket;?>" target="_blank">aqui</a> </h2>
        </div>
        <div class="tits_carrito">
            <div class="tit_id">#</div>
            <div class="tit_evento">Evento</div>
            <div class="tit_fecha">Fecha</div>
            <div class="tit_boletos">Boletos</div>
            <div class="tit_subtotal">Importe</div>
        </div>
        <div class="item_carrito">
            <?php
                

                //$productos = array("evento" => $_POST["idevento"], "cantidad" => $_POST["number"]);
                //array_push($_SESSION["basket"], $productos);
                //
//
                $i=0; $background='#ffffff';
                foreach ($_SESSION["carrito"] as $value) {
                    $ResEve=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM eventos WHERE id='".$value[0]."' LIMIT 1"));

                    echo '
                    <div class="par_id" style="background-color: '.$background.';"><a href="#"><i class="fas fa-ticket-alt"></i></a></div>
                    <div class="par_evento" style="background-color: '.$background.';">'.$ResEve["NombreEvento"].'</div>
                    <div class="par_fecha" style="background-color: '.$background.';">'.fecha($ResEve["FechaEvento"]).'</div>
                    <div class="par_boletos" style="background-color: '.$background.';">'.$value[2].'<span id="txt_boletos"> Boletos</span></div>
                    <div class="par_subtotal" style="background-color: '.$background.';">'.number_format($value[5],2).'</div>';

                    $total=$total+$value[5];
                    if($background=='#ffffff'){$background='#eeeff4';}
                    elseif($background=='#eeeff4'){$background='#ffffff';}
                    //limpiar carrito
                    unset($_SESSION["carrito"][$i]);
                    $i++;
                }


                
            ?>
        </div>
    </section>

<div class="welcome"><a href="index.php"><img src="images/logotlatoani.jpg" border="0"></a></div>


</body>
</html>