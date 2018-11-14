<?php
// Requerimos la conexión a la base de datos
require_once 'conexion.php';

class ModeloEgreso{
	// Método para mostrar uno o todos los egresos
	static public function mdlTraerEgresos($tabla,$item,$valor,$orden){
		if($item!=null){
			$sql="SELECT * FROM $tabla WHERE $item=:$item ORDER BY $orden DESC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_INT);
			$stmt->execute();
			# Retornamos un fetch por ser una sola línea la que necesitamos devolver
			return $stmt->fetch();}
		else{
			$sql="SELECT * FROM $tabla ORDER BY $orden ASC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();
		}
		$stmt=null;
	}

	// Método para traer la suma de los Egresos por fecha
	static public function mdlSumaEgresos($tabla,$fecha){
		$sql="SELECT SUM(valor) FROM $tabla WHERE fecha like '%$fecha%'";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->execute();
		# Retornamos un fetch por ser una sola línea la que necesitamos devolver
		return $stmt->fetch();
		$stmt=null;
	}

	// Método para Crear un Egreso
	static public function mdlCrearEgreso($tabla,$datos){
		$sql="INSERT INTO $tabla(id_usuario,id_cliente,observaciones,valor) VALUES (:id_usuario,:id_cliente,:observaciones,:valor)";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":id_usuario",$datos["id_usuario"],PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente",$datos["id_cliente"],PDO::PARAM_INT);
		$stmt->bindParam(":observaciones",$datos["observaciones"],PDO::PARAM_STR);
		$stmt->bindParam(":valor",$datos["valor"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para Mostrar el último Egreso ingresado
	static public function mdlMostrarUltimoEgreso($tabla,$idCliente,$idUsuario){
		$sql="SELECT * FROM $tabla WHERE id_cliente=:idCliente AND id_usuario=:idUsuario ORDER BY fecha DESC";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":idCliente",$idCliente,PDO::PARAM_INT);
		$stmt->bindParam(":idUsuario",$idUsuario,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt=null;
	}

	// Método para editar un Egreso en la BD
	static public function mdlEditarEgreso($tabla,$datos){
		$sql="UPDATE $tabla SET observaciones=:observaciones,valor=:valor,fecha=:fecha WHERE id=:id";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":id",$datos["id"],PDO::PARAM_INT);
		$stmt->bindParam(":observaciones",$datos["observaciones"],PDO::PARAM_STR);
		$stmt->bindParam(":valor",$datos["valor"],PDO::PARAM_STR);
		$stmt->bindParam(":fecha",$datos["fecha"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}
}