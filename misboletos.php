<?php
    //Inicio la sesion 
    session_start();

    if($_SESSION["autentificado"]!="SI")
    {
        header("Location: login.php?error=2"); 
    }

    include("gp/conexion.php");
    include("funciones.php");

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

    <section class="sec_busqueda">
        <div>
            <form name="f_bus_evento" id="f_bus_evento">
                <input type="text" name="palabra" id="palabra" placeholder="Busca: evento, artista, lugar, etc."> <a href="#"><i class="fas fa-search"></i></a>
            </form>
        </div>
    </section>

    <section class="carrito">
        <div class="tits_carrito">
            <div class="tit_id_mb">#</div>
            <div class="tit_evento_mb">Evento</div>
            <div class="tit_fecha_mb">Fecha</div>
            <div class="tit_boletos_mb">Boletos</div>
        </div>
        <div class="item_carrito">
            <?php
                $ResMisBoletos=mysqli_query($conn, "SELECT c.id, e.NombreEvento, e.FechaEvento, c.numboletos FROM `carrito` AS c
                                                    INNER JOIN eventos AS e ON c.idevento=e.Id
                                                    WHERE c.iduser='".$_SESSION["id"]."' AND e.FechaEvento>='".date("Y-m-d H:m:s")."'");

                $background='#ffffff';
                while($RResMB=mysqli_fetch_array($ResMisBoletos))
                {
                    echo '
                    <div class="par_id_mb" style="background-color: '.$background.';"><a href="imprime_boletos.php?id='.$RResMB["id"].'" target="_blank"><i class="fas fa-ticket-alt"></i></a></div>
                    <div class="par_evento_mb" style="background-color: '.$background.';">'.$RResMB["NombreEvento"].'</div>
                    <div class="par_fecha_mb" style="background-color: '.$background.';">'.fecha($RResMB["FechaEvento"]).'</div>
                    <div class="par_boletos_mb" style="background-color: '.$background.';">'.$RResMB["numboletos"].'<span id="txt_boletos"> Boletos</span></div>';

                    if($background=='#ffffff'){$background='#eeeff4';}
                    elseif($background=='#eeeff4'){$background='#ffffff';}
                }
            ?>
        </div>

    </section>

    <div class="welcome"><a href="index.php"><img src="images/logotlatoani.jpg" border="0"></a></div>
</body>
</html>