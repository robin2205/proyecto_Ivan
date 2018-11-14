<div class="content-wrapper">
    <!-- Header del Contenido -->
    <section class="content-header">
        <h1>Recibo de Venta</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Recibo de Caja</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="row">
            <!-- Formulario -->
            <div class="col-xs-12">
                <div class="box box-primary">
                    <form role="form" method="post" class="form-CrearRecibo">
                        <div class="row">
                            <!-- Vendedor -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="vendedor" value="<?=$_SESSION["nombre"];?>" readonly style="height:38px">
                                    <input type="hidden" name="idVendedor" value="<?=$_SESSION["id"];?>">
                                </div>
                            </div>
                            <!-- N° del Recibo -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-key"></i></span>
                                    <?php
                                        $item=null;
                                        $valor=null;
                                        $orden="num_recibo";
                                        $recibo=ControladorRecibo::ctrTraerRecibos($item,$valor,null,null,$orden);
                                        if(count($recibo)==0){
                                            echo '<input type="text" class="form-control" name="idRecibo" id="idRecibo" value="1" readonly style="height:38px">';}
                                        else{
                                            foreach($recibo as $key=>$value){}
                                            $idRecibo=$value["num_recibo"]+1;
                                            echo '<input type="text" class="form-control" name="idRecibo" id="idRecibo" value="'.$idRecibo.'" readonly style="height:38px">';}
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Cliente -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-users"></i></span>
                                    <input type="text" class="form-control" id="seleccionCliente" maxlength="15" onkeypress="return validar_textonumero(event)" required style="height:38px">
                                    <input type="hidden" name="reciboCliente" id="idCliente">
                                    <span class="input-group-addon hidden btoAgragarCli">
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Cliente</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 nombreCliente"></div>
                        </div>
                        <!-- Datos Extras del Cliente -->
                        <div class="row datosExtras"></div>
                        <!-- Observación -->
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="observacionesRecibo">Observaciones</label>
                                <textarea class="form-control" name="observacionesRecibo" id="observacionesRecibo" onkeypress="return noEnter(event)" required style="height:120px"></textarea>
                                <input type="button" class="btn btn-warning btn-xs pull-right btnLimpiar" value="Limpiar" style="margin-top:5px">
                            </div>
                        </div>
                        <!-- Método de Pago -->
                        <div class="row">
                            <!-- Forma de Pago -->
                            <div class="col-sm-6 col-xs-12">
                                <select class="form-control" id="metodoPagoRecibo" style="height:38px;">
                                    <option value="">Seleccionar...</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="T">Tarjeta</option>
                                    <option value="C">Cheque</option>
                                </select>
                            </div>
                            <div class="cajasMetodoPago"></div>
                            <input type="hidden" name="metodoPagoRecibo" id="listaMetodosPago">
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary pull-right">Guardar Recibo</button>
                            </div>
                        </div>
                        <?php
                            $reciboCaja=new ControladorRecibo();
                            $reciboCaja->ctrCrearRecibo();
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>