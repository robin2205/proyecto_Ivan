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

<!-- MODAL PARA VER DETALLES DE VENTA -->
<div id="modalVerDetallesVenta" class="modal fade modales" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" class="form-DetallePagosVenta">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-eye"></i> Detalles Formas de Pagos
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="row">
                            <!-- Factura -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control" id="detaFactura" readonly>
                                </div>
                            </div>
                            <!-- Cliente -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="detaCliente" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Vendedor -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-address-card"></i></span>
                                    <input type="text" class="form-control" id="detaUsuario" readonly>
                                </div>
                            </div>
                            <!-- Total Venta -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control detaTotal" id="detaTotal" readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="row pago1"></div>
                        <div class="row pago2"></div>
                        <div class="row pago3"></div>
                    </div>
                </div>
                <div class="modal-footer" style="margin-top:-25px;">
                    <div class="row">
                        <div class="col-sm-6 col-xs-12 pc">
                            <h4>TOTAL PAGADO</h4>
                        </div>
                        <div class="col-sm-6 col-xs-12">
                            <div class="input-group" style="width:100%">
                                <span class="input-group-addon" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                <input type="text" class="form-control totalPagado" id="totalPagado" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>