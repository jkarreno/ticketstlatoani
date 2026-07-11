<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResUsuario=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE id='".$_POST["usuario"]."'"));

$mensaje='<p align="center" class="textomensaje">Esta seguro de eliminar el usuario '.$ResUsuario["Nombre"].'<br />
            <a href="#" onclick="delete_usuario_2(\''.$_POST["usuario"].'\', \'borra\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="usuarios()">NO</a></p>';

$cadena='<div class="tabla">
				<div class="titprin">
					Eliminar Usuario
				</div>
				
				<div class="c100 ccenter">
					'.$mensaje.'
				</div>

				
            </div>';

echo $cadena;

?>
<script>
function delete_usuario_2(usuario, borra){

    var usuario = usuario;
    var hacer = borra;

    $.ajax({
                type: 'POST',
                url : 'usuarios/usuarios.php',
                data: 'hacer=' + hacer + '&usuario=' + usuario
    }).done (function ( info ){
        $('#contenido').html(info);
    });
}

</script>