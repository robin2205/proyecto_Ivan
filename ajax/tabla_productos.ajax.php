<?php
// Requerimos el controlador y el modelo
require_once '../controladores/productos.controlador.php';
require_once '../modelos/productos.modelo.php';
require_once '../controladores/categorias.controlador.php';
require_once '../modelos/categorias.modelo.php';

class AjaxTablaProductos{
	// Mostramos la tabla de Productos
	public function mostraTabla(){
		$item=null;
		$valor=null;
		$orden="id";
		$productos=ControladorProductos::ctrTraerProductos($item,$valor,$orden);
		if(count($productos)!=0){
			$datosJson='{
				"data":[';
				for($i=0;$i<count($productos);$i++){
					$item="id";
	                $valor=$productos[$i]["id_categoria"];
	                $categoria=ControladorCategorias::ctrTraerCategorias($item,$valor);
	                # Creamos los botones que nos permitiran Editar y Eliminar
	                $botones="<div class='btn-group'><button class='btn btn-warning btnEditarProducto' title='Editar' data-toggle='modal' data-target='#modalEditarProducto' idProducto='".$productos[$i]["id"]."'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarProducto' title='Eliminar' data-toggle='modal' data-target='#modalEliminarProducto' idProducto='".$productos[$i]["id"]."'><i class='fa fa-times'></i></button></div>";
	                # Creamos la estructura JSON
	                $datosJson.='[
									"'.$productos[$i]["codigo"].'",
									"'.$productos[$i]["descripcion"].'",
									"'.$categoria["categoria"].'",
									"'.$productos[$i]["stock"].'",
									"'.$productos[$i]["cant_reservada"].'",
									"$ '.number_format($productos[$i]["precio_compra"],0).'",
									"'.$productos[$i]["iva"].'%",
									"$ '.number_format($productos[$i]["precio_venta"],0).'",
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
$activarP=new AjaxTablaProductos();
$activarP->mostraTabla();