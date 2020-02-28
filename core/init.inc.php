<?php
session_start();
$_SESSION['base_href']='http://'.$_SERVER['SERVER_NAME'].'/';
$_SESSION['servidor']=$_SERVER['SERVER_NAME'];

$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/time_functions.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/clases/class.db_connect.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/clase_webs.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/clases/class.link_.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/clases/class.links.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/clases/class.tienda_.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/clases/class.tiendas.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/clases/class.perfil.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/clases/class.perfil.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/clases/class.anuncios.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/clases/class.blog.inc.php';
$link = new Links;

//compruebo IP baneadas.

if($_SESSION['ip'] == '5.134.113.210' or $_SESSION['ip'] == '84.33.17.132')
	header('location: http://images.galleries.pornpros.com/galleries.boysdestroyed.com/htdocs/pb01/pb01_scottiebrooks/full/13.jpg');


?>