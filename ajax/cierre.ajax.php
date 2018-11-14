<?php
// Requerimos el controlador y el modelo
require_once '../controladores/cierre-caja.controlador.php';
require_once '../modelos/cierre-caja.modelo.php';

class AjaxCierre{
	public $fecha;
	public function ajaxPedirDatos(){
		$recibos=ControladorCierreCaja::ctrMostrarDatosX("recibos",$this->fecha);
		$ventas=ControladorCierreCaja::ctrMostrarDatosX("ventas",$this->fecha);
		$egresos=ControladorCierreCaja::ctrMostrarDatosX("egresos",$this->fecha);
		$respuesta=array("recibos"=>$recibos,"ventas"=>$ventas,"egresos"=>$egresos);
		echo json_encode($respuesta);
	}
}

// OBJETOS
if(isset($_POST["fecha"])){
	$datos=new AjaxCierre();
	$datos->fecha=$_POST["fecha"];
	$datos->ajaxPedirDatos();
}