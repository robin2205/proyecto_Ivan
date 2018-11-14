<?php
// Requerimos el controlador y el modelo
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';

class AjaxTablaClientes{
	// Mostramos la tabla de Productos
	public function mostraTablaClientes(){
		$item=null;
		$valor=null;
		$clientes=ControladorClientes::ctrMostrarCliente($item,$valor);
		if(count($clientes)!=0){
			$datosJson='{
				"data":[';
				for($i=0;$i<count($clientes);$i++){
	                # Creamos los botones que nos permitiran Editar y Eliminar según el perfil de usuario
					if($_GET["perfil"]=="Vendedor"){
						$botones="<div class='btn-group'><button class='btn btn-warning btnEditarUsuario' idCliente='".$clientes[$i]["id"]."' title='Editar' data-toggle='modal' data-target='#modalEditarCliente'><i class='fa fa-pencil'></i></button></div>";}
					else{
	                	$botones="<div class='btn-group'><button class='btn btn-warning btnEditarUsuario' idCliente='".$clientes[$i]["id"]."' title='Editar' data-toggle='modal' data-target='#modalEditarCliente'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarCliente' idCliente='".$clientes[$i]["id"]."' title='Eliminar'><i class='fa fa-times'></i></button></div>";}
	                # Creamos la estructura JSON
	                $datosJson.='[
									"'.$clientes[$i]["tipo_Cliente"].'",
									"'.$clientes[$i]["nombre"].'",
									"'.$clientes[$i]["tipo_Documento"].'",
									"'.$clientes[$i]["documento"].'",
									"'.$clientes[$i]["email"].'",
									"'.$clientes[$i]["contacto"].'",
									"'.$clientes[$i]["direccion"].'",
									"'.$clientes[$i]["total_compras"].'",
									"'.$clientes[$i]["ultima_compra"].'",
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
$activarCl=new AjaxTablaClientes();
$activarCl->mostraTablaClientes();