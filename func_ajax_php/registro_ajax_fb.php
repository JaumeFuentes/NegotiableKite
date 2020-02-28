<script>
	window.onload=ejecutaFuncion;
	
	function ejecutaFuncion(){
		
<?php
	
session_start();

require '../facebook/php-sdk/src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => '138100716293644',
  'secret' => '5e784bac8bb0400ab274356d2bc5358e',
));

// Get User ID
$user= $facebook->getUser();



if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
		
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }   
}

$loginUrl = $facebook->getLoginUrl(array('req_perms' => 'email'));

?>
<div id="info" name=