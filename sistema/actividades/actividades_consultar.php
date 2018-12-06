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
<!--<script type="text/javascript" src="../../js/validator.js"></script>-->
<script type="text/javascript" src="../../js/funciones.js"></script>

<!--<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<link href="../../css/dataTables.bootstrap.min.css" rel="stylesheet"/>
<script type="text/javascript" src="../../js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap-hover-dropdown.js"></script>-->

<!--<link href="../../css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
<script src="../../js/fileinput.js" type="text/javascript"></script>
<script src="../../js/fileinput_locale_es.js" type="text/javascript"></script>-->

<!--<link href="../../css/bootstrap-datepicker3.css" rel="stylesheet"/>
<script type="text/javascript" src="../../js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.es.min.js"></script>-->



<script type="text/javascript" class="init">
$(document).ready(function() {
	
	$('#boton_correo').click(function() {
		$('#div_correo').toggleClass("div_correus");
	});
			
	$('.imagenes img').click(function() {
			if(($('.imagenes img').css("cursor"))=='pointer')
			{
				$('.imagenes img').toggleClass("adjuntos2");
			}
	});
/*CAMPO PARA******************************************************************************************************************************/	
	var MaxInputs       = 4; //Número Maximo de Campos
    var contenedor       = $("#contenedor"); //ID del contenedor
    var AddButton       = $("#agregarCampo"); //ID del Botón Agregar

    //var x = número de campos existentes en el contenedor
    var x = $("#contenedor div").length + 1;
    var FieldCount = x-1; //para el seguimiento de los campos

    $(AddButton).click(function (e) {
        if(x <= MaxInputs) //max input box allowed
        {
            FieldCount++;
            //agregar campo
            $(contenedor).append(
			'<div class="form-group" id="div'+FieldCount+'">'+
				'<label for="para_email" class="col-xs-6 col-sm-1 control-label"></label>'+
				'<div class="col-xs-12 col-sm-4">'+
					'<div class="input-group">'+
						'<input type="email" class="form-control input_email" id="para_email_'+FieldCount+'" name="para_email[]" placeholder="" maxlength="30" onKeyUp="mayusculas(this);" required>'+
						'<span class="input-group-btn">'+
						'<button class="btn btn-secondary eliminar" id="borrar_'+FieldCount+'" type="button"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></button>'+
						'</span>'+
					'</div>'+
				'</div>'+
			'</div>'
			);
            x++; //text box increment
        }
        return false;
    });
	
	$("body").on("click",".eliminar", function(){ //click en eliminar campo
		if( x > 1 )
		{
			var variable = $(this).attr("id").split('_');
			$('[id=div'+variable[1]+']').remove();
			x--;
		}
		return false;
	 });

/*CAMPO CC******************************************************************************************************************************/

	var MaxInputs_cc       = 4; //Número Maximo de Campos
    var contenedor_cc       = $("#contenedor_cc"); //ID del contenedor
    var AddButton_cc       = $("#agregarCampo_cc"); //ID del Botón Agregar
	
	//var x = número de campos existentes en el contenedor
    var x_cc = $("#contenedor_cc div").length + 1;
    var FieldCount_cc = x_cc-1; //para el seguimiento de los campos
	
	    $(AddButton_cc).click(function (e) {
        if(x_cc <= MaxInputs_cc) //max input box allowed
        {
            FieldCount_cc++;
            //agregar campo
            $(contenedor_cc).append(
			'<div class="form-group" id="divcc_'+FieldCount_cc+'">'+
				'<label for="cc_email" class="col-xs-6 col-sm-1 control-label"></label>'+
				'<div class="col-xs-12 col-sm-4">'+
					'<div class="input-group">'+
						'<input type="email" class="form-control input_email" id="cc_email_'+FieldCount_cc+'" name="cc_email[]" placeholder="" maxlength="30" onKeyUp="mayusculas(this);" required>'+
						'<span class="input-group-btn">'+
						'<button class="btn btn-secondary eliminar_cc" id="borrarcc_'+FieldCount_cc+'" type="button"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></button>'+
						'</span>'+
					'</div>'+
				'</div>'+
			'</div>'
			);
            x_cc++; //text box increment
        }
        return false;
    });


	$("body").on("click",".eliminar_cc", function(){ //click en eliminar campo
		if( x_cc > 1 )
		{
			var variable = $(this).attr("id").split('_');
			$('[id=divcc_'+variable[1]+']').remove();
			x_cc--;
		}
		return false;
	 });

/*CAMPO BCC******************************************************************************************************************************/

	var MaxInputs_bcc       = 4; //Número Maximo de Campos
    var contenedor_bcc       = $("#contenedor_bcc"); //ID del contenedor
    var AddButton_bcc       = $("#agregarCampo_bcc"); //ID del Botón Agregar
	
	//var x = número de campos existentes en el contenedor
    var x_bcc = $("#contenedor_bcc div").length + 1;
    var FieldCount_bcc = x_bcc-1; //para el seguimiento de los campos
	
	    $(AddButton_bcc).click(function (e) {
        if(x_bcc <= MaxInputs_bcc) //max input box allowed
        {
            FieldCount_bcc++;
            //agregar campo
            $(contenedor_bcc).append(
			'<div class="form-group" id="divbcc_'+FieldCount_bcc+'">'+
				'<label for="bcc_email" class="col-xs-6 col-sm-1 control-label"></label>'+
				'<div class="col-xs-12 col-sm-4">'+
					'<div class="input-group">'+
						'<input type="email" class="form-control input_email" id="bcc_email_'+FieldCount_bcc+'" name="bcc_email[]" placeholder="" maxlength="30" onKeyUp="mayusculas(this);" required>'+
						'<span class="input-group-btn">'+
						'<button class="btn btn-secondary eliminar_bcc" id="borrarbcc_'+FieldCount_bcc+'" type="button"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></button>'+
						'</span>'+
					'</div>'+
				'</div>'+
			'</div>'
			);
            x_bcc++; //text box increment
        }
        return false;
    });


	$("body").on("click",".eliminar_bcc", function(){ //click en eliminar campo
		if( x_bcc > 1 )
		{
			var variable = $(this).attr("id").split('_');
			$('[id=divbcc_'+variable[1]+']').remove();
			x_bcc--;
		}
		return false;
	 });

/*VALIDACIONES******************************************************************************************************************************/
	 
	 //$('button[type="submit"]').attr('disabled','disabled');
	 $('button[type="submit"]').addClass('disabled');
	 
	$('body').on('blur',".input_email", function(e) {
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var variable = $(this).attr("id").split('_');
		var campus= $('#para_email_0').val();
		var campus1= $('#clave_email').val();
		var campus2= $('#asunto_email').val();
		var campus3= $('#mensaje_email').val();
		//var patron;
		
		if (this.value == "" || this.value == null || reg.test(this.value) == false)
		{
			//if(reg.test(campus) == false){}
			$(this).css({"background-color": "#FFA1A3","font-weight": "bolder"});
			if(campus=="" || campus==null || campus1=="" || campus1==null || campus2=="" || campus2==null || campus3=="" || campus3==null || reg.test(campus) == false)
			{
				//$('button[type="submit"]').attr('disabled','disabled');
				$('button[type="submit"]').addClass('disabled');
			}
			alert('Ingrese una dirección de correo valida.\nFormato: correo@dominio.com');
            return false;
		}
		else
		{
			if(campus!="" && campus1!="" && campus2!="" && campus3!="" && reg.test(campus) != false)
			{
				//$('button[type="submit"]').removeAttr('disabled');
				$('button[type="submit"]').removeClass('disabled');
			}
			$(this).css({"background-color":"#FFF", "font-weight": "normal"});
        	return true;
		}
	});
	
	$('body').on('blur',".requeridos", function(e) {
		var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
		var campus= $('#para_email_0').val();
		var campus1= $('#clave_email').val();
		var campus2= $('#asunto_email').val();
		var campus3= $('#mensaje_email').val();
		
		if (this.value == "" || this.value == null)
		{
			if(campus=="" || campus==null || campus1=="" || campus1==null || campus2=="" || campus2==null || campus3=="" || campus3==null || reg.test(campus) == false)
			{
				//$('button[type="submit"]').attr('disabled','disabled');
				$('button[type="submit"]').addClass('disabled');
			}
			$(this).css({"background-color": "#FFA1A3","font-weight": "bolder"});
			alert('Existen campos vacios!');
            return false;
		}
		else
		{
			if(campus!="" && campus1!="" && campus2!="" && campus3!="" && reg.test(campus) != false)
			{
				//$('button[type="submit"]').removeAttr('disabled');
				$('button[type="submit"]').removeClass('disabled');
			}
			$(this).css({"background-color":"#FFF", "font-weight": "normal"});
        	return true;
		}
	});	
});
</script>

