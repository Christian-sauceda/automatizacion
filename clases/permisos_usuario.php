<?php

require_once('../clases/Conexion.php');





if (session_status() === PHP_SESSION_NONE) {
   session_start();
}






$sql_permisos = "select pu.visualizar ,p.id_objeto from tbl_permisos_usuarios pu ,tbl_objetos p,tbl_usuarios u ,tbl_roles r where r.id_rol=pu.id_rol and r.id_rol=u.id_rol and pu.id_objeto=p.id_objeto and id_usuario=" . $_SESSION['id_usuario'] . " ";

$resultado_permisos = $mysqli->query($sql_permisos);

/*Botones principales*/
$_SESSION['btn_seguridad'] = 'none';
$_SESSION['btn_vinculacion'] = 'none';
$_SESSION['btn_solicitudes'] = 'none';
$_SESSION['btn_coordinacion'] = 'none';
$_SESSION['btn_docentes'] = 'none';
$_SESSION['btn_ayuda'] = 'none';
$_SESSION['btn_mantenimiento'] = 'none';
$_SESSION['btn_perfil_estudiantil'] = 'none';
$_SESSION['btn_comite_vida_estudiantil'] = 'none';
$_SESSION['btn_control_actas'] = 'none';
$_SESSION['btn_jefatura'] = 'none';
$_SESSION['btn_gestion_laboratorio'] = 'none';
$_SESSION['btn_administracion_app'] = 'none';


/*Menu laterales*/
$_SESSION['pregunta_vista'] = 'none';
$_SESSION['usuarios_vista'] = 'none';
$_SESSION['roles_vista'] = 'none';
$_SESSION['permisos_usuario_vista'] = 'none';
$_SESSION['parametro_vista'] = 'none';
$_SESSION['bitacora_vista'] = 'none';
$_SESSION['practica_vista'] = 'none';
$_SESSION['supervision_vista'] = 'none';
$_SESSION['egresados_vista'] = 'none';
$_SESSION['proyectos_vinculacion_vista'] = 'none';
$_SESSION['final_practica'] = 'none';
$_SESSION['cambio_carrera'] = 'none';
$_SESSION['carta_egresado'] = 'none';
$_SESSION['equivalencias'] = 'none';
$_SESSION['cancelar_clases'] = 'none';
$_SESSION['solicitud_practica'] = 'none';
$_SESSION['solicitud_final_practica'] = 'none';
$_SESSION['solicitud_cambio_carrera'] = 'none';
$_SESSION['solicitud_carta_egresado'] = 'none';
$_SESSION['solicitud_equivalencias'] = 'none';
$_SESSION['solicitud_cancelar_clases'] = 'none';
$_SESSION['carga_academica_vista'] = 'none';
$_SESSION['docentes_vista'] = 'none';
$_SESSION['mantemiento_carga_academica'] = 'none';
$_SESSION['mantemiento_carga_academica1'] = 'none';
$_SESSION['plan_estudio_vista'] = 'none';
$_SESSION['mantenimiento_plan'] = 'none';
$_SESSION['perfil360_vista'] = 'none';
$_SESSION['expediente_graduacion'] = 'none';
$_SESSION['solicitud_servicio_comunitario'] = 'none';
$_SESSION['revision_servicio_comunitario'] = 'none';
$_SESSION['mantenimiento_perfil360'] = 'none';
$_SESSION['suficiencia'] = 'none';
$_SESSION['reactivacion_cuenta'] = 'none';
$_SESSION['historial_solicitudes'] = 'none';
$_SESSION['cancelar_solicitud'] = 'none';
$_SESSION['administracion_cve'] = 'none';
$_SESSION['actividades_cve'] = 'none';
$_SESSION['faltas_cve'] = 'none';
$_SESSION['horas_cve'] = 'none';
$_SESSION['memos_cve'] = 'none';
$_SESSION['gestion_reunion'] = 'none';
$_SESSION['gestion_actas'] = 'none';
$_SESSION['gestion_acuerdos_seguimientos'] = 'none';
$_SESSION['gestion_lista_asistencia'] = 'none';
$_SESSION['gestion_consulta_actas'] = 'none';
$_SESSION['mantenimiento_actas'] = 'none';
 //MENUS LATERALES
 $_SESSION['mantenimiento_laboratorio'] = 'none';
 $_SESSION['producto_vista'] = 'none';  
 $_SESSION['adquisicion_vista'] = 'none'; 
 $_SESSION['asignacion_vista'] = 'none'; 
 $_SESSION['salida_vista'] = 'none';
 $_SESSION['reportes_vista'] = 'none';
 $_SESSION['transaccion_kardex'] = 'none';
 $_SESSION['reportes_existencias_vista'] = 'none';
 $_SESSION['reportes_ubicacion_vista'] = 'none';
