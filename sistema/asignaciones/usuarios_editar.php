<?php
include('../../funciones/conexion.php');
include('../../funciones/funciones.php');
comprobar(2);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>CDA Junin</title>

<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="stylesheet" href="../../css/estilos.css">
<link rel="stylesheet" href="../../css/bootstrap.min.css">
<link rel="stylesheet" href="../../css/bootstrap-theme.min.css">
<link rel="shortcut icon" href="../../img/favicon2.ico">
<!--<script src="../../js/pace.min.js"></script>-->
<!--<link href="../../css/centersimple.css" rel="stylesheet"/>-->

<script type="text/javascript" src="../../js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../../js/validator.js"></script>
<script type="text/javascript" src="../../js/funciones.js"></script>

<!--<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<link href="../../css/dataTables.bootstrap.min.css" rel="stylesheet"/>
<script type="text/javascript" src="../../js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap-hover-dropdown.js"></script>-->

<link href="../../css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="../../js/fileinput.js" type="text/javascript"></script>
<script src="../../js/fileinput_locale_es.js" type="text/javascript"></script>

<link href="../../css/bootstrap-datepicker3.css" rel="stylesheet"/>
<script type="text/javascript" src="../../js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.es.min.js"></script>

<script type="text/javascript" class="init">
	
$(document).ready(function() {

	$('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
     });

});
	  
</script>

</head>
<body>

<?php
$conexion=conexion();

if (!isset($_POST['guardar']))
{
	$cedula=$_GET['cedula'];
	$consultar="SELECT * FROM asignaciones_usuarios WHERE cedula=$cedula";
	$query_consultar=query($consultar,$conexion);
	$result=fetch_array($query_consultar);		
}

if (isset($_POST['guardar']))
{
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	
	$cedula_old=$_POST['cedula_old'];
	$cedula_new=$_POST['cedula_usuario'];
	$nombre=$_POST['nombre_usuario'];
	$apellido=$_POST['apellido_usuario'];
	$indicador=$_POST['indicador_usuario'];
	$gerencia=$_POST['gerencia_usuario'];
	$ubicacion=$_POST['ubicacion_usuario'];
	
	if($cedula_new==$cedula_old)
	{
		$actualizar="UPDATE asignaciones_usuarios SET cedula='".$cedula_new."',nombre='".$nombre."',apellido='".$apellido."',indicador='".$indicador."',gerencia='".$gerencia."',ubicacion='".$ubicacion."' WHERE cedula='$cedula_old'";
		$actualizar_dos="UPDATE asignaciones_equipos SET cedula='".$cedula_new."', indicador='".$indicador."' WHERE cedula='$cedula_old'";
		
		if (query($actualizar,$conexion) && query($actualizar_dos,$conexion))
		{
			alert("Registro Actualizado.");
			redireccionar("usuarios_editar.php?cedula=".$cedula_new);
		}
	}
	else
	{
		$query="SELECT * FROM asignaciones_usuarios WHERE cedula='".$cedula_new."'";	
		$query_consultar=query($query,$conexion);
		//$result=fetch_array($query_consultar);
		$cuenta=num_rows($query_consultar);
		
		if($cuenta>=1)
		{
			alert("La cedula: ".$cedula_new." ya existe, por favor verifique.");
			redireccionar("usuarios_editar.php?cedula=".$cedula_old);
		}
		else
		{
			$actualizar="UPDATE asignaciones_usuarios SET cedula='".$cedula_new."',nombre='".$nombre."',apellido='".$apellido."',indicador='".$indicador."',gerencia='".$gerencia."',ubicacion='".$ubicacion."' WHERE cedula='$cedula_old'";
			$actualizar_dos="UPDATE asignaciones_equipos SET cedula='".$cedula_new."', indicador='".$indicador."' WHERE cedula='$cedula_old'";
			
			if (query($actualizar,$conexion) && query($actualizar_dos,$conexion))
			{
				alert("Registro Actualizado.");
				redireccionar("usuarios_editar.php?cedula=".$cedula_new);
			}
		}
	}
}

?>

