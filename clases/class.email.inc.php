<?php
class Email extends DB_Connect{
	private $headers;
	
	function __construct(){
		parent::__construct();
		
		$email_origen = "no_reply@negotiablekite.com";
		$nombre_origen = $_SESSION['SESS_MEMBER_ID']." [Negotiable Kite]";
		
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
		$this->headers = $headers;
		
	}
	
		
	function email_perfil($email_vendedor,$motivo_contacto,$mail_contacto,$mensaje_contacto){
		
		$asunto="El usuario ".$_SESSION['SESS_MEMBER_ID']." tiene una pregunta";
		$mensaje="<table width='629' border='0' cellspacing='1' cellpadding='2'> 
		<tr> 
			<td width='623' align='left'></td> 
		</tr> 
		<tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>El usuario ".$_SESSION['SESS_MEMBER_ID']." quiere contactar contigo</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='35' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:18px; margin-bottom:3px; font-weight:bold;'>
				<a href='mailto:".$mail_contacto."'>".$mail_contacto."</a>  / Visita su perfil en NK: 
					<a href='http://www.negotiablekite.com/perfil/".$_SESSION['SESS_MEMBER_ID']."'>
						".$_SESSION['SESS_MEMBER_ID']."
					</a>
				</div> 
			</td> 
		 </tr> 
		<tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Motivo de contacto</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='30' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				".$motivo_contacto." 
				</div> 
			</td> 
		 </tr> 
		 <tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Mensaje</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				".$mensaje_contacto." 
				</div> 
			</td> 
		 </tr> 
		 
		 <tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				<br/>Un saludo de parte del equipo de <a href='http://www.negotiablekite.com'>Negotiable Kite</a>, y buen viento! 
				</div> 
			</td> 
		 </tr> 
		</table>"; 
		
		$exito = mail($email_vendedor, $asunto, $mensaje, $this->headers);
		mail("superchauen@hotmail.com", $asunto, $mensaje, $this->headers);
		return $exito;
	}
}
?>