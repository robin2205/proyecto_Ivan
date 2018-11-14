<?php
// Requerimos el controlador y el modelo
require_once '../controladores/categorias.controlador.php';
require_once '../modelos/categorias.modelo.php';

class AjaxTablaCategorias{
	// Mostramos la tabla de Productos
	public function mostraTablaCategorias(){
		$item=null;
		$valor=null;
		$categorias=ControladorCategorias::ctrTraerCategorias($item,$valor);
		if(count($categorias)!=0){
			$datosJson='{
				"data":[';
				for($i=0;$i<count($categorias);$i++){
	                # Creamos los botones que nos permitiran Editar y Eliminar
	                $botones="<div class='btn-group'><button class='btn btn-warning btnEditarCategoria' idCategoria='".$categorias[$i]["id"]."' title='Editar' data-toggle='modal' data-target='#modalEditarCategoria'><i class='fa fa-pencil'></i></button><button class='btn btn-danger btnEliminarCategoria' title='Eliminar' idCategoria='".$categorias[$i]["id"]."'><i class='fa fa-times'></i></button></div>";
	                # Creamos la estructura JSON
	                $datosJson.='[
									"'.($i+1).'",
									"'.$categorias[$i]["categoria"].'",
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
$activarC=new AjaxTablaCategorias();
$activarC->mostraTablaCategorias();