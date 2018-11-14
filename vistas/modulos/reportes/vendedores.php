<?php
	# Treamos la información de las ventas
	$item=null;
	$valor=null;
	$ventas=ControladorVentas::ctrMostrarVentas($item,$valor);
	# Treamos la información de los usuarios
	$usuarios=ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
	$arrayVendedores=array();
	$arrayListaVendedores=array();
	# Recorremos la ventas
	foreach($ventas as $key=>$valueVentas){
		# Recorremos los usuarios
		foreach($usuarios as $key=>$valueUsuarios){
			# Comparamos si los usuarios son iguales a los vendedores
			if($valueUsuarios["id"]==$valueVentas["id_vendedor"]){
				# Capturamos los vendedores en un array
				array_push($arrayVendedores,$valueUsuarios["nombre"]);
				# Capturamos los nombres y valores netos de los vendedores en un mismo array
				$arrayListaVendedores=array($valueUsuarios["nombre"]=>$valueVentas["neto"]);
				# Sumamos los netos de cada Vendedor
				foreach($arrayListaVendedores as $key=>$value){
					$sumaNetosVendedores[$key]+=$value;}
			}
		}
	}
	# Evitamos repetir nombres
	$noRepetirNombres=array_unique($arrayVendedores);
	# Verificamos que el array si tenga datos
	if(count($noRepetirNombres)>0){
		echo '<div class="box box-info">
				<div class="box-header with-border">
					<h3 class="box-title">Vendedores</h3>
				</div>
				<div class="box-body">
					<div class="chart-responsive">
						<div class="chart" id="bar-chart1" style="height:300px;"></div>
					</div>
				</div>
			</div>

			<script>
				var bar=new Morris.Bar({
					element:"bar-chart1",
					resize:true,
					data:[';
					foreach($noRepetirNombres as $value){
						echo "{y:'".$value."',a:".$sumaNetosVendedores[$value]."},";}
				echo'],
					barColors:["#00a65a"],
					xkey:"y",
					ykeys:["a"],
					labels:["Ventas"],
					preUnits:"$ ",
					hideHover:"auto"
				});
			</script>';}
?>
<!-- Creamos el script necesario para poder mostrar los datos en la gráfica -->
