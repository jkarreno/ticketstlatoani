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
	<link rel="stylesheet" href="estilos/estilos_eventos.css">
	
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

    <?php
            if($_SESSION["autentificado"] == "SI")
            {
                $ResU=mysqli_fetch_array(mysqli_query($conn, "SELECT Nombre FROM usuarios WHERE id='".$_SESSION["id"]."' LIMIT 1"));

                echo '<div class="bienvenido">
                    <p>'.$ResU["Nombre"].'</p>
                </div>';
            }
        ?>

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

    <?php
        $ResEvento=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM eventos WHERE Id='".$_GET["e"]."' LIMIT 1"));
        $ResCat=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM cat_eventos WHERE Id='".$ResEvento["CategoriaEvento"]."' LIMIT 1"));
        $ResLug=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Nombre FROM lugar_eventos WHERE Id='".$ResEvento["LugarEvento"]."' LIMIT 1"));
        $ResDescuento=mysqli_fetch_array(mysqli_query($conn, "SELECT Descuento FROM desc_perfiles WHERE IdEvento='".$_GET["e"]."' AND IdPerfil='".$_SESSION["perfil"]."' LIMIT 1"));
    
        $fecha=explode(' ', $ResEvento["FechaEvento"]);

        //calcula boletos disponibles
        $ResBol=mysqli_fetch_array(mysqli_query($conn, "SELECT SUM(numboletos) AS bolcomprados FROM carrito WHERE idevento='".$ResEvento["Id"]."'"));

        if($ResBol["bolcomprados"]!=NULL OR $ResBol["bolcomprados"]>0)
        {
            $disponibles=$ResEvento["Cupo"]-$ResBol["bolcomprados"];
        }
        else
        {
            $disponibles=$ResEvento["Cupo"];
        }

    echo '<div class="evento">
        <div class="img_evento">
            <img src="gp/eventos/images/eventos/'.$ResEvento["Imagen"].'" border="0">
        </div>
        <div class="det_evento">
            <h1>'.$ResEvento["NombreEvento"].'</h1>
            <h2><a href="index.php?fecha='.$fecha[0].'"><i class="fas fa-calendar-day"></i> '.fecha($ResEvento["FechaEvento"]).'</a></h2>
            <h3><a href="index.php?cat='.$ResCat["Id"].'"><i class="fas fa-folder-open"></i> '.$ResCat["Nombre"].'</a> | <a href="javascript:void(0);" onclick="limpiar(); abrirmodal(); ubicacion(\''.$ResLug["Id"].'\')"><i class="fas fa-map-marker"></i> '.$ResLug["Nombre"].'</a></h3>
            <div class="desc_eve">'.$ResEvento["Descripcion"].'</div>
            <div class="venta_boletos">
                <form name="fadboleto" id="fadboleto" method="POST" action="carrito.php">
                    <div class="tit_venta_boletos"><span>Boletos disponibles: </span><span>'.$disponibles.'</span></div>
                    <div class="tit_venta_boletos"><span>Costo: </span><span>$ '.number_format($ResEvento["Precio"], 2).'</span></div>';
    if($ResDescuento["Descuento"]>0)
    {
        $pdescuento=1;
        //busca el max descuento de perfil
        $ResMaxPer=mysqli_query($conn, "SELECT * FROM max_perfiles WHERE IdEvento='".$_GET["e"]."' AND IdPerfil='".$_SESSION["perfil"]."' ");
        if(mysqli_num_rows($ResMaxPer)==1)
        {
            $RResMP=mysqli_fetch_array($ResMaxPer);

            $ventasp=mysqli_num_rows(mysqli_query($conn, "SELECT c.iduser FROM carrito as c 
                                                            INNER JOIN usuarios AS u ON c.iduser=u.id 
                                                            WHERE u.Perfil='".$_SESSION["perfil"]."' AND c.idevento='".$_GET["e"]."'"));

            if($ventasp>=$RResMP["MaxBoletos"] AND $RResMP["MaxBoletos"]>0)
            {
                $pdescuento=0;
            }
            
        }

        if($pdescuento==1)
        {
            echo '  <div class="tit_venta_boletos"><span>Descuento: </span><span>'.$ResDescuento["Descuento"].' %</span></div>';
        }
        
    }
    echo '          <div class="tit_venta_boletos"><span>Cantidad: </span>
                        <span>
                            <div class="value-button" id="decrease" onclick="decreaseValue()" value="Decrease Value">-</div>
                            <input type="number" id="number" name="number" value="1" />
                            <div class="value-button" id="increase" onclick="increaseValue()" value="Increase Value">+</div>
                        </span> 
                    </div>
                    <input type="hidden" name="idevento" id="idevento" value="'.$ResEvento["Id"].'">
                    <input type="submit" name="bot_add_car" id="bot_add_car" value="Agregar al carrito">
                </form>
            </div>
        </div>
    </div>';

    ?>

    <div class="welcome"><a href="index.php"><img src="images/logotlatoani.jpg" border="0"></a></div>

    <!-- The Modal -->
    <div id="myModal" class="modal">

        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-body" id="modal-body">
    
            </div>
    
        </div>
    </div>


<script>
//definimos el modal
var modal = document.getElementById('myModal');

function limpiar(){
    document.getElementById("modal-body").innerHTML="";
}

function abrirmodal(){
	modal.style.display = "block";
}
function cerrarmodal(){
	modal.style.display = "none";
}
// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
	if (event.target == modal) {
		modal.style.display = "none";
	}
}

function ubicacion(lugar)
{
    $.ajax({
				type: 'POST',
				url : 'lugar.php',
                data: 'lugar=' + lugar
	}).done (function ( info ){
		$('#modal-body').html(info);
	});
}

function increaseValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    value++;
    document.getElementById('number').value = value;
}

function decreaseValue() {
    var value = parseInt(document.getElementById('number').value, 10);
    value = isNaN(value) ? 0 : value;
    value < 1 ? value = 1 : '';
    value--;
    document.getElementById('number').value = value;
}
</script>


</body>
</html>