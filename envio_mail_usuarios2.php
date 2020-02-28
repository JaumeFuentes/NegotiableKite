<?php
function mail_promo($email,$usuario){			
		
		
		
		
		$nombre_origen="Negotiable Kite";
		$email_origen="no_reply@negotiablekite.com";
		$email_destino=$email;
		$asunto="Novedades en Negotiable Kite: Conecta con Facebook";
		
		$mensaje='<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<style type="text/css">
<!--
.Estilo1 {color: #0000FF}
-->
</style>
</head>

<body>
<p>Hola '.$usuario.', <br />
  <br />
Acabamos de lanzar una aplicaci&oacute;n en Negotiable Kite para que puedas <strong>conectar tu cuenta de Facebook con Negotiable Kite</strong>.</p>
<p>Simplemente tienes que ir a la p&aacute;gina principal de <a href="http://www.negotiablekite.com" target="_blank">Negotiable Kite</a> y pinchar sobre el bot&oacute;n <em>Conectar con facebook. </em></p>
<p class="Estilo1">  &iquest;Que te aporta esta aplicaci&oacute;n?</p>
<ol>
  <li>Cuando publiques  un anuncio en Negotiable Kite tendr&aacute;s la posibilidad de <strong>publicar el anuncio autom&aacute;ticamente tambi&eacute;n en tu muro de Facebook</strong> ahorr&aacute;ndote la faena de   tener que escribirlo otra vez en facebook y d&aacute;ndote la posibilidad de   que lo vea mas gente.</li>
  <br>
    
    <li>Si estas logueado en facebook y accedes a la p&aacute;gina   de Negotiable Kite autom&aacute;ticamente iniciar&aacute;s sesi&oacute;n en esta sin tener   que volver a introducir los datos, y viceversa!</li><br>
  <li>Podr&aacute;s iniciar sesi&oacute;n en Negotiable Kite con tu cuenta de facebook. </li><br>
  <li>Podr&aacute;s registrate en negotiable kite en unos segundos con tu cuenta de facebook.</li>
</ol>
<p>&nbsp;</p>
<p>En un futuro, conforme la gente vaya utilizando la aplicaci&oacute;n, a&ntilde;adiremos nuevas funciones: por ejemplo...<u>&iquest;te gustar&iacute;a ver que amigos tuyos de facebook tienen auncios publicados en negotiable kite?</u> Igual un colega tuyo vende algo que te interesa y no lo sabias. Siempre mejor comprarle a alg&uacute;n conocido que a un extra&ntilde;o no?</p>
<p>&nbsp;</p>
<p>No te preocupes por los permisos que te pide la aplicaci&oacute;n, son necesarios para que esta funcione correctamente.</p>
<p>Al pinchar sobre el bot&oacute;n de conectar con Facebook la aplicaci&oacute;n solicita basicamente dos permisos: </p>
<ol>
  <li><u>Conocer tu direcci&oacute;n de email</u> : Esto se emplear&aacute; &uacute;nicamente para   relacionar tu cuenta de facebook con la de Negotiable Kite. En ning&uacute;n   caso se enviar&aacute; ning&uacute;n tipo de email no deseado.</li>
  <li><u>Postear en   tu facebook</u> : Esto se emplear&aacute; &uacute;nica y exclusivamente para, y cuando tu   lo decidas, publicar automatimente tus anuncios de negotiable kite en tu   muro de facebook.<br>
    <br>
  </li>
</ol>
<p>Puedes ver mas informaci&oacute;n sobre la aplicaci&oacute;n en la siguiente direcci&oacute;n: <a href="http://www.facebook.com/pages/Registro-en-negotiablekite/142032429247316?sk=info" target="_blank">http://www.facebook.com/pages/Registro-en-negotiablekite/142032429247316?sk=info</a></p>
<p>No te olvides de pinchar en <b><em>me gusta</em></b>  para que se apunten tus amigos, cuantos mas sean mejor funcinar&aacute;!</p>
<p>&nbsp;</p>
<p>Un saludo y buen viento.  <br>
  <br>
  <br />
  <a href="http://www.negotiablekite.com" target="_blank">Negotiable Kite</a></p>
</body>
</html>'; 
			
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
			
		
			ini_set("SMTP", "localhost"); 
			
			mail($email_destino, $asunto, $mensaje, $headers);			 
	}
	
//mail_promo("superchauen@hotmail.com",superchauen);
//echo "enviado";


$DBHost="db370324546.db.1and1.com";
		 $DBUser="dbo370324546";
		 $DBPass="j8ef6sm80r";
		 $DBName="db370324546";		
		 
		 //compruebo que el servidor responde
		 @mysql_connect($DBHost,$DBUser,$DBPass)
		 	or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");
			
		//intentamos seleccionar la base de datos negotiable
		if(!mysql_select_db($DBName))
			die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS NEGOTIABLE");

set_time_limit(0);
/*
for($i=1019;$i<=1193;$i++){
	$query="SELECT email FROM lista_emails WHERE id='$i'";
	$result=mysql_query($query);
	$result_email = mysql_fetch_assoc($result); 
	$email=$result_email['email'];
	mail_promo($email);	
	echo $i."  ".$email."<br />";	
	sleep(4);	
}*/

$query="SELECT email,nick FROM users WHERE mail_enviado != 1 AND nick!='NULL'";
$resultado=mysql_query($query);	
$i=0;			
while($registro=mysql_fetch_row($resultado)){
	mail_promo($registro[0],$registro[1]);
	$query2="UPDATE users SET mail_enviado='1' WHERE nick='$registro[1]'";
	$result2=mysql_query($query2) or die(mysql_error()); 
	echo $i."  ".$registro[1]."<br />";
	$i++;
	sleep(4);
}
?>