</head>
<body>
<?php
session_start();
$conexion=conexion();
$responsable=$_SESSION['usuario'];

//if(isset($_POST['id_actividad'])){$actividad=$_POST['id_actividad'];} else {$actividad=$_GET['id_actividad'];}
$actividad=$_GET['id_actividad'];
$consultar="SELECT * FROM actividades WHERE responsable='".$responsable."' AND responsable_correlativo='".$actividad."'";
$query_consultar=query($consultar,$conexion);
$result_consultar=fetch_array($query_consultar);

//print_r($result_consultar);

?>

<div class="container-fluid">

  <h3 class="text-center"><strong><!--Actividad: --><?php echo $result_consultar['resumen']; ?></strong></h3>
  <br>

      <!--RESUMEN DE ACTIVIDAD-->
      <!--<div class="row">
        <label for="resumen_actividad" class="col-xs-6 col-sm-1 control-label">Resumen: </label>
        <div class="col-xs-12 col-sm-6">
        <p><u><?php echo $result_consultar['resumen']; ?></u></p>
        </div>
      </div>  
      <br>-->
      
      <!--DETALLE DE ACTIVIDAD-->
       <div class="row">
        <label for="detalle_actividad" class="col-xs-12 col-sm-1 control-label">Detalle: </label>
        <div class="col-xs-12 col-sm-10">
        <p class="text-justify"><?php echo nl2br(htmlentities($result_consultar['detalle'])); ?></p>
        </div>
      </div>
      <br>
      
    <!--CARGA DE IMAGENES-->
     	<div class="row">     
          <label class="col-xs-12 col-sm-1 control-label requiredField" for="fecha_actividad">Fecha:</label>
          <div class="col-xs-12 col-sm-4">
            <p><?php echo $result_consultar['fecha_actividad']; ?></p>
          </div>
         </div>
         <br>
