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

	$(".alert").fadeTo(4500, 500).slideUp(500, function(){
		$(".alert").remove();
	});
	
	/*$('.solo-numero').keyup(function (){
            this.value = (this.value + '').replace(/[^0-9]/g, '');
     });*/
	 
	 /*$('.input-datepicker').datepicker({
		language: "es",
		todayHighlight: true,
		format: 'yyyy-mm-dd',
		startDate: "-7d",
		endDate: "+d",
		autoclose: true,
		orientation: "right",
	 });*/
	 
	 $('body').on('focus',".input-datepicker", function(){
		$(this).datepicker({
		language: "es",
		todayHighlight: true,
		format: 'yyyy-mm-dd',
		startDate: "-7d",
		endDate: "+d",
		autoclose: true,
		orientation: "right",
	 });
	});
	
	$('body').on('keyup',".solo-numero", function(){
		this.value = (this.value + '').replace(/[^0-9]/g, '');
	});
	
	var MaxInputs=9; //Número Maximo de Campos
	var contenedor=$("#formulario_asignacion"); //ID del contenedor
	var AddButton=$("#agregar_fieldset"); //ID del Botón Agregar
	
	//var x = número de campos existentes en el contenedor
	 var x = $("#formulario_asignacion fieldset").length;
	 var FieldCount = x-1; //para el seguimiento de los campos
	
	$(AddButton).click(function (e) {
		if(x <= MaxInputs) //max input box allowed
		{
			FieldCount++;
			$(contenedor).append(
			
			'<fieldset class="asignaciones" id="fieldset_'+FieldCount+'">'+
			'<legend class="asignaciones">Equipo #'+(FieldCount+1)+'&nbsp;'+
			'<button type="button" class="btn btn-default btn-sm eliminar_fieldset" id="borrar_'+FieldCount+'"><span class="glyphicon glyphicon-minus-sign" aria-hidden="true"></span></button>'+
			'</legend>'+
			
			'<div class="row">'+
			
			'<div class="col-sm-6 col-lg-4">'+
        '<div class="form-group">'+
          '<label for="inputEmail" class="col-md-4 control-label">*Categoria:</label>'+
          '<div class="col-md-8">'+
            '<input class="form-control requeridos" id="categoria_'+FieldCount+'" name="categoria[]" placeholder="Categoria" type="text" onKeyUp="mayusculas(this);">'+
          '</div>'+
        '</div>'+
      '</div>'+
      '<div class="col-sm-6 col-lg-4">'+
        '<div class="form-group">'+
         ' <label for="inputPassword" class="col-md-4 control-label">*Marca:</label>'+
          '<div class="col-md-8">'+
           ' <input class="form-control requeridos" id="marca_'+FieldCount+'" name="marca[]" placeholder="Marca" type="text" onKeyUp="mayusculas(this);">'+
          '</div>'+
        '</div>'+
     ' </div>'+
      '<div class="col-sm-6 col-lg-4">'+
        '<div class="form-group">'+
          '<label for="inputLabel3" class="col-md-4 control-label">*Modelo:</label>'+
         ' <div class="col-md-8">'+
           ' <input class="form-control requeridos" id="modelo_'+FieldCount+'" name="modelo[]" placeholder="Modelo" type="text" onKeyUp="mayusculas(this);">'+
         ' </div>'+
       ' </div>'+
     ' </div>'+
     ' <div class="col-sm-6 col-lg-4">'+
        '<div class="form-group">'+
          '<label for="inputLabel4" class="col-md-4 control-label">Serial:</label>'+
         ' <div class="col-md-8">'+
            '<input class="form-control" id="serial_'+FieldCount+'" name="serial[]" placeholder="Serial" type="text" onKeyUp="mayusculas(this);">'+
         ' </div>'+
       ' </div>'+
      '</div>'+
      '<div class="col-sm-6 col-lg-4">'+
        '<div class="form-group">'+
          '<label for="input5" class="col-md-4 control-label">Etiqueta:</label>'+
          '<div class="col-md-8">'+
            '<input class="form-control solo-numero" id="etiqueta_'+FieldCount+'" name="etiqueta[]" placeholder="Etiqueta" type="text" onKeyUp="mayusculas(this);">'+
          '</div>'+
        '</div>'+
     ' </div>'+
     ' <div class="col-sm-6 col-lg-4">'+
       ' <div class="form-group">'+
         ' <label for="input6" class="col-md-4 control-label">Caso SIGA:</label>'+
         ' <div class="col-md-8">'+
          '  <input class="form-control solo-numero" id="casosiga_'+FieldCount+'" name="casosiga[]" placeholder="Caso SIGA" type="text" onKeyUp="mayusculas(this);">'+
         ' </div>'+
        '</div>'+
     ' </div>'+
     ' <div class="col-sm-6 col-lg-4">'+
        '<div class="form-group">'+
         ' <label for="input7" class="col-md-4 control-label">Estado SIGA:</label>'+
         ' <div class="col-md-8">'+
            '<input class="form-control" id="estadosiga_'+FieldCount+'" name="estadosiga[]" placeholder="Estado SIGA" type="text" onKeyUp="mayusculas(this);">'+
         ' </div>'+
        '</div>'+
     ' </div>'+
      '<div class="col-sm-6 col-lg-4">'+
       ' <div class="form-group">'+
         ' <label for="input8" class="col-md-4 control-label">Fecha:</label>'+
          '<div class="col-md-8">'+
            '<input class="form-control input-datepicker" id="fecha_'+FieldCount+'" name="fecha[]" value="<?php $hoy = getdate();  echo $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];?>" type="text" readonly onKeyUp="mayusculas(this);">'+
          '</div>'+
       ' </div>'+
      '</div>'+
      '<div class="col-sm-12">'+
        '<div class="form-group">'+
          '<label for="input9" class="col-md-2 control-label">Observaciones:</label>'+
          '<div class="col-md-10">'+
            '<textarea class="form-control redimensionartextarea_asig" id="observaciones_'+FieldCount+'" name="observaciones[]" placeholder="Observaciones" maxlength="150" onKeyUp="mayusculas(this);"></textarea>'+
          '</div>'+
        '</div>'+
      '</div>'+
						
			'</div><!-- /.row  -->'+
			'</fieldset>'
			
			);
			x++; //text box increment
		}
		return false;
	});
	
	$("body").on("click",".eliminar_fieldset", function(){ //click en eliminar campo
		if( x > 1 )
		{
			var variable = $(this).attr("id").split('_');
			$('[id=fieldset_'+variable[1]+']').remove();
			x--;
			//FieldCount--;
		}
		return false;
	 });
	 
	 $(document).on('submit', 'form', function(e) {
		//alert($("fieldset").length);
		//alert($(".requeridos").length);
		
		var cont=0;
		
		$('.requeridos').each(function(){
			if($(this).val() == ''){
				$(this).css({"background-color": "#FFA1A3","font-weight": "bolder"});
				cont++;
				e.preventDefault();
			}
			else
			{
				$(this).css({"background-color":"#FFF", "font-weight": "normal"});
			}
		});
		
		if(cont>0)
		{
			alert("Los campos CATEGORIA, MARCA y MODELO son obligatorios.");
		}
		else
		{
			var n = $("fieldset").length;
			$(contenedor).append('<input type="hidden" class="form-control" id="cuenta" name="cuenta" value="'+n+'"/>');
		}
		
	});
	 
});
	  
