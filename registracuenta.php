<?php
    //Inicio la sesion 
    session_start();

    include("gp/conexion.php");
	include("funciones.php");

	require(dirname(__FILE__) . '/openpay/Openpay.php');

    Openpay::setId('mskbfzpej69y7rgqveqn');
    Openpay::setApiKey('sk_9e70cba9e5bd4a55b4d53e72fda60cdc');

    $openpay = Openpay::getInstance('mskbfzpej69y7rgqveqn', 'sk_9e70cba9e5bd4a55b4d53e72fda60cdc');

	if($_POST["hacer"]=='adusuario')
	{
		//busca el perfil
		if($_POST["codpromo"]==''){$_POST["codpromo"]='PG';}
		$ResP=mysqli_fetch_array(mysqli_query($conn, "SELECT Id FROM perfiles_usuarios WHERE Codigo='".strtoupper($_POST["codpromo"])."' LIMIT 1"));
		//registra la cuenta
		mysqli_query($conn, "INSERT INTO usuarios (Nombre, Apellido, Usuario, Contrasena, CorreoE, Telefono, Perfil)
											VALUES ('".$_POST["nombre"]."', '".$_POST["apellido"]."', '".$_POST["username"]."', 
													'".md5($_POST["contrasena"])."', '".$_POST["correoe"]."',
													'".$_POST["telefono"]."', '".$ResP["Id"]."')");

		//crea la sesión
		$Rowrs = mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE Usuario='".$_POST["username"]."' and Contrasena='".md5($_POST["contrasena"])."'")) ;

		//session_start(); 
		//session_register("autentificado"); 
		$_SESSION["autentificado"] = "SI"; 
		$_SESSION["perfil"] = $Rowrs["Perfil"];
		$_SESSION["nombre"] = $Rowrs["Nombre"];
		$_SESSION["id"] = $Rowrs["id"];

		//crear cliente en openpay
		$customerData = array(
			'name' => $_POST["nombre"],
			'last_name' => $_POST["apellido"],
			'email' => $_POST["correoe"],
			'requires_account' => false,
			'phone_number' => $_POST["telefono"]
		);
	
		$customer = $openpay->customers->add($customerData);

		mysqli_query($conn, "UPDATE usuarios SET Id_openpay='".$customer->id."' WHERE id='".$_SESSION["id"]."'");


		header ("Location: index.php"); 
	}
	if(isset($_POST["boteditcuenta"]))
	{
		$ResP=mysqli_fetch_array(mysqli_query($conn, "SELECT Id FROM perfiles_usuarios WHERE Codigo='".strtoupper($_POST["codpromo"])."' LIMIT 1"));

		$sql="UPDATE usuarios SET Nombre='".$_POST["nombre"]."',
									Apellido='".$_POST["apellido"]."',
									Usuario='".$_POST["username"]."', ";
		if($_POST["contrasena"]!=''){ $sql.="Contrasena='".$_POST["contrasena"]."', ";}
		$sql.="						CorreoE='".$_POST["correoe"]."',
									Telefono='".$_POST["telefono"]."',
									Perfil='".$ResP["Id"]."'
							WHERE id='".$_SESSION["id"]."'";
		
		mysqli_query($conn, $sql);

		//editamos el cliente en openpay
		$ResU=mysqli_fetch_array(mysqli_query($conn, "SELECT Id_openpay FROM usuarios WHERE id='".$_SESSION["id"]."'"));

		if($ResU["Id_openpay"]!='')
		{
			$customer = $openpay->customers->get($ResU["Id_openpay"]);
			$customer->name = $_POST["nombre"];
			$customer->last_name = $_POST["apellido"];
			$customer->email = $_POST["correoe"];
			$customer->phone_number = $_POST["Telefono"];
			$customer->save();
		}

		header ("Location: index.php");
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
	if($_SESSION["autentificado"] == "SI")
	{
		$ResCuenta=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE id='".$_SESSION["id"]."' LIMIT 1"));

		$ResP=mysqli_fetch_array(mysqli_query($conn, "SELECT Codigo FROM perfiles_usuarios WHERE Id='".$ResCuenta["Perfil"]."' LIMIT 1"));

		echo '<form name="fadusuario" id="fadusuario" method="POST" action="registracuenta.php">
		<div class="tabla">
			<div class="titprin">
				Modificar tu cuenta
			</div>
			
			<div class="c20 c_derecha">
				Nombres:
			</div>
			<div class="c30 ccenter">
				<input type="text" name="nombre" id="nombre" value="'.$ResCuenta["Nombre"].'">
			</div>
			<div class="c20 c_derecha">
				Apellidos:
			</div>
			<div class="c30 ccenter">
				<input type="text" name="apellido" id="apellido" value="'.$ResCuenta["Apellido"].'">
			</div>
			
			<div class="c20 c_derecha">
				Nombre de usuario:
			</div>
			<div class="c30 ccenter">
				<input type="text" name="username" id="username" value="'.$ResCuenta["Usuario"].'">
			</div>
			<div class="c20 c_derecha">
				Contraseña
			</div>
			<div class="c30 ccenter">
				<input type="text" name="contrasena" id="contrasena">
			</div>

			<div class="c20 c_derecha">
				Correo electrónico:
			</div>
			<div class="c80 ccenter">
				<input type="text" name="correoe" id="correoe" value="'.$ResCuenta["CorreoE"].'">
			</div>

			<div class="c20 c_derecha">
				Teléfono móvil:
			</div>
			<div class="c80 ccenter">
				<input type="text" name="telefono" id="telefono" value="'.$ResCuenta["Telefono"].'">
			</div>

			<div class="c20 c_derecha">
				Código Promoción:
			</div>
			<div class="c80 c_derecha">
				<input type="text" id="codpromo" name="codpromo" value="'.$ResP["Codigo"].'">
			</div>

			
			
			<div class="c100 ccenter">
				<input type="submit" name="boteditcuenta" id="boteditcuenta" value="Editar Cuenta>>">
			</div>
		</div>
		</form>';
	}
	else
	{
		echo '<form name="fadusuario" id="fadusuario" method="POST" action="registracuenta.php">
		<div class="tabla">
			<div class="titprin">
				Crear una cuenta
			</div>
			
			<div class="c20 c_derecha">
				Nombres:
			</div>
			<div class="c30 ccenter">
				<input type="text" name="nombre" id="nombre">
			</div>
			<div class="c20 c_derecha">
				Apellidos:
			</div>
			<div class="c30 ccenter">
				<input type="text" name="apellido" id="apellido">
			</div>
			
			<div class="c20 c_derecha">
				Nombre de usuario:
			</div>
			<div class="c30 ccenter">
				<input type="text" name="username" id="username">
			</div>
			<div class="c20 c_derecha">
				Contraseña
			</div>
			<div class="c30 ccenter">
				<input type="text" name="contrasena" id="contrasena">
			</div>

			<div class="c20 c_derecha">
				Correo electrónico:
			</div>
			<div class="c80 ccenter">
				<input type="text" name="correoe" id="correoe">
			</div>

			<div class="c20 c_derecha">
				Teléfono móvil:
			</div>
			<div class="c80 ccenter">
				<input type="text" name="telefono" id="telefono">
			</div>

			<div class="c20 c_derecha">
				Código Promoción:
			</div>
			<div class="c80 c_derecha">
				<input type="text" id="codpromo" name="codpromo">
			</div>
			
			<div class="c100 ccenter">
				<input type="hidden" name="hacer" id="hacer" value="adusuario">
				<input type="button" name="botadcuenta" id="botadcuenta" value="Registrarme>>" onclick="javascript:valida_formulario_registro()">
			</div>
		</div>
		</form>';
	}
        
			
	?>
    </section>


    <div class="welcome"><a href="index.php"><img src="images/logotlatoani.jpg" border="0"></a></div>
</body>
</html>