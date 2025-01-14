<?php

require_once("../Controlador/db.php");
$db = new db;

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
//!modificacion 1/8/2021 ----------------------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

if (isset($_POST['add_info'])) {

    // //?archivo coordinacion academica
    $nombreArchivo_ca = $_FILES['file_ca']['name'];
    $nombreTemp_ca = $_FILES['file_ca']['tmp_name']; //ruta del archivo a validar formato correcto
    $fileError_ca = $_FILES['file_ca']['error']; //!errores

    ////?arhivo craed
    $nombreArchivo_cr = $_FILES['file_cr']['name'];
    $nombreTemp_cr = $_FILES['file_cr']['tmp_name'];
    $fileError_cr = $_FILES['file_cr']['error']; //!errores


    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($nombreTemp_ca);
    $data = $spreadsheet->getActiveSheet(0);
    $valor = $spreadsheet->getActiveSheet()->getCell('A3')->getValue();

    if ($valor != "N# Empleado") {
        echo json_encode('cr_incorrecto');
    } else {
        $spreadsheet2 = \PhpOffice\PhpSpreadsheet\IOFactory::load($nombreTemp_cr);
        $data2 = $spreadsheet2->getActiveSheet(0);
        $valor2 = $spreadsheet2->getActiveSheet()->getCell('A1')->getValue();
        if ($valor2 != "cuenta") {
            echo json_encode('cread_invalido');
        } else {
            //echo json_encode('Ambos_validos');
            //!moviendo primer archivo 
            $fileExt = explode('.', $nombreArchivo_ca);
            $fileActualExt = strtolower(end($fileExt));
            $fileNewNombre_ca = uniqid('', true) . "." . $fileActualExt;
            $ruta = "../archivos/file_academica/" . $fileNewNombre_ca;
            move_uploaded_file($nombreTemp_ca, $ruta);
            //!fin primer archivo

            //!moviendo segundo archivo
            $fileExt_cr = explode('.', $nombreArchivo_cr);
            $fileActualExt_cr = strtolower(end($fileExt_cr));
            $fileNewNombre_cr = uniqid('', true) . "." . $fileActualExt_cr;
            $ruta2 = "../archivos/file_craed/" . $fileNewNombre_cr;
            move_uploaded_file($nombreTemp_cr, $ruta2);
            //!fin segundo archivo

            //?datos del form
            $periodo_ca = $_POST['periodo_ca'];
            $descrip_ca = $_POST['descrp_ca'];
            $nombre_archivo = $fileNewNombre_ca;
            $fecha = $_POST['txt_fecha_ingreso_ca'];

            $periodo_cr = $_POST['periodo_cr'];
            $descripcion_cr = $_POST['descrip_cr'];
            $nombre_archivo_cr = $fileNewNombre_cr;
            $fecha_cr = $_POST['txt_fecha_ingreso_cr'];
            //?fin datos del form

            //$respuesta = $db->addfileAcademica($periodo_ca, $descrip_ca, $nombre_archivo, $fecha, $periodo_cr, $descripcion_cr, $nombre_archivo_cr, $fecha_cr);
            $id_ca = $db->addfileAcademica($periodo_ca, $descrip_ca, $nombre_archivo, $fecha);
            $id_cr = $db->subir_craed($periodo_cr, $descripcion_cr, $nombre_archivo_cr, $fecha_cr);
            //echo json_encode($respuesta_ca);
            //print_r($respuesta_ca . ' ' . $respuesta_cr);
            if ($id_ca <= 0 or $id_cr <= 0) {
                echo json_encode('error');
            } else {
                subirBase_academica($nombre_archivo, $id_ca);
                subirBase_craed($nombre_archivo_cr, $id_cr);
                echo json_encode('exito');
            }
        }
    }
}
//?funcion para subir el archivo de academica 
function subirBase_academica($nombre_archivo, $id_ca)
{
    require("../clases/Conexion.php");
    //$nombre_archivo = $_POST['nombre_archivo1'];
    //$id = $_POST['id_archivo'];

    // $respuesta = $db->contarArchivo($id);
    // $cantidad = $respuesta['cuenta'];
    //$conexion = new mysqli('localhost', 'root', '', 'informat_desarrollo_automatizacion');
    //$conexion = new mysqli('51.222.86.251', 'informat_desarrollo', '^Kwd{PE^(L&#', 'informat_desarrollo_automatizacion');
    //$ruta = '../archivos/file_academica/' . $nombre_archivo;
    class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
    {

        public function readCell($column, $row, $worksheetName = '')
        {
            if ($row > 3) {
                return true;
            }
            return false;
        }
    }
    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    $inputFileName = '../archivos/file_academica/' . $nombre_archivo;

    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

    $reader->setReadFilter(new MyReadFilter());
    $spreadsheet = $reader->load($inputFileName);
    $cantidad = $spreadsheet->getActiveSheet()->toArray();


    foreach ($cantidad as $row) {
        if ($row[0] != "") {
            array_push($row, $id_ca);
            // $consulta = "INSERT INTO `academica_prueba_1`(`n_empleado`, `nombre`, `codigo`, `aignatura`, `unidades_valorativas`, `seccion`, `hi`, `hf`, `dia`, `aula`, `edificio`, `n_alumnos`, `control`, `modalidad`)
            // VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]')";
            // $consulta = " INSERT INTO `tbl_carga_academica_temporal`(`N_empleado`, `Nombre`, `Codigo`, `Asignatura`, `UV`, `Seccion`, `HI`, `HF`, `Dias`, `Aula`, `Edificio`, `N_Alumnos`, `N_Control`, `Modalidad`,`id_coordAcademica`)
            //VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]')";

            $sql = "INSERT INTO `tbl_carga_academica_temporal`(`N_empleado`, `Nombre`, `Codigo`, `Asignatura`, `UV`, `Seccion`, `HI`, `HF`, `Dias`, `Aula`, `Edificio`, `N_Alumnos`, `N_Control`, `Modalidad`,`id_coordAcademica`)
            VALUES('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]')";
            $resultado = $mysqli->query($sql);
            // $consulta = "INSERT INTO `tbl_carga_academica_temporal`(`N_empleado`, `Nombre`, `Codigo`, `Asignatura`, `UV`, `Seccion`, `HI`, `HF`, `Dias`, `Aula`, `Edificio`, `N_Alumnos`, `N_Control`, `Modalidad`,`id_coordAcademica`)
            // VALUES('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]')";
            // $resultado = $conexion->query($consulta);
        }
    }
    //echo json_encode('exito');
}
//?fin funcion para subir el archivo academica


