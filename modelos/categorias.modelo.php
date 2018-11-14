<?php
// Requerimos la conexión a la base de datos
require_once 'conexion.php';

class ModeloCategorias{
	// Método para registrar una nueva Categoría en la Base de Datos
	public function mdlNuevaCategoria($tabla,$datos){
		$sql="INSERT INTO $tabla(categoria) VALUES (:categoria)";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":categoria",$datos,PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para las Categorías de la Base de Datos
	public function mdlTraerCategorias($tabla,$item,$valor){
		if($item!=null){
			$sql="SELECT * FROM $tabla WHERE $item=:$item";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->execute();
			# Retornamos un fetch por ser una sola línea la que necesitamos devolver
			return $stmt->fetch();}
		else{
			$sql="SELECT * FROM $tabla";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();
		}
		$stmt=null;
	}

	// Método para editar una nueva Categoría en la Base de Datos
	public function mdlEditarCategoria($tabla,$datos){
		$sql="UPDATE $tabla SET categoria=:categoria WHERE id=:idCategoria";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":idCategoria",$datos["idCategoria"],PDO::PARAM_INT);
		$stmt->bindParam(":categoria",$datos["categoria"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para eliminar una nueva Categoría en la Base de Datos
	public function mdlEliminarCategoria($tabla,$datos){
		$sql="DELETE FROM $tabla WHERE id=:id";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":id",$datos,PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}
}