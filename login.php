<?php
    //Inicio la sesion 
	session_start();
	
	include("gp/conexion.php");
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
			if($_GET["error"]==1)
			{
				echo '<div class="error"><p>Nombre de usuario o contraseña no valido</p></div>';
			}
			elseif($_GET["error"]==2)
			{
				echo '<div class="error"><p>Para poder comprar cualquier ticket, es necesario ingresar a tu cuenta</p></div>';
			}
		?>
        <form name="flogin" id="flogin" method="POST" action="validausuario.php">
	    	<div class="tabla">
	    		<div class="titprin">
	    			Ingresar
	    		</div>
                        
	    		<div class="c20 c_derecha">
	    			Usuario:
	    		</div>
	    		<div class="c80 ccenter">
	    			<input type="text" name="username" id="username">
	    		</div>
	    		<div class="c20 c_derecha">
	    			Contraseña
	    		</div>
	    		<div class="c80 ccenter">
	    			<input type="password" name="contrasena" id="contrasena">
	    		</div>
                    
	    		<div class="c100 ccenter">
	    			<input type="submit" name="botadcuenta" id="botadcuenta" value="Ingresar >>">
	    		</div>
	    	</div>
	    	</form>
        </section>

        <div class="welcome"><a href="index.php"><img src="images/logotlatoani.jpg" border="0"></a></div>
</body>
</html>