<?php
                  /*CONSULTAR SI LA ACTIVIDAD POSEE ALGUN ARCHIVO/SOPORTE ADJUNTO*/
                    $select_cuenta="SELECT COUNT(id_soporte_actividad) FROM actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$actividad."'
                    GROUP BY id, id_actividad, responsable";
                    $query_cuenta=query($select_cuenta,$conexion);
                    $cuenta=num_rows($query_cuenta);
					if($cuenta!=0)
					{
?>         
	
<form id="formulario_actividad" class="form-horizontal" role="form" method="post" target="_self"  enctype="multipart/form-data" action="actividades_consultar_email.php" novalidate>

<?php } ?>

          <!--FILEINPUT-->
          <div class="row"> 
          <label for="file-es" class="col-xs-12 col-sm-1 control-label">Soportes: </label>
              <div class="col-xs-12 col-sm-10">
                  <p class="imagenes">
                  <?php 
                    if($cuenta!=0)
                    {
                        $select_adjuntos="SELECT * FROM actividades_soportes WHERE responsable='".$responsable."' AND id_actividad='".$actividad."'";
                        $query_adjuntos=query($select_adjuntos,$conexion);
                        while($result=fetch_array($query_adjuntos))
                        {?>
                          <img src="<?php echo "soportes/".$responsable."/".$result['nombre_archivo'];?>" style="margin-bottom:5px;" class="img-thumbnail adjuntos" alt="" width="300" height="auto">
                          <input type="hidden" name="id_src[]" id="id_src" value="<?php echo $result['nombre_archivo'];?>"/>
                        <?php
                        }
                    }
                    else
                    {
                        echo 'Sin Soportes'; 	
                    }
                  ?>
                  </p>
              </div>
          </div>
          
        <!--FORMULARIO PARA ENVIAR POR CORREO--> 
         <div id="div_correo" class="div_correus"> 
         <br>
         	<div class="row">
                <div class="col-xs-12 text-center">
                    <h4><strong>Enviar actividad por correo:</strong></h4>
                </div>
            </div>
            <br>

