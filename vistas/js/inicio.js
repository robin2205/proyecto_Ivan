// Evitamos el evento del Submit sobre el botón, así solo funciona con clic
$(".form-CrearVenta").keypress(function(e){
	if(e.which==13){
		return false;}
});

// SELECCIONAMOS EL CLIENTE
$("#seleccionCliente").change(function(){
	// Capturamos el valor
	var identificacion=$(this).val();
	// Petición AJAX
	var datos=new FormData();
	datos.append('identificacion',identificacion);
	$.ajax({
		url:"ajax/clientes.ajax.php",
		type:"POST",
		data:datos,
		cache:false,
		contentType:false,
		processData:false,
		dataType:"json",
		success:function(respuesta){
			if(respuesta==false){
				// Mostramos el botón para agregar Cliente
				$("#seleccionCliente").parent().children('.btoAgragarCli').removeClass('hidden');
				// Para que no se repita el mensaje
				if($(".msgError").length==0){
					$("#seleccionCliente").parent().after('<div class="alert alert-danger alert-dismissable msgError" style="margin-top:5px">'+
													'<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>'+
												    '<strong>Error!</strong> El documento no existe, por favor verifique o Ingrese un nuevo Cliente.'+
												'</div>');}
				$(".nombreCliente").empty();
				$(".datosExtras").empty();
				$("#seleccionCliente").focus();
			}
			else{
				// Limpiamos las cajas
				$(".nombreCliente, .datosExtras").empty();
				// Ocultamos el botón de Agregar Cliente si esta habilitado
				$("#seleccionCliente").parent().children('.btoAgragarCli').addClass('hidden');
				$(".msgError").remove();
				$("#idCliente").val(respuesta["id"]);
				// Mostramos el nombre
				$(".nombreCliente").append(
                    '<div class="input-group" style="width: 100%">'+
                        '<span class="input-group-addon" id="spanAddon"><i class="fa fa-vcard"></i></span>'+
                        '<input type="text" class="form-control" value="'+respuesta["nombre"]+'" readonly style="height:38px">'+
                    '</div>');
				// Mostramos datos extras
				$(".datosExtras").append(
					'<!-- Correo -->'+
                    '<div class="col-sm-6 col-xs-12 pc">'+
                        '<div class="input-group" style="width: 100%">'+
	                        '<span class="input-group-addon" id="spanAddon"><i class="fa fa-envelope"></i></span>'+
	                        '<input type="text" class="form-control" value="'+respuesta["email"]+'" readonly style="height:38px">'+
	                    '</div>'+
                    '</div>'+

                    '<!-- Contacto -->'+
                    '<div class="col-sm-6 col-xs-12">'+
                        '<div class="input-group" style="width: 100%">'+
	                        '<span class="input-group-addon" id="spanAddon"><i class="fa fa-phone"></i></span>'+
	                        '<input type="text" class="form-control" value="'+respuesta["contacto"]+'" readonly style="height:38px">'+
	                    '</div>'+
                    '</div>');
				$("#seleccionProducto").focus();
			}
		}
	});
});

