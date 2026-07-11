<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

if(isset($_POST["hacer"]))
{
    if($_POST["hacer"]=='editar')
    {
        mysqli_query($conn, "UPDATE usuarios SET Perfil='".$_POST["perfil"]."' WHERE id='".$_POST["idusuario"]."'");

        $mensaje='<div class="mesaje" id="mesaje">Se actualizo el usuario</div>';
    }
    if($_POST["hacer"]=='borra')
    {
        mysqli_query($conn, "DELETE FROM usuarios WHERE id='".$_POST["idusuario"]."'") or die(mysqli_error($conn));

        $mensaje='<div class="mesaje" id="mesaje">Se elimino el usuario</div>';
    }
}

$ResUsuarios=mysqli_query($conn, "SELECT id, Nombre, Perfil FROM usuarios ORDER BY Nombre ASC");

$cadena=$mensaje.'<table style="width:80%">
        <thead>
            <tr>
                <td colspan="5" style="text-align: right"></td>
            </tr>
            <tr>
                <th colspan="5" align="center" class="textotitable">Usuarios</td>
            </tr>
            <tr>
                <th align="center" class="textotitable">&nbsp;</th>
                <th align="center" class="textotitable">Nombres</th>
                <th align="center" class="textotitable">Perfil</th>
                <th align="center" class="textotitable">&nbsp;</th>
                <th align="center" class="textotitable">&nbsp;</th>
            </tr>
        </thead>
        <tbody>';
    $bgcolor="#ffffff"; $J=1;
    while($RResUsuarios=mysqli_fetch_array($ResUsuarios))
    {
        if($RResUsuarios["Perfil"]!='Administrador')
        {
            $ResPerfil=mysqli_fetch_array(mysqli_query($conn, "SELECT NombrePerfil FROM perfiles_usuarios WHERE Id='".$RResUsuarios["Perfil"]."' LIMIT 1"));
            $perfil=$ResPerfil["NombrePerfil"];
        }
        else
        {
            $perfil=$RResUsuarios["Perfil"];
        }
        $cadena.='	<tr style="background: '.$bgcolor.'" id="row_'.$J.'">
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="top">'.$RResUsuarios["Nombre"].'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="top">'.$perfil.'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
							<a href="#" onclick="edit_usuario(\''.$RResUsuarios["id"].'\')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a> 
						</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
							<a href="#" onclick="delete_usuario(\''.$RResUsuarios["id"].'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
function edit_usuario(usuario){
	$.ajax({
				type: 'POST',
				url : 'usuarios/edit_usuario.php',
                data: 'usuario=' + usuario
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_usuario(usuario){
    $.ajax({
				type: 'POST',
				url : 'usuarios/delete_usuario.php',
                data: 'usuario=' + usuario
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}

setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000);
</script>