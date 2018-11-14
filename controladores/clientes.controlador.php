<?php
class ControladorClientes{
	// Método para Mostrar un Cliente Especificio
	static public function ctrMostrarCliente($item,$valor){
		$tabla="clientes";
		$respuesta=ModeloClientes::mdlMostrarCliente($tabla,$item,$valor);
		return $respuesta;
	}

	// Método para crear un Nuevo Cliente
	public function ctrNuevoCliente(){
		if(isset($_POST["tipoCliente"]) || isset($_POST["nombreCliente"]) || isset($_POST["documentoCliente"])){
			if(preg_match('/^[A-Z]+$/',$_POST["tipoCliente"]) && preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/',$_POST["nombreCliente"]) && preg_match('/^[A-Z]+$/',$_POST["tipoDocumento"]) && preg_match('/^[a-zA-Z0-9]+$/',$_POST["documentoCliente"]) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST["emailCliente"]) && preg_match('/^[0-9-() ]+$/',$_POST["contactoCliente"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["direccionCliente"])){
				if($_POST["fechaNacimientoCliente"]!=""){
					if(preg_match('/^[0-9-]+$/',$_POST["fechaNacimientoCliente"])){
						# Válidamos que la persona sea mayor de Edad
						date_default_timezone_set('America/Bogota');
						$edad=intval((strtotime("now")-strtotime($_POST["fechaNacimientoCliente"]))/31536000);
						if($edad>=18){
							/*NOTA IMPORTANTE: Al utilizar la conversión strtolower sin el mb... se pierden los acentos, tildes, etc*/
							$_POST["nombreCliente"]=ucwords(mb_strtolower($_POST["nombreCliente"]));
							$datos=array("tipo_Cliente"=>$_POST["tipoCliente"],"nombre"=>$_POST["nombreCliente"],"tipo_Documento"=>$_POST["tipoDocumento"],"documento"=>$_POST["documentoCliente"],"email"=>$_POST["emailCliente"],"contacto"=>$_POST["contactoCliente"],"direccion"=>$_POST["direccionCliente"],"fecha_nacimiento"=>$_POST["fechaNacimientoCliente"]);}
						else{
							# Mostramos una alerta suave
							echo '<script>
									swal({
										type: "error",
										title: "Error",
										text: "¡La persona no es mayor de Edad. Por favor, intenteló de nuevo!",
										showConfirmButton: true,
										confirmButtonText: "Cerrar"
									}).then((result)=>{
										if(result.value){
											window.location="clientes";}
									});
								</script>';}}
					else{
						# Mostramos una alerta suave
						echo '<script>
								swal({
									type: "error",
									title: "Error",
									text: "¡La información ingresada esta errada. No se permiten caracteres especiales ni campos vacíos. Por favor verifique la información!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
								}).then((result)=>{
									if(result.value){
										window.location="clientes";}
								});
							</script>';}}
				else{
					/*NOTA IMPORTANTE: Al utilizar la conversión strtolower sin el mb... se pierden los acentos, tildes, etc*/
					$_POST["nombreCliente"]=ucwords(mb_strtolower($_POST["nombreCliente"]));
					$datos=array("tipo_Cliente"=>$_POST["tipoCliente"],"nombre"=>$_POST["nombreCliente"],"tipo_Documento"=>$_POST["tipoDocumento"],"documento"=>$_POST["documentoCliente"],"email"=>$_POST["emailCliente"],"contacto"=>$_POST["contactoCliente"],"direccion"=>$_POST["direccionCliente"],"fecha_nacimiento"=>"0000-00-00");}
				$tabla="clientes";
				$respuesta=ModeloClientes::mdlNuevoCliente($tabla,$datos);
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
									window.location="clientes";}
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
									window.location="clientes";}
							});
						</script>';}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información ingresada esta errada. No se permiten caracteres especiales ni campos vacíos. Por favor verifique la información!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="clientes";}
						});
					</script>';}
		}
	}

	// Método para crear un Nuevo Cliente desde el Inicio
	public function ctrNuevoClientedesdeInicio(){
		if(isset($_POST["tipoCliente"]) || isset($_POST["nombreCliente"]) || isset($_POST["documentoCliente"])){
			if(preg_match('/^[A-Z]+$/',$_POST["tipoCliente"]) && preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/',$_POST["nombreCliente"]) && preg_match('/^[A-Z]+$/',$_POST["tipoDocumento"]) && preg_match('/^[a-zA-Z0-9]+$/',$_POST["documentoCliente"]) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST["emailCliente"]) && preg_match('/^[0-9-() ]+$/',$_POST["contactoCliente"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["direccionCliente"])){
				if($_POST["fechaNacimientoCliente"]!=""){
					if(preg_match('/^[0-9-]+$/',$_POST["fechaNacimientoCliente"])){
						# Válidamos que la persona sea mayor de Edad
						date_default_timezone_set('America/Bogota');
						$edad=intval((strtotime("now")-strtotime($_POST["fechaNacimientoCliente"]))/31536000);
						if($edad>=18){
							/*NOTA IMPORTANTE: Al utilizar la conversión strtolower sin el mb... se pierden los acentos, tildes, etc*/
							$_POST["nombreCliente"]=ucwords(mb_strtolower($_POST["nombreCliente"]));
							$datos=array("tipo_Cliente"=>$_POST["tipoCliente"],"nombre"=>$_POST["nombreCliente"],"tipo_Documento"=>$_POST["tipoDocumento"],"documento"=>$_POST["documentoCliente"],"email"=>$_POST["emailCliente"],"contacto"=>$_POST["contactoCliente"],"direccion"=>$_POST["direccionCliente"],"fecha_nacimiento"=>$_POST["fechaNacimientoCliente"]);}
						else{
							# Mostramos una alerta suave
							echo '<script>
									swal({
										type: "error",
										title: "Error",
										text: "¡La persona no es mayor de Edad. Por favor, intenteló de nuevo!",
										showConfirmButton: true,
										confirmButtonText: "Cerrar"
									}).then((result)=>{
										if(result.value){
											window.location="inicio";}
									});
								</script>';}}
					else{
						# Mostramos una alerta suave
						echo '<script>
								swal({
									type: "error",
									title: "Error",
									text: "¡La información ingresada esta errada. No se permiten caracteres especiales ni campos vacíos. Por favor verifique la información!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
								}).then((result)=>{
									if(result.value){
										window.location="inicio";}
								});
							</script>';}}
				else{
					/*NOTA IMPORTANTE: Al utilizar la conversión strtolower sin el mb... se pierden los acentos, tildes, etc*/
					$_POST["nombreCliente"]=ucwords(mb_strtolower($_POST["nombreCliente"]));
					$datos=array("tipo_Cliente"=>$_POST["tipoCliente"],"nombre"=>$_POST["nombreCliente"],"tipo_Documento"=>$_POST["tipoDocumento"],"documento"=>$_POST["documentoCliente"],"email"=>$_POST["emailCliente"],"contacto"=>$_POST["contactoCliente"],"direccion"=>$_POST["direccionCliente"],"fecha_nacimiento"=>"0000-00-00");}
				$tabla="clientes";
				$respuesta=ModeloClientes::mdlNuevoCliente($tabla,$datos);
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
									window.location="inicio";}
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
									window.location="inicio";}
							});
						</script>';}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información ingresada esta errada. No se permiten caracteres especiales ni campos vacíos. Por favor verifique la información!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="inicio";}
						});
					</script>';}
		}
	}

	// Método para editar un Cliente
	public function ctrEditarCliente(){
		if(isset($_POST["editarIdCliente"]) || isset($_POST["editarNombreCliente"])){
			if(preg_match('/^[0-9]+$/',$_POST["editarIdCliente"]) && preg_match('/^[a-zA-ZáéíóúñÁÉÍÓÚÑ ]+$/',$_POST["editarNombreCliente"]) && preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/',$_POST["editarEmailCliente"]) && preg_match('/^[0-9-() ]+$/',$_POST["editarContactoCliente"]) && preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/',$_POST["editarDireccionCliente"])){
				$tabla="clientes";
				$_POST["editarNombreCliente"]=ucwords(mb_strtolower($_POST["editarNombreCliente"]));
				$datos=array("id"=>$_POST["editarIdCliente"],"nombre"=>$_POST["editarNombreCliente"],"email"=>$_POST["editarEmailCliente"],"contacto"=>$_POST["editarContactoCliente"],"direccion"=>$_POST["editarDireccionCliente"]);
				$respuesta=ModeloClientes::mdlEditarCliente($tabla,$datos);
				if($respuesta=="ok"){
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "success",
								title: "Felicitaciones",
								text: "¡La información fue actualizada con éxito!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="clientes";}
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
									window.location="clientes";}
							});
						</script>';}}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡La información editada esta errada. No se permiten caracteres especiales ni campos vacíos. Por favor verifique la información!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="clientes";}
						});
					</script>';}
		}
	}

	// Método para Eliminar un Cliente Especificio
	static public function ctrEliminarCliente($item){
		$tabla="clientes";
		$respuesta=ModeloClientes::mdlEliminarCliente($tabla,$item);
		return $respuesta;
	}
}