<div class="content-wrapper">
    <!-- Header del Contenido -->
    <section class="content-header">
        <h1>Administrar Recibos</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Administrar Recibos</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <a href="recibo">
                    <button class="btn btn-primary">
                        <i class="fa fa-plus-circle"></i> Agregar Recibo
                    </button>
                </a>
                <button type="button" class="btn btn-default pull-right" id="daterange-btn2">
                    <span><i class="fa fa-calendar"></i> Rango de Fechas </span>
                    <i class="fa fa-caret-down"></i>
                </button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed table-hover dt-responsive tablaRecibos" width="100%">
                    <thead>
                        <tr class="info">
                            <th>N° Recibo</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Pago Acumulado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA EDITAR UN INGRESO -->
<div id="modalEditarRecibo" class="modal fade modales" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form method="POST" class="form-EditarRecibo">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-pencil"></i> Editar Recibo
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group row">
                            <!-- Número de Recibo -->
                            <div class="col-sm-4 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                    <input type="text" class="form-control" name="editarNumRecibo" id="editarNumRecibo" readonly>
                                </div>
                            </div>
                            <!-- Cliente -->
                            <div class="col-sm-8 col-xs-12">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="editarClienteRecibo" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- Observaciones -->
                        <div class="form-group row">
                            <div class="col-xs-12">
                               <textarea class="form-control" name="editarObRecibo" id="editarObRecibo" onkeypress="return noEnter(event)" style="height:150px" required></textarea>
                            </div>
                        </div>
                        <!-- Detalles -->
                        <div class="form-group row detalles"></div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Actualizar</button>
                        </div>
                    </div>
                </div>
            <?php
                $editarRecibo=new ControladorRecibo();
                $editarRecibo->ctrEditarRecibo();
            ?>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA REGISTRAR PAGOS A UN RECIBO -->
<div id="modalPagosRecibo" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" method="POST" class="form-PagosRecibo">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-plus"></i> Registro de Pagos a Recibo
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Número de Recibo -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input type="text" class="form-control" name="pagoNumRecibo" id="pagoNumRecibo" readonly>
                            </div>
                        </div>
                        <!-- Cliente -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="pagoCliente" readonly>
                            </div>
                        </div>
                        <!-- Observaciones -->
                        <div class="form-group">
                            <textarea class="form-control" id="pagoObservaciones" readonly style="height:120px"></textarea>
                        </div>
                        <div class="form-group row">
                            <!-- Acumulado -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                    <input type="text" class="form-control pagoAcumulado" id="pagoAcumulado" readonly>
                                    <input type="hidden" name="pagoAcumulado" id="pagoAcumuladoSinP">
                                </div>
                            </div>
                            <!-- Método de Pago -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <select class="form-control" id="pagoMetodo" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="T">Tarjeta</option>
                                    <option value="C">Cheque</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group pagoCajasMetodo" style="display:none;"></div>
                        <input type="hidden" name="pagoMetodo" id="pagoListaMetodos">
                        <div class="form-group">
                            <!-- Valor Pago -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                <input type="text" class="form-control pago" id="pago" placeholder="Ingrese el Pago realizado" required disabled>
                                <input type="hidden" name="pago" id="pagoPagoSinP">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Actualizar</button>
                </div>
            <?php
                $pagoRecibo=new ControladorRecibo();
                $pagoRecibo->ctrPagosRecibo();
            ?>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA VER LOS DETALLES DE UN RECIBO -->
<div id="modalVerDetalles" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">
                    <i class="fa fa-eye"></i> Detalle de Pagos
                </h3>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <!-- Datos -->
                    <div class="form-group row">
                        <!-- Número de Recibo -->
                        <div class="col-sm-4 col-xs-12">
                            <div class="input-group" style="width:100%">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input type="text" class="form-control" id="detalleNumRecibo" readonly>
                            </div>
                        </div>
                        <!-- Cliente -->
                        <div class="col-sm-8 col-xs-12">
                            <div class="input-group" style="width:100%">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="detalleCliente" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- Observaciones -->
                    <div class="form-group row">
                        <div class="col-xs-12">
                           <textarea class="form-control" id="detalleObservaciones" style="height:100px" readonly></textarea>
                        </div>
                    </div>
                    <!-- Detalle Pagos -->
                    <div class="form-group row">
                        <!-- Fechas -->
                        <div class="col-sm-4 col-xs-12">
                           <textarea class="form-control" id="detalleFechas" style="height:120px" readonly></textarea>
                        </div>
                        <!-- Método -->
                        <div class="col-sm-4 col-xs-12">
                           <textarea class="form-control" id="detalleMetodo" style="height:120px" readonly></textarea>
                        </div>
                        <!-- Pagos -->
                        <div class="col-sm-4 col-xs-12">
                            <textarea class="form-control detallePagos" id="detallePagos" style="height:120px" readonly></textarea>
                        </div>
                    </div>
                    <!-- Totales -->
                    <div class="form-group row">
                        <div class="col-sm-4 hidden-xs" style="padding:10px 20px;text-align:center;">
                           <label>Total Acumulado</label>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <div class="input-group" style="width:100%">
                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                <input type="text" class="form-control detalleTotal" id="detalleTotal" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>