$_SESSION['salida_vista'] = 'none';
$_SESSION['transaccion_kardex'] = 'none';




while ($fila = $resultado_permisos->fetch_row()) {
   /*
   	echo '<script> alert("Bienvenido a nuestro sistema :  ' .$fila[0], $fila[1]. '")</script>';
       */
   if ($fila[0] == '1') {
      $_SESSION['confirmacion_ver'] = "block";
   } else {
      $_SESSION['confirmacion_ver'] = "none";
   }
   permisos_a_roles_visualizar($fila[1], $_SESSION['confirmacion_ver']);
}




function  permisos_a_roles_visualizar($pantalla, $confirmacion)
{
   $_SESSION['confirmacion'] = $confirmacion;
   $_SESSION['pantalla'] = $pantalla;


   /* $_SESSION['historial_registro']='none';*/



   if ($_SESSION['pantalla'] >= '1' and $_SESSION['pantalla'] <= '10') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_seguridad'] = "block";
      }
   }


   if ($_SESSION['pantalla'] == '14' or $_SESSION['pantalla'] == '20'  or $_SESSION['pantalla'] == '21') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_vinculacion'] = "block";
      }
   }

   if ($_SESSION['pantalla'] >= '51') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_docentes'] = "block";
      }
   }
   //  if ($_SESSION['pantalla']>='51')
   //  {
   //   if ( $_SESSION['confirmacion']=='block') 
   //   {
   //    $_SESSION['btn_docentes']="block";
   //  }
   // }

   if ($_SESSION['pantalla'] >= '71') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_ayuda'] = "block";
      }
   }

   if ($_SESSION['pantalla'] >= '70') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_mantenimiento'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '1' or $_SESSION['pantalla'] == '2') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['pregunta_vista'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '3' or $_SESSION['pantalla'] == '4') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['usuarios_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '5' or $_SESSION['pantalla'] == '6') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['roles_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '7') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['parametro_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '8') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['bitacora_vista'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '9' or $_SESSION['pantalla'] == '10') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['permisos_usuario_vista'] = "block";
      }
   }


   if ($_SESSION['pantalla'] == '14'  or $_SESSION['pantalla'] == '18' or $_SESSION['pantalla'] == '20' or $_SESSION['pantalla'] == '21' or $_SESSION['pantalla'] == '26' or $_SESSION['pantalla'] == '27' or $_SESSION['pantalla'] == '28') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['practica_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '14'  or $_SESSION['pantalla'] == '18' or $_SESSION['pantalla'] == '20' or $_SESSION['pantalla'] == '21' or $_SESSION['pantalla'] == '26' or $_SESSION['pantalla'] == '27' or $_SESSION['pantalla'] == '28') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['supervision_vista'] = "block";
      }
   }


   if ($_SESSION['pantalla'] == '13' or $_SESSION['pantalla'] == '15' or $_SESSION['pantalla'] == '16' or $_SESSION['pantalla'] == '17' or $_SESSION['pantalla'] == '19' or $_SESSION['pantalla'] == '39' or  $_SESSION['pantalla'] == '40') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['solicitud_practica'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '22' or $_SESSION['pantalla'] == '23') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['egresados_vista'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '24' or $_SESSION['pantalla'] == '25') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['proyectos_vinculacion_vista'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '29') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['solicitud_final_practica'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '30') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['solicitud_cambio_carrera'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '31') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['solicitud_carta_egresado'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '32') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['solicitud_equivalencias'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '33') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['solicitud_cancelar_clases'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '34') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['final_practica'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '35') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['cambio_carrera'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '36') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['carta_egresado'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '37') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['equivalencias'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '38') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['cancelar_clases'] = "block";
      }
   }






   if ($_SESSION['pantalla'] >= '51') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_docentes'] = "block";
      }
   }





   // boton de solicitudes */
   if ($_SESSION['pantalla'] >= '29' and $_SESSION['pantalla'] <= '33' or $_SESSION['pantalla'] == '13' or $_SESSION['pantalla'] == '15' or $_SESSION['pantalla'] == '16' or $_SESSION['pantalla'] == '17' or $_SESSION['pantalla'] == '19' or $_SESSION['pantalla'] == '39' or  $_SESSION['pantalla'] == '40') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_solicitudes'] = "block";
      }
   }
   // boton de coordinacion */
   //** las pantallas son el id de la tbl_objetos */
   if ($_SESSION['pantalla'] >= '34' and $_SESSION['pantalla'] <= '38') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_coordinacion'] = "block";
      }
   }

 //CVE
 if ($_SESSION['pantalla'] == '8219' and $_SESSION['pantalla'] == '8220' and $_SESSION['pantalla'] == '8221' and $_SESSION['pantalla'] == '8222' and $_SESSION['pantalla'] == '8223') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['administracion_cve'] = "block";
   }
}
if ($_SESSION['pantalla'] >= '8224' and $_SESSION['pantalla'] <= '8225') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['btn_comite_vida_estudiantil'] = "block";
   }
}
if ($_SESSION['pantalla'] >= '8224' and $_SESSION['pantalla'] <= '8225') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['btn_comite_vida_estudiantil'] = "block";
   }
}

