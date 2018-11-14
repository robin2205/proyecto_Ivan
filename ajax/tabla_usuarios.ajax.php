<?php
// Requerimos el controlador y el modelo
require_once '../controladores/usuarios.controlador.php';
require_once '../modelos/usuarios.modelo.php';

class AjaxTablaUsuarios{
	// Mostramos la tabla de Productos
	public function mostraTablaUsuarios(){
		$item=null;
		$valor=null;
		$usuarios=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
		if(count($usuarios)!=0){
			$datosJson='{
				"data":[';
				for($i=0;$i<count($usuarios);$i++){
					# Verificamos el estado del usuario
					if($usuarios[$i]["estado"]==1){
						$estado="<button class='btn btn-success btn-xs btnActivar' idUsuario='".$usuarios[$i]["id"]."' estadoUsuario='0'>Activado</button>";}
					else{
						$estado="<button class='btn btn-danger btn-xs btnActivar' idUsuario='".$usuarios[$i]["id"]."' estadoUsuario='1'>Desactivado</button>";}
	                # Creamos los botones que nos permitiran Editar y Eliminar
	                $botones="<div class='btn-group'><button class='btn btn-warning btnEditarUsuario' idUsuario='".$usuarios[$i]["id"]."' title='Editar' data-toggle='modal' data-target='#modalEditarUsuario'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarUsuario' idUsuario='".$usuarios[$i]["id"]."' title='Eliminar'><i class='fa fa-times'></i></button></div>";
	                # Creamos la estructura JSON
	                $datosJson.='[
									"'.$usuarios[$i]["nombre"].'",
									"'.$usuarios[$i]["usuario"].'",
									"'.$usuarios[$i]["perfil"].'",
									"'.$estado.'",
									"'.$botones.'"
								],';
	            }
				$datosJson=substr($datosJson,0,-1);
				$datosJson.=']}';
			echo $datosJson;}
		else{
			echo '{"data":[]}';
			return;}
	}
}

// Activación de la tabla Productos
$activarU=new AjaxTablaUsuarios();
$activarU->mostraTablaUsuarios();