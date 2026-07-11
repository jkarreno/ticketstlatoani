<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResPerfil=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM perfiles_usuarios WHERE Id='".$_POST["perfil"]."' LIMIT 1"));

    $cadena='<form name="feditperfil" id="feditperfil">
			<div class="tabla">
				<div class="titprin">
					Editar Perfil
				</div>
				
				<div class="c20 c_derecha">
					Nombre:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="nombre" id="nombre" value="'.$ResPerfil["NombrePerfil"].'">
				</div>
				
				<div class="c20 c_derecha">
					Código:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="codigo" id="codigo" value="'.$ResPerfil["Codigo"].'">
                </div>
                
                <div class="c100 ccenter">
                    <input type="hidden" name="idperfil" id="idperfil" value="'.$ResPerfil["Id"].'">
                    <input type="hidden" name="hacer" id="hacer" value="editar">
					<input type="submit" name="boteditperfil" id="boteditperfil" value="Editar>>">
				</div>
			</div>
        </form>';
        
    echo $cadena;
?>
<script>
$("#feditperfil").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditperfil"));

	$.ajax({
		url: "usuarios/perfiles.php",
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