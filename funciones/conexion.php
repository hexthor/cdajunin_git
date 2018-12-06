<?php

//Conexion a la base de datos:
function conexion()
{
	$host="localhost";
	$bd="cdajunin";
	$usuario="postgres";
	$clave="12345";
	//echo $bd.'<br>';
	if (!($conexion = pg_connect("dbname=$bd host=localhost port=5432 user=$usuario password=$clave")))
	{
		/*Si la conexion no es exitosa se mostrara el siguiente mensaje y salimos*/
		echo "No pudo conectarse al servidor";
		exit();
	}
/*No importa si se establecio o no la conexion, esta sera devuelta por la funcion*/	
	return $conexion;	
}

//Funcion para realizar querys:
function query($consulta, $conexion)
{
	$resultado= pg_query($conexion,$consulta) or die("No se puede realizar la consulta ".$consulta." ".pg_result_error());
	return $resultado;
}

//Fetch array para resultado de querys:
function fetch_array($resultado)
{
	$fila=pg_fetch_array($resultado);
	return $fila;
}

function num_rows($resultado)
{
	$numero=pg_num_rows($resultado);
	return $numero;
}

?>