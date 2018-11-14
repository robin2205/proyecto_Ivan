<div class="content-wrapper">
    <!-- Header del Contenido -->
    <section class="content-header">
        <h1>Egreso de Caja</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Egreso de Caja</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="row">
            <!-- Formulario -->
            <div class="col-xs-12">
                <div class="box box-primary">
                    <form role="form" method="post" class="form-CrearEgreso">
                        <div class="row">
                            <!-- Vendedor -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="vendedor" value="<?=$_SESSION["nombre"];?>" readonly style="height:38px">
                                    <input type="hidden" name="idVendedor" value="<?=$_SESSION["id"];?>">
                                </div>
                            </div>
                            <!-- N° del Egreso -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-key"></i></span>
                                    <?php
                                        # Capturamos la fecha actual del sistema
                                        date_default_timezone_set('America/Bogota');
                                        $hoy=date('Y-m-d');
                                        $orden="id";
                                        $egreso=ControladorEgreso::ctrTraerEgresos(null,null,$orden);
                                        if(count($egreso)==0){
                                            echo '<input type="text" class="form-control" name="idEgreso" id="idEgreso" value="1" readonly style="height:38px">';}
                                        else{
                                            foreach($egreso as $key=>$value){}
                                            $idEgreso=$value["id"]+1;
                                            echo '<input type="text" class="form-control" name="idEgreso" id="idEgreso" value="'.$idEgreso.'" readonly style="height:38px">';}
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
                                    <input type="hidden" name="egresoCliente" id="idCliente">
                                    <span class="input-group-addon hidden btoAgragarCli">
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Cliente</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 nombreCliente"></div>
                        </div>
                        <!-- Datos Extras del Cliente -->
                        <div class="row datosExtras"></div>
                        <!-- Valor Efectivo en Caja -->
                         <div class="row">
                            <div class="col-sm-2 hidden-xs" style="padding:10px 20px;text-align:right;">
                                <label>Efectivo en Caja</label>
                            </div>
                            <div class="col-sm-4 col-xs-12 pc">
                            <?php
                                # Traemos el efectivo de caja por fecha de los recibos
                                $efectivoRecibo=ControladorEgreso::ctrSumaEfectivo("Efectivo",$hoy);
                                if($efectivoRecibo[0]==NULL){
                                    $efectivoRecibo[0]=0;}
                                # Traemos el efectivo de caja por fecha de las ventas
                                $efectivoVentas=ControladorEgreso::ctrSumaEfectivoVentas($hoy);
                                if($efectivoVentas[0]==NULL){
                                    $efectivoVentas[0]=0;}
                                # Traemos los Egresos realizados por fecha
                                $sumaEgreso=ControladorEgreso::ctrSumaEgresos($hoy);
                                if($sumaEgreso[0]==NULL){
                                    $sumaEgreso[0]=0;}
                                # Hallamos el valor real de la caja
                                $valorRealCaja=($efectivoRecibo[0]+$efectivoVentas[0])-$sumaEgreso[0];
                            ?>
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control valorCaja" id="valorCaja" value="<?=$valorRealCaja;?>" readonly style="height:38px">
                                    <input type="hidden" name="valorCaja" value="<?=$valorRealCaja;?>">
                                </div>
                            </div>
                            <!-- Fecha -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-calendar"></i></span>
                                    <input type="date" class="form-control" name="fechaEgreso" value="<?=$hoy;?>" readonly style="height:38px">
                                </div>
                            </div>
                        </div>
                        <!-- Observación -->
                        <div class="row">
                            <div class="col-xs-12">
                                <label for="observacionesRecibo">Observaciones</label>
                                <textarea class="form-control" name="observacionesEgreso" id="observacionesEgreso" onkeypress="return noEnter(event)" required style="height:120px"></textarea>
                                <input type="button" class="btn btn-warning btn-xs pull-right btnLimpiarEgreso" value="Limpiar" style="margin-top:5px">
                            </div>
                        </div>
                        <!-- Cantidad entregada -->
                        <div class="row">
                            <div class="col-sm-2 hidden-xs" style="padding:10px 20px;text-align:right;">
                                <label>Efectivo Entregado</label>
                            </div>
                            <div class="col-sm-4 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control cantidadEntregada" onkeypress="return validar_numero(event)" required style="height:38px">
                                    <input type="hidden" name="cantidadEntregada" id="cantidadEntregada">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary pull-right">Guardar Egreso</button>
                            </div>
                        </div>
                        <?php
                            $crearEgreso=new ControladorEgreso();
                            $crearEgreso->ctrCrearEgreso();
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>