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
		/*$('#tablon').DataTable({
				"order": [4, "desc"],
				"bPaginate": true,
				"columnDefs": [{"orderable": false, targets: [0,1,2,5,6,7,8]}]  Tiene que corresponder al numero exacto de columnas, no se debe colocar colmunas que no existen
			});*/	
			
			
	  var date_input=$('input[name="fecha_actividad"]'); //our date input has the name "date"
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

  <h3>Agregar Actividad:</h3>
  <br>
  
  <form id="formulario_actividad" class="form-horizontal" role="form" method="post" data-toggle="validator" target="_self"  enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      
      <!--RESUMEN DE ACTIVIDAD-->
      <div class="form-group">
        <label for="resumen_actividad" class="col-xs-6 col-sm-1 control-label">*Resumen: </label>
        <div class="col-xs-12 col-sm-6">
        <input type="text" class="form-control" id="resumen_actividad" name="resumen_actividad" placeholder="Campo obligatorio" maxlength="100" onKeyUp="mayusculas(this);" required>
        <div class="help-block with-errors"></div>
        </div>
      </div>  
      
      <!--DETALLE DE ACTIVIDAD-->
       <div class="form-group">
        <label for="detalle_actividad" class="col-xs-12 col-sm-1 control-label">*Detalle: </label>
        <div class="col-xs-12 col-sm-10">
        <textarea class="form-control redimensionartextarea" id="detalle_actividad" name="detalle_actividad" placeholder="Campo obligatorio" maxlength="800" onKeyUp="mayusculas(this);" required></textarea>
        <div class="help-block with-errors"></div>
        </div>
      </div>
          	
    <!--FECHA DE ACTIVIDAD-->
     	<div class="bootstrap-iso">     
         <div class="form-group ">
          <label class="col-xs-12 col-sm-1 control-label requiredField" for="fecha_actividad">*Fecha:</label>
          <div class="col-xs-12 col-sm-4">
            <input class="form-control" id="fecha_actividad" name="fecha_actividad" value="<?php fecha_hoy_php();?>" type="text" readonly required/>
            <div class="help-block with-errors"></div>
           </div>
          </div>
         </div>
         
         <!--FECHA DE REGISTRO EN EL SISTEMA-->
         <input type="hidden" class="form-control" id="fecha_registro" name="fecha_registro" value="<?php $hoy = getdate();  echo $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];?>"/>
          
          <!--FILEINPUT-->
          <div class="form-group ">
          <label for="file-es" class="col-xs-12 col-sm-1 control-label">Soportes: </label>
          <div class="col-xs-12 col-sm-10"><input class="file" id="archivo" name="archivo[]" type="file" accept=".jpeg, .jpg, .png" multiple></div>
          </div>
          
        <!--BOTON DE GUARDADO-->
        <div class="form-group">
            <div class="col-xs-12 text-right">
            <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='actividades.php';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
             <button type="submit" id="guardar" name="guardar" title="Guardar Actividad" class="btn btn-default btn-xs-text"><span class="glyphicon glyphicon-save" aria-hidden="true"></span>&nbsp;Guardar</button>
            </div>
        </div>  
  	</form>
</div>
<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js"></script>
	<script>
    $('#archivo').fileinput({
        language: 'es',
		 //maxFilePreviewSize: 240,
        //uploadUrl: 'http://localhost:8080/cdajunin/adjuntos',
		//uploadAsync: false,
		//allowedFileTypes: ['image'],
        allowedFileExtensions : ['jpg','jpeg', 'png'],
		showUpload: false,
		showCaption: false,
		overwriteInitial: false,
		
				
		//showBrowse: false,
		//browseOnZoneClick: true,
		
		maxFileCount: 20,
		
		//maxFileSize: 1000,
       // maxFilesNum: 10,
	   
		
		slugCallback: function(filename) {
            return filename.replace('(', '_').replace(']', '_');
        }
});
	</script>
</body>
</html>

<?php 
$conexion=conexion();

if (isset($_POST['guardar']))
{
	session_start();
	
	$resumen=$_POST['resumen_actividad'];
	$detalle=$_POST['detalle_actividad'];
	$fecha_registro=$_POST['fecha_registro'];
	$fecha_actividad=$_POST['fecha_actividad'];
	$responsable=$_SESSION['usuario'];
	
	/*SIGUIENTE CORRELATIVO DE ACTIVIDAD GLOBAL*/
	$select_act="select MAX(id) from actividades";
	$query_act=query($select_act,$conexion);
	$array_act=fetch_array($query_act);
	$id_actividad=$array_act[0]+1;
	
	/*SIGUIENTE CORRELATIVO DE ACTIVIDAD POR RESPONSABLE*/
	$select_act_resp="select MAX(responsable_correlativo) from actividades WHERE responsable='".$responsable."'";
	$query_act_resp=query($select_act_resp,$conexion);
	$array_act_resp=fetch_array($query_act_resp);
	$id_actividad_resp=$array_act_resp[0]+1;
	
$consulta="INSERT INTO actividades (id,resumen, detalle, fecha_registro, fecha_actividad, responsable, responsable_correlativo) VALUES ('".$id_actividad."','".$resumen."','".$detalle."','".$fecha_registro."','".$fecha_actividad."','".$responsable."','".$id_actividad_resp."')";
	if (query($consulta,$conexion))
	{
		/*GUARDAR ARCHIVOS*/
		if($_FILES["archivo"]["name"][0])
		{
			$carpetaDestino="soportes/$responsable/";
			
			//echo $carpetaDestino;
			
			 for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
			 {
				$contador=$i+1;
				$archivo=explode(".",$_FILES["archivo"]["name"][$i]);
				//$extension=$archivo[1];
				$archivo[0]=$responsable."_".$id_actividad_resp."_".$contador."_".$fecha_actividad."_".$fecha_registro;
				$archivo=$archivo[0].".".$archivo[1];
				
				//echo "<br>".$archivo;
				
				if(file_exists($carpetaDestino) || @mkdir($carpetaDestino))
				{
					$origen=$_FILES["archivo"]["tmp_name"][$i];
					$destino=$carpetaDestino.$archivo;
					
					if(@move_uploaded_file($origen, $destino))
					{
						/*SIGUIENTE CORRELATIVO DE IMAGEN*/
						$select_max_id="select MAX(id) from actividades_soportes";
						$query_max_id=query($select_max_id,$conexion);
						$array_max_id=fetch_array($query_max_id);
						$id_file=$array_max_id[0]+1;
						
						$insert_file="INSERT INTO actividades_soportes VALUES ('".$id_file."','".$id_actividad_resp."','".$contador."','".$archivo."','".$responsable."')";
						$query_file_insert=query($insert_file,$conexion);
					}
					else
					{
						echo "<br>No se ha podido mover el archivo: ".$archivo;
					}
				}
				else
				{
					echo "<br>No se ha podido crear la carpeta: ".$carpetaDestino;
				}
			}
		}
				
		confirmar_seguir("Informacion guardada con exito. ¿Desea continuar?","actividades.php");
	}
}
?>