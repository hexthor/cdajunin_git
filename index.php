<?php
session_start();
include('funciones/conexion.php');
include('funciones/funciones.php');
include('includes/iniciohtml.php');
?>
     
<div class="container">
    <img class="img-responsive" src="img/index.png" alt="PDVSA" width="auto" height="auto"> 
</div>
   
    <br>
    <br>
    
  <div class="container">  
    <form id="formulario_login" class="form-horizontal" role="form" method="post" data-toggle="validator" target="_self"  action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <div class="form-group">
      <label for="input_usuario" class="col-xs-12 col-sm-4 control-label"><span class="glyphicon glyphicon-user"></span>&nbsp;Usuario:</label>
      <div class="col-xs-12 col-sm-5">
          <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario" pattern="^[A-Z]{1,}$" onKeyUp="mayusculas(this);" data-error="Campo invalido, verifique." required>
          <div class="help-block with-errors"></div>
        </div>
    </div>
    
    <div class="form-group">
      <label for="input_password" class="col-xs-12 col-sm-4 control-label"><span class="glyphicon glyphicon-eye-open"></span>&nbsp;Contrase&ntilde;a:</label>
      <div class="col-xs-12 col-sm-5">
          <input type="password" class="form-control" id="clave" name="clave" placeholder="Contrase&ntilde;a" data-error="El campo no puede estar vacio." required>
          <div class="help-block with-errors"></div>
        </div>
     </div>

     <div class="form-group">
        <div class="col-xs-12 col-sm-9 text-right">
          <button type="submit" class="btn btn-default" id="entrar" name="entrar">Entrar</button>
        </div>
    </div>
	</form>
  </div>  
  
  <br>
  
    <div class="container" style="background-color:#EFEFEF; padding-top:10px;">
    <section class="main row">
    	<article class="col-xs-12 text-center">
        	<p>Sistema Corporativo de Petroleos de Venezuela S.A.</p>
        </article>
    </section>
   </div>
   
<?php
include('includes/finhtml.php');
?> 


<?php 
$conexion=conexion();

if($_SESSION['regreso']==1)
{
	modal_alert('Notificaci&oacute;n:','glyphicon glyphicon-exclamation-sign','Debe iniciar sesi&oacute;n para entrar al sistema.');
}
$_SESSION['regreso']=0;

if (isset($_POST['entrar']))
{

	$usuario=$_POST['usuario'];
	$clave=$_POST['clave'];
	
	$consulta="select * from usuarios  where usuario='".$usuario."'";
	$query=query($consulta,$conexion);
	$result=fetch_array($query);
	
	if($result['usuario']=='' || $result['usuario']==NULL)
	{	
		modal_alert('Notificaci&oacute;n:','glyphicon glyphicon-exclamation-sign','El usuario <strong>'.$usuario.'</strong> no esta registrado en el sistema. Verifique.');
	}
	else
	{
		if ($clave==$result['clave'])
				{	
					$_SESSION['autenticado']="SI";				
					$_SESSION['usuario']=$result['usuario'];
					$_SESSION['nombre']=$result['nombre'];
					$_SESSION['apellido']=$result['apellido'];
					$_SESSION['cedula']=$result['cedula'];
					$_SESSION['correo']=$result['correo'];
					$_SESSION['firma']=$result['firma'];
					
					$_SESSION['actividades']=$result['actividades'];
					$_SESSION['pendientes']=$result['pendientes'];
					$_SESSION['asignaciones']=$result['asignaciones'];
					$_SESSION['reportes']=$result['reportes'];
					$_SESSION['configuracion']=$result['configuracion'];
										
					redireccionar("sistema/inicio.php");
				}
				else
				{
					modal_alert('Notificaci&oacute;n:','glyphicon glyphicon-exclamation-sign','La contrase&ntilde;a es incorrecta. Verifique.');
				}
	}
}

?>

