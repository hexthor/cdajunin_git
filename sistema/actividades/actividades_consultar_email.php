<?php
include('../../funciones/conexion.php');
include('../../funciones/funciones.php');
require '../phpmailer/PHPMailerAutoload.php';
comprobar(2);
session_start();

	$mail = new PHPMailer;
	$mail->isSMTP();
	$mail->Host = 'plcsmtp.pdvsa.com';
	$mail->SMTPAuth = true;
	$mail->Username = $_SESSION['correo'];
	$mail->Password = $_POST['clave_email'];
	$mail->SMTPSecure = 'STARTTLS';
	$mail->Port = 25;
	
	$mail->SMTPOptions = array('ssl' => array('verify_peer' => false,'verify_peer_name' => false,'allow_self_signed' => true)); /****NOT SECURE****/

	$pattern = '/^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/';
	
	$mail->setFrom($_SESSION['correo'], $_SESSION['nombre'].' '.$_SESSION['apellido']);
	//$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
	
	$novalido='';
	
	$cuenta_para=count($para=$_POST['para_email']);
	if($cuenta_para>0)
	{
		$a=0;
		while($a<$cuenta_para)
		{
			if(preg_match($pattern, $para[$a]) === 1)
			{
				$mail->addAddress($para[$a]);
			}
			else if($para[$a]!= NULL)
			{
				$novalido='* '.$para[$a].'\n'.$novalido;
			}
			$a=$a+1;
		}
	}

	$cuenta_cc=count($cc=$_POST['cc_email']);
	if($cuenta_cc>0)
	{
		$b=0;
		
		while($b<$cuenta_cc)
		{
			if(preg_match($pattern, $cc[$b]) === 1)
			{
				$mail->addCC($cc[$b]);
			}
			else if($cc[$b]!= NULL)
			{
				$novalido='* '.$cc[$b].'\n'.$novalido;
			}
			$b=$b+1;
		}
	}
	
	$cuenta_bcc=count($bcc=$_POST['bcc_email']);
	if($cuenta_bcc>0)
	{
		$c=0;
		while($c<$cuenta_bcc)
		{
			if(preg_match($pattern, $bcc[$c]) === 1)
			{
				$mail->addBCC($bcc[$c]);
			}
			else if($bcc[$c]!= NULL)
			{
				$novalido='* '.$bcc[$c].'\n'.$novalido;
			}
			$c=$c+1;
		}
	}
	
	//$mail->addReplyTo('info@example.com', 'Information');
	//$mail->addCC('cc@example.com');
	//$mail->addBCC('bcc@example.com');
		
	$responsable=$_SESSION['usuario'];
	$cuenta_soportes=count($id_src=$_POST['id_src']);
	if($cuenta_soportes>0 && $_POST['check_soportes_email']==1) /*ADJUNTAR ARCHIVOS DE LA ACTIVIDAD*/
	{
		$i=0;
		while($i<$cuenta_soportes)
		{
			$mail->addAttachment('soportes/'.$responsable.'/'.$id_src[$i],'Soporte-'.($i+1));
			$i=$i+1;
		}
		
		//$cadena_soportes='<br><br><b>Soportes: </b>'.$cuenta_soportes;
	}
	
	$mail->isHTML(true);
	
	$mail->Subject = iconv('UTF-8', 'windows-1252',$_POST['asunto_email']);
	
	$mail->Body    = iconv('UTF-8', 'windows-1252',nl2br(htmlentities($_POST['mensaje_email']))).' <br><br>'.iconv('UTF-8', 'windows-1252',$_SESSION['firma']);
	
	$mail->AltBody = '';
	
	if(strlen($novalido)>0)
	{
		alert('Correos no validos: \n\n'.$novalido);
	}
	
	if(!$mail->send()) {
		alert('El mensaje no pudo ser enviado. Error: ' . $mail->ErrorInfo);
	} else {
		alert("Correo enviado con exito.");
	}
	
	redireccionar("actividades_consultar.php?id_actividad=".$_POST['id_actividad']);
	exit();
?>