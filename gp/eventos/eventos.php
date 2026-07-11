<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");
include ("../funciones.php");

$mensaje='';

if(isset($_POST["hacer"]))
{
	$copyfile='';
	
    if($_POST["hacer"]=='agregar')
    {
		//cargar archivo 
        if($_FILES['foto']!='')
        {
            $nombre_archivo_r = rand().'_'.$_FILES['foto']['name']; 

            if (is_uploaded_file($_FILES['foto']['tmp_name']))
            { 
                if(copy($_FILES['foto']['tmp_name'], './images/eventos/'.$nombre_archivo_r))
                {
                    $copyfile=1;
                }
                else
                {
                    $copyfile=2;
                }
            }
            else
            {
                $copyfile=3;
            }
		}
		else
		{
			$copyfile=1; $file='';
		}
		//guarda el nombre del archivo
        if($copyfile==1)
        {
			$file=$nombre_archivo_r;
			
			$fechaevento=$_POST["fecha"].' '.$_POST["hora"].':00';

            //inserta evento
			mysqli_query($conn, "INSERT INTO eventos (NombreEvento, CategoriaEvento, LugarEvento, FechaEvento, Descripcion, Cupo, Precio, Donativo, Imagen)
											VALUES ('".$_POST["nombre"]."', '".$_POST["cat_evento"]."', '".$_POST["lug_evento"]."', '".$fechaevento."', 
													'".$_POST["desc_evento"]."', '".$_POST["cupo"]."', '".$_POST["precio"]."', '".$_POST["donativo"]."', '".$file."')") or die(mysqli_error($conn));

			//selecciona el id del ultimo evento
			$ResLastEvento=mysqli_fetch_array(mysqli_query($conn, "SELECT Id FROM eventos ORDER BY Id DESC LIMIT 1"));

			//inserta los descuentos y maximo numero de boletos por perfiles
			//lee los perfiles de usuario
			$ResPerfiles=mysqli_query($conn, "SELECT * FROM perfiles_usuarios ORDER BY Id ASC");
			while($RResPerfiles=mysqli_fetch_array($ResPerfiles))
			{
				mysqli_query($conn, "INSERT INTO desc_perfiles (IdEvento, IdPerfil, Descuento)
												VALUES ('".$ResLastEvento["Id"]."', '".$RResPerfiles["Id"]."', '".$_POST["perfil_".$RResPerfiles["Id"]]."')") or die(mysqli_error($conn));

				mysqli_query($conn, "INSERT INTO max_perfiles (IdEvento, IdPerfil, MaxBoletos)
												VALUES ('".$ResLastEvento["Id"]."', '".$RResPerfiles["Id"]."', '".$_POST["max_perfil_".$RResPerfiles["Id"]]."')") or die(mysqli_error($conn));
			}

            $mensaje='<div class="mesaje" id="mesaje">Se agrego el evento</div>';

        }
        else
        {
            $file=NULL;

            $mensaje='<div class="mesaje" id="mesaje">No se agrego el lugar, verifica datos y vuelve a intentar</div>';
        
        }
	}
	if($_POST["hacer"]=='editar')
    {
		if($_FILES['foto']['name']!='')
		{
			$nombre_archivo_r = rand().'_'.$_FILES['foto']['name']; 
		
			if (is_uploaded_file($_FILES['foto']['tmp_name']))
			{ 
				if(copy($_FILES['foto']['tmp_name'], './images/eventos/'.$nombre_archivo_r))
				{
					$copyfile=1;
				}
				else
				{
					$copyfile=0;
				}
			}
			else
			{
				$copyfile=0;
			}
		}
		else
		{
			$nombre_archivo_r ='';
		}
		$fechaevento=$_POST["fecha"].' '.$_POST["hora"].':00';


		if($copyfile==0 AND $_FILES['foto']['name']!='')
		{
			$mensaje='<div class="mesaje" id="mesaje">No se edito el evento, verifique su contenido</div>';
		}
		else
		{
			//actualiza registro 
			$sql="UPDATE eventos SET NombreEvento='".$_POST["nombre"]."', 
									CategoriaEvento='".$_POST["cat_evento"]."', 
									LugarEvento='".$_POST["lug_evento"]."', 
									FechaEvento='".$fechaevento."', 
									Descripcion='".$_POST["desc_evento"]."', 
									Cupo='".$_POST["cupo"]."', 
									Precio='".$_POST["precio"]."', 
									Donativo='".$_POST["donativo"]."'";
			if($_FILES['foto']['name']!='')
			{
				$sql.=", Imagen='".$nombre_archivo_r."'";
			}
			$sql.=" WHERE Id='".$_POST["idevento"]."'";

			mysqli_query($conn, $sql) or die(mysqli_error($conn));

			//actualiza los descuentos por perfiles
			//lee los perfiles de usuario
			$ResPerfiles=mysqli_query($conn, "SELECT * FROM perfiles_usuarios ORDER BY Id ASC");
			while($RResPerfiles=mysqli_fetch_array($ResPerfiles))
			{
				mysqli_query($conn, "UPDATE desc_perfiles SET Descuento='".$_POST["perfil_".$RResPerfiles["Id"]]."'
												WHERE IdEvento='".$_POST["idevento"]."' AND IdPerfil='".$RResPerfiles["Id"]."'") or die(mysqli_error($conn));

				//numero maximo de boletos
				$MB=mysqli_num_rows(mysqli_query($conn, "SELECT Id FROM max_perfiles WHERE IdEvento='".$_POST["idevento"]."' AND IdPerfil='".$RResPerfiles["Id"]."'"));

				if($MB==1)
				{
					mysqli_query($conn, "UPDATE max_perfiles SET MaxBoletos='".$_POST["max_perfil_".$RResPerfiles["Id"]]."'
												WHERE IdEvento='".$_POST["idevento"]."' AND IdPerfil='".$RResPerfiles["Id"]."'") or die(mysqli_error($conn));
				}
				else
				{
					mysqli_query($conn, "INSERT INTO max_perfiles (IdEvento, IdPerfil, MaxBoletos)
												VALUES ('".$_POST["idevento"]."', '".$RResPerfiles["Id"]."', '".$_POST["max_perfil_".$RResPerfiles["Id"]]."')") or die(mysqli_error($conn));
				}
			}
			
			$mensaje='<div class="mesaje" id="mesaje">Se edito el evento</div>';
		}
	}
	if($_POST["hacer"]=='borrar')
    {
		mysqli_query($conn, "DELETE FROM eventos WHERE Id='".$_POST["evento"]."'");
		mysqli_query($conn, "DELETE FROM desc_perfiles WHERE idEvento='".$_POST["evento"]."'");

		$mensaje='<div class="mesaje" id="mesaje">Se elimino el evento</div>';
	}
}

$cadena=$mensaje.'<table style="width:80%">
        <thead>
            <tr>
                <td colspan="7" style="text-align: right">| <a href="#" onclick="add_evento()">Nuevo Evento</a> |</td>
            </tr>
            <tr>
                <th colspan="7" align="center" class="textotitable">Eventos</td>
            </tr>
            <tr>
                <th align="center" class="textotitable">&nbsp;</th>
                <th align="center" class="textotitable">Tipo</th>
                <th align="center" class="textotitable">Nombre</th>
                <th align="center" class="textotitable">Lugar</th>
                <th align="center" class="textotitable" style="width: 200px">Fecha</th>
                <th align="center" class="textotitable">&nbsp;</th>
                <th align="center" class="textotitable">&nbsp;</th>
            </tr>
        </thead>
		<tbody>';
	$ResEventos=mysqli_query($conn, "SELECT * FROM eventos WHERE FechaEvento > '".date("Y-m-d H:i:s")."' ORDER BY FechaEvento ASC");
	$bgcolor='#ffffff'; $J=1;
	while($RResEventos=mysqli_fetch_array($ResEventos))
	{
		$ResCatEvento=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM cat_eventos WHERE Id='".$RResEventos["CategoriaEvento"]."' LIMIT 1"));
		$ResLugEvento=mysqli_fetch_array(mysqli_query($conn, "SELECT * FROM lugar_eventos WHERE Id='".$RResEventos["LugarEvento"]."' LIMIT 1"));
		$cadena.='	<tr style="background: '.$bgcolor.'" id="row_'.$J.'">
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="top">'.$ResCatEvento["Nombre"].'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="top">'.$RResEventos["NombreEvento"].'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="top">'.$ResLugEvento["Nombre"].'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="top">'.fecha($RResEventos["FechaEvento"]).'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
							<a href="#" onclick="edit_evento(\''.$RResEventos["Id"].'\')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a> 
						</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
							<a href="#" onclick="delete_evento(\''.$RResEventos["Id"].'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>
						</td>
					</tr>';
		$J++;
		if($bgcolor=="#ffffff"){$bgcolor='#cccccc';}
		else if($bgcolor=="#cccccc"){$bgcolor="#ffffff";}
	}
	$cadena.='</tbody>
            </table>';
            
    echo $cadena;

?>
<script>
function add_evento(){
	$.ajax({
				type: 'POST',
				url : 'eventos/add_evento.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_evento(evento){
	$.ajax({
				type: 'POST',
				url : 'eventos/edit_evento.php',
				data: 'evento=' + evento
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_evento(evento){
	$.ajax({
				type: 'POST',
				url : 'eventos/delete_evento.php',
				data: 'evento=' + evento
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}


setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000);
</script>