<?php
session_start();

	$_SESSION['enviado']=false;
	$_SESSION['insertado']=false;
	
if(isset($_POST['desconexion'])) {session_destroy(); header('location: indice_pruebas.php');}

include "clase_webs.php";
$las_webs=new webs;
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

	
if($cookie and !isset($_SESSION['SESS_MEMBER_FACEBOOK'])){
	$user = json_decode(@file_get_contents('https://graph.facebook.com/me?access_token='.$cookie['access_token']));
	if($user){
		$email_fb=$user->email;
		$_SESSION['SESS_MEMBER_EMAIL_FACEBOOK']=$email_fb;
		$_SESSION['SESS_MEMBER_NAME_FACEBOOK']=$user->name;
		
		$registrado=$las_webs->comprueba_existe_mail_fb($email_fb);	
	}
}
	

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://ogp.me/ns/fb#">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<!--
<base href="http://www.negotiablekite.com" />-->
		
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="title" content="Negotiable Kite, tu portal de anuncios de art&iacute;culos de kitesurf" />
<meta name="description" content="Portal de anuncios clasificados de art&iacute;culos nuevos y de segunda mano de kitesurf" />
<meta name="keywords" content="kitesurf,kiteboarding,surf,anuncios,segunda mano,cometas,tablas,barras,arneses,neoprenos" />	
<meta name="author" content="NegotiableKite" />
<meta name="subject" content="negotiablekite.com" />
<meta name="publisher" content="jaumefuentes.com" />
<meta name="date" content="may-2011" />

<meta name="robots" content="all" />
<meta name="rights" content="&copy; Todos los derechos reservados" />
<?php
	if($registrado=="no")
		echo '<meta http-equiv="refresh" content="0;URL=registro.php" >';
?>

<title>NEGOTIABLE KITE</title>
<link rel="stylesheet" href="estilos.css" type="text/css" />
<link rel="shortcut icon" href="/iconos/favicon.ico" />
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="/javascript/mueve_cometa.js"></script>
<script src="/javascript/efecto_menu.js"></script>

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23066176-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<script type="text/javascript">

function enviar_formulario(){
   document.desconectar.submit()
   FB.logout(function(response) {
  // user is now logged out
});
}
</script> 


</head>

