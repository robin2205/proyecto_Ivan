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
                            <th>Subtotal</th>
                            <th>Total</th>
                            <th>Adeuda</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA EDITAR UN RECIBO -->
<div id="modalEditarRecibo" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" method="POST" class="form-EditarRecibo">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-pencil"></i> Editar Recibo
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Número de Recibo -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input type="text" class="form-control" name="editarNumRecibo" id="editarNumRecibo" readonly>
                            </div>
                        </div>
                        <!-- Cliente -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="editarCliente" readonly>
                            </div>
                        </div>
                        <!-- Observaciones -->
                        <div class="form-group">
                            <textarea class="form-control" id="editarObservaciones" readonly style="height:120px"></textarea>
                        </div>
                        <div class="form-group row">
                            <!-- Adeuda -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                    <input type="text" class="form-control editarAdeuda" id="editarAdeuda" readonly>
                                    <input type="hidden" name="editarAdeuda" id="editarAdeudaSinP">
                                </div>
                            </div>
                            <!-- Método de Pago -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <select class="form-control" id="editarMetodoPago" required>
                                    <option value="">Seleccionar...</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="T">Tarjeta</option>
                                    <option value="C">Cheque</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group cajasMetodoPagoEditar" style="display:none;"></div>
                        <input type="hidden" name="editarMetodoPago" id="listaMetodosPagoEditar">
                        <div class="form-group">
                            <!-- Valor Pago -->
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                <input type="text" class="form-control editarPago" id="editarPago" placeholder="Ingrese el Pago realizado" required disabled>
                                <input type="hidden" name="editarPago" id="editarPagoSinP">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Actualizar</button>
                </div>
            <?php
                $editarRecibo=new ControladorRecibo();
                $editarRecibo->ctrEditarRecibo();
            ?>
            </form>
        </div>
    </div>
</div>