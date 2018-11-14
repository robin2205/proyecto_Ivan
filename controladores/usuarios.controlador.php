<?php
// Clase del Controlador
class ControladorUsuarios{
	// Método para mostrar los Usuarios
	static public function ctrMostrarUsuarios($item,$valor){
	 	$tabla="usuarios";
	 	$respuesta=ModeloUsuarios::mdlTraerUsuarios($tabla,$item,$valor);
	 	return $respuesta;
	}

	// Método para realizar el ingreso de los usuarios
	public function ctrIngresoUsuario(){
		# Verificamos si vienen variables POST
		if(isset($_POST["ingUsuario"])){
			if(preg_match('/^[a-zA-Z]+$/',$_POST["ingUsuario"]) && preg_match('/^[a-zA-Z0-9]+$/',$_POST["ingPassword"])){
				# Convertimos los datos en minuscula
				$_POST["ingUsuario"]=mb_strtolower($_POST["ingUsuario"]);
				$_POST["ingPassword"]=mb_strtolower($_POST["ingPassword"]);
				# Encriptamos la contraseña
				$encriptar=crypt($_POST["ingPassword"],'$2a$07$asxx54ahjppf45sd87aa5a4dDDGsystemdev$');
				$tabla="usuarios";
				$item="usuario";
				$valor=$_POST["ingUsuario"];
				$respuesta=ModeloUsuarios::mdlTraerUsuarios($tabla,$item,$valor);
				# Validamos que nos trae la respuesta
				if($respuesta["usuario"]==$_POST["ingUsuario"] && $respuesta["password"]==$encriptar){
					if($respuesta["estado"]==1 && $respuesta["iniciada"]==0){
						# Creamos las variables de Session
						$_SESSION["iniciarSesion"]="ok";
						$_SESSION["id"]=$respuesta["id"];
						$_SESSION["nombre"]=$respuesta["nombre"];
						$_SESSION["usuario"]=$respuesta["usuario"];
						$_SESSION["perfil"]=$respuesta["perfil"];
						$_SESSION["fecha"]=$respuesta["fecha"];

						# Capturamos la fecha y hora de ingreso
						date_default_timezone_set('America/Bogota');
						$fecha=date('Y-m-d');
						$hora=date('H:i:s');
						$fechaActual=$fecha.' '.$hora;

						# Realizamos la actualización del último login
						$item1="ultimo_login";
						$valor1=$fechaActual;
						$item2="id";
						$valor2=$respuesta["id"];
						ModeloUsuarios::mdlActualizarUsuario($tabla,$item1,$valor1,$item2,$valor2);

						# Realizamos la actualización de la Sesión iniciada
						ModeloUsuarios::mdlActualizarUsuario($tabla,"iniciada",1,$item2,$valor2);

						# Redireccionamos
						echo '<script>
								window.location="inicio";
							</script>';}
					else{
						echo '<div class="alert alert-danger alert-dismissable" id="mensajeError">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
						    <strong>Error!</strong> El usuario se encuentra Desactivado o ya tiene una Sesión Iniciada. Por favor, pongase en contacto con el administrador del Sistema.
						</div>';}}
				else{
					echo '<div class="alert alert-danger alert-dismissable" id="mensajeError">
							<a href="#" class="close" data-dismiss="alert" aria-label="close">x</a>
						    <strong>Error!</strong> La información de ingreso es incorrecta. Por favor verifique nuevamente.
						</div>';}
			}
		}
	}

	// Método para Crear un usuario
	public function ctrCrearUsuario(){
		if(isset($_POST["nuevoNombre"])){
			if(preg_match('/^[A-Za-záéíóúñÁÉÍÓÚÑ ]+$/',$_POST["nuevoNombre"]) && preg_match('/^[A-Za-záéíóúñÁÉÍÓÚÑ]+$/',$_POST["nuevoUsuario"]) && preg_match('/^[A-Za-z0-9áéíóúñÁÉÍÓÚÑ.]+$/',$_POST["nuevoPassword"])){
				$_POST["nuevoUsuario"]=mb_strtolower($_POST["nuevoUsuario"]);
				$_POST["nuevoPassword"]=mb_strtolower($_POST["nuevoPassword"]);
				$tabla="usuarios";
				# Encriptamos la contraseña
				$encriptar=crypt($_POST["nuevoPassword"],'$2a$07$asxx54ahjppf45sd87aa5a4dDDGsystemdev$');
				# Ponemos mayúsculas iniciales a la descripción, pero convertimos el string en minúsculas primero
				$_POST["nuevoNombre"]=ucwords(mb_strtolower($_POST["nuevoNombre"]));

				$datos=array("nombre"=>$_POST["nuevoNombre"],"usuario"=>$_POST["nuevoUsuario"],"password"=>$encriptar,"perfil"=>$_POST["nuevoPerfil"]);
				$respuesta=ModeloUsuarios::mdlCrearUsuario($tabla,$datos);
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
									window.location="usuarios";}
							});
						</script>';}
				else{
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "error",
								title: "Error",
								text: "¡La información no se Registro. Por favor intentelo de nuevo!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="usuarios";}
							});
						</script>';}
			}
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
								window.location="usuarios";}
						});
					</script>';
			}
		}
	}

	// Método para Editar la información de un usuario
	public function ctrEditarUsuario(){
		if(isset($_POST["editarUsuario"])){
			if(preg_match('/^[A-Za-záéíóúñÁÉÍÓÚÑ ]+$/',$_POST["editarNombre"])){
				# Verificamos si se hizo cambio en el Password
				if($_POST["editarPassword"]!=""){
					if(preg_match('/^[A-Za-z0-9áéíóúñÁÉÍÓÚÑ.]+$/',$_POST["editarPassword"])){
						$_POST["editarPassword"]=strtolower($_POST["editarPassword"]);
						$encriptar=crypt($_POST["editarPassword"],'$2a$07$asxx54ahjppf45sd87aa5a4dDDGsystemdev$');}
					else{
						# Mostramos una alerta suave
						echo '<script>
								swal({
									type: "error",
									title: "Error",
									text: "¡La Contraseña no puede contener caracteres especiales!",
									showConfirmButton: true,
									confirmButtonText: "Cerrar"
								}).then((result)=>{
									if(result.value){
										window.location="usuarios";}
								});
							</script>';}}
				else{
					$encriptar=$_POST["passwordActual"];}
				$tabla="usuarios";
				$datos=array("nombre"=>$_POST["editarNombre"],"usuario"=>$_POST["editarUsuario"],"password"=>$encriptar,"perfil"=>$_POST["editarPerfil"]);
				$respuesta=ModeloUsuarios::mdlEditarUsuario($tabla,$datos);
				if($respuesta=="ok"){
					# Verificamos si el usuario es el admin para actualizar las variables de session
					if($_POST["editarUsuario"]=="admin"){
						$_SESSION["nombre"]=$_POST["editarNombre"];
						$_SESSION["usuario"]=$_POST["editarUsuario"];
						$_SESSION["perfil"]=$_POST["editarPerfil"];
					}
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
									window.location="usuarios";}
							});
						</script>';}
				else{
					# Mostramos una alerta suave
					echo '<script>
							swal({
								type: "error",
								title: "Error",
								text: "¡La información no se actualizó. Por favor intentelo de nuevo!",
								showConfirmButton: true,
								confirmButtonText: "Cerrar"
							}).then((result)=>{
								if(result.value){
									window.location="usuarios";}
							});
						</script>';}
			}
			else{
				# Mostramos una alerta suave
				echo '<script>
						swal({
							type: "error",
							title: "Error",
							text: "¡El Nombre no puede contener caracteres especiales o ir vacío!",
							showConfirmButton: true,
							confirmButtonText: "Cerrar"
						}).then((result)=>{
							if(result.value){
								window.location="usuarios";}
						});
					</script>';}
		}
	}

	// Método para Eliminar un usuario
	static public function ctrEliminarUsuario($id){
		$tabla="usuarios";
	 	$respuesta=ModeloUsuarios::mdlEliminarUsuario($tabla,$id);
		return $respuesta;
	}
}