<?php
include_once '../core/init.inc.php';
isset($_REQUEST['puntos']) ? $puntos = $_REQUEST['puntos'] : $puntos = "";
isset($_REQUEST['tit_coment']) ? $tit_coment = $_REQUEST['tit_coment'] : $tit_coment = "";
isset($_REQUEST['comentario']) ? $comentario = $_REQUEST['comentario'] : $comentario = "";
isset($_REQUEST['nick_votado']) ? $nick_votado = $_REQUEST['nick_votado'] : $nick_votado = "";

$urlStar = "layout/estrellas/stars".$puntos.".gif";
$fecha = date("d/m/Y");
?>

<?php 
$perfil = new perfil($_SESSION['SESS_MEMBER_ID']);
$fecha_voto = time();
$nick_votador = $_SESSION['SESS_MEMBER_ID'];
$insert = $perfil->InsertComment($nick_votado,$nick_votador,$fecha_voto,$puntos,$comentario,$tit_coment);
?>

<?php
if($insert)
	$mensaje ='
	 <div class="comentarios">
		<div class="commentTiendaBox hreview">
		   <div class="commentTiendaLeft">
			  <img alt=""  src="layout/comillas.gif">
		   </div>
		   <div>
			  <p class="bold">'.$tit_coment.'
				  <img alt="'.$puntos.'" title="'.$puntos.'" src="'.$urlStar.'" class="rating">
			  </p>
			  <p class="description  text">
				  '.$comentario.'
			  </p>
			  <p class="reviewer dequien">'.$_SESSION['SESS_MEMBER_ID'].'</p><span class="dtreviewed dequien">'.$fecha.'</span>
		   </div>
		</div>
	 </div>';
else
	$mensaje = '<br /><span style="color:red">LO SENTIMOS, PARECE QUE HA HABIDO UN ERROR.</span>';
 
echo utf8_encode($mensaje);
?>

