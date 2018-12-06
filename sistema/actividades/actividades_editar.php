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
	
    $(".imagenes img").click(function () {
		
		var archivo = $(this).attr("src").split('/');
		//alert(archivo[2]);
		
            if ($(this).css("opacity")==1)
			{
				$(this).append('<input type="hidden" name="id_src[]" id="id_src" value="'+archivo[2]+'"/>');
				$(this).toggleClass("eliminar_adjuntos");
			}
			else
			{
				$('[id=id_src][value="'+archivo[2]+'"]').remove();
				$(this).toggleClass("eliminar_adjuntos");
			}
    });
			
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

<?php
session_start();
$conexion=conexion();

if (!isset($_POST['guardar']))
{
	$responsable=$_SESSION['usuario'];
	$actividad=$_GET['id_actividad'];
	//print_r($actividad);
	$consultar="SELECT * FROM actividades WHERE responsable='".$responsable."' AND responsable_correlativo='".$actividad."'";
	$query_consultar=query($consultar,$conexion);
	$result_consultar=fetch_array($query_consultar);
	
	$select_cuenta="SELECT COUNT(id_soporte_actividad) FROM actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$actividad."'
	GROUP BY id, id_actividad, responsable";
	$query_cuenta=query($select_cuenta,$conexion);
	$cuenta=num_rows($query_cuenta);
}
?>

<div class="container-fluid">

  <h3>Editar Actividad:</h3>
  <br>
  
  <form id="formulario_actividad" class="form-horizontal" role="form" method="post" data-toggle="validator" target="_self"  enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>">
      
      <!--RESUMEN DE ACTIVIDAD-->
      <div class="form-group">
        <label for="resumen_actividad" class="col-xs-6 col-sm-1 control-label">Resumen: </label>
        <div class="col-xs-12 col-sm-6">
        <input type="text" class="form-control" id="resumen_actividad" name="resumen_actividad" placeholder="Resumen" maxlength="100" onKeyUp="mayusculas(this);" value="<?php echo $result_consultar['resumen']; ?>" required>
        <div class="help-block with-errors"></div>
        </div>
      </div>  
      
      <!--DETALLE DE ACTIVIDAD-->
       <div class="form-group">
        <label for="detalle_actividad" class="col-xs-12 col-sm-1 control-label">Detalle: </label>
        <div class="col-xs-12 col-sm-10">
        <textarea class="form-control redimensionartextarea" id="detalle_actividad" name="detalle_actividad" placeholder="Detalle" maxlength="800" onKeyUp="mayusculas(this);" required><?php echo $result_consultar['detalle']; ?></textarea>
        <div class="help-block with-errors"></div>
        </div>
      </div>
          	
    <!--FECHA DE ACTIVIDAD-->
     	<div class="bootstrap-iso">     
         <div class="form-group ">
          <label class="col-xs-12 col-sm-1 control-label requiredField" for="fecha_actividad">Fecha:</label>
          <div class="col-xs-12 col-sm-4">
            <input class="form-control" id="fecha_actividad" name="fecha_actividad" placeholder="aaaa-mm-dd" type="text" value="<?php echo $result_consultar['fecha_actividad']; ?>" readonly required/>
            <div class="help-block with-errors"></div>
           </div>
          </div>
         </div>
         
         <!--FECHA DE REGISTRO EN EL SISTEMA-->
         <input type="hidden" class="form-control" id="fecha_registro" name="fecha_registro" value="<?php echo $result_consultar['fecha_registro']; ?>"/>
         
         <!--FECHA DE MODIFICACION-->
         <input type="hidden" class="form-control" id="fecha_modificacion" name="fecha_modificacion" value="<?php $hoy = getdate();  echo $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];?>"/>
         
         <input type="hidden" class="form-control" id="id_actividad" name="id_actividad" value="<?php echo $result_consultar['responsable_correlativo']; ?>"/>
          
