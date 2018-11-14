<?php
if($_SESSION["perfil"]=="Vendedor"){
    echo '<script>
            window.location="inicio";
        </script>';
    return;}
?>
<div class="content-wrapper">
    <!-- Header del Contenido -->
    <section class="content-header">
        <h1>Administrar Productos</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Administrar Productos</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
                    <i class="fa fa-plus-circle"></i> Agregar Producto
                </button>
            </div>
            <div class="box-body">
                <input type="hidden" value="<?=$_SESSION["perfil"];?>" id="perfilOculto">
                <table class="table table-bordered table-condensed table-hover dt-responsive tablaProductos" width="100%">
                    <thead>
                        <tr class="info">
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Precio de Compra</th>
                            <th>IVA</th>
                            <th>Precio de Venta</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR UN PRODUCTO -->
<div id="modalAgregarProducto" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" method="POST" id="formulario">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-plus-circle"></i> Agregar Producto
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Categoría -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <select class="form-control" name="categoriaProducto" id="categoriaProducto" required>
                                    <option value="">Seleccione el Categoría...</option>
                                <?php
                                    $item=null;
                                    $valor=null;
                                    $categorias=ControladorCategorias::ctrTraerCategorias($item,$valor);
                                    foreach($categorias as $key=>$value){
                                        echo '<option value="'.$value["id"].'">'.$value["categoria"].'</option>';}
                                ?>
                                </select>
                            </div>
                        </div>
                        <!-- Código -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input type="text" class="form-control" name="codigoProducto" id="codigoProducto" placeholder="Ingrese el código del Producto" required>
                            </div>
                        </div>
                        <!-- Descripción -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                                <input type="text" class="form-control" name="descripcionProducto" id="descripcionProducto" placeholder="Ingrese la descripción del Producto" maxlength="200" onkeypress="return validar_textonumero(event)" required>
                            </div>
                        </div>
                        <!-- Stock -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dropbox"></i></span>
                                <input type="number" class="form-control" name="stockProducto" placeholder="Ingrese la cantidad de Stock" min="0" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- Precio de Compra -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                    <input type="text" class="form-control" name="precioCompra" id="precioCompra" placeholder="Ingrese el valor de compra del Producto" maxlength="10" onkeypress="return validar_numeroDecimal(event)" required>
                                </div>
                            </div>
                            <!-- Iva del Producto -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" id="iva">
                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    <input type="text" class="form-control" name="ivaProducto" id="ivaProducto" placeholder="Ingrese el IVA del Producto" maxlength="2" onkeypress="return validar_numero(event)" required>
                                    <input type="hidden" class="form-control" name="valorIva" id="valorIva">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- Precio de Venta -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                    <input type="text" class="form-control" name="precioVentaNuevo" id="precioVentaNuevo" placeholder="Valor Precio de Venta" onkeypress="return validar_numero(event)" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><i class="fa fa-sign-out"></i> Salir</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>
            <?php
                $crearProducto=new ControladorProductos();
                $crearProducto->ctrCrearProducto();
            ?>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR UN PRODUCTO -->
<div id="modalEditarProducto" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" method="POST" id="formulario">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-pencil"></i> Editar Producto
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Código -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input type="text" class="form-control" name="editarCodigoProducto" id="editarCodigoProducto" readonly>
                            </div>
                        </div>
                        <!-- Descripción -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-product-hunt"></i></span>
                                <input type="text" class="form-control" name="editarDescripcionProducto" id="editarDescripcionProducto" placeholder="Ingrese la descripción del Producto" maxlength="200" onkeypress="return validar_textonumero(event)" required>
                            </div>
                        </div>
                        <!-- Stock -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-dropbox"></i></span>
                                <input type="number" class="form-control" name="editarStockProducto" id="editarStockProducto" placeholder="Ingrese la cantidad de Stock" min="0" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- Precio de Compra -->
                            <div class="col-sm-6 col-xs-12 pc">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                    <input type="text" class="form-control" name="editarPrecioCompra" id="editarPrecioCompra" placeholder="Ingrese el valor de compra del Producto" maxlength="10" onkeypress="return validar_numeroDecimal(event)" required>
                                </div>
                            </div>
                            <!-- Iva del Producto -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" id="iva">
                                    <span class="input-group-addon"><i class="fa fa-percent"></i></span>
                                    <input type="text" class="form-control" name="editarIvaProducto" id="editarIvaProducto" placeholder="Ingrese el IVA del Producto" maxlength="2" onkeypress="return validar_numero(event)" required>
                                    <input type="hidden" class="form-control" name="valorIvaEditado" id="valorIvaEditado">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <!-- Precio de Venta -->
                            <div class="col-sm-6 col-xs-12">
                                <div class="input-group" id="precioVenta">
                                    <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                    <input type="text" class="form-control" name="editarPrecioVenta" id="editarPrecioVenta" placeholder="Ingrese el valor PVP" onkeypress="return validar_numeroDecimal(event)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-sign-out"></i> Salir</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Actualizar</button>
                </div>
            <?php
                $editarProducto=new ControladorProductos();
                $editarProducto->ctrEditarProducto();
            ?>
            </form>
        </div>
    </div>
</div>