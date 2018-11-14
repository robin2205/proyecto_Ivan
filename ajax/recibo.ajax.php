<?php
// Requerimos el controlador y el modelo
require_once '../controladores/recibo.controlador.php';
require_once '../modelos/recibo.modelo.php';
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';
require_once '../controladores/productos.controlador.php';
require_once '../modelos/productos.modelo.php';
require_once '../controladores/ventas.controlador.php';
require_once '../modelos/ventas.modelo.php';

class AjaxRecibo{
	// Editar Categoría
	public $numRecibo;
	public function ajaxEditarRecibo(){
		$orden="num_recibo";
		$respuesta=ControladorRecibo::ctrTraerRecibos("num_recibo",$this->numRecibo,null,null,$orden);
		# Capturamos el id del Cliente para traer el nombre
		$valor=$respuesta["id_cliente"];
		$infoCliente=ControladorClientes::ctrMostrarCliente("id",$valor);
		$respuesta["id_cliente"]=$infoCliente["nombre"];
		$respuesta[3]=$infoCliente["nombre"];
		echo json_encode($respuesta);
	}

	// Eliminar Recibo
	public $eliminarNumRecibo;
	public function ajaxEliminarRecibo(){
		$respuesta=ControladorRecibo::ctrEliminarRecibo($this->eliminarNumRecibo);
		echo $respuesta;
	}
}

// OBJETOS
if(isset($_POST["numRecibo"])){
	$editar=new AjaxRecibo();
	$editar->numRecibo=$_POST["numRecibo"];
	$editar->ajaxEditarRecibo();
}

if(isset($_POST["reciboEliminar"])){
	$eliminar=new AjaxRecibo();
	$eliminar->eliminarNumRecibo=$_POST["reciboEliminar"];
	$eliminar->ajaxEliminarRecibo();
}