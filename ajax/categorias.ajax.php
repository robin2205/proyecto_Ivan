<?php
// Requerimos el controlador y el modelo
require_once '../controladores/categorias.controlador.php';
require_once '../modelos/categorias.modelo.php';

class AjaxCategorias{
	// Editar Categoría
	public $idCategoria;
	public function ajaxEditarCategoria(){
		$item="id";
		$valor=$this->idCategoria;
		$respuesta=ControladorCategorias::ctrTraerCategorias($item,$valor);
		echo json_encode($respuesta);
	}

	// Eliminar Categoría
	public $eliminarIdCategoria;
	public function ajaxEliminarCategoria(){
		$tabla="categorias";
		$respuesta=ModeloCategorias::mdlEliminarCategoria($tabla,$this->eliminarIdCategoria);
		echo $respuesta;
	}
}

// OBJETOS
if(isset($_POST["idCategoria"])){
	$editar=new AjaxCategorias();
	$editar->idCategoria=$_POST["idCategoria"];
	$editar->ajaxEditarCategoria();
}

if(isset($_POST["eliminarIdCategoria"])){
	$eliminar=new AjaxCategorias();
	$eliminar->eliminarIdCategoria=$_POST["eliminarIdCategoria"];
	$eliminar->ajaxEliminarCategoria();
}