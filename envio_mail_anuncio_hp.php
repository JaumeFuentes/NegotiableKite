<?php
function mail_promo($email){			
		
		
		
		
		$nombre_origen="Negotiable Kite";
		$email_origen="no_reply@negotiablekite.com";
		$email_destino=$email;
		$asunto="Negotiable Kite: Promocion camisetas HokusPokus para usuarios de NK";
		
		$mensaje='<html lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
.ln{
	width:630px;
	height:15px;
	background-color:#000;
}

#contenedor2{
	width:630px;
}

#izda{
	float:left;
	background:url(http://www.negotiablekite.com/anuncios/hp/NK_HP.png) center center no-repeat;
	width:315px;
	height:390px;
}

#dcha{
	width:315px;
	float:left;
}

#titulo{
	width:315px;
	height:30px;
	background-color:#000;
	color:#ff6501;
	font-size:18px;
	font-weight:bold;
	margin-top:28px;
	text-align:center;
	line-height:30px;
}

#encabezado{
	margin-top:8px;
	margin-left:8px;
	margin-right:5px;
	color:#ff6501;
	font-weight:bold;
	text-align:justify;
}

#texto{
	text-align:justify;
	margin-left:8px;
	margin-top:15px;
	font-size:12px;
	font-family:"Comic Sans MS", cursive;
}

#foto1{
	width:85px;
	height:103px;
	background:url(http://www.negotiablekite.com/anuncios/hp/rojo4.png) no-repeat center;
	float:left;
}

#foto2{
	width:85px;
	height:103px;
	background:url(http://www.negotiablekite.com/anuncios/hp/azulok.png) no-repeat center;
	float:left;	
}

#foto3{
	width:85px;
	height:103px;
	background:url(http://www.negotiablekite.com/anuncios/hp/okverde.png) no-repeat center;
	float:left;
}

.foto{
	margin-left:16px;
	margin-bottom:5px;
	margin-top:5px;
}

#cr{
	color:#ff6501;
	font-size:9px;
	text-align:center;
	margin-top:4px;
	width:630px;
}

a{
	text-decoration:none;
	color:#ff6501;
	font-weight:bold;
}
	

</style>
</head>

<body>
<div id="contenedor">
	<div id="cuerpo">
    	<div class="ln"></div>
        <div id="contenedor2">
        	<div id="izda"><img src="http://www.negotiablekite.com/anuncios/hp/NK_HP.png"</div></div>
            <div id="dcha">
            	<div id="titulo">PROMOCI&Oacute;N CAMISETAS</div>
                <div id="encabezado">HokusPokus lanza una oferta especial para los usuarios de Negotiable Kite!!</div>
                <div id="texto">
                	Para todos los usuarios de <a href="http://www.negotiablekite.com">Negotiable Kite</a> la tienda <a href="http://www.hokuspokus.es">Hokuspokus</a> realiza un descuento de 5&euro; en sus camisetas kitesurferas, que pode&iacute;s ver en su p&aacute;gina web www.hokuspokus.com <br /><br />
                    Simplemente contacta con ellos a trav&eacute;s de su p&aacute;gina web o de su p&aacute;gina de <a href="http://www.negotiablekite.com/perfil.php?user=hokuspokus">perfil en NK</a> indicando el nick y la direcci&oacute;n de correo con la que te has registrado en negotiable kite y obtendr&aacute;s tu descuento del 25%. <br /><br />
                    
					La oferta es limitada, no la deje&iacute;s escapar!!

                </div>
                <div id="fotos">
                	<a href="http://everyoneweb.com/WA/DataFileshokuspokus/rojo4.JPG"><div class="foto" id="foto1">
						<img src="http://www.negotiablekite.com/anuncios/hp/rojo4.png"></img></div></a>
                    <a href="http://everyoneweb.com/WA/DataFileshokuspokus/azulok.JPG"><div class="foto" id="foto2">
						<img src="http://www.negotiablekite.com/anuncios/hp/azulok.png"></img></div></a>
                    <a href="http://everyoneweb.com/WA/DataFileshokuspokus/okverde.JPG"><div class="foto" id="foto3">
						<img src="http://www.negotiablekite.com/anuncios/hp/okverde.png"></img></div></a>
                </div>
            </div>
        </div>
        <div style="clear:both"></div>
        <div class="ln"></div>
        <div id="cr">&copy; Negotiable Kite</div>
    </div>
</div>

<div  style="width:630px; font-size:10px; margin-top:10px;">Si no deseas recibir mas emails de promocion de NK envia un email a info@negotiablekite.com escribiendo como asunto "borrar email"</div>                    
      		
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
	
//mail_promo("clarita1986@hotmail.com");
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
//----------------------------------------------------------
//en total tengo 1193 direcciones de email
for($i=1177;$i<=1193;$i++){
	$query="SELECT email FROM lista_emails WHERE id='$i'";
	$result=mysql_query($query);
	$result_email = mysql_fetch_assoc($result); 
	$email=$result_email['email'];
	mail_promo($email);	
	echo $i."  ".$email."<br />";	
	sleep(4);	
}
//----------------------------------------------------------
*/
//----------------------------------------------------------
//para usuarios de NK
$i=1;
$query="SELECT email FROM users ";
$result=mysql_query($query);
while ($registro=mysql_fetch_assoc($result)){
	$email=$registro['email'];
	mail_promo($email);	
	echo $i."  ".$email."<br />";	
	$i++;
	sleep(4);	
}
//----------------------------------------------------------

?>