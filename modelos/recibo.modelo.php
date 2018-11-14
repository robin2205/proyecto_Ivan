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
	static public function mdlTraerDetalleRecibos($tabla,$item,$valor){
		if($item!=null){
			$sql="SELECT * FROM $tabla WHERE $item=:$item AND estado=0";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_INT);}
		else{
			$sql="SELECT * FROM $tabla WHERE estado=0";
			$stmt=Conexion::conectar()->prepare($sql);}
		$stmt->execute();
		# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
		return $stmt->fetchAll();
		$stmt=null;
	}

	// Método para Crear un nuevo Recibo
	static public function mdlCrearRecibo($tabla,$datos){
		$sql="INSERT INTO $tabla(num_recibo,id_usuario,id_cliente,observaciones) VALUES (:num_recibo,:id_usuario,:id_cliente,:observaciones)";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":num_recibo",$datos["num_recibo"],PDO::PARAM_INT);
		$stmt->bindParam(":id_usuario",$datos["id_usuario"],PDO::PARAM_INT);
		$stmt->bindParam(":id_cliente",$datos["id_cliente"],PDO::PARAM_INT);
		$stmt->bindParam(":observaciones",$datos["observaciones"],PDO::PARAM_STR);
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

	// Método para realizar la actualización de una Observación
	static public function mdlEditarOb($tabla,$datos){
		$sql="UPDATE $tabla SET observaciones=:observaciones WHERE num_recibo=:num_recibo";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":observaciones",$datos["observaciones"],PDO::PARAM_STR);
		$stmt->bindParam(":num_recibo",$datos["num_recibo"],PDO::PARAM_INT);
		$stmt->execute();
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

	// Este método nos ayuda a traer la suma de pagos realizados por Recibo
	static public function mdlPagoAcumulado($tabla,$numRecibo){
		$sql="SELECT SUM(pago) FROM $tabla WHERE num_recibo=:num_recibo AND estado=0";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":num_recibo",$numRecibo,PDO::PARAM_INT);
		$stmt->execute();
		# Retornamos un fetch por ser una sola línea la que necesitamos devolver
		return $stmt->fetch();
		$stmt=null;
	}

	// Método para Mostrar el último Recibo ingresado
	static public function mdlMostrarUltimoRecibo($tabla,$idCliente,$idUsuario){
		$sql="SELECT * FROM $tabla WHERE id_cliente=:idCliente AND id_usuario=:idUsuario ORDER BY fecha DESC";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":idCliente",$idCliente,PDO::PARAM_INT);
		$stmt->bindParam(":idUsuario",$idUsuario,PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt=null;
	}

	// Este método nos ayuda a traer la suma del Efectivo que se ha ingresado por fecha
	static public function mdlSumaEfectivo($tabla,$metodo,$fecha){
		$sql="SELECT SUM(pago) FROM $tabla WHERE metodo_pago=:metodo_pago AND fecha like '%$fecha%'";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":metodo_pago",$metodo,PDO::PARAM_STR);
		$stmt->execute();
		# Retornamos un fetch por ser una sola línea la que necesitamos devolver
		return $stmt->fetch();
		$stmt=null;
	}
}