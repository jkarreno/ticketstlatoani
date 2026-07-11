<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResCategoria=mysqli_fetch_array(mysqli_query($conn, "SELECT Id, Nombre FROM cat_eventos WHERE id='".$_POST["catego"]."'"));

$mensaje='<p align="center" class="textomensaje">Esta seguro de eliminar la categoría '.$ResCategoria["Nombre"].'<br />
            <a href="#" onclick="delete_catego_2(\''.$_POST["catego"].'\', \'borracat\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="categorias()">NO</a></p>';


$cadena='<div class="tabla">
				<div class="titprin">
					Eliminar Categoría
				</div>
				
				<div class="c100 ccenter">
					'.$mensaje.'
				</div>

				
            </div>';

echo $cadena;

?>
<script>
function delete_catego_2(categoria, borra){

    var catego = categoria;
    var hacer = borra;

    $.ajax({
                type: 'POST',
                url : 'eventos/categorias.php',
                data: 'hacer=' + hacer + '&categoria=' + catego
    }).done (function ( info ){
        $('#contenido').html(info);
    });
}

</script>