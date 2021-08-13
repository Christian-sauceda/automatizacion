<?php
ob_start();
session_start();

require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');

//Lineas de msj al cargar pagina de acuerdo a actualizar o eliminar datos
if (isset($_REQUEST['msj'])) {
    $msj = $_REQUEST['msj'];

    if ($msj == 1) {
        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Lo sentimos el grado académico ya existe",
        type: "info",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
    }

    if ($msj == 2) {


        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Los datos  se almacenaron correctamente",
        type: "success",
        showConfirmButton: false,
        timer: 3000
    });
</script>';



        $sqltabla = "select grado_academico, descripcion
FROM tbl_grados_academicos";
        $resultadotabla = $mysqli->query($sqltabla);
    }
    if ($msj == 3) {


        echo '<script type="text/javascript">
    swal({
        title: "",
        text: "Error al actualizar lo sentimos,intente de nuevo.",
        type: "error",
        showConfirmButton: false,
        timer: 3000
    });
</script>';
    }
}


$Id_objeto = 61;
$visualizacion = permiso_ver($Id_objeto);



if ($visualizacion == 0) {
    // header('location:  ../vistas/menu_roles_vista.php');
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

    bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento Grado Académico');


    if (permisos::permiso_modificar($Id_objeto) == '1') {
        $_SESSION['btn_modificar_grado'] = "";
    } else {
        $_SESSION['btn_modificar_grado'] = "disabled";
    }


    /* Manda a llamar todos las datos de la tabla para llenar el gridview  */
    $sqltabla = "select grado_academico, descripcion FROM tbl_grados_academicos";
    $resultadotabla = $mysqli->query($sqltabla);



    /* Esta condicion sirve para  verificar el valor que se esta enviando al momento de dar click en el icono modicar */
    if (isset($_GET['grado_academico'])) {
        $sqltabla = "select grado_academico, descripcion           
FROM tbl_grados_academicos";
        $resultadotabla = $mysqli->query($sqltabla);

        /* Esta variable recibe el estado de modificar */
        $grado_academico = $_GET['grado_academico'];

        /* Iniciar la variable de sesion y la crea */
        /* Hace un select para mandar a traer todos los datos de la 
 tabla donde rol sea igual al que se ingreso en el input */
        $sql = "select * FROM tbl_grados_academicos WHERE grado_academico = '$grado_academico'";
        $resultado = $mysqli->query($sql);
        /* Manda a llamar la fila */
        $row = $resultado->fetch_array(MYSQLI_ASSOC);

        /* Aqui obtengo el id_estado_civil de la tabla de la base el cual me sirve para enviarla a la pagina actualizar.php para usarla en el where del update   */
        $_SESSION['id_grado_academico'] = $row['id_grado_academico'];
        $_SESSION['grado_academico'] = $row['grado_academico'];
        $_SESSION['descripcion'] = $row['descripcion'];


        /*Aqui levanto el modal*/

        if (isset($_SESSION['grado_academico'])) {


?>
            <script>
                $(function() {
                    $('#modal_modificar_grado_academico').modal('toggle')

                })
            </script>;

            <?php
            ?>

<?php


        }
    }
}

ob_end_flush();


?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../plugins/datatables/DataTables-1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel=" stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
    <title></title>
</head>


