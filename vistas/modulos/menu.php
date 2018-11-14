<aside class="main-sidebar">
    <section class="sidebar">
        <!-- Menús -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menú de Navegación</li>
            <?php
            # Si es Administrador y Vendedor
            if($_SESSION["perfil"]=="Administrador" || $_SESSION["perfil"]=="Vendedor"){
                echo '<li>
                        <a href="inicio"><i class="fa fa-home"></i> <span>Inicio</span></a>
                    </li>';}
            # Si es Administrador
            if($_SESSION["perfil"]=="Administrador"){
                echo '<li>
                        <a href="usuarios"><i class="fa fa-user"></i> <span>Usuarios</span></a>
                    </li>';}
            # Si es Administrador y Especial
            if($_SESSION["perfil"]=="Administrador" || $_SESSION["perfil"]=="Especial"){
                echo '<li>
                        <a href="categorias"><i class="fa fa-th"></i> <span>Categorías</span></a>
                    </li>
                    <li>
                        <a href="productos"><i class="fa fa-product-hunt"></i> <span>Productos</span></a>
                    </li>';}
            # Si es Administrador y Vendedor
            if($_SESSION["perfil"]=="Administrador" || $_SESSION["perfil"]=="Vendedor"){
                echo '<li>
                        <a href="clientes"><i class="fa fa-users"></i> <span>Clientes</span></a>
                    </li>
                    <li class="treeview">
                        <a>
                            <i class="fa fa-folder"></i> <span>Recibos</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="recibo"><i class="fa fa-circle"></i> Recibo de Caja</a></li>
                            <li><a href="admon-recibos"><i class="fa fa-circle"></i> Administrar Recibos</a></li>
                        </ul>
                    </li>
                    <li class="treeview">
                        <a>
                            <i class="fa fa-list-ul"></i> <span>Ventas</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu">
                            <li><a href="ventas"><i class="fa fa-circle"></i> Administrar Ventas</a></li>';}
                # Si es Administrador
                if($_SESSION["perfil"]=="Administrador"){
                    echo '<li><a href="#"><i class="fa fa-circle"></i> Gráficas</a></li>';}
                ?>
                </ul>
            </li>
            <hr class="hidden-lg hidden-md hidden-sm">
            <li class="hidden-lg hidden-md hidden-sm">
                <a href="salir" title="Salir"><i class="fa fa-sign-out"></i></a>
            </li>
        </ul>
    </section>
</aside>