if ($_SESSION['pantalla'] == '8228') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['btn_comite_vida_estudiantil'] = "block";
   }
}

if ($_SESSION['pantalla'] == '8229') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['btn_comite_vida_estudiantil'] = "block";
   }
}

if ($_SESSION['pantalla'] == '8232') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['btn_comite_vida_estudiantil'] = "block";
   }
}
if ($_SESSION['pantalla'] == '8219') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['btn_comite_vida_estudiantil'] = "block";
   }
}
if ($_SESSION['pantalla'] == '8233') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['btn_comite_vida_estudiantil'] = "block";
   }
}

if ($_SESSION['pantalla'] == '8235') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['btn_comite_vida_estudiantil'] = "block";
   }
}


 //FIN DE CVE

   //MODULO VISTA 360 ESTUDIANTIL
   if ($_SESSION['pantalla'] == '115') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_perfil_estudiantil'] = "block";
      }
   }

   //AGREGANDO CARGA ACADEMICA
   if ($_SESSION['pantalla'] == '45') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_coordinacion'] = "block";
      }
   }

  //Modulo de actas
  //AGREGANDO Modulo Control de Actas

  //Boton Principal Control de Actas
  if ($_SESSION['pantalla'] == '5000' or $_SESSION['pantalla'] == '5001' or $_SESSION['pantalla'] == '5003' or $_SESSION['pantalla'] == '5004' or $_SESSION['pantalla'] == '5006' or $_SESSION['pantalla'] == '5007' or $_SESSION['pantalla'] == '5009' or $_SESSION['pantalla'] == '5010' or $_SESSION['pantalla'] == '5011' or $_SESSION['pantalla'] == '5012' or $_SESSION['pantalla'] == '5020' or $_SESSION['pantalla'] == '5027' ){ if ($_SESSION['confirmacion'] == 'block') { $_SESSION['btn_control_actas'] = "block"; } } //Menu de Reuniones
   if ($_SESSION['pantalla'] == '5000' or $_SESSION['pantalla'] == '5001' or $_SESSION['pantalla'] == '5003') { if ($_SESSION['confirmacion'] == 'block') { $_SESSION['gestion_reunion'] = "block"; } } //Menu de Actas 
   if ($_SESSION['pantalla'] == '5004' or $_SESSION['pantalla'] == '5005' or $_SESSION['pantalla'] == '5006' or $_SESSION['pantalla'] == '5019') { if ($_SESSION['confirmacion'] == 'block') { $_SESSION['gestion_actas'] = "block"; } }
    //Menu Acuerdos y Seguimientos
    if ($_SESSION['pantalla'] == '5007' or $_SESSION['pantalla'] == '5008' or $_SESSION['pantalla'] == '5009' or $_SESSION['pantalla'] == '5010') { if ($_SESSION['confirmacion'] == 'block') { $_SESSION['gestion_acuerdos_seguimientos'] = "block"; } } //Menu Lista de Asistencia 
    if ($_SESSION['pantalla'] == '5011' or $_SESSION['pantalla'] == '5012') { if ($_SESSION['confirmacion'] == 'block') { $_SESSION['gestion_lista_asistencia'] = "block"; } } //Menu Lista de Actas Archivadas 
    if ($_SESSION['pantalla'] == '5020'){ if ($_SESSION['confirmacion'] == 'block') { $_SESSION['gestion_consulta_actas'] = "block"; } } //Mantenimiento de Actas 
    if ($_SESSION['pantalla'] == '5013' or $_SESSION['pantalla'] == '5014' or $_SESSION['pantalla'] == '5015' or $_SESSION['pantalla'] == '5016' or $_SESSION['pantalla'] == '5017' or $_SESSION['pantalla'] == '5018'){ if ($_SESSION['confirmacion'] == 'block') { $_SESSION['mantenimiento_actas'] = "block"; } } 
  //aqui termina modulos de acta


   if ($_SESSION['pantalla'] == '47' or $_SESSION['pantalla'] == '48' or $_SESSION['pantalla'] == '104' or $_SESSION['pantalla'] == '275') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['carga_academica_vista'] = "block";
      }
   }




   ///planes de estudio mantenimiento

   if ($_SESSION['pantalla'] == '95') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['mantenimiento_plan'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '99' or $_SESSION['pantalla'] == '100' or $_SESSION['pantalla'] == '101' or $_SESSION['pantalla'] == '102' or $_SESSION['pantalla'] == '107' or $_SESSION['pantalla'] == '108' or $_SESSION['pantalla'] == '109' or $_SESSION['pantalla'] == '110') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['mantenimiento_plan'] = "block";
      }
   }


   //
   //esto es docentes la vista
   if ($_SESSION['pantalla'] == '49') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['docentes_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '50' or $_SESSION['pantalla'] == '54' or $_SESSION['pantalla'] == '53' or $_SESSION['pantalla'] == '51' or $_SESSION['pantalla'] == '113') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['docentes_vista'] = "block";
      }
   }
   //menu manteniiento carga academica
   if ($_SESSION['pantalla'] == '94') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['mantemiento_carga_academica1'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '111' or $_SESSION['pantalla'] == '93' or $_SESSION['pantalla'] == '82' or $_SESSION['pantalla'] == '60' or $_SESSION['pantalla'] == '83' or $_SESSION['pantalla'] == '58' or $_SESSION['pantalla'] == '86' or $_SESSION['pantalla'] == '85' or $_SESSION['pantalla'] == '63' or $_SESSION['pantalla'] == '55') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['mantemiento_carga_academica1'] = "block";
      }
   }
   //menu mantenimietno docente

   if ($_SESSION['pantalla'] == '70') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['mantemiento_carga_academica'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '56' or $_SESSION['pantalla'] == '57' or $_SESSION['pantalla'] == '59' or $_SESSION['pantalla'] == '61' or $_SESSION['pantalla'] == '62' or $_SESSION['pantalla'] == '64' or $_SESSION['pantalla'] == '65' or $_SESSION['pantalla'] == '66' or $_SESSION['pantalla'] == '67' or $_SESSION['pantalla'] == '68' or $_SESSION['pantalla'] == '84' or $_SESSION['pantalla'] == '73' or $_SESSION['pantalla'] == '90' or $_SESSION['pantalla'] == '91' or $_SESSION['pantalla'] == '80' or $_SESSION['pantalla'] == '81' or $_SESSION['pantalla'] == '74' or $_SESSION['pantalla'] == '75' or $_SESSION['pantalla'] == '76' or $_SESSION['pantalla'] == '77' or $_SESSION['pantalla'] == '78' or $_SESSION['pantalla'] == '79' or $_SESSION['pantalla'] == '88' or $_SESSION['pantalla'] == '89') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['mantemiento_carga_academica'] = "block";
      }
   }




   //menu plan de estudio
   if ($_SESSION['pantalla'] == '103') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['plan_estudio_vista'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '96' or $_SESSION['pantalla'] == '97' or $_SESSION['pantalla'] == '98' or $_SESSION['pantalla'] == '106' or $_SESSION['pantalla'] == '105' or $_SESSION['pantalla'] == '112') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['plan_estudio_vista'] = "block";
      }
   }




   if ($_SESSION['pantalla'] = '123' or $_SESSION['pantalla'] == '120') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['solicitud_examensuficiencia'] = "block";
      }
   }

   if ($_SESSION['pantalla'] = '122') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['suficiencia'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '121') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['reactivacion_cuenta'] = "block";
      }
   }

   if ($_SESSION['pantalla'] = '124') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['reactivacion_cuenta_unica'] = "block";
      }
   }

   if ($_SESSION['pantalla'] = '125') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['revision_reactivacion'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '126') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['revision_suficiencia_unica'] = "block";
      }
   }


   if ($_SESSION['pantalla'] == '127') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['menu_revision_suficiencia'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '128') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['solicitud_servicio_comunitario'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '129') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['revision_servicio_comunitario'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '130') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['revision_coordinacion_servicio_comunitario'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '132') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['mantenimiento_perfil360'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '132') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['Historial_de_solicitudes'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '143') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['cancelar_solicitud'] = "block";
      }
   }

   //AGREGANDO MODULO CVE



   


   //----agregando vistas de GESTION DEL MODULO DE JEFATURA----//
   if ($_SESSION['pantalla'] = '266') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['jefatura'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '236') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_cargajefatura_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '249') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_reasignacionjefatura_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '250') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_reasignacion_solicitud'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '251') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_reasignacion_retroalimentacion'] = "block";
      }
   }

   if ($_SESSION['pantalla'] == '252') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_planificacionjefatura_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '245') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_carga_cargaacademica_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '241') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_carga_recontratacion_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '237') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_carga_declaracionjurada_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '247') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['responsables_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '253') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_solicitud_reasignacion_docentes'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '254') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_retroalimentacion_docentes'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '239') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_generardeclaracion_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '243') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_generarrecontratacion_vista'] = "block";
      }
   }
   //nuevas pantallas de poa
   if ($_SESSION['pantalla'] == '238') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['poa_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '240') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['objetivos_poa'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '242') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['indicadores_poa'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '244') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['metas_poa'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '246') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['actividades_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '255') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['menu_mantenimientos_jefatura_principal'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '262') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['indicador_tipo'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '263') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['mantenimiento_tipo_indicadores'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '264') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['responsables_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '262') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['indicador_tipo'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '259') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['mantenimiento_tipos_recursos'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '258') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['recursos_tipo'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '260') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['gastos_tipo'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '261') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['mantenimiento_tipo_gastos_vista'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '248') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_detalle_recursos'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '256') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_detalle_indicadores'] = "block";
      }
   }
   if ($_SESSION['pantalla'] == '257') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['g_detalle_gastos'] = "block";
      }
   }


  //AGREGANDO MODULO GESTION LABORATORIO

