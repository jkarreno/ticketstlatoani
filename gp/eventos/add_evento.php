<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

$ResTiposEvento=mysqli_query($conn, "SELECT * FROM cat_eventos ORDER BY Nombre ASC");
$ResLugarEvento=mysqli_query($conn, "SELECT * FROM lugar_eventos ORDER BY Nombre ASC");

$cadena='<form name="fadevento" id="fadevento" method="POST" enctype="multipart/form-data">
			<div class="tabla">
				<div class="titprin">
					Nuevo Evento
				</div>
				
				<div class="c20 c_derecha">
					Nombre:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="nombre" id="nombre">
                </div>
				
                <div class="c20 c_derecha">
					Categoría:
				</div>
				<div class="c80 ccenter">
                    <select name="cat_evento" id="cat_evento">
                        <option value="0">Seleccione</option>';
    while($RResTE=mysqli_fetch_array($ResTiposEvento))
    {
        $cadena.='          <option value="'.$RResTE["Id"].'">'.$RResTE["Nombre"].'</option>';
    }
    $cadena.='           </select>
                </div>

                <div class="c20 c_derecha">
					Lugar:
				</div>
				<div class="c80 ccenter">
                    <select name="lug_evento" id="lug_evento">
                        <option value="0">Seleccione</option>';
    while($RResLE=mysqli_fetch_array($ResLugarEvento))
    {
        $cadena.='          <option value="'.$RResLE["Id"].'">'.$RResLE["Nombre"].'</option>';
    }
    $cadena.='           </select>
                </div>

                <div class="c20 c_derecha">
					Fecha:
				</div>
                <div class="c30 c_derecha">
					<input type="date" name="fecha" id="fecha" value="'.date("Y-m-d").'">
                </div>
                
                <div class="c20 c_derecha">
					Hora:
				</div>
                <div class="c30 c_derecha">
                    <select name="hora" id="hora">
                        <option value="08:00"';if(date("H")=='08'){$cadena.=' selected';}$cadena.='>08:00</option>
                        <option value="09:00"';if(date("H")=='09'){$cadena.=' selected';}$cadena.='>09:00</option>
                        <option value="10:00"';if(date("H")=='10'){$cadena.=' selected';}$cadena.='>10:00</option>
                        <option value="11:00"';if(date("H")=='11'){$cadena.=' selected';}$cadena.='>11:00</option>
                        <option value="12:00"';if(date("H")=='12'){$cadena.=' selected';}$cadena.='>12:00</option>
                        <option value="13:00"';if(date("H")=='13'){$cadena.=' selected';}$cadena.='>13:00</option>
                        <option value="14:00"';if(date("H")=='14'){$cadena.=' selected';}$cadena.='>14:00</option>
                        <option value="15:00"';if(date("H")=='15'){$cadena.=' selected';}$cadena.='>15:00</option>
                        <option value="16:00"';if(date("H")=='16'){$cadena.=' selected';}$cadena.='>16:00</option>
                        <option value="17:00"';if(date("H")=='17'){$cadena.=' selected';}$cadena.='>17:00</option>
                        <option value="18:00"';if(date("H")=='18'){$cadena.=' selected';}$cadena.='>18:00</option>
                        <option value="19:00"';if(date("H")=='19'){$cadena.=' selected';}$cadena.='>19:00</option>
                        <option value="20:00"';if(date("H")=='20'){$cadena.=' selected';}$cadena.='>20:00</option>
                        <option value="21:00"';if(date("H")=='21'){$cadena.=' selected';}$cadena.='>21:00</option>
                        <option value="22:00"';if(date("H")=='22'){$cadena.=' selected';}$cadena.='>22:00</option>
                    </select>
				</div>

                <div class="c20 c_derecha">
					Descripción:
				</div>
				<div class="c80 ccenter">
                    <textarea name="desc_evento" id="desc_evento"></textarea>
                </div>

                <div class="c20 c_derecha">
					Cupo:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="cupo" id="cupo">
                </div>

                <div class="c20 c_derecha">
					Precio:
				</div>
				<div class="c40 ccenter">
					<input type="number" name="precio" id="precio">
                </div>
                <div class="c20 c_derecha">
					Donativo:
				</div>
                <div class="c20 ccenter">
					<ul class="tg-list">
                        <li class="tg-list-item">
                            <input class="tgl tgl-light" id="aco_'.$RResAco["Id"].'" name="aco_'.$RResAco["Id"].'" type="checkbox" value="1"/>
                            <label class="tgl-btn" for="aco_'.$RResAco["Id"].'"></label>
                        </li>
                    </ul>
                </div>

                <div class="c20 c_derecha">
					Foto:
				</div>
				<div class="c80 ccenter">
					<input type="file" name="foto" id="foto">
                </div>

                <div class="c20 c_derecha">
					Descuentos Perfiles:
				</div>
                <div class="c80 ccenter" style="display: flex !important; flex-wrap: wrap;">';
                
    //consulta los perfiles
    $ResPerfiles=mysqli_query($conn, "SELECT * FROM perfiles_usuarios ORDER BY NombrePerfil ASC");
    while($RResPerfiles=mysqli_fetch_array($ResPerfiles))
    {
        $cadena.='  <div class="c20">    
                        <div class="c100 ccenter" style="border: 0px !important;">
                            '.$RResPerfiles["NombrePerfil"].':
                        </div>
                        <div class="c100 c_izquierda" style="border: 0px !important;">
                            <input type="number" name="perfil_'.$RResPerfiles["Id"].'" id="perfil_'.$RResPerfiles["Id"].'" value="0" style="width: calc(100% - 20px)"> %
                        </div>
                        <div class="c100 c_izquierda" style="border: 0px !important;">
                            <input type="number" name="max_perfil_'.$RResPerfiles["Id"].'" id="max_perfil_'.$RResPerfiles["Id"].'" value="0" style="width: calc(100% - 50px)"> Max
                        </div>
                    </div>';
    }
					
    $cadena.='  </div>
                        
                <div class="c100 ccenter">
                    <input type="hidden" name="hacer" id="hacer" value="agregar">
					<input type="submit" name="botadevento" id="botadevento" value="Agregar>>">
				</div>
			</div>
    </form>';
    
    echo $cadena;
?>
<script>
$("#fadevento").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("fadevento"));

	$.ajax({
		url: "eventos/eventos.php",
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