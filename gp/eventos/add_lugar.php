<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$cadena.='<form name="fadlugar" id="fadlugar" method="POST" enctype="multipart/form-data">
        <div class="tabla">
            <div class="titprin">
                Nuevo Lugar
            </div>

            <div class="c20 c_derecha">
                Nombre:
            </div>
            <div class="c80 ccenter">
                <input type="text" name="nombre" id="nombre">
            </div>

            <div class="c20 c_derecha">
                Dirección:
            </div>
            <div class="c80 ccenter">
                <input type="text" name="direccion" id="direccion">
            </div>

            <div class="c20 c_derecha">
                Telefono:
            </div>
            <div class="c80 ccenter">
                <input type="text" name="telefono" id="telefono">
            </div>

            <div class="c20 c_derecha">
                Url mapa:
            </div>
            <div class="c80 ccenter">
                <input type="text" name="mapa" id="mapa">
            </div>

            <div class="c20 c_derecha">
                Foto:
            </div>
            <div class="c80 ccenter">
                <input type="file" name="foto" id="foto">
            </div>

            <div class="c100 ccenter">
                <input type="hidden" name="hacer" id="hacer" value="agregar">
                <input type="submit" name="botadlugar" id="botadlugar" value="Agregar>>">
            </div>
        </div>
    </form>';

echo $cadena;
?>
<script>
$("#fadlugar").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadlugar"));

	$.ajax({
		url: "eventos/lugares.php",
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