<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResUsuario=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM usuarios WHERE id='".$_POST["usuario"]."' LIMIT 1"));

$cadena='<form name="feditusuario" id="feditusuario">
			<div class="tabla">
				<div class="titprin">
					Editar Usuario
				</div>
				
				<div class="c20 c_derecha">
					Nombre:
				</div>
				<div class="c80 ccenter">
					'.$ResUsuario["Nombre"].'
                </div>

                <div class="c20 c_derecha">
					Correo electrónico:
				</div>
				<div class="c80 ccenter">
					'.$ResUsuario["CorreoE"].'
                </div>

                <div class="c20 c_derecha">
					Perfil:
				</div>
                <div class="c80 c_derecha">
					<select name="perfil" id="perfil">
						<option value="">Seleccione</option>';
					//consulta los perfiles
    				$ResPerfiles=mysqli_query($conn, "SELECT * FROM perfiles_usuarios ORDER BY NombrePerfil ASC");
    				while($RResPerfiles=mysqli_fetch_array($ResPerfiles))
    				{
						$cadena.='<option value="'.$RResPerfiles["Id"].'"';if($RResPerfiles["Id"]==$ResUsuario["Perfil"]){$cadena.=' selected';}$cadena.='>'.$RResPerfiles["NombrePerfil"].'</option>';
					}
	$cadena.='		</select>
				</div>
                
				<div class="c100 ccenter">
					<input type="hidden" name="hacer" id="hacer" value="editar">
					<input type="hidden" name="idusuario" id="idusuario" value="'.$ResUsuario["id"].'">
					<input type="submit" name="boteditusaurio" id="boteditusuario" value="Editar>>">
				</div>
			</div>
    </form>';
    
    echo $cadena;

    ?>
	<script>
$("#feditusuario").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditusuario"));

	$.ajax({
		url: "usuarios/usuarios.php",
		type: "POST",
		dataType: "HTML",
		data: formData,
		cache: false,
		contentType: false,
		processData: false
	}).done(function(echo){
		$("#contenido").html(echo);
	});
});
</script>