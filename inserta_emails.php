<?php
 $DBHost="db370324546.db.1and1.com";
		 $DBUser="dbo370324546";
		 $DBPass="j8ef6sm80r";
		 $DBName="db370324546";
		
		 
		 //compruebo que el servidor responde
		 @mysql_connect($DBHost,$DBUser,$DBPass)
		 	or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");
			
		//intentamos seleccionar la base de datos negotiable
		if(!mysql_select_db($DBName))
			die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS NEGOTIABLE");
			
$matriz=file("prueba_contactos3.txt");

for($i=0;$i<count($matriz);$i++){
	$query="INSERT INTO lista_emails (email)
	VALUES ('".$matriz[$i]."')";					
	$result = mysql_query($query) or die(mysql_error()); 
	if($result)
		echo $i."  ".$matriz[$i];
}
?>