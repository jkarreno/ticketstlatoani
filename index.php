<?php
    //Inicio la sesion 
    session_start();

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
	
	<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
	<script src="https://kit.fontawesome.com/2df1cf6d50.js" crossorigin="anonymous"></script>
	<script src="gp/js/codigo.js"></script>

</head>
<body>
    <header>
        <?php
            if($_SESSION["autentificado"] == "SI")
            {
                $ResU=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM usuarios WHERE id='".$_SESSION["id"]."' LIMIT 1"));

                echo '<div class="bienvenido">
                    <p>'.$ResU["Nombre"].'</p>
                </div>';
            }
        ?>
            <div class="menu_bar">
				<a href="#" class="bt-menu"><span class="fa fa-bars"></span></a>
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
                                    <li><a href="registracard.php">Mi tarjeta de pago</a></li>
                                    <li><a href="#">Mis boletos</a></li>
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
    
        
    <section class="sec_busqueda">
        <div>
            <form name="f_bus_evento" id="f_bus_evento">
                <input type="text" name=" " id="palabra" placeholder="Busca: evento, artista, lugar, etc."> <a href="#"><i class="fas fa-search"></i></a>
            </form>
        </div>
    </section>
    <section class="eventos">
        
        <?php
            if(isset($_GET["cat"]))
            {
                $ResEventos=mysqli_query($conn, "SELECT * FROM eventos WHERE FechaEvento > '".date("Y-m-d H:i:s")."' AND CategoriaEvento='".$_GET["cat"]."' ORDER BY FechaEvento ASC ");

                $ResCategoria=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM cat_eventos WHERE Id='".$_GET["cat"]."' LIMIT 1"));

                echo '<div class="tit_catego"><h1>'.$ResCategoria["Nombre"].'</h1></div>';
            }
            elseif(isset($_GET["lugar"]))
            {
                $ResEventos=mysqli_query($conn, "SELECT * FROM eventos WHERE FechaEvento > '".date("Y-m-d H:i:s")."' AND LugarEvento='".$_GET["lugar"]."' ORDER BY FechaEvento ASC ");

                $ResLugar=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM lugar_eventos WHERE Id='".$_GET["lugar"]."' LIMIT 1"));

                echo '<div class="tit_catego"><h1>'.$ResLugar["Nombre"].'</h1></div>';
            }
            elseif(isset($_GET["fecha"]))
            {
                $ResEventos=mysqli_query($conn, "SELECT * FROM eventos WHERE FechaEvento LIKE '".$_GET["fecha"]."%' ORDER BY FechaEvento ASC ");

                echo '<div class="tit_catego"><h1>'.fecha($_GET["fecha"]).'</h1></div>';
            }
            else{
                $ResEventos=mysqli_query($conn, "SELECT * FROM eventos WHERE FechaEvento > '".date("Y-m-d H:i:s")."' ORDER BY FechaEvento ASC ");
                
            }

            while($RResE=mysqli_fetch_array($ResEventos))
            {
                echo '<div class="cardeventos" style="background-image: url(\'gp/eventos/images/eventos/'.$RResE["Imagen"].'\');" onclick="ira_evento(\''.$RResE["Id"].'\')">
                    <div class="dat_evento">
                        <h1><a href="evento.php?e='.$RResE["Id"].'"><i class="fas fa-ticket-alt"></i> '.$RResE["NombreEvento"].'</a></h1>
                        <p>'.$RResE["Descripcion"].'</p>
                        <p>'.fecha($RResE["FechaEvento"]).'</p>
                    </div>
                </div>';
            }
            
            
        ?>

    </section>
    <footer>
    </footer>

    <div class="welcome"><a href="index.php"><img src="images/logotlatoani.jpg" border="0"></a></div>
</body>
</html>
<script>
function ira_evento(evento){
    window.location.href = "evento.php?e=" + evento;
}
</script>
