$(".valorCaja").number(true,0); // Formato para los números
$(".cantidadEntregada").number(true,0);

// Aquí cada que presionamos un botón en cantidad Entregada, lo enviamos a un input
$(".form-CrearEgreso").on("keyup","input.cantidadEntregada",function(){
	var valor=$(this).val();
	$("#cantidadEntregada").val(valor);
});

// Cargar Tabla dinámica
$(".tablaEgresos").DataTable({
	"ajax":"ajax/tabla_egresos.ajax.php",
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

// Ver detalles de Egreso
$(".tablaEgresos").on("click","button.btnVerObEgresos",function(){
	var idEgreso=$(this).attr("idEgreso");
	var datos=new FormData();
	datos.append("idEgreso",idEgreso);
	$.ajax({
		url:"ajax/egreso.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			// Mostramos la información en el Modal
			$("#numEgreso").val(respuesta['id']);
			$("#clienteEgreso").val(respuesta['id_cliente']);
			$("#observacionesEgre").val(respuesta['observaciones']);
			$("#totalEntregado").val(respuesta['valor']);
			$(".totalEntregado").number(true,0);
		}
	});
});

// LIMPIAR EL TEXTAREA
$(".btnLimpiarEgreso").click(function(){
	$("#observacionesEgreso").val("");
	$("#observacionesEgreso").focus();
});

// ==================================================== EDITAR EGRESO ==================================================== //
$(".tablaEgresos").on("click","button.btnEditarEgreso",function(){
	var idEgreso=$(this).attr("idEgreso");
	var datos=new FormData();
	datos.append("idEgreso",idEgreso);
	$.ajax({
		url:"ajax/egreso.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			// Mostramos la información en el Modal
			$("#editarNumEgreso").val(respuesta['id']);
			$("#editarClienteEgreso").val(respuesta['id_cliente']);
			$("#editarObEgreso").val(respuesta['observaciones']);
			$("#editarTotalEntregado").val(respuesta['valor']);
			$("#editarTotalEntregadoSinP").val(respuesta['valor']);
			$(".editarTotalEntregado").number(true,0);
		}
	});
});

// Aquí cada que presionamos un botón en cantidad Entregada, lo enviamos a un input
$(".form-EditarEgreso").on("keyup","input.editarTotalEntregado",function(){
	var valor=$(this).val();
	$("#editarTotalEntregadoSinP").val(valor);
});

// ==================================================== IMPRIMIR EGRESO ==================================================== //
$(".tablaEgresos").on('click',"button.btnImprimirEgreso",function(){
	var egreso=$(this).attr("egreso");
	// Le solicitamos a windows que me abra otra ventana
	window.open("extensiones/tcpdf/pdf/egreso.php?egreso="+egreso,"_blank");
});