//?subir archivo de craed
function subirBase_craed($nombre_archivo_cr, $id_cr)
{
    require('../clases/Conexion.php');
    //$conexion = new mysqli('localhost', 'root', '', 'informat_desarrollo_automatizacion');
    //$conexion = new mysqli('51.222.86.251', 'informat_desarrollo', '^Kwd{PE^(L&#', 'informat_desarrollo_automatizacion');
    class MyReadFilte implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
    {
        public function readCell($column, $row, $worksheetName = '')
        {
            if ($row > 2) {
                return true;
            }
            return false;
        }
    }

    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
    $inputFileName = '../archivos/file_craed/' . $nombre_archivo_cr;

    $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

    $reader->setReadFilter(new MyReadFilter());
    $spreadsheet = $reader->load($inputFileName);
    $cantidad = $spreadsheet->getActiveSheet()->toArray();


    foreach ($cantidad as $row) {
        if ($row[0] != "") {
            array_push($row, $id_cr);
            // $consulta = "INSERT INTO `academica_prueba_1`(`n_empleado`, `nombre`, `codigo`, `aignatura`, `unidades_valorativas`, `seccion`, `hi`, `hf`, `dia`, `aula`, `edificio`, `n_alumnos`, `control`, `modalidad`)
            // VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]')";
            // $consulta = " INSERT INTO `tbl_carga_craed`(`Seleccionar`, `N_Control_cr`, `Centro_cr`, `Codigo_cr`, `Asignatura_cr`, `Seccion_cr`, `Periodo`, `HI_cr`, `HF_cr`, `Dias_cr`, `Aula_cr`, `Edificio_cr`, `Numero`, `Profesor`, `Autorizacion`, `Cupos`, `Cupos_libres`, `Lista_espera`, `Semana`, `En_linea`, `Por_egresar`, `En_Red`, 'id_craed_jefa')
            // VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]', '$row[15]', '$row[16]', '$row[17]','$row[18]', '$row[19]','$row[20]','$row[21]','$row[22]')";

            // $sql = "INSERT INTO `tbl_carga_craed`(`Seleccionar`, `N_Control_cr`, `Centro_cr`, `Codigo_cr`, `Asignatura_cr`, `Seccion_cr`, `Periodo`, `HI_cr`, `HF_cr`, `Dias_cr`, `Aula_cr`, `Edificio_cr`, `Numero`, `Profesor`, `Autorizacion`, `Cupos`, `Cupos_libres`, `Lista_espera`, `Semana`, `En_linea`, `Por_egresar`, `En_Red`, `id_craed_jefa`)
            // VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]','$row[15]', '$row[16]','$row[17]', '$row[18]', '$row[19]', '$row[20]','$row[21]', '$row[22]')";
            $sql = "INSERT INTO `tbl_carga_craed`(`Centro_cr`, `Codigo_cr`, `Asignatura_cr`, `Seccion_cr`,`HI_cr`, `HF_cr`, `Dias_cr`, `Numero`, `Profesor`, `Cupos`, `Cupos_libres`, `Lista_espera`, `Semana`,`Por_egresar`,`id_craed_jefa`)
            VALUES('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]')";
            $resultado = $mysqli->query($sql);
            // $consulta =  "INSERT INTO `tbl_carga_craed`(`Seleccionar`, `N_Control_cr`, `Centro_cr`, `Codigo_cr`, `Asignatura_cr`, `Seccion_cr`, `Periodo`, `HI_cr`, `HF_cr`, `Dias_cr`, `Aula_cr`, `Edificio_cr`, `Numero`, `Profesor`, `Autorizacion`, `Cupos`, `Cupos_libres`, `Lista_espera`, `Semana`, `En_linea`, `Por_egresar`, `En_Red`, `id_craed_jefa`)
            // VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]','$row[15]', '$row[16]','$row[17]', '$row[18]', '$row[19]', '$row[20]','$row[21]', '$row[22]')";
            // $resultado = $conexion->query($consulta);
            //print_r($row);

        }
    }
    //    echo $resultado;      
    //echo json_encode('archivo_subidoCR');
}
//fin subir archivo de craed

//!fin modificacion 1/08/2021 ----------------------------------------------------->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

if (isset($_POST['reac_cliente'])) {

    $id_cliente = $_POST['id_cliente'];
    $respuesta = $db->getDatosReac($id_cliente);
    echo json_encode($respuesta);
}

//?modificacion 29/07/2021

if (isset($_POST['denegada'])) {
    $razon_minu = $_POST['razon_negada'];
    $razon_mayus = strtoupper($razon_minu);
    $id_cliente = $_POST['id_cliente'];
    $respuesta = $db->updateSolicitudDenegada($id_cliente, $razon_mayus);
    echo json_encode($respuesta);
}
//?fin modificacion 29/07/2021

