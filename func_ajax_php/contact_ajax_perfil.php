<?php
include_once '../core/init.inc.php';


!isset($_REQUEST['vendedor'])? $vendedor = "" : $vendedor = $_REQUEST['vendedor'];
!isset($_REQUEST['asunto']) ? $asunto="" : $asunto = $_REQUEST['asunto'];
!isset($_REQUEST['email']) ? $mail_contacto="" : $mail_contacto = $_REQUEST['email'];
!isset($_REQUEST['message']) ? $message="" : $message = $_REQUEST['message'];


if($vendedor){
	$ObjetoVendedor = new perfil($vendedor);
	$datosVendedor = $ObjetoVendedor->loadUserData($vendedor);
	$email_vendedor = $datosVendedor['email'];
}


if ($mail_contacto=="" or $message=="" or $asunto=="")
	echo "<p style='color:red'> RELLENE TODOS LOS CAMPOS</p>";
else{	
	$email = new Email;
	$exito = $email->email_perfil($email_vendedor,$asunto,$mail_contacto,$message);
	if($exito)			
		echo "Mensaje Enviado!";
	else
		echo "UFFFF PARECE QUE HA HABIDO UN ERROR";
}

?>