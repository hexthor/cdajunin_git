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

	$('.input_usuario').attr('disabled','disabled');
	
	$('#equipos').hide();
	
	$('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
     });
	
	$('#buscar_usuario').click(function(){
		var cedula=$('#cedula_usuario').val();
		$form = $("#formulario_verificar");
		
		$.ajax({
			type: 'POST',
			url: 'buscar_usuario.php',
			dataType: 'json',
			data: 'cedula=' + cedula,
			success: function(respuesta) {

				if(respuesta.cuenta>0)
				{
					$('#nombre_usuario').val(respuesta.nombre);
					$('#apellido_usuario').val(respuesta.apellido);
					$('#indicador_usuario').val(respuesta.indicador);
					$('#gerencia_usuario').val(respuesta.gerencia);
					$('#ubicacion_usuario').val(respuesta.ubicacion);
					$('.input_usuario').attr('disabled','disabled');
					$('#equipos').removeClass('disabled');
					$('#equipos').show();
					$('#equipos').html('<span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>&nbsp;Equipos');
					
					$form.append(
					'<input type="hidden" class="form-control input_hidden" id="nombre_usuario" name="nombre_usuario" value="'+respuesta.nombre+'">'+
					'<input type="hidden" class="form-control input_hidden" id="apellido_usuario" name="apellido_usuario" value="'+respuesta.apellido+'">'+
					'<input type="hidden" class="form-control input_hidden" id="indicador_usuario" name="indicador_usuario" value="'+respuesta.indicador+'">'+
					'<input type="hidden" class="form-control input_hidden" id="gerencia_usuario" name="gerencia_usuario" value="'+respuesta.gerencia+'">'+
					'<input type="hidden" class="form-control input_hidden" id="ubicacion_usuario" name="ubicacion_usuario" value="'+respuesta.ubicacion+'">'
					);
					
					$('#alerta').append(
					'<div class="alert alert-success alert-dismissible" role="alert">'+
					'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					'<strong>Usuario encontrado!</strong> Pulse Agregar Equipos para continuar...'+
					'</div>'
					);
				}
				else
				{
					//alert("Usuario no encontrado.\n\n Por favor complete los campos.");
					
					$('#alerta').append(
					'<div class="alert alert-danger alert-dismissible" role="alert">'+
					'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+
					'<strong>Usuario no encontrado!</strong> Por favor complete los campos y presione Guardar.'+
					'</div>'
					);
					
					$('.input_usuario').val("");
					$('#ubicacion_usuario').val("SAN DIEGO DE CABRUTICA");
					$('.input_usuario').removeAttr('disabled');
					$('#equipos').addClass('disabled');
					$('#equipos').show();
					$('#equipos').html('<span class="glyphicon glyphicon-save" aria-hidden="true"></span>&nbsp;Guardar');
					$(".input_hidden").remove();
					//alert(respuesta.cuenta);
				}
				
					$('#cuenta').val(respuesta.cuenta);/********CAMPO OCULTO*/
					$('#cedula_respuesta').val(respuesta.cedula);/********CAMPO OCULTO*/
					
					$("#alerta").fadeTo(4500, 500).slideUp(500, function(){
						$(".alert").remove();
					});

		   	}
		});
	});							
});
	  
</script>

</head>
<body>

