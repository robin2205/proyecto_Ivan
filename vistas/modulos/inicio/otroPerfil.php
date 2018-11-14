<!-- Mensaje de Bienvenida -->
<div class="col-xs-12">
    <h1>Bienvenid@ <?=$_SESSION["nombre"];?></h1>
</div>
<!-- Ventas -->
<div class="col-sm-6 col-xs-12">
    <div class="small-box bg-aqua">
        <div class="inner">
        <?php
            $tabla="ventas";
            $accion="SUM";
            $item="neto";
            $columna="id_vendedor";
            $valor=$_SESSION["id"];
            $respuesta=ControladorPlantilla::crtSumaTotalRequerimiento($tabla,$accion,$item,$columna,$valor);
            echo '<h3>'.number_format($respuesta[0],0).'</h3>';?>
            <p>Mis Ventas</p>
        </div>
        <div class="icon">
            <i class="ion ion-social-usd"></i>
        </div>
        <a href="ventas" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- Clientes -->
<div class="col-sm-6 col-xs-12">
    <div class="small-box bg-lime">
        <div class="inner">
        <?php
            $tabla="ventas";
            $accion="COUNT";
            $item="DISTINCT id_cliente";
            $columna="id_vendedor";
            $valor=$_SESSION["id"];
            $respuesta=ControladorPlantilla::crtSumaTotalRequerimiento($tabla,$accion,$item,$columna,$valor);
            echo '<h3>'.$respuesta[0].'</h3>';?>
            <p>Mis Clientes</p>
        </div>
        <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <a href="clientes" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>