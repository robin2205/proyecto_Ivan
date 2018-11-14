<?php
// Requerimos la conexión a la base de datos
require_once 'conexion.php';

class ModeloCierreCaja{
	static public function mdlMostrarDatosX($tabla,$fecha){
		$sql="SELECT * FROM $tabla WHERE fecha like '%$fecha%'";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->execute();
		# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
		return $stmt->fetchAll();
		$stmt=null;
	}

	// Método para mostrar un detalle de recibo sin importar el estado
	static public function mdlTraerDR($tabla,$item,$valor){
		$sql="SELECT * FROM $tabla WHERE $item=:$item";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":".$item,$valor,PDO::PARAM_INT);
		$stmt->execute();
		# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
		return $stmt->fetchAll();
		$stmt=null;
	}

	// Método para mostrar uno o todos los cierres de caja
	static public function mdlMostrarCierres($tabla,$item,$valor){
		if($item!=null){
			$sql="SELECT * FROM $tabla WHERE $item=:$item ORDER BY fecha DESC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->execute();
			# Retornamos un fetch por ser una sola línea la que necesitamos devolver
			return $stmt->fetch();}
		else{
			$sql="SELECT * FROM $tabla ORDER BY fecha ASC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();
		}
		$stmt=null;
	}

	// Método que permite guardar la información del cierre contable
	static public function mdlGuardarCierre($tabla,$datos){
		$sql="INSERT INTO $tabla(id_usuario,fecha,efectivo,egreso,ingreso,facturas,tarjetas,cheques,dinero,arqueo,observaciones) VALUES (:id_usuario,:fecha,:efectivo,:egreso,:ingreso,:facturas,:tarjetas,:cheques,:dinero,:arqueo,:observaciones)";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":id_usuario",$datos["id_usuario"],PDO::PARAM_INT);
		$stmt->bindParam(":fecha",$datos["fecha"],PDO::PARAM_STR);
		$stmt->bindParam(":efectivo",$datos["efectivo"],PDO::PARAM_STR);
		$stmt->bindParam(":egreso",$datos["egreso"],PDO::PARAM_STR);
		$stmt->bindParam(":ingreso",$datos["ingreso"],PDO::PARAM_STR);
		$stmt->bindParam(":facturas",$datos["facturas"],PDO::PARAM_INT);
		$stmt->bindParam(":tarjetas",$datos["tarjetas"],PDO::PARAM_INT);
		$stmt->bindParam(":cheques",$datos["cheques"],PDO::PARAM_STR);
		$stmt->bindParam(":dinero",$datos["dinero"],PDO::PARAM_STR);
		$stmt->bindParam(":arqueo",$datos["arqueo"],PDO::PARAM_STR);
		$stmt->bindParam(":observaciones",$datos["observaciones"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}
}