function valida_formulario_registro(){
    var enviar=1;
    regex = /^(?=.*\d)(?=.*[a-záéíóúüñ]).*[A-ZÁÉÍÓÚÜÑ]/;

    if(document.fadusuario.nombre.value.length==0){
        alert("Debes indicar tu nombre") 
        document.fadusuario.nombre.focus();
        enviar=0;
        return 0;
    }
    
    if(document.fadusuario.apellido.value.lenght==0){
        alert("Debes indicar tu apellido") 
        document.fadusuario.apellido.focus();
        enviar=0;
        return 0;
    }
	
    if(document.fadusuario.username.value.length==0){
        alert("Debes indicar tu nombre de usuario") 
        document.fadusuario.username.focus();
        enviar=0;
        return 0;
	}

	if(document.fadusuario.username.length>10)
    {
        alert("Tu nombre de usuario no debe ser mayor a 10 caracteres");
        document.fadusuario.username.focus();
        enviar=0;
        return 0;
	}
	
	//if(!regex.test(document.fadusuario.contrasena.value)){
    //    alert("Tu contraseña debe tener una Mayuscula, una minuscula, un numero y un caracter especial"); 
    //    document.fadusuario.contrasena.focus(); 
    //    enviar=0;
    //    return 0;
	//}
	
	if(document.fadusuario.telefono.value.length>0 && (document.fadusuario.telefono.value.length<10 || document.fadusuario.telefono.length>10))
    {
        alert("Tu numero telefonico debe de ser de 10 digitos");
        document.fadusuario.telefono.focus();
        enviar=0;
        return 0;
    }
	
    if(document.fadusuario.correoe.value.length==0){
        alert("Debes indicar tu correo electrónico") 
        document.fadusuario.correoe.focus();
        enviar=0;
        return 0;
    }
    if(document.fadusuario.telefono.value.length==0){
        alert("Debes indicar tu numero de telefono celular") 
        document.fadusuario.telefono.focus();
        enviar=0;
        return 0;
    }

    if(document.fadusuario.telefono.value.length>0 && (document.fadusuario.telefono.value.length<10 || document.fadusuario.telefono.length>10))
    {
        alert("Tu numero telefonico debe de ser de 10 digitos");
        document.fadusuario.telefono.focus();
        enviar=0;
        return 0;
    }


    //if(!regex.test(document.fadusuario.contrasena.value)){
    //    alert("Tu contraseña debe tener una Mayuscula, una minuscula, un numero y un caracter especial"); 
    //    document.fadusuario.contrasena.focus(); 
    //    enviar=0;
    //    return 0;
    //}


    if(enviar==1)
    {
        document.fadusuario.submit(); 
    }
}
function valida_registro_tarjeta(){
    var enviar=1;

    if(document.fadcard.nombre.value.length==0){
        alert("Debes ingresar el nombre como aparece en la tarjeta") 
        document.fadcard.nombre.focus();
        enviar=0;
        return 0;
    }

    if(document.fadcard.numcard.value.length==0){
        alert("Debes ingresar el numero como aparece en la tarjeta") 
        document.fadcard.numcard.focus();
        enviar=0;
        return 0;
    }

    if(document.fadcard.fechaexp.value.length==0){
        alert("Debes ingresar la fecha de expiración de la tarjeta") 
        document.fadcard.fechaexp.focus();
        enviar=0;
        return 0;
    }

    if(document.fadcard.cvc.value.length==0){
        alert("Debes ingresar el código cvc de la tarjeta, se encuentra en el reverso de la misma") 
        document.fadcard.cvc.focus();
        enviar=0;
        return 0;
    }

    if(enviar==1)
    {
        document.fadcard.submit(); 
    }
}