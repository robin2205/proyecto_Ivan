<div id="back"></div>
<div class="login-box">
    <div class="login-logo">
        <img src="vistas/img/plantilla/logo-blanco-bloque.png" class="img-responsive" style="padding: 30px 50px 0px 50px">
    </div>
    <!-- Logo del Login -->
    <div class="login-box-body">
        <p class="login-box-msg">Ingresar al Sistema</p>
        <form method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="ingUsuario" name="ingUsuario" placeholder="Ingrese el Usuario" maxlength="10" onkeypress="return validar_texto(event)" required>
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="ingPassword" name="ingPassword" placeholder="Ingrese la Contraseña" maxlength="10" onkeypress="return validar_textonumero(event)" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                </div>
            </div>
            <?php
                $login=new ControladorUsuarios();
                $login->ctrIngresoUsuario();
            ?>
        </form>
    </div>
</div>