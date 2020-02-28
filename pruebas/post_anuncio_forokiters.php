<?php
$login_url = 'http://www.forokiters.com/ucp.php';

//These are the post data username and password
$post_data = 'username=superchauen&password=000177&autologin=on&viewonline=on&redirect=ucp.php&sid=e34ddb9787b3b3dc6ac59e63b341a80b&login=Identificarse';
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

set_time_limit(0);

//for other pages we only have to indicate the adress and use the cookie
for($i=16050;$i<=18550;$i+=50){
$login_url = 'http://www.forokiters.com/memberlist.php?&start='.$i;
curl_setopt($ch, CURLOPT_URL, $login_url );
curl_setopt($ch, CURLOPT_COOKIEJAR, 'pruebas/cookie.txt');
curl_setopt($ch, CURLOPT_COOKIEFILE, 'pruebas/cookie.txt');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$postResult = curl_exec($ch);

$pagina .= $postResult;
}

echo $pagina;

curl_close($ch);
?>

<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script>
var direcc=""
	$(document).ready(function(){
	
			
			$(".gen a").each(function(i){
				if(valid($(this).attr("href"))){
					direccion = $(this).attr("href").replace("mailto:","");
					direcc=direcc+"    "+direccion;
				}
			});
			alert(direcc);
		});
		
		function valid(direccion) {
			
             if (direccion.indexOf("@") == -1) 
              return false;
			  else
			  return true;
			}
		
		
</script>