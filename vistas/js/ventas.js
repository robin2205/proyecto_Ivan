// Validamos que venga la variable capturaRango en el localStorage
if(localStorage.getItem("capturaRango")!=null){
	$("#daterange-btn span").html(localStorage.getItem("capturaRango"));
	cargarTablaVentas(localStorage.getItem("fechaInicial"),localStorage.getItem("fechaFinal"));
	localStorage.removeItem("objeto");
}
else{
	$("#daterange-btn span").html('<i class="fa fa-calendar"></i> Rango de Fecha ');
	localStorage.removeItem("objeto");
	cargarTablaVentas(null,null);
}

/* ========================================================================================================
												TABLA VENTAS
======================================================================================================== */
// Función para cargar Tabla dinámica de Ventas
function cargarTablaVentas(fechaInicial,fechaFinal){
	// $.ajax({
	// 	url:"ajax/tabla_Ventas.ajax.php?perfil="+$("#perfilOculto").val()+"&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal,
	// 	success:function(respuesta){
	// 		console.log("respuesta", respuesta);}
	// });
	$(".tablaVentas").DataTable({
		"ajax":"ajax/tabla_Ventas.ajax.php?perfil="+$("#perfilOculto").val()+"&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal,
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
}


/* ========================================================================================================================
EDITAR VENTAS
======================================================================================================================== */
$(".tablaVentas").on('click',"button.btnEditarVenta",function(){
	var idVenta=$(this).attr("idVenta");
	window.location="index.php?ruta=editar-venta&idVenta="+idVenta;
});
// Formato para los números en las cajas
$(".precioProducto").number(true,0);
$(".valorUni").number(true,0);
$("#totalVenta").number(true,0);
$(".subtotalVenta").number(true,0);
$(".iva").number(true,0);

/* ========================================================================================================================
ANULAR VENTAS
======================================================================================================================== */
$(".tablaVentas").on('click',"button.btnEliminarVenta",function(){
	var idVenta=$(this).attr("idVenta");
	swal({
		type: "warning",
		title: "Advertencia",
		text: "¿Está seguro de Anular la Venta? ¡Si no está seguro, puede cancelar la acción!",
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: "¡Si, anular Venta!",
		cancelButtonText: "Cancelar",
	}).then(function(result){
		if(result.value){
			var datos=new FormData();
			datos.append("idVenta",idVenta);
			$.ajax({
				url:"ajax/ventas.ajax.php",
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
							text: "¡La venta fue Anulada con éxito!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="ventas";}
						});}
				}
			});
		}
	});
});


/* ========================================================================================================================
IMPRIMIR FACTURAS
======================================================================================================================== */
$(".tablaVentas").on('click',"button.btnImprimirFactura",function(){
	// Capturamos el atributo factura
	var factura=$(this).attr("factura");
	// Le solicitamos a windows que me abra otra ventana
	window.open("extensiones/tcpdf/pdf/factura.php?factura="+factura,"_blank");
});

if(window.matchMedia("(max-width:768px)").matches){
	$("#daterange-btn").removeClass("pull-right");
	$("#daterange-btn").css({"margin-top":"10px"});
}

/* ========================================================================================================================
RANGO DE FECHAS (DATE RANGE)
======================================================================================================================== */
$("#daterange-btn").daterangepicker({
	ranges:{
		'Hoy':[moment(),moment()],
		'Ayer':[moment().subtract(1,'days'),moment().subtract(1,'days')],
		'Últimos 7 días':[moment().subtract(6,'days'),moment()],
		'Últimos 30 días':[moment().subtract(29,'days'),moment()],
		'Este mes':[moment().startOf('month'),moment().endOf('month')],
		'Último mes':[moment().subtract(1,'month').startOf('month'),moment().subtract(1,'month').endOf('month')]
	},
	startDate:moment(),
	endDate:moment()
},
function(start,end){
	$("#daterange-btn span").html(start.format('MMMM DD, YYYY')+' - '+end.format('MMMM DD, YYYY'));
	// Capturamos la fecha inicial y final con el formato de la BD
	var fechaInicial=start.format('YYYY-MM-DD');
	var fechaFinal=end.format('YYYY-MM-DD');
	// Capturamos el rango que se genera
	var capturaRango=$("#daterange-btn span").html();
	// Guardamos el rango en una variable del localStorage
	localStorage.setItem("capturaRango",capturaRango);
	localStorage.setItem("fechaInicial",fechaInicial);
	localStorage.setItem("fechaFinal",fechaFinal);
	// Recargamos la tabla con la información para ser mostrada en la tabla
	$(".tablaVentas").DataTable().destroy(); // Destruimos la tabla
	cargarTablaVentas(fechaInicial,fechaFinal);
});

// Acción al cancelar el rango de Fechas
$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click",function(){
	// Limpiamos la variable capturaRango y el localStorage
	localStorage.removeItem("capturaRango");
	localStorage.removeItem("fechaInicial");
	localStorage.removeItem("fechaFinal");
	localStorage.clear();
	// Redireccionamos a la página de ventas
	window.location="ventas";
});

// Capturar hoy
$(".daterangepicker.opensleft .ranges li").on("click",function(){
	var hoy=$(this).attr("data-range-key");
	if(hoy=="Hoy"){
		// Capturamos el día de hoy
		var fecha=new Date();
		var dia=fecha.getDate();
		dia=optimizar(dia);
		var mes=fecha.getMonth()+1;
		mes=optimizar(mes);
		var year=fecha.getFullYear();
		var fechaInicial=year+"-"+mes+"-"+dia;
		var fechaFinal=year+"-"+mes+"-"+dia;
		$("#daterange-btn span").html("Hoy");
		// Guardamos el rango en una variable del localStorage
		localStorage.setItem("capturaRango","Hoy");
		localStorage.setItem("fechaInicial",fechaInicial);
		localStorage.setItem("fechaFinal",fechaFinal);
		// Recargamos la tabla con la información para ser mostrada en la tabla
		$(".tablaVentas").DataTable().destroy();
		cargarTablaVentas(fechaInicial,fechaFinal);
	}
});
function optimizar(dato){
	if(dato<10){
		dato='0'+dato;}
	return dato;
}