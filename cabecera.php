<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es">
<head>
<?php
if($_SESSION['servidor']=='192.168.1.159')
	echo '<base href="http://192.168.1.159/" />';
else
	echo '<base href="http://www.negotiablekite.com/" />';		
?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />		
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


<title>NEGOTIABLE KITE | Kitesurf segunda mano | Kitesurf nuevo | Anuncios  | Ocasion | Kites , Tablas , etc ...</title>
<link rel="stylesheet" href="estilos.css" type="text/css" />
<link rel="stylesheet" href="css/cloud-zoom.css" type="text/css" />
<link rel="stylesheet" href="css/anuncios_fb.css" type="text/css" />
<link rel="shortcut icon" href="/iconos/favicon.ico" />
<link rel="stylesheet" href="css/prettyPhoto.css" /> 
<link rel="stylesheet" href="css/tiendas.css" />
<link rel="stylesheet" href="css/perfil.css" />
<link rel="stylesheet" href="css/editar_perfil.css" />

<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
<!--<script src="http://code.jquery.com/jquery-latest.min.js"></script>-->
<script src="javascript/mueve_cometa.js"></script>
<script src="javascript/efecto_menu.js"></script>

<!--script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>-->
<script type="text/javascript" src="javascript/prettyphoto/custom_jQuery.js"></script>
<script type="text/javascript" src="javascript/prettyphoto/jquery.prettyPhoto.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.4" type="text/css" media="screen" />
<script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js?v=2.1.4"></script>


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
<div id="detalle_nk"></div>
<div id="top_negro">
	<ul id="menu">
        <!--<li><a href="/blog">Blog</a></li>-->
        <li><a href="http://www.negotiablekite.com">Inicio</a>
        <li><a href="/anuncios/cometas">Anuncios</a>
        <li><a href="/video">Videos</a>
        <li><a href="/tiendas">Tiendas</a>
        <li><a href="/links">Links</a>
            <?php echo $link->generaListaLinks() ?>
        </li>
        <li><a href="contact.html?iframe=true&amp;width=530&amp;height=370" rel="prettyPhoto">Contacto</a></li>
    </ul>
    <?php
	if(!isset($_SESSION['SESS_MEMBER_ID'])){
		echo '
    <div id="registrate_top">
        	<a href="/registro.php">REGISTRATE</a>
    </div>';
	}
	?>
</div>
<script src="ajax/links_ajax.js"></script>

<script type="text/javascript">
	//alert(screen.width);
	ancho = screen.width-17;
	ancho = ancho+"px";
	$("#top_negro").css("width",ancho);
</script>

<div id="cuerpo">
	<div id="cabecera">
		<div id="top_cabecera">
			<div id="logo"><a href="<?php echo 'http://www.'.$_SESSION['servidor']?>"><img src="iconos/logo2.png" border="0"/></a></div>
			<div id="tit_slo">
				<div id="tit"><span id="esconde_tit"><h1>Negotiable Kite</h1></span></div>
				<div id="slo"><span id="esconde_slogan">Portal de anuncios de art&iacute;culos de Kitesurf</span></div>
			</div>
			
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
					Hola Kiter!
				</div>";
			}
			else{
				echo"
				<div id='links'>
					<a href='mi_pagina.php'>Ir a mi pagina</a>&nbsp;|&nbsp;
					<a href='javascript:enviar_formulario()'>Desconectar</a> 
					 <form name='desconectar' method='post' action='index.php'>
						 <input type='hidden' name ='desconexion' value='desconexion' />						 
				     </form> 
				 </div>
				 <div id='user'>
				 	Hola ".$_SESSION['SESS_MEMBER_ID']."!
				</div>";
			}
			?>				
			</div>
		</div>	        	
		<div id="menu_busq">
			<div id="menu">
				<ul>
					<li><a class="cometas" href="anuncios/Cometas" title="Cometas"></a></li>
					<li><a class="tablas" href="anuncios/Tablas" title="Tablas"></a></li>
					<li><a class="barras" href="anuncios/Barras" title="Barras"></a></li>
					<li><a class="arneses" href="anuncios/Arneses" title="Arneses"></a></li>
					<li><a class="accesorios" href="anuncios/Accesorios" title="Accesorios"></a></li>
				</ul>
			</div>
			<div id="busq">
				<form id="formulario" action="busqueda.php" method="get">
					<span id="busq_rap">Búsqueda rápida:</span>
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
				<span class="texto_index"><a href="users">Ver usuarios</a></span>
				
			</div>
			<div id="linea_cab"></div>
			<div class="us">
				<span class="texto_index"><a href="publicar_anuncio">Publicar anuncio</a></span>
				
			</div>
		</div>
        <div class="clear"></div>
        
		<div id="linea_verde3"></div>
	</div>
	
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
          xfbml      : true, // parse XFBML		
		  oauth		 : true  
        });

		 // Additional initialization code here
        
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
 		 }, {scope: 'email,publish_stream,user_groups'});
	}
   </script>
	
   

	<!--FIN DE LA CABECERA-->