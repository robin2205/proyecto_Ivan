<?php
class ControladorRecibo{
	// Este método sirve para mostrar uno o todos los recibos
	public function ctrTraerRecibos($item,$valor,$item2,$valor2,$orden){
		$respuesta=ModeloRecibo::mdlTraerRecibos("recibos",$item,$valor,$item2,$valor2,$orden);
		return $respuesta;
	}

	// Mostrar recibos por rango de Fechas
	static public function ctrTraerRecibosRangoFechas($fechaInicial,$fechaFinal){
		$respuesta=ModeloRecibo::mdlTraerRecibosRangoFechas("recibos",$fechaInicial,$fechaFinal);
		return $respuesta;
	}

	// Este método sirve para mostrar uno o todos los detalles de recibos
	public function ctrTrarDetalleRecibos($item,$valor){
		$respuesta=ModeloRecibo::mdlTrarDetalleRecibos("detalles_recibo",$item,$valor);
		return $respuesta;
	}

	// Este método permite el ingreso de un recibo al sistema
	public function ctrCrearRecibo(){
		if(isset($_POST["idVendedor"]) || isset($_POST["idRecibo"]) || isset($_POST["reciboCliente"]) || isset($_POST["observacionesRecibo"]) || isset($_POST["subtotalRecibo"]) || isset($_POST["ivaRecibo"]) || isset($_POST["totalRecibo"]) || isset($_POST["proSelRecibo"])){
			if(!isset($_POST["pagoRecibo"]) || $_POST["pagoRecibo"]==""){
				$_POST["pagoRecibo"]=0;}
			# Válidamos que el pago realizado no sea mayor a la deuda
			if($_POST["pagoRecibo"]>$_POST["totalRecibo"]){
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡El pago realizado no puede ser mayor que el Total del Recibo. Por favor ingrese el valor igual o menor que el Total!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="recibo";}
						});
					</script>';}
			if(preg_match('/^[0-9]+$/',$_POST["idVendedor"]) && preg_match('/^[0-9]+$/',$_POST["idRecibo"]) && preg_match('/^[0-9]+$/',$_POST["reciboCliente"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_\-\,\.\:\;\s\d\(\)]*$/',$_POST["observacionesRecibo"]) && preg_match('/^[0-9]+$/',$_POST["subtotalRecibo"]) && preg_match('/^[0-9]+$/',$_POST["ivaRecibo"]) && preg_match('/^[0-9]+$/',$_POST["totalRecibo"]) && preg_match('/^[0-9]+$/',$_POST["pagoRecibo"])){
				# Válidamos si viene algún tipo de pago
				if($_POST["metodoPagoRecibo"]!="" && !preg_match('/^[a-zA-Z0-9-]+$/',$_POST["metodoPagoRecibo"])){
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "error",
								title: "Error",
								text: "¡La información presento problemas. No hay coincidencia con los datos necesarios, por favor verifique la información!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="recibo";}
							});
						</script>';}
				# Ponemos mayúsculas iniciales, pero convertimos el string en minúsculas primero
				$_POST["observacionesRecibo"]=ucwords(mb_strtolower($_POST["observacionesRecibo"]));
				# Hallamos el adeuda del recibo
				$adeuda=$_POST["totalRecibo"]-$_POST["pagoRecibo"];
				$datos=array("num_recibo"=>$_POST["idRecibo"],"id_usuario"=>$_POST["idVendedor"],"id_cliente"=>$_POST["reciboCliente"],"observaciones"=>$_POST["observacionesRecibo"],"array_datos"=>$_POST["proSelRecibo"],"subtotal"=>$_POST["subtotalRecibo"],"suma_iva"=>$_POST["ivaRecibo"],"total"=>$_POST["totalRecibo"],"adeuda"=>$adeuda);
				$respuesta=ModeloRecibo::mdlCrearRecibo("recibos",$datos);
				if($respuesta=="ok"){
					$item="id_usuario";
					$valor=$_POST["idVendedor"];
					$item2="id_cliente";
					$valor2=$_POST["reciboCliente"];
					$orden="fecha";
					$dato=ModeloRecibo::mdlTraerRecibos("recibos",$item,$valor,$item2,$valor2,$orden);
					$respuesta2=ModeloRecibo::mdlCrearDetalleRecibo("detalles_recibo",$dato[0]["num_recibo"],$_POST["pagoRecibo"],$_POST["metodoPagoRecibo"]);
					if($respuesta2=="ok"){
						# Modificamos la información de los productos comprados en un array
						$listaProductos=json_decode($_POST["proSelRecibo"],true);
						$comprasTotales=0;
						foreach($listaProductos as $key=>$value){
							$item="codigo";
							$valor=$value["codigo"];
							$orden="codigo";
							$comprasTotales=$comprasTotales+$value["cantidad"];
							$respuestaProducto=ModeloProductos::mdlTraerProductos("productos",$item,$valor,$orden);
							# Actualizamos la cant_reservada en la tabla productos
							$item1="cant_reservada";
							$valor1=$respuestaProducto["cant_reservada"]+$value["cantidad"];
							ModeloVentas::mdlActualizarUnDato("productos",$item1,$valor1,$item,$valor,"sencilla");
							# Actualizamos el stock en la tabla productos
							$item2="stock";
							$valor2=$respuestaProducto["stock"]-1;
							ModeloVentas::mdlActualizarUnDato("productos",$item2,$valor2,$item,$valor,"sencilla");
						}
						# Traemos la información del cliente
						$item="id";
						$valor=$_POST["reciboCliente"];
						$cliente=ModeloClientes::mdlMostrarCliente("clientes",$item,$valor);
						# Actualizamos el Total_compras en la tabla Clientes
						$item2="total_compras";
						$valor2=$cliente["total_compras"]+$comprasTotales;
						ModeloVentas::mdlActualizarUnDato("clientes",$item2,$valor2,null,$valor,"compuesta");
						# Actualizamos ultima_compra en la tabla Clientes
						date_default_timezone_set('America/Bogota');
						$item3="ultima_compra";
						$valor3=date('Y/m/d h:i:s');
						ModeloVentas::mdlActualizarUnDato("clientes",$item3,$valor3,null,$valor,"compuesta");
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
										window.location="recibo";}
								});
							</script>';}
					else{
						# Mostramos una alerta suave
						echo '<script>
								swal({
									type: "error",
									title: "Error",
									text: "¡La información presento problemas y no se registro el detalle adecuadamente. Por favor, intenteló de nuevo!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
								}).then((result)=>{
									if(result.value){
										window.location="recibo";}
								});
							</script>';}}
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
									window.location="recibo";}
							});
						</script>';}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información presento problemas. No se permiten caracteres especiales o no se ha seleccionado ningún producto!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="recibo";}
						});
					</script>';}
		}
	}

	// Este método permite el ingreso de un pago al recibo
	public function ctrEditarRecibo(){
		if(isset($_POST["editarNumRecibo"]) || isset($_POST["editarMetodoPago"]) || isset($_POST["editarPago"]) || isset($_POST["editarAdeuda"])){
			if($_POST["editarPago"]==0){
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información presento problemas. No se ingreso un pago!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="admon-recibos";}
						});
					</script>';}
			# Válidamos que el pago realizado no sea mayor a la deuda
			if($_POST["editarPago"]>$_POST["editarAdeuda"]){
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡El pago realizado no puede ser mayor que la Deuda. Por favor ingrese el valor igual o menor a la Deuda!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="admon-recibos";}
						});
					</script>';}
			else if(preg_match('/^[0-9]+$/',$_POST["editarNumRecibo"]) && preg_match('/^[a-zA-Z0-9-]+$/',$_POST["editarMetodoPago"]) && preg_match('/^[0-9]+$/',$_POST["editarPago"]) && preg_match('/^[0-9]+$/',$_POST["editarAdeuda"])){
				$respuesta=ModeloRecibo::mdlCrearDetalleRecibo("detalles_recibo",$_POST["editarNumRecibo"],$_POST["editarPago"],$_POST["editarMetodoPago"]);
				if($respuesta=="ok"){
					$item1="adeuda";
					$valor1=$_POST["editarAdeuda"]-$_POST["editarPago"];
					$item="num_recibo";
					$valor=$_POST["editarNumRecibo"];
					ModeloVentas::mdlActualizarUnDato("recibos",$item1,$valor1,$item,$valor,"sencilla");
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
									window.location="admon-recibos";}
							});
						</script>';
				}
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
									window.location="admon-recibos";}
							});
						</script>';}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información presento problemas. No se permiten caracteres especiales o se modificaron los valores erradamente. Por favor intenteló nuevamente!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="admon-recibos";}
						});
					</script>';}
		}
	}

	// Este método es para Eliminar un recibo de la BD
	static public function ctrEliminarRecibo($numRecibo){
		$datos=ModeloRecibo::mdlTraerRecibos("recibos","num_recibo",$numRecibo,null,null,"num_recibo");
		$id_cliente=$datos["id_cliente"]; // Capturamos el id del Cliente
		$productos=json_decode($datos["array_datos"],true); // Capturamos los productos que se separaron en Recibo de Caja
		$respuesta=ModeloRecibo::mdlEliminarRecibo("recibos",$numRecibo); // Eliminamos el recibo
		$respuesta2=ModeloRecibo::mdlEliminarRecibo("detalles_recibo",$numRecibo); // Eliminamos los detalles de recibo
		if($respuesta=="ok" && $respuesta2=="ok"){
			$acuCompras=0;
			foreach($productos as $key=>$value){
				# Traemos los datos de cada producto en cada iteracción
				$infoProducto=ModeloProductos::mdlTraerProductos("productos","codigo",$value["codigo"],"codigo");
				$nuevaCantReservada=$infoProducto["cant_reservada"]-$value["cantidad"]; # Hacemos la resta de la cantidad reservada
				$nuevoStock=$infoProducto["stock"]+$value["cantidad"]; # Hacemos la suma para el nuevo Stock
				# Actualizamos la cantidad reservada en la tabla productos
				ModeloVentas::mdlActualizarUnDato("productos","cant_reservada",$nuevaCantReservada,"codigo",$value["codigo"],"sencilla");
				# Actualizamos el Stock
				ModeloVentas::mdlActualizarUnDato("productos","stock",$nuevoStock,"codigo",$value["codigo"],"sencilla");
				$acuCompras++;}
			# Traemos los datos del Cliente
			$infoCliente=ModeloClientes::mdlMostrarCliente("clientes","id",$id_cliente);
			$totalCompras=$infoCliente["total_compras"]-$acuCompras;
			ModeloVentas::mdlActualizarUnDato("clientes","total_compras",$totalCompras,null,$id_cliente,"compuesta");
			return "ok";}
	}
}