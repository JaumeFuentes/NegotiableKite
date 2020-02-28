<?php
/*It is important for the channel file (//connect.facebook.net/en_US/all.js) to be cached for as long as possible. When serving this file, you must send valid Expires headers with a long expiration period. we can do that with this code */
 $cache_expire = 60*60*24*365;
 header("Pragma: public");
 header("Cache-Control: max-age=".$cache_expire);
 header('Expires: ' . gmdate('D, d M Y H:i:s', time()+$cache_expire) . ' GMT');
 ?>
 
<?php

define('YOUR_APP_ID', '138100716293644');
define('YOUR_APP_SECRET', '5e784bac8bb0400ab274356d2bc5358e');

function get_facebook_cookie($app_id, $app_secret) {
  $args = array();
  parse_str(trim($_COOKIE['fbs_' . $app_id], '\\"'), $args);
  ksort($args);
  $payload = '';
  foreach ($args as $key => $value) {
    if ($key != 'sig') {
      $payload .= $key . '=' . $value;
    }
  }
  if (md5($payload . $app_secret) != $args['sig']) {
    return null;
  }
  return $args;
}

$cookie = get_facebook_cookie(YOUR_APP_ID, YOUR_APP_SECRET);
if($cookie)
$user = json_decode(file_get_contents(
    'https://graph.facebook.com/me?access_token=' .
    $cookie['access_token']));

?>
<!--you must add an XML namespace attribute to the root <html> element of your page. Without this declaration, XFBML tags will not render in Internet Explorer: xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#" -->
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
  <body>
    <?php if ($cookie) { ?>
      Welcome <?= $user->name ?>
    <?php } else { ?>
      <fb:login-button perms="email"></fb:login-button>
    <?php } print_r($user);?>
    <div id="fb-root"></div>
    
    <!-- *************************************************************-->
    <!-- The following code will load and initialize the JavaScript SDK with all common options 
    The best place to put this code is right after the opening <body> tag -->
    <!-- Visit http://developers.facebook.com/docs/reference/javascript/ for more info -->
    
    <script>
      window.fbAsyncInit = function() {
        FB.init({//visit http://developers.facebook.com/docs/reference/javascript/FB.init/ for mor info
          appId      : '138100716293644',
		  //channelURL : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File (optional)
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true // parse XFBML
        });

		 // Additional initialization code here
        FB.Event.subscribe('auth.login', function(response) {
          window.location.reload();
        });
      };
		// Load the SDK Asynchronously
      (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
		 //tener en cuenta aqui poner en_US para ingles o es_LA para español
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
       }(document));
    </script>
    
    <!-- *******************************************************-->
    
  </body>
</html>