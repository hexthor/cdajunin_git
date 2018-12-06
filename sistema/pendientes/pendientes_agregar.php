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

<div class="container-fluid">

  <h3>Agregar Pendiente:</h3>
  <br>
  
  <form id="formulario_pendiente" class="form-horizontal" role="form" method="post" data-toggle="validator" target="_self"  enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      
      <!--RESUMEN DE ACTIVIDAD-->
      <div class="form-group">
        <label for="resumen_pendiente" class="col-xs-6 col-sm-1 control-label">*Resumen: </label>
        <div class="col-xs-12 col-sm-6">
        <input type="text" class="form-control" id="resumen_pendiente" name="resumen_pendiente" placeholder="Campo obligatorio" maxlength="100" onKeyUp="mayusculas(this);" required>
        <div class="help-block with-errors"></div>
        </div>
      </div>  
      
      <!--DETALLE DE ACTIVIDAD-->
       <div class="form-group">
        <label for="detalle_pendiente" class="col-xs-12 col-sm-1 control-label">*Detalle: </label>
        <div class="col-xs-12 col-sm-10">
        <textarea class="form-control redimensionartextarea" id="detalle_pendiente" name="detalle_pendiente" placeholder="Campo obligatorio" maxlength="800" onKeyUp="mayusculas(this);" required></textarea>
        <div class="help-block with-errors"></div>
        </div>
      </div>
          	
    <!--FECHA DE ACTIVIDAD-->
     	<div class="bootstrap-iso">     
         <div class="form-group ">
          <label class="col-xs-12 col-sm-1 control-label requiredField" for="fecha_registro">*Fecha:</label>
          <div class="col-xs-12 col-sm-4">
            <input class="form-control" id="fecha_registro" name="fecha_registro" type="text" value="<?php fecha_hoy_php();?>" readonly required/>
            <div class="help-block with-errors"></div>
           </div>
          </div>
         </div>
         
         <!--FECHA DE REGISTRO EN EL SISTEMA-->
         <!--<input type="hidden" class="form-control" id="fecha_registro" name="fecha_registro" value="<?php $hoy = getdate();  echo $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];?>"/>-->
                    
        <!--BOTON DE GUARDADO-->
        <div class="form-group">
            <div class="col-xs-12 text-right">
            <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='pendientes.php';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
             <button type="submit" id="guardar" name="guardar" title="Guardar Pendiente" class="btn btn-default btn-xs-text"><span class="glyphicon glyphicon-save" aria-hidden="true"></span>&nbsp;Guardar</button>
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
	
	$resumen=$_POST['resumen_pendiente'];
	$detalle=$_POST['detalle_pendiente'];
	$fecha_registro=$_POST['fecha_registro'];
	$responsable=$_SESSION['usuario'];
	$estado='ACTIVO';
	
	/*SIGUIENTE CORRELATIVO DE PENDIENTES*/
	$select_pend="select MAX(id) from pendientes";
	$query_pend=query($select_pend,$conexion);
	$array_pend=fetch_array($query_pend);
	$id_pendiente=$array_pend[0]+1;
		
$consulta="INSERT INTO pendientes (id,resumen, detalle, fecha_registro, estado, responsable) VALUES ('".$id_pendiente."','".$resumen."','".$detalle."','".$fecha_registro."','".$estado."','".$responsable."')";
	if (query($consulta,$conexion))
	{
		/*****MODIFICAR VALOR DEL BADGE PENDIENTES*****/
		$select_pendiente="SELECT * FROM pendientes WHERE estado!='CERRADO'";
		$query_pend=query($select_pendiente,$conexion);
		$num_rows=num_rows($query_pend);
		badge($num_rows);
		/**********************************************/
		
		confirmar_seguir("Informacion guardada con exito. ¿Desea continuar?","pendientes.php");
	}
}
?>