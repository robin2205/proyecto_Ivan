<div class="content-wrapper">
    <!-- Header del Contenido -->
    <section class="content-header">
        <h1>Administrar Egresos</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Administrar Egresos</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <a href="egreso">
                    <button class="btn btn-primary">
                        <i class="fa fa-plus-circle"></i> Agregar Egreso
                    </button>
                </a>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed table-hover dt-responsive tablaEgresos" width="100%">
                    <thead>
                        <tr class="info">
                            <th>N°</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Valor</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA VER LOS DETALLES DE UN EGRESO -->
<div id="modalVerObEgresos" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h3 class="modal-title">
                    <i class="fa fa-eye"></i> Detalle de Egresos
                </h3>
            </div>
            <div class="modal-body">
                <div class="box-body">
                    <!-- Datos -->
                    <div class="form-group row">
                        <!-- Número de Egreso -->
                        <div class="col-sm-4 col-xs-12 pc">
                            <div class="input-group" style="width:100%">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input type="text" class="form-control" id="numEgreso" readonly>
                            </div>
                        </div>
                        <!-- Cliente -->
                        <div class="col-sm-8 col-xs-12">
                            <div class="input-group" style="width:100%">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" id="clienteEgreso" readonly>
                            </div>
                        </div>
                    </div>
                    <!-- Observaciones -->
                    <div class="form-group row">
                        <div class="col-xs-12">
                           <textarea class="form-control" id="observacionesEgre" style="height:100px" readonly></textarea>
                        </div>
                    </div>
                    <!-- Totales -->
                    <div class="form-group row">
                        <div class="col-sm-4 hidden-xs" style="padding:10px 20px;text-align:center;">
                           <label>Total Entregado</label>
                        </div>
                        <div class="col-sm-8 col-xs-12">
                            <div class="input-group" style="width:100%">
                                <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                <input type="text" class="form-control totalEntregado" id="totalEntregado" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR UN EGRESO -->
<div id="modalEditarEgreso" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form method="POST" class="form-EditarEgreso">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-pencil"></i> Editar Egreso
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group row">
                            <!-- Número de Egreso -->
                            <div class="col-sm-4 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                    <input type="text" class="form-control" name="editarNumEgreso" id="editarNumEgreso" readonly>
                                </div>
                            </div>
                            <!-- Cliente -->
                            <div class="col-sm-8 col-xs-12">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="editarClienteEgreso" readonly>
                                </div>
                            </div>
                        </div>
                        <!-- Observaciones -->
                        <div class="form-group row">
                            <div class="col-xs-12">
                               <textarea class="form-control" name="editarObEgreso" id="editarObEgreso" onkeypress="return noEnter(event)" style="height:150px" required></textarea>
                            </div>
                        </div>
                        <!-- Totales -->
                        <div class="form-group row">
                            <div class="col-sm-4 hidden-xs" style="padding:10px 20px;text-align:center;">
                               <label>Total Entregado</label>
                            </div>
                            <div class="col-sm-8 col-xs-12">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control editarTotalEntregado" id="editarTotalEntregado" onkeypress="return validar_numero(event)" required>
                                    <input type="hidden" name="editarTotalEntregado" id="editarTotalEntregadoSinP">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Actualizar</button>
                        </div>
                    </div>
                </div>
            <?php
                $editarEgreso=new ControladorEgreso();
                $editarEgreso->ctrEditarEgreso();
            ?>
            </form>
        </div>
    </div>
</div>