// AGREGANDO PRODUCTOS
var numProducto=0;
var arrayValoresIva={}; // Creamos un Objeto
if(localStorage.getItem("objeto")!=null){
	arrayValoresIva=JSON.parse(localStorage.getItem("objeto"));
	activarTipoPago(); // Activamos o desactivamos la opción de Tipo_Pago
}
$("#seleccionProducto").keypress(function(e){
	if(e.which==13){
		numProducto++;
		var producto=$(this).val();
		// Realizamos una petición AJAX para traer todo los productos
		var datos=new FormData();
		datos.append("producto",producto);
		$.ajax({
			url:"ajax/ventas.ajax.php",
			type:"POST",
			data:datos,
			cache:false,
			contentType:false,
			processData:false,
			dataType:"json",
			success:function(respuesta){
				if(respuesta!=false){
					// Removemos el mensaje de error si el producto existe
					$(".msgError").remove();
					// Creamos la variable bandera, que nos permite saber si un producto ya fue ingresado
					var bandera=false;
					// Con el ciclo for in recorremos el objeto para validar si hay una propiedad igual al código ingresado
					for(var codigo in arrayValoresIva){
						if(codigo==$("#seleccionProducto").val()){
							bandera=true;}}
					if(bandera==false){
						$(".nuevoProducto").append(
							'<div id="itemVenta">'+
								'<!-- Descripción del Producto -->'+
								'<div class="col-sm-5 col-xs-12" id="divDescripcion">'+
	                                '<div class="input-group" style="margin-bottom:10px; width:100%">'+
	                                    '<span class="input-group-addon">'+
	                                        '<button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'+respuesta["id"]+'"><i class="fa fa-times"></i></button>'+
	                                    '</span>'+
	                                    '<input type="text" class="form-control productoSeleccionado" name="productoSeleccionado" id="productoSeleccionado'+numProducto+'" value="'+respuesta["descripcion"]+'" idProducto="" readonly style="height: 38px">'+
	                                '</div>'+
	                            '</div>'+

	                            '<!-- Cantidad del Producto -->'+
	                            '<div class="col-sm-2 col-xs-12 divStock" id="divStock">'+
	                                '<div class="input-group" style="margin-bottom:10px; width:100%">'+
	                                    '<span class="input-group-addon" id="spanIcono"><i class="fa fa-arrow-up"></i></span>'+
	                                    '<input type="number" class="form-control cantidadProducto" name="cantidadProducto" id="cantidadProducto" value="1" stock="'+respuesta["stock"]+'" placeholder="0" min="1" max="'+respuesta["stock"]+'" codigo="'+respuesta["codigo"]+'" required style="height:38px;">'+
	                                '</div>'+
	                            '</div>'+

	                            '<!-- Valor Unitario -->'+
	                            '<div class="col-sm-2 col-xs-12">'+
	                                '<div class="input-group" style="margin-bottom:10px; width:100%">'+
	                                    '<span class="input-group-addon" id="spanAddon"><i class="fa fa-tag"></i></span>'+
	                                    '<input type="text" class="form-control valorUni" value="'+respuesta["precio_venta"]+'" readonly style="height:38px">'+
	                                '</div>'+
	                            '</div>'+

	                            '<!-- Precio del Producto -->'+
	                            '<div class="col-sm-3 col-xs-12 divPrecio" id="divPrecio">'+
	                                '<div class="input-group" style="margin-bottom:10px; width:100%">'+
	                                    '<span class="input-group-addon" id="spanAddon"><i class="ion ion-social-usd"></i></span>'+
	                                    '<input type="text" class="form-control precioProducto" name="precioProducto" id="precioProducto" precioReal="'+respuesta["precio_venta"]+'" value="'+respuesta["precio_venta"]+'" readonly style="height:38px">'+
	                                '</div>'+
	                            '</div>'+
	                        '</div>');
						$(".precioProducto").number(true,0); // Formato para los números
						$(".valorUni").number(true,0);
						$(".subtotalVenta").number(true,0);
						$(".iva").number(true,0);
						$("#seleccionProducto").val(""); // Limpiamos la caja del producto
						sumarTotalPrecios(); // Sumar total de Precios
						llenarArrayValoresIva(respuesta["codigo"],respuesta["valor_Iva"]);
						activarTipoPago(); // Activamos o desactivamos la opción de Tipo_Pago
						listarProductos(); // Agrupamos productos en formato JSON
						// Mostramos el Subtotal
						$("#subtotalVenta").val($("#totalVenta").val()-$("#iva").val());
						$("#subtotalVentaSinP").val($("#totalVenta").val()-$("#iva").val());
					}
					else{
						// Para que no se repita el mensaje
						if($(".msgError").length==0){
							$("#seleccionProducto").parent().after(
								'<div class="alert alert-danger alert-dismissable msgError" style="margin-top:5px">'+
									'<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>'+
								    '<strong>Error!</strong> El producto ya fue ingresado, por favor verifique o aumente la cantidad.'+
								'</div>');}
						$("#seleccionProducto").val("");}
					acumularValorIva(); // Sumamos los valores del IVA
				}
				else{
					// Para que no se repita el mensaje
					if($(".msgError").length==0){
						$("#seleccionProducto").parent().after(
							'<div class="alert alert-danger alert-dismissable msgError" style="margin-top:5px">'+
								'<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>'+
							    '<strong>Error!</strong> El producto no existe, por favor verifique.'+
							'</div>');}
					$("#seleccionProducto").val("");
				}}});}
});