if (isset($_POST['aceptada'])) {
    $id_cliente = $_POST['id_cliente'];
    $respuesta = $db->updateSolicitudAceptada($id_cliente);
    echo json_encode($respuesta);
}

if (isset($_POST['ver_excel_ca'])) {

    $nombre_archivo = $_POST['nombre_archivo'];
    print_r('<label>' . $nombre_archivo . '</label>');
    $ruta_archivo_excel = '../archivos/file_academica/' . $nombre_archivo;


    //$ruta = 'craed.xlsx';
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
    $spreadsheet = $reader->load($ruta_archivo_excel);
    //establecer en que hoja se trabajara
    $sheet = $spreadsheet->getActiveSheet(0); // se espcifica en que hoja se quiere trabajar
    $value = $spreadsheet->getActiveSheet()->getCell('A3')->getValue(); //especifica el valor especifico del archivo a subir


    echo '<table class="table table-bordered table-striped mb-0" >';
    foreach ($sheet->/*getRowIterator(3)*/getRowIterator(3)  as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        echo '<tr>';
        foreach ($cellIterator as $cell) {
            if (!is_null($cell)) {
                //$value = $cell->getCalculatedValue();
                $value = $cell->getValue();
                echo '<td>' . $value . '</td>';
            }
        }
        echo '</tr>';
    }
    echo '</table>';
}

if (isset($_POST['ver_excel_cr'])) {
    $nombre_archivo = $_POST['nombre_archivo_cr'];
    print_r('<label>' . $nombre_archivo . '</label>');
    $ruta_archivo_excel = '../archivos/file_craed/' . $nombre_archivo;


    //$ruta = 'craed.xlsx';
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
    $spreadsheet = $reader->load($ruta_archivo_excel);
    //establecer en que hoja se trabajara
    $sheet = $spreadsheet->getActiveSheet(0); // se espcifica en que hoja se quiere trabajar
    $value = $spreadsheet->getActiveSheet()->getCell('A4')->getValue(); //especifica el valor especifico del archivo a subir


    echo '<table class="table table-bordered table-striped mb-0" >';
    foreach ($sheet->/*getRowIterator(3)*/getRowIterator(4)  as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(false);
        echo '<tr>';
        foreach ($cellIterator as $cell) {
            if (!is_null($cell)) {
                //$value = $cell->getCalculatedValue();
                $value = $cell->getValue();
                echo '<td>' . $value . '</td>';
            }
        }
        echo '</tr>';
    }
    echo '</table>';
}

//aqui recursos
if (isset($_POST['tipo_recursos'])) {
    $estado = 'Activo';
    $descripcion = $_POST['descripcion'];
    $fecha = $_POST['fecha_recurso'];
    $nombre_recurso = $_POST['nombre_recurso'];
    $respuesta = $db->newTipoRecurso($descripcion, $fecha, $nombre_recurso, $estado);
    echo json_encode($respuesta);
}

if (isset($_POST['eliminar_recurso'])) {
    //echo json_encode($_POST);
    $id_recurso = $_POST['id'];
    $rspuesta = $db->EliminarRecurso($id_recurso);
    echo json_encode($rspuesta);
}

// if (isset($_POST['eliminar_recurso'])) {
//     $id = $_POST['id'];
//     $respuesta = $db->eliminarRecurso($id);
//     echo json_encode($respuesta);
// }
//!este es del tipo de recursos por la consulta a la BD
if (isset($_POST['cambiar_estado'])) {
    $estado = $_POST['estado'];
    $id = $_POST['id'];
    if ($estado == 'Activo') {
        $nuevo_estado = 'Inactivo';
        $respuesta = $db->cambiarEstado($id, $nuevo_estado);
        echo json_encode($respuesta);
    } else if ($estado == 'Inactivo') {
        $nuevo_estado = 'Activo';
        $respuesta = $db->cambiarEstado($id, $nuevo_estado);
        echo json_encode($respuesta);
    }
}
//!este es del tipo de recursos por la consulta a la BD
//termina recursos.

//aqui gastos
if (isset($_POST['agregar_tipo_gasto'])) {

    $descrip = $_POST['descripcion'];
    $estado = "Activo";
    $fecha = $_POST['fecha_gasto'];
    $nombre_gasto = $_POST['nombre_gasto'];

    $respuesta = $db->insertTipoGasto($descrip, $estado, $fecha, $nombre_gasto);
    echo json_encode($respuesta);
    //echo json_encode($_POST);
}

//eliminar el gasto
if (isset($_POST['eliminar_gastosV2'])) {
    $id = $_POST['id'];
    $respuesta = $db->eliminarGastos($id);
    echo json_encode($respuesta);
}
//!cambiar estado de gastos, este es pra los gastos.

if (isset($_POST['cambiar_estado_gastosV2'])) {
    $estado = $_POST['estado'];
    $id = $_POST['id'];
    if ($estado == 'Activo') {
        $nuevo_estado = 'Inactivo';
        $respuesta = $db->cambiarEstadog($id, $nuevo_estado);
        echo json_encode($respuesta);
    } else if ($estado == 'Inactivo') {
        $nuevo_estado = 'Activo';
        $respuesta = $db->cambiarEstadog($id, $nuevo_estado);
        echo json_encode($respuesta);
    }
}
//fin de los datos de gastos
//aqui empieza ind
if (isset($_POST['agregar_tipo_indicador'])) {

    $descripcion = $_POST['descripcion'];
    $estado = "Activo";
    $fecha = $_POST['fecha_indicador'];
    $nombre_indicador = $_POST['nombre_indicador'];

    $respuesta = $db->insertTipoIndicador($descripcion, $estado, $fecha, $nombre_indicador);
    echo json_encode($respuesta);
    //echo json_encode($_POST);
}