//BOTON PRINCIPAL
if ($_SESSION['pantalla']='12194' or $_SESSION['pantalla']='12195' or $_SESSION['pantalla']='12196' or $_SESSION['pantalla']='12210' or $_SESSION['pantalla']='12211' or $_SESSION['pantalla']='12218' or $_SESSION['pantalla']='12212' or $_SESSION['pantalla']='12214' or $_SESSION['pantalla']='12208' or $_SESSION['pantalla']='12209' or $_SESSION['pantalla']='12217' or $_SESSION['pantalla']='12206' or $_SESSION['pantalla']='12207'  ){
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['btn_gestion_laboratorio'] = "block";
   }
}

//PROCESO PRODUCTO
  if ($_SESSION['pantalla'] = '12194' or $_SESSION['pantalla'] = '12195' or $_SESSION['pantalla'] = '12196') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['producto_vista'] = "block";
   }
}

//PROCESO ADQUISICION
if ($_SESSION['pantalla'] = '12210' or $_SESSION['pantalla'] = '12211' or $_SESSION['pantalla'] = '12218') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['adquisicion_vista'] = "block";
   }
}

//PROCESO ASIGNACION
if ($_SESSION['pantalla'] = '12212' or $_SESSION['pantalla'] = '12214') {
   if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['asignacion_vista'] = "block";
   }
}
     

