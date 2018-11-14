// Validamos que venga la variable capturaRangoR en el localStorage
if(localStorage.getItem("capturaRangoR")!=null){
	$("#daterange-btn2 span").html(localStorage.getItem("capturaRangoR"));
	cargarTablaRecibos(localStorage.getItem("fechaInicial"),localStorage.getItem("fechaFinal"));}
else{
	$("#daterange-btn2 span").html('<i class="fa fa-calendar"></i> Rango de Fecha ');
	cargarTablaRecibos(null,null);}

/* ========================================================================================================
												TABLA RECIBOS
======================================================================================================== */
// Función para cargar Tabla dinámica de Recibos
function cargarTablaRecibos(fechaInicial,fechaFinal){
	$(".tablaRecibos").DataTable({
		"ajax":"ajax/tabla_Recibo.ajax.php?fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal,
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

/* ========================================================================================================
											CREAR RECIBOS
======================================================================================================== */
// LIMPIAR EL TEXTAREA
$(".btnLimpiar").click(function(){
	$("#observacionesRecibo").val("");
	$("#metodoPagoRecibo").val("");
	$("#listaPagoRecibo").val("");
	$("#observacionesRecibo").focus();
});

// SELECCIONAR MÉTODO DE PAGO
$("#metodoPagoRecibo").change(function(){
	$("#listaMetodosPago").val(""); // Limpiamos el value
	var metodo=$(this).val(); // Capturamos el método
	if(metodo==""){ // Mostramos las cajas correspondientes al método de pago
		$(this).parent().parent().children(".cajasMetodoPago").html('');}
	else if(metodo=="Efectivo"){
		$(".cajasMetodoPago").addClass("col-sm-6 col-xs-12");
		$(this).parent().parent().children(".cajasMetodoPago").html(
			'<div class="input-group" style="width:100%">'+
				'<span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>'+
                '<input type="text" class="form-control pagoRecibo" placeholder="Ingrese el Pago realizado por el Cliente" style="height:38px">'+
                '<input type="hidden" name="pagoRecibo" id="pagoReciboSinP">'+
            '</div>');
		// Agregamos formato a las cajas
        $(".pagoRecibo").number(true,0);
        $(".pagoRecibo").focus();
        listarMetodosPagoRecibo(); // Listamos el método de pago
	}
	else if(metodo=="T"){
		$(".cajasMetodoPago").removeClass("col-sm-6 col-xs-12");
		$(this).parent().parent().children(".cajasMetodoPago").html(
			'<div class="col-sm-3 col-xs-12 pc">'+
	            '<div class="input-group" style="width:100%">'+
					'<span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>'+
	                '<input type="text" class="form-control pagoRecibo" placeholder="Ingrese el Pago realizado" style="height:38px">'+
	                '<input type="hidden" name="pagoRecibo" id="pagoReciboSinP">'+
	            '</div>'+
            '</div>'+
			'<div class="col-sm-3 col-xs-12 pc">'+
	            '<div class="input-group" style="width:100%">'+
	                '<input type="text" class="form-control" name="codigoTransaccion" id="codigoTransaccion" placeholder="Ingrese Código de Transacción" required style="height:38px">'+
	                '<span class="input-group-addon" id="spanAddon"><i class="fa fa-lock"></i></span>'+
	            '</div>'+
            '</div>');
		// Agregamos formato a las cajas
        $(".pagoRecibo").number(true,0);
        $(".pagoRecibo").focus();}
	else{
		$(".cajasMetodoPago").removeClass("col-sm-6 col-xs-12");
		$(this).parent().parent().children(".cajasMetodoPago").html(
			'<div class="col-sm-3 col-xs-12 pc">'+
	            '<div class="input-group" style="width:100%">'+
					'<span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>'+
	                '<input type="text" class="form-control pagoRecibo" placeholder="Ingrese el valor del Cheque" style="height:38px">'+
	                '<input type="hidden" name="pagoRecibo" id="pagoReciboSinP">'+
	            '</div>'+
            '</div>'+
			'<div class="col-sm-3 col-xs-12 pc">'+
	            '<div class="input-group" style="width:100%">'+
	            	'<span class="input-group-addon" id="spanAddon"><i class="fa fa-gg"></i></span>'+
	                '<input type="text" class="form-control" name="numCheque" id="numCheque" placeholder="Ingrese el Número del Cheque" required style="height:38px">'+
	            '</div>'+
            '</div>');
		// Agregamos formato a las cajas
        $(".pagoRecibo").number(true,0);
        $(".pagoRecibo").focus();}
});

// Aquí cada que presionamos un botón en el pago, lo enviamos a un input
$(".form-CrearRecibo").on("keyup","input.pagoRecibo",function(){
	var valor=$(this).val();
	$("#pagoReciboSinP").val(valor);
});

// CAMBIO A TRANSACCIÓN
$(".form-CrearRecibo").on("change","input#codigoTransaccion",function(){
	listarMetodosPagoRecibo(); // Listamos el método de pago
});

// CAMBIO A CHEQUE
$(".form-CrearRecibo").on("change","input#numCheque",function(){
	listarMetodosPagoRecibo(); // Listamos el método de pago
});

/* ========================================================================================================
											EDITAR RECIBOS
======================================================================================================== */
// Traemos los datos cuando se de click en el botón editar Recibo
$(".tablaRecibos").on("click","button.btnEditarRecibo",function(){
	var numRecibo=$(this).attr("idRecibo");
	var datos=new FormData();
	datos.append("numRecibo",numRecibo);
	$.ajax({
		url:"ajax/recibo.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			// console.log("respuesta", respuesta);
			$("#editarNumRecibo").val(respuesta["num_recibo"]);
			$("#editarClienteRecibo").val(respuesta["id_cliente"]);
			$("#editarObRecibo").val(respuesta["observaciones"]);
			var datos2=new FormData();
			datos2.append("numReciboDetalles",numRecibo);
			$.ajax({
				url:"ajax/recibo.ajax.php",
				type:"POST",
				data:datos2,
				cache:false,
				contentType:false,
				processData:false,
				dataType:"json",
				success:function(detalles){
					$(".detalles").empty(); // Limpiamos la caja detalles
					for(var i=0;i<detalles.length;i++){
						$(".detalles").append(
							'<!-- Pago -->'+
                            '<div class="col-sm-4 col-xs-12 fila">'+
                                '<div class="input-group" style="width:100%">'+
                                    '<span class="input-group-addon"><i class="fa fa-dollar"></i></span>'+
                                    '<input type="text" class="form-control pagosRecibos" id="'+(i+1)+'" value="'+detalles[i]["pago"]+'" required>'+
                                    '<input type="hidden" name="idPagosRecibos[]" value="'+detalles[i]["id"]+'">'+
                                    '<input type="hidden" name="pagosRecibos[]" id="sinP'+(i+1)+'" value="'+detalles[i]["pago"]+'">'+
                                '</div>'+
                            '</div>'+
                            '<!-- Método -->'+
                            '<div class="col-sm-4 col-xs-12 fila">'+
                                '<div class="input-group" style="width:100%">'+
                                    '<span class="input-group-addon"><i class="fa fa-tag"></i></span>'+
                                    '<input type="text" class="form-control" value="'+detalles[i]["metodo_pago"]+'" readonly>'+
                                '</div>'+
                            '</div>'+
                            '<!-- Fecha -->'+
                            '<div class="col-sm-4 col-xs-12 fila">'+
                                '<div class="input-group" style="width:100%">'+
                                    '<span class="input-group-addon"><i class="fa fa-calendar"></i></span>'+
                                    '<input type="text" class="form-control" value="'+detalles[i]["fecha"]+'" readonly>'+
                                '</div>'+
                            '</div>'
						);}
					$(".pagosRecibos").number(true,0);}
			});}
	});
});

// Modificación de pagos en Editar Recibo
$(".form-EditarRecibo").on("keyup","input.pagosRecibos",function(){
	var id=$(this).attr("id");
	var valor=$(this).val();
	$("#sinP"+id).val(valor);
});


/* ========================================================================================================
											PAGOS RECIBOS
======================================================================================================== */
// Agregamos formato a las cajas
$(".pagoAcumulado").number(true,0);
$(".pago").number(true,0);

// Traemos los datos cuando se de click en el botón Pagos Recibo
$(".tablaRecibos").on("click","button.btnPagosRecibo",function(){
	var numRecibo=$(this).attr("idRecibo");
	var datos=new FormData();
	datos.append("numRecibo",numRecibo);
	$.ajax({
		url:"ajax/recibo.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			$("#pagoNumRecibo").val(respuesta["num_recibo"]);
			$("#pagoCliente").val(respuesta["id_cliente"]);
			$("#pagoObservaciones").val(respuesta["observaciones"]);
			$("#pagoAcumulado").val(respuesta[6]);
			$("#pagoAcumuladoSinP").val(respuesta[6]);}
	});
});

// Selección de método de pago
$(".form-PagosRecibo").on("change","#pagoMetodo",function(){
	$(".form-PagosRecibo #pagoListaMetodos").val(""); // Limpiamos el value
	$(".pagoCajasMetodo").empty();
	var seleccion=$(this).val();
	// Mostramos las cajas correspondientes al método de pago
	if(seleccion==""){
		$(".pagoCajasMetodo").css("display","none");
		$(".pago").val(""); // Limpiamos la caja
		$(".pago").attr("disabled",true);}
	else if(seleccion=="Efectivo"){
		$(".pagoCajasMetodo").css("display","none");
		$(".pago").val(""); // Limpiamos la caja
		$(".pago").removeAttr("disabled");
		$("#pago").focus();
		pagoListarMetodos();}
	else if(seleccion=="T"){
		$(".pagoCajasMetodo").css("display","block");
		$(".pago").val(""); // Limpiamos la caja
		$(".pago").removeAttr("disabled");
		$(".pagoCajasMetodo").html(
            '<div class="input-group">'+
                '<input type="text" class="form-control" name="codigoTransaccion" id="codigoTransaccion" placeholder="Ingrese Código de Transacción" required>'+
                '<span class="input-group-addon" id="spanAddon"><i class="fa fa-lock"></i></span>'+
            '</div>');}
	else{
		$(".pagoCajasMetodo").css("display","block");
		$(".pago").val(""); // Limpiamos la caja
		$(".pago").removeAttr("disabled");
		$(".pagoCajasMetodo").html(
            '<div class="input-group">'+
            	'<span class="input-group-addon" id="spanAddon"><i class="fa fa-gg"></i></span>'+
                '<input type="text" class="form-control" name="numCheque" id="numCheque" placeholder="Ingrese el Número del Cheque" required>'+
            '</div>');}
});

// Cambio cuando hay una selección de Tarjeta
$(".form-PagosRecibo").on("change","input#codigoTransaccion",function(){
	pagoListarMetodos();
});

// Cambio cuando hay una selección de Tarjeta
$(".form-PagosRecibo").on("change","input#numCheque",function(){
	pagoListarMetodos();
});

// Aquí cada que presionamos un botón en el pago, lo enviamos a un input
$(".form-PagosRecibo").on("keyup","input.pago",function(){
	var valor=$(this).val();
	$("#pagoPagoSinP").val(valor);
});

/* ========================================================================================================
										VER DETALLES RECIBOS
======================================================================================================== */
// Traemos los datos cuando se de click en el botón editar Recibo
$(".tablaRecibos").on("click",".btnVerDRecibo",function(){
	// Limpiamos los textarea
	$("#detalleFechas").empty();
	$("#detalleMetodo").empty();
	$("#detallePagos").empty();
	var numRecibo=$(this).attr("idRecibo"); // Capturamos el atributo
	var sumador=0;
	$(".detalleTotal").number(true,0); // Formato para los números
	// Creamos la petición AJAX
	var datos=new FormData();
	datos.append("numRecibo",numRecibo);
	$.ajax({
		url:"ajax/recibo.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			$("#detalleNumRecibo").val(respuesta["num_recibo"]);
			$("#detalleCliente").val(respuesta["id_cliente"]);
			$("#detalleObservaciones").val(respuesta["observaciones"]);
			// Traemos los detalles de Pago
			var datos=new FormData();
			datos.append("numReciboDetalles",numRecibo);
			$.ajax({
				url:"ajax/recibo.ajax.php",
				type:"POST",
				data:datos,
				cache:false,
				contentType:false,
				processData:false,
				dataType:"json",
				success:function(detalles){
					for(var i=0;i<detalles.length;i++){
						if(detalles[i]["pago"]!=0){
							sumador=sumador+parseInt(detalles[i]["pago"]);
							var fecha=detalles[i]["fecha"].substring(0,10);
							var pago=new Number(detalles[i]["pago"]).toLocaleString();
							$("#detalleFechas").append(fecha+"\n");
							$("#detalleMetodo").append(detalles[i]["metodo_pago"]+"\n");
							$("#detallePagos").append("$ "+pago+"\n");}}
					$("#detalleTotal").val(sumador);}
			});}
	});
});

