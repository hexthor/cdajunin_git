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
<link href="../../css/dataTables.bootstrap.min.css" rel="stylesheet"/>

<script type="text/javascript" src="../../js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap.min.js"></script>
<!--<script type="text/javascript" src="../../js/validator.js"></script>-->
<script type="text/javascript" src="../../js/funciones.js"></script>
<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../js/dataTables.bootstrap.min.js"></script>
<!--<script type="text/javascript" src="../../js/bootstrap-hover-dropdown.js"></script>-->
<script type="text/javascript" class="init">
	
$(document).ready(function() {
$('#tablon').DataTable({
		"order": [3, "asc"],
		/*"bPaginate": true,*/
		"columnDefs": [{"orderable": false, targets: [0,4,5,6]}] 
	});
	
	
	
});
</script>
    
<script type="text/javascript">
function eliminar(id,resumen,fecha)
{
	var answer = confirm("¿Desea eliminar el pendiente: "+resumen+" de fecha: "+fecha+"?");
	if (answer){
		location.href = "pendientes_eliminar.php?id_pendiente="+id+"";
	}
}	
</script>
</head>
<body>

<div class="container-fluid">

  <h2>Pendientes <button type="button" class="btn btn-default btn-sm" title="Agregar Actividad" onClick="location.href='pendientes_agregar.php';"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button></h2>
  
  <div class="table-responsive">  
    <table id="tablon" class="table table-bordered table-hover" width="100%" cellspacing="0">
        <thead style="background-color:#EFEFEF;">
            <tr>
                <th>Resumen</th>
                <th>Fecha de Registro <small style="font-weight:lighter; color:#ACACAC;">(aaaa/mm/dd)</small></th>
                <th style="text-align:center;">Usuario</th>
                <th style="text-align:center;">Estado</th>
                <th style="text-align:center;"><span class="glyphicon glyphicon-eye-open"></span></th>
                <th style="text-align:center;"><span class="glyphicon glyphicon-edit"></span></th>
                <th style="text-align:center;"><span class="glyphicon glyphicon-remove-circle"></span></th>
            </tr>
        </thead>
        <tbody>
        <?php
		
		session_start();
		$conexion=conexion();
		$responsable=$_SESSION['usuario'];
		/*$select_act_usu="SELECT a.responsable_correlativo as actividad, a.resumen, a.fecha_actividad,COUNT(s.id_soporte_actividad) AS cuenta FROM actividades a JOIN actividades_soportes s ON a.responsable=s.responsable  AND a.responsable_correlativo=s.id_actividad AND a.responsable='".$responsable."' GROUP BY a.responsable,a.responsable_correlativo, a.resumen, a.fecha_actividad ORDER BY a.fecha_actividad DESC";
		$query_act=query($select_act_usu,$conexion);
		$num_rows=num_rows($query_act);
		//print_r($num_rows);*/
		
		$select_pendiente="SELECT * FROM pendientes ORDER BY fecha_registro DESC";
		$query_pend=query($select_pendiente,$conexion);
		$num_rows=num_rows($query_pend);
		
		/*****MODIFICAR VALOR DEL BADGE PENDIENTES*****/
		$select_pendientes_activos="SELECT * FROM pendientes WHERE estado!='CERRADO'";
		$query_activos=query($select_pendientes_activos,$conexion);
		$num_rows_activos=num_rows($query_activos);
		badge($num_rows_activos);
		/**********************************************/
		
		while($result=fetch_array($query_pend)){
		
		?>
        
        <tr <?php if ($result['estado']=='CERRADO'){echo 'class="success"';}?>>
            <td><?php echo $result['resumen'];?></td>
            <td><?php echo $result['fecha_registro'];?></td>
            <td align="center"><?php echo $result['responsable'];?></td>
            <td align="center"><?php echo $result['estado'];?></td>
            <td style="text-align:center;"><a href="pendientes_consultar.php?id_pendiente=<?php echo $result['id'];?>" title="Consultar" class="linktabla"><span class="glyphicon glyphicon-eye-open"></span></a></td>
            <td style="text-align:center;"><a href="pendientes_editar.php?id_pendiente=<?php echo $result['id'];?>" title="Editar" class="linktabla"><span class=" glyphicon glyphicon-edit"></span></a></td>
            <td style="text-align:center;"><a href="javascript:eliminar(<?php echo "'".$result['id']."'";?>,<?php echo "'".$result['resumen']."'";?>,<?php echo "'".$result['fecha_registro']."'";?>);" title="Eliminar" class="linktabla"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
        </tr>
            
          <?php }?>  
        </tbody>
    </table>  
  </div>
</div>
		<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js"></script>
</body>
</html>