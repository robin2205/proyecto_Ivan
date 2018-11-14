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
        <h1>Administrar Usuarios</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Administrar Usuarios</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
                    <i class="fa fa-plus-circle"></i> Agregar Usuario
                </button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed table-hover dt-responsive tablaUsuarios" width="100%">
                    <thead>
                        <tr class="info">
                            <th>Nombre</th>
                            <th>Usuario</th>
                            <th>Perfil</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR UN USUARIO -->
<div id="modalAgregarUsuario" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" method="POST" id="formularioCrear">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-plus-circle"></i> Agregar Usuario
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" name="nuevoNombre" placeholder="Ingrese el Nombre del Usuario" maxlength="100" onkeypress="return validar_texto(event)" required>
                            </div>
                        </div>
                        <!-- Usuario -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" class="form-control" name="nuevoUsuario" id="nuevoUsuario" placeholder="Ingrese el Usuario asignado" maxlength="10" onkeypress="return validar_texto(event)" required>
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="nuevoPassword" placeholder="Ingrese la Contraseña asignada" maxlength="10" onkeypress="return validar_textonumero(event)" required>
                            </div>
                        </div>
                        <!-- Perfil -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select class="form-control" name="nuevoPerfil" required>
                                    <option value="">Seleccione el Perfil...</option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Especial">Especial</option>
                                    <option value="Vendedor">Vendedor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-sign-out"></i> Salir</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>
            <?php
                $crearUsuario=new ControladorUsuarios();
                $crearUsuario->ctrCrearUsuario();
            ?>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR UN USUARIO -->
<div id="modalEditarUsuario" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" method="POST" id="formularioEditar">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-pencil"></i> Editar Usuario
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Nombre -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input type="text" class="form-control" name="editarNombre" id="editarNombre" placeholder="Ingrese el Nombre del Usuario" maxlength="100" value="" onkeypress="return validar_texto(event)" required>
                            </div>
                        </div>
                        <!-- Usuario -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <input type="text" class="form-control" name="editarUsuario" id="editarUsuario" readonly>
                            </div>
                        </div>
                        <!-- Password -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                <input type="password" class="form-control" name="editarPassword" id="editarPassword" placeholder="Ingrese la Contraseña nueva" maxlength="10" onkeypress="return validar_textonumero(event)">
                                <input type="hidden" name="passwordActual" id="passwordActual">
                            </div>
                        </div>
                        <!-- Perfil -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                <select class="form-control" name="editarPerfil" required>
                                    <option value="" id="editarPerfil"></option>
                                    <option value="Administrador">Administrador</option>
                                    <option value="Especial">Especial</option>
                                    <option value="Vendedor">Vendedor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-sign-out"></i> Salir</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Actualizar</button>
                </div>
            <?php
                $editarUsuario=new ControladorUsuarios();
                $editarUsuario->ctrEditarUsuario();
            ?>
            </form>
        </div>
    </div>
</div>