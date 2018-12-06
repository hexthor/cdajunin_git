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

<!--<link href="../../css/bootstrap-datepicker3.css" rel="stylesheet"/>
<script type="text/javascript" src="../../js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.es.min.js"></script>-->

<script type="text/javascript" class="init">
	
$(document).ready(function() {
	
	$('#boton_nota').click(function() {
		$('#div_nota').toggleClass("div_notus");
	});
	
	$('#cerrar_nota').click(function() {
		$('#div_nota').toggleClass("div_notus");
	});
							
});
	  
</script>



<script type="text/javascript">
function eliminar(id,id_pendiente,resumen,fecha)
{
	var answer = confirm("¿Desea eliminar la nota: "+resumen+" de fecha: "+fecha+"?");
	if (answer){
		location.href = "pendientes_consultar.php?id_pendiente="+id_pendiente+"&opcion=eliminar&id_nota="+id+"";
	}
}
</script>

</head>
<body>

<?php
session_start();
$conexion=conexion();
$responsable=$_SESSION['usuario'];
$pendiente=$_GET['id_pendiente'];

if($_GET['cerrar']==1)
{
	$actualizar="UPDATE pendientes SET estado='CERRADO' WHERE id='$pendiente'";
	if(query($actualizar,$conexion))
	{
		/*****MODIFICAR VALOR DEL BADGE PENDIENTES*****/
		$select_pendiente="SELECT * FROM pendientes WHERE estado!='CERRADO'";
		$query_pend=query($select_pendiente,$conexion);
		$num_rows=num_rows($query_pend);
		badge($num_rows);
		/**********************************************/
		
		alert("Pendiente cerrado.");
	}
}

if($_GET['id_nota']!='' && $_GET['opcion']=="eliminar")
{
	$id_nota=$_GET['id_nota'];
	$eliminar_notas="DELETE FROM pendientes_notas WHERE id_pendiente=$pendiente AND id=$id_nota";
	if(query($eliminar_notas,$conexion))
	{
		alert("Nota eliminada.");	
	}
}

$consultar="SELECT * FROM pendientes WHERE id='".$pendiente."'";
$query_consultar=query($consultar,$conexion);
$result=fetch_array($query_consultar);

if (isset($_POST['guardar']))
{
	$nota=$_POST['resumen_nota'];
	$fecha=fecha_hoy_php_return();
	
	$select_max_id="select MAX(id) from pendientes_notas";
	$query_max_id=query($select_max_id,$conexion);
	$array_max_id=fetch_array($query_max_id);
	$id_max=$array_max_id[0]+1;
	
	$consulta="INSERT INTO pendientes_notas (id, id_pendiente, detalle, usuario, fecha) VALUES ('".$id_max."','".$pendiente."','".$nota."','".$responsable."','".$fecha."')";
	if (query($consulta,$conexion))
	{
		confirmar_aceptar("Informacion guardada con exito.¿Desea cerrar el pendiente?","pendientes_consultar.php?cerrar=1&id_pendiente=$pendiente");
	}
}

?>

<div class="container-fluid">

  <h3 class="text-center">Pendiente: <strong><?php echo $result['resumen']; ?></strong></h3>
  <br>
        
      <!--RESUMEN DEL PENDIENTE-->
