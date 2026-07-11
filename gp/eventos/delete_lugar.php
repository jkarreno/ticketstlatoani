<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResLugares=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Nombre FROM lugar_eventos WHERE id='".$_POST["lugar"]."'"));

$mensaje='<p align="center" class="textomensaje">Esta seguro de eliminar el lugar '.$ResLugares["Nombre"].'<br />
				<a href="#" onclick="delete_lugar_2(\''.$_POST["lugar"].'\', \'borrar\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="lugares()">NO</a></p>';


$cadena='<div class="tabla">
				<div class="titprin">
					Eliminar Lugar
				</div>
				
				<div class="c100 ccenter">
					'.$mensaje.'
				</div>

				
            </div>';

echo $cadena;

?>
<script>
function delete_lugar_2(lugar, borra){

    var lugar = lugar;
    var hacer = borra;

    $.ajax({
                type: 'POST',
                url : 'eventos/lugares.php',
                data: 'hacer=' + hacer + '&lugar=' + lugar
    }).done (function ( info ){
        $('#contenido').html(info);
    });
}
