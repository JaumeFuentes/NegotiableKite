<?php 
//Atencion! Cuando ejecute esta tarea en el CRON de 1and1 tengo que especificar que use php5
//en la web uso PHP5 porque asi lo tengo indicado en el panel de control pero en el corn usa PHP4.4.9
//así que debería de poner esto /usr/bin/php5 /kunden/homepages/9/d369922627/htdocs/pruebas/auto_fb_login.php

include "../facebook/php-sdk/src/facebook.php";
$DBHost="db370324546.db.1and1.com";
$DBUser="dbo370324546";
$DBPass="j8ef6sm80r";
$DBName="db370324546";



/*$DBHost="localhost";
$DBUser="root";
$DBPass="000177";
$DBName="db370324546";
*/

$web = "http://www.negotiablekite.com/";

//compruebo que el servidor responde
@mysql_connect($DBHost,$DBUser,$DBPass)
  or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");	
//intentamos seleccionar la base de datos negotiable
if(!mysql_select_db($DBName))
	die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS NEGOTIABLE");
	
$facebook = new Facebook(array(
  'appId'  => '138100716293644',
  'secret' => '5e784bac8bb0400ab274356d2bc5358e',
));

     

$query = "SELECT cod_anuncio,cod_articulo,titulo FROM anuncio WHERE anun_fb != '1' ";
$resultado = mysql_query($query);
while($registro = mysql_fetch_row($resultado))
	$datos_anuncio[]= array("cod_anuncio"=>$registro[0],"cod_articulo"=>$registro[1],"titulo"=>$registro[2],"direc_img"=>"");
	
for($i=0;$i<count($datos_anuncio);$i++){
	$cod_articulo = $datos_anuncio[$i]["cod_articulo"];
	$query = "SELECT direcc_imagen FROM imagenes WHERE cod_articulo = '$cod_articulo' AND imagen_principal ='1'";
	$resultado = mysql_query($query);
	$registro = mysql_fetch_assoc ($resultado);
	if(mysql_num_rows($resultado) >0)
		$datos_anuncio[$i]["direc_img"] = $registro['direcc_imagen'];
	else
		$datos_anuncio[$i]["direc_img"] = "imagenes/icono-camara.jpeg";
}
		
set_time_limit(0);	
for($i=0;$i<count($datos_anuncio);$i++){
	$cod_anuncio = $datos_anuncio[$i]["cod_anuncio"];
	//echo $datos_anuncio[$i]["cod_anuncio"];echo "<br />";
	//echo $web."anuncio/".$datos_anuncio[$i]["cod_articulo"];echo "<br />";
	//echo $datos_anuncio[$i]["titulo"];echo "<br />";
	//echo $web.$datos_anuncio[$i]["direc_img"];echo "<br /><br />";


	 $facebook_post_array = array(
	 	
		"message" => $datos_anuncio[$i]["titulo"],
		"description" => $datos_anuncio[$i]["titulo"],
		"link" => $web."anuncio/".$datos_anuncio[$i]["cod_anuncio"],
		"picture" => $web.$datos_anuncio[$i]["direc_img"]
		
	);
	$facebook->api("369144093150754/feed", "POST", $facebook_post_array);	
	sleep(3);
	$facebook->api("100002477755331/feed", "POST", $facebook_post_array);	
	$query = "UPDATE anuncio SET anun_fb = '1' WHERE cod_anuncio = '$cod_anuncio'";
	mysql_query($query);
	sleep(3);
}












 /*$app_id = "138100716293644";
    $app_secret = "5e784bac8bb0400ab274356d2bc5358e";
    $app_token_url = "https://graph.facebook.com/oauth/access_token?"
        . "client_id=" . $app_id
        . "&client_secret=" . $app_secret 
        . "&grant_type=client_credentials";

        $acces_token = file_get_contents($app_token_url);
     echo $acces_token;*/
?>
