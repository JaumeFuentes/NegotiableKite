<?php
//Este script se encarga de:
//- Eliminar registros en lista_emails de los emails que se hayan registrado o esten en la tabla users del servidor REMOTO
//- Eliminar los registros anteriores en el servidor LOCAL
//- Actualizar campo enviar_mail en servidor LOCAL

set_time_limit(0);
//primero en servidor remoto elimino los registros en los que los emails se hayan registrado
$DBHost="db370324546.db.1and1.com";
$DBUser="dbo370324546";
$DBPass="j8ef6sm80r";
$DBName="db370324546";


@mysql_connect($DBHost,$DBUser,$DBPass)
	or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");
if(!mysql_select_db($DBName))
	die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS");

//me guardo en la variable $email todos los emails que se han registrado	
$query = "SELECT email FROM lista_emails WHERE email = ANY (SELECT email FROM users)";
$resultado = mysql_query($query);
while($registro=mysql_fetch_assoc($resultado))
	$email[] = array('email'=>$registro['email']);
	
//borro de la tabla lista_emails del servidor remoto todos los registros en los que se han registrado
$query = "DELETE FROM lista_emails WHERE email = ANY (SELECT email FROM users)";
mysql_query($query);

//Selecciono todos los emails en los que enviar_mail=0 y los guardo en la variable $email2
$query = "SELECT email FROM lista_emails WHERE enviar_mail='0'";
$resultado = mysql_query($query);
while($registro=mysql_fetch_assoc($resultado))
	$email2[] = array('email'=>$registro['email']);

	
//Conecto con la base de datos del servidor local
$DBHost="superchauen.sytes.net:3306";
$DBUser="root";
$DBPass="000177";
$DBName="db370324546";

@mysql_connect($DBHost,$DBUser,$DBPass)
	or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");
if(!mysql_select_db($DBName))
	die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS");


//borro de la tabla lista_emails del servidor local todos los registros en los que se han registrado
for($i=0;$i<count($email);$i++){
	$email_a_borrar = $email[$i]['email'];
	$query = "DELETE FROM lista_emails WHERE email = '$email_a_borrar'";
	mysql_query($query);	
}

//Actualizo el campo enviar_mail en el servidor local
for($i=0;$i<count($email2);$i++){
	$email_a_cambiar = $email2[$i]['email'];
	$query = "UPDATE lista_emails SET enviar_mail='0' WHERE email = '$email_a_cambiar'";
	mysql_query($query);	
}

?>