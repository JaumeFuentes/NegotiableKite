<?php
define('FACEBOOK_APP_ID', '138100716293644');
define('FACEBOOK_SECRET', '5e784bac8bb0400ab274356d2bc5358e');

function parse_signed_request($signed_request, $secret) {
  list($encoded_sig, $payload) = explode('.', $signed_request, 2); 

  // decode the data
  $sig = base64_url_decode($encoded_sig);
  $data = json_decode(base64_url_decode($payload), true);

  if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
    error_log('Unknown algorithm. Expected HMAC-SHA256');
    return null;
  }

  // check sig
  $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
  if ($sig !== $expected_sig) {
    error_log('Bad Signed JSON signature!');
    return null;
  }

  return $data;
}

function base64_url_decode($input) {
    return base64_decode(strtr($input, '-_', '+/'));
}

if ($_REQUEST) {
  echo '<p>signed_request contents:</p>';
  $response = parse_signed_request($_REQUEST['signed_request'], 
                                   FACEBOOK_SECRET);
  echo '<pre>';
  //print_r($response);
  echo '</pre>';  
  echo $response['registration']['name']."<br />";
  echo $response['registration']['email']."<br />";
  echo $response['registration']['location']['name']."<br />";
  echo $response['registration']['password']."<br />";
} else {
  echo '$_REQUEST is empty';
}


?>
<html>
<head>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="/ajax/registro_ajax_fb.js"></script>

</head>

<body>
<div id="in"></div>
<!--
<fb:login-button perms='email'> Connect</fb:login-button> 
<div id='fb-root'></div>
      <script src='http://connect.facebook.net/en_US/all.js'></script>
      <script>
         FB.init({ 
            appId:'138100716293644', cookie:true, 
            status:true, xfbml:true 
         });
		 FB.Event.subscribe('auth.login', function(response) {    		
     	 });
      </script> 
-->

<iframe src="https://www.facebook.com/plugins/registration.php?
             client_id=138100716293644&
             redirect_uri=http://www.negotiablekite.com/registro_fb.php&
             fields=[
 				 {'name':'name'},
				 {'name':'nick',      'description':'Nick',             'type':'text'},
 				 {'name':'email'},
				 {'name':'location'},				 
				 {'name':'password'}]"
        scrolling="auto"
        frameborder="no"
        style="border:none"
        allowTransparency="true"
        width="100%"
        height="330">
</iframe>

</body>
</html>
