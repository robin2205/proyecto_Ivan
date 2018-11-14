<?php
// Requerimos el controlador y el modelo
require_once '../controladores/productos.controlador.php';
require_once '../modelos/productos.modelo.php';

class AjaxTablaProductosVentas{
	// Mostramos la tabla de Productos
	public function mostrarTablaPV(){
		$item=null;
		$valor=null;
		$orden="id";
		$productos=ControladorProductos::ctrTraerProductos($item,$valor,$orden);
		if(count($productos)>0){
			$datosJson='{
				"data":[';
					for($i=0;$i<count($productos);$i++){
						# Traemos la imagen
						$imagen="<img src='".$productos[$i]["imagen"]."' width='40px'>";
						# Traemos el stock
						if($productos[$i]["stock"]==0){
							$stock="<span class='label label-default spanLabel'>".$productos[$i]["stock"]." Und</span>";}
						else if($productos[$i]["stock"]>=1 && $productos[$i]["stock"]<=10){
							$stock="<span class='label label-danger'>".$productos[$i]["stock"]." Und</span>";}
						else if($productos[$i]["stock"]>11 && $productos[$i]["stock"]<=15){
							$stock="<span class='label label-warning'>".$productos[$i]["stock"]." Und</span>";}
						else{
							$stock="<span class='label label-success'>".$productos[$i]["stock"]." Und</span>";}
						# Traemos las acciones
						if($productos[$i]["stock"]==0){
							$botones="<div class='btn-group'><button class='btn btn-default btn-xs'><i class='fa fa-plus-circle'></i> Agregar</button></div>";}
						else{
							$botones="<div class='btn-group'><button class='btn btn-primary btn-xs agregarProductoV recuperarBoton' idproducto='".$productos[$i]["id"]."'><i class='fa fa-plus-circle'></i> Agregar</button></div>";}
						$datosJson.='[
										"'.$productos[$i]["codigo"].'",
										"'.$imagen.'",
										"'.$productos[$i]["descripcion"].'",
										"'.$stock.'",
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
			}';}
	}
}

// Activación de la tabla Productos
$activar=new AjaxTablaProductosVentas();
$activar->mostrarTablaPV();