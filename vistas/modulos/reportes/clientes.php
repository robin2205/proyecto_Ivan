<?php
	# Treamos la información de las ventas
	$item=null;
	$valor=null;
	$ventas=ControladorVentas::ctrMostrarVentas($item,$valor);
	# Treamos la información de los clientes
	$clientes=ControladorClientes::ctrMostrarCliente($item,$valor);
	$arrayClientes=array();
	$arrayListaClientes=array();
	# Recorremos la ventas
	foreach($ventas as $key=>$valueVentas){
		# Recorremos los clientes
		foreach($clientes as $key=>$valueClientes){
			# Comparamos si los clientes son iguales a los id_clientes de las Ventas
			if($valueClientes["id"]==$valueVentas["id_cliente"]){
				# Capturamos los Clientes en un array
				array_push($arrayClientes,$valueClientes["nombre"]);
				# Capturamos los nombres y valores netos de los Clientes en un mismo array
				$arrayListaClientes=array($valueClientes["nombre"]=>$valueVentas["total"]);
				# Sumamos los totales de cada Cliente
				foreach($arrayListaClientes as $key=>$value){
					$sumaTotalesClientes[$key]+=$value;}
			}
		}
	}
	# Evitamos repetir nombres
	$noRepetirNombres=array_unique($arrayClientes);
	# Verificamos que el array si tenga datos
	if(count($noRepetirNombres)>0){
		echo '<div class="box box-danger">
				<div class="box-header with-border">
					<h3 class="box-title">Clientes</h3>
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
					foreach($noRepetirNombres as $value){
						echo "{y:'".$value."',a:".$sumaTotalesClientes[$value]."},";}
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

<!-- =========================== GRÁFICO DE VENDEDORES =========================== -->

<!-- Creamos el script necesario para poder mostrar los datos en la gráfica -->
