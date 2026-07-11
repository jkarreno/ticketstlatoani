<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResPerfil=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM perfiles_usuarios WHERE Id='".$_POST["perfil"]."'"));

$mensaje='<p align="center" class="textomensaje">Esta seguro de eliminar el perfil '.$ResPerfil["NombrePerfil"].'<br />
            <a href="#" onclick="delete_perfil_2(\''.$_POST["perfil"].'\', \'borra\')">SI</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" onclick="perfiles()">NO</a></p>';

$cadena='<div class="tabla">
				<div class="titprin">
					Eliminar Perfil
				</div>
				
				<div class="c100 ccenter">
					'.$mensaje.'
				</div>

				
            </div>';

echo $cadena;

?>
<script>
function delete_perfil_2(perfil, borra){

    var perfil = perfil;
    var hacer = borra;

    $.ajax({
                type: 'POST',
                url : 'usuarios/perfiles.php',
                data: 'hacer=' + hacer + '&perfil=' + perfil
    }).done (function ( info ){
        $('#contenido').html(info);
    });
}

</script>