/* ========================================================================================================
											ELIMINAR RECIBOS
======================================================================================================== */
// Traemos los datos cuando se de click en el botón editar Recibo
$(".tablaRecibos").on("click",".btnEliminarRecibo",function(){
	var numRecibo=$(this).attr("idRecibo");
	swal({
		type: "warning",
		title: "Advertencia",
		text: "¿Está seguro de querer borrar el Recibo? ¡Si no está seguro, puede cancelar la acción!",
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: "¡Si, eliminar recibo!",
		cancelButtonText: "Cancelar",
	}).then(function(result){
		if(result.value){
			var datos=new FormData();
			datos.append("reciboEliminar",numRecibo);
			$.ajax({
				url:"ajax/recibo.ajax.php",
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
								window.location="admon-recibos";}
						});}}
			});}
	});
});

/* ========================================================================================================================
IMPRIMIR RECIBOS
======================================================================================================================== */
$(".tablaRecibos").on('click',"button.btnImprimirRecibo",function(){
	var recibo=$(this).attr("recibo");
	// Le solicitamos a windows que me abra otra ventana
	window.open("extensiones/tcpdf/pdf/recibo.php?recibo="+recibo,"_blank");
});

/* ========================================================================================================================
RANGO DE FECHAS (DATE RANGE)
======================================================================================================================== */
if(window.matchMedia("(max-width:768px)").matches){
	$("#daterange-btn2").removeClass("pull-right");
	$("#daterange-btn2").css({"margin-top":"10px"});
}

