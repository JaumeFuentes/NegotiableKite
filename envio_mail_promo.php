<?php
function mail_promo($email){			
		
		
		
		
		$nombre_origen="Negotiable Kite";
		$email_origen="no_reply@negotiablekite.com";
		$email_destino=$email;
		$asunto="Negotiable Kite: portal de anuncios clasificados de kitesurf";
		
		$mensaje='<html lang="es">
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
	
}

#caja1{
	height:73px;
	background-color:#2E3229;
}

#tit1{
	font-size:26px;
	margin-left:10px;
	margin-top:20px;
	color:#FFF;
	font-weight:bold;
}

#slogan{
	font-size:15px;
	margin-left:10px;
	margin-top:13px;
	color:#666;
	font-weight:bold;
}

#caja2{
	background-color:#DBFBB7;
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
	margin-bottom:3px;
}

</style>
<body>

<div id="cuerpo">
	<div id="caja1">
    	<div id="tit1">
        	NEGOTIABLE KITE
        </div>
        <div id="slogan">
        	El primer portal de anuncios de art&iacute;culos de kitesurf
        </div>
    </div>
    <div id="caja2">
    	<div class="caja3">
        	<div class="tit">
            Un lugar en el que anunciar tu material de kite y encontrar lo que necesitas
            </div>
            <div class="texto">
          <b><a href="http://www.negotiablekite.com" style="color: #0eb6ce; text-decoration: none;">Negotiable Kite</a></b> se trata de un portal de anuncios especialmente dedicado a la publicaci&oacute;n de anuncios realcionados con el mundo del kitesurf.
		  <br />
		  <ul>
		  	<li>
				En <b>Negotiable Kite</b> podr&aacute;s anunciar y poner a la venta cometas, tablas, arneses etc, pudiendo especificar detalles como la medida de la cometa, el tipo, si tiene reparaciones, si incluye la barra, etc.
			</li>
			<li>		  
				Realiza b&uacute;squedas avanzadas del material en el que est&aacute;s interesado.
				</li>
				<li>
					Publica tus anuncios y enl&aacute;zalos con facebook para que lleguen mas gente.
				</li>
				<li>
					Vota a los distintos usuarios como compradores y/o vendedores seg&uacute;n tus experiencias con ellos.
				</li>
				<li>
					Administra tus anuncios edit&aacute;ndolos o elimin&aacute;ndolos .
				</li>
			</ul>
			<b><a href="http://www.negotiablekite.com" style="color: #0eb6ce; text-decoration: none;">Negotiable Kite</a></b> es un punto de encuentro entre compradores y vendedores del mundo del kitesurf dando a estos la posibilidad de tener una gran variedad de art&iacute;culos perfectamente organizados, asi como un perfil de votaciones el cual garantice seguridad a la hora de realizar la compra o la venta.
            </div>
        </div>
        
        <div class="caja3">
        	<div class="tit">
            Contacta con nosotros
            </div>
            <div class="texto">
			<b>web:  <a href="http://www.negotiablekite.com" style="color: #0eb6ce; text-decoration: none;"> http://www.negotiablekite.com</a></b><br /><br />
            <b>e-mail: </b>  <a href="mailto:info@negotiablekite.com" style="color: #0eb6ce; text-decoration: none;">  info@negotiablekite.com</a><br /><br />
			 <b>Facebook: </b> <a href="http://www.facebook.com/negotiable.kite" style="color: #0eb6ce; text-decoration: none;"> http://www.facebook.com/negotiable.kite</a>
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
<div id="cr" style="width:406px; font-size:10px; margin-top:10px;">Si no deseas recibir mas emails de NK envia un email a info@negotiablekite.com escribiendo como asunto "no me des la paliza, pesao"</div>

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
	
mail_promo("superchauen@hotmail.com");
echo "enviado";
	
/*
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
//en total tengo 1193 direcciones de email
for($i=1019;$i<=1193;$i++){
	$query="SELECT email FROM lista_emails WHERE id='$i'";
	$result=mysql_query($query);
	$result_email = mysql_fetch_assoc($result); 
	$email=$result_email['email'];
	mail_promo($email);	
	echo $i."  ".$email."<br />";	
	sleep(4);	
}
*/

?>