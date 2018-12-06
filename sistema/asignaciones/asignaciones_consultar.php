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

</head>
<body>

<?php

session_start();
$conexion=conexion();
$responsable=$_SESSION['usuario'];

	$equipo=$_GET['id_equipo'];
	$consultar="SELECT * FROM asignaciones_equipos WHERE id='".$equipo."'";
	$query_consultar=query($consultar,$conexion);
	$result=fetch_array($query_consultar);
	
	$cedula=$result['cedula'];
	$consultar_usu="SELECT * FROM asignaciones_usuarios WHERE cedula='".$cedula."'";
	$query_usu=query($consultar_usu,$conexion);
	$result_usu=fetch_array($query_usu);

?>

<div class="container-fluid">

    <h3>Consultar Asignaci&oacute;n:</h3>
      <br>
  
   <form id="formulario_asignacion" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" action="<?php echo $_SERVER['PHP_SELF']; ?>" novalidate>
    
    <fieldset class="asignaciones" id="fieldset_0">
        <legend class="asignaciones">Equipo:</legend>
        
    <div class="row">
    
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label class="col-md-4 control-label">Categoria:</label>
          <div class="col-md-8" style="padding-top:8px;">
            <?php echo $result['categoria'];?>
          </div>
        </div>
      </div>
      
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputPassword" class="col-md-4 control-label">Marca:</label>
          <div class="col-md-8" style="padding-top:8px;">
            <?php echo $result['marca'];?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputLabel3" class="col-md-4 control-label">Modelo:</label>
          <div class="col-md-8" style="padding-top:8px;">
            <?php echo $result['modelo'];?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputLabel4" class="col-md-4 control-label">Serial:</label>
          <div class="col-md-8" style="padding-top:8px;">
           <?php if($result['serial']=="" || $result['serial']==NULL){echo "---";}else{echo $result['serial'];}?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input5" class="col-md-4 control-label">Etiqueta:</label>
          <div class="col-md-8" style="padding-top:8px;">
           <?php if($result['etiqueta']=="" || $result['etiqueta']==NULL){echo "---";}else{echo $result['etiqueta'];}?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input6" class="col-md-4 control-label">Caso SIGA:</label>
          <div class="col-md-8" style="padding-top:8px;">
            <?php if($result['casosiga']=="" || $result['casosiga']==NULL){echo "---";}else{echo $result['casosiga'];}?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input7" class="col-md-4 control-label">Estado SIGA:</label>
          <div class="col-md-8" style="padding-top:8px;">
            <?php if($result['estadosiga']=="" || $result['estadosiga']==NULL){echo "---";}else{echo $result['estadosiga'];}?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input8" class="col-md-4 control-label">Fecha:</label>
          <div class="col-md-8" style="padding-top:8px;">
            <?php if($result['fecha']=="" || $result['fecha']==NULL){echo "---";}else{echo $result['fecha'];}?>
          </div>
        </div>
      </div>
      <div class="col-sm-12">
        <div class="form-group">
          <label for="input9" class="col-md-2 control-label">Observaciones:</label>
          <div class="col-md-10" style="padding-top:8px;">
            <p class="text-justify"><?php if($result['observacion']=="" || $result['observacion']==NULL){echo "---";}else{echo $result['observacion'];}?></p>
          </div>
        </div>
      </div>
      </div><!-- /.row  -->
    </fieldset>
    
    <fieldset class="asignaciones" id="fieldset_1">
        <legend class="asignaciones">Usuario:</legend>
        
    <div class="row">
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputPassword" class="col-md-4 control-label">Nombre:</label>
          <div class="col-md-8" style="padding-top:8px;">
            <?php echo $result_usu['nombre'];?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputLabel3" class="col-md-4 control-label">Apellido:</label>
          <div class="col-md-8" style="padding-top:8px;">
            <?php echo $result_usu['apellido'];?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label class="col-md-4 control-label">Cedula:</label>
          <div class="col-md-8" style="padding-top:8px;">
            <?php echo $result_usu['cedula'];?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="inputLabel4" class="col-md-4 control-label">Indicador:</label>
          <div class="col-md-8" style="padding-top:8px;">
           <?php echo $result_usu['indicador'];?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input5" class="col-md-4 control-label">Gerencia:</label>
          <div class="col-md-8" style="padding-top:8px;">
           <?php echo $result_usu['gerencia'];?>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-4">
        <div class="form-group">
          <label for="input6" class="col-md-4 control-label">Ubicacion:</label>
          <div class="col-md-8" style="padding-top:8px;">
            <?php echo $result_usu['ubicacion'];?>
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
    </div>
    </div>  
  
</div>
<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js"></script>

</body>
</html>