//PROCESO SALIDA
if ($_SESSION['pantalla'] = '12208' or $_SESSION['pantalla'] = '12209') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['salida_vista'] = "block";
   }
}

//PANTALLA TRANSACCIONES
if ($_SESSION['pantalla'] = '12217'){
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['transaccion_kardex']  = "block";
   }
}


//DESPLEGAR REPORTES
if ($_SESSION['pantalla'] = '12206' or $_SESSION['pantalla'] = '12207') {
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['reportes_vista'] = "block";
   }
}

      
//PANTALLA EXISTENCIAS
if ($_SESSION['pantalla'] = '12206'){
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['reportes_existencias_vista']  = "block";
   }
}
        
//PANTALLA UBICACION
if ($_SESSION['pantalla'] = '12207'){
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['reportes_ubicacion_vista']  = "block";
   }
}


//Mantenimiento LABORATORIO
if ($_SESSION['pantalla']='12184' or $_SESSION['pantalla']='12185' or $_SESSION['pantalla']='12186' or $_SESSION['pantalla']='12187' or $_SESSION['pantalla']='12188' or $_SESSION['pantalla']='12189' or $_SESSION['pantalla']='12191' or $_SESSION['pantalla']='12192' or $_SESSION['pantalla']='12197'or $_SESSION['pantalla']='12198' or $_SESSION['pantalla']='12199' or $_SESSION['pantalla']='12200' ){
   if ($_SESSION['confirmacion'] == 'block') {
      $_SESSION['mantenimiento_laboratorio'] = "block";
   }
}


   //COMITE VIDA ESTUDIANTL
  
   if ($_SESSION['pantalla'] == '8220' or $_SESSION['pantalla'] == '8221' or $_SESSION['pantalla'] == '8222' or $_SESSION['pantalla'] == '8223') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['administracion_cve'] = "block";
      }
   }

   if ($_SESSION['pantalla'] = '8224') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['actividades_cve'] = "block";
      }
   }

   if ($_SESSION['pantalla'] = '8226') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['faltas_cve'] = "block";
      }
   }

   if ($_SESSION['pantalla'] = '8228') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['horas_cve'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '8219') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['administracion_cve'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '8234') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['memos_cve'] = "block";
      }
   }
   //Fin del Comite vide estudiantil

   //PERFIL 360
   if ($_SESSION['pantalla'] = '116') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['perfil360_vista'] = "block";
      }
   }


   //MENU ADMINISTRACION APP 

   if ($_SESSION['pantalla'] = '181') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_administracion_app'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '162') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_administracion_app'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '161') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_administracion_app'] = "block";
      }
   }
   if ($_SESSION['pantalla'] = '160') {
      if ($_SESSION['confirmacion'] == 'block') {
         $_SESSION['btn_administracion_app'] = "block";
      }
   }
}
