<?php
// Clase del Controlador
class ControladorProductos{
	// Método para traer los productos de la Base de Datos
	static public function ctrTraerProductos($item,$valor,$orden){
		$tabla="productos";
		$respuesta=ModeloProductos::mdlTraerProductos($tabla,$item,$valor,$orden);
		return $respuesta;
	}

	// Método para guardar un producto en la Base de Datos
	public function ctrCrearProducto(){
		if(isset($_POST["categoriaProducto"]) || isset($_POST["codigoProducto"])){
			# Válidamos con preg_match la información que se esta recibiendo
			if(preg_match('/^[0-9]+$/',$_POST["categoriaProducto"]) && preg_match('/^[a-zA-Z0-9]+$/',$_POST["codigoProducto"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["descripcionProducto"]) && preg_match('/^[0-9]+$/',$_POST["stockProducto"]) && preg_match('/^[0-9.,]+$/',$_POST["precioCompra"]) && preg_match('/^[0-9]+$/',$_POST["ivaProducto"]) && preg_match('/^[0-9]+$/',$_POST["valorIva"]) && preg_match('/^[0-9.,]+$/',$_POST["precioVentaNuevo"])){
				$tabla="productos";
				# Ponemos mayúsculas iniciales a la descripción, pero convertimos el string en minúsculas primero
				$_POST["descripcionProducto"]=ucwords(mb_strtolower($_POST["descripcionProducto"]));
				$datos=array("id_categoria"=>$_POST["categoriaProducto"],"codigo"=>$_POST["codigoProducto"],"descripcion"=>$_POST["descripcionProducto"],"stock"=>$_POST["stockProducto"],"precio_compra"=>$_POST["precioCompra"],"iva"=>$_POST["ivaProducto"],"valor_Iva"=>$_POST["valorIva"],"precio_venta"=>$_POST["precioVentaNuevo"]);
				$respuesta=ModeloProductos::mdlCrearProducto($tabla,$datos);
				if($respuesta=="ok"){
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "success",
								title: "OK",
								text: "¡La información se guardó correctamente!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="productos";}
							});
						</script>';}
				else{
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "error",
								title: "Error",
								text: "¡La información presento problemas y no se registro adecuadamente. Por favor, intenteló de nuevo!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="productos";}
							});
						</script>';}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información presento problemas. No se permiten caracteres especiales!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="productos";}
						});
					</script>';}
		}
	}

	// Método para editar un producto en la Base de Datos
	public function ctrEditarProducto(){
		if(isset($_POST["editarCodigoProducto"]) || isset($_POST["editarDescripcionProducto"])){
			# Válidamos con preg_match la información que se esta recibiendo
			if(preg_match('/^[a-zA-Z0-9]+$/',$_POST["editarCodigoProducto"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["editarDescripcionProducto"]) && preg_match('/^[0-9]+$/',$_POST["editarStockProducto"]) && preg_match('/^[0-9.,]+$/',$_POST["editarPrecioCompra"]) && preg_match('/^[0-9]+$/',$_POST["editarIvaProducto"]) && preg_match('/^[0-9]+$/',$_POST["valorIvaEditado"]) && preg_match('/^[0-9.,]+$/',$_POST["editarPrecioVenta"])){
				$tabla="productos";
				$_POST["editarDescripcionProducto"]=ucwords(mb_strtolower($_POST["editarDescripcionProducto"]));
				$datos=array("codigo"=>$_POST["editarCodigoProducto"],"descripcion"=>$_POST["editarDescripcionProducto"],"stock"=>$_POST["editarStockProducto"],"precio_compra"=>$_POST["editarPrecioCompra"],"iva"=>$_POST["editarIvaProducto"],"valor_Iva"=>$_POST["valorIvaEditado"],"precio_venta"=>$_POST["editarPrecioVenta"]);
				$respuesta=ModeloProductos::mdlEditarProducto($tabla,$datos);
				if($respuesta=="ok"){
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "success",
								title: "OK",
								text: "¡La información se actualizó correctamente!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="productos";}
							});
						</script>';}
				else{
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "error",
								title: "Error",
								text: "¡La información presento problemas y no se actualizó adecuadamente. Por favor, intenteló de nuevo!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="productos";}
							});
						</script>';}}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información presento problemas. No se permiten caracteres especiales o existen campos sin información!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="productos";}
						});
					</script>';}
		}
	}

	// Método para eliminar un producto en la Base de Datos
	static public function ctrEliminarProductos($id){
		$tabla="productos";
	 	$respuesta=ModeloProductos::mdlEliminarProducto($tabla,$id);
		return $respuesta;
	}

	// Método para mostrar la suma de las Ventas
	public function ctrMostrarSumaVentas(){
		$respuesta=ModeloProductos::mdlMostrarSumaVentas("productos");
		return $respuesta;
	}
}