<body>

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>Grados Académicos Docentes
                        </h1>
                    </div>

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/menu_mantenimiento.php">Menu Mantenimiento</a></li>
                            <li class="breadcrumb-item active"><a href="../vistas/mantenimiento_crear_grados_academicos_vista.php">Nuevo Grado Academico</a></li>
                        </ol>
                    </div>

                    <div class="RespuestaAjax"></div>

                </div>
            </div><!-- /.container-fluid -->
        </section>


        <!--Pantalla 2-->

        <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">Grados Académicos Existentes</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                </div>
                <br>
                <div class=" px-12">
                    <!-- <button class="btn btn-success "> <i class="fas fa-file-pdf"></i> <a style="font-weight: bold;" onclick="ventana()">Exportar a PDF</a> </button> -->
                </div>
            </div>
            <div class="card-body">
                <div class="input-group">
                    <div class="col-md-3">
                        <div class="input-group mb-3 input-group" hidden>

                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group mb-3 input-group" hidden>

                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="input-group mb-3 input-group" hidden>

                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                            <input type="text" class="global_filter form-control" id="global_filter" placeholder="Ingresar dato a buscar" maxlength="30" onkeypress="return letrasynumeros(event)">
                        </div>

                    </div>
                </div>


                <table id="tabla9" class="table table-bordered table-striped">



                    <thead>
                        <tr>
                            <th>GRADO ACADÉMICO</th>
                            <th>DESCRIPCIÓN </th>
                            <th>MODIFICAR</th>
                            <th>ELIMINAR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultadotabla->fetch_array(MYSQLI_ASSOC)) { ?>
                            <tr>
                                <td><?php echo $row['grado_academico']; ?></td>
                                <td><?php echo $row['descripcion']; ?></td>

                                <td style="text-align: center;">

                                    <a href="../vistas/mantenimiento_grados_academicos_vista.php?grado_academico=<?php echo $row['grado_academico']; ?>" class="btn btn-primary btn-raised btn-xs">
                                        <i class="far fa-edit" style="display:<?php echo $_SESSION['modificar_grado_academico'] ?> "></i>
                                    </a>
                                </td>

                                <td style="text-align: center;">

                                    <form action="../Controlador/eliminar_grado_academico_controlador.php?grado_academico=<?php echo $row['grado_academico']; ?>" method="POST" class="FormularioAjax" data-form="delete" autocomplete="off">
                                        <button type="submit" class="btn btn-danger btn-raised btn-xs">

                                            <i class="far fa-trash-alt" style="display:<?php echo $_SESSION['eliminar_grado_academico'] ?> "></i>
                                        </button>
                                        <div class="RespuestaAjax"></div>
                                    </form>
                                </td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>


        <!-- /.card-body -->
        <div class="card-footer">

        </div>
    </div>





    <!-- *********************Creacion del modal 

-->

    <form action="../Controlador/actualizar_grado_academico_controlador.php?id_grado_academico=<?php echo $_SESSION['id_grado_academico']; ?>" method="post" data-form="update" autocomplete="off">



        <div class="modal fade" id="modal_modificar_grado_academico">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"> Actualizar Grado Académico</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>


                    <!--Cuerpo del modal-->
                    <div class="modal-body">





                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">

                                        <label>Modificar Grado Académico</label>


                                        <input class="form-control" type="text" id="txtgrado_academico" name="txtgrado_academico" value="<?php echo $_SESSION['grado_academico']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txtgrado_academico');" onkeypress="return sololetras(event)" maxlength="30">

                                    </div>


                                    <div class="form-group">
                                        <label class="control-label">Descripción</label>

                                        <input class="form-control" type="text" id="txtdescripcion" name="txtdescripcion" value="<?php echo $_SESSION['descripcion']; ?>" required style="text-transform: uppercase" onkeyup="DobleEspacio(this, event); MismaLetra('txtdescripcion');" onkeypress="return sololetras(event)" maxlength="30" onkeypress="return comprobar(this.value, event, this.id)">

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>




                    <!--Footer del modal-->
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" id="btn_modificar_grado" name="btn_modificar_grado" <?php echo $_SESSION['btn_modificar_grado']; ?>>Guardar Cambios</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- /.  finaldel modal -->

        <!--mosdal crear -->



    </form>
    <script type="text/javascript" language="javascript">
        function ventana() {
            window.open("../Controlador/reporte_mantenimiento_grados_academicos_controlador.php", "REPORTE");
        }
    </script>



  


</body>

</html>
<script src="../js/validaciones_plan.js"></script>
<script type="text/javascript" src="../js/funciones_registro_docentes.js"></script>
<script type="text/javascript" src="../js/validar_registrar_docentes.js"></script>

<script type="text/javascript" src="../js/pdf_mantenimientos.js"></script>
<script src="../plugins/select2/js/select2.min.js"></script>
<!-- datatables JS -->
<script type="text/javascript" src="../plugins/datatables/datatables.min.js"></script>
<!-- para usar botones en datatables JS -->
<script src="../plugins/datatables/Buttons-1.5.6/js/dataTables.buttons.min.js"></script>
<script src="../plugins/datatables/JSZip-2.5.0/jszip.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/pdfmake.min.js"></script>
<script src="../plugins/datatables/pdfmake-0.1.36/vfs_fonts.js"></script>
<script src="../plugins/datatables/Buttons-1.5.6/js/buttons.html5.min.js"></script>