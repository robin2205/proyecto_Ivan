<?php
// Requerimos el controlador y el modelo
require_once '../controladores/egreso.controlador.php';
require_once '../modelos/egreso.modelo.php';
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';
require_once '../controladores/usuarios.controlador.php';
require_once '../modelos/usuarios.modelo.php';

class AjaxTablaEgresos{
	// Mostramos la tabla de Productos
	public function mostraTablaEgresos(){
		$orden="id";
		$egresos=ControladorEgreso::ctrTraerEgresos(null,null,$orden);
		if(count($egresos)!=0){
			$datosJson='{
				"data":[';
				for($i=0;$i<count($egresos);$i++){
					$item="id";
					# Traemos los datos de los clientes
					$respuCliente=ControladorClientes::ctrMostrarCliente($item,$egresos[$i]["id_cliente"]);
					# Traemos los datos del usuario vendedor
					$respuVendedor=ControladorUsuarios::ctrMostrarUsuarios($item,$egresos[$i]["id_usuario"]);
	                # Creamos los botones que nos permitiran Editar y Eliminar según el perfil de usuario
                	$botones="<div class='btn-group'><button class='btn btn-info btn-sm btnImprimirEgreso' egreso='".$egresos[$i]["id"]."' title='Imprimir'><i class='fa fa-print'></i></button><button class='btn btn-sm btn-success btnVerObEgresos' idEgreso='".$egresos[$i]["id"]."' title='Ver Observaciones' data-toggle='modal' data-target='#modalVerObEgresos'><i class='fa fa-eye'></i></button><button class='btn btn-warning btn-sm btnEditarEgreso' title='Editar' data-toggle='modal' data-target='#modalEditarEgreso' idEgreso='".$egresos[$i]["id"]."'><i class='fa fa-pencil'></i></button><button class='btn btn-sm btn-danger btnEliminarCliente' idEgreso='".$egresos[$i]["id"]."' title='Eliminar'><i class='fa fa-times'></i></button></div>";
	                # Creamos la estructura JSON
	                $datosJson.='[
									"'.$egresos[$i]["id"].'",
									"'.$respuCliente["nombre"].'",
									"'.$respuVendedor["nombre"].'",
									"$ '.number_format($egresos[$i]["valor"],0).'",
									"'.$egresos[$i]["fecha"].'",
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
$activarEgresos=new AjaxTablaEgresos();
$activarEgresos->mostraTablaEgresos();