<?php 
$DBHost="db370324546.db.1and1.com";
$DBUser="dbo370324546";
$DBPass="j8ef6sm80r";
$DBName="db370324546";



$DBHost="localhost";
$DBUser="root";
$DBPass="000177";
$DBName="db370324546";



$web = "http://www.negotiablekite.com/";

//compruebo que el servidor responde
@mysql_connect($DBHost,$DBUser,$DBPass)
  or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");	
//intentamos seleccionar la base de datos negotiable
if(!mysql_select_db($DBName))
	die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS NEGOTIABLE");
	
$login_url = 'http://novatos-kite.com/foro/ucp.php?mode=login&sid=a9013ae884fe5b34973ac5e8c32540f9';
$posting_url = 'http://www.forokiters.com/posting.php?mode=post&f=29';
//These are the post data username and password
$post_data = 'username=superchauen&password=000177&autologin=on&viewonline=on&redirect=index.php&sid=a9013ae884fe5b34973ac5e8c32540f9&login=Identificarse';
//$post_data = 'username=superchauen&password=000177';
//Create a curl object
$ch = curl_init();

//Set the useragent
$agent = $_SERVER["HTTP_USER_AGENT"];
curl_setopt($ch, CURLOPT_USERAGENT, $agent);

//Set the URL
curl_setopt($ch, CURLOPT_URL, $login_url );

//This is a POST query
curl_setopt($ch, CURLOPT_POST, 1 );

//Set the post data
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);


curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);



//We want the content after the query
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

//Follow Location redirects
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

/*
Set the cookie storing files
Cookie files are necessary since we are logging and session data needs to be saved
*/

curl_setopt($ch, CURLOPT_COOKIEJAR, 'pruebas/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'pruebas/cookie.txt');

//Execute the action to login
echo $postResult = curl_exec($ch);

///////////////////////////////////////////////////////////////////////////////////////////////////////
     
/*
$query = "SELECT cod_anuncio,cod_articulo,titulo,descripcion FROM anuncio WHERE anun_sk != '1' ";
$resultado = mysql_query($query);
while($registro = mysql_fetch_row($resultado))
	$datos_anuncio[]= array("cod_anuncio"=>$registro[0],"cod_articulo"=>$registro[1],"titulo"=>$registro[2],"descripcion"=>$registro[3],"direc_img"=>"");
	
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
	$imagen = $web.$datos_anuncio[$i]["direc_img"];
	$asunto = $datos_anuncio[$i]["titulo"];
	$link = $web."anuncio/".$datos_anuncio[$i]["cod_anuncio"];
	$mensaje = "[b][url=".$link."]".$asunto."[/url][/b]
	
	 ".$datos_anuncio[$i]["descripcion"]."
	 
	 [b]Para contactar con el anunciante visita: [url]".$link."[/url][/b]
	 
	 [img]".$imagen."[/img]";
	 

	  $post_data = 'subject='.$asunto.'&message='.$mensaje.'&attach_sig=on&notify=on&mode=newtopic&f=29&post=Enviar';
	  curl_setopt($ch, CURLOPT_URL, $posting_url );
	  curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	  curl_setopt($ch, CURLOPT_COOKIEJAR, 'pruebas/cookie.txt');
	  curl_setopt($ch, CURLOPT_COOKIEFILE, 'pruebas/cookie.txt');
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	  $postResult = curl_exec($ch);	  
	 
	 
	sleep(1);
	
	$query = "UPDATE anuncio SET anun_sk = '1' WHERE cod_anuncio = '$cod_anuncio'";
	mysql_query($query);
	sleep(15);
}*/

/*
$mi_url=$posting_url;
$fo= fopen("$mi_url","r") or die ("No se ha encontrado la pagina2.");
while (!feof($fo)) {
$mi_cadena .= fgets($fo, 4096);
}
fclose ($fo);
echo $mi_cadena;


*/
curl_close($ch);
?>