$("#daterange-btn2").daterangepicker({
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
	$("#daterange-btn2 span").html(start.format('MMMM DD, YYYY')+' - '+end.format('MMMM DD, YYYY'));
	// Le cambiamos el html al botón cancelar, para que no genere discordia con el botón Cancelar del módulo Ventas
	$(".daterangepicker.opensleft .range_inputs .cancelBtn").html("Cancelar Rango");
	// Capturamos la fecha inicial y final con el formato de la BD
	var fechaInicial=start.format('YYYY-MM-DD');
	var fechaFinal=end.format('YYYY-MM-DD');
	// Capturamos el rango que se genera
	var capturaRango=$("#daterange-btn2 span").html();
	// Guardamos el rango en una variable del localStorage
	localStorage.setItem("capturaRangoR",capturaRango);
	localStorage.setItem("fechaInicialR",fechaInicial);
	localStorage.setItem("fechaFinalR",fechaFinal);
	// Recargamos la tabla con la información para ser mostrada en la tabla
	$(".tablaRecibos").DataTable().destroy(); // Destruimos la tabla
	cargarTablaRecibos(fechaInicial,fechaFinal);
});

// Acción al cancelar el rango de Fechas
$(".daterangepicker.opensleft .range_inputs .cancelBtn").on("click",function(){
	console.log();
	// Limpiamos la variable capturaRangoR y el localStorage
	localStorage.removeItem("capturaRangoR");
	localStorage.removeItem("fechaInicialR");
	localStorage.removeItem("fechaFinalR");
	localStorage.clear();
	if($(this).html()=="Cancelar Rango"){
		// Redireccionamos a la página de ventas
		window.location="admon-recibos";}
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
		$("#daterange-btn2 span").html("Hoy");
		// Guardamos el rango en una variable del localStorage
		localStorage.setItem("capturaRangoR","Hoy");
		localStorage.setItem("fechaInicialR",fechaInicial);
		localStorage.setItem("fechaFinalR",fechaFinal);
		// Recargamos la tabla con la información para ser mostrada en la tabla
		$(".tablaRecibos").DataTable().destroy();
		cargarTablaRecibos(fechaInicial,fechaFinal);
	}
});






