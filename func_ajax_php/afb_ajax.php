<?php

require '../facebook/php-sdk/src/facebook.php';
$facebook = new Facebook(array(
  'appId'  => '138100716293644',
  'secret' => '5e784bac8bb0400ab274356d2bc5358e',
));
$access_token = $facebook->getAccessToken();

for($i=0;$i<count($_SESSION['id_grupos']);$i++){
	if($_SESSION['feed'][$i]==""){	
		$_SESSION['feed'][$i]=$facebook->api($_SESSION['id_grupos'][$i].'/feed','GET',array('acces_token' => $acces_token,'limit' => 200));		
	}
}
$_SESSION['cargado'] = true;
echo '<span style="font-size:12px; font-weight:bold; line-heidht:47px;">GRUPOS CARGADOS!</span>';
?>