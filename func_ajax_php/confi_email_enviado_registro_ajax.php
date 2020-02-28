<?php
include_once '../core/init.inc.php';
$las_webs=new webs;

!isset($_REQUEST['mail_contacto'])? $mail_contacto="" : $mail_contacto=$_REQUEST['mail_contacto'];
!isset($_REQUEST['asunto'])? $asunto="" : $asunto=$_REQUEST['asunto'];
!isset($_REQUEST['mensaje'])? $mensaje="" : $mensaje=nl2br($_REQUEST['mensaje']);
!isset($_REQUEST['user'])? $user="" : $user=$_REQUEST['user'];
!isset($_REQUEST['codan'])? $codan="" : $codan=$_REQUEST['codan'];
sleep(4);
if($mail_contacto!="" and $asunto!="" and $mensaje!="" and $user!=""){

	//envio email de confirmacion al usuario de que se ha enviado su email
	$las_webs->envia_confirma_mail_anuncio($user,$mail_contacto,$asunto,$mensaje,$codan);
	
	//ahora veo si el usuario que envia el mail esta registrado o no
	$query="SELECT * FROM users WHERE email='$mail_contacto'";
	$result=mysql_query($query) or die(mysql_error());
	if($result){
		if(mysql_num_rows($result)==0){
		
			//si no me devuelve ningun resultado inserto su email y un numero aleatorio en la tabla users y le envio un email de registro.
			//su estado será 1 porque no estará activo. Habrá que tener en cuenta que cuando finalice el registro mediante este proceso no necesitará activacion mediante email.
			
			$aleatorio=$las_webs->genera_random(20);
				
			$las_webs->mail_registro($mail_contacto,$aleatorio);
		}
	}
}	
		
		


?>






				