//eliminar para indicadores
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    $respuesta = $db->eliminarGestion($id);
    echo json_encode($respuesta);
}

//!cambiar estado para indicadores 
if (isset($_POST['cambiar_estado_indicador'])) {

    $estado = $_POST['estado'];
    $id = $_POST['id'];
    if ($estado == 'Activo') {
        $nuevo_estado = 'Inactivo';
        $respuesta = $db->cambiarEstadogg($id, $nuevo_estado);
        echo json_encode($respuesta);
    } else if ($estado == 'Inactivo') {
        $nuevo_estado = 'Activo';
        $respuesta = $db->cambiarEstadogg($id, $nuevo_estado);
        echo json_encode($respuesta);
    }


    // if ($estado == 'Activo') {
    //     $nuevo_estado = 'Inactivo';
    //     $respuesta = $db->cambiarEstadogg($id, $nuevo_estado);
    //     echo json_encode($respuesta);
    // } else if ($estado == 'Inactivo') {
    //     $nuevo_estado = 'Activo';
    //     $respuesta = $db->cambiarEstadogg($id, $nuevo_estado);
    //     echo json_encode($respuesta);
    //}
    //echo json_encode($_POST);
}
//!fin datos de indicadores de gestion de estado

// if (isset($_POST['subir_excel_ca'])) {
//     $nombre_archivo = $_POST['nombre_archivo1'];
//     $id = $_POST['id_archivo'];

//     $respuesta = $db->contarArchivo($id);
//     $cantidad = $respuesta['cuenta'];

//     if ($cantidad >= 1) {
//         echo json_encode('archivo_subido');
//     } else {
//         $conexion = new mysqli('51.222.86.251', 'informat_desarrollo', '^Kwd{PE^(L&#', 'informat_desarrollo_automatizacion');
//         //$ruta = '../archivos/file_academica/' . $nombre_archivo;

//         class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
//         {

//             public function readCell($column, $row, $worksheetName = '')
//             {
//                 if ($row > 3) {
//                     return true;
//                 }
//                 return false;
//             }
//         }

//         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
//         $inputFileName = '../archivos/file_academica/' . $nombre_archivo;

//         $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

//         $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

//         $reader->setReadFilter(new MyReadFilter());
//         $spreadsheet = $reader->load($inputFileName);
//         $cantidad = $spreadsheet->getActiveSheet()->toArray();


//         foreach ($cantidad as $row) {
//             if ($row[0] != "") {
//                 array_push($row, $id);
//                 // $consulta = "INSERT INTO `academica_prueba_1`(`n_empleado`, `nombre`, `codigo`, `aignatura`, `unidades_valorativas`, `seccion`, `hi`, `hf`, `dia`, `aula`, `edificio`, `n_alumnos`, `control`, `modalidad`)
//                 // VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]')";
//                 // $consulta = " INSERT INTO `tbl_carga_academica_temporal`(`N_empleado`, `Nombre`, `Codigo`, `Asignatura`, `UV`, `Seccion`, `HI`, `HF`, `Dias`, `Aula`, `Edificio`, `N_Alumnos`, `N_Control`, `Modalidad`,`id_coordAcademica`)
//                 //VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]')";


//                 $consulta = "INSERT INTO `tbl_carga_academica_temporal`(`N_empleado`, `Nombre`, `Codigo`, `Asignatura`, `UV`, `Seccion`, `HI`, `HF`, `Dias`, `Aula`, `Edificio`, `N_Alumnos`, `N_Control`, `Modalidad`,`id_coordAcademica`)
//             VALUES('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]')";
//                 $resultado = $conexion->query($consulta);
//             }
//         }
//         echo json_encode('exito');
//     }
// }

// if (isset($_POST['subir_excel_cr'])) {
//     $nombre_archivo = $_POST['nombre_archivo_cr'];
//     $id = $_POST['id_archivo_cr'];

//     $respuesta = $db->contarArchivoCR($id);
//     $cantidad = $respuesta['cuenta'];

//     if ($cantidad >= 1) {
//         echo json_encode('archivo_subidoCR');
//     } else {
//         $conexion = new mysqli('51.222.86.251', 'informat_desarrollo', '^Kwd{PE^(L&#', 'informat_desarrollo_automatizacion');


//         //$ruta = '../archivos/file_academica/' . $nombre_archivo;

//         class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
//         {

//             public function readCell($column, $row, $worksheetName = '')
//             {
//                 if ($row > 4) {
//                     return true;
//                 }
//                 return false;
//             }
//         }

//         $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
//         $inputFileName = '../archivos/file_craed/' . $nombre_archivo;

//         $inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);

//         $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

//         $reader->setReadFilter(new MyReadFilter());
//         $spreadsheet = $reader->load($inputFileName);
//         $cantidad = $spreadsheet->getActiveSheet()->toArray();


//         foreach ($cantidad as $row) {
//             if ($row[0] != "") {
//                 array_push($row, $id);
//                 // $consulta = "INSERT INTO `academica_prueba_1`(`n_empleado`, `nombre`, `codigo`, `aignatura`, `unidades_valorativas`, `seccion`, `hi`, `hf`, `dia`, `aula`, `edificio`, `n_alumnos`, `control`, `modalidad`)
//                 // VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]')";
//                 // $consulta = " INSERT INTO `tbl_carga_craed`(`Seleccionar`, `N_Control_cr`, `Centro_cr`, `Codigo_cr`, `Asignatura_cr`, `Seccion_cr`, `Periodo`, `HI_cr`, `HF_cr`, `Dias_cr`, `Aula_cr`, `Edificio_cr`, `Numero`, `Profesor`, `Autorizacion`, `Cupos`, `Cupos_libres`, `Lista_espera`, `Semana`, `En_linea`, `Por_egresar`, `En_Red`, 'id_craed_jefa')
//                 // VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]', '$row[15]', '$row[16]', '$row[17]','$row[18]', '$row[19]','$row[20]','$row[21]','$row[22]')";

