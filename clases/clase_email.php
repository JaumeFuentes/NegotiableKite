<?php


class clase_emails extends PHPMailer{ 
	public $num_emails;
	public $datos_obt;
	//constructor que intenta conectarse a la base de datos NEGOTIABLE
	function clase_emails(){
		 	
		if($_SESSION['servidor']=='192.168.1.159'){
			$DBHost="localhost";
			$DBUser="root";
			$DBPass="000177";
			$DBName="db370324546";
		  }
		  else{
			$DBHost="localhost";
			$DBUser="root";
			$DBPass="";
			$DBName="db370324546";
		  }
		 //compruebo que el servidor responde
		 @mysql_connect($DBHost,$DBUser,$DBPass)
		 	or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");
			
		//intentamos seleccionar la base de datos negotiable
		if(!mysql_select_db($DBName))
			die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS NEGOTIABLE");
	}
		
		function obten_datos($grupo){
			
			if($grupo==1) $query="SELECT email,nick FROM users WHERE mail_enviado!=1 AND nick!='NULL' AND enviar_mail=1 AND estado=0";
			if($grupo==2) $query="SELECT email,nick,cod_usuario,activate FROM users WHERE mail_enviado!=1 AND nick!='NULL' AND enviar_mail=1 AND estado=1";
			if($grupo==3) $query="SELECT email FROM users WHERE mail_enviado!=1 AND nick='NULL' AND enviar_mail=1";
			if($grupo==4) $query="SELECT email FROM lista_emails WHERE mail_enviado!=1 AND enviar_mail=1";
			
			$resultado=mysql_query($query);	
			$this->num_emails = mysql_num_rows($resultado);
			while($registro=mysql_fetch_row($resultado))				
				$datos[]=array ("email_destino"=>$registro[0],"usuario"=>$registro[1],"cod_usuario"=>$registro[2],"activate"=>$registro[3]);
			$this->datos_obt = $datos;
			
			
		}
		
		function mod_mensaje($mensaje,$usuario,$email_destino,$cod_usuario,$activate){
			$mensaje = str_replace("*usuario*",$usuario, $mensaje);
			$mensaje = str_replace("*mail*",$email_destino, $mensaje);
			$mensaje = str_replace("*cod_usuario*",$cod_usuario, $mensaje);
			$mensaje = str_replace("*activatekey*",$activate, $mensaje);
			$mensaje = utf8_decode($mensaje);
			return $mensaje;
		}
		
		function emails_restantes($grupo){
			if($grupo==1) $query="SELECT email,nick FROM users WHERE mail_enviado!=1 AND nick!='NULL' AND enviar_mail=1 AND estado=0";
			if($grupo==2) $query="SELECT email,nick FROM users WHERE mail_enviado!=1 AND nick!='NULL' AND enviar_mail=1 AND estado=1";
			if($grupo==3) $query="SELECT email FROM users WHERE mail_enviado!=1 AND nick='NULL' AND enviar_mail=1";
			if($grupo==4) $query="SELECT email FROM lista_emails WHERE mail_enviado!=1 AND enviar_mail=1";
			$resultado=mysql_query($query);
			return mysql_num_rows($resultado);
		}
			
		
		function desactiva_email($mail){
			$query1="UPDATE users SET enviar_mail='0' WHERE email='$mail'";
			$query2="UPDATE lista_emails SET enviar_mail='0' WHERE email='$mail'";
			mysql_query($query1);
			mysql_query($query2);
		}
		
		function mail_enviado($email_destino){
			$query1="UPDATE users SET mail_enviado='1' WHERE email like '%$email_destino%'";
			$query2="UPDATE lista_emails SET mail_enviado='1' WHERE email like '%$email_destino%'";
			mysql_query($query1);
			mysql_query($query2);
		}
		
		//esta funcion solo es para el grupo 4
		function reset_mail_enviado(){
			$query="SELECT * FROM lista_emails WHERE mail_enviado='0' AND enviar_mail='1'";
			$resultado=mysql_query($query);
			$num_filas = mysql_num_rows($resultado);
			if($num_filas==0){
				$query="UPDATE lista_emails SET mail_enviado='0' WHERE enviar_mail='1'";
				mysql_query($query);
			}
		}
		
		function clean($str) { 
			$str = @trim($str); 
			if(get_magic_quotes_gpc())
			{ 
				$str = stripslashes($str); 
			} 
			return mysql_real_escape_string($str); 
		} 	
		
		function getProperty($property){
			return $this->$property;
		}
}