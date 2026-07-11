<?php
    //Inicio la sesion 
    session_start();

    if($_SESSION["autentificado"]!="SI")
    {
        header("Location: login.php?error=2"); 
    }

    include("gp/conexion.php");
    include("funciones.php");

    require_once('stripe/config.php');

    //registra en el carrito
    if(isset($_POST["bot_add_car"]))
    {

        //datos del evento
        $ResEvento=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM eventos WHERE Id='".$_POST["idevento"]."' LIMIT 1"));

        //subtotal
        $subtotal=$ResEvento["Precio"]*$_POST["number"];

        //descuento
        $ResDescuento=mysqli_query($conn, "SELECT Descuento FROM desc_perfiles WHERE IdEvento='".$_POST["idevento"]."' AND IdPerfil='".$_SESSION["perfil"]."' LIMIT 1");

        

        if(mysqli_num_rows($ResDescuento)!=0)
        {
            $ResDesc=mysqli_fetch_array($ResDescuento);

            //aplica descuento
            if($ResDesc["Descuento"]>0)
            {
                $adescuento=1;
                //busca el max descuento de perfil
                $ResMaxPer=mysqli_query($conn, "SELECT * FROM max_perfiles WHERE IdEvento='".$_POST["idevento"]."' AND IdPerfil='".$_SESSION["perfil"]."' ");
                if(mysqli_num_rows($ResMaxPer)==1)
                {
                    $RResMP=mysqli_fetch_array($ResMaxPer);

                    $ventasp=mysqli_num_rows(mysqli_query($conn, "SELECT c.iduser FROM carrito as c 
                                                                    INNER JOIN usuarios AS u ON c.iduser=u.id 
                                                                    WHERE u.Perfil='".$_SESSION["perfil"]."' AND c.idevento='".$_POST["idevento"]."'"));

                    if($ventasp>=$RResMP["MaxBoletos"] AND $RResMP["MaxBoletos"]>0)
                    {
                        $adescuento=0;
                    }

                }

                if($adescuento==1)
                {
                    $descuento=($subtotal*$ResDesc["Descuento"])/100;
                    $idesc=$ResDesc["Descuento"];
                }
                else
                {
                    $descuento=0;
                    $idesc=0;
                }
            }
        

        }
        else
        {
            $descuento=0;
            $idesc=0;
        }

        //resta descuento
        $importe=$subtotal-$descuento;
        //crea el arreglo del evento
        //idevento, idusuario, numerodeboletos, precio de boleto, subtotal, total, descuento //
        $arreglo=array($ResEvento["Id"], $_SESSION["id"], $_POST["number"], $ResEvento["Precio"], $subtotal, $importe, $idesc);
        array_push($_SESSION["carrito"], $arreglo);

        print_r($arreglo);
    }
    //borra partida
    if(isset($_GET["b"]))
    {
        unset($_SESSION["carrito"][$_GET["b"]]);

        $_SESSION["carrito"] = array_values($_SESSION["carrito"]);
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
            <div class="tit_id">#</div>
            <div class="tit_evento">Evento</div>
            <div class="tit_fecha">Fecha</div>
            <div class="tit_boletos">Boletos</div>
            <div class="tit_subtotal">Subtotal</div>
            <div class="tit_descuento">Descuento</div>
            <div class="tit_importe">Importe</div>
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
                    <div class="par_id" style="background-color: '.$background.';"><a href="carrito.php?b='.$i.'"><i class="fas fa-trash-alt"></i></a></div>
                    <div class="par_evento" style="background-color: '.$background.';">'.$ResEve["NombreEvento"].'</div>
                    <div class="par_fecha" style="background-color: '.$background.';">'.fecha($ResEve["FechaEvento"]).'</div>
                    <div class="par_boletos" style="background-color: '.$background.';">'.$value[2].'<span id="txt_boletos"> Boletos</span></div>
                    <div class="par_subtotal" style="background-color: '.$background.';">'.number_format($value[4],2).'</div>
                    <div class="par_descuento" style="background-color: '.$background.';">'.$value[6].' %</div>
                    <div class="par_importe" style="background-color: '.$background.';">'.number_format($value[5],2).'</div>';

                    $total=$total+$value[5];
                    $i++;
                    if($background=='#ffffff'){$background='#eeeff4';}
                    elseif($background=='#eeeff4'){$background='#ffffff';}
                }

                //$ResCarrito=mysqli_query($conn, "SELECT * FROM carrito WHERE iduser='".$_SESSION["id"]."' AND status='0' ORDER BY id ASC");
                //while($RResC=mysqli_fetch_array($ResCarrito))
                //{
                //    $ResE=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM eventos WHERE Id='".$RResC["idevento"]."' LIMIT 1"));
                //    echo '<div class="par_id"><i class="fas fa-trash-alt"></i></div>
                //        <div class="par_evento">'.$ResE["NombreEvento"].'</div>
                //        <div class="par_fecha">'.fecha($ResE["FechaEvento"]).'</div>
                //        <div class="par_boletos">'.$RResC["numboletos"].'<span id="txt_boletos"> Boletos</span></div>
                //        <div class="par_subtotal">'.number_format(($RResC["total"]),2).'</div>';
//
                //    $total=$total+$RResC["total"];
                //}

                $totalstripe=explode('.', number_format($total,2));
                $_SESSION["totalstripe"]=$totalstripe[0].$totalstripe[1];
            ?>
        </div>
        <div class="tot_carrito">
            <div class="tot_tit">Total: </div>
            <div class="tot_cos">
                <?php echo number_format($total, 2); ?><br />
                <form action="cargo.php" method="post">
                    <script src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                        data-key="<?php echo $stripe['publishable_key']; ?>"
                        data-description="Compra boletos"
                        data-amount="<?echo $_SESSION["totalstripe"];?>"
                        data-currency="mxn"
                        data-label="Comprar Boletos"
                        data-locale="auto">
                    </script>
                </form>
            </div>
        </div>

    </section>

    <?php echo "SELECT Descuento FROM desc_perfiles WHERE IdEvento='".$_POST["idevento"]."' AND IdPerfil='".$_SESSION["Perfil"]."' LIMIT 1";?>


    <div class="welcome"><a href="index.php"><img src="images/logotlatoani.jpg" border="0"></a></div>

    <style>
    .stripe-button-el span {
        background: #4CAF50; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        height: auto;
        line-height: 20px;
        text-shadow: none;
        box-shadow: none;
        border-radius: 0;
    }
    </style>
</body>
</html>