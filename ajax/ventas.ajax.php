<?php
require_once '../controladores/ventas.controlador.php';
require_once '../modelos/ventas.modelo.php';
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';
require_once '../controladores/productos.controlador.php';
require_once '../modelos/productos.modelo.php';

class AjaxVentas{
	# Método para traer un Producto
	public $producto;
	public function ajaxTraerProducto(){
		$item="codigo";
		$valor=$this->producto;
		$respuesta=ControladorProductos::ctrTraerProductos($item,$valor,$item);
		echo json_encode($respuesta);
	}
	# Método para anular una Venta
	public $idVenta;
	public function ajaxAnularVenta(){
		$idVenta=$this->idVenta;
		$respuesta=ControladorVentas::ctrAnularVenta($idVenta);
		echo $respuesta;
	}
}

// OBJETOS
if(isset($_POST["producto"])){
	$traerProducto=new AjaxVentas();
	$traerProducto->producto=$_POST["producto"];
	$traerProducto->ajaxTraerProducto();
}
if(isset($_POST["idVenta"])){
	$anularVenta=new AjaxVentas();
	$anularVenta->idVenta=$_POST["idVenta"];
	$anularVenta->ajaxAnularVenta();
}