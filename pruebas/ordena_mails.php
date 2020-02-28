<?php
$DBHost="localhost";
		 $DBUser="root";
		 $DBPass="";
		 $DBName="db370324546";
		 //compruebo que el servidor responde
		 @mysql_connect($DBHost,$DBUser,$DBPass)
		 	or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");
			
		//intentamos seleccionar la base de datos negotiable
		if(!mysql_select_db($DBName))
			die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS NEGOTIABLE");
/*
$archivo = file("emails_forokiters.txt");
$fichero=fopen("emails_ordenados.txt","w");

$i=0;
while($archivo[$i]!=NULL){
	$row = $archivo[$i];
	$sql = explode("    ",$row);
	$num = count($sql);
	$i++;
	for($j=0;$j<=$num;$j++){
		fputs($fichero,$sql[$j]);
		fputs($fichero,"\r\n");
		echo $sql[$j]."<br />";
	}
}*/

$query = "SELECT email FROM lista_emails";
$resultado = mysql_query($query);
while ($registro=mysql_fetch_row($resultado))
	$emails[]=array ("email"=>$registro[0]);
//echo $emails[1]['email'];
	
/*	
$archivo = file("emails_ordenados.txt");
$i=0;
$k=0;
while($archivo[$i]!=NULL){
	for($j=0;$j<=count($emails);$j++){
			if($archivo[$i]==$emails[$j]['email']){
				$existe = true;
				$j = count($emails)-1;
			}
	}
	if($existe!=true){
		$query = "INSERT INTO lista_emails (email) VALUES ('".$archivo[$i]."')";
		mysql_query($query) or die(mysql_error()); 
		echo $k." ".$archivo[$i]."<br />";
		$k++;
	}
				
	//echo $j." ".$archivo[$i]."<br />";
	$i++;
}
//echo $i;*/

$query = "SELECT email FROM users";
$resultado = mysql_query($query);
while ($registro=mysql_fetch_row($resultado))
	$emails_users[]=array ("email"=>$registro[0]);
	

$l=0;
for($i=0;$i<=count($emails);$i++){	
	for($j=0;$j<=count($emails_users);$j++){
		
		if(strpos($emails[$i]['email'],$emails_users[$j]['email'])===FALSE)
			$a=0;
		else{
			echo $emails[$i]['email']."<br />";
			$email=$emails[$i]['email'];
			$query="DELETE FROM lista_emails WHERE email like '%".trim($email)."%'";
			mysql_query($query);
			$l++;
		}
	}
	
}
echo $l;
?>