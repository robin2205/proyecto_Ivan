// Cargar Tabla dinámica
$(".tablaClientes").DataTable({
	"ajax":"ajax/tabla_clientes.ajax.php?perfil="+$("#perfilOculto").val(),
	"deferRender":true,
	"retrieve":true,
	"processing":true,
	"language":{
		"sProcessing":     "Procesando...",
		"sLengthMenu":     "Mostrar _MENU_ registros",
		"sZeroRecords":    "No se encontraron resultados",
		"sEmptyTable":     "No hay datos disponibles en esta tabla",
		"sInfo":           "Registros del _START_ al _END_ de un total de _TOTAL_",
		"sInfoEmpty":      "Registros del 0 al 0 de un total de 0",
		"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
		"sInfoPostFix":    "",
		"sSearch":         "Buscar:",
		"sUrl":            "",
		"sInfoThousands":  ",",
		"sLoadingRecords": "Cargando...",
		"oPaginate":{
			"sFirst":    "Primero",
			"sLast":     "Último",
			"sNext":     "Siguiente",
			"sPrevious": "Anterior"
		},
		"oAria":{
			"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
			"sSortDescending": ": Activar para ordenar la columna de manera descendente"
		}
	}
});

// VALIDAMOS EL TIPO DE DOCUMENTO SELECCIONADO
$("#tipoDocumento").change(function(){
	var seleccion=$(this).val();
	if(seleccion!=""){
		if(seleccion=="C" || seleccion=="CE"){
			$("#cumpleanos").css({"display":"block"});
			$("#fechaNacimientoCliente").attr("required",true);}
		else{
			$("#cumpleanos").css({"display":"none"});
			$("#fechaNacimientoCliente").attr("required",false);}}
	else{
		$("#cumpleanos").css({"display":"none"});
		$("#fechaNacimientoCliente").attr("required",false);}
});

// VALIDACIÓN DE UN DOCUMENTO EXISTENTE EN LA BD
$("#documentoCliente").change(function(){
	var documento=$(this).val();
	var datos=new FormData();
	datos.append("documento",documento);
	$.ajax({
		url:"ajax/clientes.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			if(respuesta){
				if($(".msgError").length==0){
					$("#documentoCliente").parent().after('<div class="alert alert-danger alert-dismissable msgError" id="mensajeError">'+
												'<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>'+
											    '<strong>Error!</strong> El documento ya esta existe en la Base de Datos, por favor verifique.'+
											'</div>');}
				$("#documentoCliente").val("");
				$("#documentoCliente").focus();}
			else{
				$(".msgError").remove();}}
	});
});

// VALIDACIÓN MAYOR DE EDAD
$("#fechaNacimientoCliente").change(function(){
	var fecha=new Date($(this).val());
	var hoy=new Date();
	var edad=parseInt((hoy-fecha)/365/24/60/60/1000);
	if(edad<18){
		if($(".msgError2").length==0){
				$("#fechaNacimientoCliente").parent().after('<div class="alert alert-danger alert-dismissable msgError2" id="mensajeError">'+
											'<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>'+
										    '<strong>Error!</strong> El cliente debe se mayor de Edad, por favor verifique.'+
										'</div>');}
			$("#fechaNacimientoCliente").val("");
			$("#fechaNacimientoCliente").focus();}
	else{
		$(".msgError2").remove();}
});

// EDITAR CLIENTE
$(".tablaClientes").on("click",".btnEditarUsuario",function(){
	var idCliente=$(this).attr("idCliente");
	var datos=new FormData();
	datos.append("idCliente",idCliente);
	$.ajax({
		url:"ajax/clientes.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			$("#editarIdCliente").val(respuesta["id"]);
			$("#editarNombreCliente").val(respuesta["nombre"]);
			$("#editarEmailCliente").val(respuesta["email"]);
			$("#editarContactoCliente").val(respuesta["contacto"]);
			$("#editarDireccionCliente").val(respuesta["direccion"]);
			$("#editarFNCliente").val(respuesta["fecha_nacimiento"]);
		}
	});
});

// ELIMINAR CLIENTE
$(".tablaClientes").on("click",".btnEliminarCliente",function(){
	var clienteEliminar=$(this).attr("idCliente");
	swal({
		type: "warning",
		title: "Advertencia",
		text: "¿Está seguro de querer borrar el Cliente? ¡Si no está seguro, puede cancelar la acción!",
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: "¡Si, eliminar cliente!",
		cancelButtonText: "Cancelar",
	}).then(function(result){
		if(result.value){
			var datos=new FormData();
			datos.append("clienteEliminar",clienteEliminar);
			$.ajax({
				url:"ajax/clientes.ajax.php",
				type:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				success:function(respuesta){
					if(respuesta=="ok"){
						swal({
							type: "success",
							title: "¡Ok!",
							text: "¡La información fue Eliminada con éxito!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="clientes";}
						});}}
			});}
	});
});