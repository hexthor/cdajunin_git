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

<!--<link href="../../css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="../../js/fileinput.js" type="text/javascript"></script>
<script src="../../js/fileinput_locale_es.js" type="text/javascript"></script>-->

<link href="../../css/bootstrap-datepicker3.css" rel="stylesheet"/>
<script type="text/javascript" src="../../js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.es.min.js"></script>

<script type="text/javascript" class="init">
	
$(document).ready(function() {
		/*$('#tablon').DataTable({
				"order": [4, "desc"],
				"bPaginate": true,
				"columnDefs": [{"orderable": false, targets: [0,1,2,5,6,7,8]}]  Tiene que corresponder al numero exacto de columnas, no se debe colocar colmunas que no existen
			});*/	
			
			
	  var date_input=$('input[name="fecha_registro"]'); //our date input has the name "date"
      var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
      var options={
        format: 'yyyy-mm-dd',
		language: "es",
        container: container,
        todayHighlight: true,
        autoclose: true,
		orientation: "right", 
		//clearBtn: true,
		
		//NO SE PUEDE AGREGAR ACTIVIDADES PARA EL DIA DE MAÑANA, NI ANTES DE 7 DIAS.
		startDate: "-7d",
		endDate: "+d",
      };
      date_input.datepicker(options);
						
	  });
	  
</script>

</head>
<body>

<?php
session_start();
$conexion=conexion();
if (!isset($_POST['guardar']))
{
	$responsable=$_SESSION['usuario'];
	$pendiente=$_GET['id_pendiente'];
	//print_r($actividad);
	$consultar="SELECT * FROM pendientes WHERE id=$pendiente";
	$query_consultar=query($consultar,$conexion);
	$result=fetch_array($query_consultar);
	$from=$_GET['from'];
}
?>

<div class="container-fluid">

  <h3>Editar Pendiente:</h3>
  <br>
  
  <form id="formulario_pendiente" class="form-horizontal" role="form" method="post" data-toggle="validator" target="_self"  enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      
      <!--RESUMEN DE ACTIVIDAD-->
      <div class="form-group">
        <label for="resumen_pendiente" class="col-xs-6 col-sm-1 control-label">*Resumen: </label>
        <div class="col-xs-12 col-sm-6">
        <input type="text" class="form-control" id="resumen_pendiente" name="resumen_pendiente" <?php if($result['estado']=='CERRADO'){ echo "readonly";}?> placeholder="Campo obligatorio" maxlength="100" onKeyUp="mayusculas(this);" value="<?php echo $result['resumen']; ?>"  required>
        <div class="help-block with-errors"></div>
        </div>
      </div>  
      
      <!--DETALLE DE ACTIVIDAD-->
       <div class="form-group">
        <label for="detalle_pendiente" class="col-xs-12 col-sm-1 control-label">*Detalle: </label>
        <div class="col-xs-12 col-sm-10">
        <textarea class="form-control redimensionartextarea" id="detalle_pendiente" name="detalle_pendiente" <?php if($result['estado']=='CERRADO'){ echo "readonly";}?> placeholder="Campo obligatorio" maxlength="800" onKeyUp="mayusculas(this);" required><?php echo $result['detalle']; ?></textarea>
        <div class="help-block with-errors"></div>
        </div>
      </div>
          	
    <!--FECHA DE ACTIVIDAD-->
     	<div class="bootstrap-iso">     
         <div class="form-group ">
          <label class="col-xs-12 col-sm-1 control-label requiredField" for="fecha_registro">*Fecha:</label>
          <div class="col-xs-12 col-sm-4">
            <input class="form-control" type="text" <?php if($result['estado']!='CERRADO'){ echo 'id="fecha_registro" name="fecha_registro"';}?> value="<?php echo $result['fecha_registro']; ?>" readonly required/>
            <div class="help-block with-errors"></div>
           </div>
          </div>
         </div>
  
  <?php if($result['estado']=='CERRADO'){?>       
   <!--ESTADO DE ACTIVIDAD-->
      <div class="form-group">
        <label for="estado_pendiente" class="col-xs-6 col-sm-1 control-label">*Estado: </label>
        <div class="col-xs-12 col-sm-4">
        
        <select class="form-control" id="estado_pendiente" name="estado_pendiente">
          <option selected>CERRADO</option>
          <option>ACTIVO</option>
        </select>
        
        <!--<input type="text" class="form-control" id="estado_pendiente" name="estado_pendiente" placeholder="Campo obligatorio" maxlength="100" onKeyUp="mayusculas(this);" value="<?php echo $result['estado']; ?>"  required>-->
        <div class="help-block with-errors"></div>
        </div>
      </div> 
      
      <?php }?>      
         
         <input type="hidden" class="form-control" id="id_pendiente" name="id_pendiente" value="<?php echo $result['id']; ?>"/>
         <input type="hidden" class="form-control" id="from" name="from" value="<?php echo $from; ?>"/>
                             
        <!--BOTON DE GUARDADO-->
        <div class="form-group">
            <div class="col-xs-12 text-right">
            
            <?php if($from!=1){?>
            <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='pendientes.php';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
             <?php } else {?>
             <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='pendientes_consultar.php?id_pendiente=<?php echo $pendiente?>';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
             <?php }?>
            
             <button type="submit" id="guardar" name="guardar" class="btn btn-default btn-xs-text" title="Guardar Modificaci&oacute;n"><span class="glyphicon glyphicon-save" aria-hidden="true"></span>&nbsp;Guardar</button>
            </div>
        </div>  
  	</form>
</div>
<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js"></script>
</body>
</html>

<?php 
$conexion=conexion();

if (isset($_POST['guardar']))
{
	session_start();
	$id_pendiente=$_POST['id_pendiente'];
	$resumen=$_POST['resumen_pendiente'];
	$detalle=$_POST['detalle_pendiente'];
	$estado=$_POST['estado_pendiente'];
	$fecha_registro=$_POST['fecha_registro'];
	$responsable=$_SESSION['usuario'];
	
	//alert($estado);
	if($estado!='')
	{
		$actualizar="UPDATE pendientes SET estado='".$estado."' WHERE id='$id_pendiente'";
	}
	else
	{	
		$actualizar="UPDATE pendientes SET resumen='".$resumen."', detalle='".$detalle."', fecha_registro='".$fecha_registro."' WHERE id='$id_pendiente'";
	}
		
	if (query($actualizar,$conexion))
	{
		alert("Registro Actualizado.");
		
		/*****MODIFICAR VALOR DEL BADGE PENDIENTES*****/
		$select_pendiente="SELECT * FROM pendientes WHERE estado!='CERRADO'";
		$query_pend=query($select_pendiente,$conexion);
		$num_rows=num_rows($query_pend);
		badge($num_rows);
		/**********************************************/
		
		if($_POST['from']==1)
		{
			redireccionar("pendientes_editar.php?from=1&id_pendiente=".$id_pendiente);
		}
		else
		{
			redireccionar("pendientes_editar.php?id_pendiente=".$id_pendiente);
		}
		//confirmar_seguir("Informacion guardada con exito. ¿Desea continuar?","pendientes.php");
	}
}
?>