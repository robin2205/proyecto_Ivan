<?php
# Reqerimos los controladores y modelos
require_once '../../../controladores/cierre-caja.controlador.php';
require_once '../../../modelos/cierre-caja.modelo.php';
require_once '../../../controladores/clientes.controlador.php';
require_once '../../../modelos/clientes.modelo.php';

# Recibimos la variable GET
class imprimirCierre{
public $fecha;
public function traerImpresionRecibo(){
$fechaCierre=$this->fecha;
# Traemos la información del cierre según fecha
$recibos=ControladorCierreCaja::ctrMostrarDatosX("recibos",$fechaCierre);
$ventas=ControladorCierreCaja::ctrMostrarDatosX("ventas",$fechaCierre);
$egresos=ControladorCierreCaja::ctrMostrarDatosX("egresos",$fechaCierre);
$texto=null;
$acuFacturas=0;
$acuRecibos=0;
$acuEgresos=0;
$efectivo=0;
$tarjeta=0;
$cheque=0;
# Imprimir Recibos
if(count($recibos)>0){
    $texto.="RECIBOS:<br>";
    foreach($recibos as $key=>$value){
        $cliente=ControladorClientes::ctrMostrarCliente("id",$value["id_cliente"]);
        $detalle=ControladorCierreCaja::ctrTraerDR("num_recibo",$value["id"]);
        $texto.="N°".$value["id"]." ";
        $texto.="Cliente: ".$cliente["nombre"].". ";
        $texto.="Valor: $ ".number_format($detalle[0]["pago"],0).". ";
        $texto.="(Por/Para) ".$value["observaciones"]."<br>";
        $acuRecibos+=$detalle[0]["pago"];
        if($detalle[0]["metodo_pago"]=="Efectivo"){
            $efectivo+=$detalle[0]["pago"];}
        else if(substr($detalle[0]["metodo_pago"],0,1)=="T"){
            $tarjeta+=$detalle[0]["pago"];}
        else if(substr($detalle[0]["metodo_pago"],0,1)=="C"){
            $cheque+=$detalle[0]["pago"];}
    }
}
# Imprimir Egresos
if(count($egresos)>0){
    $texto.="<br>EGRESOS:<br>";
    foreach($egresos as $key=>$value){
        $cliente=ControladorClientes::ctrMostrarCliente("id",$value["id_cliente"]);
        $texto.="N°".$value["id"]." ";
        $texto.="Cliente: ".$cliente["nombre"].". ";
        $texto.="Valor: $ ".number_format($value["valor"],0).". ";
        $texto.="(Por/Para) ".$value["observaciones"]."<br>";
        $acuEgresos+=$value["valor"];
    }
}
# Imprimir Facturas
if(count($ventas)>0){
    $texto.="<br>FACTURAS:<br>";
    foreach($ventas as $key=>$value){
        $cliente=ControladorClientes::ctrMostrarCliente("id",$value["id_cliente"]);
        $texto.="FAC N°".$value["id"]." ";
        $texto.="Cliente: ".$cliente["nombre"].". ";
        $texto.="Valor: $ ".number_format($value["total"],0)."<br>";
        $acuFacturas+=$value["total"];
        if($value["metodo_1"]=="Efectivo"){
            $efectivo+=$value["pago_1"];}
        else if(substr($value["metodo_1"],0,1)=="T"){
            $tarjeta+=$value["pago_1"];}
        else if(substr($value["metodo_1"],0,1)=="C"){
            $cheque+=$value["pago_1"];}
        if(substr($value["metodo_3"],0,1)=="T"){
            $tarjeta+=$value["pago_3"];}
        else if(substr($value["metodo_3"],0,1)=="C"){
            $cheque+=$value["pago_3"];}
    }
}
$efectivo-=$acuEgresos; # Hallamos la resta de los pagos en Efectivo (Recibos y Facturas) menos los egresos entregados

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
				<br><br><b>FECHA CIERRE <br>$fechaCierre</b>
			</td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 1 creado en el PDF
$pdf->writeHTML($bloque1,false,false,false,false,'');

# ****************************** BLOQUE 2 MAQUETACIÓN INFORMACIÓN DE LAS ACTIVIDADES DEL CIERRE ******************************
$bloque2=<<<EOF
	<table>
		<tr><td></td></tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;">
		<tr style="background-color:#D9D9D9">
			<td style="width:540px;text-align:center"><b>Actividades</b></td>
		</tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;">
		<tr>
			<td style="width:540px;text-align:left;">$texto</td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 2 creado en el PDF
$pdf->writeHTML($bloque2,false,false,false,false,'');

# ****************************** BLOQUE 3 MAQUETACIÓN CABECERA DE DATOS ******************************
$bloque3=<<<EOF
	<table>
		<tr><td></td></tr>
	</table>
	<table style="font-size:10px;padding:5px 10px;">
		<tr style="background-color:#D9D9D9">
			<td style="width:110px;text-align:left"><b>Efectivo en caja</b></td>
			<td style="width:85px;text-align:center"><b>Egreso</b></td>
			<td style="width:85px;text-align:left"><b>Ingreso</b></td>
			<td style="width:90px;text-align:left"><b>Facturas</b></td>
			<td style="width:90px;text-align:left"><b>Tarjetas</b></td>
			<td style="width:80px;text-align:left"><b>Cheques</b></td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 3 creado en el PDF
$pdf->writeHTML($bloque3,false,false,false,false,'');

# ****************************** BLOQUE 4 MAQUETACIÓN DE DATOS ******************************
$efectivo=number_format($efectivo,0);
$acuEgresos=number_format($acuEgresos,0);
$acuRecibos=number_format($acuRecibos,0);
$acuFacturas=number_format($acuFacturas,0);
$tarjeta=number_format($tarjeta,0);
$cheque=number_format($cheque,0);
$bloque4=<<<EOF
	<table style="font-size:10px;padding:5px 10px;">
		<tr>
			<td style="width:110px;text-align:left"><b>$ $efectivo</b></td>
			<td style="width:85px;text-align:center"><b>$ $acuEgresos</b></td>
			<td style="width:85px;text-align:left"><b>$ $acuRecibos</b></td>
			<td style="width:90px;text-align:left"><b>$ $acuFacturas</b></td>
			<td style="width:90px;text-align:left"><b>$ $tarjeta</b></td>
			<td style="width:80px;text-align:left"><b>$ $cheque</b></td>
		</tr>
	</table>
EOF;
# Pintamos el bloque 4 creado en el PDF
$pdf->writeHTML($bloque4,false,false,false,false,'');

/* SALIDA DEL ARCHIVO VISTA PREVIA EN NAVEGADOR*/
$pdf->Output('cierre.pdf');
}
}

// OBJETOS INSTANCIADOS
$a=new imprimirCierre();
$a->fecha=$_GET["fecha"];
$a->traerImpresionRecibo();
?>