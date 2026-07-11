<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");


$cadena='<form name="fadperfil" id="fadperfil">
			<div class="tabla">
				<div class="titprin">
					Nuevo Perfil
				</div>
				
				<div class="c20 c_derecha">
					Nombre:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="nombre" id="nombre">
				</div>
				
				<div class="c20 c_derecha">
					Código:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="codigo" id="codigo">
                </div>
                
                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="agregar">
					<input type="submit" name="botadperfil" id="botadperfil" value="Agregar>>">
				</div>
			</div>
        </form>';
        
echo $cadena;
?>
<script>
$("#fadperfil").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadperfil"));

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