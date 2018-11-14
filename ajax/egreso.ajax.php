<?php
// Requerimos el controlador y el modelo
require_once '../controladores/egreso.controlador.php';
require_once '../modelos/egreso.modelo.php';
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';

class AjaxEgreso{
	// Ver Detalles de Egreso
	public $idEgreso;
	public function ajaxTraerEgreso(){
		$respuesta=ControladorEgreso::ctrTraerEgresos("id",$this->idEgreso,"id");
		# Capturamos el id del Cliente para traer el nombre
		$valor=$respuesta["id_cliente"];
		$infoCliente=ControladorClientes::ctrMostrarCliente("id",$valor);
		$respuesta["id_cliente"]=$infoCliente["nombre"];
		echo json_encode($respuesta);
	}

	// // Eliminar Categoría
	// public $eliminaridEgreso;
	// public function ajaxEliminarCategoria(){
	// 	$tabla="categorias";
	// 	$respuesta=ModeloCategorias::mdlEliminarCategoria($tabla,$this->eliminaridEgreso);
	// 	echo $respuesta;
	// }
}

// OBJETOS
if(isset($_POST["idEgreso"])){
	$editar=new AjaxEgreso();
	$editar->idEgreso=$_POST["idEgreso"];
	$editar->ajaxTraerEgreso();
}

// if(isset($_POST["eliminarIdCategoria"])){
// 	$eliminar=new AjaxCategorias();
// 	$eliminar->eliminarIdCategoria=$_POST["eliminarIdCategoria"];
// 	$eliminar->ajaxEliminarCategoria();
// }