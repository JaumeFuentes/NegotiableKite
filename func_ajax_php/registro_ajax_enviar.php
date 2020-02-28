<?php
//este script es para comprobar que todos los datos son correctos y si es asi introducir los datos en el servidor
include_once '../core/init.inc.php';
$las_webs=new webs;

if(!isset($_REQUEST['ubicacion'])) $ubicacion="";
else $ubicacion=$_REQUEST['ubicacion'];
if(!isset($_REQUEST['email'])) $email="";
else $email=$_REQUEST['email'];
if(!isset($_REQUEST['nick'])) $nick="";
else $nick=$_REQUEST['nick'];
if(!isset($_REQUEST['password'])) $password="";
else $password=$_REQUEST['password'];
if(!isset($_REQUEST['condiciones'])) $condiciones="";
else $condiciones=$_REQUEST['condiciones'];
if(!isset($_REQUEST['nombre_tienda'])) $nombre_tienda="";
else $nombre_tienda=$_REQUEST['nombre_tienda'];

if(!isset($_REQUEST['aleatorio'])) $aleatorio="";
else $aleatorio=$_REQUEST['aleatorio'];

if($_SESSION['mensaje_registro_fb']==true)
	$email=$_SESSION['SESS_MEMBER_EMAIL_FACEBOOK'];

if($aleatorio==""){
	$envio_ok=$las_webs->insert_user_data($ubicacion,$email,$nick,$password,$condiciones,$nombre_tienda);
		if($envio_ok){
		echo "
			<div class='registro'>
				Registro de usuario 
			</div>
			<div id='cont_reg'>
				<div id='texto_icono'>
				";
				if($_SESSION['mensaje_registro_fb']==false)
					echo "<div id='texto'>Informaci&oacute;n enviada correctamente</div>";
				else
					echo "<div id='texto'>Informaci&oacute;n enviada correctamente</div>";
				echo "
					<div id='icono'></div>
				</div>
				<div id='icono_inicio'><a href='index.php' title='ir a la p&aacute;gina de inicio'></a></div>
				";
			if($_SESSION['mensaje_registro_fb']==false){
				echo "
					<div id='texto_registro'>
						<span class='texto_registro2'>
							En beve recibir&aacute;s un email con un link de activaci&oacute;n para completar el registro.
						</span><br />
						<span class='texto_registro2'>
							Si no recibes ning&uacute;n email en unos minutos revisa tu carpeta de spam
							</span>
					</div>
					<div style='clear:both'></div>
				</div>";
			}
	}
	else 
		echo "ERROOOOOOOOOOOOOOOOOR PRIMO!! AAAY EL PAYO QUE SE QUIERE DE REGISTR&aacute; ASIN POR LAS MALAS"; 
}
else{
	$envio_ok_2=$las_webs->insert_user_data_mail($ubicacion,$nick,$password,$condiciones,$aleatorio,$nombre_tienda);
	if($envio_ok_2){
		echo "
			<div class='registro'>
				Registro de usuario 
			</div>
			<div id='cont_reg'>
				<div id='texto_icono'>
					<div id='texto'>Registro completado con &eacute;xito!</div>
					<div id='icono'></div>
				</div>
				<div id='icono_inicio'><a href='index.php' title='ir a la p&aacute;gina de inicio'></a></div>
				
				<div style='clear:both'></div>
			</div>";
	}
	else 
		echo "ERROOOOOOOOOOOOOOOOOR PRIMO!! AAAY EL PAYO QUE SE QUIERE DE REGISTR&aacute; ASIN POR LAS MALAS"; 
}


?>