<?php
function mail_promo($email,$usuario){			
		
		
		
		
		$nombre_origen="Negotiable Kite";
		$email_origen="no_reply@negotiablekite.com";
		$email_destino=$email;
		$asunto="Novedades en Negotiable Kite: el boton bump!";
		
		$mensaje='<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
Hola '.$usuario.' <br />
<br />
Se han incluido varias posibilidades a la hora de mostrar los resultados   de b&uacute;squeda destacando una nueva funcionalidad: el bot&oacute;n Bump! <br />
<br />
Ahora en las b&uacute;squedas se mostrar&aacute;n, por defecto, primero los &uacute;ltimos   anuncios  publicados y/o sobre los que se haya pinchado en el bot&oacute;n   bump!. <br />
<br />
&iquest;que es el bot&oacute;n bump? <br />
<br />
Si tienes un anuncio publicado y quieres que este suba al primero de la   lista para que lo vea mas gente, simplemente tienes que iniciar sesi&oacute;n,   localizar tu anuncio en los resultados de b&uacute;squeda ( de cometas, tablas o   lo que sea) y pinchar sobre el bot&oacute;n bump! y automaticamente tu anuncio   se mover&aacute; al principio de la lista con lo que cada vez que alguien   realice una b&uacute;squeda tu anuncio aparecer&aacute; el primero. <br />
<br />
De momento no hay l&iacute;mite de veces de pinchar sobre el bot&oacute;n bump!, asi que ale, a pinchar. <br />
<br />
Un saludo y buen viento!
<br />
<a href="http://www.negotiablekite.com" target="_blank">Negotiable Kite</a>

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
	
//mail_promo("superchauen@hotmail.com");
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

$query="SELECT email,nick FROM users WHERE mail_enviado != 1";
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