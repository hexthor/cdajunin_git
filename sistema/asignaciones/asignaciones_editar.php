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

	 $(document).on('submit', 'form', function(e) {
		
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

if (!isset($_POST['guardar']))
{
	$equipo=$_GET['id_equipo'];
	$consultar="SELECT * FROM asignaciones_equipos WHERE id='".$equipo."'";
	$query_consultar=query($consultar,$conexion);
	$result=fetch_array($query_consultar);
	
	$cedula=$result['cedula'];
	$indicador=$result['indicador'];
}

if (isset($_POST['guardar']))
{
/*	echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/
	
	$id_equipo=$_POST['id'];
	$categoria=$_POST['categoria'];
	$marca=$_POST['marca'];
	$modelo=$_POST['modelo'];
	$serial=$_POST['serial'];
	$etiqueta=$_POST['etiqueta'];
	$casosiga=$_POST['casosiga'];
	$estadosiga=$_POST['estadosiga'];
	$fecha=$_POST['fecha'];
	$observacion=$_POST['observacion'];
	
	$usuario=explode(",",$_POST['usuario']);
	$cedula_new=$usuario[0];
	$indicador_new=$usuario[1];
	
	$actualizar="UPDATE asignaciones_equipos SET cedula='".$cedula_new."',indicador='".$indicador_new."',categoria='".$categoria."', marca='".$marca."', modelo='".$modelo."', serial='".$serial."', etiqueta='".$etiqueta."', casosiga='".$casosiga."', estadosiga='".$estadosiga."', fecha='".$fecha."', observacion='".$observacion."' WHERE id='$id_equipo'";
	
	if (query($actualizar,$conexion))
	{
		alert("Registro Actualizado.");
		redireccionar("asignaciones_editar.php?id_equipo=".$id_equipo);
	}
}

?>

<div class="container-fluid">

    <h3>Modificar equipo:</h3>
      <br>
  
   <form id="formulario_asignacion" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
    
    <fieldset class="asignaciones" id="fieldset_0">
        <legend class="asignaciones">Asignado a: &nbsp;
        
        <select style="height:34px;padding:6px 12px;font-size:14px;color:#555;border:1px solid #ccc;border-radius:4px;" id="usuario" name="usuario">
        <?php
		$usuarios="SELECT * FROM asignaciones_usuarios ORDER BY nombre";
		$query_usuarios=query($usuarios,$conexion);
		
		while($usuariosss=fetch_array($query_usuarios))
		{
			if($cedula==$usuariosss['cedula']){$selected="selected";}else{$selected="";}
			echo '<option value="'.$usuariosss['cedula'].','.$usuariosss['indicador'].'" '.$selected.'>'.$usuariosss['nombre'].' '.$usuariosss['apellido'].', C.I: '.$usuariosss['cedula'].', ID: '.$usuariosss['indicador'].'</option>';
		}
		
		?>  
        </select>
        
        </legend>
        
         <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $equipo;?>"/>
    
    <div class="row">
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">*Categoria:</label>
          <div class="col-md-8">
            <input class="form-control requeridos" id="categoria" name="categoria" placeholder="Categoria" type="text" onKeyUp="mayusculas(this);" value="<?php echo $result['categoria'];?>">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputPassword" class="col-md-4 control-label">*Marca:</label>
          <div class="col-md-8">
            <input class="form-control requeridos" id="marca" name="marca" placeholder="Marca" type="text" onKeyUp="mayusculas(this);" value="<?php echo $result['marca'];?>">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputLabel3" class="col-md-4 control-label">*Modelo:</label>
          <div class="col-md-8">
            <input class="form-control requeridos" id="modelo" name="modelo" placeholder="Modelo" type="text" onKeyUp="mayusculas(this);" value="<?php echo $result['modelo'];?>">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputLabel4" class="col-md-4 control-label">Serial:</label>
          <div class="col-md-8">
           <input class="form-control" id="serial" name="serial" placeholder="Serial" type="text" onKeyUp="mayusculas(this);" <?php /*?>disabled="disabled"<?php */?> value="<?php echo $result['serial'];?>">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input5" class="col-md-4 control-label">Etiqueta:</label>
          <div class="col-md-8">
            <input class="form-control solo-numero" id="etiqueta" name="etiqueta" placeholder="Etiqueta" type="text" onKeyUp="mayusculas(this);" value="<?php echo $result['etiqueta'];?>">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input6" class="col-md-4 control-label">Caso SIGA:</label>
          <div class="col-md-8">
            <input class="form-control solo-numero" id="casosiga" name="casosiga" placeholder="Caso SIGA" type="text" onKeyUp="mayusculas(this);" value="<?php echo $result['casosiga'];?>">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input7" class="col-md-4 control-label">Estado SIGA:</label>
          <div class="col-md-8">
            <input class="form-control" id="estadosiga" name="estadosiga" placeholder="Estado SIGA" type="text" onKeyUp="mayusculas(this);" value="<?php echo $result['estadosiga'];?>">
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input8" class="col-md-4 control-label">Fecha:</label>
          <div class="col-md-8">
            <input class="form-control input-datepicker" id="fecha" name="fecha" value="<?php echo $result['fecha'];?>" type="text" readonly onKeyUp="mayusculas(this);">
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label for="input9" class="col-md-2 control-label">Observaciones:</label>
          <div class="col-md-10">
            <textarea class="form-control redimensionartextarea_asig" id="observacion" name="observacion" placeholder="Observaciones" maxlength="150" onKeyUp="mayusculas(this);"><?php echo $result['observacion']; ?></textarea>
          </div>
        </div>
      </div>
      </div><!-- /.row  -->
    </fieldset>

   </form>
   
      
    <!--AGREGAR EQUIPOS-->
    <div class="form-group">
    <div class="col-xs-12 text-right">
    <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='asignaciones.php';" form="formulario_asignacion"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
     <button type="submit" id="guardar" name="guardar" title="Guardar" form="formulario_asignacion" class="btn btn-default btn-xs-text"><span class="glyphicon glyphicon-save" aria-hidden="true"></span>&nbsp;Guardar</button>
    </div>
    </div>  
  
</div>
<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js"></script>

</body>
</html>