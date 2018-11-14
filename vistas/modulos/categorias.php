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
        <h1>Administrar Categorías</h1>
        <ol class="breadcrumb">
            <li><a href="inicio"><i class="fa fa-home"></i> Inicio</a></li>
            <li class="active">Administrar Categorías</li>
        </ol>
    </section>

    <!-- Sección de Contenido -->
    <section class="content">
        <div class="box">
            <div class="box-header with-border">
                <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarCategoria">
                    <i class="fa fa-plus-circle"></i> Agregar Categoría
                </button>
            </div>
            <div class="box-body">
                <table class="table table-bordered table-condensed table-hover dt-responsive tablaCategoria" width="100%">
                    <thead>
                        <tr class="info">
                            <th style="width: 10px;">#</th>
                            <th>Categoría</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- MODAL PARA AGREGAR UNA CATEGORÍA -->
<div id="modalAgregarCategoria" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" method="POST" id="formulario">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-plus-circle"></i> Agregar Categoría
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Categoría -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <input type="text" class="form-control" name="nuevoCategoria" placeholder="Ingrese la Categoría nueva" maxlength="200" onkeypress="return validar_textonumero(event)" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success pull-left" data-dismiss="modal"><i class="fa fa-sign-out"></i> Salir</button>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar</button>
                </div>
            <?php
                $crearCategoria=new ControladorCategorias();
                $crearCategoria->ctrNuevaCategoria();
            ?>
            </form>
        </div>
    </div>
</div>

<!-- MODAL PARA EDITAR UNA CATEGORÍA -->
<div id="modalEditarCategoria" class="modal fade modales" role="dialog">
    <div class="modal-dialog">
        <!-- Contenido del Modal-->
        <div class="modal-content">
            <form role="form" method="POST" id="formularioEditar" enctype="multipart/form-data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">X</button>
                    <h3 class="modal-title">
                        <i class="fa fa-pencil"></i> Editar Categoría
                    </h3>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <!-- Id de Categoría -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                <input type="text" class="form-control" name="idCategoria" id="idCategoria" value="" onkeypress="return validar_numero(event)" readonly>
                            </div>
                        </div>
                        <!-- Categoría -->
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                <input type="text" class="form-control" name="editarCategoria" id="editarCategoria" placeholder="Ingrese la Categoría editada" maxlength="200" value="" onkeypress="return validar_textonumero(event)" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning pull-left" data-dismiss="modal"><i class="fa fa-sign-out"></i> Salir</button>
                    <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> Actualizar</button>
                </div>
            <?php
                $editarCategoria=new ControladorCategorias();
                $editarCategoria->ctrEditarCategoria();
            ?>
            </form>
        </div>
    </div>
</div>