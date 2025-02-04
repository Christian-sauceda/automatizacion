<?php

ob_start();


session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/conexion_mantenimientos.php');
$id_persona = "";
$id_persona = $_GET["id_persona"];
print_r($_GET);


ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>

  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <?php
  if (isset($_POST) && isset($_POST['id_asignatura'])) {
    echo '<script> mostrar(' . $_POST['id_asignatura'] . '); 
                  console.log("Hay Post");
            </script>';
    # code...
  }
  ?>
</head>

<body>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Asignar Docente Supervisor</h1>


          </div>



          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item "><a href="../vistas/menu_supervision_vista.php">Supervisión</a></li>
              </li>
            </ol>
          </div>

          <div class="RespuestaAjax"></div>

        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- pantalla 1 -->

        <form name="formulario" id="formulario" method="post" data-form="save" autocomplete="off" class="FormularioAjax">

          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title"></h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>

            <?php
            ?>
            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-group">
                    <input Type="hidden" name="id_supervisor" id="id_supervisor" value="<?php echo $id_persona ?>">
                    <label>Docente supervisor</label>
                    <select class="form-control" name="docente" id="docente" onchange="mostrar_asignados($('#txt_nombre_docente').val());">
                      <option value="" selected hidden>Seleccione</option>
                      <?php
                      $query = $mysqli->query("SELECT id_persona, CONCAT(nombres,' ', apellidos) nombres FROM tbl_personas WHERE id_tipo_persona = 1 AND Estado = 'ACTIVO'");
                      while ($valores = mysqli_fetch_array($query)) {
                        echo '<option value="' . $valores['id_persona'] . '">' . $valores['nombres'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                </div>

                <div class="col-md-2">
                  <div class="form-group">
                    <label>Estudiantes asignados al docente:</label>
                    <input class="form-control" readonly type="text" id="txt_asignados" name="txt_asignados">

                  </div>
                </div>


                <div class="col-md-2">
                  <div class="form-group" hidden>
                    <label>nombre docente:</label>
                    <input class="form-control" readonly type="text" id="txt_nombre_docente" name="txt_nombre_docente">

                  </div>
                </div>



                <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                  <button class="btn btn-primary" type="submit" id="btnGuardar" onclick="editar();"> Guardar</button>

                  <a href="../vistas/gestion_docente_supervisor_vista.php" class="btn btn-danger float-right ">Cancelar</a>
                </div>



        </form>

      </div>
    </section>


  </div>



</body>

</html>


<script type="text/javascript" src="../js/supervisiones/docente_supervisor.js"></script>