// MODIFICACIÓN DE LA CANTIDAD
$(".form-CrearVenta").on("change","input.cantidadProducto",function(){
	acumularValorIva(); // Sumamos los valores del IVA
	var precio=$(this).parent().parent().siblings("#divPrecio").children().children(".precioProducto");
	var precioFinal=precio.attr("precioReal")*$(this).val();
	precio.val(precioFinal);
	// Validamos que la cantidad no superé la que hay en Inventario
	if(Number($(this).val())>Number($(this).attr("stock"))){
		if($(".msgError").length==0){
			$(this).parent().parent().parent().parent().after(
				'<div class="alert alert-danger alert-dismissable msgError" id="mensajeError">'+
					'<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>'+
				    '<strong>Error!</strong> La cantidad superó el Inventario. Solo hay '+$(this).attr("stock")+' Unidades'+
				'</div>');}
		$(this).val(1);
		var precioFinal=$(this).val()*precio.attr("precioReal");
		precio.val(precioFinal);
		// Sumar total de Precios
		sumarTotalPrecios();
		$(this).focus();
	}
	sumarTotalPrecios(); // Sumar total de Precios
	listarProductos(); // Agrupamos productos en formato JSON
	// Mostramos el Subtotal
	$("#subtotalVenta").val($("#totalVenta").val()-$("#iva").val());
	$("#subtotalVentaSinP").val($("#totalVenta").val()-$("#iva").val());
});

