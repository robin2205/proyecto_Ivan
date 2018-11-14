function validar_texto(e){
	tecla=(document.all)?e.keyCode:e.which;
	if(tecla==8) return true;
	patron=/[A-Za-z\sáéíóúñÁÉÍÓÚÑ ]/;
	tecla_final=String.fromCharCode(tecla);
	return patron.test(tecla_final);
}

function validar_numero(e){
	tecla=(document.all)?e.keyCode:e.which;
	if(tecla==8) return true;
	patron=/\d/;
	tecla_final=String.fromCharCode(tecla);
	return patron.test(tecla_final);
}

function validar_textonumero(e){
	tecla=(document.all)?e.keyCode:e.which;
	if(tecla==8) return true;
	patron=/[A-Za-z0-9\sáéíóúñÁÉÍÓÚÑ ]/;
	tecla_final=String.fromCharCode(tecla);
	return patron.test(tecla_final);
}

function validar_numeroDecimal(e){
	tecla=(document.all)?e.keyCode:e.which;
	if(tecla==8) return true;
	patron=/^\d*\.?\,?d*$/;
	tecla_final=String.fromCharCode(tecla);
	return patron.test(tecla_final);
}