<?php
class ControladorEgreso{
	// Este método sirve para mostrar uno o todos los egresos
	public function ctrTraerEgresos($item,$valor,$orden){
		$respuesta=ModeloEgreso::mdlTraerEgresos("egresos",$item,$valor,$orden);
		return $respuesta;
	}

	// Este método nos ayuda a traer la suma del Efectivo que se ha ingresado por fecha
	static public function ctrSumaEfectivo($metodo,$fecha){
		$respuesta=ModeloRecibo::mdlSumaEfectivo("detalles_recibo",$metodo,$fecha);
		return $respuesta;
	}

	// Este método nos ayuda a traer la suma de los Egresos por fecha
	static public function ctrSumaEgresos($fecha){
		$respuesta=ModeloEgreso::mdlSumaEgresos("egresos",$fecha);
		return $respuesta;
	}

	// Este método nos permite ingresar un Egreso al sistema
	public function ctrCrearEgreso(){
		if(isset($_POST["idVendedor"]) && isset($_POST["idEgreso"]) && isset($_POST["egresoCliente"]) && isset($_POST["valorCaja"]) && isset($_POST["observacionesEgreso"]) && isset($_POST["cantidadEntregada"])){
			# Válidamos los datos según su contenido
			if(preg_match('/^[0-9]+$/',$_POST["idVendedor"]) && preg_match('/^[0-9]+$/',$_POST["idEgreso"]) && preg_match('/^[0-9]+$/',$_POST["egresoCliente"]) && preg_match('/^[0-9]+$/',$_POST["valorCaja"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_\-\,\.\:\"\'\;\s\d\(\)]*$/',$_POST["observacionesEgreso"]) && preg_match('/^[0-9]+$/',$_POST["cantidadEntregada"])){
				# Verificamos que el valor del Egreso no sea mayor al valor de la caja
				$ingresoRecibo=ModeloRecibo::mdlSumaEfectivo("detalles_recibo","Efectivo",$_POST["fechaEgreso"]);
				$ingresoVentas=ModeloVentas::mdlSumaEfectivo("ventas",$_POST["fechaEgreso"]);
				$egresosEntregados=ModeloEgreso::mdlSumaEgresos("egresos",$_POST["fechaEgreso"]);
				$suma=($ingresoRecibo[0]+$ingresoVentas[0])-$egresosEntregados[0];
				if($_POST["cantidadEntregada"]>$suma){
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "error",
								title: "Error",
								text: "¡El valor que se desea entregar es mayor al Valor existente en caja. Por favor, intenteló de nuevo!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="egreso";}
							});
						</script>';}
				else{
					# Ponemos mayúsculas iniciales, pero convertimos el string en minúsculas primero
					$_POST["observacionesEgreso"]=ucwords(mb_strtolower($_POST["observacionesEgreso"]));
					$datos=array("id_usuario"=>$_POST["idVendedor"],"id_cliente"=>$_POST["egresoCliente"],"observaciones"=>$_POST["observacionesEgreso"],"valor"=>$_POST["cantidadEntregada"]);
					$respuesta=ModeloEgreso::mdlCrearEgreso("egresos",$datos);
					if($respuesta=="ok"){
						$ultimo=ModeloEgreso::mdlMostrarUltimoEgreso("egresos",$_POST["egresoCliente"],$_POST["idVendedor"]);
						$egreso=$ultimo[0]["id"];
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
											text: "¿Desea imprimir el Egreso realizado?",
											showCancelButton: true,
											confirmButtonColor: "#3085d6",
											cancelButtonColor: "#d33",
											confirmButtonText: "¡Si, Imprimir!",
											cancelButtonText: "Cancelar",
										}).then(function(result){
											if(result.value){
												window.open("extensiones/tcpdf/pdf/egreso.php?egreso='.$egreso.'","_blank");
												window.location="egreso";}
											else{
												window.location="egreso";}
										});}
								});
							</script>';}
				}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información presento problemas. No se permiten caracteres especiales o se ha modificado algún dato de manera inadecuada!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="egreso";}
						});
					</script>';}
		}
	}

	// Este método nos permite editar un Egreso al sistema
	public function ctrEditarEgreso(){
		if(isset($_POST["editarNumEgreso"]) && isset($_POST["editarObEgreso"]) && isset($_POST["editarTotalEntregado"])){
			# Válidamos los datos según su contenido
			if(preg_match('/^[0-9]+$/',$_POST["editarNumEgreso"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_\-\,\.\:\"\'\;\s\d\(\)]*$/',$_POST["editarObEgreso"]) && preg_match('/^[0-9]+$/',$_POST["editarTotalEntregado"])){
				# Verificamos que el valor del Egreso no sea mayor al valor anterior
				$infoEgreso=ModeloEgreso::mdlTraerEgresos("egresos","id",$_POST["editarNumEgreso"],"id");
				if($_POST["editarTotalEntregado"]>$infoEgreso["valor"]){
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "error",
								title: "Error",
								text: "¡El valor que se desea entregar es mayor al Valor entregado anteriormente. Si éste es el caso, por favor cree un nuevo Egreso con el valor equivalente!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="admon-egreso";}
							});
						</script>';}
				else{
					# Ponemos mayúsculas iniciales, pero convertimos el string en minúsculas primero
					$_POST["editarObEgreso"]=ucwords(mb_strtolower($_POST["editarObEgreso"]));
					$datos=array("id"=>$_POST["editarNumEgreso"],"observaciones"=>$_POST["editarObEgreso"],"valor"=>$_POST["editarTotalEntregado"],"fecha"=>$infoEgreso["fecha"]);
					$respuesta=ModeloEgreso::mdlEditarEgreso("egresos",$datos);
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
										window.location="admon-egreso";}
								});
							</script>';}}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información presento problemas. No se permiten caracteres especiales o se ha modificado algún dato de manera inadecuada!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="admon-egreso";}
						});
					</script>';}
		}
	}

	// Método para pedir la suma de valores en Efectivo por fecha
	static public function ctrSumaEfectivoVentas($fecha){
		$respuesta=ModeloVentas::mdlSumaEfectivo("ventas",$fecha);
		return $respuesta;
	}
}