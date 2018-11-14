<?php
class ControladorCierreCaja{
	// Método para traer los datos de cualquier tabla por Fecha
	static public function ctrMostrarDatosX($tabla,$fecha){
		$respuesta=ModeloCierreCaja::mdlMostrarDatosX($tabla,$fecha);
		return $respuesta;
	}

	// Este método sirve para mostrar un detalle de recibo sin importar estado
	static public function ctrTraerDR($item,$valor){
		$respuesta=ModeloCierreCaja::mdlTraerDR("detalles_recibo",$item,$valor);
		return $respuesta;
	}

	// Este método sirve uno o todos los cierres de caja
	static public function ctrMostrarCierres($item,$valor){
		$respuesta=ModeloCierreCaja::mdlMostrarCierres("cierres_caja",$item,$valor);
		return $respuesta;
	}

	// Con este método guardamos la información del cierre contable
	public function ctrGuardarCierre(){
		# Verificamos que algunas cajas contengan información
		if(isset($_POST["fechaCierre"]) || isset($_POST["arqueoCaja"]) || isset($_POST["obsCaja"])){
			# Realizamos las validaciones del lado servidor
			if(preg_match('/^[0-9-]+$/',$_POST["fechaCierre"]) && preg_match('/^[0-9,]+$/',$_POST["efectivoCaja"]) && preg_match('/^[0-9,]+$/',$_POST["egresoCierre"]) && preg_match('/^[0-9,]+$/',$_POST["ingresoCierre"]) && preg_match('/^[0-9,]+$/',$_POST["facturasCierre"]) && preg_match('/^[0-9,]+$/',$_POST["tarjetasCierre"]) && preg_match('/^[0-9,]+$/',$_POST["chequesCierre"]) && preg_match('/^[0-9,]+$/',$_POST["arqueoCaja"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ_\-\,\.\:\"\'\;\s\d\(\)]*$/',$_POST["obsCaja"])){
				# Convertimos los datos de moneda en números para guardar en la BD
				$efectivoCaja=$this->convertir($_POST["efectivoCaja"]);
				$egresoCierre=$this->convertir($_POST["egresoCierre"]);
				$ingresoCierre=$this->convertir($_POST["ingresoCierre"]);
				$facturasCierre=$this->convertir($_POST["facturasCierre"]);
				$tarjetasCierre=$this->convertir($_POST["tarjetasCierre"]);
				$chequesCierre=$this->convertir($_POST["chequesCierre"]);
				$arqueoCaja=$this->convertir($_POST["arqueoCaja"]);
				# Convertimos los datos de dinero en un objeto JSON
				$dinero=json_encode($_POST["dinEfectivo"],JSON_FORCE_OBJECT);
				$datos=array("id_usuario"=>$_SESSION["id"],"fecha"=>$_POST["fechaCierre"],"efectivo"=>$efectivoCaja,"egreso"=>$egresoCierre,"ingreso"=>$ingresoCierre,"facturas"=>$facturasCierre,"tarjetas"=>$tarjetasCierre,"cheques"=>$chequesCierre,"dinero"=>$dinero,"arqueo"=>$arqueoCaja,"observaciones"=>$_POST["obsCaja"]);
				$respuesta=ModeloCierreCaja::mdlGuardarCierre("cierres_caja",$datos);
				if($respuesta=="ok"){
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
									window.location="cierre-caja";}
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
									window.location="cierre-caja";}
							});
						</script>';}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type:"error",
							title:"Error",
							text:"¡La información presento problemas. No se permiten caracteres especiales, existe un dato fue modificado de manera incorrecta o no se envió información del Arqueo de Caja.",
							showConfirmButton:true,
							confirmButtonText:"Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="cierre-caja";}
						});
					</script>';}
		}
	}

	// Con esta función, convertimos los datos númericos que tienen comas, en número para guardar
	function convertir($dato){
		return str_replace(",","",$dato);
	}
}