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
        <h1>Administrar Clientes</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Administrar Clientes</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCliente">
                    <i class="fa fa-plus-circle"></i> Agregar Cliente
                </button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed table-hover dt-responsive tablaClientes" width="100%">
                    <input type="hidden" value="<?=$_SESSION["perfil"];?>" id="perfilOculto">
                    <thead>
                        <tr class="info">
                            <th>TC</th>
                            <th>Nombre</th>
                            <th>TD</th>
                            <th>Documento</th>
                            <th>Email</th>
                            <th>Contacto</th>
                            <th>Dirección</th>
                            <th>Compras</th>
                            <th>Última Compra</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
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
                        <!-- Tipo Cliente -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <select class="form-control" name="tipoCliente" required>
                                    <option value="">Seleccione...</option>
                                    <option value="C">Cliente</option>
                                    <option value="E">Empleado</option>
                                    <option value="P">Proveedor</option>
                                </select>
                            </div>
                        </div>
                        <!-- Nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                <input type="text" class="form-control" name="nombreCliente" placeholder="Ingrese el Nombre del Cliente" maxlength="200" onkeypress="return validar_texto(event)" required>
                            </div>
                        </div>
                        <!-- Tipo Documento -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-id-badge"></i></span>
                                <select class="form-control" name="tipoDocumento" id="tipoDocumento" required>
                                    <option value="">Seleccione...</option>
                                    <option value="C">Cédula</option>
                                    <option value="CE">C.Extranjería</option>
                                    <option value="N">NIT</option>
                                </select>
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
                        <div class="form-group" id="cumpleanos" style="display:none;">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="date" class="form-control" name="fechaNacimientoCliente" id="fechaNacimientoCliente">
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
                $crearCliente->ctrNuevoCliente();
            ?>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR UN CLIENTE -->
<div id="modalEditarCliente" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" method="POST" id="formularioEditar" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-pencil"></i> Editar Cliente
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <input type="hidden" name="editarIdCliente" id="editarIdCliente">
                        <!-- Nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-address-card"></i></span>
                                <input type="text" class="form-control" name="editarNombreCliente" id="editarNombreCliente" placeholder="Ingrese el Nombre del Cliente" maxlength="200" onkeypress="return validar_texto(event)" required>
                            </div>
                        </div>
                        <!-- Email -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input type="email" class="form-control" name="editarEmailCliente" id="editarEmailCliente" placeholder="Ingrese el Correo del Cliente" maxlength="200" required>
                            </div>
                        </div>
                        <!-- Contacto -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input type="text" class="form-control" name="editarContactoCliente" id="editarContactoCliente" placeholder="Ingrese el Contacto del Cliente" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
                            </div>
                        </div>
                        <!-- Dirección -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
                                <input type="text" class="form-control" name="editarDireccionCliente" id="editarDireccionCliente" placeholder="Ingrese el Dirección del Cliente" maxlength="200" onkeypress="return validar_textonumero(event)" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-sign-out"></i> Salir</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Actualizar</button>
                </div>
            <?php
                $editarCliente=new ControladorClientes();
                $editarCliente->ctrEditarCliente();
            ?>
            </form>
        </div>
    </div>
</div>