<?php 
if (!isset($_POST['guardar']))
{
		  /*CONSULTAR SI LA ACTIVIDAD POSEE ALGUN ARCHIVO/SOPORTE ADJUNTO*/
			$select_cuenta="SELECT COUNT(id_soporte_actividad) FROM actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$actividad."'
			GROUP BY id, id_actividad, responsable";
			$query_cuenta=query($select_cuenta,$conexion);
			$cuenta=num_rows($query_cuenta);
			
			if($cuenta!=0)
			{?>
                      
              <!--CARGA DE IMAGENES-->
              <div class="row"> 
              <label for="file-es" class="col-xs-12 col-sm-1 control-label">Soportes: </label>
              <div class="col-xs-12 col-sm-10">
              <p class="imagenes" id="contenedor">
          
            <?php
				
				//echo $cuenta.' archivos.';
				$select_adjuntos="SELECT * FROM actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$actividad."'";
				$query_adjuntos=query($select_adjuntos,$conexion);
				while($result=fetch_array($query_adjuntos))
				{?>
                        <img src="<?php echo "soportes/".$responsable."/".$result['nombre_archivo'];?>" style="margin-bottom:5px;" id="source" class="img-thumbnail adjuntos" alt="" width="300" height="auto">
				<?php 
				}
				?>
              </p>
              </div>
              </div>
                <?php
			}

}

		$from=$_GET['from'];
		  ?>
		<input type="hidden" class="form-control" id="from" name="from" value="<?php echo $from; ?>"/>
          
          <!--FILEINPUT-->
          <div class="form-group ">
          <label for="file-es" class="col-xs-12 col-sm-1 control-label"><?php if($cuenta>0) {?><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span><?php } else echo 'Soportes:'; ?></label>
          <div class="col-xs-12 col-sm-10"><input class="file" id="archivo" name="archivo[]" type="file" accept=".jpeg, .jpg, .png, .bmp" multiple></div>
          </div>
          
        <!--BOTON DE GUARDADO-->
        <div class="form-group">
            <div class="col-xs-12 text-right">
            
            <?php if($from!=1){?>
            <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='actividades.php';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
             <?php } else {?>
             <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='actividades_consultar.php?id_actividad=<?php echo $actividad?>';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
             <?php }?>
            
            <button type="submit" id="guardar" name="guardar" title="Guardar Modificaci&oacute;n" class="btn btn-default btn-xs-text"><span class="glyphicon glyphicon-save" aria-hidden="true"></span>&nbsp;Guardar</button>
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
        allowedFileExtensions : ['jpg','jpeg', 'png','bmp'],
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
	//alert("hola");
	//print_r($_POST['id_src']);
	
	$id_actividad=$_POST['id_actividad'];
	$resumen=$_POST['resumen_actividad'];
	$detalle=$_POST['detalle_actividad'];
	$fecha_actividad=$_POST['fecha_actividad'];
	$fecha_modificacion=$_POST['fecha_modificacion'];
	$responsable=$_SESSION['usuario'];
	
	$cuenta=count($id_src=$_POST['id_src']);
	
	
	
	$actualizar="UPDATE actividades SET resumen='".$resumen."', detalle='".$detalle."', fecha_actividad='".$fecha_actividad."', fecha_modificacion='".$fecha_modificacion."' WHERE responsable_correlativo='$id_actividad' AND responsable='".$responsable."'";
	if (query($actualizar,$conexion))
	{
		if($cuenta>0) /*BORRAR ARCHIVOS ADJUNTOS DE LA ACTIVIDAD PREVIAMENTE CARGADOS*/
		{
			$i=0;
			while($i<$cuenta)
			{
				unlink("soportes/$responsable/".$id_src[$i]);
				$borrar_adjuntos="DELETE FROM actividades_soportes WHERE nombre_archivo='".$id_src[$i]."'";
				$query_borrar_adjuntos=query($borrar_adjuntos,$conexion);
				$i=$i+1;
			}
			
			$carpeta = @scandir("soportes/$responsable"); /*SI LA CARPETA DEL USUARIO QUEDA VACIA DESPUES DE ELIMINAR LOS ADJUNTOS, SE ELIMINA LA CARPETA TAMBIEN*/
			if (count($carpeta)<=2)
			{
				deleteDirectory("soportes/".$responsable);
			}
		}
		
		/*GUARDAR ARCHIVOS NUEVOS ARCHIVOS*/
		if($_FILES["archivo"]["name"][0])
		{
			$carpetaDestino="soportes/$responsable/";
			
			 for($i=0;$i<count($_FILES["archivo"]["name"]);$i++)
			 {
				$select_max_id_cont="select MAX(id_soporte_actividad) from actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$id_actividad."'";
				$query_max_id_cont=query($select_max_id_cont,$conexion);
				$array_max_id_cont=fetch_array($query_max_id_cont);
				$id_file_cont=$array_max_id_cont[0]+1;
				 
				$archivo=explode(".",$_FILES["archivo"]["name"][$i]);
				//$extension=$archivo[1];
				$archivo[0]=$responsable."_".$id_actividad."_".$id_file_cont."_".$fecha_actividad."_".$fecha_modificacion;
				$archivo=$archivo[0].".".$archivo[1];
				
				//echo "<br>".$archivo;
				
				if(file_exists($carpetaDestino) || @mkdir($carpetaDestino))
				{
					$origen=$_FILES["archivo"]["tmp_name"][$i];
					$destino=$carpetaDestino.$archivo;
					
					if(@move_uploaded_file($origen, $destino))
					{
						$conexion=conexion();
						/*SIGUIENTE CORRELATIVO DE IMAGEN*/
						$select_max_id="select MAX(id) from actividades_soportes";
						$query_max_id=query($select_max_id,$conexion);
						$array_max_id=fetch_array($query_max_id);
						$id_file=$array_max_id[0]+1;
						
						$insert_file="INSERT INTO actividades_soportes VALUES ('".$id_file."','".$id_actividad."','".$id_file_cont."','".$archivo."','".$responsable."')";
						//print_r($insert_file);
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
		
		alert("Registro Actualizado.");
		
		if($_POST['from']==1)
		{
			redireccionar("actividades_editar.php?from=1&id_actividad=".$id_actividad);
		}
		else
		{
			redireccionar("actividades_editar.php?id_actividad=".$id_actividad);
		}
	}
}
?>