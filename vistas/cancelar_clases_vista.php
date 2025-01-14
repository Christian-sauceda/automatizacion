<?php
ob_start();
session_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

$Id_objeto = 33;
$visualizacion = permiso_ver($Id_objeto);
if ($visualizacion == 0) {
  echo '<script type="text/javascript">
  swal({
        title:"",
        text:"Lo sentimos no tiene permiso de visualizar la pantalla",
        type: "error",
        showConfirmButton: false,
        timer: 3000
      });
  window.location = "../vistas/pagina_principal_vista.php";

   </script>';
} else {
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'INGRESO', 'A SOLICITUD CANCELAR CLASES');
}

$sql = $mysqli->prepare("SELECT p.id_persona, p.nombres, p.apellidos, pe.valor
            FROM tbl_usuarios u, tbl_personas p,tbl_personas_extendidas pe
            WHERE u.id_persona = p.id_persona
            AND p.id_persona = pe.id_persona
            AND u.Usuario = ?");
$sql->bind_param("s", $_SESSION['usuario']);
$sql->execute();
$resultado = $sql->get_result();
$row = $resultado->fetch_array(MYSQLI_ASSOC);

ob_end_flush();



?>

<!DOCTYPE html>
<html>

<head>
  <script src="../js/autologout.js"></script>
  <title></title>
  <link rel="stylesheet" href="../plugins/toastr/toastr.min.css">
</head>

<body>


  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Solicitud Cancelación Excepcional de Clases</h1>
          </div>



          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item"><a href="../pdf/requisitos_cancelacion_excepcional.php" target="_blank">Requisitos</a></li>
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

        <form action="../Controlador/cancelar_clases_controlador.php" method="post" data-form="save" autocomplete="off" class="FormularioAjax">

          <div class="card card-default">
            <div class="card-header">
              <h3 class="card-title">Cancelar clases</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
              </div>
            </div>


            <!-- /.card-header -->
            <div class="card-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Nombre</label>
                    <input class="form-control" readonly onmousedown="return false;" type="text" id="txt_nombre" name="txt_nombre" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" value="<?php echo $row['nombres'] . ' ' . $row['apellidos']; ?>">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Verifiqué su Nombre</label>
                    <input class="form-control" type="text" id="txt_verificado1" name="txt_verificado1" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" placeholder="Colocar acentos en los nombres si los lleva">
                    <input class="form-control d-none " type="text" value="<?php echo $row['id_persona'] ?>" name="id_persona">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Verifiqué su Apellido</label>
                    <input class="form-control" type="text" id="txt_verificado2" name="txt_verificado2" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)" maxlength="50" placeholder="Colocar acentos en los apellidos si los lleva">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Número de Cuenta</label>
                    <input class="form-control" type="text" id="cuenta" name="txt_cuenta" onkeypress="return Numeros(event)" onkeyup="DobleEspacio(this, event)" maxlength="30">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Correo Electrónico Institucional</label>
                    <input class="form-control" type="email" id="correo" name="txt_correo" style="text-transform: uppercase" onkeyup="DobleEspacio(this, event)" maxlength="30">
                  </div>
                </div>
                <div class="alert alert-info alert-dismissible fade show  col-12" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>NOTA:</strong> LOS DOCUMENTOS ADJUNTOS TIENEN QUE SER EXTENSION PDF. EJEMPLO: <span> midocumento.pdf</span>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <label>Razón de Cancelación</label>
                    <textarea class="form-control" type="text" id="razon" name="txt_razon" style="text-transform: uppercase" onkeypress="return Letras(event)" onkeyup="DobleEspacio(this, event)"></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Solicitud de Cancelación</label>
                    <input class="form-control " type="file" id="solicitud" name="txt_solicitud">

                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Documento de soporte que justifica la cancelación</label>
                    <input class="form-control" type="file" id="constancia" name="txt_constancia">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Copia de tarjeta de identidad</label>
                    <input class="form-control" type="file" id="identidad" name="txt_identidad">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label>Copia de Forma 03</label>
                    <input class="form-control" type="file" id="forma" name="txt_forma">
                  </div>
                </div>

              </div>
              <p class="text-center form-group" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary " id="btn_cancelar_clases"><i class="zmdi zmdi-floppy"></i> Guardar</button>
              </p>
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

  <!-- <script type="text/javascript" language="javascript">
                    function ventana() {
                      window.location.href = "../vistas/historial_solicitudes_vista.php";
                    }
                  </script> -->

  <script>
    $('input[type="file"]').on('change', function() {
      var ext = $(this).val().split('.').pop();
      if ($(this).val() != '') {
        if (ext == "pdf" || ext == "PDF") {
          if ($(this)[0].files[0].size > 1048576) {
            swal({
              title: "",
              text: "excede el tamaño permitido...",
              type: "error",
              showConfirmButton: false,
              timer: 2000
            });

            $(this).val('');
          }
        } else {
          $(this).val('');
          swal({
            title: "",
            text: "Extensión no permitida: " + ext,
            type: "error",
            showConfirmButton: false,
            timer: 2000
          });
        }
      }
    });
  </script>
  <script src="../plugins/toastr/toastr.min.js"></script>
  <script src="../js/Validaciones_solicitudes.js"></script>
</body>

</html>