<?php if($cuenta==0){?>        
<form id="formulario_actividad" class="form-horizontal" role="form" method="post" target="_self"  enctype="multipart/form-data" action="actividades_consultar_email.php" novalidate>	 
<?php }?>  
          
           <div class="form-group">
            <label for="para_email" class="col-xs-6 col-sm-1 control-label">*Para: </label>
            <div class="col-xs-12 col-sm-4">
                <div class="input-group">
                    <input type="text" class="form-control input_email" id="para_email_0" name="para_email[]" placeholder="Campo obligatorio" maxlength="30" onKeyUp="mayusculas(this);">
                    <span class="input-group-btn">
                    <button class="btn btn-secondary" id="agregarCampo" type="button"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
                    </span>
                </div>
                <div class="help-block with-errors"></div>
            </div>
          </div>

           <div id="contenedor"></div> 
          
          <div class="form-group">
            <label for="cc_email" class="col-xs-6 col-sm-1 control-label">CC: </label>
            <div class="col-xs-12 col-sm-4">
            <div class="input-group">
            <input type="email" class="form-control input_email" id="cc_email_0" name="cc_email[]" placeholder="" maxlength="30" onKeyUp="mayusculas(this);">
            <span class="input-group-btn">
            <button class="btn btn-secondary" id="agregarCampo_cc" type="button"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
            </span>
            </div>
            <div class="help-block with-errors"></div>
            </div>
          </div>
          
          <div id="contenedor_cc"></div> 
          
          <div class="form-group">
            <label for="bcc_email" class="col-xs-6 col-sm-1 control-label">CCO: </label>
            <div class="col-xs-12 col-sm-4">
            <div class="input-group">
            <input type="email" class="form-control input_email" id="bcc_email_0" name="bcc_email[]" placeholder="" maxlength="30" onKeyUp="mayusculas(this);">
            <span class="input-group-btn">
            <button class="btn btn-secondary" id="agregarCampo_bcc" type="button"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
            </span>
            </div>
            <div class="help-block with-errors"></div>
            </div>
          </div>
          
          <div id="contenedor_bcc"></div> 
          
          <div class="form-group">
            <label for="asunto_email" class="col-xs-6 col-sm-1 control-label">*Asunto: </label>
            <div class="col-xs-12 col-sm-6">
            <input type="text" class="form-control requeridos" id="asunto_email" name="asunto_email" placeholder="Campo obligatorio" maxlength="150" value="<?php echo $result_consultar['resumen']; ?>">
            <div class="help-block with-errors"></div>
            </div>
          </div>
          
          <div class="form-group">
            <label for="mensaje_email" class="col-xs-12 col-sm-1 control-label">*Mensaje: </label>
            <div class="col-xs-12 col-sm-10">
                <textarea class="form-control redimensionartextarea requeridos" id="mensaje_email" name="mensaje_email" placeholder="Campo obligatorio" maxlength="800"><?php echo $result_consultar['detalle']; ?></textarea>
            <div class="help-block with-errors"></div>
            </div>
          </div>
          
<?php if($cuenta!=0)
{?>          
          <div class="form-group">
            <div class="col-sm-offset-1 col-sm-10">
              <div class="checkbox">
                <label>
                  <input type="checkbox" id="check_soportes_email" name="check_soportes_email" value="1" checked> <strong>Adjuntar Soportes.</strong>
                </label>
              </div>
            </div>
          </div>
 <?php } ?>    
 
      	  <div class="form-group">
            <label for="clave_email" class="col-xs-6 col-sm-1 control-label">*Clave: </label>
            <div class="col-xs-12 col-sm-3">
            <input type="password" class="form-control requeridos" id="clave_email" name="clave_email" placeholder="Campo obligatorio" maxlength="30">
            <div class="help-block with-errors"></div>
            </div>
          </div>
          
          
          <div class="form-group">
            <div class="col-xs-12 text-center">
             <button type="submit" id="enviar_email" name="enviar_email" class="btn btn-default"><span class="glyphicon glyphicon-send" aria-hidden="true"></span>&nbsp;Enviar</button>
            </div>
          </div>
          
          <input type="hidden" class="form-control" id="id_actividad" name="id_actividad" value="<?php echo $actividad;?>"/>
          <input type="hidden" class="form-control" id="resumen" name="resumen" value="<?php echo $result_consultar['resumen']; ?>"/>
          <input type="hidden" class="form-control" id="detalle" name="detalle" value="<?php echo $result_consultar['detalle']; ?>"/>
          <input type="hidden" class="form-control" id="fecha_actividad" name="fecha_actividad" value="<?php echo $result_consultar['fecha_actividad']; ?>"/>
           
         </div>
         
        <!--BOTON DE REGRESAR-->
        <div class="row"> 
            <div class="col-xs-12 text-right">
          
        <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='actividades.php';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>

            <!--<a target="_blank" href="actividades_pdf.php?id_actividad=<?php echo $actividad;?>" title="PDF" class="btn btn-default"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span>&nbsp;PDF</a>-->
        
        <button type="button" class="btn btn-default btn-xs-text" title="Editar actividad" onClick="location.href='actividades_editar.php?from=1&id_actividad=<?php echo $actividad;?>';"><span class=" glyphicon glyphicon-edit"></span>&nbsp;Editar</button>
        
        <button type="button" id="boton_correo" name="boton_correo" title="Enviar actividad por correo" class="btn btn-default btn-xs-text"><span class="glyphicon glyphicon-send" aria-hidden="true"></span>&nbsp;E-mail</button>

            </div>
        </div>  
        </form>

<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js"></script>
</body>
</html>