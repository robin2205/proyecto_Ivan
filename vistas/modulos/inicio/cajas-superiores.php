<!-- Ventas -->
<div class="col-lg-4 col-xs-12">
    <div class="small-box bg-aqua">
        <div class="inner">
        <?php
            $tabla="ventas";
            $accion="SUM";
            $item="neto";
            $respuesta=ControladorPlantilla::crtSumaTotalRequerimiento($tabla,$accion,$item,null,null);
            echo '<h3>'.number_format($respuesta[0],0).'</h3>';?>
            <p>Ventas (Neto)</p>
        </div>
        <div class="icon">
            <i class="ion ion-social-usd"></i>
        </div>
        <a href="ventas" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- Usuarios -->
<div class="col-lg-4 col-xs-12">
    <div class="small-box bg-yellow">
        <div class="inner">
        <?php
            $tabla="usuarios";
            $accion="COUNT";
            $item="usuario";
            $respuesta=ControladorPlantilla::crtSumaTotalRequerimiento($tabla,$accion,$item,null,null);
            echo '<h3>'.$respuesta[0].'</h3>';?>
            <p>Usuarios</p>
        </div>
        <div class="icon">
            <i class="ion ion-person-add"></i>
        </div>
        <a href="usuarios" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- Categorías -->
<div class="col-lg-4 col-xs-12">
    <div class="small-box bg-purple">
        <div class="inner">
        <?php
            $tabla="categorias";
            $accion="COUNT";
            $item="categoria";
            $respuesta=ControladorPlantilla::crtSumaTotalRequerimiento($tabla,$accion,$item,null,null);
            echo '<h3>'.$respuesta[0].'</h3>';?>
            <p>Categorías</p>
        </div>
        <div class="icon">
            <i class="ion ion-clipboard"></i>
        </div>
        <a href="categorias" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- Productos -->
<div class="col-lg-3 col-xs-12">
    <div class="small-box bg-red">
        <div class="inner">
        <?php
            $tabla="productos";
            $accion="COUNT";
            $item="descripcion";
            $respuesta=ControladorPlantilla::crtSumaTotalRequerimiento($tabla,$accion,$item,null,null);
            echo '<h3>'.$respuesta[0].'</h3>';?>
            <p>Productos</p>
        </div>
        <div class="icon">
            <i class="ion ion-ios-cart"></i>
        </div>
        <a href="productos" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- Clientes -->
<div class="col-lg-3 col-xs-12">
    <div class="small-box bg-lime">
        <div class="inner">
        <?php
            $tabla="clientes";
            $accion="COUNT";
            $item="nombre";
            $respuesta=ControladorPlantilla::crtSumaTotalRequerimiento($tabla,$accion,$item,null,null);
            echo '<h3>'.$respuesta[0].'</h3>';?>
            <p>Clientes</p>
        </div>
        <div class="icon">
            <i class="fa fa-users"></i>
        </div>
        <a href="clientes" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- Stock -->
<div class="col-lg-3 col-xs-12">
    <div class="small-box bg-blue">
        <div class="inner">
        <?php
            $tabla="productos";
            $accion="SUM";
            $item="stock";
            $respuesta=ControladorPlantilla::crtSumaTotalRequerimiento($tabla,$accion,$item,null,null);
            if($respuesta[0]!=null){
                echo '<h3>'.$respuesta[0].'</h3>';}
            else{
                echo '<h3>0</h3>';}?>
            <p>Inventario (Stock)</p>
        </div>
        <div class="icon">
            <i class="fa fa-book"></i>
        </div>
        <a href="productos" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>
<!-- Reportes -->
<div class="col-lg-3 col-xs-12">
    <div class="small-box bg-green">
        <div class="inner">
            <h3>Reportes</h3>
            <p>Gráficas</p>
        </div>
        <div class="icon">
            <i class="ion ion-stats-bars"></i>
        </div>
        <a href="reportes" class="small-box-footer">Más Información <i class="fa fa-arrow-circle-right"></i></a>
    </div>
</div>