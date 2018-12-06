<?php
include('../../funciones/conexion.php');
include('../../funciones/funciones.php');
comprobar(2);

session_start();
$conexion=conexion();
$responsable=$_SESSION['usuario'];
$id_pendiente=$_GET['id_pendiente'];

$consulta="DELETE FROM pendientes WHERE id=$id_pendiente";
$consulta_notas="DELETE FROM pendientes_notas WHERE id_pendiente=$id_pendiente";

if(query($consulta,$conexion) && query($consulta_notas,$conexion))
{
	alert("Registro eliminado con exito.");
	redireccionar("pendientes.php");	
}
else
{
	alert("Error en consulta. No se puede eliminar el registro.");	
}
?>