<body>

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
<div id="cuerpo">
	<div id="cabecera">
		<div id="top_cabecera">
			<div id="logo"><a href="index.php"><img src="iconos/logo_NK.gif" border="0"/></a></div>
			<div id="tit_slo">
				<div id="tit"><span id="esconde_tit"><h1>Negotiable Kite</h1></span></div>
				<div id="slo"><span id="esconde_slogan">Portal de anuncios de art&iacute;culos de Kitesurf</span></div>
			</div>
			<div id="logo2"></div>
			<div id="ini_ses">
			<?php 
			if(!isset($_SESSION['SESS_MEMBER_ID'])){
				echo"
				<div id='links'>
					<a href='login.php'>Iniciar sesión</a>&nbsp;|&nbsp;<a href='registro.php'>Registrarse</a>
			";?>
					
					
					
    		<?php
			echo "
					
				</div>
				<div id='user'>
					Bienvenido Usuario
				</div>";
			}
			else{
				echo"
				<div id='links'>
					<a href='mi_pagina.php'>Ir a mi pagina</a>&nbsp;|&nbsp;
					<a href='javascript:enviar_formulario()'>Desconectar</a> 
					 <form name='desconectar' method='post' action='indice_pruebas.php'>
						 <input type='hidden' name ='desconexion' value='desconexion' />	
				     </form> 
				 </div>
				 <div id='user'>
				 	Bienvenido ".$_SESSION['SESS_MEMBER_ID']."
				</div>";
			}
			?>				
			</div>
		</div>		
		<div id="menu_busq">
			<div id="menu">
				<ul>
					<li><a class="cometas" href="busqueda.php?clase=Cometas" title="Cometas">Cometas</a><div id="separador"></div></li>
					<li><a class="tablas" href="busqueda.php?clase=Tablas" title="Tablas">Tablas</a><div id="separador"></div></li>
					<li><a class="barras" href="busqueda.php?clase=Barras" title="Barras">Barras</a><div id="separador"></div></li>
					<li><a class="arneses" href="busqueda.php?clase=Arneses" title="Arneses">Arneses</a><div id="separador"></div></li>
					<li><a class="accesorios" href="busqueda.php?clase=Accesorios" title="Accesorios">Accesorios</a></li>
				</ul>
			</div>
			<div id="busq">
				<form id="formulario" action="busqueda.php" method="get">
					Búsqueda rápida:
					<input type="text" name="dato_busqueda" value=""/>		
					<select id="articulo" name="clase">				
						<option value="Cometas" selected="selected">Cometas</option>
						<option value="Tablas">Tablas</option>
						<option value="Barras">Barras</option>
						<option value="Arneses">Arneses</option>
						<option value="Accesorios">Accesorios</option>
					</select>
					<input type="submit" value="Buscar" />
				</form>
			</div>
		</div>
		<div id="us_publ">
			<div class="us">
				<span class="texto_index"><a href="users.php">Ver usuarios</a></span>
				<div id="ico_users"></div>
			</div>
			<div class="us">
				<span class="texto_index"><a href="publicar_anuncio.php">Publicar anuncio</a></span>
				<div id="ico_publ"></div>
			</div>
		</div>
		<div id="linea_verde3"></div>
	</div>
	
	<!--FIN DE LA CABECERA-->
			

	<div id="bloque1">
		<div id="bloque1_1">
		<!--	<div id="anuncio1" >
				<div class="centrar-imagen"><a href="http://www.northkites.com/public/content/products/kites/rebel/index_esp.html"><img src="layout/banner_rebel_2011_468x60.gif"></a></div>
			</div>-->
			
			
				<div class="texto_inicio">¿Que clase de art&iacute;culo est&aacute;s buscando?</div>
				<div id="cajas_cometa" class="cajas_busqueda2"><a href="busqueda.php?clase=Cometas" title="Cometas"></a> </div>
				<div id="cajas_tabla" class="cajas_busqueda2"><a href="busqueda.php?clase=Tablas" title="Tablas"></a> </div>
				<div id="cajas_barra" class="cajas_busqueda2"><a href="busqueda.php?clase=Barras"></a> </div>
				<div id="cajas_arnes" class="cajas_busqueda2"><a href="busqueda.php?clase=Arneses"></a> </div>
				<div id="cajas_accesorios" class="cajas_busqueda2"><a href="busqueda.php?clase=Accesorios"></a> </div>
				<!--<span class="cajas_busqueda2"><a href="#"><img src="layout/CatRopa.jpg" title="Ropa"></a> </span>
				<span class="cajas_busqueda2"><a href="#"><img src="layout/CatOtros.jpg" title="Otros"></a> </span>-->
				
				<div id="linea_verde4"></div>
				<div style="clear:both"></div>
				<div class="texto_inicio">Comenta que piensas y recomi&eacute;ndanos si te gusta:</div>
				
				<div id="fb">
					<div id="coment_fb">
						<div id="comment">
							<fb:comments href="www.negotiablekite.com" num_posts="1" width="380"></fb:comments>
						</div>
						<div id="num_comment">
							<iframe src="http://www.facebook.com/plugins/comments.php?locale=es_ES&href=www.negotiablekite.com/fb.php&permalink=1" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:16px;" allowTransparency="true"></iframe> 
						</div>
					</div>
					<div id="like_fb">
						<iframe src="http://www.facebook.com/plugins/like.php?locale=es_ES&href=www.negotiablekite.com&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=true&amp;action=recommend&amp;colorscheme=light&amp;font=arial&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:80px;" allowTransparency="true"></iframe>
					</div>		
					<a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>	
				</div>
			
		</div>
		
		<div id="anuncio2">	
			<?php
			if(!$user){
				echo '
					<div id="login_fb">
						<div id="conecta_fb">
						</div>
						<div id="login_boton">
							 <fb:login-button perms="email" ></fb:login-button>
						</div>
					</div>';
			}
			?>
		</div>
		
		<div style="clear:both"></div>		
		
	</div>
	
		
<div id="linea_verde5"></div>	
</div>
<div style="clear:both"></div>	
<div id="pie_index">
	<iframe id="frame_pie_index" src="pie.html" frameborder="0" marginwidth="0" marginheight ="0"></iframe>
	<div class="iconos_redes">
		<a href="http://wisuki.com/profile/NegotiableKite" target="_blank">
			<img src="iconos/wisuki.png" border="0"/>
		</a>	
		<a href="http://www.facebook.com/negotiable.kite1" target="_blank">
			<img src="iconos/facebook.gif" border="0"/>
		</a>
		<a href="http://twitter.com/#!/Negotiablekite" target="_blank">
			<img src="iconos/twitter.png" border="0" />
		</a>
	</div>
</div>

</body>
</html>
