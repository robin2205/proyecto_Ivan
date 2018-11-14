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
        <h1>Editar Venta</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Editar Venta</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="row">
            <!-- Formulario -->
            <div class="col-xs-12">
                <div class="box box-primary">
                    <form role="form" method="post" class="form-CrearVenta">
                        <?php
                            $item="id";
                            $valor=$_GET["idVenta"];
                            $ventas=ControladorVentas::ctrMostrarVentas($item,$valor);
                            # Traemos los datos del Vendedor
                            $nombreVendedor=ControladorUsuarios::ctrMostrarUsuarios($item,$ventas["id_vendedor"]);
                            $nombreVendedor=$nombreVendedor["nombre"];
                            # Traemos los datos del cliente
                            $datosCliente=ControladorClientes::ctrMostrarCliente($item,$ventas["id_cliente"]);
                        ?>
                        <div class="row">
                            <!-- Vendedor -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-user"></i></span>
                                    <input type="text" class="form-control" id="vendedor" value="<?=$nombreVendedor;?>" readonly style="height:38px">
                                    <input type="hidden" name="idVendedorEditarVenta" value="<?=$ventas["id_vendedor"];?>">
                                </div>
                            </div>
                            <!-- Factura Venta -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-key"></i></span>
                                    <input type="text" class="form-control" name="editarFactura" id="editarFactura" value="<?=$ventas["factura"];?>" readonly style="height:38px">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Cliente -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-users"></i></span>
                                    <input type="text" class="form-control" id="documentoCliente" value="<?=$datosCliente["documento"]?>" readonly style="height:38px">
                                    <input type="hidden" name="idClienteEditar" id="idCliente" value="<?=$ventas["id_cliente"];?>">
                                </div>
                            </div>
                            <div class="col-sm-6 col-xs-12 nombreCliente">
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-vcard"></i></span>
                                    <input type="text" class="form-control" value="<?=$datosCliente["nombre"]?>" readonly style="height:38px">
                                </div>
                            </div>
                        </div>
                        <!-- Datos Extras del Cliente -->
                        <div class="row datosExtras">
                            <!-- Correo -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-envelope"></i></span>
                                    <input type="text" class="form-control" value="<?=$datosCliente["email"]?>" readonly style="height:38px">
                                </div>
                            </div>
                            <!-- Contacto -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" style="width: 100%">
                                    <span class="input-group-addon" id="spanAddon"><i class="fa fa-phone"></i></span>
                                    <input type="text" class="form-control" value="<?=$datosCliente["contacto"]?>" readonly style="height:38px">
                                </div>
                            </div>
                        </div>
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
                        <div class="form-group row nuevoProducto">
                        <?php
                            $objeto=array();
                            $listaProductos=json_decode($ventas["productos"],true);
                            foreach($listaProductos as $key=>$value){
                                # Traemos los datos por producto
                                $infoProducto=ControladorProductos::ctrTraerProductos("codigo",$value["codigo"],"codigo");
                                # Capturamos en una array el código y el valor_Iva del producto
                                $objeto+=array($value["codigo"]=>$infoProducto["valor_Iva"]);
                                # Hallamos el stock anterior
                                $stockAnterior=$value["stock"]+$value["cantidad"];
                                echo '<div id="itemVenta">
                                        <div class="col-sm-5 col-xs-12" id="divDescripcion">
                                            <div class="input-group" style="margin-bottom:10px; width:100%">
                                                <span class="input-group-addon">
                                                    <button type="button" class="btn btn-danger btn-xs quitarProducto" idProducto="'.$value["codigo"].'"><i class="fa fa-times"></i></button>
                                                </span>
                                                <input type="text" class="form-control productoSeleccionado" name="productoSeleccionado" id="productoSeleccionado" value="'.$value["descripcion"].'" idProducto="" readonly style="height:38px">
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-xs-12 divStock" id="divStock">
                                            <div class="input-group" style="margin-bottom:10px; width:100%">
                                                <span class="input-group-addon" id="spanIcono"><i class="fa fa-arrow-up"></i></span>
                                                <input type="number" class="form-control cantidadProducto" name="cantidadProducto" id="cantidadProducto" value="'.$value["cantidad"].'" stock="'.$stockAnterior.'" placeholder="0" min="1" max="'.$stockAnterior.'" codigo="'.$value["codigo"].'" required style="height:38px;">
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-xs-12">
                                            <div class="input-group" style="margin-bottom:10px; width:100%">
                                                <span class="input-group-addon" id="spanAddon"><i class="fa fa-tag"></i></span>
                                                <input type="text" class="form-control valorUni" value="'.$value["precio"].'" readonly style="height:38px">
                                            </div>
                                        </div>
                                        <div class="col-sm-3 col-xs-12 divPrecio" id="divPrecio">
                                            <div class="input-group" style="margin-bottom:10px; width:100%">
                                                <span class="input-group-addon" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                                <input type="text" class="form-control precioProducto" name="precioProducto" id="precioProducto" precioReal="'.$value["precio"].'" value="'.$value["total"].'" readonly style="height:38px">
                                            </div>
                                        </div>
                                    </div>';}
                        echo "<script>
                                localStorage.setItem('objeto',JSON.stringify(".json_encode($objeto)."));
                            </script>";
                        ?>
                        </div>
                        <!-- Subtotal, IVA y Total -->
                        <div class="row">
                            <!-- Subtotal -->
                            <div class="col-sm-3 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control subtotalVenta" id="subtotalVenta" value="<?=$ventas["subtotalventa"];?>" placeholder="Subtotal Venta" readonly style="height:38px">
                                    <input type="hidden" name="subtotalVenta" id="subtotalVentaSinP" value="<?=$ventas["subtotalventa"];?>">
                                </div>
                            </div>
                            <!-- IVA -->
                            <div class="col-sm-3 col-xs-12 pc">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control iva" id="iva" value="<?=$ventas["sumaiva"];?>" placeholder="IVA" readonly style="height:38px">
                                    <input type="hidden" name="iva" id="ivaSinP" value="<?=$ventas["sumaiva"];?>">
                                </div>
                            </div>
                            <!-- Total de Venta -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" style="width:100%">
                                    <span class="input-group-addon hidden-xs" id="spanAddon"><i class="ion ion-social-usd"></i></span>
                                    <input type="text" class="form-control" id="totalVenta" value="<?=$ventas["total"];?>" placeholder="Total Venta" total="" readonly style="height:38px">
                                    <input type="hidden" name="totalVenta" id="totalVentaSinP" value="<?=$ventas["total"];?>">
                                </div>
                            </div>
                        </div>
                        <!-- Método de Pago -->
                        <div class="row">
                            <!-- Forma de Pago -->
                            <div class="col-sm-5 col-xs-12">
                                <select class="form-control" name="metodoPagoVenta" id="metodoPagoVenta" required style="height:38px;" disabled>
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
                                <button type="submit" class="btn btn-success pull-right">Actualizar Venta</button>
                            </div>
                        </div>
                        <?php
                            $editarVenta=new ControladorVentas();
                            $editarVenta->ctrEditarVentas();
                        ?>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>