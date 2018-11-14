<?php
// Requerimos el controlador y el modelo
require_once '../controladores/productos.controlador.php';
require_once '../modelos/productos.modelo.php';

class AjaxProductos{
	// Método para traer información de una Categoría
	public $idCategoriaCodigo;
	public function ajaxCrearCodigoProducto(){
		$item="id_categoria";
		$valor=$this->idCategoriaCodigo;
		$orden="id";
		$respuesta=ControladorProductos::ctrTraerProductos($item,$valor,$orden);
		echo json_encode($respuesta);
	}

	// Método para editar un producto
	public $idProducto;
	public function ajaxEditarProducto(){
		$item="id";
		$valor=$this->idProducto;
		$orden="id";
		$respuesta=ControladorProductos::ctrTraerProductos($item,$valor,$orden);
		echo json_encode($respuesta);
	}

	// Método para eliminar un producto
	public $productoEliminar;
	public function ajaxEliminarProducto(){
		$id=$this->productoEliminar;
		$respuesta=ControladorProductos::ctrEliminarProductos($id);
		echo $respuesta;
	}

	// Método para Traer todos los productos
	public $traerProductos;
	public function ajaxMostrarProductos(){
		if($this->traerProductos=="ok"){
			$item=null;
			$valor=null;
			$orden="id";
			$respuesta=ControladorProductos::ctrTraerProductos($item,$valor,$orden);
			echo json_encode($respuesta);}
	}
}

// OBJETOS
if(isset($_POST["idCategoriaCodigo"])){
	$infoCategoria=new AjaxProductos();
	$infoCategoria->idCategoriaCodigo=$_POST["idCategoriaCodigo"];
	$infoCategoria->ajaxCrearCodigoProducto();
}

if(isset($_POST["idProducto"])){
	$editarProducto=new AjaxProductos();
	$editarProducto->idProducto=$_POST["idProducto"];
	$editarProducto->ajaxEditarProducto();
}

if(isset($_POST["productoEliminar"])){
	$editarProducto=new AjaxProductos();
	$editarProducto->productoEliminar=$_POST["productoEliminar"];
	$editarProducto->ajaxEliminarProducto();
}

if(isset($_POST["traerProductos"])){
	$productos=new AjaxProductos();
	$productos->traerProductos=$_POST["traerProductos"];
	$productos->ajaxMostrarProductos();
}