<?php
require_once 'conexion.php';

class ModeloVentas{
	// Método para Mostrar las ventas
	static public function mdlMostrarVentas($tabla,$item,$valor){
		if($item!=null){
			$sql="SELECT * FROM $tabla WHERE $item=:$item ORDER BY id ASC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->execute();
			# Retornamos un fetch por ser una sola línea la que necesitamos devolver
			return $stmt->fetch();}
		else{
			$sql="SELECT * FROM $tabla ORDER BY id ASC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();}
		$stmt=null;
	}

	// Método para actualizar un dato
	static public function mdlActualizarUnDato($tabla,$item1,$valor1,$item2,$valor2,$tipoConsulta){
		if($tipoConsulta=="sencilla"){
			$sql="UPDATE $tabla SET $item1=$valor1 WHERE $item2=$valor2";
			$stmt=Conexion::conectar()->prepare($sql);}
		else{
			$sql="UPDATE $tabla SET $item1=:$item1 WHERE id=:id";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item1,$valor1,PDO::PARAM_STR);
			$stmt->bindParam(":id",$valor2,PDO::PARAM_INT);}
		$stmt->execute();
		$stmt=null;
	}

	// Método para guardar las ventas
	static public function mdlGuardarVentas($tabla,$datos){
		$sql="INSERT INTO $tabla(factura,id_cliente,id_vendedor,productos,subtotalventa,sumaiva,total,metodo_1,pago_1,num_recibo,pago_recibo,metodo_3,pago_3,estado) VALUES (:factura,:id_cliente,:id_vendedor,:productos,:subtotalventa,:sumaiva,:total,:metodo_1,:pago_1,:num_recibo,:pago_recibo,:metodo_3,:pago_3,:estado)";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":factura",$datos["factura"],PDO::PARAM_STR);
		$stmt->bindParam(":id_cliente",$datos["id_cliente"],PDO::PARAM_INT);
		$stmt->bindParam(":id_vendedor",$datos["id_vendedor"],PDO::PARAM_INT);
		$stmt->bindParam(":productos",$datos["productos"],PDO::PARAM_STR);
		$stmt->bindParam(":subtotalventa",$datos["subtotalventa"],PDO::PARAM_STR);
		$stmt->bindParam(":sumaiva",$datos["sumaiva"],PDO::PARAM_STR);
		$stmt->bindParam(":total",$datos["total"],PDO::PARAM_STR);
		$stmt->bindParam(":metodo_1",$datos["metodo_1"],PDO::PARAM_STR);
		$stmt->bindParam(":pago_1",$datos["pago_1"],PDO::PARAM_STR);
		$stmt->bindParam(":num_recibo",$datos["num_recibo"],PDO::PARAM_INT);
		$stmt->bindParam(":pago_recibo",$datos["pago_recibo"],PDO::PARAM_STR);
		$stmt->bindParam(":metodo_3",$datos["metodo_3"],PDO::PARAM_STR);
		$stmt->bindParam(":pago_3",$datos["pago_3"],PDO::PARAM_STR);
		$stmt->bindParam(":estado",$datos["estado"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para anular una venta
	static public function mdlAnularVenta($tabla,$idVenta,$estado){
		$sql="UPDATE $tabla SET estado=:estado WHERE id=:id";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":id",$idVenta,PDO::PARAM_INT);
		$stmt->bindParam(":estado",$estado,PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para mostrar el Rango de Fechas de Ventas
	static public function mdlRangoFechasVentas($tabla,$fechaInicial,$fechaFinal,$estado){
		if($fechaInicial=="null"){
			$sql="SELECT * FROM $tabla WHERE estado=:estado ORDER BY id ASC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":estado",$estado,PDO::PARAM_STR);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();}
		else if($fechaInicial==$fechaFinal){
			$sql="SELECT * FROM $tabla WHERE estado=:estado AND fecha like '%$fechaInicial%'";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":estado",$estado,PDO::PARAM_STR);
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
			$sql="SELECT * FROM $tabla WHERE estado=:estado AND fecha BETWEEN '$fechaInicial' AND '$fechaFinalmasUno'";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":estado",$estado,PDO::PARAM_STR);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();
		}
		$stmt=null;
	}

	// Método para mostrar la suma total de un requerimiento
	static public function mdlSumaTotalRequerimiento($tabla,$accion,$item,$columna,$valor){
		if($columna==null){
			$sql="SELECT $accion($item) FROM $tabla";}
		else{
			$sql="SELECT $accion($item) FROM $tabla WHERE $columna=$valor";}
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->execute();
		return $stmt->fetch();
		$stmt=null;
	}

	// Método para Mostrar la última venta ingresada
	static public function mdlMostrarUltimaVenta($tabla,$idCliente,$idVendedor,$estado){
		$sql="SELECT * FROM $tabla WHERE id_cliente=:idCliente AND id_vendedor=:idVendedor AND estado=:estado ORDER BY fecha DESC";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":idCliente",$idCliente,PDO::PARAM_INT);
		$stmt->bindParam(":idVendedor",$idVendedor,PDO::PARAM_INT);
		$stmt->bindParam(":estado",$estado,PDO::PARAM_STR);
		$stmt->execute();
		return $stmt->fetchAll();
		$stmt=null;
	}

	// Método para mostrar los detalles de recibos desde la Venta
	static public function mdlTraerDetalleRecibosVentas($tabla,$item,$valor){
		$sql="SELECT * FROM $tabla WHERE $item=:$item";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":".$item,$valor,PDO::PARAM_INT);
		$stmt->execute();
		# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
		return $stmt->fetchAll();
		$stmt=null;
	}

	// Método para actualizar fechas de los detalles del Recibo
	static public function mdlActualizarFechaDetalleR($tabla,$fecha,$num_recibo,$id){
		$sql="UPDATE $tabla SET fecha=:fecha WHERE num_recibo=:num_recibo AND id=:id";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":num_recibo",$num_recibo,PDO::PARAM_INT);
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		$stmt->bindParam(":fecha",$fecha,PDO::PARAM_STR);
		$stmt->execute();
		$stmt=null;
	}

	// Método para mostrar de mayor a menor la suma de totales de ventas con un limite de datos
	static public function mdlSumasTotalesVentas($tabla,$limite){
		$sql="SELECT id_cliente, SUM(total) AS suma FROM $tabla GROUP BY id_cliente ORDER BY suma DESC LIMIT $limite";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->execute();
		# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
		return $stmt->fetchAll();
		$stmt=null;
	}

	// Método para pedir la suma de valores en Efectivo por fecha
	static public function mdlSumaEfectivo($tabla,$fecha){
		$sql="SELECT SUM(pago_1) FROM $tabla WHERE metodo_1='Efectivo' AND fecha like '%$fecha%'";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->execute();
		# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
		return $stmt->fetch();
		$stmt=null;
	}
}