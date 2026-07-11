<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResCat=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM cat_eventos WHERE Id='".$_POST["catego"]."' LIMIT 1"));

$cadena='<form name="feditcategoria" id="feditcategoria">
			<div class="tabla">
				<div class="titprin">
					Editar Categoría
				</div>
				
				<div class="c20 c_derecha">
					Nombre:
				</div>
				<div class="c80 ccenter">
                    <input type="text" name="nombre" id="nombre" value="'.$ResCat["Nombre"].'">
                    <input type="hidden" name="idcat" id="idcat" value="'.$ResCat["Id"].'"> 
                </div>
                
                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="editar">
					<input type="submit" name="boteditcategoria" id="boteditcategoria" value="Editar>>">
				</div>
			</div>
		</form>';
        
echo $cadena;

?>
<script>
$("#feditcategoria").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditcategoria"));

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