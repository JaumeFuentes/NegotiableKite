// JavaScript Document
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
          xfbml      : true, // parse XFBML		
		  oauth		 : true  
        });

		 // Additional initialization code here
        FB.Event.subscribe('auth.login', function(response) {
          if (response.authResponse) {
                    window.location.href = window.location.href +'?signed_request='+response.authResponse.signedRequest;
          } 	
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
	<script>
	function FbLogin() {
		FB.login(function(response) {
   			if (response.authResponse) {
    	   		window.location.reload(); 
   			} 
			else {
    	   	 console.log('User cancelled login or did not fully authorize.');
  		    }
 		 }, {scope: 'email,publish_stream'});
	}
   </script>