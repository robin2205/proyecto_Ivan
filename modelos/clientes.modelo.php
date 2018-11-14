<?php
require_once 'conexion.php';

class ModeloClientes{
	// Método para mostrar un Cliente de la BD
	static public function mdlMostrarCliente($tabla,$item,$valor){
		if($item!=null){
			$sql="SELECT * FROM $tabla WHERE $item=:$item";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->execute();
			# Retornamos un fetch por ser una sola línea la que necesitamos devolver
			return $stmt->fetch();}
		else{
			$sql="SELECT * FROM $tabla ORDER BY nombre";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();}
		$stmt=null;
	}

	// Método para crear un Nuevo Cliente en la BD
	static public function mdlNuevoCliente($tabla,$datos){
		$sql="INSERT INTO $tabla(tipo_Cliente,nombre,tipo_Documento,documento,email,contacto,direccion,fecha_nacimiento) VALUES (:tipo_Cliente,:nombre,:tipo_Documento,:documento,:email,:contacto,:direccion,:fecha_nacimiento)";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":tipo_Cliente",$datos["tipo_Cliente"],PDO::PARAM_STR);
		$stmt->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
		$stmt->bindParam(":tipo_Documento",$datos["tipo_Documento"],PDO::PARAM_STR);
		$stmt->bindParam(":documento",$datos["documento"],PDO::PARAM_STR);
		$stmt->bindParam(":email",$datos["email"],PDO::PARAM_STR);
		$stmt->bindParam(":contacto",$datos["contacto"],PDO::PARAM_STR);
		$stmt->bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);
		$stmt->bindParam(":fecha_nacimiento",$datos["fecha_nacimiento"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para editar un Cliente en la BD
	static public function mdlEditarCliente($tabla,$datos){
		$sql="UPDATE $tabla SET nombre=:nombre,email=:email,contacto=:contacto,direccion=:direccion WHERE id=:id";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":id",$datos["id"],PDO::PARAM_INT);
		$stmt->bindParam(":nombre",$datos["nombre"],PDO::PARAM_STR);
		$stmt->bindParam(":email",$datos["email"],PDO::PARAM_STR);
		$stmt->bindParam(":contacto",$datos["contacto"],PDO::PARAM_STR);
		$stmt->bindParam(":direccion",$datos["direccion"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para Eliminar un Cliente de la BD
	static public function mdlEliminarCliente($tabla,$item){
		$sql="DELETE FROM $tabla WHERE id=:id";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":id",$item,PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}
}