// SELECCIONAR MÉTODO DE PAGO
$("#metodoPagoVenta").change(function(){
	// Capturamos el método
	var metodo=$(this).val();
	// Mostramos las cajas correspondientes al método de pago
	if(metodo==""){
		$(this).parent().parent().children(".cajasMetodoPago").html('');}
	else if(metodo=="Efectivo"){
		$(this).parent().parent().children(".cajasMetodoPago").html(
			'<div class="col-sm-6 col-xs-12 capturarValorEfectivo pc">'+
                '<div class="input-group" style="width:100%">'+
                    '<span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>'+
					'<input type="text" class="form-control nuevoValorEfectivo" placeholder="Ingrese el Pago" required style="height:38px">'+
					'<input type="hidden" name="valorEfectivo" id="valorEfectivo">'+
                '</div>'+
            '</div>'+
            '<div class="col-sm-6 col-xs-12 capturarCambioEfectivo">'+
                '<div class="input-group" style="width:100%">'+
                    '<span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>'+
					'<input type="text" class="form-control nuevoCambioEfectivo" placeholder="Aquí le dira el Cambio" readonly style="height:38px">'+
                '</div>'+
            '</div>');
        // Válidamos la resolución de la pantalla
		if(window.matchMedia("(min-width:768px)").matches){
			// Cambiamos el tamaño de las cajas por estética
			$(this).parent().removeClass('col-sm-5');
			$(this).parent().addClass('col-sm-4');
			$(this).parent().parent().children(".cajasMetodoPago").removeClass('col-sm-7');
			$(this).parent().parent().children(".cajasMetodoPago").addClass('col-sm-8');
			// Modificamos los margenes de la caja
			$(this).parent().parent().children(".cajasMetodoPago").css({"padding-left":0,"padding-right":0});
			$(this).parent().parent().children(".cajasMetodoPago").children(".capturarValorEfectivo").css({"padding-left":0});
			$(this).parent().parent().children(".cajasMetodoPago").children(".capturarCambioEfectivo").css({"padding-left":0});}
		else{
			$(this).parent().parent().children(".cajasMetodoPago").css({"padding-left":0,"padding-right":0,"margin-top":"5px",});}
        // Agregamos formato a las cajas
        $(".nuevoValorEfectivo").number(true,0);
        $(".nuevoCambioEfectivo").number(true,0);
        listarMetodosPago(); // Listamos el método de pago
	}
	else if(metodo=="T"){
		// Válidamos la resolución de la pantalla
		if(window.matchMedia("(min-width:768px)").matches){
			// Cambiamos el tamaño de las cajas por estética
			$(this).parent().removeClass('col-sm-4');
			$(this).parent().addClass('col-sm-5');
			$(this).parent().parent().children(".cajasMetodoPago").removeClass('col-sm-8');
			$(this).parent().parent().children(".cajasMetodoPago").addClass('col-sm-7');
			// Modificamos los margenes de la caja
			$(this).parent().parent().children(".cajasMetodoPago").removeAttr("style");}
		else{
			$(this).parent().parent().children(".cajasMetodoPago").removeAttr("style");
			$(this).parent().parent().children(".cajasMetodoPago").css({"margin-top":"5px"});}
		$(this).parent().parent().children(".cajasMetodoPago").html(
            '<div class="input-group" style="width:100%">'+
                '<input type="text" class="form-control" id="codigoTransaccion" placeholder="Código Transacción" required style="height:38px">'+
                '<span class="input-group-addon" id="spanAddon"><i class="fa fa-lock"></i></span>'+
            '</div>');
	}
	else if(metodo=="C"){
		// Válidamos la resolución de la pantalla
		if(window.matchMedia("(min-width:768px)").matches){
			// Cambiamos el tamaño de las cajas por estética
			$(this).parent().removeClass('col-sm-4');
			$(this).parent().addClass('col-sm-5');
			$(this).parent().parent().children(".cajasMetodoPago").removeClass('col-sm-8');
			$(this).parent().parent().children(".cajasMetodoPago").addClass('col-sm-7');
			// Modificamos los margenes de la caja
			$(this).parent().parent().children(".cajasMetodoPago").removeAttr("style");}
		else{
			$(this).parent().parent().children(".cajasMetodoPago").removeAttr("style");
			$(this).parent().parent().children(".cajasMetodoPago").css({"margin-top":"5px"});}
		$(this).parent().parent().children(".cajasMetodoPago").html(
            '<div class="input-group" style="width:100%">'+
            	'<span class="input-group-addon" id="spanAddon"><i class="fa fa-gg"></i></span>'+
                '<input type="text" class="form-control" id="numCheque" placeholder="Ingrese el número de Cheque" required style="height:38px">'+
            '</div>');
	}
});

// CAMBIO EN EFECTIVO
$(".form-CrearVenta").on("change","input.nuevoValorEfectivo",function(){
	// Capturamos el valor ingresado
	var efectivo=$(this).val();
	$(".form-CrearVenta input#valorEfectivo").val(efectivo);
	var cambio=Number(efectivo)-Number($("#totalVenta").val());
	if(cambio<0){
		// Limpiamos la caja para el nuevo ingreso
		$(this).val("");
		// Mostramos la alerta
		if($(".msgError").length==0){
			$(this).parent().parent().append(
					'<div class="alert alert-danger alert-dismissable msgError" style="margin-top:5px;">'+
						'<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>'+
					    '<strong>¡Error!</strong> El pago realizado es menor a la cantidad que debe Cancelar, por favor verifique.'+
					'</div>');}}
	else{
		$(".msgError").remove();
		$(".nuevoCambioEfectivo").val(cambio);}
});

// CAMBIO DE TRANSACCIÓN CON TARJETA
$(".form-CrearVenta").on("change","input#codigoTransaccion",function(){
	listarMetodosPago(); // Listamos el método de pago
});

// CAMBIO DE TRANSACCIÓN CON CHEQUE
$(".form-CrearVenta").on("change","input#numCheque",function(){
	listarMetodosPago(); // Listamos el método de pago
});

