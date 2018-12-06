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
				"order": [5, "desc"],
				/*"bPaginate": true,*/
				"columnDefs": [{"orderable": false, targets: [3,6,7,8]}]  /*Tiene que corresponder al numero exacto de columnas, no se debe colocar colmunas que no existen*/
			});
				
		});
</script>
    
<script type="text/javascript">
function eliminar(id,categoria,marca,modelo,serial,indicador)
{
	if(serial=="---")
	{
		var answer = confirm("¿Desea eliminar "+categoria+" Marca: "+marca+", Modelo: "+modelo+" asignado a "+indicador+"?");
	}
	else
	{
		var answer = confirm("¿Desea eliminar "+categoria+" Marca: "+marca+", Modelo: "+modelo+", Serial: "+serial+" asignado a "+indicador+"?");
	}
	
	if (answer){
		location.href = "asignaciones_eliminar.php?id_equipo="+id+"";
	}
}	
</script>    
    
</head>
<body>
  
<div class="container-fluid">

  <h2>Asignaciones
  <button type="button" class="btn btn-default btn-sm" title="Agregar Asignaci&oacute;n" onClick="location.href='verificar_usuario.php';"><span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span></button>
  <button type="button" class="btn btn-default btn-sm" title="Gestionar Usuarios" onClick="location.href='usuarios.php';"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>
  </h2>
  
  <div class="table-responsive">  
          
  <table id="tablon" class="table table-bordered table-hover" width="100%" cellspacing="0"<?php /*?> style="font-size:13px;"<?php */?>>
        <thead style="background-color:#EFEFEF;">
            <tr>
                <th>Categoria</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serial</th>
                <th>Usuario</th>
                <th>Fecha</th>
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
		
		$select_asig_usu="SELECT * FROM asignaciones_equipos WHERE responsable='".$responsable."' ORDER BY indicador,fecha DESC";
		$query_asig=query($select_asig_usu,$conexion);
		$num_rows=num_rows($query_asig);
		
		while($result=fetch_array($query_asig)){
			
			if($result['serial']=="" || $result['serial']==NULL)
			{
				$result['serial']="---";
			}
		?>
            <tr>
                <td><?php echo $result['categoria'];?></td>
                <td><?php echo $result['marca'];?></td>
                <td><?php echo $result['modelo'];?></td>
                <td><?php echo $result['serial'];?></td>
                <td><?php echo $result['indicador'];?></td>
                <td><?php echo $result['fecha'];?></td>
                <td style="text-align:center;"><a href="asignaciones_consultar.php?id_equipo=<?php echo $result['id'];?>" title="Consultar" class="linktabla"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                <td style="text-align:center;"><a href="asignaciones_editar.php?id_equipo=<?php echo $result['id'];?>" title="Editar" class="linktabla"><span class=" glyphicon glyphicon-edit"></span></a></td>
                <td style="text-align:center;"><a href="javascript:eliminar(<?php echo "'".$result['id']."'";?>,<?php echo "'".$result['categoria']."'";?>,<?php echo "'".$result['marca']."'";?>,<?php echo "'".$result['modelo']."'";?>,<?php echo "'".$result['serial']."'";?>,<?php echo "'".$result['indicador']."'";?>);" title="Eliminar" class="linktabla"><span class="glyphicon glyphicon-remove-circle"></span></a></td>
            </tr>
         <?php } ?>
        </tbody>
    </table>  
  </div>
</div>
		<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js" defer></script>
</body>
</html>