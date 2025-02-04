<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_bitacora.php');

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Menu Asistencia');


if (permiso_ver('5011') == '1') {

    $_SESSION['asistencia_acta'] = "...";
} else {
    $_SESSION['asistencia_acta'] = "No tiene permisos para visualizar";
}

if (permiso_ver('5012') == '1') {

    $_SESSION['asistencia_persona'] = "...";
} else {
    $_SESSION['asistencia_persona'] = "No tiene permisos para visualizar";
}
ob_end_flush();
?>
<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div class="wrapper">
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0 text-dark">Menú asistencia</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="pagina_principal_vista">Inicio</a></li>
                                <li class="breadcrumb-item active">menú asistencia</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="container-fluid"><br><br>
                    <!-- Info boxes -->
                    <div class="row" style="  display: flex; align-items: center; justify-content: center;">
                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="small-box bg-primary">
                                <div class="inner">
                                    <h4>Asistencia por Acta</h4>
                                    <p><?php echo $_SESSION['asistencia_acta']; ?></p>
                                </div>
                                <div class="icon"><i class="fas fa-file-alt"></i>
                                </div>
                                <a href="../vistas/asistencia_actas_vista" class="small-box-footer">
                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <!--/. container-fluid -->
                </div>
            </section>



            <section class="content">
                <div class="container-fluid">
                    <!-- Info boxes -->
                    <div class="row" style="  display: flex; align-items: center; justify-content: center;">
                        <div class="col-12 col-sm-6 col-md-4">
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h4>Asistencia por Persona</h4>
                                    <p><?php echo $_SESSION['asistencia_persona']; ?></p>
                                </div>
                                <div class="icon"><i class="fas fa-user"></i>
                                </div>
                                <a href="../vistas/asistencia_persona_vista" class="small-box-footer">
                                    Ir <i class="fas fa-arrow-circle-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- /.row -->
                    </div>
                    <!--/. container-fluid -->
                </div>
            </section>
            <!-- /.content -->
        </div>

    </div>

</body>

</html>