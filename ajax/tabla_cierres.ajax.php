<?php
// Requerimos el controlador y el modelo
require_once '../controladores/cierre-caja.controlador.php';
require_once '../modelos/cierre-caja.modelo.php';

class AjaxTablaCierres{
	public function mostraTablaCierres(){
		$cierres=ControladorCierreCaja::ctrMostrarCierres(null,null);
		if(count($cierres)!=0){
			$datosJson='{
				"data":[';
				for($i=0;$i<count($cierres);$i++){
	                # Creamos la estructura JSON
	                $datosJson.='[
									"'.$cierres[$i]["fecha"].'",
									"$ '.number_format($cierres[$i]["efectivo"],0).'",
									"$ '.number_format($cierres[$i]["egreso"],0).'",
									"$ '.number_format($cierres[$i]["ingreso"],0).'",
									"$ '.number_format($cierres[$i]["facturas"],0).'",
									"$ '.number_format($cierres[$i]["tarjetas"],0).'",
									"$ '.number_format($cierres[$i]["cheques"],0).'",
									"$ '.number_format($cierres[$i]["arqueo"],0).'"
								],';
	            }
				$datosJson=substr($datosJson,0,-1);
				$datosJson.=']}';
			echo $datosJson;}
		else{
			echo '{"data":[]}';
			return;}
	}
}

// OBJETOS
$datos=new AjaxTablaCierres();
$datos->mostraTablaCierres();