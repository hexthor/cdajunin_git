<?php
include('../../funciones/conexion.php');
include('../../funciones/funciones.php');
comprobar(2);

session_start();
$conexion=conexion();
$responsable=$_SESSION['usuario'];
$actividad=$_GET['id_actividad'];

$consulta="DELETE FROM actividades WHERE responsable='".$responsable."' AND responsable_correlativo='".$actividad."'";

if(query($consulta,$conexion))
{
	
	/*SELECCIONAR ARCHIVOS ADJUNTOS PARA LA ACTIVIDAD A ELIMINAR*/
	$select_cuenta="SELECT COUNT(id_soporte_actividad) FROM actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$actividad."'
	GROUP BY id, id_actividad, responsable";
	$query_cuenta=query($select_cuenta,$conexion);
	$cuenta=num_rows($query_cuenta);
	
	if($cuenta!=0) /*SI LA ACTIVIDAD TIENE ADJUNTOS ENTRA AL IF, Y SE PROCEDEN A BORRAR CADA UNO DE ELLOS EN EL WHILE*/
	{
		$select_adjuntos="SELECT * FROM actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$actividad."'";
		$query_adjuntos=query($select_adjuntos,$conexion);
		while($result=fetch_array($query_adjuntos))
		{
			$archivo=$result['nombre_archivo'];
			unlink("soportes/$responsable/$archivo");
		}
		
		$borrar_adjuntos="DELETE FROM actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$actividad."'";
		$query_borrar_adjuntos=query($borrar_adjuntos,$conexion);
		
		$carpeta = @scandir("soportes/$responsable"); /*SI LA CARPETA DEL USUARIO QUEDA VACIA DESPUES DE ELIMINAR LOS ADJUNTOS, SE ELIMINA LA CARPETA TAMBIEN*/
		if (count($carpeta)<=2)
		{
			deleteDirectory("soportes/".$responsable);
		}
	}
	
	alert("Registro eliminado con exito.");
	redireccionar("actividades.php");	
}
else
{
	alert("Error en consulta. No se puede eliminar el registro.");	
}
?>