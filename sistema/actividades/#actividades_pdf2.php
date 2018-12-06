<?php
include('../../funciones/conexion.php');
include('../../funciones/funciones.php');
comprobar(2);
session_start();
$conexion=conexion();
$responsable=$_SESSION['usuario'];
$select_act_usu="SELECT * FROM actividades WHERE responsable='".$responsable."'";
$query_act=query($select_act_usu,$conexion);
$num_rows=num_rows($query_act);

$b=1;
while($result=fetch_array($query_act))
{	
	echo '<br>Actividad 01.- '.$result['detalle'].'<br><br>';
	$select_soporte="SELECT nombre_archivo FROM actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$result['responsable_correlativo']."'";
	$query_soporte=query($select_soporte,$conexion);
	$num_sop=num_rows($query_soporte);
	$b+=1;
	unset($arreglo);
	while($result_sop=fetch_array($query_soporte))
	{
		echo $result_sop['nombre_archivo'].'<br><br>';
		$arreglo[]=$result_sop['nombre_archivo'];
	}
	
	echo 'LINEAS:'.count(array_chunk($arreglo, 3));
	echo '<pre>';
	print_r(array_chunk($arreglo, 3));
	echo '</pre>';
}
?>