//                 $consulta =  "INSERT INTO `tbl_carga_craed`(`Seleccionar`, `N_Control_cr`, `Centro_cr`, `Codigo_cr`, `Asignatura_cr`, `Seccion_cr`, `Periodo`, `HI_cr`, `HF_cr`, `Dias_cr`, `Aula_cr`, `Edificio_cr`, `Numero`, `Profesor`, `Autorizacion`, `Cupos`, `Cupos_libres`, `Lista_espera`, `Semana`, `En_linea`, `Por_egresar`, `En_Red`, `id_craed_jefa`)
//         VALUES ('$row[0]', '$row[1]','$row[2]', '$row[3]','$row[4]', '$row[5]', '$row[6]', '$row[7]','$row[8]', '$row[9]','$row[10]', '$row[11]','$row[12]', '$row[13]', '$row[14]','$row[15]', '$row[16]','$row[17]', '$row[18]', '$row[19]', '$row[20]','$row[21]', '$row[22]')";
//                 $resultado = $conexion->query($consulta);
//                 //print_r($row);

//             }
//         }
//         //    echo $resultado;
//         echo json_encode('exito');
//     }
// }



//empieza poa
if (isset($_POST['enviar_retro'])) {
    $id_retro = $_POST['id_retro'];
    $respuesta = $db->retro($id_retro);
    echo json_encode($respuesta);
}

if (isset($_POST['crear_plani'])) {

    $nombre = $_POST['n_planificacion'];
    $descripcion = $_POST['descripcion'];
    $anio = $_POST['txt_fecha_ingreso_ca'];
    $año_actual = date('Y');
    if ($anio < $año_actual) {
        echo json_encode('anio_viejo');
    } else {
        $respuesta = $db->addPlanificaion($nombre, $descripcion, $anio);
        echo json_encode($respuesta);
    }
}

if (isset($_POST['crear_obj'])) {

    $nombre_objetivo = $_POST['n_objetivo'];
    $descripcion = $_POST['obj_descripción'];
    $id_planificacion = $_POST['id_plani'];

    $respuesta = $db->addObjetivo($nombre_objetivo, $descripcion, $id_planificacion);
    echo json_encode($respuesta);
}

if (isset($_POST['obj_delete'])) {

    $id = $_POST['id_delete'];
    $respuesta = $db->deleteObj($id);
    echo json_encode($respuesta);
}

if (isset($_POST['new_indicador'])) {
    $descripcion = $_POST['ind_indicador'];
    $resultados = $_POST['ind_resultado'];
    $id_objetivo = $_POST['id_objetivo'];
    $respuesta = $db->new_indicador($descripcion, $resultados, $id_objetivo);
    echo json_encode($respuesta);
}


if (isset($_POST['delete_plani'])) {

    $id_planificacion = $_POST['id_plan'];
    $resultado = $db->deletePlan($id_planificacion);
    echo json_encode($resultado);
}

if (isset($_POST['edit_form_plan'])) {

    $id_plan  = $_POST['id_plani_edit'];
    $descripcion = $_POST['descripcion'];
    $anio = $_POST['txt_fecha_ingreso_ca'];
    $nombre_plan = $_POST['n_planificacion'];

    $respuesta = $db->editPlan($id_plan, $descripcion, $anio, $nombre_plan);
    echo json_encode($respuesta);
}

if (isset($_POST['edicion_obj_edit'])) {

    $id_objetivo = $_POST['id_objetivo_edit'];
    $nombre_objetivo = $_POST['n_objetivo'];
    $descripcion = $_POST['obj_descripción'];
    $respuesta = $db->editObj($id_objetivo, $nombre_objetivo, $descripcion);
    echo json_encode($respuesta);
}

if (isset($_POST['indicador_delete'])) {

    $id_indicador = $_POST['id_indicador'];
    $respuesta = $db->delete_Indicador($id_indicador);
    echo json_encode($respuesta);
}

if (isset($_POST['edit_indicador'])) {

    $id_indicador = $_POST['id_indicador_edit'];
    $descripcion = $_POST['ind_indicador'];
    $resultados = $_POST['ind_resultado'];
    $mensaje = $db->edit_indicador($id_indicador, $descripcion, $resultados);
    echo json_encode($mensaje);
}

if (isset($_POST['get_data_res'])) {

    $id_indicador = $_POST['id_indicador'];
    $respuesta = $db->get_data_responsables($id_indicador);
    echo json_encode($respuesta);
}

if (isset($_POST['add_res'])) {

    $responsable = $_POST['responsable_rs'];
    $id_indicador = $_POST['id_indicador_res'];
    $respuesta = $db->insert_responsable($id_indicador, $responsable);
    echo json_encode($respuesta);
}

//!obtener data de las actividades
if (isset($_POST['getdata_Act'])) {

    $id_indicador = $_POST['id_indicador_act'];
    $respuesta = $db->getData_actividades($id_indicador);
    echo json_encode($respuesta);
}
//! fin obtener data de las actividades

//!guardar data de las actividades
if (isset($_POST['send_data_act'])) {
    $id_indicador = $_POST['id_indicador_act'];
    $nombre_actividad = $_POST['n_actividad'];

    $id_actividad = $db->guardar_actividad($nombre_actividad, $id_indicador);


    $verificacion = $_POST['m_verificacion'];
    $id_med_ver = $db->guardar_medioVerificacion($verificacion);



    $poblacion = $_POST['p_objetivo'];
    $id_poblacion = $db->add_poblacion_objetivo($poblacion);


    $actividad_verificacion = $db->add_actividad_verificacion($id_actividad, $id_med_ver);
    $actividad_poblacion = $db->add_actividad_poblacion($id_poblacion, $id_actividad);

    if ($actividad_verificacion = 'exito' and $actividad_poblacion = 'exito') {
        echo json_encode('exito');
    } else {
        echo json_encode('error');
    }
}
//!fin guardar data de las actividades

