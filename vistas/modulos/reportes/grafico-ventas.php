<?php
	/* Colocamos error_reporting(0); para evitar el error
	que nos muestra cuento utilizamos como indice una fecha */
	error_reporting(0);

	# Verificamos si la variable GET["fechaIncial"] tiene información
	if(isset($_GET["fechaInicial"])){
		$fechaInicial=$_GET["fechaInicial"];
		$fechaFinal=$_GET["fechaFinal"];}
	else{
		$fechaInicial=null;
		$fechaFinal=null;}
	# Traemos los datos de las ventas por Rango de Fechas
	$respuesta=ControladorVentas::ctrRangoFechasVentas($fechaInicial,$fechaFinal,"AC");
	$arrayFechas=array();
	$arrayVentas=array();
	$arraySumaPagoMes=array();
	foreach($respuesta as $key=>$value){
		# Capturamos solo el año y el mes de la Fecha
		$fecha=substr($value["fecha"],0,10);
		# Llenamos el array de las fechas con los datos
		array_push($arrayFechas,$fecha);
		# Capturamos los totales de las ventas dentro de un array donde los indices serán las fechas
		$arrayVentas=array($fecha=>$value["total"]);
		# Sumamos los totales que ocurrieron en el mismo mes
		foreach($arrayVentas as $key=>$value){
			$arraySumaPagoMes[$key]+=$value;}
	}
	/* Como el arrayFechas tiene más indices que el arraySumaPagoMes,
	debemos igualar los arrays, por tal utilizarmos la función de php
	array_unique, y estos datos los guardamos en un nuevo array*/
	$noRepetirFechas=array_unique($arrayFechas);
?>

<!-- =========================== GRÁFICO DE VENTAS =========================== -->
<div class="box box-solid bg-teal-gradient">
	<div class="box-header with-border">
		<i class="fa fa-th"></i>
		<h3 class="box-title">Reporte de Ventas</h3>
	</div>
	<div class="box-body border-radius-none nuevoGraficoVentas">
		<div class="chart" id="line-chart-ventas" style="height:250px;"></div>
	</div>
</div>
<!-- Creamos el script necesario para poder mostrar los datos en la gráfica -->
<script>
	var line=new Morris.Line({
    element:'line-chart-ventas',
    resize:true,
    data:[
    <?php
    	if($noRepetirFechas!=null){
	    	# Creamos un foreach para recorrer el array, y mostrar los datos
	    	foreach($noRepetirFechas as $key){
	    		echo "{y:'".$key."',ventas:".$arraySumaPagoMes[$key]."},";}
	    	# Mostramos el último dato son ,
	    	echo "{y:'".$key."',ventas:".$arraySumaPagoMes[$key]."}";}
	    else{
	    	echo "{y:'0',ventas:'0'}";}
    ?>
    ],
    xkey:'y',
    ykeys:['ventas'],
    labels:['Ventas'],
    lineColors:['#efefef'],
    lineWidth:2,
    hideHover:'auto',
    gridTextColor:'#fff',
    gridStrokeWidth:0.4,
    pointSize:4,
    pointStrokeColors:['#efefef'],
    gridLineColor:'#efefef',
    gridTextFamily:'Open Sans',
    preUnits:'$ ',
    gridTextSize:10
  });
</script>