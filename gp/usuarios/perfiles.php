<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

if(isset($_POST["hacer"]))
{
    if($_POST["hacer"]=='agregar')
    {
        mysqli_query($conn, "INSERT INTO perfiles_usuarios (NombrePerfil, Codigo) VALUES ('".$_POST["nombre"]."', '".$_POST["codigo"]."')") or die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje">Se agrego el perfil</div>';
    }
    if($_POST["hacer"]=='editar')
    {
        mysqli_query($conn, "UPDATE perfiles_usuarios SET NombrePerfil='".$_POST["nombre"]."', Codigo='".$_POST["codigo"]."' WHERE Id='".$_POST["idperfil"]."'");

        $mensaje='<div class="mesaje" id="mesaje">Se actualizo el perfil</div>';
    }
    if($_POST["hacer"]=='borra')
    {
        mysqli_query($conn, "DELETE FROM perfiles_usuarios WHERE Id='".$_POST["perfil"]."'") or die(mysqli_error($conn));
        mysqli_query($conn, "DELETE FROM desc_perfiles WHERE IdPerfil='".$_POST["perfil"]."'") or die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje">Se elimino el perfil</div>';
    }
}

$cadena=$mensaje.'<table style="width:80%">
        <thead>
            <tr>
                <td colspan="5" style="text-align: right">| <a href="#" onclick="nuevo_perfil()">Nuevo Perfil</a> |</td>
            </tr>
            <tr>
                <th colspan="5" align="center" class="textotitable">Perfiles de Usuarios</td>
            </tr>
            <tr>
                <th align="center" class="textotitable">&nbsp;</th>
                <th align="center" class="textotitable">Nombre</th>
                <th align="center" class="textotitable">Código</th>
                <th align="center" class="textotitable">&nbsp;</th>
                <th align="center" class="textotitable">&nbsp;</th>
            </tr>
        </thead>
        <tbody>';
    $ResPerfiles=mysqli_query($conn, "SELECT * FROM perfiles_usuarios ORDER BY NombrePerfil ASC");
    $bgcolor="#ffffff"; $J=1;
    while($RResPerfiles=mysqli_fetch_array($ResPerfiles))
    {
        $cadena.='	<tr style="background: '.$bgcolor.'" id="row_'.$J.'">
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="top">'.$RResPerfiles["NombrePerfil"].'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="top">'.$RResPerfiles["Codigo"].'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
							<a href="#" onclick="edit_perfil(\''.$RResPerfiles["Id"].'\')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a> 
						</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
							<a href="#" onclick="delete_perfil(\''.$RResPerfiles["Id"].'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
function nuevo_perfil(){
	$.ajax({
				type: 'POST',
				url : 'usuarios/add_perfil.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_perfil(perfil){
	$.ajax({
				type: 'POST',
				url : 'usuarios/edit_perfil.php',
                data: 'perfil=' + perfil
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_perfil(perfil){
	$.ajax({
				type: 'POST',
				url : 'usuarios/delete_perfil.php',
                data: 'perfil=' + perfil
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000);
</script>