// QUITAR PRODUCTO DE LA VENTA
localStorage.removeItem("quitarProducto");
$(".form-CrearVenta").on("click","button.quitarProducto",function(){
	$(this).parent().parent().parent().parent().remove(); // Eliminamos la línea pariente de ese botón
	acumularValorIva(); // Sumamos los valores del IVA
	sumarTotalPrecios(); // Sumar total de Precios
	listarProductos(); // Agrupamos productos en formato JSON
	activarTipoPago(); // Activamos o desactivamos la opción de Tipo_Pago
	// Mostramos el Subtotal
	$("#subtotalVenta").val($("#totalVenta").val()-$("#iva").val());
	$("#subtotalVentaSinP").val($("#totalVenta").val()-$("#iva").val());
});

/* ============================================= FUNCIONES ============================================= */
// Sumar todos los Precios
function sumarTotalPrecios(){
	// Obtenemos un array con todos los precios que hay en la clase .precioProducto
	var precioItem=$(".precioProducto");
	var arraySumaPrecio=[];
	for(var i=0;i<precioItem.length;i++){
		arraySumaPrecio.push(Number($(precioItem[i]).val()));
	}

	function sumarPrecios(total,numero){
		return total+numero;}
	// Válidamos que la caja .nuevoProducto no este vacía
	if($(".nuevoProducto").children().length!=0){
		var sumaTotalPrecio=arraySumaPrecio.reduce(sumarPrecios);}
	$("#totalVenta").val(sumaTotalPrecio);
	$("#totalVentaSinP").val(sumaTotalPrecio);
	$("#totalVenta").attr("total",sumaTotalPrecio);
	// Formato para los números
	$("#totalVenta").number(true,0);
}

// Agrupar o Listar los productos seleccionado para la venta
function listarProductos(){
	// Creamos un array
	var listaProducto=[];
	// Capturamos los datos
	var descripcion=$(".productoSeleccionado");
	var cantidad=$(".cantidadProducto");
	var precio=$(".precioProducto");
	for(var i=0;i<descripcion.length;i++){
		var nuevoStock=$(cantidad[i]).attr("stock")-$(cantidad[i]).val();
		listaProducto.push({
			"codigo":$(cantidad[i]).attr("codigo"),
			"descripcion":$(descripcion[i]).val(),
			"cantidad":$(cantidad[i]).val(),
			"stock":nuevoStock,
			"precio":$(precio[i]).attr("precioReal"),
			"total":$(precio[i]).val()
		});
	}
	$("#listaProductos").val(JSON.stringify(listaProducto));
}

// Activación Tipo de Pago
function activarTipoPago(){
	if($(".nuevoProducto").children().length!=0){
		$("#metodoPagoVenta").removeAttr("disabled");
		$("#seleccionProducto").removeAttr("required");}
	else{
		$("#metodoPagoVenta").attr("disabled",true);
		$("#seleccionProducto").attr("required",true);
		$("#listaProductos").val("");}
}

// Sumatoria del valor Iva
function acumularValorIva(){
	var cajas=$(".form-CrearVenta input.cantidadProducto");
	var acumulador=0;
	for(var i=0;i<cajas.length;i++){
		var multi=0;
		var codigoAtr=$(cajas[i]).attr("codigo"); // Capturamos el atributo código
		var valordelCod=arrayValoresIva[codigoAtr]; // Capturamos valor del Iva del código
		var multi=parseInt(valordelCod)*parseInt($(cajas[i]).val()); // Múltiplicamos por su cantidad seleccionada
		acumulador=acumulador+multi;}
	$("#iva").val(acumulador);
	$("#ivaSinP").val(acumulador);
}

// Función para llenar un array con los valores del IVA por producto
function llenarArrayValoresIva(propiedad,valor){
	arrayValoresIva[propiedad]=valor;
}

// Listar el método de pago
function listarMetodosPago(){
	$("#listaMetodosPago").val("");
	if($("#metodoPagoVenta").val()=="Efectivo"){
		$("#listaMetodosPago").val("Efectivo");}
	else if($("#metodoPagoVenta").val()=="T"){
		$("#listaMetodosPago").val($("#metodoPagoVenta").val()+"-"+$("#codigoTransaccion").val());}
	else{
		$("#listaMetodosPago").val($("#metodoPagoVenta").val()+"-"+$("#numCheque").val());}
}