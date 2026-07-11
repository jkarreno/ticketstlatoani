<?php
//Inicio la sesion 
session_start();

include("gp/conexion.php");
include("funciones.php");

require(dirname(__FILE__) . '/openpay/Openpay.php');

Openpay::setId('mskbfzpej69y7rgqveqn');
Openpay::setApiKey('sk_9e70cba9e5bd4a55b4d53e72fda60cdc');

$openpay = Openpay::getInstance('mskbfzpej69y7rgqveqn', 'sk_9e70cba9e5bd4a55b4d53e72fda60cdc');

if($_POST["hacer"]=='adcard')
{
    //obtener idopenpay del cliente
    $ResIdOP=mysqli_fetch_array(mysqli_query($conn, "SELECT Id_openpay FROM usuarios WHERE id='".$_POST["iduser"]."' LIMIT 1"));

    //guarda la tarjeta
    $cardDataRequest = array(
        'holder_name' => $_POST["nombre"],
        'card_number' => str_replace(' ', '', $_POST["numcard"]),
        'cvv2' => $_POST["cvc"],
        'expiration_month' => $_POST["fechaexp"][0].$_POST["fechaexp"][1],
        'expiration_year' => $_POST["fechaexp"][3].$_POST["fechaexp"][4]);
    
    $customer = $openpay->customers->get($ResIdOP["Id_openpay"]);
    $card = $customer->cards->add($cardDataRequest);

    //guardamos el id de la tarjeta
    mysqli_query($conn, "UPDATE usuarios SET Id_openpay_card='".$card->id."' WHERE id='".$_POST["iduser"]."'");
}

?>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Tickets Tlatoani</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	
	
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="estilos/estilos.css">
	<link rel="stylesheet" href="estilos/estilos_index.css">
	<link rel="stylesheet" href="estilos/estilos_micuenta.css">
	
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://kit.fontawesome.com/2df1cf6d50.js" crossorigin="anonymous"></script>
	<script src="js/codigo.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous"></script>

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

    <section class="micuenta">

	<?php
	
		echo '<form name="fadcard" id="fadcard" method="POST" action="registracard.php">
		<div class="tabla">
			<div class="titprin">
				Registrar una tarjeta
			</div>
			
			<div class="c20 c_derecha">
				Nombre:
			</div>
			<div class="c80 ccenter">
				<input type="text" name="nombre" id="nombre" placeholder="Nombre como aparece en la tarjeta">
			</div>
            
            <div class="c20 c_derecha">
				Numero de la tarjeta:
			</div>
			<div class="c80 ccenter">
				<input type="text" name="numcard" id="numcard" class="input-card" placeholder="**** **** **** ****">
			</div>
			
			<div class="c20 c_derecha">
				Fecha de Expiración:
			</div>
			<div class="c30 ccenter">
				<input type="text" name="fechaexp" id="fechaexp" class="input-fechaexp" placeholder="mm/aa">
			</div>
			<div class="c20 c_derecha">
				CVC: 
			</div>
			<div class="c30 ccenter">
				<input type="text" name="cvc" id="cvc" class="input-cvc" placeholder="###">
			</div>
			
			<div class="c100 ccenter">
                <input type="hidden" name="hacer" id="hacer" value="adcard">
                <input type="hidden" name="iduser" id="iduser" value="'.$_SESSION["id"].'">
				<input type="button" name="botadcard" id="botadcard" value="Guardar>>" onclick="javascript:valida_registro_tarjeta()">
			</div>
		</div>
		</form>';
	
        
			
	?>
    </section>


    <div class="welcome"><a href="index.php"><img src="images/logotlatoani.jpg" border="0"></a></div>
    <script>
        var cleave = new Cleave('.input-card', {
            creditCard: true
        });
        var cleave = new Cleave('.input-fechaexp', {
            date: true,
            datePattern: ['m', 'y']
        });
        var cleave = new Cleave('.input-cvc', {
            blocks: [3]
        });
    </script>
</body>
</html>