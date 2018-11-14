<?php

// Requerimos el controlador y el modelo
require_once '../controladores/usuarios.controlador.php';
require_once '../modelos/usuarios.modelo.php';

class AjaxUsuarios{
	// Editar Usuario
	public $idUsuario;
	public function ajaxEditarUsuario(){
		$item="id";
		$valor=$this->idUsuario;
		$respuesta=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
		echo json_encode($respuesta);
	}

	// Activar-Desactivar Usuario
	public $activarId;
	public $activarEstado;
	public function ajaxActivarDesactivarUsuario(){
		$tabla="usuarios";
		$item1="estado";
		$valor1=$this->activarEstado;
		$item2="id";
		$valor2=$this->activarId;
		$respuesta=ModeloUsuarios::mdlActualizarUsuario($tabla,$item1,$valor1,$item2,$valor2);
		echo $respuesta;
	}

	// Válidar Usuarios existente
	public $validarUsuario;
	public function ajaxValidarUsuarioExistente(){
		$item="usuario";
		$valor=$this->validarUsuario;
		$respuesta=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
		echo json_encode($respuesta);
	}

	// Eliminar un usuario
	public $eliminarUsuario;
	public function ajaxEliminarUsuario(){
		$id=$this->eliminarUsuario;
		$respuesta=ControladorUsuarios::ctrEliminarUsuario($id);
		echo $respuesta;
	}
}

// OBJETOS
if(isset($_POST["idUsuario"])){
	$editar=new AjaxUsuarios();
	$editar->idUsuario=$_POST["idUsuario"];
	$editar->ajaxEditarUsuario();
}

if(isset($_POST["activarId"])){
	$activar=new AjaxUsuarios();
	$activar->activarId=$_POST["activarId"];
	$activar->activarEstado=$_POST["activarEstado"];
	$activar->ajaxActivarDesactivarUsuario();
}

if(isset($_POST["nuevoUsuario"])){
	$validar=new AjaxUsuarios();
	$validar->validarUsuario=$_POST["nuevoUsuario"];
	$validar->ajaxValidarUsuarioExistente();
}

if(isset($_POST["usuarioEliminar"])){
	$eliminar=new AjaxUsuarios();
	$eliminar->eliminarUsuario=$_POST["usuarioEliminar"];
	$eliminar->ajaxEliminarUsuario();
}