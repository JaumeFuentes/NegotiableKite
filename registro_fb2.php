<?php
	
session_start();

require 'facebook/php-sdk/src/facebook.php';

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
	
	$email=$user_profile['email'];
	$first=$user_profile['first_name'];
	echo $user."<br />";
	echo $email."<br />";
	echo $first."<br />";
	
	
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
  echo "logout: ".$logoutUrl."<br />";
  echo "<a href='".$logoutUrl."'>Logout</a>";
  
} else {
  $loginUrl = $facebook->getLoginUrl(array('req_perms' => 'email'));
  echo "login: ".$loginUrl."<br />";
  echo "<a href='".$loginUrl."'>Login</a>";
}


?>




</head>

<body>



</body>
</html>
