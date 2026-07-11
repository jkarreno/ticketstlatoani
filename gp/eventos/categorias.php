<?php
//Inicio la sesion 
session_start();

include ("../conexion.php");

if(isset($_POST["hacer"]))
{
    if($_POST["hacer"]=='agregar')
    {
        mysqli_query($conn, "INSERT INTO cat_eventos (Nombre) VALUES ('".$_POST["nombre"]."')") or die(mysqli_error());

        $mensaje='<div class="mesaje" id="mesaje">Se agrego la categoría</div>';
    }

    if($_POST["hacer"]=='editar')
    {
        mysqli_query($conn, "UPDATE cat_eventos SET Nombre='".$_POST["nombre"]."' WHERE id='".$_POST["idcat"]."'");

        $mensaje='<div class="mesaje" id="mesaje">Se modifico la categoría</div>';
    }

    if($_POST["hacer"]=='borracat')
    {
        mysqli_query($conn, "DELETE FROM cat_eventos WHERE id='".$_POST["categoria"]."'") or die(mysqli_error());

        $mensaje='<div class="mesaje" id="mesaje">Se elimino la categoría</div>';
    }
}

$cadena=$mensaje.'<table style="width:80%">
        <thead>
            <tr>
                <td colspan="4" style="text-align: right">| <a href="#" onclick="add_catego()">Nueva Categoría</a> |</td>
            </tr>
            <tr>
                <th colspan="4" align="center" class="textotitable">Categorías de Eventos</td>
            </tr>
            <tr>
                <th align="center" class="textotitable">&nbsp;</th>
                <th align="center" class="textotitable">Nombre</th>
                <th align="center" class="textotitable">&nbsp;</th>
                <th align="center" class="textotitable">&nbsp;</th>
            </tr>
        </thead>
        <tbody>';
    $ResCategorias=mysqli_query($conn, "SELECT * FROM cat_eventos ORDER BY Nombre");
    $bgcolor="#ffffff"; $J=1;
    while($RResCategorias=mysqli_fetch_array($ResCategorias))
    {
        $cadena.='	<tr style="background: '.$bgcolor.'" id="row_'.$J.'">
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">'.$J.'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="left" class="texto" valign="top">'.$RResCategorias["Nombre"].'</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
							<a href="#" onclick="edit_catego(\''.$RResCategorias["Id"].'\')"><i class="fa fa-pencil-square" aria-hidden="true"></i></a> 
						</td>
						<td onmouseover="row_'.$J.'.style.background=\'#e8a5f8\'" onmouseout="row_'.$J.'.style.background=\''.$bgcolor.'\'" align="center" class="texto" valign="middle">
							<a href="#" onclick="delete_catego(\''.$RResCategorias["Id"].'\')"><i class="fa fa-trash" aria-hidden="true"></i></a>
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
function add_catego(){
	$.ajax({
				type: 'POST',
				url : 'eventos/add_categoria.php'
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function edit_catego(categoria){
	$.ajax({
				type: 'POST',
				url : 'eventos/edit_categoria.php',
                data: 'catego=' + categoria
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}
function delete_catego(categoria){
	$.ajax({
				type: 'POST',
				url : 'eventos/delete_categoria.php',
                data: 'catego=' + categoria
	}).done (function ( info ){
		$('#contenido').html(info);
	});
}


setTimeout(function() { 
    $('#mesaje').fadeOut('fast'); 
}, 1000);
</script>