</script>

</head>
<body>

<?php

/*echo "<pre>";
print_r($_POST);
echo "</pre>";*/

session_start();
$conexion=conexion();
$responsable=$_SESSION['usuario'];
$cedula=$_POST['cedula_respuesta'];
$nombre=$_POST['nombre_usuario'];
$apellido=$_POST['apellido_usuario'];
$indicador=$_POST['indicador_usuario'];
$gerencia=$_POST['gerencia_usuario'];
$ubicacion=$_POST['ubicacion_usuario'];

/**SI EL USUARIO INGRESADO NO ESTA EN LA BASE DE DATOS SE PROCEDE A REGISTRAR*/
if($_POST['cuenta']==0 && !isset($_POST['guardar'])){
	$ingresar="INSERT INTO asignaciones_usuarios (cedula,nombre,apellido,indicador,gerencia,ubicacion) VALUES ('".$cedula."','".$nombre."','".$apellido."','".$indicador."','".$gerencia."','".$ubicacion."')";
	if(query($ingresar,$conexion))
	{
		echo '
		
		<div class="alert alert-success alert-dismissible" role="alert">
		  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		  <strong>Usuario Guardado!</strong> Por favor agregue los equipos para la nueva asignaci&oacute;n.
		</div>
		
		';
	}	
}

if (isset($_POST['guardar']))
{
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	$conexion=conexion();
	
	$cedula=$_POST['cedula'];
	$indicador=$_POST['indicador'];
	$categoria=$_POST['categoria'];
	$marca=$_POST['marca'];
	$modelo=$_POST['modelo'];
	$serial=$_POST['serial'];
	$etiqueta=$_POST['etiqueta'];
	$casosiga=$_POST['casosiga'];
	$estadosiga=$_POST['estadosiga'];
	$fecha=$_POST['fecha'];
	$observaciones=$_POST['observaciones'];
	
	$cuenta=$_POST['cuenta']; //CUENTA DE LOS FIELDSETS CREADOS EN EL BODY.
	
	$i=0;
	$j=0;
	while($i<$cuenta)
	{
		/*SIGUIENTE CORRELATIVO DE ASIGNACIONES*/
		$select_asig="select MAX(id) from asignaciones_equipos";
		$query_asig=query($select_asig,$conexion);
		$array_asig=fetch_array($query_asig);
		$id_asig=$array_asig[0]+1;
		
		$insert="INSERT INTO asignaciones_equipos VALUES ('".$id_asig."','".$cedula."','".$indicador."','".$categoria[$i]."','".$marca[$i]."','".$modelo[$i]."','".$serial[$i]."','".$etiqueta[$i]."','".$casosiga[$i]."','".$estadosiga[$i]."','".$fecha[$i]."','".$observaciones[$i]."','".$responsable."')";
		
		if(query($insert,$conexion))
		{
			$j+=1;
		}
		
		$i+=1;
	}
	
	if($j>=1)
	{
		alert("Equipos agregados con exito.");
		redireccionar("asignaciones.php");
	}
}

