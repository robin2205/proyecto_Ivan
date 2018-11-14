<?php
// Requerimos el archivo de Conexión
require_once 'conexion.php';

class ModeloProductos{
	// Método para traer los productos de la Base de Datos
	static public function mdlTraerProductos($tabla,$item,$valor,$orden){
		if($item!=null){
			$sql="SELECT * FROM $tabla WHERE $item=:$item ORDER BY $orden DESC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->bindParam(":".$item,$valor,PDO::PARAM_STR);
			$stmt->execute();
			# Retornamos un fetch por ser una sola línea la que necesitamos devolver
			return $stmt->fetch();}
		else{
			$sql="SELECT * FROM $tabla ORDER BY $orden DESC";
			$stmt=Conexion::conectar()->prepare($sql);
			$stmt->execute();
			# Retornamos un fetchAll por ser más de una línea la que necesitamos devolver
			return $stmt->fetchAll();
		}
		$stmt=null;
	}

	// Método para guardar un producto en la Base de Datos
	static public function mdlCrearProducto($tabla,$datos){
		$sql="INSERT INTO $tabla(id_categoria,codigo,descripcion,stock,precio_compra,iva,valor_Iva,precio_venta) VALUES (:id_categoria,:codigo,:descripcion,:stock,:precio_compra,:iva,:valor_Iva,:precio_venta)";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":id_categoria",$datos["id_categoria"],PDO::PARAM_INT);
		$stmt->bindParam(":codigo",$datos["codigo"],PDO::PARAM_STR);
		$stmt->bindParam(":descripcion",$datos["descripcion"],PDO::PARAM_STR);
		$stmt->bindParam(":stock",$datos["stock"],PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra",$datos["precio_compra"],PDO::PARAM_STR);
		$stmt->bindParam(":iva",$datos["iva"],PDO::PARAM_INT);
		$stmt->bindParam(":valor_Iva",$datos["valor_Iva"],PDO::PARAM_INT);
		$stmt->bindParam(":precio_venta",$datos["precio_venta"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para editar un producto en la Base de Datos
	static public function mdlEditarProducto($tabla,$datos){
		$sql="UPDATE $tabla SET descripcion=:descripcion,stock=:stock,precio_compra=:precio_compra,iva=:iva,valor_Iva=:valor_Iva,precio_venta=:precio_venta WHERE codigo=:codigo";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":codigo",$datos["codigo"],PDO::PARAM_STR);
		$stmt->bindParam(":descripcion",$datos["descripcion"],PDO::PARAM_STR);
		$stmt->bindParam(":stock",$datos["stock"],PDO::PARAM_STR);
		$stmt->bindParam(":precio_compra",$datos["precio_compra"],PDO::PARAM_STR);
		$stmt->bindParam(":iva",$datos["iva"],PDO::PARAM_INT);
		$stmt->bindParam(":valor_Iva",$datos["valor_Iva"],PDO::PARAM_INT);
		$stmt->bindParam(":precio_venta",$datos["precio_venta"],PDO::PARAM_STR);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para Eliminar un Producto
	static public function mdlEliminarProducto($tabla,$id){
		$sql="DELETE FROM $tabla WHERE id=:id";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->bindParam(":id",$id,PDO::PARAM_INT);
		if($stmt->execute()){
			return "ok";}
		else{
			return "error";}
		$stmt=null;
	}

	// Método para mostrar la suma de las Ventas
	static public function mdlMostrarSumaVentas($tabla){
		$sql="SELECT SUM(ventas) AS total FROM $tabla";
		$stmt=Conexion::conectar()->prepare($sql);
		$stmt->execute();
		return $stmt->fetch();
		$stmt=null;
	}
}