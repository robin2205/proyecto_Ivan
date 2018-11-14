$(".din-Efectivo").change(function(){
	$(".arqueoCaja").number(true,0); // Le ponemos formato a la caja
	var arrayInputs=$(".din-Efectivo");
	var mostrarV=0;
	for(var i=0;i<arrayInputs.length;i++){
		var cantidad=arrayInputs[i].value;
		if(cantidad==""){
			cantidad=0;}
		mostrarV=mostrarV+(parseInt(arrayInputs[i].id)*cantidad);}
	$(".arqueoCaja").val(mostrarV);
});

// Cambio de fecha para cargar otro cierre
$("#fechaCierre").on("change",function(){
	var fecha=$(this).val();
	var datos=new FormData();
	datos.append("fecha",fecha);
	$.ajax({
		url:"ajax/cierre.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			if(respuesta.recibos.length>0 || respuesta.ventas.length>0 || respuesta.egresos.length>0){
				window.location="index.php?ruta=cierre-caja&fecha="+fecha;}
			else{
				swal({
					type: "error",
					title: "Error",
					text: "¡No hay información de Cierre en la Fecha seleccionada!",
					showConfirmButton: true,
					confirmButtonText: "Cerrar"
				}).then((result)=>{
					if(result.value){
						window.location="cierre-caja";}
				});}
		}
	});
});

// Impresión del cierre de caja
$(".btnImprimirCierre").on("click",function(){
	// Capturamos la fecha
	var fecha=$("#fechaCierre").val();
	window.open("extensiones/tcpdf/pdf/cierre.php?fecha="+fecha,"_blank");
});

// Tabla Listado de Cierres guardados
$(".tablaCierres").DataTable({
	"ajax":"ajax/tabla_cierres.ajax.php",
	"deferRender":true,
	"retrieve":true,
	"processing":true,
	"order":[[0,"desc"]],
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