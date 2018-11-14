<?php
// Requerimos la Conexión a la Base de Datos
require_once 'conexion.php';

// Clase de Modelo
class ModeloUsuarios{
	// Método para realizar el ingreso al sistema
	static public function mdlTraerUsuarios($tabla,$item,$valor){
		if($item!=null){
			# Creamos el SQL
			$sql="SELECT * FROM $tabla WHERE $item=:$item";
			# Preparamos la conexión
			$stmt=Conexion::conectar()->prepare($sql);
			# Enlazamos el parámetro de busqueda
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			# Ejecutamos la sentencia
			$stmt->execute();
			# Retornamos un fetch por ser una sola línea la que necesitamos devolver
			return $stmt->fetch();}
		else{
			# Creamos el SQL
			$sql="SELECT * FROM $tabla";
			# Preparamos la conexión
			$stmt=Conexion::conectar()->prepare($sql);
			# Ejecutamos la sentencia
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();
		}
		# Anulamos el objeto PDO
		$stmt=null;
	}

	// Método para realizar el registro de un usuario
	static public function mdlCrearUsuario($tabla,$datos){
		$sql="INSERT INTO $tabla(nombre,usuario,password,perfil) VALUES (:nombre,:usuario,:password,:perfil)";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
		$stmt->bindParam(":usuario",$datos["usuario"],PDO::PARAM_STR);
		$stmt->bindParam(":password",$datos["password"],PDO::PARAM_STR);
		$stmt->bindParam(":perfil",$datos["perfil"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para realizar la actualización de un usuario
	static public function mdlEditarUsuario($tabla,$datos){
		$sql="UPDATE $tabla SET nombre=:nombre,password=:password,perfil=:perfil WHERE usuario=:usuario";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
		$stmt->bindParam(":usuario",$datos["usuario"],PDO::PARAM_STR);
		$stmt->bindParam(":password",$datos["password"],PDO::PARAM_STR);
		$stmt->bindParam(":perfil",$datos["perfil"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para activar y desactivar un usuario
	static public function mdlActualizarUsuario($tabla,$item1,$valor1,$item2,$valor2){
		$sql="UPDATE $tabla SET $item1=:$item1 WHERE $item2=:$item2";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
		$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para Eliminar un usuario
	static public function mdlEliminarUsuario($tabla,$id){
		$sql="DELETE FROM $tabla WHERE id=:id";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}
}