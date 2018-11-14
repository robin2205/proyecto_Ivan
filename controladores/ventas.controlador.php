<?php

class ControladorVentas{
	// Método para Mostrar las ventas
	static public function ctrMostrarVentas($item,$valor){
		$tabla="ventas";
		$respuesta=ModeloVentas::mdlMostrarVentas($tabla,$item,$valor);
		return $respuesta;
	}

	// Método para Guardar las ventas
	public function ctrGuardarVentas(){
		if(isset($_POST["factura"]) && isset($_POST["seleccionCliente"]) && isset($_POST["listaProductos"])){
			if(preg_match('/^[0-9]+$/',$_POST["idVendedor"]) && preg_match('/^[a-zA-Z0-9-_]+$/',$_POST["factura"]) && preg_match('/^[0-9]+$/',$_POST["seleccionCliente"]) && preg_match('/^[0-9]+$/',$_POST["subtotalVenta"]) && preg_match('/^[0-9]+$/',$_POST["iva"]) && preg_match('/^[0-9]+$/',$_POST["totalVenta"])){
				/* ================================= VÁLIDAMOS LOS MÉTODO DE PAGO UTILIZADOS PARA LA VENTA =================================*/
				if($_POST["listaMetodosPago"]!="" && preg_match('/^[a-zA-Z0-9-]+$/',$_POST["listaMetodosPago"])){ # Si el primer método de pago viene diferente a vacío
					# Si viene primer pago, viene pago con recibo, y no viene tercer pago
					if(isset($_POST["primerPagoVenta"]) && preg_match('/^[0-9]+$/',$_POST["primerPagoVenta"]) && isset($_POST["recibo"]) && preg_match('/^[0-9]+$/',$_POST["recibo"]) && isset($_POST["sumaRecibo"]) && preg_match('/^[0-9]+$/',$_POST["sumaRecibo"]) && $_POST["listaTercerPago"]==""){
						$suma=$_POST["primerPagoVenta"]+$_POST["sumaRecibo"]; # Realizamos la suma
						if($suma<$_POST["totalVenta"]){
							# Mostramos una alerta suave
							echo '<script>
									swal({
										type: "error",
										title: "Error",
										text: "¡El valor acumulado ingresado es menor al Valor Total que se debe pagar. Por favor verifique!",
										showConfirmButton: true,
										confirmButtonText: "Cerrar"
									}).then((result)=>{
										if(result.value){
											window.location="inicio";}
									});
								</script>';
							exit;}
						else{
							$metodo1=$_POST["listaMetodosPago"];
							$pago1=$_POST["primerPagoVenta"];
							$metodo3="";
							$pago3=0;
							# Actualizamos el estado del Detalle Recibo
							ModeloVentas::mdlActualizarUnDato("detalles_recibo","estado",1,"num_recibo",$_POST["recibo"],"sencilla");}
					}
					# Si viene primer pago, no viene pago con recibo, y no viene tercer pago
					else if(isset($_POST["primerPagoVenta"]) && preg_match('/^[0-9]+$/',$_POST["primerPagoVenta"]) && $_POST["recibo"]==NULL && $_POST["listaTercerPago"]==""){
						if($_POST["primerPagoVenta"]<$_POST["totalVenta"]){
							# Mostramos una alerta suave
							echo '<script>
									swal({
										type: "error",
										title: "Error",
										text: "¡El valor en Efectivo ingresado es menor al Valor Total que se debe pagar, debe seleccionar otro método de Pago adicional. Por favor verifique!",
										showConfirmButton: true,
										confirmButtonText: "Cerrar"
									}).then((result)=>{
										if(result.value){
											window.location="inicio";}
									});
								</script>';
							exit;}
						else{
							$metodo1=$_POST["listaMetodosPago"];
							$pago1=$_POST["primerPagoVenta"];
							$_POST["sumaRecibo"]=0;
							$metodo3="";
							$pago3=0;}
					}
					# Si viene primer pago, no viene pago con recibo, y viene tercer pago
					else if(isset($_POST["primerPagoVenta"]) && preg_match('/^[0-9]+$/',$_POST["primerPagoVenta"]) && $_POST["recibo"]==NULL && $_POST["listaTercerPago"]!="" && preg_match('/^[a-zA-Z0-9-]+$/',$_POST["listaTercerPago"]) && isset($_POST["tercerPagoVenta"]) && preg_match('/^[0-9]+$/',$_POST["tercerPagoVenta"])){
						$suma=$_POST["primerPagoVenta"]+$_POST["tercerPagoVenta"];
						if($suma<$_POST["totalVenta"]){
							# Mostramos una alerta suave
							echo '<script>
									swal({
										type: "error",
										title: "Error",
										text: "¡El valor acumulado ingresado es menor al Valor Total que se debe pagar. Por favor verifique!",
										showConfirmButton: true,
										confirmButtonText: "Cerrar"
									}).then((result)=>{
										if(result.value){
											window.location="inicio";}
									});
								</script>';
							exit;}
						else{
							$metodo1=$_POST["listaMetodosPago"];
							$pago1=$_POST["primerPagoVenta"];
							$_POST["sumaRecibo"]=0;
							$metodo3=$_POST["listaTercerPago"];
							$pago3=$_POST["tercerPagoVenta"];}
					}
					# Si viene primer pago, viene pago con recibo, y viene tercer pago
					else if(isset($_POST["primerPagoVenta"]) && preg_match('/^[0-9]+$/',$_POST["primerPagoVenta"]) && isset($_POST["recibo"]) && isset($_POST["sumaRecibo"]) && $_POST["listaTercerPago"]!="" && isset($_POST["tercerPagoVenta"]) && preg_match('/^[0-9]+$/',$_POST["tercerPagoVenta"])){
						$suma=$_POST["primerPagoVenta"]+$_POST["sumaRecibo"]+$_POST["tercerPagoVenta"];
						if($suma<$_POST["totalVenta"]){
							# Mostramos una alerta suave
							echo '<script>
									swal({
										type: "error",
										title: "Error",
										text: "¡El valor acumulado ingresado es menor al Valor Total que se debe pagar. Por favor verifique!",
										showConfirmButton: true,
										confirmButtonText: "Cerrar"
									}).then((result)=>{
										if(result.value){
											window.location="inicio";}
									});
								</script>';
							exit;}
						else{
							$metodo1=$_POST["listaMetodosPago"];
							$pago1=$_POST["primerPagoVenta"];
							$metodo3=$_POST["listaTercerPago"];
							$pago3=$_POST["tercerPagoVenta"];
							# Actualizamos el estado del Detalle Recibo
							ModeloVentas::mdlActualizarUnDato("detalles_recibo","estado",1,"num_recibo",$_POST["recibo"],"sencilla");}
					}
					/* ==============================================
					DATOS A GUARDAR EN LA VENTA
					============================================== */
					$datos=array("factura"=>$_POST["factura"],"id_cliente"=>$_POST["seleccionCliente"],"id_vendedor"=>$_POST["idVendedor"],"productos"=>$_POST["listaProductos"],"subtotalventa"=>$_POST["subtotalVenta"],"sumaiva"=>$_POST["iva"],"total"=>$_POST["totalVenta"],"metodo_1"=>$metodo1,"pago_1"=>$pago1,"num_recibo"=>$_POST["recibo"],"pago_recibo"=>$_POST["sumaRecibo"],"metodo_3"=>$metodo3,"pago_3"=>$pago3,"estado"=>"AC");
					/* ==============================================
					GUARDAMOS LA VENTA
					============================================== */
					$respuesta=ModeloVentas::mdlGuardarVentas("ventas",$datos);
					if($respuesta=="ok"){
						# Capturamos el último id de Venta
						$ultima=ModeloVentas::mdlMostrarUltimaVenta("ventas",$_POST["seleccionCliente"],$_POST["idVendedor"],"AC");
						$factura=$ultima[0]["factura"];
						# Modificamos la información de los productos comprados en un array
						$listaProductos=json_decode($_POST["listaProductos"],true);
						$comprasTotales=0;
						foreach($listaProductos as $key=>$value){
							$item="codigo";
							$valor=$value["codigo"];
							$orden="codigo";
							$comprasTotales=$comprasTotales+$value["cantidad"];
							$respuestaProducto=ModeloProductos::mdlTraerProductos("productos",$item,$valor,$orden);
							# Actualizamos las ventas en la tabla productos
							$item1="ventas";
							$valor1=$respuestaProducto["ventas"]+$value["cantidad"];
							ModeloVentas::mdlActualizarUnDato("productos",$item1,$valor1,$item,$valor,"sencilla");
							# Actualizamos el stock en la tabla productos
							$item2="stock";
							$valor2=$value["stock"];
							ModeloVentas::mdlActualizarUnDato("productos",$item2,$valor2,$item,$valor,"sencilla");
						}
						# Traemos la información del cliente
						$item="id";
						$valor=$_POST["seleccionCliente"];
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
									title: "Felicitaciones",
									text: "¡La información fue registrada con éxito!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
								}).then((result)=>{
									if(result.value){
										swal({
											type: "info",
											title: "Imprimir",
											text: "¿Desea imprimir la Factura?",
											showCancelButton: true,
											confirmButtonColor: "#3085d6",
											cancelButtonColor: "#d33",
											confirmButtonText: "¡Si, Imprimir!",
											cancelButtonText: "Cancelar",
										}).then(function(result){
											if(result.value){
												window.open("extensiones/tcpdf/pdf/factura.php?factura='.$factura.'","_blank");
												window.location="inicio";}
											else{
												window.location="inicio";}
										});}
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
										window.location="inicio";}
								});
							</script>';}
				}
				else if($_POST["listaMetodosPago"]==""){ # Si el primer método de pago NO viene con datos
					# Si viene recibo y tercer pago viene vacío
					if(isset($_POST["recibo"]) && preg_match('/^[0-9]+$/',$_POST["recibo"]) && isset($_POST["sumaRecibo"]) && preg_match('/^[0-9]+$/',$_POST["sumaRecibo"]) && $_POST["listaTercerPago"]==""){
						if($_POST["sumaRecibo"]>$_POST["totalVenta"]){
							# Mostramos una alerta suave
							echo '<script>
									swal({
										type: "error",
										title: "Error",
										text: "¡El valor acumulado en el Recibo es mayor al Valor Total a pagar, debe seleccionar otro producto o no utilizar el recibo. Por favor verifique!",
										showConfirmButton: true,
										confirmButtonText: "Cerrar"
									}).then((result)=>{
										if(result.value){
											window.location="inicio";}
									});
								</script>';
							exit;}
						else if($_POST["sumaRecibo"]<$_POST["totalVenta"]){
							# Mostramos una alerta suave
							echo '<script>
									swal({
										type: "error",
										title: "Error",
										text: "¡El valor acumulado en el Recibo no cubre al Valor Total a pagar, debe seleccionar otro medio de pago. Por favor verifique!",
										showConfirmButton: true,
										confirmButtonText: "Cerrar"
									}).then((result)=>{
										if(result.value){
											window.location="inicio";}
									});
								</script>';
							exit;}
						else{
							# Actualizamos el estado del Detalle Recibo
							ModeloVentas::mdlActualizarUnDato("detalles_recibo","estado",1,"num_recibo",$_POST["recibo"],"sencilla");
							/* ==============================================
							DATOS A GUARDAR EN LA VENTA
							============================================== */
							$datos=array("factura"=>$_POST["factura"],"id_cliente"=>$_POST["seleccionCliente"],"id_vendedor"=>$_POST["idVendedor"],"productos"=>$_POST["listaProductos"],"subtotalventa"=>$_POST["subtotalVenta"],"sumaiva"=>$_POST["iva"],"total"=>$_POST["totalVenta"],"metodo_1"=>"","pago_1"=>0,"num_recibo"=>$_POST["recibo"],"pago_recibo"=>$_POST["sumaRecibo"],"metodo_3"=>"","pago_3"=>0,"estado"=>"AC");
							/* ==============================================
							GUARDAMOS LA VENTA
							============================================== */
							$respuesta=ModeloVentas::mdlGuardarVentas("ventas",$datos);
							if($respuesta=="ok"){
								# Capturamos el último id de Venta
								$ultima=ModeloVentas::mdlMostrarUltimaVenta("ventas",$_POST["seleccionCliente"],$_POST["idVendedor"],"AC");
								$factura=$ultima[0]["factura"];
								# Modificamos la información de los productos comprados en un array
								$listaProductos=json_decode($_POST["listaProductos"],true);
								$comprasTotales=0;
								foreach($listaProductos as $key=>$value){
									$item="codigo";
									$valor=$value["codigo"];
									$orden="codigo";
									$comprasTotales=$comprasTotales+$value["cantidad"];
									$respuestaProducto=ModeloProductos::mdlTraerProductos("productos",$item,$valor,$orden);
									# Actualizamos las ventas en la tabla productos
									$item1="ventas";
									$valor1=$respuestaProducto["ventas"]+$value["cantidad"];
									ModeloVentas::mdlActualizarUnDato("productos",$item1,$valor1,$item,$valor,"sencilla");
									# Actualizamos el stock en la tabla productos
									$item2="stock";
									$valor2=$value["stock"];
									ModeloVentas::mdlActualizarUnDato("productos",$item2,$valor2,$item,$valor,"sencilla");
								}
								# Traemos la información del cliente
								$item="id";
								$valor=$_POST["seleccionCliente"];
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
											title: "Felicitaciones",
											text: "¡La información fue registrada con éxito!",
											showConfirmButton: true,
											confirmButtonText: "Cerrar"
										}).then((result)=>{
											if(result.value){
												swal({
													type: "info",
													title: "Imprimir",
													text: "¿Desea imprimir la Factura?",
													showCancelButton: true,
													confirmButtonColor: "#3085d6",
													cancelButtonColor: "#d33",
													confirmButtonText: "¡Si, Imprimir!",
													cancelButtonText: "Cancelar",
												}).then(function(result){
													if(result.value){
														window.open("extensiones/tcpdf/pdf/factura.php?factura='.$factura.'","_blank");
														window.location="inicio";}
													else{
														window.location="inicio";}
												});}
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
												window.location="inicio";}
										});
									</script>';}}
					}
					else if($_POST["listaMetodosPago"]=="" && $_POST["listaTercerPago"]!=""){
						# Mostramos una alerta suave
						echo '<script>
								swal({
									type: "error",
									title: "Error",
									text: "¡Por favor, seleccione el método de pago en la Primera opción de selección. La opción seleccionada se utiliza como Pago alterno!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
								}).then((result)=>{
									if(result.value){
										window.location="inicio";}
								});
							</script>';
						exit;}
				}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información ingresada esta errada. No se permiten caracteres especiales ni campos vacíos o no se seleccionó ningún producto. Por favor verifique la información!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="inicio";}
						});
					</script>';}
		}
	}

	// Método para Anular las ventas
	static public function ctrAnularVenta($idVenta){
		# Nos traemos la información de la Venta
		$item="id";
		$infoVenta=ModeloVentas::mdlMostrarVentas("ventas",$item,$idVenta);
		/* *************************** ACTUALIZAMOS ÚLTIMA FECHA DE COMPRA *************************** */
		# Traemos todas las ventas
		$todasVentas=ModeloVentas::mdlMostrarVentas("ventas",null,null);
		$arrayFechas=array();
		foreach($todasVentas as $key=>$value){
			# Traemos todas las fechas del cliente al que se le borra la venta
			if($value["id_cliente"]==$infoVenta["id_cliente"]){
				# Almacenamos las fechas en el array
				array_push($arrayFechas,$value["fecha"]);}
		}
		# Válidamos que el array sea mayor a 1
		if(count($arrayFechas)>1){
			# Validamos que la fecha de la venta que se va a anular sea la penúltima fecha
			if($infoVenta["fecha"]>$arrayFechas[count($arrayFechas)-2]){
				$item="ultima_compra";
				$valor=$arrayFechas[count($arrayFechas)-2];
				ModeloVentas::mdlActualizarUnDato("clientes",$item,$valor,null,$infoVenta["id_cliente"],"compuesta");}
			# Si es la última
			else{
				$item="ultima_compra";
				$valor=$arrayFechas[count($arrayFechas)-1];
				ModeloVentas::mdlActualizarUnDato("clientes",$item,$valor,null,$infoVenta["id_cliente"],"compuesta");}
		}
		else{
			$item="ultima_compra";
			$valor="0000-00-00 00:00:00";
			ModeloVentas::mdlActualizarUnDato("clientes",$item,$valor,null,$infoVenta["id_cliente"],"compuesta");
		}
		/* ************************* FORMATEAMOS LA TABLA DE PRODUCTOS Y DE CLIENTES ************************* */
		$productosEliminados=json_decode($infoVenta["productos"],true);
		# Traemos la información del cliente
		$itemCliente="id";
		$valorCliente=$infoVenta["id_cliente"];
		$cliente=ModeloClientes::mdlMostrarCliente("clientes",$itemCliente,$valorCliente);
		$comprasTotales=$cliente["total_compras"];
		foreach($productosEliminados as $key=>$value){
			# Traemos los productos por Código en cada interacción
			$item="codigo";
			$valor=$value["codigo"];
			$orden="codigo";
			$infoProducto=ModeloProductos::mdlTraerProductos("productos",$item,$valor,$orden);
			# Realizamos la resta de compras totales
			$comprasTotales=$comprasTotales-$value["cantidad"];
			# Actualizamos las ventas en la tabla productos
			$item1="ventas";
			$valor1=$infoProducto["ventas"]-$value["cantidad"];
			ModeloVentas::mdlActualizarUnDato("productos",$item1,$valor1,$item,$valor,"sencilla");
			# Actualizamos el stock en la tabla productos
			$item2="stock";
			$valor2=$value["cantidad"]+$infoProducto["stock"];
			ModeloVentas::mdlActualizarUnDato("productos",$item2,$valor2,$item,$valor,"sencilla");
		}
		# Actualizamos el Total_compras en la tabla Clientes
		$item2="total_compras";
		$valor2=$comprasTotales;
		ModeloVentas::mdlActualizarUnDato("clientes",$item2,$valor2,null,$valorCliente,"compuesta");
		/* ************************* ACTUALIZAMOS EL RECIBO ************************* */
		if($infoVenta["num_recibo"]!=0){
			# Actualizamos el estado del Detalle Recibo
			ModeloVentas::mdlActualizarUnDato("detalles_recibo","estado",0,"num_recibo",$infoVenta["num_recibo"],"sencilla");}
		/* ==============================================
		ANULAMOS LA VENTA
		============================================== */
		$respuesta=ModeloVentas::mdlAnularVenta("ventas",$idVenta,"AN");
		return $respuesta;
	}

	// Mostrar rango de Fechas
	static public function ctrRangoFechasVentas($fechaInicial,$fechaFinal,$estado){
		$tabla="ventas";
		$respuesta=ModeloVentas::mdlRangoFechasVentas($tabla,$fechaInicial,$fechaFinal,$estado);
		return $respuesta;
	}

	// Método para pedir de mayor a menor la suma de totales de ventas con un limite de datos
	static public function crtSumasTotalesVentas($limite){
		$respuesta=ModeloVentas::mdlSumasTotalesVentas("ventas",$limite);
		return $respuesta;
	}

	// Método para Descargar Excel
	public function ctrDescargarExcel(){
		# Válidamos que venga la variable reporte
		if(isset($_GET["reporte"])){
			$tabla="ventas";
			# Válidamos que vengan las GET fechaInicial y fechaFinal para reporte con Rango de fechas
			if(isset($_GET["fechaInicial"]) && isset($_GET["fechaFinal"])){
				$ventas=ModeloVentas::mdlRangoFechasVentas($tabla,$_GET["fechaInicial"],$_GET["fechaFinal"]);}
			# Sino imprimimos otro reporte
			else{
				$ventas=ModeloVentas::mdlMostrarVentas($tabla,null,null);}
		/* ==============================================
		CREAMOS EL ARCHIVO DE EXCEL
		============================================== */
		# Colocamos nombre al archivo
		$name=$_GET["reporte"].'.xls';

		# Pasamos una información en la cabecera para trabajar con los archivos de Excel
		header('Expires:0');
		header('Cache-control:private');
		header('Content-type:application/vnd.ms-excel'); # Archivo de Excel
		header('Cache-control:cache,must-revalidate');
		header('Content-Description:File Transfer');
		header('Last-Modified:'.date('D,d M Y H:i:s'));
		header('Pragma:public');
		header('Content-Disposition:;filename="'.$name.'"');
		header('Content-Transfer-Encoding:binary');

		# Creamos la tabla del archivo de Excel
		echo utf8_decode('<table border="0">
							<tr>
								<td style="font-weight:bold;border:1px solid #eee;">Factura</td>
								<td style="font-weight:bold;border:1px solid #eee;">Cliente</td>
								<td style="font-weight:bold;border:1px solid #eee;">Vendedor</td>
								<td style="font-weight:bold;border:1px solid #eee;">Productos</td>
								<td style="font-weight:bold;border:1px solid #eee;">Cantidad</td>
								<td style="font-weight:bold;border:1px solid #eee;">Subtotal</td>
								<td style="font-weight:bold;border:1px solid #eee;">IVA</td>
								<td style="font-weight:bold;border:1px solid #eee;">Total</td>
								<td style="font-weight:bold;border:1px solid #eee;">Método de Pago 1</td>
								<td style="font-weight:bold;border:1px solid #eee;">Pago 1</td>
								<td style="font-weight:bold;border:1px solid #eee;">N° de Recibo</td>
								<td style="font-weight:bold;border:1px solid #eee;">Valor Recibo</td>
								<td style="font-weight:bold;border:1px solid #eee;">Método de Pago 3</td>
								<td style="font-weight:bold;border:1px solid #eee;">Pago 3</td>
								<td style="font-weight:bold;border:1px solid #eee;">Estado</td>
								<td style="font-weight:bold;border:1px solid #eee;">Fecha</td>
							</tr>');
			foreach($ventas as $key=>$valueVentas){
				# Traemos la información del Cliente
				$cliente=ControladorClientes::ctrMostrarCliente("id",$valueVentas["id_cliente"]);
				# Traemos la información del Vendedor
				$vendedor=ControladorUsuarios::ctrMostrarUsuarios("id",$valueVentas["id_vendedor"]);
				echo utf8_decode('<tr>
									<td style="border:1px solid #eee;vertical-align:middle">'.$valueVentas["factura"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">'.$cliente["nombre"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">'.$vendedor["nombre"].'</td>
									<td style="border:1px solid #eee;">');
									# Decodificamos los productos en un archivo JSON
									$productos=json_decode($valueVentas["productos"],true);
									foreach($productos as $key=>$valueProductos){
										echo utf8_decode($valueProductos["descripcion"]."<br>");
									}
					echo utf8_decode('</td>
									<td style="border:1px solid #eee;text-align:left">');
									foreach($productos as $key=>$valueProductos){
										echo utf8_decode($valueProductos["cantidad"]."<br>");
									}
					echo utf8_decode('</td>
									<td style="border:1px solid #eee;vertical-align:middle">$ '.$valueVentas["subtotalventa"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">$ '.$valueVentas["sumaiva"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">$ '.$valueVentas["total"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">'.$valueVentas["metodo_1"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">$ '.$valueVentas["pago_1"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">'.$valueVentas["num_recibo"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">$ '.$valueVentas["pago_recibo"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">'.$valueVentas["metodo_3"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">$ '.$valueVentas["pago_3"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">'.$valueVentas["estado"].'</td>
									<td style="border:1px solid #eee;vertical-align:middle">'.substr($valueVentas["fecha"],0,10).'</td>
								</tr>');
			}
			echo '</table>';
		}
	}
}