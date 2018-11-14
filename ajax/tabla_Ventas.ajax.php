<?php
// Requerimos el controlador y el modelo
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';
require_once '../controladores/usuarios.controlador.php';
require_once '../modelos/usuarios.modelo.php';
require_once '../controladores/ventas.controlador.php';
require_once '../modelos/ventas.modelo.php';

class AjaxTablaVentas{
	// Mostramos la tabla de Productos
	public function mostrarTablaVentas(){
		$estado="AC";
		$ventas=ControladorVentas::ctrRangoFechasVentas($_GET["fechaInicial"],$_GET["fechaFinal"],$estado);
		if(count($ventas)>0){
			$datosJson='{
				"data":[';
					for($i=0;$i<count($ventas);$i++){
						$item="id";
						# Traemos los datos de los clientes
						$valorC=$ventas[$i]["id_cliente"];
						$respuCliente=ControladorClientes::ctrMostrarCliente($item,$valorC);
						# Traemos los datos del usuario vendedor
						$valorU=$ventas[$i]["id_vendedor"];
						$respuVendedor=ControladorUsuarios::ctrMostrarUsuarios($item,$valorU);
						# Válidamos el perfil del usuario que ingresó
						if($_GET["perfil"]=="Administrador"){
							$botones="<div class='btn-group'><button class='btn btn-info btn-sm btnImprimirFactura' factura='".$ventas[$i]["factura"]."' title='Imprimir'><i class='fa fa-print'></i></button><button class='btn btn-warning btn-sm btnEditarVenta' title='Editar Venta' idVenta='".$ventas[$i]["id"]."'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btn-sm btnEliminarVenta' title='Eliminar Venta' idVenta='".$ventas[$i]["id"]."'><i class='fa fa-times'></i></button></div>";}
						else{
							$botones="<div class='btn-group'><button class='btn btn-info btn-sm btnImprimirFactura' factura='".$ventas[$i]["factura"]."' title='Imprimir'><i class='fa fa-print'></i></button></div>";}
						$datosJson.='[
										"'.$ventas[$i]["factura"].'",
										"'.$respuCliente["nombre"].'",
										"'.$respuVendedor["nombre"].'",
										"'.$ventas[$i]["metodo_pago"].'",
										"$ '.number_format($ventas[$i]["subtotalventa"]).'",
										"$ '.number_format($ventas[$i]["total"]).'",
										"'.$ventas[$i]["fecha"].'",
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

$tablaVentas=new AjaxTablaVentas();
$tablaVentas->mostrarTablaVentas();