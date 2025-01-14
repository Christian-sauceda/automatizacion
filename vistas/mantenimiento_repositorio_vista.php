<?php

ob_start();
session_start();
require_once ('../vistas/pagina_inicio_vista.php');
require_once ('../clases/Conexion.php');

require_once ('../clases/funcion_bitacora.php');
require_once ('../clases/funcion_visualizar.php');
require_once ('../clases/funcion_permisos.php');

$Id_objeto=8222; 

 
$visualizacion= permiso_ver($Id_objeto);

if($visualizacion==0){
  echo '<script type="text/javascript">
      swal({
            title:"",
            text:"Lo sentimos no tiene permiso de visualizar la pantalla",
            type: "error",
            showConfirmButton: false,
            timer: 3000
          });
      window.location = "../vistas/menu_administracion_cve_vista.php";

       </script>'; 
}else{
  bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'],'INGRESO' , 'A Mantenimiento de repositorios');
}
if (permisos::permiso_insertar($Id_objeto)==0)
  {
  $_SESSION["btnagregar"]="disabled";
  }
else
  {
    $_SESSION["btnagregar"]="";
  }
ob_end_flush();
?>
<body oncopy="return false" onpaste="return false">
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">

         <h1>Mantenimiento Tipo De Repositorio</h1>
          </div>

                <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
              <li class="breadcrumb-item active"><a href="../vistas/menu_administracion_cve_vista.php">Administrar Módulo CVE</a></li>
            </ol>
          </div>

            <div class="RespuestaAjax"></div>
   
        </div>
      </div><!-- /.container-fluid -->
    </section>
<!--Contenido-->
      <!-- Content Wrapper. Contains page content -->
      <div class="card card-default">        
        <!-- Main content -->
        <section class="content">
            <div class="card-header">
              <div class="col-md-12">
                  <div class="box">
                    <div class="box-header with-border">
                          <h1><button class="btn btn-success" id="btnagregar" <?php echo $_SESSION['btnagregar']; ?> onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar Tipo Repositorio</button></h1>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <!-- centro -->
                    <div class="panel-body table-responsive" id="listadoregistros">
                        <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                          <thead>
                            <th>Opciones</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                          </thead>
                          <tbody>                            
                          </tbody>
                          
                        </table>
                    </div>
                    <div class="panel-body" style="height: 400px;" id="formularioregistros">
                        <!--AQUI INICIAL EL FORMULARIO-->
                        <form name="formulario" id="formulario" method="POST">
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Nombre:</label>
                            <input type="hidden" name="id_repositorio" id="id_repositorio">
                            
                            <!--CAJA DE TEXTO NOMBRE TREPOSITORIO-->
                            <input type="text" class="form-control" name="nombre_repositorio" id="nombre_repositorio" minlength="3" maxlength="50" placeholder="NOMBRE" style="text-transform: uppercase;" onkeypress="return soloLetras(event)" required/>
                          </div>
                          <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <label>Descripción:</label>
                            <!--CAJA DE TEXTO DESCRIPCION TREPOSITORIO-->
                            <input type="text" class="form-control" name="descripcion_repositorio" id="descripcion_repositorio" minlength="10" maxlength="255" placeholder="DESCRIPCION" style="text-transform: uppercase;" onkeypress="return soloLetras(event)" required/>
                          </div>
                          <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <button class="btn btn-primary" type="submit" id="btnGuardar"><i class="fa fa-save"></i> Guardar</button>

                            <button class="btn btn-danger" onclick="cancelarform()" type="button"><i class="fa fa-arrow-circle-left"></i> Cancelar</button>
                          </div>
                        </form>
                    </div>
                    <!--Fin centro -->
                  </div><!-- /.box -->
              </div><!-- /.col -->
          </div><!-- /.row -->
      </section><!-- /.content -->

    </div><!-- /.content-wrapper -->
</div>
<script src="../public/datatables/jszip.min.js"></script>
    

 <link rel="stylesheet" type="text/css" href="../public/DataTables-1.10.25/css/dataTables.bootstrap4.min.css"/>
<link rel="stylesheet" type="text/css" href="../public/Buttons-1.7.1/css/buttons.bootstrap4.min.css"/>
 
<script type="text/javascript" src="../public/pdfmake-0.1.36/pdfmake.min.js"></script>
<script type="text/javascript" src="../public/pdfmake-0.1.36/vfs_fonts.js"></script>
<script type="text/javascript" src="../public/DataTables-1.10.25/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../public/DataTables-1.10.25/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="../public/Buttons-1.7.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="../public/Buttons-1.7.1/js/buttons.bootstrap4.min.js"></script>
<script type="text/javascript" src="../public/Buttons-1.7.1/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="../js/repositorio.js"></script>
<script src="//cdn.jsdelivr.net/npm/promise-polyfill@8/dist/polyfill.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>



<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
  function soloLetras(e) {
    var key = e.keyCode || e.which,
      tecla = String.fromCharCode(key).toUpperCase(),
      letras = " ÀÈÌÒÙABCDEFGHIJKLMNÑOPQRSTUVWXYZ",
      especiales = [8, 37, 39, 46],
      tecla_especial = false;

    for (var i in especiales) {
      if (key == especiales[i]) {
        tecla_especial = true;
        break;
      }
    }

    if (letras.indexOf(tecla) == -1 && !tecla_especial) {
      return false;
    }
  }
</script>
</body>
</html>

