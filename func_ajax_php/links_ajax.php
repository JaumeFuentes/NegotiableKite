<?php
include_once '../core/init.inc.php';
$link = new Links;
!isset($_REQUEST['id'])? $id="" : $id=$_REQUEST['id'];

if($id){
	$clicks = $link->addClick($id);
	echo $clicks;
}
?>


