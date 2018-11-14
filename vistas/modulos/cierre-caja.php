<div class="content-wrapper">
    <!-- Header del Contenido -->
    <section class="content-header">
        <h1>Cierre de Caja</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Cierre de Caja</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <form role="form" method="post" class="cierre_caja">
                        <div class="row">
                            <?php
                                if(isset($_GET["fecha"])){ # Verificamos si viene variable GET de fecha
                                    $fecha=$_GET["fecha"];}
                                else{
                                    date_default_timezone_set('America/Bogota'); # Capturamos la fecha actual del sistema
                                    $fecha=date('Y-m-d');}
                                $recibos=ControladorCierreCaja::ctrMostrarDatosX("recibos",$fecha);
                                $ventas=ControladorCierreCaja::ctrMostrarDatosX("ventas",$fecha);
                                $egresos=ControladorCierreCaja::ctrMostrarDatosX("egresos",$fecha);
                                $texto=null;
                                $acuFacturas=0;
                                $acuRecibos=0;
                                $acuEgresos=0;
                                $efectivo=0;
                                $tarjeta=0;
                                $cheque=0;
                                # Imprimir Recibos
                                if(count($recibos)>0){
                                    $texto.="RECIBOS:\n";
                                    foreach($recibos as $key=>$value){
                                        $cliente=ControladorClientes::ctrMostrarCliente("id",$value["id_cliente"]);
                                        $detalle=ControladorCierreCaja::ctrTraerDR("num_recibo",$value["id"]);
                                        $texto.="N°".$value["id"]." ";
                                        $texto.="Cliente: ".$cliente["nombre"].". ";
                                        $texto.="Valor: $ ".number_format($detalle[0]["pago"],0).". ";
                                        $texto.="(Por/Para) ".$value["observaciones"]."\n";
                                        $acuRecibos+=$detalle[0]["pago"];
                                        if($detalle[0]["metodo_pago"]=="Efectivo"){
                                            $efectivo+=$detalle[0]["pago"];}
                                        else if(substr($detalle[0]["metodo_pago"],0,1)=="T"){
                                            $tarjeta+=$detalle[0]["pago"];}
                                        else if(substr($detalle[0]["metodo_pago"],0,1)=="C"){
                                            $cheque+=$detalle[0]["pago"];}
                                    }
                                }
                                # Imprimir Egresos
                                if(count($egresos)>0){
                                    $texto.="\nEGRESOS:\n";
                                    foreach($egresos as $key=>$value){
                                        $cliente=ControladorClientes::ctrMostrarCliente("id",$value["id_cliente"]);
                                        $texto.="N°".$value["id"]." ";
                                        $texto.="Cliente: ".$cliente["nombre"].". ";
                                        $texto.="Valor: $ ".number_format($value["valor"],0).". ";
                                        $texto.="(Por/Para) ".$value["observaciones"]."\n";
                                        $acuEgresos+=$value["valor"];
                                    }
                                }
                                # Imprimir Facturas
                                if(count($ventas)>0){
                                    $texto.="\nFACTURAS:\n";
                                    foreach($ventas as $key=>$value){
                                        $cliente=ControladorClientes::ctrMostrarCliente("id",$value["id_cliente"]);
                                        $texto.="FAC N°".$value["id"]." ";
                                        $texto.="Cliente: ".$cliente["nombre"].". ";
                                        $texto.="Valor: $ ".number_format($value["total"],0)."\n";
                                        $acuFacturas+=$value["total"];
                                        if($value["metodo_1"]=="Efectivo"){
                                            $efectivo+=$value["pago_1"];}
                                        else if(substr($value["metodo_1"],0,1)=="T"){
                                            $tarjeta+=$value["pago_1"];}
                                        else if(substr($value["metodo_1"],0,1)=="C"){
                                            $cheque+=$value["pago_1"];}
                                        if(substr($value["metodo_3"],0,1)=="T"){
                                            $tarjeta+=$value["pago_3"];}
                                        else if(substr($value["metodo_3"],0,1)=="C"){
                                            $cheque+=$value["pago_3"];}
                                    }
                                }
                                $efectivo-=$acuEgresos; # Hallamos la resta de los pagos en Efectivo (Recibos y Facturas) menos los egresos entregados
                            ?>
                            <!-- Imprimir reporte -->
                            <div class="col-sm-4 col-xs-12 pc">
                                <input type="button" class="btn btn-success btnImprimirCierre" value="Imprimir Cierre de Caja">
                            </div>
                            <!-- Fecha -->
                            <div class="col-sm-4 col-xs-12 pc pull-right">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-calendar"></i></span>
                                    <input type="date" class="form-control" id="fechaCierre" name="fechaCierre" value="<?=$fecha;?>" style="height:38px">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Datos -->
                            <div class="col-sm-8 col-xs-12 pc">
                                <textarea class="form-control" id="obserCierre" disabled><?=$texto;?></textarea>
                            </div>
                            <div class="col-sm-4 col-xs-12 pc">
                                <!-- Efectivo en Caja -->
                                <label class="hidden-xs">Efectivo en Caja</label>
                                <div class="input-group pc" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control efectivoCaja" name="efectivoCaja" value="<?=number_format($efectivo,0);?>" readonly style="height:38px">
                                </div>
                                <!-- Egreso -->
                                <label class="hidden-xs">Egreso</label>
                                <div class="input-group pc" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-upload"></i></span>
                                    <input type="text" class="form-control" name="egresoCierre" value="<?=number_format($acuEgresos,0);?>" readonly style="height:38px">
                                </div>
                                <!-- Ingreso -->
                                <label class="hidden-xs">Ingreso</label>
                                <div class="input-group pc" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-download"></i></span>
                                    <input type="text" class="form-control" name="ingresoCierre" value="<?=number_format($acuRecibos,0);?>" readonly style="height:38px">
                                </div>
                                <!-- Facturas -->
                                <label class="hidden-xs">Facturas</label>
                                <div class="input-group pc" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control" name="facturasCierre" value="<?=number_format($acuFacturas,0);?>" readonly style="height:38px">
                                </div>
                                <!-- Tarjetas -->
                                <label class="hidden-xs">Tarjetas</label>
                                <div class="input-group pc" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-credit-card"></i></span>
                                    <input type="text" class="form-control" name="tarjetasCierre" value="<?=number_format($tarjeta,0);?>" readonly style="height:38px">
                                </div>
                                <!-- Cheques -->
                                <label class="hidden-xs">Cheques</label>
                                <div class="input-group pc" style="width:100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-gg"></i></span>
                                    <input type="text" class="form-control" name="chequesCierre" value="<?=number_format($cheque,0);?>" readonly style="height:38px">
                                </div>
                            </div>
                        </div>
                        <?php
                            # Traemos los datos de cierres anteriores que hayan sido guardados
                            $datoCierre=ControladorCierreCaja::ctrMostrarCierres("fecha",$fecha);
                            if($datoCierre==false){ # Si no existen datos de cierres pasados
                                echo '<!-- Dinero Efectivo -->
                                    <div class="row">
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 100.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="100000">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 50.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="50000">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 20.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="20000">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 10.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="10000">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 5.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="5000">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 2.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="2000">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 1.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="1000">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 500</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="500">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 200</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="200">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 100</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="100">
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 50</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" min="0" id="50">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Arqueo de Caja -->
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            <label class="hidden-xs">Arqueo de Caja</label>
                                            <div class="input-group pc" style="width:100%">
                                                <span class="input-group-addon" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                                <input type="text" class="form-control arqueoCaja" id="arqueoCaja" name="arqueoCaja" readonly style="height:38px">
                                            </div>
                                        </div>
                                        <div class="col-sm-8 col-xs-12">
                                            <label class="hidden-xs">Observaciones</label>
                                            <textarea class="form-control" id="obsCaja" name="obsCaja" onkeypress="return noEnter(event)" required></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <a href="lista-cierres" class="btn btn-warning">Ver otros Cierres</a>
                                            <button type="submit" class="btn btn-primary pull-right">Guardar Cierre</button>
                                        </div>
                                    </div>';
                                $guardarCierre=new ControladorCierreCaja();
                                $guardarCierre->ctrGuardarCierre();
                            }
                            else{ # Si existen cierres anteriores guardados
                                $arrayDinero=json_decode($datoCierre["dinero"],true); # Convertimos el string de dinero en un array
                                echo '<!-- Dinero Efectivo -->
                                    <div class="row">
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 100.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[0].'" min="0" id="100000" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 50.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[1].'" min="0" id="50000" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 20.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[2].'" min="0" id="20000" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 10.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[3].'" min="0" id="10000" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 5.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[4].'" min="0" id="5000" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 2.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[5].'" min="0" id="2000" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 1.000</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[6].'" min="0" id="1000" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 500</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[7].'" min="0" id="500" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 200</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[8].'" min="0" id="200" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 100</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[9].'" min="0" id="100" readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-1 col-xs-12">
                                            <div class="form-group" style="width:100%">
                                                <label>$ 50</label>
                                                <input type="number" class="form-control din-Efectivo" name="dinEfectivo[]" value="'.$arrayDinero[10].'" min="0" id="50" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Arqueo de Caja -->
                                    <div class="row">
                                        <div class="col-sm-4 col-xs-12">
                                            <label class="hidden-xs">Arqueo de Caja</label>
                                            <div class="input-group pc" style="width:100%">
                                                <span class="input-group-addon" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                                <input type="text" class="form-control arqueoCaja" id="arqueoCaja" name="arqueoCaja" value="'.number_format($datoCierre["arqueo"],0).'" readonly style="height:38px">
                                            </div>
                                        </div>
                                        <div class="col-sm-8 col-xs-12">
                                            <label class="hidden-xs">Observaciones</label>
                                            <textarea class="form-control" id="obsCaja" name="obsCaja" readonly>'.$datoCierre["observaciones"].'</textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <a href="lista-cierres" class="btn btn-warning">Ver otros Cierres</a>
                                        </div>
                                    </div>';}
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>