<?php
	# Requerimos los controladores y modelos que vamos a necesitar
	require_once '../../controladores/ventas.controlador.php';
	require_once '../../modelos/ventas.modelo.php';
	require_once '../../controladores/clientes.controlador.php';
	require_once '../../modelos/clientes.modelo.php';
	require_once '../../controladores/usuarios.controlador.php';
	require_once '../../modelos/usuarios.modelo.php';

	# Realizamos el llamado al controlador del método ctrDescargarExcels
	$descargar=new ControladorVentas();
	$descargar->ctrDescargarExcel();
?>