<!--      <div class="row">
        <label for="resumen_pendiente" class="col-xs-6 col-sm-1 control-label">Resumen: </label>
        <div class="col-xs-12 col-sm-6">
        <p><u><?php echo $result['resumen']; ?></u></p>
        <div class="help-block with-errors"></div>
        </div>
      </div>-->  
      
      <!--DETALLE DEL PENDIENTE-->
       <div class="row">
        <label for="detalle_pendiente" class="col-xs-12 col-sm-1 control-label">Detalle: </label>
        <div class="col-xs-12 col-sm-10">
        <p class="text-justify"><?php echo nl2br(htmlentities($result['detalle'])); ?></p>
        <div class="help-block with-errors"></div>
        </div>
      </div>
      <br>
          	
    <!--FECHA DEL PENDIENTE-->
     <div class="row">
      <label class="col-xs-12 col-sm-1 control-label requiredField" for="fecha_registro">Fecha:</label>
      <div class="col-xs-12 col-sm-4">
        <p><?php echo $result['fecha_registro']; ?></p>
        <div class="help-block with-errors"></div>
       </div>
      </div>
      <br>
      
    <!--ESTADO DEL PENDIENTE-->
     <div class="row">
      <label class="col-xs-12 col-sm-1 control-label requiredField" for="fecha_registro">Estado:</label>
      <div class="col-xs-12 col-sm-4">
      <?php if($result['estado']!='CERRADO'){?>
        <p><span class="label label-danger"><?php echo $result['estado']; ?></span></p>
        <?php } else { ?>
        <p><span class="label label-success"><?php echo $result['estado']; ?></span></p>
        <?php }?>
        <div class="help-block with-errors"></div>
       </div>
      </div>
      
      <!--AGREGAR NOTAS AL PENDIENTE-->
      <div id="div_nota" class="div_notus"> 
          <br>
          <form id="formulario_actividad" class="form-horizontal" role="form" method="post" target="_self" data-toggle="validator" action="pendientes_consultar.php?id_pendiente=<?php echo $pendiente; ?>">
              <div class="form-group">
                  <label for="resumen_nota" class="col-xs-6 col-sm-1 control-label">*Nota: </label>
                  <div class="col-xs-12 col-sm-11">
                      <div class="input-group">
                          <input type="text" class="form-control" id="resumen_nota" name="resumen_nota" placeholder="Agregar nota al pendiente" maxlength="300" onKeyUp="mayusculas(this);" required>
                          <span class="input-group-btn">
                          	<button class="btn btn-default" type="submit" id="guardar" name="guardar" title="Guardar Nota"><span class="glyphicon glyphicon-save"></button>
                            <button class="btn btn-default" type="button" id="cerrar_nota" name="cerrar_nota" title="Eliminar Campo"><span class="glyphicon glyphicon-remove"></button>
                          </span>
                      </div>
                      <div class="help-block with-errors"></div>
                  </div> 
              </div>
          </form>
      </div>
      
      <?php
	  $select_notas="SELECT * FROM pendientes_notas WHERE id_pendiente='".$pendiente."' ORDER BY id DESC";
	  $query_notas=query($select_notas,$conexion);
	  $num_notas=num_rows($query_notas);
	  // while($result_notas=fetch_array($query_notas))
	  
	  if($num_notas>=1)
	  {
	  ?>
      <!--TABLA DE NOTAS-->
      <div class="row">
        <div class="col-xs-12 text-center">
            <h5><strong>Notas:</strong></h5>
        </div>
       </div>
     
      <div class="row">
      <div class="table-responsive">  
      <table id="tablita" class="table table-bordered table-hover table-condensed" width="100%" cellspacing="0">
            <thead style="background-color:#EFEFEF;">
                <tr>
               		<th>#</th>
                    <th>Detalle</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <?php if($result['estado']!="CERRADO") { ?><th style="text-align:center;"><span class="glyphicon glyphicon-remove-circle"></span></th><?php } ?>
                </tr>
            </thead>
            <tbody>
            <?php
            $i=$num_notas;
			while($result_notas=fetch_array($query_notas)) {?>
                <tr>
               		<td><?php echo $i;?></td>
                    <td><?php echo $result_notas['detalle']; ?></td>
                    <td><?php echo $result_notas['usuario']; ?></td>
                    <td><?php echo $result_notas['fecha']; ?></td>
                    <?php if($result['estado']!="CERRADO") { ?><td style="text-align:center;"><a href="javascript:eliminar(<?php echo "'".$result_notas['id']."'";?>,<?php echo "'".$result_notas['id_pendiente']."'";?>,<?php echo "'".$result_notas['detalle']."'";?>,<?php echo "'".$result_notas['fecha']."'";?>);" title="Eliminar" class="linktabla"><span class="glyphicon glyphicon-remove-circle"></span></a></td><?php } ?>
                </tr>
            <?php $i-=1; }?>
            </tbody>
        </table>  
      </div>
      </div>
      
      <?php }?>
      

                             
        <!--BOTON DE GUARDADO-->
        <div class="row">
            <div class="col-xs-12 text-right">
            <button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='pendientes.php';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
            <button type="button" class="btn btn-default btn-xs-text" title="Editar" onClick="location.href='pendientes_editar.php?from=1&id_pendiente=<?php echo $pendiente;?>';"><span class=" glyphicon glyphicon-edit"></span>&nbsp;Editar</button>
            <?php if($result['estado']!='CERRADO'){?>
            <button type="button" class="btn btn-default btn-xs-text" title="Agregar Nota" id="boton_nota" name="boton_nota"><span class=" glyphicon glyphicon-plus-sign"></span>&nbsp;Nota</button>
            <?php }?>
            </div>
        </div>  
</div>
<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js"></script>
</body>
</html>