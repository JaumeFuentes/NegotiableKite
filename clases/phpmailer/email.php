    <?php
    require("class.phpmailer.php");
    $mail = new PHPMailer();
    

	
  
$mail->IsSMTP();
$mail->SMTPAuth = true; // enable SMTP authentication
$mail->Host = "auth.smtp.1and1.co.uk";
$mail->Port = 25; // set the SMTP port


$mail->Username="info@negotiablekite.com";
$mail->Password="00000177";

$mail->From="no_reply@negotiablekite.com";
$mail->FromName="Negotiable Kite";
$mail->Timeout=60;
$mail->IsHTML(true);
//Enviamos el correo
$mail->AddAddress('superchauen@hotmail.com'); //Puede ser Hotmail
$mail->Subject='Anuncia y encuentra material de kitesurf en Negotiable Kite';
$mail->Body='<html lang="es">
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
	border:2px solid #cccccc;
	
}

#caja1{
	height:59px;
	background-color:#2E3229;
}

#tit1{
	font-size:26px;
	margin-left:10px;
	
	color:#FFF;
	font-weight:bold;
}

#slogan{
	font-size:15px;
	margin-left:10px;
	margin-top:3px;
	color:#ccc;
	font-weight:bold;
}

#caja2{
	background-color:#eee;
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
a:hover {
    color: #FFCC33;
}
</style>
<body>

<div id="cuerpo">
	<div id="caja1">
    	<div id="tit1">
        	<img src="http://www.negotiablekite.com/iconos/detalle_nk.png" />
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
          <b><a href="http://www.negotiablekite.com" >Negotiable Kite</a></b> se trata de un portal de anuncios especialmente dedicado a la publicaci&oacute;n de anuncios realcionados con el mundo del kitesurf.
		  <br />
		  <ul>
		  	<li>
				En <b>Negotiable Kite</b> podr&aacute;s anunciar y poner a la venta cometas, tablas, arneses etc, pudiendo especificar detalles como la medida de la cometa, el tipo, si tiene reparaciones, si incluye la barra, etc.
			</li>
            <li>		  
				<a href="http://www.negotiablekite.com/afb">Buscador de anuncios de kite en facebook</a>. Buscador que incluye los principales grupos de facebook de venta de material de kitesurf de forma que todo queda resumido en un mismo lugar. Recomendado!
				</li>
			<li>		  
				Realiza b&uacute;squedas avanzadas del material en el que est&aacute;s interesado.
				</li>
				<li>
					Publica tus anuncios y enl&aacute;zalos con facebook para que lleguen mas gente.
				</li>
				<li>
					Utiliza nuestras herramientas para compartir tus anuncios en las redes sociales, via email, etc!!
				</li>
				<li>
					Administra tus anuncios edit&aacute;ndolos o elimin&aacute;ndolos .
				</li>
			</ul>
			
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
$mail->AltBody="Texto que debe decir lo mismo que el Body, pero sin etiquetas HTML";
$exito = $mail->Send();
if($exito){
     $mail->ClearAddresses();
     echo "Mensaje enviado exitosamente";
}  
	
	?>