<?php
if($_SESSION["perfil"]=="Vendedor"){
    echo '<script>
            window.location="inicio";
        </script>';
    return;}
if($_SESSION["perfil"]=="Especial"){
    echo '<script>
            window.location="categorias";
        </script>';
    return;}
?>
<div class="content-wrapper">
    <!-- Header del Contenido -->
    <section class="content-header">
        <h1>Gráficas</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Gráficas</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <div class="col-sm-6 col-xs-12">
                    <button type="button" class="btn btn-default" id="daterange-btn3">
                        <span><i class="fa fa-calendar"></i> Rango de Fechas </span>
                        <i class="fa fa-caret-down"></i>
                    </button>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="box-tools pull-right">
                    <?php
                        if(isset($_GET["fechaInicial"])){
                            echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte&fechaInicial='.$_GET["fechaInicial"].'&fechaFinal='.$_GET["fechaFinal"].'">';}
                        else{
                            echo '<a href="vistas/modulos/descargar-reporte.php?reporte=reporte">';}
                    ?>
                            <button class="btn btn-success btnReporteExcel"><i class="fa fa-file-excel-o"></i> Descargar Reporte en Excel</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                    <?php include 'reportes/grafico-ventas.php'; ?>
                    </div>
                    <div class="col-md-6 col-xs-12">
                    <?php include 'reportes/productos-mas-vendidos.php'; ?>
                    </div>
                    <div class="col-md-6 col-xs-12">
                    <?php include 'reportes/clientes.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>