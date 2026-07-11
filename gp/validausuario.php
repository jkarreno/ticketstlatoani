<?php
//conecto con la base de datos 
include('conexion.php');

//Sentencia SQL para buscar un usuario con esos datos 
$ssql = "SELECT * FROM usuarios WHERE Usuario='".$_POST["user"]."' and Contrasena='".md5($_POST["pass"])."'"; 

//Ejecuto la sentencia 
$rs = mysqli_query($conn, $ssql); 

//vemos si el usuario y contrase�a es v�ildo 
//si la ejecuci�n de la sentencia SQL nos da alg�n resultado 
//es que si que existe esa conbinaci�n usuario/contrase�a 
if (mysqli_num_rows($rs)!=0){ 
    //usuario y contrase�a v�lidos 
    $Rowrs=mysqli_fetch_array($rs);
    //defino una sesion y guardo datos 
    session_start(); 
    //session_register("autentificado"); 
    $_SESSION["autentificado"] = "SI"; 
    $_SESSION["perfil"] = $Rowrs["Perfil"];
    $_SESSION["nombre"] = $Rowrs["Nombre"];
 //    sesion_register("usuario");
//    $usuario = $username;
	if($_POST["pass"]=='12345678')
	{
		header ("Location: principal2.php");
	}
	else 
	{
    header ("Location: principal.php"); 
	}
}else { 
    //si no existe le mando otra vez a la portada 
    header("Location: index.php"); 
} 


//jkarreno2020
?> 

