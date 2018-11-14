// Capturamos el perfil Oculto
var perfilOculto=$("#perfilOculto").val();
// Cargar Tabla dinámica
// $.ajax({
// 	url:"ajax/tabla_productos.ajax.php",
// 	success:function(respuesta){
// 		console.log("respuesta", respuesta);}
// });
$(".tablaProductos").DataTable({
	"ajax":"ajax/tabla_productos.ajax.php",
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

// MOSTRAR EL PRIMER PRECIO DE VENTA
$("#ivaProducto").keypress(function(e){
	if(e.which==13){
		PVP("precioCompra","ivaProducto","precioVentaNuevo","valorIva");
	}
});
$("#ivaProducto").change(function(){
	PVP("precioCompra","ivaProducto","precioVentaNuevo","valorIva");
});


// EDITAR PRODUCTO
$(".tablaProductos tbody").on("click","button.btnEditarProducto",function(){
	var idProducto=$(this).attr("idProducto");
	var datos=new FormData();
	datos.append("idProducto",idProducto);
	$.ajax({
		url:"ajax/productos.ajax.php",
			method:"POST",
			data:datos,
			cache:false,
			contentType:false,
			processData:false,
			dataType:"json",
			success:function(respuesta){
				$("#editarDescripcionProducto").val(respuesta["descripcion"]);
				$("#editarStockProducto").val(respuesta["stock"]);
				$("#editarPrecioCompra").val(respuesta["precio_compra"]);
				$("#editarIvaProducto").val(respuesta["iva"]);
				$("#valorIvaEditado").val(respuesta["valor_Iva"]);
				$("#editarPrecioVenta").val(respuesta["precio_venta"]);
				$("#editarCodigoProducto").val(respuesta["codigo"]);
			}
	});
});

// MODIFICAMOS EL PVP SI SE CAMBIA EL IVA DEL PRODUCTO EN EDITAR
$("#editarIvaProducto").keypress(function(e){
	if(e.which==13){
		PVP("editarPrecioCompra","editarIvaProducto","editarPrecioVenta","valorIvaEditado");
	}
});
$("#editarIvaProducto").change(function(){
	PVP("editarPrecioCompra","editarIvaProducto","editarPrecioVenta","valorIvaEditado");
});

// ELIMINAR PRODUCTO
$(".tablaProductos tbody").on("click","button.btnEliminarProducto",function(){
	var idProducto=$(this).attr("idProducto");
	swal({
		type: "warning",
		title: "Advertencia",
		text: "¿Está seguro de querer borrar el Producto? ¡Si no está seguro, puede cancelar la acción!",
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: "¡Si, eliminar producto!",
		cancelButtonText: "Cancelar",
	}).then(function(result){
		if(result.value){
			var datos=new FormData();
			datos.append("productoEliminar",idProducto);
			$.ajax({
				url:"ajax/productos.ajax.php",
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
								window.location="productos";}
						});}
				}
			});}
	});
});

/* ================================================ FUNCIONES ================================================ */
function PVP(cajaPrecioCompra,cajaIvaProducto,cajaNuevoPVP,cajaValorIva){
	// Válidamos si el precio de compra no esta vacio
	if($("#"+cajaPrecioCompra).val()!=""){
		var valorIva=Number(($("#"+cajaPrecioCompra).val()*$("#"+cajaIvaProducto).val()/100));
		$("#"+cajaValorIva).val(valorIva);
		var pvp=Number(($("#"+cajaPrecioCompra).val()*$("#"+cajaIvaProducto).val()/100))+Number($("#"+cajaPrecioCompra).val());
		$("#"+cajaNuevoPVP).val(pvp);}
}