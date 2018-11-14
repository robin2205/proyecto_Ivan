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
	static public function ctrTraerDetalleRecibos($item,$valor){
		$respuesta=ModeloRecibo::mdlTraerDetalleRecibos("detalles_recibo",$item,$valor);
		return $respuesta;
	}

	// Este método permite el ingreso de un recibo al sistema
	public function ctrCrearRecibo(){
		if(isset($_POST["idVendedor"]) || isset($_POST["idRecibo"]) || isset($_POST["reciboCliente"]) || isset($_POST["observacionesRecibo"])){
			if(!isset($_POST["pagoRecibo"]) || $_POST["pagoRecibo"]==""){
				$_POST["pagoRecibo"]=0;}
			if(preg_match('/^[0-9]+$/',$_POST["idVendedor"]) && preg_match('/^[0-9]+$/',$_POST["idRecibo"]) && preg_match('/^[0-9]+$/',$_POST["reciboCliente"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_\-\,\.\:\"\'\;\s\d\(\)]*$/',$_POST["observacionesRecibo"]) && preg_match('/^[0-9]+$/',$_POST["pagoRecibo"])){
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
				$datos=array("num_recibo"=>$_POST["idRecibo"],"id_usuario"=>$_POST["idVendedor"],"id_cliente"=>$_POST["reciboCliente"],"observaciones"=>$_POST["observacionesRecibo"]);
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
						$ultimo=ModeloRecibo::mdlMostrarUltimoRecibo("recibos",$_POST["reciboCliente"],$_POST["idVendedor"]);
						$recibo=$ultimo[0]["num_recibo"];
						# Traemos la información del cliente
						$item="id";
						$valor=$_POST["reciboCliente"];
						$cliente=ModeloClientes::mdlMostrarCliente("clientes",$item,$valor);
						# Actualizamos el Total_compras en la tabla Clientes
						$item2="total_compras";
						$valor2=$cliente["total_compras"]+1;
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
											text: "¿Desea imprimir el Recibo?",
											showCancelButton: true,
											confirmButtonColor: "#3085d6",
											cancelButtonColor: "#d33",
											confirmButtonText: "¡Si, Imprimir!",
											cancelButtonText: "Cancelar",
										}).then(function(result){
											if(result.value){
												window.open("extensiones/tcpdf/pdf/recibo.php?recibo='.$recibo.'","_blank");
												window.location="recibo";}
											else{
												window.location="recibo";}
										});}
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

	// Este método permite la edición de un recibo al sistema
	public function ctrEditarRecibo(){
		if(isset($_POST["editarNumRecibo"]) || isset($_POST["editarObRecibo"])){
			if(preg_match('/^[0-9]+$/',$_POST["editarNumRecibo"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_\-\,\.\:\"\'\;\s\d\(\)]*$/',$_POST["editarObRecibo"])){
				$band=false;
				for($i=0;$i<count($_POST["pagosRecibos"]);$i++){
					if(!preg_match('/^[0-9]+$/',$_POST["pagosRecibos"][$i]) || !preg_match('/^[0-9]+$/',$_POST["idPagosRecibos"][$i])){
						$band=true;}}
				if($band==true){
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "error",
								title: "Error",
								text: "¡La información presento problemas. No se permiten caracteres especiales o algún dato fue editado de forma incorrecta!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="admon-recibos";}
							});
						</script>';}
				else{
					# Ponemos mayúsculas iniciales, pero convertimos el string en minúsculas primero
					$_POST["editarObRecibo"]=ucwords(mb_strtolower($_POST["editarObRecibo"]));
					# Actualizamos la Observación
					$info=array("observaciones"=>$_POST["editarObRecibo"],"num_recibo"=>$_POST["editarNumRecibo"]);
					ModeloRecibo::mdlEditarOb("recibos",$info);
					# Actualizamos el o los Pagos editados
					for($i=0;$i<count($_POST["pagosRecibos"]);$i++){
						ModeloVentas::mdlActualizarUnDato("detalles_recibo","pago",$_POST["pagosRecibos"][$i],null,$_POST["idPagosRecibos"][$i],"compuesta");}
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
						</script>';}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información presento problemas. No se permiten caracteres especiales o algún dato fue editado de forma incorrecta!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="admon-recibos";}
						});
					</script>';}
		}
	}

	// Este método permite el ingreso de un pago al recibo
	public function ctrPagosRecibo(){
		if(isset($_POST["pagoNumRecibo"]) || isset($_POST["pagoMetodo"]) || isset($_POST["pago"]) || isset($_POST["pagoAcumulado"])){
			if($_POST["pago"]==0){
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
			else if(preg_match('/^[0-9]+$/',$_POST["pagoNumRecibo"]) && preg_match('/^[a-zA-Z0-9-]+$/',$_POST["pagoMetodo"]) && preg_match('/^[0-9]+$/',$_POST["pago"]) && preg_match('/^[0-9]+$/',$_POST["pagoAcumulado"])){
				$respuesta=ModeloRecibo::mdlCrearDetalleRecibo("detalles_recibo",$_POST["pagoNumRecibo"],$_POST["pago"],$_POST["pagoMetodo"]);
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
									window.location="admon-recibos";}
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
		$respuesta=ModeloRecibo::mdlEliminarRecibo("recibos",$numRecibo); // Eliminamos el recibo
		$respuesta2=ModeloRecibo::mdlEliminarRecibo("detalles_recibo",$numRecibo); // Eliminamos los detalles de recibo
		if($respuesta=="ok" && $respuesta2=="ok"){
			# Traemos los datos del Cliente
			$infoCliente=ModeloClientes::mdlMostrarCliente("clientes","id",$id_cliente);
			$totalCompras=$infoCliente["total_compras"]-1;
			ModeloVentas::mdlActualizarUnDato("clientes","total_compras",$totalCompras,null,$id_cliente,"compuesta");
			return "ok";}
	}

	// Este método nos ayuda a traer la suma de pagos realizados por Recibo
	static public function ctrPagoAcumulado($numRecibo){
		$respuesta=ModeloRecibo::mdlPagoAcumulado("detalles_recibo",$numRecibo);
		return $respuesta;
	}
}