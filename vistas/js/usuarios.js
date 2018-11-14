// Cargar Tabla dinámica
$(".tablaUsuarios").DataTable({
	"ajax":"ajax/tabla_usuarios.ajax.php",
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

// EDITAR USUARIO
$(".tablaUsuarios").on("click","button.btnEditarUsuario",function(){
	// Capturamos el id del usuario que viene en el atributo
	var idUsuario=$(this).attr("idUsuario");
	// Generamos una petición AJAX
	var datos=new FormData();
	datos.append("idUsuario",idUsuario);
	$.ajax({
		url:"ajax/usuarios.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			// Mostramos la información en el Modal
			$("#editarNombre").val(respuesta["nombre"]);
			$("#editarUsuario").val(respuesta["usuario"]);
			$("#editarPerfil").html(respuesta["perfil"]);
			$("#editarPerfil").val(respuesta["perfil"]);
			$("#passwordActual").val(respuesta["password"]);
		}
	});
});

// ACTIVANDO-DESACTIVANDO USUARIO
$(".tablaUsuarios").on("click","button.btnActivar",function(){
	// Capturamos el id del usuario y el estado
	var idUsuario=$(this).attr("idUsuario");
	var estadoUsuario=$(this).attr("estadoUsuario");
	// Realizamos la activación-desactivación por una petición AJAX
	var datos=new FormData();
	datos.append("activarId",idUsuario);
	datos.append("activarEstado",estadoUsuario);
	$.ajax({
		url:"ajax/usuarios.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		success:function(respuesta){
			if(window.matchMedia("(max-width:767px)").matches){
				swal({
					type: "success",
					title: "¡Ok!",
					text: "¡La información fue actualizada con éxito!",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"
				}).then((result)=>{
					if(result.value){
						window.location="usuarios";}
				});}}
	});
	// Cambiamos el estado del botón físicamente
	if(estadoUsuario==0){
		$(this).removeClass("btn-success");
		$(this).addClass("btn-danger");
		$(this).html("Desactivado");
		$(this).attr("estadoUsuario",1);}
	else{
		$(this).addClass("btn-success");
		$(this).removeClass("btn-danger");
		$(this).html("Activado");
		$(this).attr("estadoUsuario",0);}
});

// VALIDACIÓN DE USUARIO EXISTENTE
$("#nuevoUsuario").change(function(){
	var datos=new FormData();
	datos.append("nuevoUsuario",$(this).val());
	$.ajax({
		url:"ajax/usuarios.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			if(respuesta){
				if($(".msgError").length==0){
					$("#nuevoUsuario").parent().after('<div class="alert alert-danger alert-dismissable msgError" id="mensajeError">'+
												'<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>'+
											    '<strong>Error!</strong> El usuario ya esta asignado en la Base de Datos.'+
											'</div>');}
				$("#nuevoUsuario").val("");
				$("#nuevoUsuario").focus();}
			else{
				$(".msgError").remove();}}
	});
});

// ELIMINAR UN USUARIO
$(".tablaUsuarios").on("click","button.btnEliminarUsuario",function(){
	var usuarioEliminar=$(this).attr("idUsuario");
	var fotoUsuario=$(this).attr("fotoUsuario");
	var usuario=$(this).attr("usuario");
	swal({
		type: "warning",
		title: "Advertencia",
		text: "¿Está seguro de querer borrar el Usuario? ¡Si no está seguro, puede cancelar la acción!",
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: "¡Si, eliminar usuario!",
		cancelButtonText: "Cancelar",
	}).then(function(result){
		if(result.value){
			var datos=new FormData();
			datos.append("usuarioEliminar",usuarioEliminar);
			datos.append("fotoUsuario",fotoUsuario);
			datos.append("usuario",usuario);
			$.ajax({
				url:"ajax/usuarios.ajax.php",
				type:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				success:function(respuesta){
					console.log("respuesta", respuesta);
					if(respuesta=="ok"){
						swal({
							type: "success",
							title: "¡Ok!",
							text: "¡La información fue Eliminada con éxito!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="usuarios";}
						});}}
			});}
	});
});