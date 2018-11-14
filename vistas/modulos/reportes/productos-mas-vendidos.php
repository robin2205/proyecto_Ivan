<?php
	# Traemos todos los Productos
	$item=null;
	$valor=null;
	$orden="ventas";
	$productos=ControladorProductos::ctrTraerProductos($item,$valor,$orden);
	if(count($productos)>=7){
		$cantidadAMostrar=7;}
	else{
		$cantidadAMostrar=count($productos);}
	# Creamos un array de colores, para este caso 7, que son los productos máximos que mostraremos
	$arrayColores=array("#B0E0E6","#87CEEB","#1E90FF","#AFEEEE","#7FFF","#5F9EA0","#4682B4");
	# Obtenemos la suma de las ventas en productos
	$sumaVentas=ControladorProductos::ctrMostrarSumaVentas();
?>

<!-- =========================== GRÁFICO DE PRODUCTOS MÁS VENDIDOS =========================== -->
<div class="box box-warning">
	<div class="box-header with-border">
		<h3 class="box-title">Productos más Vendidos</h3>
	</div>
	<div class="box-body">
		<div class="row">
			<div class="col-md-7">
				<div class="chart-responsive">
					<canvas id="pieChart" height="150"></canvas>
				</div>
			</div>
			<div class="col-md-5">
				<ul class="chart-legend clearfix">
				<?php
					# Válidamos que si hayan sumas de ventas
					if($sumaVentas["total"]>0){
						# Creamos un ciclo para que muestre sólo 7 productos
						for($i=0;$i<$cantidadAMostrar;$i++){
							echo '<li>'.($i+1).'. '.$productos[$i]["descripcion"].'</li>';}
					}
				?>
				</ul>
			</div>
		</div>
	</div>
	<div class="box-footer no-padding">
		<ul class="nav nav-pills nav-stacked">
		<?php
			echo '<li>
					<a>
						<b>Productos (Los '.$cantidadAMostrar.' primeros)</b>
						<span class="pull-right"><b>% de Venta</b></span>
					</a>
				</li>';
			# Válidamos que si hayan sumas de ventas
			if($sumaVentas["total"]>0){
				# Creamos un ciclo para que muestre sólo los 7 o menos productos
				for($i=0;$i<$cantidadAMostrar;$i++){
					echo '<li>
							<a>
								'.$productos[$i]["descripcion"].'
								<span class="pull-right text-'.$arrayColores[$i].'"> '.ceil($productos[$i]["ventas"]*100/$sumaVentas["total"]).'%</span>
							</a>
						</li>';}
			}
		?>
		</ul>
	</div>
</div>
<!-- Creamos el script necesario para poder mostrar los datos en la gráfica -->
<script>
	// Obtenemos el context con jQuery - usando método .get()
	var pieChartCanvas=$('#pieChart').get(0).getContext('2d');
	var pieChart=new Chart(pieChartCanvas);
	var PieData=[
	<?php
		# Válidamos que si hayan sumas de ventas
		if($sumaVentas["total"]>0){
		  	for($i=0;$i<$cantidadAMostrar;$i++){
		  		echo "{
				     	value:".$productos[$i]["ventas"].",
				     	color:'".$arrayColores[$i]."',
				     	highlight:'#191970',
				     	label:'Und ".$productos[$i]["descripcion"]."'
				    },";}
	  	}
	?>
	];
	var pieOptions={
		// Separador de segmentos del gráfico
	    segmentShowStroke:true,
	    // Color de los bordes de cada segmento del gráfico
	    segmentStrokeColor:'#fff',
	    // Espacio de separación entre los segmentos del gráfico
	    segmentStrokeWidth:1,
	    // % de ancho de los segmentos del gráfico
	    percentageInnerCutout:45, // Esto es 0 por medida pie
	    // Velocidad de animación
	    animationSteps:100,
	    // Efecto de animación easing
	    animationEasing:'easeOutBounce',
	    // Aminación de rotación habilitada
	    animateRotate:true,
	    // Escala centrada de animación de rotación
	    animateScale:false,
	    // Gráfica responsiva
	    responsive:true,
	    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
	    maintainAspectRatio:true,
	    // Leyendas al pasar el mouse por los segmentos
	    legendTemplate:'<ul class=\'<%=name.toLowerCase()%>-legend\'><% for (var i=0; i<segments.length; i++){%><li><span style=\'background-color:<%=segments[i].fillColor%>\'></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>',
	    // Información extra en la leyenda
	    tooltipTemplate:'<%=value %> <%=label%>'
	};
	// Creamos el pie del Doughnut
	pieChart.Doughnut(PieData,pieOptions);
</script>