//! INICIO obtener la data de las metas_smart

if (isset($_POST['getData_metas'])) {

    $id_indicador_meta = $_POST['id_indicador_meta'];
    $respuesta = $db->getData_Metas($id_indicador_meta);
    echo json_encode($respuesta);
    //echo json_encode($_POST);
}

if (isset($_POST['addNew_meta'])) {

    $id_indicador = $_POST['id_indicador_meta'];
    $primer_trimestre = $_POST['primer_trimestre'];
    $segundo_trimestre = $_POST['segundo_trimestre'];
    $tercer_trimestre = $_POST['tercer_trimestre'];
    $cuarto_trimestre = $_POST['cuarto_trimestre'];

    if ($primer_trimestre == null) {
        $primer_trimestre = 0;
    } else {
        $primer_trimestre = $primer_trimestre;
    }

    if ($segundo_trimestre == null) {
        $segundo_trimestre = 0;
    } else {
        $segundo_trimestre = $segundo_trimestre;
    }

    if ($tercer_trimestre == null) {
        $tercer_trimestre = 0;
    } else {
        $tercer_trimestre = $tercer_trimestre;
    }

    if ($cuarto_trimestre == null) {
        $cuarto_trimestre = 0;
    } else {
        $cuarto_trimestre = $cuarto_trimestre;
    }


    $total = $primer_trimestre + $segundo_trimestre + $tercer_trimestre + $cuarto_trimestre;
    if ($total > 100) {
        echo json_encode('cuenta_mayor');
    } else if ($total < 100) {
        echo json_encode('menor_cuenta');
    } else {
        $conteo = $db->contar_metas($id_indicador);
        $conteo_total = $conteo['total'];
        if ($conteo_total >= 1) {
            echo json_encode('tiene_datos');
        } else {
            //echo json_encode('no tiene datos');
            //insertar datos
            $respuesta = $db->insertData_metas($primer_trimestre, $segundo_trimestre, $tercer_trimestre, $cuarto_trimestre, $id_indicador);
            echo json_encode($respuesta);
        }
    }
    //echo json_encode($_POST);
}
//! FIN obtener data de las metas

//?INICIO eliminacion de responsable
if (isset($_POST['dele_responsable'])) {

    $id_responsable = $_POST['id_responsable'];
    $respuesta = $db->delete_responsable($id_responsable);
    echo json_encode($respuesta);
}
//?fin eliminacion de responsable

//?eliminacion de una actividades
if (isset($_POST['dele_actividad'])) {

    $id_actividad = $_POST['id_actividad'];
    $respuesta = $db->delete_actividad($id_actividad);
    echo json_encode($respuesta);
}
//?fin eliminacion de responsable

//?inciio elliminacion de meta
if (isset($_POST['dele_meta'])) {

    $id_meta = $_POST['id_meta'];
    $respuesta = $db->delete_meta($id_meta);
    echo json_encode($respuesta);
}

//?fin eliminacion de meta

//* start obtener detalle de poa

if (isset($_POST['get_detalle_poa'])) {

    $id_planificacion = $_POST['id_planificacion'];
    $salida = $db->get_data($id_planificacion);

    $count = count($salida);
    for ($i = 0; $i < $count; $i++) {
        printf($salida[$i]['id_objetivo'] . ';');
    }
}


//* FIN obtener detalle de poa


//!obetner detalles de tipo_recursos

if (isset($_POST['getDataRecursos'])) {
    $respuesta = $db->getDataTipo_recurso();
    echo json_encode($respuesta);
}

if (isset($_POST['addData_r_detalle'])) {

    $nombre = $_POST["nombre_detalle_r"];
    $cantidad = $_POST["cantidad_detalle"];
    $descripcion = $_POST["descp_detalle"];
    $precio_aprox = $_POST["precio_detalle"];
    $id_recurso_tipo = $_POST["valor_select"];
    $rspuesta = $db->insertar_detalle($nombre, $cantidad, $descripcion, $precio_aprox, $id_recurso_tipo);
    echo json_encode($rspuesta);
}
//eliminar para detalle recursos
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    $respuesta = $db->eliminarGestion_recursos($id);
    echo json_encode($respuesta);
}
//!obetner detalles de id_detalles_tipo_indicador

if (isset($_POST['getDataIndicador'])) {
    $respuesta = $db->getDataTipo_indicador();
    echo json_encode($respuesta);
}

if (isset($_POST['insertDataIndicador'])) {
    $descripcion = $_POST["descp_detalle"];
    $id_indicador_gestion = $_POST["valor_select"];
    $respuesta = $db->insertar_detalle_gestion($descripcion, $id_indicador_gestion);
    //$rspuesta = $db->insertar_detalle_gestion($descripcion, $id_indicador_gestion);
    echo json_encode($respuesta);
}

//eliminar para indicadores detalle
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    $respuesta = $db->eliminarGestion_indicador($id);
    echo json_encode($respuesta);
}
//!obetner detalles de tipo_gastos



//!eliminacion de un indicador V2
if (isset($_POST['eliminar_indicadorV2'])) {
    $id = $_POST['id'];
    $respuesta = $db->eliminar_indicador_v2($id);
    echo json_encode($respuesta);
}
//!eliminacion de un indicador V2

