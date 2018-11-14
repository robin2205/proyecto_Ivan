<?php
// Requerimos el controlador y el modelo
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';
require_once '../controladores/usuarios.controlador.php';
require_once '../modelos/usuarios.modelo.php';
require_once '../controladores/recibo.controlador.php';
require_once '../modelos/recibo.modelo.php';

class AjaxTablaRecibo{
	// Mostramos la tabla de Productos
	public function mostrarTablaRecibo(){
		$recibos=ControladorRecibo::ctrTraerRecibosRangoFechas($_GET["fechaInicial"],$_GET["fechaFinal"]);
		if(count($recibos)>0){
			$datosJson='{
				"data":[';
					for($i=0;$i<count($recibos);$i++){
						$item="id";
						# Traemos los datos de los clientes
						$respuCliente=ControladorClientes::ctrMostrarCliente($item,$recibos[$i]["id_cliente"]);
						# Traemos los datos del usuario vendedor
						$respuVendedor=ControladorUsuarios::ctrMostrarUsuarios($item,$recibos[$i]["id_usuario"]);
						$pagoAculumado=ControladorRecibo::ctrPagoAcumulado($recibos[$i]["num_recibo"]);
						$botones="<div class='btn-group'><button class='btn btn-info btn-sm btnImprimirRecibo' recibo='".$recibos[$i]["num_recibo"]."' title='Imprimir'><i class='fa fa-print'></i></button><button class='btn btn-success btn-sm btnVerDRecibo' data-toggle='modal' data-target='#modalVerDetalles' idRecibo='".$recibos[$i]["num_recibo"]."' title='Ver Detalles'><i class='fa fa-eye'></i></button><button class='btn btn-warning btn-sm btnEditarRecibo' data-toggle='modal' data-target='#modalEditarRecibo' title='Editar Recibo' idRecibo='".$recibos[$i]["num_recibo"]."'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btn-sm btnEliminarRecibo' title='Eliminar Recibo' idRecibo='".$recibos[$i]["num_recibo"]."'><i class='fa fa-times'></i></button></div>";
						$datosJson.='[
										"'.$recibos[$i]["num_recibo"].'",
										"'.$respuCliente["nombre"].'",
										"'.$respuVendedor["nombre"].'",
										"$ '.number_format($pagoAculumado[0]).'",
										"'.$recibos[$i]["fecha"].'",
										"'.$botones.'"
									],';

					}
					$datosJson=substr($datosJson,0,-1);
					$datosJson.=']
			}';
			echo $datosJson;}
		else{
			echo '{
				"data":[]
			}';
			return;}
	}
}

$tablaRecibo=new AjaxTablaRecibo();
$tablaRecibo->mostrarTablaRecibo();