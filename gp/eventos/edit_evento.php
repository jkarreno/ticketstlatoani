<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

    $ResTiposEvento=mysqli_query($conn, "SELECT * FROM cat_eventos ORDER BY Nombre ASC");
    $ResLugarEvento=mysqli_query($conn, "SELECT * FROM lugar_eventos ORDER BY Nombre ASC");
    $ResEvento=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM eventos WHERE Id='".$_POST["evento"]."' LIMIT 1"));

    $cadena='<form name="feditevento" id="feditevento" method="POST"enctype="multipart/form-data">
			<div class="tabla">
				<div class="titprin">
					Editar Evento
				</div>
				
				<div class="c20 c_derecha">
					Nombre:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="nombre" id="nombre" value="'.$ResEvento["NombreEvento"].'">
                </div>
				
                <div class="c20 c_derecha">
					Categoría:
				</div>
				<div class="c80 ccenter">
                    <select name="cat_evento" id="cat_evento">
                        <option value="0">Seleccione</option>';
    while($RResTE=mysqli_fetch_array($ResTiposEvento))
    {
        $cadena.='          <option value="'.$RResTE["Id"].'"';if($RResTE["Id"]==$ResEvento["CategoriaEvento"]){$cadena.=' selected';}$cadena.='>'.$RResTE["Nombre"].'</option>';
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
        $cadena.='          <option value="'.$RResLE["Id"].'"';if($RResLE["Id"]==$ResEvento["LugarEvento"]){$cadena.=' selected';}$cadena.='>'.$RResLE["Nombre"].'</option>';
    }
    $cadena.='           </select>
                </div>

                <div class="c20 c_derecha">
					Fecha:
				</div>
                <div class="c30 c_derecha">
					<input type="date" name="fecha" id="fecha" value="'.$ResEvento["FechaEvento"][0].$ResEvento["FechaEvento"][1].$ResEvento["FechaEvento"][2].$ResEvento["FechaEvento"][3].$ResEvento["FechaEvento"][4].$ResEvento["FechaEvento"][5].$ResEvento["FechaEvento"][6].$ResEvento["FechaEvento"][7].$ResEvento["FechaEvento"][8].$ResEvento["FechaEvento"][9].'">
                </div>
                
                <div class="c20 c_derecha">
					Hora:
				</div>
                <div class="c30 c_derecha">
                    <select name="hora" id="hora">
                        <option value="08:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='08'){$cadena.=' selected';}$cadena.='>08:00</option>
                        <option value="09:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='09'){$cadena.=' selected';}$cadena.='>09:00</option>
                        <option value="10:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='10'){$cadena.=' selected';}$cadena.='>10:00</option>
                        <option value="11:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='11'){$cadena.=' selected';}$cadena.='>11:00</option>
                        <option value="12:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='12'){$cadena.=' selected';}$cadena.='>12:00</option>
                        <option value="13:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='13'){$cadena.=' selected';}$cadena.='>13:00</option>
                        <option value="14:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='14'){$cadena.=' selected';}$cadena.='>14:00</option>
                        <option value="15:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='15'){$cadena.=' selected';}$cadena.='>15:00</option>
                        <option value="16:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='16'){$cadena.=' selected';}$cadena.='>16:00</option>
                        <option value="17:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='17'){$cadena.=' selected';}$cadena.='>17:00</option>
                        <option value="18:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='18'){$cadena.=' selected';}$cadena.='>18:00</option>
                        <option value="19:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='19'){$cadena.=' selected';}$cadena.='>19:00</option>
                        <option value="20:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='20'){$cadena.=' selected';}$cadena.='>20:00</option>
                        <option value="21:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='21'){$cadena.=' selected';}$cadena.='>21:00</option>
                        <option value="22:00"';if($ResEvento["FechaEvento"][11].$ResEvento["FechaEvento"][12]=='22'){$cadena.=' selected';}$cadena.='>22:00</option>
                    </select>
				</div>

                <div class="c20 c_derecha">
					Descripción:
				</div>
				<div class="c80 ccenter">
                    <textarea name="desc_evento" id="desc_evento">'.$ResEvento["Descripcion"].'</textarea>
                </div>

                <div class="c20 c_derecha">
					Cupo:
				</div>
				<div class="c80 ccenter">
					<input type="text" name="cupo" id="cupo" value="'.$ResEvento["Cupo"].'">
                </div>
                <div class="c20 c_derecha">
					Donativo:
				</div>
                <div class="c20 ccenter">
					<ul class="tg-list">
                        <li class="tg-list-item">
                            <input class="tgl tgl-light" id="aco_'.$RResAco["Id"].'" name="aco_'.$RResAco["Id"].'" type="checkbox" value="1" '.($ResEvento["Donativo"] == 1 ? 'checked' : '').'/>
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
        $ResDP=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM desc_perfiles WHERE IdEvento='".$_POST["evento"]."' AND IdPerfil='".$RResPerfiles["Id"]."' LIMIT 1"));
        $ResMB=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM max_perfiles WHERE IdEvento='".$_POST["evento"]."' AND IdPerfil='".$RResPerfiles["Id"]."' LIMIT 1"));


        $cadena.='  <div class="c20"> 
                        <div class="c100 c_izquierda" style="border: 0px !important;">
                            '.$RResPerfiles["NombrePerfil"].':
                        </div>
                        <div class="c100 c_izquierda" style="border: 0px !important;">
                            <input type="number" name="perfil_'.$RResPerfiles["Id"].'" id="perfil_'.$RResPerfiles["Id"].'" value="'.($ResDP["Descuento"] ?? '').'" style="width: calc(100% - 20px)"> %
                        </div>
                        <div class="c100 c_izquierda" style="border: 0px !important;">
                            <input type="number" name="max_perfil_'.$RResPerfiles["Id"].'" id="max_perfil_'.$RResPerfiles["Id"].'" value="';if($ResMB==NULL){$cadena.='0';}else{$cadena.=$ResMB["MaxBoletos"];}$cadena.='" style="width: calc(100% - 50px)"> Max
                        </div>
                    </div>';
    }
					
    $cadena.='  </div>

                
                <div class="c100 ccenter">
                    <input type="hidden" name="idevento" id="idevento" value="'.$ResEvento["Id"].'">
                    <input type="hidden" name="hacer" id="hacer" value="editar">
					<input type="submit" name="boteditevento" id="boteditevento" value="Modificar>>">
				</div>
			</div>
    </form>';
    
    echo $cadena;

?>
<script>
$("#feditevento").on("submit", function(e){
	e.preventDefault();
	var formData = new FormData(document.getElementById("feditevento"));

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
