<?php
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';

class AjaxClientes{
	# Método para buscar un Cliente en la BD
	public $identificacion;
	public function ajaxBuscarCliente(){
		$item="documento";
		$valor=$this->identificacion;
		$respuesta=ControladorClientes::ctrMostrarCliente($item,$valor);
		echo json_encode($respuesta);
	}

	# Método para válidar si existe un Documento en la BD
	public $documento;
	public function ajaxValidarDocumento(){
		$item="documento";
		$valor=$this->documento;
		$respuesta=ControladorClientes::ctrMostrarCliente($item,$valor);
		echo json_encode($respuesta);
	}

	# Método para mostrar la info del Cliente que se va a editar
	public $idCliente;
	public function ajaxEditarCliente(){
		$item="id";
		$valor=$this->idCliente;
		$respuesta=ControladorClientes::ctrMostrarCliente($item,$valor);
		echo json_encode($respuesta);
	}

	# Método para eliminar la info del Cliente
	public $clienteEliminar;
	public function ajaxEliminarCliente(){
		$item=$this->clienteEliminar;
		$respuesta=ControladorClientes::ctrEliminarCliente($item);
		echo $respuesta;
	}
}

// OBJETOS
if(isset($_POST["identificacion"])){
	$buscarCliente=new AjaxClientes();
	$buscarCliente->identificacion=$_POST["identificacion"];
	$buscarCliente->ajaxBuscarCliente();
}

if(isset($_POST["documento"])){
	$validarDocumento=new AjaxClientes();
	$validarDocumento->documento=$_POST["documento"];
	$validarDocumento->ajaxValidarDocumento();
}

if(isset($_POST["idCliente"])){
	$editarCliente=new AjaxClientes();
	$editarCliente->idCliente=$_POST["idCliente"];
	$editarCliente->ajaxEditarCliente();
}

if(isset($_POST["clienteEliminar"])){
	$eliminarCliente=new AjaxClientes();
	$eliminarCliente->clienteEliminar=$_POST["clienteEliminar"];
	$eliminarCliente->ajaxEliminarCliente();
}