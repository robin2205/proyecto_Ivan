<?php
require_once '../controladores/ventas.controlador.php';
require_once '../modelos/ventas.modelo.php';
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';
require_once '../controladores/productos.controlador.php';
require_once '../modelos/productos.modelo.php';
require_once '../controladores/recibo.controlador.php';
require_once '../modelos/recibo.modelo.php';
require_once '../controladores/usuarios.controlador.php';
require_once '../modelos/usuarios.modelo.php';

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

	# Método para traer datos de Recibo
	public $reciboBuscar;
	public $idCliente;
	public function ajaxDatosRecibo(){
		$respuesta=ControladorRecibo::ctrTraerRecibos("id_cliente",$this->idCliente,"id_cliente",$this->idCliente,"id_cliente");
		$suma=0;
		for($i=0;$i<count($respuesta);$i++){
			if($respuesta[$i]["num_recibo"]==$this->reciboBuscar){
				$suma=ControladorRecibo::ctrPagoAcumulado($this->reciboBuscar);}}
		echo $suma[0];
	}

	# Método para Traer los datos de Pagos Venta
	public $idVentaPagos;
	public function ajaxPagosVenta(){
		$idVenta=$this->idVentaPagos;
		$respuesta=ControladorVentas::ctrMostrarVentas("id",$idVenta);
		# Capturamos el id del Cliente para traer el nombre
		$valor=$respuesta["id_cliente"];
		$infoCliente=ControladorClientes::ctrMostrarCliente("id",$valor);
		# Capturamos el id del Vendedor para traer el nombre
		$valor=$respuesta["id_vendedor"];
		$infoUsuario=ControladorUsuarios::ctrMostrarUsuarios("id",$valor);
		# Hacemos los cambios al arreglo que se envia como respuesta
		$respuesta["id_cliente"]=$infoCliente["nombre"];
		$respuesta["id_vendedor"]=$infoUsuario["nombre"];
		echo json_encode($respuesta);
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
if(isset($_POST["reciboBuscar"]) && isset($_POST["idCliente"])){
	$datos=new AjaxVentas();
	$datos->reciboBuscar=$_POST["reciboBuscar"];
	$datos->idCliente=$_POST["idCliente"];
	$datos->ajaxDatosRecibo();
}
if(isset($_POST["idVentaPagos"])){
	$pagos=new AjaxVentas();
	$pagos->idVentaPagos=$_POST["idVentaPagos"];
	$pagos->ajaxPagosVenta();
}