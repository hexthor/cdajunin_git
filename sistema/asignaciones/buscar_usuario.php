<?php
include('../../funciones/conexion.php');
include('../../funciones/funciones.php');

session_start();
$conexion=conexion();
$cedula=$_POST['cedula'];

$query="SELECT * FROM asignaciones_usuarios WHERE cedula='".$cedula."'";
$query_consultar=query($query,$conexion);
$result=fetch_array($query_consultar);
$cuenta=num_rows($query_consultar);

/*echo "<pre>";
print_r ($query);
echo "<br>";
print_r ($result);
echo "</pre>";*/

echo json_encode(array("cuenta" => $cuenta, "cedula" => $_POST['cedula'], "nombre" => $result['nombre'], "apellido" => $result['apellido'], "indicador" => $result['indicador'], "gerencia" => $result['gerencia'], "ubicacion" => $result['ubicacion']));
?>