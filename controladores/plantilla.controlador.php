<?php
// Clase del Controlador
class ControladorPlantilla{
	// Método para llamar la plantilla en la vista
	public function ctrPlantilla(){
		include 'vistas/plantilla.php';
	}

	// Método para mostrar la suma total de un requerimiento
	static public function crtSumaTotalRequerimiento($tabla,$accion,$item,$columna,$valor){
		$respuesta=ModeloVentas::mdlSumaTotalRequerimiento($tabla,$accion,$item,$columna,$valor);
		return $respuesta;
	}
}