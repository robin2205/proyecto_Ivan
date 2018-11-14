<?php
	# Treamos la información de los clientes que tienen compras
	$clientes=ControladorClientes::ctrMostrarClientesConCompras();
	if(count($clientes)>=10){
		$limite=10;}
	else{
		$limite=count($clientes);}
	$ventas=ControladorVentas::crtSumasTotalesVentas($limite);
	for($i=0;$i<count($ventas);$i++){
		$infoClientes=ControladorClientes::ctrMostrarCliente("id",$ventas[$i]["id_cliente"]);
		$ventas[$i]["id_cliente"]=$infoClientes["nombre"];}
	# Verificamos que el array si tenga datos
	if(count($ventas)>0){
		echo '<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Clientes <small style="color:red;">(Estos son los '.$limite.' clientes con mayores compras)</small></h3>
				</div>
				<div class="box-body">
					<div class="chart-responsive">
						<div class="chart" id="bar-chart2" style="height:300px;"></div>
					</div>
				</div>
			</div>

			<script>
				var bar=new Morris.Bar({
					element:"bar-chart2",
					resize:true,
					data:[';
					for($i=0;$i<count($ventas);$i++){
						echo "{y:'".$ventas[$i]["id_cliente"]."',a:".$ventas[$i]["suma"]."},";}
					echo '],
					barColors:["#f56954"],
					xkey:"y",
					ykeys:["a"],
					labels:["Compras"],
					preUnits:"$ ",
					hideHover:"auto"
				});
				</script>';}
?>
