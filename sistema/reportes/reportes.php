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
<script type="text/javascript" src="../../js/validator.js"></script>
<script type="text/javascript" src="../../js/funciones.js"></script>

<link href="../../css/bootstrap-datepicker3.css" rel="stylesheet"/>
<script type="text/javascript" src="../../js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap-datepicker.es.min.js"></script>

<!--<script type="text/javascript" src="../../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../../js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="../../js/bootstrap-hover-dropdown.js"></script>-->


<script type="text/javascript" class="init">
	
$(document).ready(function() {
	
	/*$('#one').css({
    'background-image': 'none',
    'background-color': 'black'
    });
	
	$('#dos').css({
    'background-image': 'none',
    'background-color': 'cyan'
    });
	
	$('#tres').css({
    'background-image': 'none',
    'background-color': 'magenta'
    });
	
	$('#four').css({
    'background-image': 'none',
    'background-color': 'yellow'
    });*/
	
	//$('#generar').attr('disabled','disabled');
	$('#generar').addClass('disabled');
	
	$('body').on('change',".input_reporte", function(e) {
		
		var campus= $('#fecha_desde').val();
		var campus1= $('#fecha_hasta').val();
		
		if (campus!="" && campus1!="" && ($('#check_actividades').is(':checked') || $('#check_pendientes').is(':checked') || $('#check_asignaciones').is(':checked')))
		{
			//$('button[type="button"]').removeAttr('disabled');
			$('#generar').removeClass('disabled');
		}
		else
		{
			//$('button[type="button"]').attr('disabled','disabled');
			$('#generar').addClass('disabled');
		}
		
	});
	
	$('.input-daterange').datepicker({
		language: "es",
		//autoclose: true,
		todayHighlight: true,
		format: 'yyyy-mm-dd',
		endDate: "+d",
	 });
		 
		 
	/*$('#generar').click(function() {
		
		//data: frm.serialize(),
		
		var valores = $('form').serialize();
 		var url = "reporte_pdf.php";
		window.open(url+"?"+valores, '_blank');
		//alert(valores);

	});	*/ 
		 
	  				
		});
	</script>

</head>
<body>
  
<div class="container-fluid">

  <h2>Reportes:</h2>
  
  <br>
  
    <form id="formulario_reporte" name="formulario_reporte" class="form-horizontal" role="form" method="post" novalidate <?php /*?>target="_blank" action="reporte_pdf.php"<?php */?>>

		<div class="form-group">
        <label for="resumen_actividad" class="col-xs-6 col-sm-1 control-label">*Incluir: </label>
        <div class="col-xs-12 col-sm-6">
				<div class="checkbox">
                <label>
                  <input class="input_reporte" type="checkbox" id="check_actividades" name="check_actividades" value="1" checked> <strong>Actividades.</strong>
                </label>
              	</div>
                <br>
                <div class="checkbox">
                <label>
                  <input class="input_reporte" type="checkbox" id="check_pendientes" name="check_pendientes" value="1" checked> <strong>Pendientes.</strong>
                </label>
              	</div>
                <br>
                <div class="checkbox">
                <label>
                  <input class="input_reporte" type="checkbox" id="check_asignaciones" name="check_asignaciones" value="1" checked> <strong>Asignaciones.</strong>
                </label>
              	</div>
                <br>
              <div class="help-block with-errors"></div>
        </div>
      </div>
         
    <div class="form-group">
        <label class="col-xs-12 col-sm-1 control-label requiredField" for="fecha_actividad">*Fecha:</label>
        <div class="col-xs-12 col-sm-6">    
            <div class="input-daterange input-group" id="datepicker">
                <!--<span class="input-group-addon">Desde:</span>-->
                <input class="form-control input_reporte" name="fecha_desde" id="fecha_desde" type="text" placeholder="Desde:" required >
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></span>
                <input class="form-control input_reporte" name="fecha_hasta" id="fecha_hasta" type="text" placeholder="Hasta:" required >
            </div>
        </div>
    </div>
      
      <div class="form-group">
            <div class="col-xs-12 text-right">
             <button type="button" id="generar" name="generar" title="Generar Reporte" class="btn btn-default btn-xs-text"  onclick="envio_form()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>&nbsp;Generar PDF</button>
            </div>
        </div> 
        
	</form>




