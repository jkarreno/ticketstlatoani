<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResLugar=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM lugar_eventos WHERE id='".$_POST["lugar"]."' LIMIT 1"));

$cadena.=' <form name="feditlugar" id="feditlugar" method="POST" enctype="multipart/form-data">
        <div class="tabla">
            <div class="titprin">
                Editar Lugar
            </div>

            <div class="c20 c_derecha">
                Nombre:
            </div>
            <div class="c80 ccenter">
                <input type="text" name="nombre" id="nombre" value="'.$ResLugar["Nombre"].'">
            </div>

            <div class="c20 c_derecha">
                Dirección:
            </div>
            <div class="c80 ccenter">
                <input type="text" name="direccion" id="direccion" value="'.$ResLugar["Direccion"].'">
            </div>

            <div class="c20 c_derecha">
                Telefono:
            </div>
            <div class="c80 ccenter">
                <input type="text" name="telefono" id="telefono" value="'.$ResLugar["Telefono"].'">
            </div>

            <div class="c20 c_derecha">
                Url Mapa:
            </div>
            <div class="c80 ccenter">
                <input type="text" name="mapa" id="mapa" value="'.$ResLugar["Url_mapa"].'">
            </div>

            <div class="c20 c_derecha">
                Foto:
            </div>
            <div class="c80 ccenter">
                <input type="file" name="foto" id="foto">
            </div>

            <div class="c100 ccenter">
                <input type="hidden" name="idlugar" id="idlugar" value="'.$ResLugar["Id"].'">
                <input type="hidden" name="hacer" id="hacer" value="editar">
                <input type="submit" name="boteditlugar" id="boteditlugar" value="editar>>">
            </div>
        </div>
    </form>';

    echo $cadena;

?>
<script>
$("#feditlugar").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditlugar"));

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