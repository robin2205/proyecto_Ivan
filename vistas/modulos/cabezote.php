<header class="main-header">
    <!-- LOGOTIPO -->
    <a href="inicio" class="logo">
        <!-- Mini logo para sidebar de 50*50 pixeles -->
        <span class="logo-mini">
            <img src="vistas/img/plantilla/icono-blanco.png" class="img-responsive" style="padding: 5px;">
        </span>
        <!-- Logo normal para los demás dispositivos -->
        <span class="logo-lg">
            <img src="vistas/img/plantilla/logo-blanco-lineal.png" class="img-responsive" style="padding: 10px 0px;">
        </span>
    </a>
    <!-- BARRA DE NAVEGACIÓN -->
    <nav class="navbar navbar-static-top">
        <!-- Botón de Navegación -->
        <a class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Perfil de Usuario -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="hidden-xs"><?=$_SESSION["usuario"];?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="user-header">
                            <p>
                                <?=$_SESSION["nombre"];?> - <?=$_SESSION["perfil"];?>
                                <small>Miembro desde <?=substr($_SESSION["fecha"],0,-9);?></small>
                            </p>
                        </li>
                        <!-- Opciones -->
                        <li class="user-footer">
                            <div class="pull-right">
                                <a href="salir" class="btn btn-default btn-flat">Salir</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>