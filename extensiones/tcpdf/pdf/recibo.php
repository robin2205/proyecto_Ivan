<?php
# Reqerimos los controladores y modelos
require_once '../../../controladores/recibo.controlador.php';
require_once '../../../modelos/recibo.modelo.php';
require_once '../../../controladores/clientes.controlador.php';
require_once '../../../modelos/clientes.modelo.php';
require_once '../../../controladores/usuarios.controlador.php';
require_once '../../../modelos/usuarios.modelo.php';

class imprimirRecibo{
public $recibo;
public function traerImpresionRecibo(){
# Traemos la información del Recibo
$valor=$this->recibo;
$infoRecibo=ControladorRecibo::ctrTraerRecibos("num_recibo",$valor,null,null,"num_recibo");
# Traemos los detalles de Pagos
$detalles=ControladorRecibo::ctrTrarDetalleRecibos("num_recibo",$valor);
# Almacenamos la información de la venta en variables
$fecha=substr($infoRecibo["fecha"],0,-8);
$acumulador=0;

# Traemos la información del Cliente
$itemCliente="id";
$valorCliente=$infoRecibo["id_cliente"];
$infoCliente=ControladorClientes::ctrMostrarCliente($itemCliente,$valorCliente);

# Traemos la información del Vendedor
$itemVendedor="id";
$valorVendedor=$infoRecibo["id_usuario"];
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
				<br><br><b>RECIBO N°<br>$valor</b>
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
			<td style="width:270px">
				Vendedor: <b>$infoVendedor[nombre]</b>
			</td>
			<td style="width:270px;text-align:right">
				Fecha: <b>$fecha</b>
			</td>
		</tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;">
		<tr>
			<td style="width:270px">
				Tipo Documento: <b>$infoCliente[tipo_Documento]</b>
			</td>
			<td style="width:135px">
				Documento: <b>$infoCliente[documento]</b>
			</td>
			<td style="width:135px;text-align:right">
				Tipo Cliente: <b>$infoCliente[tipo_Cliente]</b>
			</td>
		</tr>
		<tr>
			<td style="width:270px">
				Cliente: <b>$infoCliente[nombre]</b>
			</td>
			<td style="width:270px">
				Email: <b>$infoCliente[email]</b>
			</td>
		</tr>
		<tr>
			<td style="width:270px">
				Contacto: <b>$infoCliente[contacto]</b>
			</td>
			<td style="width:270px">
				Dirección: <b>$infoCliente[direccion]</b>
			</td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 2 creado en el PDF
$pdf->writeHTML($bloque2,false,false,false,false,'');

# ****************************** BLOQUE 3 MAQUETACIÓN CABECERA DE OBSERVACIONES ******************************
$bloque3=<<<EOF
	<table>
		<tr><td></td></tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;">
		<tr style="background-color:#D9D9D9">
			<td style="width:540px;text-align:center"><b>Observaciones</b></td>
		</tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;">
		<tr>
			<td style="width:540px;text-align:left;">$infoRecibo[observaciones]</td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 3 creado en el PDF
$pdf->writeHTML($bloque3,false,false,false,false,'');

# ****************************** BLOQUE 4 MAQUETACIÓN OBSERVACIONES DE LA BD ******************************
$bloque4=<<<EOF
	<table>
		<tr><td></td></tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;border-bottom:1px solid #fff">
		<tr style="background-color:#D9D9D9">
			<td style="width:540px;text-align:center"><b>Detalles de Pagos</b></td>
		</tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;">
		<tr style="background-color:#D9D9D9">
			<td style="width:270px;text-align:center;"><b>Fecha de Pago</b></td>
			<td style="width:270px;text-align:left;"><b>Pago</b></td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 4 creado en el PDF
$pdf->writeHTML($bloque4,false,false,false,false,'');

# ****************************** BLOQUE 5 MAQUETACIÓN DETALLES ******************************
foreach($detalles as $key=>$value){
if($value["pago"]!=0){
$acumulador+=$value["pago"];
$pago="$ ".number_format($value["pago"],0);
$fechaDetalle=substr($value["fecha"],0,-8);
$bloque5=<<<EOF
	<table style="font-size:10px;padding:5px 10px;">
		<tr>
			<td style="width:270px;text-align:center">$fechaDetalle</td>
			<td style="width:270px;text-align:left;">$pago</td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 4 creado en el PDF
$pdf->writeHTML($bloque5,false,false,false,false,'');
}}

# ****************************** BLOQUE 6 MAQUETACIÓN TOTALIZADO ******************************
$acumulador=number_format($acumulador,0);
$bloque6=<<<EOF
	<table style="font-size:10px;padding:5px 10px;">
		<tr style="background-color:#D9D9D9">
			<td style="width:270px;text-align:center;"><b>Total Acumulado</b></td>
			<td style="width:270px;text-align:left;"><b>$ $acumulador</b></td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 4 creado en el PDF
$pdf->writeHTML($bloque6,false,false,false,false,'');

/* SALIDA DEL ARCHIVO VISTA PREVIA EN NAVEGADOR*/
$pdf->Output('recibo'.$valor.'.pdf');
}
}

// OBJETOS INSTANCIADOS
$a=new imprimirRecibo();
$a->recibo=$_GET["recibo"];
$a->traerImpresionRecibo();
?>