<?php 
/*
function pingDomain($domain){
    $starttime = microtime(true);
    $file      = @fsockopen ($domain, 80, $errno, $errstr, 10);
    $stoptime  = microtime(true);
    $status    = 0;
 
    if (!$file) $status = -1;  // Site is down
    else {
        fclose($file);
        $status = ($stoptime - $starttime) * 1000;
        $status = floor($status);
    }
    
    if ($status <> -1) {
        return true;
    } else {
        return false;
    }
    
}

$ip='10.34.30.242';

$ping=pingDomain($ip);

echo '<br>';

if($ping==1){
$total=explode(":",@snmpget($ip, 'public', '.1.3.6.1.2.1.43.11.1.1.8.1.1'));
$restante=explode(":",@snmpget($ip, 'public', '.1.3.6.1.2.1.43.11.1.1.9.1.1'));
$porcentaje_negro=($restante[1]*100)/$total[1];

$total=explode(":",@snmpget($ip, 'public', '.1.3.6.1.2.1.43.11.1.1.8.1.2'));
$restante=explode(":",@snmpget($ip, 'public', '.1.3.6.1.2.1.43.11.1.1.9.1.2'));
$porcentaje_azul=($restante[1]*100)/$total[1];

$total=explode(":",@snmpget($ip, 'public', '.1.3.6.1.2.1.43.11.1.1.8.1.3'));
$restante=explode(":",@snmpget($ip, 'public', '.1.3.6.1.2.1.43.11.1.1.9.1.3'));
$porcentaje_magenta=($restante[1]*100)/$total[1];

$total=explode(":",@snmpget($ip, 'public', '.1.3.6.1.2.1.43.11.1.1.8.1.4'));
$restante=explode(":",@snmpget($ip, 'public', '.1.3.6.1.2.1.43.11.1.1.9.1.4'));
$porcentaje_amarillo=($restante[1]*100)/$total[1];

?>

<div class="row">     
    <label class="col-xs-12 col-sm-1 control-label requiredField" for="one">Negro:</label>
    <div class="col-xs-12 col-sm-6">
        <div class="progress ">
            <div id="one" class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($porcentaje_negro)?>%;">
            <?php echo round($porcentaje_negro).'%';?>
            </div>
        </div>
    </div>
</div>

<div class="row">     
    <label class="col-xs-12 col-sm-1 control-label requiredField" for="one">Cyan:</label>
    <div class="col-xs-12 col-sm-6">
        <div class="progress ">
            <div id="dos" class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($porcentaje_azul)?>%;; color:#000000;">
             <?php echo round($porcentaje_azul).'%';?>
            </div>
        </div>
    </div>
</div>

<div class="row">     
    <label class="col-xs-12 col-sm-1 control-label requiredField" for="one">Magenta:</label>
    <div class="col-xs-12 col-sm-6">
        <div class="progress ">
            <div id="tres" class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($porcentaje_magenta)?>%;">
            <?php echo round($porcentaje_magenta).'%';?>
            </div>
        </div>
    </div>
</div>

<div class="row">     
    <label class="col-xs-12 col-sm-1 control-label requiredField" for="one">Amarillo:</label>
    <div class="col-xs-12 col-sm-6">
        <div class="progress ">
            <div id="four" class="progress-bar" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:<?php echo round($porcentaje_amarillo)?>%; color:#000000;">
            <?php echo round($porcentaje_amarillo).'%';?>
            </div>
        </div>
    </div>
</div>

<?php } */?>




</div>
		<script type="text/javascript" src="../../js/iframeResizer.contentWindow.js" defer></script>
</body>
</html>