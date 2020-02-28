<?php

if (isset($_GET['user'])) $user=$_GET['user'];
else $user=""; 

if (isset($_GET['pass'])) $pass=$_GET['pass'];
else $pass=""; 

if($user=="superchauen" and $pass=="000177"){
	include_once 'core/init.inc.php';
	$las_webs=new webs;
	
	if(isset($_REQUEST["user_el"])){
		$cod_usuario=$_REQUEST["user_el"];
		$las_webs->elimina_usuario($cod_usuario);
	}
	
	
	$query = "SELECT cod_usuario, nick FROM users";
	$result = mysql_query($query);
	
	while($row = mysql_fetch_row($result))
		$matriz_resultado[] = array('cod_usuario'=>$row[0], 'nick'=>$row[1]);
		
	foreach($matriz_resultado as $key => $value){
		$usuario_a_eliminar="\"administrador2.php?user_el=".$matriz_resultado[$key]['cod_usuario']."
		&user=".$user."&pass=".$pass."\"";
		
		echo "codigo = ".$matriz_resultado[$key]['cod_usuario']." 
		Usuario = ".$matriz_resultado[$key]['nick']."
		<a id='eliminar' href='JavaScript:confirma(".$usuario_a_eliminar.")'>Eliminar</a><br />";
	}
		
		
}

else
	echo "que te den";
	

?>

<script language="JavaScript">
function confirma (url) {
	
	if (confirm("¿Estas seguro de que quires eliminar al usuario?")) location.replace(url);
}
</script>