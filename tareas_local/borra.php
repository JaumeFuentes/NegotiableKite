<?php 
$DBHost="localhost";
		 $DBUser="root";
		 $DBPass="000177";
		 $DBName="db370324546";
		  //compruebo que el servidor responde
		 @mysql_connect($DBHost,$DBUser,$DBPass)
		 	or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");
			
		//intentamos seleccionar la base de datos negotiable
		if(!mysql_select_db($DBName))
			die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS NEGOTIABLE");
			
			$query="INSERT INTO lista_emails(email) VALUES('periquillo')";					
	$result = mysql_query($query) or die(mysql_error()); 

?>