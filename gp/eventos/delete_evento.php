<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResEvento=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, NombreEvento FROM eventos WHERE Id='".$_POST["evento"]."'"));

$mensaje='<p align="center" class="textomensaje">Esta seguro de eliminar el evento '.$ResEvento["NombreEvento"].'<br />
				<a href="#" onclick="delete_evento_2(\''.$_POST["evento"].'\', \'borrar\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="eventos()">NO</a></p>';


$cadena='<div class="tabla">
				<div class="titprin">
					Eliminar Evento
				</div>
				
				<div class="c100 ccenter">
					'.$mensaje.'
				</div>

				
            </div>';

echo $cadena;

?>
<script>
function delete_evento_2(evento, borra){

    var evento = evento;
    var hacer = borra;

    $.ajax({
                type: 'POST',
                url : 'eventos/eventos.php',
                data: 'hacer=' + hacer + '&evento=' + evento
    }).done (function ( info ){
        $('#contenido').html(info);
    });
}
</script>
