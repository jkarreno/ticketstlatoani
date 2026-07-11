<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$cadena='<form name="fadcategoria" id="fadcategoria">
			<div class="tabla">
				<div class="titprin">
					Nueva Categoría
				</div>
				
				<div class="c20 c_derecha">
					Nombre:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="nombre" id="nombre">
                </div>
                
				<div class="c100 ccenter">
					<input type="hidden" name="hacer" id="hacer" value="agregar">
					<input type="submit" name="botadcategoria" id="botadcategoria" value="Agregar>>">
				</div>
			</div>
        </form>';
        
echo $cadena;

?>
<script>
$("#fadcategoria").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadcategoria"));

	$.ajax({
		url: "eventos/categorias.php",
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