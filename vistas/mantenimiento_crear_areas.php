<?php
session_start();
ob_start();
require_once('../vistas/pagina_inicio_vista.php');
require_once('../clases/Conexion.php');
require_once('../clases/funcion_bitacora.php');
require_once('../clases/funcion_visualizar.php');
require_once('../clases/funcion_permisos.php');





$Id_objeto = 93;

bitacora::evento_bitacora($Id_objeto, $_SESSION['id_usuario'], 'Ingreso', 'A Mantenimiento/Crear Area');



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
                           window.location = "../vistas/menu_roles_vista.php";

                            </script>';
} else {






    if (permisos::permiso_insertar($Id_objeto) == '1') {
        $_SESSION['btn_guardar_area'] = "";
    } else {
        $_SESSION['btn_guardar_area'] = "disabled";
    }
}



ob_end_flush();


?>


<!DOCTYPE html>
<html>

<head>
    <script src="../js/autologout.js"></script>
    <title></title>



</head>

<body>


    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">


                        <h1>áreas para asignaturas</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="../vistas/pagina_principal_vista.php">Inicio</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/menu_mantenimiento_carga.php">Menú mantenimiento</a></li>
                            <li class="breadcrumb-item"><a href="../vistas/mantenimiento_area_vista.php"> Mantenimiento áreas</a></li>
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

                <form action="../Controlador/guardar_area_controlador.php" method="post" data-form="save" class="FormularioAjax" autocomplete="off">

                    <div class="card card-default ">
                        <div class="card-header center">
                            <h3 class="card-title">Nueva área</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="card-body ">
                            <div class="row">

                                <div class="col-md-3">
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group ">
                                        <label>Área</label>
                                        <input class="form-control" type="text" id="area_asignatura" name="area_asignatura" onkeyup="DobleEspacio(this, event); MismaLetra('area_asignatura');">
                                    </div>

                                    <div class="form-group ">
                                        <label>Descripción</label>
                                        <input class="form-control" type="text" id="descripcion_area" name="descripcion_area" onkeyup="DobleEspacio(this, event); MismaLetra('descripcion_area');">
                                    </div>

                                    <div class="form-group">
                                        <label>Ingrese la Carrera</label>
                                        <select class="form-control select2" type="text" id="cbm_carrera" name="cmb_carrera" style="width: 100%;">
                                            <option value="">Seleccione una opción</option>
                                        </select>
                                    </div>
                                    <input hidden class="form-control" id="carrera1" name="carrera1" value="0" readonly>



                                    <p class="text-center" style="margin-top: 20px;">
                                        <button type="submit" class="btn btn-primary" id="btn_guardar_area" name="btn_guardar_area" <?php echo $_SESSION['btn_guardar_area']; ?>><i class="zmdi zmdi-floppy"></i> Guardar</button>
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


<script type="text/javascript" language="javascript">
    function MismaLetra(id_input) {
        var valor = $('#' + id_input).val();
        var longitud = valor.length;
        //console.log(valor+longitud);
        if (longitud > 2) {
            var str1 = valor.substring(longitud - 3, longitud - 2);
            var str2 = valor.substring(longitud - 2, longitud - 1);
            var str3 = valor.substring(longitud - 1, longitud);
            nuevo_valor = valor.substring(0, longitud - 1);
            if (str1 == str2 && str1 == str3 && str2 == str3) {
                swal('Error', 'No se permiten 3 letras consecutivamente', 'error');

                $('#' + id_input).val(nuevo_valor);
            }
        }
    }

    function sololetras(e) {

        key = e.keyCode || e.wich;

        teclado = String.fromCharCode(key).toUpperCase();

        letras = " ABCDEFGHIJKLMNOPQRSTUVWXYZÑ";

        especiales = "8-37-38-46-164";

        teclado_especial = false;

        for (var i in especiales) {

            if (key == especiales[i]) {
                teclado_especial = true;
                break;
            }
        }

        if (letras.indexOf(teclado) == -1 && !teclado_especial) {
            return false;
        }

    }

    // llenar select nombre de plan
    function llenar_carrera() {
        var cadena = "&activar=activar";
        $.ajax({
            url: "../Controlador/plan_estudio_controlador.php?op=carreras",
            type: "POST",
            data: cadena,
            success: function(r) {
                $("#cbm_carrera").html(r).fadeIn();
                var o = new Option("SELECCIONAR", 0);


                $("#cbm_carrera").append(o);
                $("#cbm_carrera").val(0);

            },
        });
    }
    llenar_carrera();
    $('#cbm_carrera').change(function() {
        var carrera = $(this).val();
        console.log(carrera);
        $('#carrera1').val(carrera);
        if (carrera == 0) {
            alert("Seleccione una opción válida");
            document.getElementById("cbm_carrera").value = "";
        }
    });
</script>