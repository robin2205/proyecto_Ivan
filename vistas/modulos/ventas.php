<?php
if($_SESSION["perfil"]=="Especial"){
    echo '<script>
            window.location="categorias";
        </script>';
    return;}
?>
<div class="content-wrapper">
    <!-- Header del Contenido -->
    <section class="content-header">
        <h1>Administrar Ventas</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Administrar Ventas</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <a href="inicio">
                    <button class="btn btn-primary">
                        <i class="fa fa-plus-circle"></i> Agregar Venta
                    </button>
                </a>
                <button type="button" class="btn btn-default pull-right" id="daterange-btn">
                    <span><i class="fa fa-calendar"></i> Rango de Fechas </span>
                    <i class="fa fa-caret-down"></i>
                </button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed table-hover dt-responsive tablaVentas" width="100%">
                    <input type="hidden" value="<?=$_SESSION["perfil"];?>" id="perfilOculto">
                    <thead>
                        <tr class="info">
                            <th>Factura</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Registro de Pago</th>
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</div>