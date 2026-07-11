<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

if(isset($_POST["hacer"]))
{
    if($_POST["hacer"]=='agregar')
    {
        //cargar archivo 
        if($_FILES['foto']!='')
        {
            $nombre_archivo_r = rand().'_'.$_FILES['foto']['name']; 

            if (is_uploaded_file($_FILES['foto']['tmp_name']))
            { 
                if(copy($_FILES['foto']['tmp_name'], '../images/lugares/'.$nombre_archivo_r))
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

        //guarda el nombre del archivo
        if($copyfile==1)
        {
            $file=$nombre_archivo_r;

            mysqli_query($conn, "INSERT INTO lugar_eventos (Nombre, Direccion, Telefono, Imagen, Url_mapa)
                        VALUES ('".$_POST["nombre"]."', '".$_POST["direccion"]."', '".$_POST["telefono"]."', '".$file."', '".$_POST["mapa"]."')") or die(mysqli_error());

            $mensaje='<div class="mesaje" id="mesaje">Se agrego el lugar</div>';

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
                if(copy($_FILES['foto']['tmp_name'], '../images/lugares/'.$nombre_archivo_r))
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
            $copyfile=1;
        }

        //actualiza registro
        if($copyfile==1)
        {
            $sql="UPDATE lugar_eventos SET Nombre='".$_POST["nombre"]."', 
                Direccion='".$_POST["direccion"]."', 
                Telefono='".$_POST["telefono"]."',
                Url_mapa='".$_POST["mapa"]."'";
            if($_FILES['foto']['name']!='')
            {
            $sql.=", Imagen='".$nombre_archivo_r."'";
            }
            $sql.=" WHERE id='".$_POST["idlugar"]."'";

            mysqli_query($conn, $sql) or die(mysqli_error());

            $mensaje='<div class="mesaje" id="mesaje">Se modifico el lugar</div>';
        }
        else
        {
            $mensaje='<div class="mesaje" id="mesaje">No se logró modificar el lugar, verifica tu información e intenta nuevamente '.$copyfile.'</div>';
        }
        
    }
    if($_POST["hacer"]=='borrar')
    {
        mysqli_query($conn, "DELETE FROM lugar_eventos WHERE id='".$_POST["lugar"]."'") or die(mysql_error());

        $mensaje='<div class="mesaje" id="mesaje">Se elimino el lugar</div>';
    }
}

$cadena=$copyfile.$mensaje.'<table style="width:80%">
        <thead>
            <tr>
                <td colspan="4" style="text-align: right">| <a href="#" onclick="add_lugar()">Nuevo Lugar</a> |</td>
            </tr>
            <tr>
                <th colspan="4" align="center" class="textotitable">Lugares de Eventos</td>
            </tr>
            <tr>
                <th align="center" class="textotitable">&nbsp;</th>
                <th align="center" class="textotitable">Nombre</th>
                <th align="center" class="textotitable">&nbsp;</th>
                <th align="center" class="textotitable">&nbsp;</th>
            </tr>
        </thead>
        <tbody>';
    $ResLugares=mysqli_query($conn, "SELECT * FROM lugar_eventos ORDER BY Nombre");
    $bgcolor="#ffffff"; $J=1;
    while($RResLugares=mysqli_fetch_array($ResLugares))
    {
        $cadena.='	<tr style="background: '.$bgcolor.'" id="row_'.$J.'">
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="top">'.$RResLugares["Nombre"].'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
							<a href="#" onclick="edit_lugar(\''.$RResLugares["Id"].'\')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a> 
						</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
							<a href="#" onclick="delete_lugar(\''.$RResLugares["Id"].'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
function add_lugar(){
	$.ajax({
				type: 'POST',
				url : 'eventos/add_lugar.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_lugar(lugar){
	$.ajax({
				type: 'POST',
				url : 'eventos/edit_lugar.php',
                data: 'lugar=' + lugar
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_lugar(lugar){
	$.ajax({
				type: 'POST',
				url : 'eventos/delete_lugar.php',
                data: 'lugar=' + lugar
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000);
</script>