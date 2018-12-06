<?php
include('../../funciones/conexion.php');
include('../../funciones/funciones.php');
require '../phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer;

//$mail->SMTPDebug = 3;                               // Enable verbose debug output

$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'plcsmtp.pdvsa.com';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'morenoho@pdvsa.com';                 // SMTP username
$mail->Password = 'morenoho10';                           // SMTP password
$mail->SMTPSecure = 'STARTTLS';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 25;                                    // TCP port to connect to

$mail->setFrom('morenoho@pdvsa.com', 'Hector Moreno');
//$mail->addAddress('joe@example.net', 'Joe User');     // Add a recipient
$mail->addAddress('morenoho@pdvsa.com');               // Name is optional
//$mail->addReplyTo('info@example.com', 'Information');
//$mail->addCC('cc@example.com');
//$mail->addBCC('bcc@example.com');

$mail->addAttachment('temp/MORENOHO_5_1_2016-08-24_2016-8-24.JPG');         // Add attachments
//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
$mail->isHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Esto es una prueba';
$mail->Body    = 'This is the HTML message body <b>in boldddd :)!</b>';
$mail->AltBody = 'Cambio de Guardia Hector Moreno.';

if(!$mail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    echo 'Message has been sent';
}