if (isset($_POST['getDataGasto'])) {
    $respuesta = $db->getDataTipo_gasto();
    echo json_encode($respuesta);
}

if (isset($_POST['addData_detalle_gasto'])) {

    $nombre = $_POST["nombre_detalle_r"];
    $cantidad = $_POST["cantidad_detalle"];
    $descripcion = $_POST["descp_detalle"];
    $precio_aprox = $_POST["precio_detalle"];
    $id_tipo_gastos = $_POST["valor_select"];
    //$rspuesta = $db->insertar_detalle($nombre, $cantidad, $descripcion, $precio_aprox, $id_tipo_gasto);
    $respuesta = $db->insertar_detalle_gasto($nombre, $cantidad, $descripcion, $precio_aprox, $id_tipo_gastos);
    echo json_encode($respuesta);

    //echo json_encode($_POST);
}
//modificacion laura


//parte de alex
//?ultima modificacion 28/7/2021
if (isset($_POST['getData_docente'])) {
    $respuesta = $db->getDocentes();
    echo json_encode($respuesta);
}

if (isset($_POST['guardarDatos_soli'])) {

    $id_docente = $_POST['nombre_docentes'];
    $nombre_docente = $_POST['nombre_completo'];
    $nombre_proyecto = $_POST['nombre_proyecto'];
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_final = $_POST['fecha_final'];
    $avance_realizado = $_POST['avance_realizado'];
    $proyec_periodo_actual = $_POST['periodo_soli'];
    $cant_horas = $_POST['horas_soli'];
    $estado = 'Pendiente';
    $respuesta = $db->insert_soli($id_docente, $nombre_docente, $nombre_proyecto, $fecha_inicio, $fecha_final, $avance_realizado, $proyec_periodo_actual, $cant_horas, $estado);
    echo json_encode($respuesta);
}
//?ultima modificacion 28/7/2021

if (isset($_POST['eliminar_indicador'])) {
    $id_indicador = $_POST['id_indicador'];
    $rspuesta = $db->eliminar_indicador($id_indicador);
    echo json_encode($rspuesta);
}
if (isset($_POST['eliminar_detalle_gasto'])) {

    $id_detalle_tipo_gasto = $_POST['id_detalle_tipo_gasto'];
    $rewspuesta = $db->eliminar_deatlle_gasto($id_detalle_tipo_gasto);
    echo json_encode($rewspuesta);
    //echo json_encode($_POST);

}

//?modificacion 29/07/2021
if (isset($_POST['nueva_retro'])) {
    $nombre_docente = $_POST['nombre_completo'];
    $arrayNombre = explode(" ", $nombre_docente, 3);
    $nombre_buscar = $arrayNombre[0] . " " . $arrayNombre[1];

    $anio = date("Y");
    $periodo = $_POST["periodo_soli"];
    $docente = $_POST["nombre_completo"];
    $codigo_empleado = $_POST["nombre_docentes"];
    $cant_clases_reasignadas = $_POST["cant_clases"];
    $memorandum = $_POST["n_memo"];
    $nombre_proyecto = $_POST["nombre_proyecto"];
    $fecha_inicio = $_POST["fecha_inicio"];
    $fecha_finalizacion = $_POST["fecha_final"];
    $estado = 'Pendiente';
    $avances = $_POST["avance_realizado"];


    $identidad = $db->get_id($nombre_buscar);
    if ($identidad == false) {
        $nombre_buscar = $arrayNombre[0];
        $n_identidad = $db->get_id($nombre_buscar);
        $id_final = $n_identidad['identidad'];
        $ingresar_retro = $db->add_retroalimentacion($periodo, $anio, $docente, $codigo_empleado, $cant_clases_reasignadas, $memorandum, $nombre_proyecto, $fecha_inicio, $fecha_finalizacion, $id_final, $estado, $avances);
        echo json_encode($ingresar_retro);
        //echo json_encode($n_identidad);
    } else {
        $id_final = $identidad['identidad'];
        $ingresar_retro = $db->add_retroalimentacion($periodo, $anio, $docente, $codigo_empleado, $cant_clases_reasignadas, $memorandum, $nombre_proyecto, $fecha_inicio, $fecha_finalizacion, $id_final, $estado, $avances);
        echo json_encode($ingresar_retro);
        //echo json_encode($identidad);
    }
}
//?fin modificacion 29/07/2021

//!cambios POA_metas
if (isset($_POST['editar_meta'])) {

    $id_metas = $_POST['id_metas'];
    $primer_trimestre = $_POST['primer_trimestre'];
    $segundo_trimestre = $_POST['segundo_trimestre'];
    $tercer_trimestre = $_POST['tercer_trimestre'];
    $cuarto_trimestre = $_POST['cuarto_trimestre'];

    if ($primer_trimestre == null) {
        $primer_trimestre = 0;
    } else {
        $primer_trimestre = $primer_trimestre;
    }

    if ($segundo_trimestre == null) {
        $segundo_trimestre = 0;
    } else {
        $segundo_trimestre = $segundo_trimestre;
    }

    if ($tercer_trimestre == null) {
        $tercer_trimestre = 0;
    } else {
        $tercer_trimestre = $tercer_trimestre;
    }

    if ($cuarto_trimestre == null) {
        $cuarto_trimestre = 0;
    } else {
        $cuarto_trimestre = $cuarto_trimestre;
    }


    $total = $primer_trimestre + $segundo_trimestre + $tercer_trimestre + $cuarto_trimestre;
    if ($total > 100) {
        echo json_encode('cuenta_mayor');
    } else if ($total < 100) {
        echo json_encode('menor_cuenta');
    } else {
        //echo json_encode('no tiene datos');
        //insertar datos
        $respuesta = $db->edicion_metas($id_metas, $primer_trimestre, $segundo_trimestre, $tercer_trimestre, $cuarto_trimestre);
        echo json_encode($respuesta);
    }
    //echo json_encode($_POST);
}
//!cambios POA _META 13/08/2021 

