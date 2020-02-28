<?php
include_once '../core/init.inc.php';
$las_webs=new webs;

if(!isset($_SESSION['SESS_MEMBER_ID'])) header('location:../login.php');
	$votador=$las_webs->codigo_usuario($_SESSION['SESS_MEMBER_ID']);


if(!isset($_REQUEST['puntos_vendedor'])) $puntos_vendedor="";
else $puntos_vendedor=$_REQUEST['puntos_vendedor'];
if(!isset($_REQUEST['comentario_vendedor'])) $comentario_vendedor="";
else $comentario_vendedor=$_REQUEST['comentario_vendedor'];

if(!isset($_REQUEST['puntos_comprador'])) $puntos_comprador="";
else $puntos_comprador=$_REQUEST['puntos_comprador'];
if(!isset($_REQUEST['comentario_comprador'])) $comentario_comprador="";
else $comentario_comprador=$_REQUEST['comentario_comprador'];

if(!isset($_REQUEST['votado'])) $votado="";
else $votado=$_REQUEST['votado'];
//if(!isset($_REQUEST['votador'])) $votador="";
//else $votador=$_REQUEST['votador'];
if(!isset($_REQUEST['nick_votado'])) $nick_votado="";
else $nick_votado=$_REQUEST['nick_votado'];

if($puntos_vendedor!="" )
	$votacion_vendedor_ok=$las_webs->votar_vendedor($votado,$votador,$puntos_vendedor,$comentario_vendedor);
	
if($puntos_comprador!="" )
	$votacion_comprador_ok=$las_webs->votar_comprador($votado,$votador,$puntos_comprador,$comentario_comprador);

if($votacion_vendedor_ok==true ){
	echo "
	
		<div class=fieldseto>
			<div class=leyenda>Puntuar a ".$nick_votado." como vendedor</div>
			<div class='puntos'>";						
			echo "Votaci&oacute;n realizada correctamente
			</div>	
		</div>
	";
}
else{
	if($puntos_vendedor!=""){
		echo "
		
			<div class=fieldseto>
				<div class=leyenda>Puntuar a ".$nick_votado." como vendedor</div>
				<div class='puntos'>";						
				echo "Ya vot&oacute; a ".$nick_votado." hace menos de cuatro d&iacute;as.
				</div>	
			</div>
		";
	}
}

if($votacion_comprador_ok==true ){
	echo "
	
		<div class=fieldseto>
			<div class=leyenda>Puntuar a ".$nick_votado." como comprador</div>
			<div class='puntos'>";						
			echo "Votaci&oacute;n realizada correctamente
			</div>	
		</div>
	";
}
else{
	if($puntos_comprador!=""){
		echo "
		
			<div class=fieldseto>
				<div class=leyenda>Puntuar a ".$nick_votado." como comprador</div>
				<div class='puntos'>";						
				echo "Ya vot&oacute; a ".$nick_votado." hace menos de cuatro d&iacute;as.
				</div>	
			</div>
		";
	}
}


?>