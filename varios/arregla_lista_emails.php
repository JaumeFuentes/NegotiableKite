<?php
$DBHost="db370324546.db.1and1.com";
		 $DBUser="dbo370324546";
		 $DBPass="j8ef6sm80r";
		 $DBName="db370324546"; 	
		 
		/*$DBHost="localhost";
		$DBUser="root";
		$DBPass="";
		$DBName="db370324546";*/
		 
		 //compruebo que el servidor responde
		 @mysql_connect($DBHost,$DBUser,$DBPass)
		 	or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");
			
		//intentamos seleccionar la base de datos negotiable
		if(!mysql_select_db($DBName))
			die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS NEGOTIABLE");
			
$query = "SELECT email,id FROM lista_emails";
$resultado = mysql_query($query);
while($registro=mysql_fetch_row($resultado)){
	$email[] = array('email'=>$registro[0],'id'=>$registro[1]);
}

for($i=0;$i<count($email);$i++){
	$email2 = trim($email[$i]['email']);
	$id = $email[$i]['id'];
	$query = "UPDATE lista_emails SET email='$email2' WHERE id='$id'";
	mysql_query($query);
	//echo $id." ".$email2."<br />";
}


?>