<?php
require_once "../Modelos/mantenimientos_modelo.php";


$instancia_modelo = new modelo_mantenimientos();




switch ($_GET["op"]){

  case 'listar_persona':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_persona();
       
          while ($r=$respuesta->fetch_object()) {
       
             
               # code...
               echo "<option value='". $r->id_tipo_persona."'> ".$r->tipo_persona." </option>";
               
           }
  
        
         }
         else{
           echo 'No hay informacion';
         }
       
break;


case 'listar_comision':
      if (isset($_POST['activar'])) {
          $data=array();
          $respuesta=$instancia_modelo->listar_comision();
         
            while ($r=$respuesta->fetch_object()) {
         
               
                 # code...
                 echo "<option value='". $r->id_comisiones."'> ".$r->comision." </option>";
                 
             }
    
          
           }
           else{
             echo 'No hay informacion';
           }
         
  break;


  case 'listar_edificio':
    if (isset($_POST['activar'])) {
        $data=array();
        $respuesta=$instancia_modelo->listar_edificio();
       
          while ($r=$respuesta->fetch_object()) {
       
             
               # code...
               echo "<option value='". $r->id_edificio."'> ".$r->nombre." </option>";
               
           }
  
        
         }
         else{
           echo 'No hay informacion';
         }
       
break;


case 'listar_aula':
  if (isset($_POST['activar'])) {
      $data=array();
      $respuesta=$instancia_modelo->listar_aula();
     
        while ($r=$respuesta->fetch_object()) {
     
           
             # code...
             echo "<option value='". $r->id_tipo_aula."'> ".$r->tipo_aula." </option>";
             
         }

      
       }
       else{
         echo 'No hay informacion';
       }
     
break;

}

  
?>