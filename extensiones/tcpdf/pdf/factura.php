<?php
# Reqerimos los controladores y modelos
require_once '../../../controladores/ventas.controlador.php';
require_once '../../../modelos/ventas.modelo.php';
require_once '../../../controladores/clientes.controlador.php';
require_once '../../../modelos/clientes.modelo.php';
require_once '../../../controladores/usuarios.controlador.php';
require_once '../../../modelos/usuarios.modelo.php';
require_once '../../../controladores/productos.controlador.php';
require_once '../../../modelos/productos.modelo.php';

# Recibimos la variable GET
class imprimirFactura{
public $factura;
public function traerImpresionFactura(){
# Traemos la información de la venta
$item="factura";
$valor=$this->factura;
$infoVenta=ControladorVentas::ctrMostrarVentas($item,$valor);
# Almacenamos la información de la venta en variables
$fecha=substr($infoVenta["fecha"],0,-8);
$productos=json_decode($infoVenta["productos"],true);
$subtotalventa=number_format($infoVenta["subtotalventa"],0);
$sumaiva=number_format($infoVenta["sumaiva"],0);
$total=number_format($infoVenta["total"],0);
$sumaCantidad=0;

# Traemos la información del Cliente
$itemCliente="id";
$valorCliente=$infoVenta["id_cliente"];
$infoCliente=ControladorClientes::ctrMostrarCliente($itemCliente,$valorCliente);

# Traemos la información del Vendedor
$itemVendedor="id";
$valorVendedor=$infoVenta["id_vendedor"];
$infoVendedor=ControladorUsuarios::ctrMostrarUsuarios($itemVendedor,$valorVendedor);

# Requerimos el tcpdf para trabajar la impresión
require_once 'tcpdf_include.php';

# Creamos un nuevo documento PDF
$pdf=new TCPDF(PDF_PAGE_ORIENTATION,PDF_UNIT,PDF_PAGE_FORMAT,true,'UTF-8',false);

# Iniciamos la opción de tener varias páginas dentro del PDF
$pdf->startPageGroup();
# Eliminamos el encabezado y el pie de página
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
# Adicionamos una nueva página
$pdf->AddPage();
# ****************************** BLOQUE 1 MAQUETACIÓN INFORMACIÓN DE LA EMPRESA ******************************
$bloque1=<<<EOF
	<table>
		<tr>
			<td style="width:150px"><img src="images/logo-negro-bloque.png"></td>
			<td style="background-color:white; width:140px">
				<div style="font-size:8.5px;text-align:right;line-height:15px">
					<br>
					<b>NIT</b>: 1017.137.664
					<br>
					<b>Dirección</b>: Calle siempre Viva.
				</div>
			</td>
			<td style="background-color:white; width:140px">
				<div style="font-size:8.5px;text-align:right;line-height:15px">
					<br>
					<b>Contacto</b>: (300) 00 00 00
					<br>
					<b>Correo</b>: abc@hotmail.com
				</div>
			</td>
			<td style="background-color:white; width:110px; text-align:center; color:red">
				<br><br><b>FACTURA N°<br>$valor</b>
			</td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 1 creado en el PDF
$pdf->writeHTML($bloque1,false,false,false,false,'');

# ****************************** BLOQUE 2 MAQUETACIÓN INFORMACIÓN DEL CLIENTE Y VENDEDOR ******************************
$bloque2=<<<EOF
	<table>
		<tr><td></td></tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;">
		<tr>
			<td style="width:360px">
				Cliente: <b>$infoCliente[nombre]</b>
			</td>
			<td style="width:180px">
				Fecha: <b>$fecha</b>
			</td>
		</tr>
		<tr>
			<td style="width:180px">
				Documento: <b>$infoCliente[documento]</b>
			</td>
			<td style="width:180px">
				Email: <b>$infoCliente[email]</b>
			</td>
			<td style="width:180px">
				Contacto: <b>$infoCliente[contacto]</b>
			</td>
		</tr>
		<tr>
			<td style="width:540px">
				Vendedor: <b>$infoVendedor[nombre]</b>
			</td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 2 creado en el PDF
$pdf->writeHTML($bloque2,false,false,false,false,'');

# ****************************** BLOQUE 3 MAQUETACIÓN CABECERA DE PRODUCTOS ******************************
$bloque3=<<<EOF
	<table>
		<tr><td></td></tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;">
		<tr style="background-color:#D9D9D9">
			<td style="width:260px;text-align:left"><b>Producto</b></td>
			<td style="width:80px;text-align:center"><b>Cantidad</b></td>
			<td style="width:100px;text-align:left"><b>Valor Unit.</b></td>
			<td style="width:100px;text-align:left"><b>Valor Total</b></td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 3 creado en el PDF
$pdf->writeHTML($bloque3,false,false,false,false,'');

# ****************************** BLOQUE 4 MAQUETACIÓN LISTADO DE PRODUCTOS ******************************
# Con un foreach hacemos la impresión de los productos que fueron vendidos
foreach($productos as $key=>$itemP){
# Hallamos el conteo de Productos comprados
$sumaCantidad=$sumaCantidad+$itemP["cantidad"];
$precio=number_format($itemP["precio"],0);
$totalProducto=number_format($itemP["total"],0);
$bloque4=<<<EOF
	<table style="font-size:10px;padding:5px 10px;">
		<tr>
			<td style="width:260px;text-align:left;">$itemP[descripcion]</td>
			<td style="width:80px;text-align:center">$itemP[cantidad]</td>
			<td style="width:100px;text-align:left">$ $precio</td>
			<td style="width:100px;text-align:left">$ $totalProducto</td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 4 creado en el PDF
$pdf->writeHTML($bloque4,false,false,false,false,'');
}

# ****************************** BLOQUE 5 MAQUETACIÓN RESUMEN DE PAGOS ******************************
$bloque5=<<<EOF
	<table>
		<tr><td></td></tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;">
		<tr>
			<td style="width:240px"></td>
			<td style="width:150px;text-align:right;background-color:#D9D9D9"><b>Items Comprados:</b></td>
			<td style="width:150px;text-align:left;background-color:#D9D9D9"><b>$sumaCantidad</b></td>
		</tr>
		<tr>
			<td style="width:240px"></td>
			<td style="width:150px;text-align:right;background-color:#D9D9D9"><b>SubTotal:</b></td>
			<td style="width:150px;text-align:left;background-color:#D9D9D9"><b>$ $subtotalventa</b></td>
		</tr>
		<tr>
			<td style="width:240px"></td>
			<td style="width:150px;text-align:right;background-color:#D9D9D9"><b>IVA:</b></td>
			<td style="width:150px;text-align:left;background-color:#D9D9D9"><b>$ $sumaiva</b></td>
		</tr>
		<tr>
			<td style="width:240px"></td>
			<td style="width:150px;text-align:right;background-color:#D9D9D9"><b>Total a Pagar:</b></td>
			<td style="width:150px;text-align:left;background-color:#D9D9D9"><b>$ $total</b></td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 5 creado en el PDF
$pdf->writeHTML($bloque5,false,false,false,false,'');

/* SALIDA DEL ARCHIVO VISTA PREVIA EN NAVEGADOR*/
$pdf->Output('factura'.$valor.'.pdf');
}
}

// OBJETOS INSTANCIADOS
$a=new imprimirFactura();
$a->factura=$_GET["factura"];
$a->traerImpresionFactura();
?>