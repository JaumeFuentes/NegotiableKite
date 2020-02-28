
<?php
include "../facebook/php-sdk/src/facebook.php";

$facebook = new Facebook(array(
  'appId'  => '138100716293644',
  'secret' => '5e784bac8bb0400ab274356d2bc5358e',
));
$access_token = $facebook->getAccessToken();
echo $access_token;
?>
