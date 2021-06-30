<?php
session_start();

require_once('../clases/conexion_mantenimientos.php');



$instancia_conexion = new conexion();

class modelo_plan{

 

    function tipo_plan_sel()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT * FROM tbl_tipo_plan');

        return $consulta;
    }
  
    function verificarPlanNombre($nombre)
    {
        global $instancia_conexion;

        $sql4 = "call proc_verificar_nombre_plan('$nombre')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }

    function crear_plan_estudio($nombre, $num_clases, $fecha_creacion, $codigo_plan, $plan_vigente, $id_tipo_plan,$creado_por, $numero_acta, $fecha_acta, $fecha_emision,$creditos,$activo)
    {

        global $instancia_conexion;

        $sql = "call proc_insertar_plan_estudio('$nombre','$num_clases','$fecha_creacion','$codigo_plan','$plan_vigente','$id_tipo_plan','$creado_por','$numero_acta','$fecha_acta','$fecha_emision','$creditos','$activo')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            return 1;
            
        } else {
            return 0;
        }
    }
   
    function listar_planes_estudio()
    {
        global $instancia_conexion;
        $sql = "call sel_gestion_plan_estudio()";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }
    function historial_plan_estudio_datos()
    {
        global $instancia_conexion;
        $sql = "call sel_historial_plan_estudio()";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }
    function buscar_historial_plan($nombre,$codigo)
    {
        global $instancia_conexion;
        $sql = "call sel_busca_historial_plan('$nombre','$codigo')";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }
    function listar_historial_plan_vigente()
    {
        global $instancia_conexion;
        $sql = " call sel_historial_plan_vigente()";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }

    function modificar_plan_estudio($nombre, $num_clases, $codigo_plan, $id_tipo_plan, $fecha_modificacion, $modificado_por, $creditos_plan, $id_plan_estudio)
    {

        //$Id_objeto=98;
        global $instancia_conexion;

        $sql = "call proc_actualizar_plan_estudio('$nombre', '$num_clases', '$codigo_plan', '$id_tipo_plan', '$fecha_modificacion', '$modificado_por','$creditos_plan', '$id_plan_estudio')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            return 1;
          

        } else {
            return 0;
        }
    }
   
    function plan_sel()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT id_plan_estudio,nombre FROM tbl_plan_estudio ');

        return $consulta;
    }
    function area_sel()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT id_area,area FROM tbl_areas');

        return $consulta;
    }
    function periodo_sel()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT id_periodo_plan,periodo FROM tbl_periodo_plan');

        return $consulta;
    }

    function UVasignaturas($id_plan_estudio)
    {
        global $instancia_conexion;

        $sql4 = "call proc_verificar_unidades_asignatura_plan('$id_plan_estudio')";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql4);
    }

    function modificar_plan_estudio_no($vigencia_si, $id_plan, $vigencia_no, $estado_activo_asig, $estado_inactivo_asig, $activo_plan_pasado, $modificado_por, $fecha_primer_vigencia, $fecha_modificacion)
    {

        //$Id_objeto=98;
        global $instancia_conexion;

        $sql = "call proc_actualizar_vigencia_planes_no('$vigencia_si', '$id_plan', '$vigencia_no', '$estado_activo_asig', '$estado_inactivo_asig', '$activo_plan_pasado','$modificado_por', '$fecha_primer_vigencia','$fecha_modificacion')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            return 1;
        } else {
            return 0;
        }
    }

    function modificar_plan_estudio_si($vigencia_no, $modificado_por, $fecha_ultima_vigencia, $estado_inactivo_asig, $id_plan)
    {

        //$Id_objeto=98;
        global $instancia_conexion;

        $sql = "call proc_actualizar_vigencia_planes_si('$vigencia_no', '$modificado_por', '$fecha_ultima_vigencia', '$estado_inactivo_asig', '$id_plan')";

        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            return 1;
        } else {
            return 0;
        }
    }
    function nombre_plan_sel()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT * FROM tbl_plan_estudio');

        return $consulta;
    }
    function comparar_historial_plan($nombre)
    {
        global $instancia_conexion;
        $sql = "call sel_comparar_historial_plan('$nombre')";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }

    function asignatura_sel()
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT * FROM tbl_asignaturas');

        return $consulta;
    }
    function plan_sel_asig($id_plan_estudio)
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta('SELECT * FROM tbl_asignaturas where id_plan_estudio=' . $id_plan_estudio . '');

        return $consulta;
    }
    
    function UVplan($id_plan_estudio)
    {

        global $instancia_conexion;
        $sql6 =
        "SELECT creditos_plan,num_clases FROM tbl_plan_estudio where id_plan_estudio= $id_plan_estudio";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql6);
    }


    function contarAsignaturas($id_plan_estudio)
    {

        global $instancia_conexion;
        $sql6 =
        "SELECT COUNT(Id_asignatura) as suma FROM tbl_asignaturas where id_plan_estudio= '$id_plan_estudio'";
        return $instancia_conexion->ejecutarConsultaSimpleFila($sql6);
    }
    function tabla_equivalencias()
    {
        global $instancia_conexion;
        $sql = " call sel_equivalencias_plan()";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }
    function sel_equivalencias($id_asignatura)
    {
        global $instancia_conexion;
        $consulta = $instancia_conexion->ejecutarConsulta(" call sel_busca_equivalencias_plan($id_asignatura)");
      
        $equivalencias = array();
        
    
        while ($row = $consulta->fetch_assoc()) {
    
          $equivalencias['equivalencias'][] = $row;
        }
    
        //echo '<pre>';print_r($actividades);echo'</pre>';
        return $equivalencias;
       
    }
    function existe_equivalencia($id_asignatura, $id_equivalencia){
    global $instancia_conexion;
    $sql5 = "CALL sel_existe_equivalencia_plan('$id_asignatura','$id_equivalencia')";
    return $instancia_conexion->ejecutarConsultaSimpleFila($sql5);
  }
  function insertar_equivalencias($id_asignatura, $id_equivalencia)
  {
    global $instancia_conexion;
    $sql = "CALL proc_insertar_equivalencias_plan($id_asignatura, $id_equivalencia);";

    if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
      return 1;
    } else {
      return 0;
    }
  }
  
  function eliminar_equivalencias($eliminar_equivalencia)
  {
    global $instancia_conexion;
    $consulta = $instancia_conexion->ejecutarConsulta("DELETE FROM tbl_equivalencias_plan WHERE id_equivalencias_plan='$eliminar_equivalencia';");

    return $consulta;
  }
    function listar_asignaturas_vigentes()
    {
        global $instancia_conexion;
        $sql = " call sel_asignaturas_vigentes()";
        $arreglo = array();
        if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
            while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
                $arreglo["data"][] = $consulta_VU;
            }
            return $arreglo;
        }
    }

  




}



?>