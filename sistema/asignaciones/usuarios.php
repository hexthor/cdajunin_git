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
				"order": [1, "asc"],
				/*"bPaginate": true,*/
				"columnDefs": [{"orderable": false, targets: [6,7]}]  /*Tiene que corresponder al numero exacto de columnas, no se debe colocar colmunas que no existen*/
			});
				
		});
</script>
    
<script type="text/javascript">
function eliminar(cedula,nombre,apellido,indicador)
{
	var answer = confirm("¿Desea eliminar al usuario "+nombre+" "+apellido+", Cedula: "+cedula+", Indicador: "+indicador+"? \n\n Nota: Se eliminaran todos los equipos asignados al usuario tambien.");
	
	if (answer){
		location.href = "usuarios_eliminar.php?cedula="+cedula+"";
	}
}	
</script>    
    
</head>
<body>
  
<div class="container-fluid">

  <h2>Usuarios Registrados</h2>
  
  <div class="table-responsive">  
          
  <table id="tablon" class="table table-bordered table-hover" width="100%" cellspacing="0" style="font-size:13px;">
        <thead style="background-color:#EFEFEF;">
            <tr>
                <th>C&eacute;dula</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Indicador</th>
                <th>Gerencia</th>
                <th>Ubicaci&oacute;n</th>
                <th style="text-align:center;"><span class="glyphicon glyphicon-edit"></span></th>
                <th style="text-align:center;"><span class="glyphicon glyphicon-remove-circle"></span></th>
            </tr>
        </thead>
        <tbody>
        
        <?php
		session_start();
		$conexion=conexion();
		
		$select_usu="SELECT * FROM asignaciones_usuarios ORDER BY nombre DESC";
		$query_usu=query($select_usu,$conexion);
		$num_rows=num_rows($query_usu);
		
		while($result=fetch_array($query_usu)){
		?>
            <tr>
                <td><?php echo $result['cedula'];?></td>
                <td><?php echo $result['nombre'];?></td>
                <td><?php echo $result['apellido'];?></td>
                <td><?php echo $result['indicador'];?></td>
                <td><?php echo $result['gerencia'];?></td>
                <td><?php echo $result['ubicacion'];?></td>
                <td style="text-align:center;"><a href="usuarios_editar.php?cedula=<?php echo $result['cedula'];?>" title="Editar" class="linktabla"><span class=" glyphicon glyphicon-edit"></span></a></td>
                <td style="text-align:center;"><a href="javascript:eliminar(<?php echo "'".$result['cedula']."'";?>,<?php echo "'".$result['nombre']."'";?>,<?php echo "'".$result['apellido']."'";?>,<?php echo "'".$result['indicador']."'";?>);" title="Eliminar" class="linktabla"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
            </tr>
         <?php } ?>
        </tbody>
    </table>  
  </div>
  <br>
  <div class="row">
  	<div class="col-xs-12 text-right">
    	<button type="button" class="btn btn-default btn-xs-text" title="Regresar" onClick="location.href='asignaciones.php';"><span class=" glyphicon glyphicon-arrow-left" aria-hidden="true"></span>&nbsp;Regresar</button>
  	</div>
  </div>
  
</div>
		<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js" defer></script>
</body>
</html>