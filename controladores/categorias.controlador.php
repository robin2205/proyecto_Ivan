<?php

class ControladorCategorias{
	// Método para registrar una Categoría nueva
	public function ctrNuevaCategoria(){
		if(isset($_POST["nuevoCategoria"])){
			if(preg_match('/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ. ]+$/',$_POST["nuevoCategoria"])){
				# Ponemos mayúsculas iniciales a la descripción, pero convertimos el string en minúsculas primero
				$_POST["nuevoCategoria"]=ucwords(mb_strtolower($_POST["nuevoCategoria"]));
				$tabla="categorias";
				$respuesta=ModeloCategorias::mdlNuevaCategoria($tabla,$_POST["nuevoCategoria"]);
				if($respuesta=="ok"){
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "success",
								title: "Felicitaciones",
								text: "¡La información fue registrada con éxito!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="categorias";}
							});
						</script>';}
				else{
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "error",
								title: "Error",
								text: "¡La información presento problemas y no se registro adecuadamente. Por favor, intenteló de nuevo!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="categorias";}
							});
						</script>';}}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información ingresada esta errada. No se permiten caracteres especiales. Por favor verifique los campos y corrija la información!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="categorias";}
						});
					</script>';}
		}
	}

	// Método para traer las Categorías
	static public function ctrTraerCategorias($item,$valor){
		$tabla="categorias";
		$respuesta=ModeloCategorias::mdlTraerCategorias($tabla,$item,$valor);
		return $respuesta;
	}

	// Método para editar las Categorías
	public function ctrEditarCategoria(){
		if(isset($_POST["idCategoria"])){
			if(preg_match('/^[0-9]+$/',$_POST["idCategoria"]) && preg_match('/^[a-zA-Z0-9áéíóúñÁÉÍÓÚÑ. ]+$/',$_POST["editarCategoria"])){
				$tabla="categorias";
				$datos=array("idCategoria"=>$_POST["idCategoria"],"categoria"=>$_POST["editarCategoria"]);
				$respuesta=ModeloCategorias::mdlEditarCategoria($tabla,$datos);
				if($respuesta=="ok"){
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "success",
								title: "Felicitaciones",
								text: "¡La información fue actualizó con éxito!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="categorias";}
							});
						</script>';}
				else{
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "error",
								title: "Error",
								text: "¡La información presento problemas y no se actualizó adecuadamente. Por favor, intenteló de nuevo!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="categorias";}
							});
						</script>';}}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información ingresada esta errada. No se permiten caracteres especiales. Por favor verifique los campos y corrija la información!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="categorias";}
						});
					</script>';}
		}
	}
}