/* ============================================= FUNCIONES ============================================= */
// Función para llenar un array objeto con los productos separados
function llenarArrayProductosRecibo(propiedad,valor){
	arrayProductosRecibo[propiedad]=valor;
}

// Mostrar valores y sumatorias
function valoresSumatorias(){
	var sumaIvas=0;
	var sumaTotales=0;
	for(var i in arrayProductosRecibo){
		sumaIvas=sumaIvas+parseInt(arrayProductosRecibo[i][0]);
		sumaTotales=sumaTotales+parseInt(arrayProductosRecibo[i][1]);
		var subtotal=sumaTotales-sumaIvas;
		$("#subtotalRecibo").val(subtotal);
		$("#subtotalReciboSinP").val(subtotal);
		$("#ivaRecibo").val(sumaIvas);
		$("#ivaReciboSinP").val(sumaIvas);
		$("#totalRecibo").val(sumaTotales);
		$("#totalReciboSinP").val(sumaTotales);
		$(".subtotalRecibo").number(true,0); // Formato para los números
		$(".ivaRecibo").number(true,0);
		$(".totalRecibo").number(true,0);
	}
}

// Función para evitar enter sobre input
function noEnter(e){
	if(e.keyCode==13){
		return false;}
	return true;
}

// Listar el método de pago al Crear el recibo
function listarMetodosPagoRecibo(){
	if($("#metodoPagoRecibo").val()=="Efectivo"){
		$("#listaMetodosPago").val("Efectivo");}
	else if($("#metodoPagoRecibo").val()=="T"){
		$("#listaMetodosPago").val($("#metodoPagoRecibo").val()+"-"+$("#codigoTransaccion").val());}
	else{
		$("#listaMetodosPago").val($("#metodoPagoRecibo").val()+"-"+$("#numCheque").val());}
}

// Listar el método de pago al Editar el recibo
function pagoListarMetodos(){
	if($("#pagoMetodo").val()=="Efectivo"){
		$("#pagoListaMetodos").val("Efectivo");}
	else if($("#pagoMetodo").val()=="T"){
		$("#pagoListaMetodos").val($("#pagoMetodo").val()+"-"+$("#codigoTransaccion").val());}
	else{
		$("#pagoListaMetodos").val($("#pagoMetodo").val()+"-"+$("#numCheque").val());}
}