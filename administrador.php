<?php

if (isset($_GET['user'])) $user=$_GET['user'];
else $user=""; 

if (isset($_GET['pass'])) $pass=$_GET['pass'];
else $pass=""; 

if($user=="superchauen" and $pass=="000177"){
	include_once 'core/init.inc.php';
	$las_webs=new webs;
	//$las_webs->borra_anuncio_caducado();
	//$las_webs->elimina_usuario(1081);	
	//$las_webs->borra_anuncio(171,alonzo)
	$las_webs->email_renovacion();
	sleep(4);
	//mail('superchauen@hotmail.com','confirma cron admin','Esto tiene que llegar cada 5 horas');
}

else
	echo "que te den";
?>