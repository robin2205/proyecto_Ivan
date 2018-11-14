// Cargar Tabla dinámica
$(".tablaCategoria").DataTable({
	"ajax":"ajax/tabla_categorias.ajax.php",
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

// MODIFICAR UNA CATEGORÍA
$(".tablaCategoria").on("click","button.btnEditarCategoria",function(){
	var idCategoria=$(this).attr("idCategoria");
	var datos=new FormData();
	datos.append("idCategoria",idCategoria);
	$.ajax({
		url:"ajax/categorias.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			// Mostramos la información en el Modal
			$("#idCategoria").val(respuesta['id']);
			$("#editarCategoria").val(respuesta['categoria']);}
	});
});

// ELIMINAR UNA CATEGORÍA
$(".tablaCategoria").on("click","button.btnEliminarCategoria",function(){
	swal({
		type: "warning",
		title: "Advertencia",
		text: "¿Está seguro de querer borrar la Categoría? ¡Si no está seguro, puede cancelar la acción!",
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: "¡Si, eliminar categoría!",
		cancelButtonText: "Cancelar",
	}).then((result)=>{
		if(result.value){
			var idCategoria=$(this).attr("idCategoria");
			var datos=new FormData();
			datos.append("eliminarIdCategoria",idCategoria);
			$.ajax({
				url:"ajax/categorias.ajax.php",
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
						}).then(function(result){
							if(result.value){
								window.location="categorias";}
						});}}
			});}
	});
});