<div class="container-fluid">

    <h3>Modificar Usuario:</h3>
    <br>
  
  <form id="formulario_modificar" class="form-horizontal" role="form" method="post" data-toggle="validator" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    
    <input type="hidden" class="form-control" id="cedula_old" name="cedula_old" value="<?php echo $cedula; ?>"/>
    
      <!--CEDULA USUARIO-->
    <div class="form-group">
        <label for="cedula_usuario" class="col-xs-6 col-sm-2 control-label">*Cedula: </label>
        <div class="col-xs-12 col-sm-4">
         <input type="text" class="form-control solo-numero" id="cedula_usuario" name="cedula_usuario" pattern="[0-9]{6,8}" placeholder="Campo obligatorio" maxlength="8" onKeyUp="mayusculas(this);" data-error="Campo invalido, verifique." value="<?php echo $result['cedula']; ?>" required>
         <div class="help-block with-errors"></div>
         </div>
    </div> 
      
    <!--NOMBRE Y APELLIDO DEL USUARIO-->
       
     <div class="form-group">
        <label for="nombre_usuario" class="col-xs-6 col-sm-2 control-label">*Nombre: </label>
            <div class="col-xs-12 col-sm-4">
            <input type="text" class="form-control input_usuario" id="nombre_usuario" name="nombre_usuario" pattern="([a-zA-ZÁÉÍÓÚÜñáéíóúü]{1,}[\s]*)+" data-error="Verifique. Solo se permiten letras." placeholder="Campo obligatorio" maxlength="20" onKeyUp="mayusculas(this);" value="<?php echo $result['nombre']; ?>" required>
        <div class="help-block with-errors"></div>
        </div>
    </div> 
    
    <div class="form-group">
        <label for="apellido_usuario" class="col-xs-6 col-sm-2 control-label">*Apellido: </label>
            <div class="col-xs-12 col-sm-4">
            <input type="text" class="form-control input_usuario" id="apellido_usuario" name="apellido_usuario" pattern="([a-zA-ZÁÉÍÓÚÜñáéíóúü]{1,}[\s]*)+" data-error="Verifique. Solo se permiten letras." placeholder="Campo obligatorio" maxlength="20" onKeyUp="mayusculas(this);" value="<?php echo $result['apellido']; ?>" required>
        <div class="help-block with-errors"></div>
        </div>
    </div> 
    
     <!--INDICADOR-->
     <div class="form-group">
        <label for="indicador_usuario" class="col-xs-6 col-sm-2 control-label">*Indicador: </label>
            <div class="col-xs-12 col-sm-4">
            <input type="text" class="form-control input_usuario" id="indicador_usuario" name="indicador_usuario" pattern="[A-Z]{3,20}" data-error="Verifique. Solo se permiten letras sin espacios." placeholder="Campo obligatorio" maxlength="20" onKeyUp="mayusculas(this);" value="<?php echo $result['indicador']; ?>" required>
        <div class="help-block with-errors"></div>
        </div>
    </div> 
    
    <!--GERENCIA-->
    <div class="form-group">
        <label for="gerencia_usuario" class="col-xs-6 col-sm-2 control-label">*Gerencia: </label>
            <div class="col-xs-12 col-sm-5">
            <input type="text" class="form-control input_usuario" id="gerencia_usuario" name="gerencia_usuario" pattern="([a-zA-ZÁÉÍÓÚÜñáéíóúü]{1,}[\s]*)+" data-error="Verifique. Solo se permiten letras." placeholder="Campo obligatorio" maxlength="50" onKeyUp="mayusculas(this);" value="<?php echo $result['gerencia']; ?>" required>
        <div class="help-block with-errors"></div>
        </div>
    </div> 
    
    <!--UBICACION-->
    <div class="form-group">
        <label for="ubicacion_usuario" class="col-xs-6 col-sm-2 control-label ">*Ubicaci&oacute;n: </label>
            <div class="col-xs-12 col-sm-5">
            
            <select class="form-control input_usuario" id="ubicacion_usuario" name="ubicacion_usuario" required>
              <option <?php if($result['ubicacion']=="EL TIGRE") {echo "selected";};?> value="EL TIGRE">EL TIGRE</option>
              <option <?php if($result['ubicacion']=="PARIAGUAN") {echo "selected";};?> value="PARIAGUAN">PARIAGUAN</option>
              <option <?php if($result['ubicacion']=="PUERTO LA CRUZ") {echo "selected";};?> alue="PUERTO LA CRUZ">PUERTO LA CRUZ</option>
              <option <?php if($result['ubicacion']=="SAN DIEGO DE CABRUTICA") {echo "selected";};?> value="SAN DIEGO DE CABRUTICA">SAN DIEGO DE CABRUTICA</option>
              <option <?php if($result['ubicacion']=="SAN TOME") {echo "selected";};?> value="SAN TOME">SAN TOME</option>
              <option <?php if($result['ubicacion']=="ZUATA") {echo "selected";};?> value="ZUATA">ZUATA</option>
            </select>
            
        <div class="help-block with-errors"></div>
        </div>
    </div>
  	</form>
        
        <!--AGREGAR EQUIPOS-->
        <div class="form-group">
            <div class="col-xs-12 text-right">
            <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='usuarios.php';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
            <button type="submit" id="guardar" name="guardar" class="btn btn-default btn-xs-text" form="formulario_modificar"><span class=" glyphicon glyphicon-save" aria-hidden="true"></span>&nbsp;Guardar</button>
            </div>
        </div> 
    
</div>
<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js"></script>

</body>
</html>