<?php

$nombre_origen="Contacto Negotiable Kite";
$email_origen="no_reply@negotiablekite.com";
$email_destino = "info@negotiablekite.com";
$asunto = "Envio de formulario de contacto desde NK";

//*****************************************************************//
$headers  = "From: $nombre_origen <$email_origen> \r\n"; 
$headers .= "Return-Path: <$email_origen> \r\n"; 
$headers .= "Reply-To: $email_origen \r\n"; 
$headers .= "X-Sender: $email_origen \r\n"; 
$headers .= "X-Priority: 3 \r\n"; 
$headers .= "MIME-Version: 1.0 \r\n"; 
$headers .= "Content-Transfer-Encoding: 7bit \r\n"; 
$headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  
//*****************************************************************//



if(!isset($_REQUEST['name'])) $name="";
	else $name = $_REQUEST['name'];
if(!isset($_REQUEST['email'])) $email="";
	else $email = $_REQUEST['email'];
if(!isset($_REQUEST['message'])) $message="";
	else $message = $_REQUEST['message'];


if ($name=="" or $email=="" or $message=="")
	echo "<p style='color:red'> RELLENE TODOS LOS CAMPOS</p>";
else{	
	$mensaje = $name."<br />".$email."<br />".$message;
	
	$exito = mail($email_destino, $asunto, $mensaje, $headers);
	if($exito)	
		echo "Mensaje Enviado!";
}
?>