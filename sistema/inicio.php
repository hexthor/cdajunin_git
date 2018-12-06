<?php
include('../funciones/conexion.php');
include('../funciones/funciones.php');
comprobar(1);
$conexion=conexion();
$select_pendiente="SELECT * FROM pendientes WHERE estado!='CERRADO'";
$query_pend=query($select_pendiente,$conexion);
$num_rows=num_rows($query_pend);
?>

<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>CDA Junin</title>

<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
<link rel="shortcut icon" href="../img/favicon2.ico">
<link rel="stylesheet" href="../css/estilos.css">
<link rel="stylesheet" href="../css/bootstrap.min.css">
<link rel="stylesheet" href="../css/bootstrap-theme.min.css">
<link href="../css/centersimple.css" rel="stylesheet"/>
<link href="../css/dataTables.bootstrap.min.css" rel="stylesheet"/>

<script src="../js/pace.min.js"></script>
<script type="text/javascript" src="../js/jquery-3.1.0.min.js"></script>
<script type="text/javascript" src="../js/bootstrap.min.js"></script>
<script type="text/javascript" src="../js/validator.js"></script>
<script type="text/javascript" src="../js/funciones.js"></script>
<script type="text/javascript" src="../js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="../js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript" src="../js/bootstrap-hover-dropdown.js"></script>


<script type="text/javascript" class="init">
	
$(document).ready(function() {
			
		var flag = 0;
		var flag2 = 0;
		
		$('#conf').click(function() {
    		flag = 1;
 		});
				
		$('#cerrarsesion').click(function() {
    		flag2 = 1;
 		});
		
		$(".nav a").on("click", function(){
			
			if (flag == 1)
 			{
				$("#conf").off('click');
				flag = 0;
			}
			else
			{
				if (flag2 != 1)
				{
					$(".nav").find(".active").removeClass("active").css('font-weight', 'normal');
					$(this).parent().addClass("active").css('font-weight', 'bold');
				}
				flag = 0;
				flag2 = 0;
			}
		});
		
		$(".dropdown-menu a").on("click", function(){
			$("#conf").parent().addClass("active").css('font-weight', 'bold');
		});
		
		iFrameResize({
			log                     : false,                  // Enable console logging
			inPageLinks             : true,
		});
		
		$('#pendiente_badge').text("<?php echo $num_rows;?>");
				
	});
</script>

</head>
<body>

<div class="container" id="idheader">
  <div class="page-header">
    <div class="row" style="margin-top:10px; margin-bottom:10px;">
    	<div class="col-xs-3"><img src="../img/logopdvsa.png" alt="PDVSA" id="imgpdvsa"></div>
        <div class="col-xs-3 punteado" id="headeruno">Petr&oacute;leos de Venezuela S.A</div>
        <div class="col-xs-6 punteado" id="headerdos">Sistema de Reportes CDA Jun&iacute;n<!--SIRCA: Sistema de Reportes y Control de Activos--></div>
    </div>
    
        <div class="row">
        	<div class="col-xs-12" style="background-color:#ff3333;"></div>
        </div>
 
         <div class="row" id="barragradient">
            <div class="col-xs-6 text-left">Bienvenido: <?php session_start(); /*WHY?*/ echo '<strong>'.htmlentities($_SESSION['nombre']).' '.htmlentities($_SESSION['apellido']).'</strong>';?> </div>
            <div class="col-xs-6 text-right"><script language='javascript'>fecha1();</script></div>
        </div> 
        
        <div class="row">
            <div class="col-xs-12 text-right" style="background-color:#ff3333; color:#FFFFFF;"><small style="font-size:11px;">Version: 1.0b</small></div>
        </div> 
  </div>
</div>

<div class="container">
  
  <nav class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
           <div class="navbar-brand">Men&uacute;</div>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
          
            <?php if($_SESSION['actividades']==1){?><li class="active" style="font-weight:bold;"><a href="actividades/actividades.php" target="marco">Actividades</a></li><?php }?>
            <?php if($_SESSION['pendientes']==1){?><li><a href="pendientes/pendientes.php" target="marco">Pendientes <span class="badge" id="pendiente_badge"></span></a></li><?php }?>
            <?php if($_SESSION['asignaciones']==1){?><li><a href="asignaciones/asignaciones.php" target="marco">Asignaciones</a></li><?php }?>
            <?php if($_SESSION['reportes']==1){?><li><a href="reportes/reportes.php" target="marco">Reportes</a></li><?php }?>
            
            <?php if($_SESSION['configuracion']==1){?>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" role="button" aria-haspopup="true" aria-expanded="false" id="conf">Configuraci&oacute;n<span class="caret"></span></a>
              <ul class="dropdown-menu">
              <li class="dropdown-header">Usuarios</li>
                <li><a href="#usuarios">Gestionar</a></li> 
                <li><a href="#localidades">Cambio de Clave</a></li>
                <li><a href="#algo">Algo</a></li>
                <li role="separator" class="divider"></li>
                <li class="dropdown-header">Divisor</li>
                <li><a href="#link1">Link1</a></li>
                <li><a href="#link2">Link2</a></li>
                <li><a href="#link3">Hola</a></li>
              </ul>
            </li>
            <?php }?>
          </ul>
          <ul class="nav navbar-nav navbar-right" style="padding-right:27px;">
      		<li><a data-toggle="modal" data-target="#modalcerrarsesion" href="#" id="cerrarsesion" title="Salir del sistema"><span class="glyphicon glyphicon-remove-sign"></span>&nbsp;Salir</a></li>
    	  </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
</div>
   
<div class="container">
<iframe src="actividades/actividades.php" width="100%" scrolling="no" frameborder="0" id="marco" name="marco"></iframe>
</div>
        
<div class="container" style="background-color:#EFEFEF; margin-top:10px;">
    <section class="main row">
        <article class="col-xs-12 text-center">
        <p style="padding-top:10px;">Sistema Corporativo de Petroleos de Venezuela S.A.</p>
        </article>
    </section>
</div>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="modalcerrarsesion" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header msjerroneo">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong><span class="glyphicon glyphicon-exclamation-sign"></span>&nbsp;Notificaci&oacute;n:</strong></h4>
      </div>
      <div class="modal-body">
        <h4>¿Desea cerrar sesi&oacute;n?</h4>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" onClick="location.href='logout.php';"><span class="glyphicon glyphicon-ok"></span>&nbsp;Aceptar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;Cancelar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript" src="../js/iframeResizer.js"></script>
</body>
</html>