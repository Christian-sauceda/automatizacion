<?php

ob_start();


session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 66;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento/Crear Categoría');



$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    //header('location:  ../vistas/menu_roles_vista.php');

    echo '<script type="text/javascript">
                              swal({
                                   title:"",
                                   text:"Lo sentimos no tiene permiso de visualizar la pantalla",
                                   type: "error",
                                   showConfirmButton: false,
                                   timer: 3000
                                });
                           window.location = "../vistas/menu_mantenimiento.php";

                            </script>';
} else {






    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_categoria'] = "";
    } else {
        $_SESSION['btn_guardar_categoria'] = "disabled";
    }
    /*

 if (isset($_REQUEST['msj']))
 {
      $msj=$_REQUEST['msj'];
        if ($msj==1)
            {
            echo '<script> alert("Lo sentimos el rol a ingresar ya existe favor intenta con uno nuevo")</script>';
            }
   
               if ($msj==2)
                  {
                  echo '<script> alert("Rol agregado correctamente")</script>';
                  }
 }

*/
}


ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
    <title></title>



</head>

<body>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Categoría</h1>
                    </div>



                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_mantenimiento.php">Menu Mantenimiento</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/mantenimiento_categorias_docente_vista.php"> Mantenimiento Categoría</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid ">
                <!-- pantalla 1 -->

                <form action="../Controlador/guardar_categoria_controlador.php" method="post" data-form="save" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h3 class="card-title">Nueva Categoría</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>


                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-md-6">
                                <div class="form-group ">
                                        <label>Ingrese la Categoría</label>
                                        <input class="form-control " type="text" id="txt_categoria1" name="txt_categoria1" required="" maxlength="30" style="text-transform: uppercase"onkeyup="DobleEspacio(this, event); MismaLetra('txt_categoria1');" onkeypress="return LetrasyNumeros(event)" onkeypress="return comprobar(this.value, event, this.id)">
                                    </div>

                                    <div class="form-group">
                                        <label>Descripción</label>
                                        <input class="form-control" type="text" id="txt_descripcion" name="txt_descripcion" required="" maxlength="30" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txt_descripcion');" onkeypress="return sololetras(event)"onkeypress="return comprobar(this.value, event, this.id)">
                                    </div>


                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_categoria" name="btn_guardar_categoria" <?php echo $_SESSION['btn_guardar_categoria']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
                                    </p>

                                </div>
                            </div>
                        </div>



                        <!-- /.card-body -->
                        <div class="card-footer">

                        </div>
                    </div>



                    <div class="RespuestaAjax"></div>
                </form>

            </div>
        </section>

    </div>





</body>

</html>
<script type="text/javascript" src="../js/funciones_registro_docentes.js"></script>
  <script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>