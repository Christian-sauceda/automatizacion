<?php
ob_start();
require "../clases/conexion_mantenimientos.php";
$instancia_conexion = new conexion();

Class pruebas
{
    public function insertar($nombre,$edad)
	{
		$sql="INSERT INTO tb_pruebas (nombre,edad)
		VALUES ('$nombre','$edad')";
		return ejecutarConsulta($sql);
    }
    
    public function update($nombre,$edad)
	{
		$sql="UPDATE  tb_pruebas set nombre='$nombre',edad='$edad'";
		return ejecutarConsulta($sql);
	}
	public function valida_campos($nombre,$edad)
	{
		$sql="SELECT * from tb_pruebas where nombre='$nombre' and edad='$edad'";
			if (validar_select($sql))
			    {
					return true;
					# code...
				}
			else
			{
				return false;
			}
	}
	public function busqueda_fechas($fecha_inicio,$fecha_p)
	{
        global $instancia_conexion;
		$sql="SELECT COUNT(fecha) as fecha from tbl_dias_feriados WHERE fecha BETWEEN '$fecha_inicio' and '$fecha_p'";
		return $instancia_conexion->ejecutarConsultaSimpleFila($sql);
        
    }
	public function update_pps($txt_estudiante_cuenta, $obs, $empresa, $cb_horas_practica, $fechaN, $fechaF)
	{
        global $instancia_conexion;
		$tipo = 1;
		$sql = "call proc_aprobacion_practica('$txt_estudiante_cuenta', '$obs', '$tipo', '$empresa', '$cb_horas_practica', '$fechaN', '$fechaF')";
		// return $instancia_conexion->ejecutarConsulta($sql);

		if ($consulta = $instancia_conexion->ejecutarConsulta($sql)) {
           return 1;
        } else {
            return 0;
        }

		
        
    }
	
}




















ob_end_flush();

?>