?>

<div class="container-fluid">

    <h3>Asignar Equipos a: <strong><?php echo ucwords(strtolower($nombre." ".$apellido)); echo ", ID:".$indicador;?></strong></h3>
      <br>
  
   <form id="formulario_asignacion" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
   
   <input type="hidden" class="form-control" id="cedula" name="cedula" value="<?php echo $cedula;?>"/> 
   <input type="hidden" class="form-control" id="indicador" name="indicador" value="<?php echo $indicador;?>"/> 
    
    <fieldset class="asignaciones" id="fieldset_0">
        <legend class="asignaciones">Equipo #1 
            <button type="button" class="btn btn-default btn-sm" id="agregar_fieldset" name="agregar_fieldset" title="Agregar Equipo"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
        </legend>
    
    <div class="row">
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">*Categoria:</label>
          <div class="col-md-8">
            <input class="form-control requeridos" id="categoria_0" name="categoria[]" placeholder="Categoria" type="text" onKeyUp="mayusculas(this);">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputPassword" class="col-md-4 control-label">*Marca:</label>
          <div class="col-md-8">
            <input class="form-control requeridos" id="marca_0" name="marca[]" placeholder="Marca" type="text" onKeyUp="mayusculas(this);">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputLabel3" class="col-md-4 control-label">*Modelo:</label>
          <div class="col-md-8">
            <input class="form-control requeridos" id="modelo_0" name="modelo[]" placeholder="Modelo" type="text" onKeyUp="mayusculas(this);">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputLabel4" class="col-md-4 control-label">Serial:</label>
          <div class="col-md-8">
          		<!--<div class="input-group">
                	<span class="input-group-addon">
                    <input type="checkbox" onChange="serial_0.disabled=!this.checked">
                    </span>-->
            		<input class="form-control" id="serial_0" name="serial[]" placeholder="Serial" type="text" onKeyUp="mayusculas(this);" <?php /*?>disabled="disabled"<?php */?>>
                <!--</div>-->
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input5" class="col-md-4 control-label">Etiqueta:</label>
          <div class="col-md-8">
            <input class="form-control solo-numero" id="etiqueta_0" name="etiqueta[]" placeholder="Etiqueta" type="text" onKeyUp="mayusculas(this);">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input6" class="col-md-4 control-label">Caso SIGA:</label>
          <div class="col-md-8">
            <input class="form-control solo-numero" id="casosiga_0" name="casosiga[]" placeholder="Caso SIGA" type="text" onKeyUp="mayusculas(this);">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input7" class="col-md-4 control-label">Estado SIGA:</label>
          <div class="col-md-8">
            <input class="form-control" id="estadosiga_0" name="estadosiga[]" placeholder="Estado SIGA" type="text" onKeyUp="mayusculas(this);">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input8" class="col-md-4 control-label">Fecha:</label>
          <div class="col-md-8">
            <input class="form-control input-datepicker" id="fecha_0" name="fecha[]" value="<?php $hoy = getdate();  echo $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];?>" type="text" readonly onKeyUp="mayusculas(this);">
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label for="input9" class="col-md-2 control-label">Observaciones:</label>
          <div class="col-md-10">
            <textarea class="form-control redimensionartextarea_asig" id="observaciones_0" name="observaciones[]" placeholder="Observaciones" maxlength="150" onKeyUp="mayusculas(this);"></textarea>
          </div>
        </div>
      </div>
      </div><!-- /.row  -->
    </fieldset>

   </form>
   
      
    <!--AGREGAR EQUIPOS-->
    <div class="form-group">
    <div class="col-xs-12 text-right">
    <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='verificar_usuario.php';" form="formulario_asignacion"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
     <button type="submit" id="guardar" name="guardar" title="Guardar" form="formulario_asignacion" class="btn btn-default btn-xs-text"><span class="glyphicon glyphicon-save" aria-hidden="true"></span>&nbsp;Guardar</button>
    </div>
    </div>  
  
</div>
<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js"></script>

</body>
</html>