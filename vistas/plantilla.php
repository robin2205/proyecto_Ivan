<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sistema Inventario</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- ****************************************PLUGINS DE CSS**************************************** -->
    <link rel="stylesheet" href="vistas/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="vistas/bower_components/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vistas/bower_components/Ionicons/css/ionicons.min.css">
    <link rel="stylesheet" href="vistas/dist/css/AdminLTE.css">
    <link rel="stylesheet" href="vistas/dist/css/skins/_all-skins.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="vistas/bower_components/datatables.net-bs/css/responsive.bootstrap.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="vistas/plugins/iCheck/all.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- Morris.css charts -->
    <link rel="stylesheet" href="vistas/bower_components/morris.js/morris.css">

    <!-- ****************************************PERSONALES DE CSS**************************************** -->
    <link rel="stylesheet" href="vistas/dist/css/estilos_propios.css">
    <link rel="icon" href="vistas/img/plantilla/icono-negro.png">

    <!-- ****************************************PLUGINS DE JAVASCRIPT**************************************** -->
    <script src="vistas/bower_components/jquery/dist/jquery.min.js"></script>
    <script src="vistas/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="vistas/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="vistas/bower_components/fastclick/lib/fastclick.js"></script>
    <script src="vistas/dist/js/adminlte.js"></script>
    <!-- DataTables -->
    <script src="vistas/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vistas/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vistas/bower_components/datatables.net-bs/js/dataTables.responsive.min.js"></script>
    <script src="vistas/bower_components/datatables.net-bs/js/responsive.bootstrap.min.js"></script>
    <!-- Sweetalert2 -->
    <script src="vistas/plugins/sweetalert2/sweetalert2.all.js"></script>
    <!-- Habitamos el soporte para Internet Explorer -->
    <script src="vistas/js/plugins-para-ie.js"></script>
    <!-- iCheck -->
    <script src="vistas/plugins/iCheck/icheck.min.js"></script>
    <!-- InputMask -->
    <script src="vistas/plugins/input-mask/jquery.inputmask.js"></script>
    <script src="vistas/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
    <script src="vistas/plugins/input-mask/jquery.inputmask.extensions.js"></script>
    <!-- jQuery Number -->
    <script src="vistas/plugins/jQueryNumber.js"></script>
    <!-- Daterange picker -->
    <script src="vistas/bower_components/moment/min/moment.min.js"></script>
    <script src="vistas/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- Morris.js charts -->
    <script src="vistas/bower_components/raphael/raphael.min.js"></script>
    <script src="vistas/bower_components/morris.js/morris.min.js"></script>
    <!-- Chart.js -->
    <script src="vistas/bower_components/chart.js/Chart.js"></script>
</head>
<!-- ****************************************CUERPO DEL SISTEMA**************************************** -->
<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
    <?php
        // Verificamos que la variable de Session tenga información
        if(isset($_SESSION["iniciarSesion"]) && $_SESSION["iniciarSesion"]=="ok"){
            /*---------- Wrapper ----------*/
            echo '<div class="wrapper">';
            # Incluimos el cabezote
            include 'modulos/cabezote.php';
            # Incluimos el menú
            include 'modulos/menu.php';

            // Verificamos que venga información en la varibale ruta (URL's Amigables)
            if(isset($_GET["ruta"])){
                # Creamos nuestra lista blanca de rutas permitidas
                if($_GET["ruta"]=="inicio" || $_GET["ruta"]=="usuarios" || $_GET["ruta"]=="categorias" || $_GET["ruta"]=="productos" || $_GET["ruta"]=="clientes" || $_GET["ruta"]=="ventas" || $_GET["ruta"]=="recibo" || $_GET["ruta"]=="admon-recibos" || $_GET["ruta"]=="egreso" || $_GET["ruta"]=="admon-egreso" || $_GET["ruta"]=="reportes" || $_GET["ruta"]=="cierre-caja" || $_GET["ruta"]=="lista-cierres" || $_GET["ruta"]=="salir"){
                    include 'modulos/'.$_GET["ruta"].'.php';}
                else{
                    include 'modulos/404.php';}}
            else{
                include 'modulos/inicio.php';}

            # Incluimos el footer
            include 'modulos/footer.php';

            echo '</div>';}
        else{
            include 'modulos/login.php';
        }
    ?>

    <!-- ****************************************JAVASCRIPT PERSONALES**************************************** -->
    <script src="vistas/js/plantilla.js"></script>
    <script src="vistas/js/validaciones.js"></script>
    <script src="vistas/js/inicio.js"></script>
    <script src="vistas/js/usuarios.js"></script>
    <script src="vistas/js/categorias.js"></script>
    <script src="vistas/js/productos.js"></script>
    <script src="vistas/js/clientes.js"></script>
    <script src="vistas/js/ventas.js"></script>
    <script src="vistas/js/reportes.js"></script>
    <script src="vistas/js/recibo.js"></script>
    <script src="vistas/js/egreso.js"></script>
    <script src="vistas/js/cierre-caja.js"></script>
</body>
</html>
