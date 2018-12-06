<?php
session_start();

function comprobar($nivel)
{
	if($_SESSION['autenticado']!="SI")
	{
		$_SESSION['regreso']=1;
		switch ($nivel)
		{
   			case 0:
       			redireccionar_parent('index.php');
        		break;
   			case 1:
        		redireccionar_parent('../index.php');
        		break;
    		case 2:
				redireccionar_parent('../../index.php');
				break;
			case 3:
				redireccionar_parent('../../../index.php');
				break;

		}
	}
}

function redireccionar($url)
{	
	$direccion='<script languaje="JavaScript">
	location.href="'.$url.'";
	</script>';
	echo $direccion;
}

function redireccionar_parent($url)
{	
	$direccion='<script languaje="JavaScript">
	parent.location.href="'.$url.'";
	</script>';
	echo $direccion;
}

function modal_alert($titulo,$icono,$mensaje)
{
	$modal='<div class="container">
					<!-- Modal -->
					<div class="modal fade" data-backdrop="static" data-keyboard="false" id="myModal" role="dialog">
					<div class="modal-dialog">
					
					  <!-- Modal content-->
					  <div class="modal-content">
						<div class="modal-header msjerroneo">
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						  <h4 class="modal-title"><strong><span class="'.$icono.'"></span>&nbsp;'.$titulo.'</strong></h4>
						</div>
						<div class="modal-body">
						  <h4>'.$mensaje.'</h4>
						</div>
						<div class="modal-footer">
						  <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;Cerrar</button>
						</div>
					  </div>
					  
					</div>
					</div>
					</div>
					
		<script>
		$(document).ready(function(){
		$("#myModal").modal("show");
		});
		</script>
	 ';
	echo $modal;
}

function alert($mensaje)
{	
	$alert='<script languaje="JavaScript">
	alert("'.$mensaje.'");
	</script>';
	echo $alert;
}

function badge($num_rows_activos)
{	
	$badge='<script type="text/javascript" class="init">
		$(document).ready(function() {
		window.parent.$("#pendiente_badge").text("'.$num_rows_activos.'");
		});
		</script>';
	echo $badge;
}

function confirmar_seguir($mensaje,$cancelar)
{
	$confirmar='
	<script languaje="JavaScript">
	var answer = confirm("'.$mensaje.'");
	if (!answer)
	{
		location.href = "'.$cancelar.'";
	}
	</script>';
	
	echo $confirmar;
}

function confirmar_aceptar($mensaje,$aceptar)
{
	$confirmar='
	<script languaje="JavaScript">
	var answer = confirm("'.$mensaje.'");
	if (answer)
	{
		location.href = "'.$aceptar.'";
	}
	</script>';
	
	echo $confirmar;
}

function deleteDirectory($dir) {
    if(!$dh = @opendir($dir)) return;
    while (false !== ($current = readdir($dh))) {
        if($current != '.' && $current != '..') {
            //echo 'Se ha borrado el archivo '.$dir.'/'.$current.'<br/>';
            if (!@unlink($dir.'/'.$current)) 
                deleteDirectory($dir.'/'.$current);
        }       
    }
    closedir($dh);
    //echo 'Se ha borrado el directorio '.$dir.'<br/>';
    @rmdir($dir);
}

function saber_dia($nombredia)
{
	$dias = array('', 'Lunes','Martes','Miercoles','Jueves','Viernes','Sabado', 'Domingo');
	$fecha = $dias[date('N', strtotime($nombredia))];
	return $fecha;
}

function formatear_fecha($fecha)
{
	$explode=explode('-',$fecha);
	$explode=$explode[2].'/'.$explode[1].'/'.$explode[0];
	return $explode;
}

function fecha_hoy_php()
{
	$hoy = getdate();
	if(strlen($hoy['mon'])==1){$hoy['mon']='0'.$hoy['mon'];}
	echo $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];
}

function fecha_hoy_php_return()
{
	$hoy = getdate();
	if(strlen($hoy['mon'])==1){$hoy['mon']='0'.$hoy['mon'];}
	return $hoy['year'].'-'.$hoy['mon'].'-'.$hoy['mday'];
}

?>