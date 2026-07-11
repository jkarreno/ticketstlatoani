<?php
include("gp/conexion.php");
include("funciones.php");

$ResLugar=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM lugar_eventos WHERE Id='".$_POST["lugar"]."' LIMIT 1"));

$cadena.='<div class="det_lugar">
            <h1><i class="fas fa-landmark"></i> '.$ResLugar["Nombre"].'</h1>
            <div class="det_lugar_dir">
                <p><i class="fas fa-map-marker-alt"></i> '.$ResLugar["Direccion"].'</p>
                <p><img src="gp/images/lugares/'.$ResLugar["Imagen"].'" style="width: 100%"></p>
            </div>
            <div class="det_lugar_map">
            <iframe src="'.$ResLugar["Url_mapa"].'" 
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
            <div class="det_lugar_mas">
                <a href="index.php?lugar='.$_POST["lugar"].'">Ver mas eventos en este lugar</a>
            </div>
        </div>';

echo $cadena;

?>