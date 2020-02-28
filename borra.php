<?php
/*
include_once 'core/init.inc.php';
$query = "SELECT nick,password,fecha_alta,email  FROM users WHERE estado='0'";
$data = mysql_query($query);
while($result = mysql_fetch_row($data)){
	$usuarios[] = array("nick"=>$result[0],"password"=>$result[1],"fecha_alta"=>$result[2],"email"=>$result[3]);
}

require_once ('video/include/DB_Data.php');
require_once ('video/include/functions.php');	
foreach($usuarios as $usuario){
	
	$reg_date = strtotime($usuario['fecha_alta']);
	$last_signin = $reg_date;	
	$conn_id = db_connect();
	mysql_select_db($db_name);
	$query = "INSERT INTO pm_users (username,name,password,reg_date,last_signin,email) 
		      VALUES ('".$usuario['nick']."','".$usuario['nick']."',
			  '".$usuario['password']."','".$reg_date."','".$last_signin."','".$usuario['email']."')";
	echo $usuario['nick'];
	mysql_query($query) or die(mysql_error()); 
}*/
echo $_SERVER['DOCUMENT_ROOT'];

?>