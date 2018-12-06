<?php
include('../../funciones/conexion.php');
include('../../funciones/funciones.php');
comprobar(2);

session_start();
$conexion=conexion();
$cedula=$_GET['cedula'];

$consulta="DELETE FROM asignaciones_usuarios WHERE cedula=$cedula";
$consulta_equipos="DELETE FROM asignaciones_equipos WHERE cedula=$cedula";

if(query($consulta,$conexion) && query($consulta_equipos,$conexion))
{
	alert("Registro eliminado con exito.");
	redireccionar("usuarios.php");	
}
else
{
	alert("Error en consulta. No se puede eliminar el registro.");	
}
?>