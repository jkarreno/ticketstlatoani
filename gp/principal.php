<?php 
//Inicio la sesion 
session_start();
//COMPRUEBA QUE EL USUARIO ESTA AUTENTIFICADO 
if ($_SESSION["autentificado"] != "SI") { 
    //si no existe, envio a la p?gina de autentificacion 
    header("Location: index.php"); 
    //ademas salgo de este script 
    exit(); 
} 

include ("conexion.php");


include ("funciones.php");


?>
<html>
<head>
	<meta charset="UTF-8" />
	<title>Administración</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	
	
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link rel="stylesheet" href="estilos/estilos.css">
	
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
				<div class="welcome">Bienvenido <?php echo $_SESSION["nombre"];?></div>
				<ul>
					<li><a href="principal.php"><i class="fa fa-home"></i>Inicio</a></li>
					
					<li class="submenu">
						<a href="#"><i class="fas fa-theater-masks"></i>Eventos<span class="caret fa fa-caret-down"></span></a>
						<ul class="children">
							<li><a href="#" onclick="categorias()"><span class="fas fa-layer-group"></span> Categorias</a></li>
							<li><a href="#" onclick="lugares()"><span class="fas fa-landmark"></span> Lugares</a></li>
							<li><a href="#" onclick="eventos()"><span class="fas fa-theater-masks"></span> Eventos</a></li>
						</ul>
					</li>

					<li class="submenu"><a href="#"><i class="fa fa-users"></i>Usuarios<span class="caret fa fa-caret-down"></span></a>
						<ul class="children">
							<li><a href="#" onclick="perfiles()"><span class="fa fa-users"></span> Perfiles</a></li>
							<li><a href="#" onclick="usuarios()"><span class="fa fa-users"></span> Usuarios</a></li>
						</ul>
					<li>
					
					<li><a href="logout.php"><i class="fa fa-close"></i>Salir</a></li>
				</ul>
			</nav>
		</header>
		
		<section class="contenido" id="contenido">
			
		</section>
</body>
</html>

<script>
function categorias(){
	$.ajax({
				type: 'POST',
				url : 'eventos/categorias.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function lugares(){
	$.ajax({
				type: 'POST',
				url : 'eventos/lugares.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function eventos(){
	$.ajax({
				type: 'POST',
				url : 'eventos/eventos.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function perfiles(){
	$.ajax({
				type: 'POST',
				url : 'usuarios/perfiles.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function usuarios(){
	$.ajax({
				type: 'POST',
				url : 'usuarios/usuarios.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
</script>