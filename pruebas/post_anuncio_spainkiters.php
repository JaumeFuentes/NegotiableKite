<?php
$login_url = 'http://www.spainkiters.com/phpBB2/login.php';

//These are the post data username and password
$post_data = 'username=superchauen&password=000177&autologin=on&viewonline=on&redirect=index.php&sid=e34ddb9787b3b3dc6ac59e63b341a80b&login=Login';
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
$postResult = curl_exec($ch);
// now we are loged in and the cookie has been created
//echo $postResult;  

//set_time_limit(0);

//for other pages we only have to indicate the adress and use the cookie



$posting_url = 'http://www.spainkiters.com/phpBB2/posting.php?mode=newtopic&f=1';
$mensaje ="prueba
prueba";
$post_data = 'subject=prueba&message='.$mensaje.'&attach_sig=on&notify=on&mode=newtopic&f=15&post=Enviar';
curl_setopt($ch, CURLOPT_URL, $posting_url );
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_COOKIEJAR, 'pruebas/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'pruebas/cookie.txt');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$postResult = curl_exec($ch);



//echo $postResult;

curl_close($ch);
?>

