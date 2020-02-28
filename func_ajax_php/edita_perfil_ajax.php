<?php
include_once '../core/init.inc.php';
$perfil = new perfil($_SESSION['SESS_MEMBER_ID']);

$datos = array ("descripcion","marcas","direccion","localidad","provincia","telefono","web","facebook","twitter");
$datoReq = array();

foreach ($datos as $dato){
	//if($dato == "descripcion") $_REQUEST[$dato] = str_replace('\n', '<br />', $_REQUEST[$dato]);	
	isset($_REQUEST[$dato]) ? $datoReq[$dato] =  $_REQUEST[$dato] : $datoReq[$dato] = "";	
	if ($datoReq[$dato] == "http://")  $datoReq[$dato] = "";
	//echo $dato.": ".$datoReq[$dato]."<br />";
}

$updated = $perfil->updateUserData($datoReq,$_SESSION['SESS_MEMBER_ID']);
if($updated)
	echo '<span id="respuesta">Datos actualizados</span>';
else
	echo '<span id="respuesta_error">Error actualizacion</span>';

	 

?>