<?php

/*
Grupos de emails:
	1: Usuarios registrados y activados.
	2: Usuarios regsitrados no activados.
	3: Usuarios no  registrados que algun dia enviaron un email.
	4: Emails conseguidos en forokiters y spainkiters
	
Hay que asegurarse que los del grupo 4 no estan ni en el 3,2,1
En la base de datos:
	- mail_enviado: 1 significa que se ha enviado email
	- enviar_mail: 1 significa que tienen activado la recepcion de emails
	
Para enviar mensaje masivo hay que:
	1º Seleccionar grupo en la variable $grupo
	2º Introducir en asunto en la variable $asunto
	3º Introducir en mensaje en la variable $mensaje. Tener en cuenta que *usuario* se reemplazará por el nombre de usuario(si existe)
	   y *mail* se sustituirá por la dirección de email
*/
include (dirname(__FILE__)."/../clases/phpmailer/class.phpmailer.php");
include (dirname(__FILE__)."/../clases/clase_email.php");

ini_set("SMTP","auth.smtp.1and1.co.uk");
ini_set("sendmail_from","no_reply@negotiablekite.com");
ini_set("smtp_port", "587");


$grupo=1;
//$asunto="Anuncia y encuentra material de kitesurf en Negotiable Kite";
$asunto="Negotiable Kite: nueva seccion de VIDEOS!";
//$mail->AltBody="Anuncia tu material de kitesurf gratis!";
$mail->AltBody="Negotiable Kite: nueva seccion de VIDEOS!";
$mensaje_aux = '<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>
<style>
body{
	font-family:Helvetica, Arial, sans-serif;
}

#cuerpo{
	width:460px;
	padding:2px;
	border:2px solid #0EB6CE;
	
}

#caja1{
	height:59px;
	background-color:#2E3229;
}

#tit1{
	font-size:26px;
	margin-left:10px;
	
	
	font-weight:bold;
}

#tit1 a{
	color:#FFF;
}

#slogan{
	font-size:15px;
	margin-left:10px;
	margin-top:3px;
	color:#ccc;
	font-weight:bold;
}

#caja2{
	background-color:#F9F5B8;
}

.caja3{
	width:406px;
	margin-left:20px;
	padding-top:10px;
}

.tit{
	font-weight:bold;
	color:#666;
	margin-bottom:5px;
}

.texto{
	text-align:justify;
	color:#004040;
	font-size:12px;
}

li{
	margin-bottom:10px;
}

a{
	text-decoration:none;
	font-weight:bold;
	color:#0EB6CE;
}
a:hover,#tit1 a:hover {
    color: #FFCC33;
}
</style>
<body>

<div id="cuerpo">
	<div id="caja1">
    	<div id="tit1">
        	<img src="http://www.negotiablekite.com/iconos/detalle_nk.png" />
        	<a href="http://www.negotiablekite.com">NEGOTIABLE KITE</a>
        </div>
        <div id="slogan">
        	El primer portal de anuncios de art&iacute;culos de kitesurf
        </div>
    </div>
    <div id="caja2">
    	<div class="caja3">
        	<div class="tit">
          	  Negotiable Kite estrena una nueva sección de <a href="http://www.negotiablekite.com/video"><b>videos</b></a>!!
            </div>
            <div class="texto">
          		Hola *usuario*,<br/><br/>
				queriamos informarte que en Negotiable Kite hemos lanzado una nueva seccion de videos con diferentes categorias como Kitesurf, Surf, Windsurf, Snowboard, etc.<br/><br/>
				
				Con vuestra cuenta de usuarios de NK podeis iniciar sesion y empezar a <b>compartir vuestros videos</b>, enlazar videos de youtube, vimeo, etc.., a&ntilde;adir videos a vuestros favoritos, votar, seguir a usuarios y muchas cosas mas!
				<br /><br/>
				Pasaros y empezad a disfrutar de los mejores videos extremos y no os olvideis de recomendarlo a vuestros amigos kiters, surferos, windsurferos....quien sea!
		  
			
            </div>
        </div>
        
        <div class="caja3">
        	<div class="tit">
            Contacta con nosotros
            </div>
            <div class="texto">
			<b>web:  <a href="http://www.negotiablekite.com" > http://www.negotiablekite.com</a></b><br /><br />
            <b>e-mail: </b>  <a href="mailto:info@negotiablekite.com" >  info@negotiablekite.com</a><br /><br />
			 <b>Facebook: </b> <a href="http://www.facebook.com/groups/negotiablekite/" > http://www.facebook.com/groups/negotiablekite/</a>
            </div>
        </div>
        
        <div class="caja3">
        	<div class="tit">
           
            </div>
            <div class="texto" style="margin-bottom:5px;"> 
            Un saludo de parte del equipo de <b>Negotiable Kite</b>
            </div>
			
			
        </div>  
    </div>
	<div id="saludo">
		<span style="font-size:11px; margin-left:180px; color:#999999;">&copy;Negotiable Kite</span>
        </div>
</div>
<div id="cr" style="width:406px; font-size:10px; margin-top:10px;">
	Este mensaje fue enviado a <a href="mailto:*mail*">*mail*</a>. Si no deseas recibir mas avisos haz clik <a href="http://www.negotiablekite.com/desact_alert?mail=*mail*">aqui</a>
</div>

</body>
</html>';
?>



<?php
$mail = new clase_emails;
$mail->reset_mail_enviado();//este solo vale para el grupo 4
$mail->IsSMTP();
$mail->SMTPAuth = true; // enable SMTP authentication
$mail->Host = "auth.smtp.1and1.co.uk";
$mail->Port = 25; // set the SMTP port
//$mail->Port = 587; // set the SMTP port


$mail->Username="no_reply@negotiablekite.com";
$mail->Password="00000177";

$mail->From="no_reply@negotiablekite.com";
$mail->FromName="Negotiable Kite";
$mail->Timeout=20;
$mail->IsHTML(true);

$mail->Subject=$asunto;
$mail->obten_datos($grupo);
$datos = $mail->getProperty('datos_obt');
$num_emails = $mail->getProperty('num_emails');

set_time_limit(0);
for($i=0;$i<$num_emails;$i++){
	//limito el numero de emails enviados a 200
	if($i==5) break;
	
	//mediante el archivo controlo cuando paro el bucle
	$archivo = file(dirname(__FILE__)."/stop_envio.txt");
	if($archivo[0]==1) break;
	
	$usuario = $datos[$i]['usuario'];
	$email_destino = $datos[$i]['email_destino'];	
	$cod_usuario = $datos[$i]['cod_usuario'];
	$activate = $datos[$i]['activate'];
	if($usuario=="NULL") $usuario="";
	
	$mensaje = $mensaje_aux;
	$mensaje = $mail->mod_mensaje($mensaje,$usuario,$email_destino,$cod_usuario,$activate);
	$mail->Body=$mensaje;
	$mail->AddAddress($email_destino);
	//$exito = $mail->Send();
	$mail->Send();
	
	//if($exito){
		$mail->mail_enviado($email_destino);
		$mail->ClearAddresses();
		
	//}
	//else{
		//break;
		//$i = $i-1;
		//echo "error. probando de nuevo <br />";
	//}
				
	sleep(4); 
}
?>
