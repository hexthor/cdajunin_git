<?php
include('../../funciones/conexion.php');
include('../../funciones/funciones.php');
comprobar(2);

session_start();
$conexion=conexion();
$responsable=$_SESSION['usuario'];
$id_equipo=$_GET['id_equipo'];

$consulta="DELETE FROM asignaciones_equipos WHERE id=$id_equipo";
//$consulta_notas="DELETE FROM pendientes_notas WHERE id_pendiente=$id_pendiente";

if(query($consulta,$conexion)/* && query($consulta_notas,$conexion)*/)
{
	alert("Registro eliminado con exito.");
	redireccionar("asignaciones.php");	
}
else
{
	alert("Error en consulta. No se puede eliminar el registro.");	
}
?>