//!cambios poa actividades_proyecto
if (isset($_POST['edit_act_send'])) {
    //echo json_encode($_POST);
    $id_actividades_poa = $_POST['id_actividad'];
    $n_actividad = $_POST['n_actividad'];
    $id_verificacion = $_POST['id_verificacion'];
    $m_verificacion = $_POST['m_verificacion'];
    $id_poblacion = $_POST['id_poblacion'];
    $p_objetivo = $_POST['p_objetivo'];

    $respuesta = $db->update_actividades($id_actividades_poa, $n_actividad, $id_verificacion, $m_verificacion, $id_poblacion, $p_objetivo);
    echo json_encode($respuesta);
}
if (isset($_POST['edicion_recurso_send'])) {

    $id_recurso = $_POST['id_recurso'];
    $nombre_recurso_ed = $_POST['nombre_recurso_ed'];
    $descripcion_ed = $_POST['descripcion_ed'];
    $respuesta = $db->editar_recurso($id_recurso, $nombre_recurso_ed, $descripcion_ed);
    echo json_encode($respuesta);
}

if (isset($_POST['edicion_indicadores'])) {

    $id_indicador = $_POST['id_indicador'];
    $nombre_indicador = $_POST['nombre_recurso_ed'];
    $descripcion = $_POST['descripcion_ed'];
    $respuesta = $db->edicion_indicador($id_indicador, $nombre_indicador, $descripcion);
    echo json_encode($respuesta);
}

if (isset($_POST['editar_gasto_send'])) {

    $id_gasto = $_POST['id_gasto'];
    $descripcion = $_POST['desc_gasto'];
    $nombre_gasto = $_POST['nombre_gasto'];
    $fecha = $_POST['fecha_recurso_ed'];
    $respuesta = $db->editar_gasto($id_gasto, $descripcion, $nombre_gasto, $fecha);
    echo json_encode($respuesta);
}

if (isset($_POST['editar_detalleSend_recuros'])) {
    $id_detalle_recurso = $_POST['id_recurso_detalle'];
    $nombre_detalle = $_POST['nombre_detalle'];
    $cant_detalle = $_POST['cantidad_detalle'];
    $precio_detalle = $_POST['precio_detalle'];
    $desc_detalle = $_POST['desc_detalle'];
    $respuesta = $db->editar_detalle_recurso($id_detalle_recurso, $nombre_detalle, $cant_detalle, $precio_detalle, $desc_detalle);
    echo json_encode($respuesta);
}

if (isset($_POST['editar_indicdrosend_det'])) {
    $id_indicador = $_POST['id_indicador'];
    $descripcion = $_POST['desc_indicadro'];
    $respuesta = $db->detalle_indicador($id_indicador, $descripcion);
    echo json_encode($respuesta);
}

if (isset($_POST['eliminar_detalle_recurso'])) {

    $id_recurso = $_POST['id_recurso'];
    $respuesta = $db->eliminar_detalle_recurso($id_recurso);
    echo json_encode($respuesta);
}

if (isset($_POST['editar_gastos_detalle'])) {

    $id_gasto = $_POST['id_gasto'];
    $desc_gasto_detalle = $_POST['desc_gasto_detalle'];
    $nombre_gasto_detalle = $_POST['nombre_gasto_detalle'];
    $precio_gasto_detalle = $_POST['precio_gasto_detalle'];
    $cantidad_gasto_detalle = $_POST['cantidad_gasto_detalle'];

    $respuesta = $db->editar_gasto_detalle($id_gasto, $nombre_gasto_detalle, $precio_gasto_detalle, $cantidad_gasto_detalle, $desc_gasto_detalle);
    echo json_encode($respuesta);
}

//!eliminacion de los datos de aademica, pero no elimina el archivo
if (isset($_POST['file_delete_acd'])) {
    $id_acd = $_POST['id'];
    $respuesta = $db->eliminar_Academica($id_acd);
    $respuesta2 = $db->eliminar_temporal_data($id_acd);
    if ($respuesta == $respuesta2) {
        echo json_encode('exito');
    } else {
        echo json_encode('error');
    }
    //echo json_encode($respuesta);
}

//!ELIMINACION DEL CRAED
if (isset($_POST['file_delete_crd'])) {
    $id_crd = $_POST['id'];
    $respuesta = $db->eliminar_craed_data($id_crd);
    $respuesta2 = $db->eliminar_craed_temporal($id_crd);
    if ($respuesta == $respuesta2) {
        echo json_encode('exito');
    } else {
        echo json_encode('error');
    }
    //echo json_encode($respuesta);
}

if (isset($_POST['datos_editar_acd'])) {
    $id_edit = $_POST['id_editarAcd'];
    $periodo = $_POST['periodo_ca_edit'];
    $anio = $_POST['txt_fecha_ingreso_ca_edit'];
    $descripcion = $_POST['descrp_ca_edit'];
    $respuesta = $db->editar_academica_file($id_edit, $periodo, $anio, $descripcion);
    echo json_encode($respuesta);
}

if (isset($_POST['datos_editar_crd'])) {
    $id_cr = $_POST['id_editarCrd'];
    $periodo_cr = $_POST['periodo_cr_edit'];
    $descrip_cr = $_POST['descrip_cr_edit'];
    $anio_cr = $_POST['txt_fecha_ingreso_cr'];

    $respuesta = $db->editar_craed_file($id_cr, $periodo_cr, $descrip_cr, $anio_cr);
    echo json_encode($respuesta);
}
