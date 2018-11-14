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
        <h1>Crear Venta</h1>
        <ol class="breadcrumb">
            <li><i class="fa fa-home"></i> Inicio</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="row">
            <!-- Formulario -->
            <div class="col-xs-12">
                <div class="box box-primary">
                    <form role="form" method="post" class="form-CrearVenta">
                        <div class="row">
                            <!-- Vendedor -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="vendedor" value="<?=$_SESSION["nombre"];?>" readonly style="height:38px">
                                    <input type="hidden" name="idVendedor" value="<?=$_SESSION["id"];?>">
                                </div>
                            </div>
                            <!-- Factura Venta -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-key"></i></span>
                                    <?php
                                        $item=null;
                                        $valor=null;
                                        $ventas=ControladorVentas::ctrMostrarVentas($item,$valor);
                                        if(!$ventas){
                                            echo '<input type="text" class="form-control" name="factura" id="factura" maxlength="15" onkeypress="return validar_textonumero(event)" required style="height:38px">';}
                                        else{
                                            foreach($ventas as $key=>$value){}
                                            $factura=$value["factura"]+1;
                                            echo '<input type="text" class="form-control" name="factura" id="factura" value="'.$factura.'" readonly style="height:38px">';}
                                    ?>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Cliente -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-users"></i></span>
                                    <input type="text" class="form-control" id="seleccionCliente" maxlength="15" onkeypress="return validar_textonumero(event)" required style="height:38px">
                                    <input type="hidden" name="seleccionCliente" id="idCliente">
                                    <span class="input-group-addon hidden btoAgragarCli">
                                        <button type="button" class="btn btn-default btn-xs" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Cliente</button>
                                    </span>
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 nombreCliente"></div>
                        </div>
                        <!-- Datos Extras del Cliente -->
                        <div class="row datosExtras"></div>
                        <!-- Busqueda del Producto -->
                        <div class="row">
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-cart-plus"></i></span>
                                    <input type="text" class="form-control" name="seleccionProducto" id="seleccionProducto" maxlength="15" onkeypress="return validar_numero(event)" required style="height:38px">
                                </div>
                            </div>
                        </div>
                         <!-- ENTRADA PARA AGREGAR PRODUCTOS -->
                        <input type="hidden" id="listaProductos" name="listaProductos">
                        <!-- Visualizador de Producto agregados-->
                        <div class="form-group row nuevoProducto"></div>
                        <!-- Subtotal, IVA y Total -->
                        <div class="row">
                            <!-- Subtotal -->
                            <div class="col-sm-3 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control subtotalVenta" id="subtotalVenta" placeholder="Subtotal Venta" readonly style="height:38px">
                                    <input type="hidden" name="subtotalVenta" id="subtotalVentaSinP">
                                </div>
                            </div>
                            <!-- IVA -->
                            <div class="col-sm-3 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control iva" id="iva" placeholder="IVA" readonly style="height:38px">
                                    <input type="hidden" name="iva" id="ivaSinP">
                                </div>
                            </div>
                            <!-- Total de Venta -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control" id="totalVenta" placeholder="Total Venta" total="" readonly style="height:38px">
                                    <input type="hidden" name="totalVenta" id="totalVentaSinP">
                                </div>
                            </div>
                        </div>
                        <!-- Método de Pago -->
                        <div class="row">
                            <!-- Forma de Pago -->
                            <div class="col-sm-5 col-xs-12">
                                <select class="form-control" name="metodoPagoVenta" id="metodoPagoVenta" required style="height: 38px;" disabled>
                                    <option value="">Seleccionar...</option>
                                    <option value="Efectivo">Efectivo</option>
                                    <option value="T">Tarjeta</option>
                                    <option value="C">Cheque</option>
                                    <option value="C15">Crédito 15 días</option>
                                    <option value="C30">Crédito 30 días</option>
                                    <option value="C45">Crédito 45 días</option>
                                    <option value="C60">Crédito 60 días</option>
                                </select>
                            </div>
                            <div class="col-sm-7 col-xs-12 cajasMetodoPago"></div>
                            <input type="hidden" name="listaMetodosPago" id="listaMetodosPago">
                        </div>
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-primary pull-right">Guardar Venta</button>
                            </div>
                        </div>
                        <?php
                            $crearVenta=new ControladorVentas();
                            $crearVenta->ctrGuardarVentas();
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR UN CLIENTE -->
<div id="modalAgregarCliente" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" method="POST" id="formulario">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-plus-circle"></i> Agregar Cliente
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                <input type="text" class="form-control" name="nombreCliente" placeholder="Ingrese el Nombre del Cliente" maxlength="200" onkeypress="return validar_texto(event)" required>
                            </div>
                        </div>
                        <!-- Documento -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-flag"></i></span>
                                <input type="text" class="form-control" name="documentoCliente" id="documentoCliente" placeholder="Ingrese el Documento del Cliente" maxlength="20" onkeypress="return validar_textonumero(event)" required>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="emailCliente" placeholder="Ingrese el Correo del Cliente" maxlength="200" required>
                            </div>
                        </div>
                        <!-- Contacto -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control" name="contactoCliente" placeholder="Ingrese el Contacto del Cliente" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
                            </div>
                        </div>
                        <!-- Dirección -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control" name="direccionCliente" placeholder="Ingrese el Dirección del Cliente" maxlength="200" onkeypress="return validar_textonumero(event)" required>
                            </div>
                        </div>
                        <!-- Fecha de Nacimiento -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="date" class="form-control" name="fechaNacimientoCliente" id="fechaNacimientoCliente" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><i class="fa fa-sign-out"></i> Salir</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>
            <?php
                $crearCliente=new ControladorClientes();
                $crearCliente->ctrNuevoClientedesdeInicio();
            ?>
            </form>
        </div>
    </div>
</div>