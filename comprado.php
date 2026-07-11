<?php
//Inicio la sesion 
session_start();

if($_SESSION["autentificado"]!="SI")
{
    header("Location: login.php?error=2"); 
}

include("gp/conexion.php");
include("funciones.php");

require(dirname(__FILE__) . '/openpay/Openpay.php');

Openpay::setId('mskbfzpej69y7rgqveqn');
Openpay::setApiKey('sk_9e70cba9e5bd4a55b4d53e72fda60cdc');

$openpay = Openpay::getInstance('mskbfzpej69y7rgqveqn', 'sk_9e70cba9e5bd4a55b4d53e72fda60cdc');

$charge = $openpay->charges->get($_GET["id"]);

//echo $charge->card->type;

//guarda la compra
//foreach ($_SESSION["carrito"] as $value) {
//    mysqli_query($conn, "INSERT INTO carrito (idevento, iduser, numboletos, costounitario, subtotal, total, fecha, status, Id_transaccion)
//                                VALUES ('".$value[0]."', '".$value[1]."', '".$value[2]."', '".$value[3]."', '".$value[4]."', '".$value[5]."', '".$value[6]."', '1', '".$_GET["id"]."')") or die(mysqli_error($conn));
//}


?>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Tickets Tlatoani</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	
	
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="estilos/estilos.css">
	<link rel="stylesheet" href="estilos/estilos_index.css">
	<link rel="stylesheet" href="estilos/estilos_carrito.css">
	
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://kit.fontawesome.com/2df1cf6d50.js" crossorigin="anonymous"></script>
	<script src="gp/js/codigo.js"></script>

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
                                    <li><a href="misboletos.php">Mis boletos</a></li>
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

    <section class="sec_busqueda">
        <div>
            <form name="f_bus_evento" id="f_bus_evento">
                <input type="text" name="palabra" id="palabra" placeholder="Busca: evento, artista, lugar, etc."> <a href="#"><i class="fas fa-search"></i></a>
            </form>
        </div>
    </section>

    <section class="carrito">
        <h1>Gracias por tu compra, esperamos que disfrutes de nuestras presentaciones</h1>
        <div class="tits_carrito">
            <div class="tit_gracias">Detalles de tu compra</div>
            <div class="tit_id">#</div>
            <div class="tit_evento">Evento</div>
            <div class="tit_fecha">Fecha</div>
            <div class="tit_boletos">Boletos</div>
            <div class="tit_subtotal">Subtotal</div>
        </div>
        <div class="item_carrito">
            <?php
                

                $i=1; $background='#ffffff';
                $ResCompra=mysqli_query($conn, "SELECT * FROM carrito WHERE status='1' AND Id_transaccion='".$_GET["id"]."' ORDER BY id ASC");
                while($RResC=mysqli_fetch_array($ResCompra)) 
                {
                    $ResEve=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM eventos WHERE id='".$RResC["idevento"]."' LIMIT 1"));

                    echo '
                    <div class="par_id" style="background-color: '.$background.';"><a href="boleto.php?boleto='.$RResC["id"].'" target="_blank"><i class="fas fa-print"></i></a></div>
                    <div class="par_evento" style="background-color: '.$background.';">'.$ResEve["NombreEvento"].'</div>
                    <div class="par_fecha" style="background-color: '.$background.';">'.fecha($ResEve["FechaEvento"]).'</div>
                    <div class="par_boletos" style="background-color: '.$background.';">'.$RResC["numboletos"].'<span id="txt_boletos"> Boletos</span></div>
                    <div class="par_subtotal" style="background-color: '.$background.';">'.number_format($RResC["total"],2).'</div>';

                    //$total=$total+$value[5];
                    $i++;
                    if($background=='#ffffff'){$background='#eeeff4';}
                    elseif($background=='#eeeff4'){$background='#ffffff';}
                }
            ?>
        </div>
    </section>

    <div class="welcome"><a href="index.php"><img src="images/logotlatoani.jpg" border="0"></a></div>
</body>
</html>