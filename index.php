<?php
// Requerimos los Controladores
require_once 'controladores/plantilla.controlador.php';
require_once 'controladores/usuarios.controlador.php';
require_once 'controladores/categorias.controlador.php';
require_once 'controladores/productos.controlador.php';
require_once 'controladores/clientes.controlador.php';
require_once 'controladores/ventas.controlador.php';
require_once 'controladores/recibo.controlador.php';
require_once 'controladores/egreso.controlador.php';
require_once 'controladores/cierre-caja.controlador.php';

// Requerimos los Modelos
require_once 'modelos/usuarios.modelo.php';
require_once 'modelos/categorias.modelo.php';
require_once 'modelos/productos.modelo.php';
require_once 'modelos/clientes.modelo.php';
require_once 'modelos/ventas.modelo.php';
require_once 'modelos/recibo.modelo.php';
require_once 'modelos/egreso.modelo.php';
require_once 'modelos/cierre-caja.modelo.php';

$plantilla=new ControladorPlantilla();
$plantilla->ctrPlantilla();