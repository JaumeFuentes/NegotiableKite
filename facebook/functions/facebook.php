<?php
//session_start();
if(!isset($_REQUEST['de_anuncio'])){
	 $de_anuncio=false;
	 include "facebook/php-sdk/src/facebook.php";
}
else {
	$de_anuncio=true;
	include "../php-sdk/src/facebook.php";
}

$facebook = new Facebook(array(
  'appId'  => '138100716293644',
  'secret' => '5e784bac8bb0400ab274356d2bc5358e',
));

// See if there is a user from a cookie
$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
	$_SESSION['user_fb']=$user;
	$user_profile = $facebook->api('/me');
	$_SESSION['SESS_MEMBER_EMAIL_FACEBOOK']=$user_profile['email'];
	$_SESSION['SESS_MEMBER_NAME_FACEBOOK']=$user_profile['name'];
	$_SESSION['SESS_MEMBER_ID_FACEBOOK']=$user_profile['id'];
	    	
	$friends = $facebook->api('/me/friends');
	$groups = $facebook->api('/me/groups');
	$_SESSION['friends']=$friends;
	$_SESSION['groups']=$groups;
  } catch (FacebookApiException $e) {
    //echo '<pre>'.htmlspecialchars(print_r($e, true)).'</pre>';
    $user = null;
	$_SESSION['user_fb'] = null;
  }
}

if($de_anuncio==true){
echo '<div id="pre_box">
	  	<input id="box" class="box" type="checkbox" name="publ_fb" value="acepta"/>
		<span id="prev">Vista previa</span>
	  </div>';
echo '<select id="grupo_fb" name="grupo_fb">
	  	<option value='.$_SESSION['SESS_MEMBER_ID_FACEBOOK'].'>En tu muro</option>';
		if(count($_SESSION['groups']['data']>0)){
			for($i=0;$i<=count($_SESSION['groups']['data']);$i++)
				echo '<option value='.$_SESSION['groups']['data'][$i]['id'].'>'.$_SESSION['groups']['data'][$i]['name'].'</option>';
		}
echo '</select>';		
echo '<input style="display:none" id="name_fb" type="text" value='.$_SESSION['SESS_MEMBER_NAME_FACEBOOK'].' />';
echo '<input style="display:none" id="id_fb" type="text" value='.$_SESSION['SESS_MEMBER_ID_FACEBOOK'].' />';
}
?>