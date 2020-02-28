<?php

require 'facebook/php-sdk/src/facebook.php';
include "facebook/functions/facebook.php";

if(!$user_profile)
	echo "que no hay user coñooooo";
	
$facebook_post_array = array(
    "message" => "Vendo cometa en perfecto estado:prueba!",
    "description" => "Esta sería la descripción del anuncio explicando todo",
    "link" => "http://www.negotiablekite.com/anuncio.php?codan=373",
    "picture" => "http://www.negotiablekite.com/imagenes/360imagen2back_IMG00168-20111113-1131.jpg",
);


if($user)
  $facebook->api("/me/feed", "POST", $facebook_post_array);
?>

<script type="text/javascript">
	function enviar_formulario(){   
    FB.logout(function(response) { window.location.reload();});}
</script> 

<script>
window.onload=reloade;
function reloade(){
	document.getElementById("click").onclick=function(){window.location.reload()};
}
</script>



<!DOCTYPE html>
<html xmlns:fb="http://www.facebook.com/2008/fbml">
  <body>	
    <div id="fb-root"></div>
	
    <script>
      window.fbAsyncInit = function() {
        FB.init({
          appId: '<?php echo $facebook->getAppID() ?>',
		  status     : true,
          cookie: true,
          xfbml: true,
          oauth: true
        });		
         FB.Event.subscribe('auth.login', function(response) {			 
		 	if (response.authResponse) {
                    window.location.href = window.location.href +'?signed_request='+response.authResponse.signedRequest;
                } 	 
        });   		  		     
      };	  
      (function() {
        var e = document.createElement('script'); e.async = true;
        e.src = document.location.protocol +
          '//connect.facebook.net/en_US/all.js';
        document.getElementById('fb-root').appendChild(e);
      }());
    </script>
			
	 <?php if (!$user_profile) { ?>
	  <fb:login-button></fb:login-button>	  
    <?php } else { ?>
	  <a href='javascript:enviar_formulario()'>Desconectar</a> 
      <br>
	  estas logueao      
    <?php } ?>
	
	<div id="click">reload</div>
	
  </body>
</html>