<div class="container-fluid">

	<div id="alerta"></div>

    <h3>Verificar Usuario:</h3>
    <br>
  
  <form id="formulario_verificar" class="form-horizontal" role="form" method="post" data-toggle="validator" enctype="multipart/form-data" action="asignaciones_agregar.php">
      
      <!--CEDULA USUARIO-->
    <div class="form-group">
        <label for="cedula_usuario" class="col-xs-6 col-sm-2 control-label">*Cedula: </label>
        <div class="col-xs-12 col-sm-4">
            <div class="input-group">
                <input type="text" class="form-control solo-numero" id="cedula_usuario" name="cedula_usuario" pattern="[0-9]{6,8}" placeholder="Campo obligatorio" maxlength="8" onKeyUp="mayusculas(this);" data-error="Campo invalido, verifique." required>
                <span class="input-group-btn">
                <button class="btn btn-secondary" type="button" id="buscar_usuario" name="buscar_usuario"><span class=" glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </span>
            </div>
         <div class="help-block with-errors"></div>
         </div>
    </div> 
    
    <input type="hidden" class="form-control" id="cuenta" name="cuenta"/>
    <input type="hidden" class="form-control" id="cedula_respuesta" name="cedula_respuesta"/> 
      
    <!--NOMBRE Y APELLIDO DEL USUARIO-->
       
     <div class="form-group">
        <label for="nombre_usuario" class="col-xs-6 col-sm-2 control-label">*Nombre: </label>
            <div class="col-xs-12 col-sm-4">
            <input type="text" class="form-control input_usuario" id="nombre_usuario" name="nombre_usuario" pattern="([a-zA-ZÁÉÍÓÚÜÑñáéíóúü]{1,}[\s]*)+" data-error="Verifique. Solo se permiten letras." placeholder="Campo obligatorio" maxlength="20" onKeyUp="mayusculas(this);" required>
        <div class="help-block with-errors"></div>
        </div>
    </div> 
    
    <div class="form-group">
        <label for="apellido_usuario" class="col-xs-6 col-sm-2 control-label">*Apellido: </label>
            <div class="col-xs-12 col-sm-4">
            <input type="text" class="form-control input_usuario" id="apellido_usuario" name="apellido_usuario" pattern="([a-zA-ZÁÉÍÓÚÜÑñáéíóúü]{1,}[\s]*)+" data-error="Verifique. Solo se permiten letras." placeholder="Campo obligatorio" maxlength="20" onKeyUp="mayusculas(this);" required>
        <div class="help-block with-errors"></div>
        </div>
    </div> 
    
     <!--INDICADOR-->
     <div class="form-group">
        <label for="indicador_usuario" class="col-xs-6 col-sm-2 control-label">*Indicador: </label>
            <div class="col-xs-12 col-sm-4">
            <input type="text" class="form-control input_usuario" id="indicador_usuario" name="indicador_usuario" pattern="[A-Z]{3,20}" data-error="Verifique. Solo se permiten letras sin espacios." placeholder="Campo obligatorio" maxlength="20" onKeyUp="mayusculas(this);" required>
        <div class="help-block with-errors"></div>
        </div>
    </div> 
    
    <!--GERENCIA-->
    <div class="form-group">
        <label for="gerencia_usuario" class="col-xs-6 col-sm-2 control-label">*Gerencia: </label>
            <div class="col-xs-12 col-sm-5">
            <input type="text" class="form-control input_usuario" id="gerencia_usuario" name="gerencia_usuario" pattern="([a-zA-ZÁÉÍÓÚÜñáéíóúü]{1,}[\s]*)+" data-error="Verifique. Solo se permiten letras." placeholder="Campo obligatorio" maxlength="50" onKeyUp="mayusculas(this);" required>
        <div class="help-block with-errors"></div>
        </div>
    </div> 
    
    <!--UBICACION-->
    <div class="form-group">
        <label for="ubicacion_usuario" class="col-xs-6 col-sm-2 control-label ">*Ubicaci&oacute;n: </label>
            <div class="col-xs-12 col-sm-5">
            
            <select class="form-control input_usuario" id="ubicacion_usuario" name="ubicacion_usuario" required>
              <option value="EL TIGRE">EL TIGRE</option>
              <option value="PARIAGUAN">PARIAGUAN</option>
              <option value="PUERTO LA CRUZ">PUERTO LA CRUZ</option>
              <option selected value="SAN DIEGO DE CABRUTICA">SAN DIEGO DE CABRUTICA</option>
              <option value="SAN TOME">SAN TOME</option>
              <option value="ZUATA">ZUATA</option>
            </select>
        <div class="help-block with-errors"></div>
        </div>
    </div>
  	</form>
    
        
        <!--AGREGAR EQUIPOS-->
        <div class="form-group">
            <div class="col-xs-12 text-right">
            <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='asignaciones.php';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
            <button type="submit" id="equipos" name="equipos" class="btn btn-default btn-xs-text" form="formulario_verificar"></button>
            </div>
        </div> 
    
</div>
<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js"></script>

</body>
</html>