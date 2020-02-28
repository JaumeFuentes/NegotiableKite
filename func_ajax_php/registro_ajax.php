<?php
//este script es para comprobar que no se introduce un nick o email que ya existen
include_once '../core/init.inc.php';
$las_webs=new webs;

if(!isset($_REQUEST['email'])) $email="";
else $email=$_REQUEST['email'];
if(!isset($_REQUEST['nick'])) $nick="";
else $nick=$_REQUEST['nick'];

if($email!="")
	$email_existe=$las_webs->email_existe($email);
	
if($nick!="")
	$nick_existe=$las_webs->nick_existe($nick);

if(isset($_REQUEST['email'])){	
	if($email_existe)
		echo "<span style='color:red'>El email ya existe</span>
			  <input type='hidden' id='email_existe' name='email_existe' value='true' /> ";
	else
		echo "Direcci&oacute;n de correo electr&oacute;nico";
}

if(isset($_REQUEST['nick'])){	
	if($nick_existe)
		echo "<span style='color:red'>El nick ya existe</span>
			  <input type='hidden' id='nick_existe' name='nick_existe' value='true' /> ";
	else
		echo "Elige tu nick (m&iacute;nimo 4 car&aacute;cteres)";
}
?>