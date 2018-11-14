<?php
// Requerimos la conexión a la base de datos
require_once 'conexion.php';

class ModeloRecibo{
	// Método para mostrar uno o todos los recibos
	static public function mdlTraerRecibos($tabla,$item,$valor,$item2,$valor2,$orden){
		if($item!=null && $item2==null){
			$sql="SELECT * FROM $tabla WHERE $item=:$item ORDER BY $orden DESC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_INT);
			$stmt->execute();
			# Retornamos un fetch por ser una sola línea la que necesitamos devolver
			return $stmt->fetch();}
		else if($item!=null && $item2!=null){
			$sql="SELECT * FROM $tabla WHERE $item=:$item AND $item2=:$item2 ORDER BY $orden DESC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_INT);
			$stmt->bindParam(":".$item2,$valor2,PDO::PARAM_INT);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();}
		else{
			$sql="SELECT * FROM $tabla ORDER BY $orden ASC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();
		}
		$stmt=null;
	}

	// Método para mostrar el Rango de Fechas de Recibos
	static public function mdlTraerRecibosRangoFechas($tabla,$fechaInicial,$fechaFinal){
		if($fechaInicial=="null"){
			$sql="SELECT * FROM $tabla";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();}
		else if($fechaInicial==$fechaFinal){
			$sql="SELECT * FROM $tabla WHERE fecha like '%$fechaInicial%'";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();
		}
		else{
			$fechaActual=new DateTime();
			$fechaActual->add(new DateInterval("P1D"));
			$fechaActualmasUno=$fechaActual->format("Y-m-d");

			$fechaFinal2=new DateTime($fechaFinal);
			$fechaFinal2->add(new DateInterval("P1D"));
			$fechaFinalmasUno=$fechaFinal2->format("Y-m-d");
			$sql="SELECT * FROM $tabla WHERE fecha BETWEEN '$fechaInicial' AND '$fechaFinalmasUno'";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();
		}
		$stmt=null;
	}

	// Método para mostrar uno o todos los detalles de recibos
	static public function mdlTrarDetalleRecibos($tabla,$item,$valor){
		if($item!=null){
			$sql="SELECT * FROM $tabla WHERE $item=:$item";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_INT);
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

	// Método para Crear un nuevo Recibo
	static public function mdlCrearRecibo($tabla,$datos){
		$sql="INSERT INTO $tabla(num_recibo,id_usuario,id_cliente,observaciones,array_datos,subtotal,suma_iva,total,adeuda) VALUES (:num_recibo,:id_usuario,:id_cliente,:observaciones,:array_datos,:subtotal,:suma_iva,:total,:adeuda)";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":num_recibo",$datos["num_recibo"],PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario",$datos["id_usuario"],PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente",$datos["id_cliente"],PDO::PARAM_INT);
		$stmt->bindParam(":observaciones",$datos["observaciones"],PDO::PARAM_STR);
		$stmt->bindParam(":array_datos",$datos["array_datos"],PDO::PARAM_STR);
		$stmt->bindParam(":subtotal",$datos["subtotal"],PDO::PARAM_STR);
		$stmt->bindParam(":suma_iva",$datos["suma_iva"],PDO::PARAM_STR);
		$stmt->bindParam(":total",$datos["total"],PDO::PARAM_STR);
		$stmt->bindParam(":adeuda",$datos["adeuda"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para Crear un nuevo detalle de Recibo
	static public function mdlCrearDetalleRecibo($tabla,$num_recibo,$pago,$metodo){
		$sql="INSERT INTO $tabla(num_recibo,pago,metodo_pago) VALUES (:num_recibo,:pago,:metodo_pago)";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":num_recibo",$num_recibo,PDO::PARAM_INT);
		$stmt->bindParam(":pago",$pago,PDO::PARAM_STR);
		$stmt->bindParam(":metodo_pago",$metodo,PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para eliminar un recibo de la BD
	static public function mdlEliminarRecibo($tabla,$numRecibo){
		$sql="DELETE FROM $tabla WHERE num_recibo=:num_recibo";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":num_recibo",$numRecibo,PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt->close();
		$stmt=null;
	}
}