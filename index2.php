<?php
session_start();

	$_SESSION['enviado']=false;
	$_SESSION['insertado']=false;
	
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>NEGOTIABLE KITE</title>
<link rel="stylesheet" href="estilos.css" type="text/css" />

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23066176-1']);
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
}
</script> 

</head>

<body>

<div id="cuerpo">
	
	<div id="cabecera">
		<div id="top_cabecera">
			<div id="logo"></div>
			<div id="tit_slo">
				<div id="tit"></div>
				<div id="slo"></div>
			</div>
			<div id="logo2"></div>
			<div id="ini_ses">
			<?php 
			if(!isset($_SESSION['SESS_MEMBER_ID'])){
				echo"
				<div id='links'>
					<a href='login.php'>Iniciar sesión</a>&nbsp;|&nbsp;<a href='registro.php'>Registrarse</a>
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
					 <form name='desconectar' method='post' action='index.php'>
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
					<a class="cometas" href="busqueda.php?clase=Cometas" title="Cometas"><li>Cometas</li></a><div id="separador"></div>
					<a class="tablas" href="busqueda.php?clase=Tablas" title="Tablas"><li>Tablas</li></a><div id="separador"></div>
					<a class="barras" href="busqueda.php?clase=Barras" title="Barras"><li>Barras</li></a><div id="separador"></div>
					<a class="arneses" href="busqueda.php?clase=Arneses" title="Arneses"><li>Arneses</li></a><div id="separador"></div>
					<a class="accesorios" href="busqueda.php?clase=Accesorios" title="Accesorios"><li>Accesorios</li></a>
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
			<div id="anuncio1" >
				<div class="centrar-imagen"><a href="http://www.northkites.com/public/content/products/kites/rebel/index_esp.html"><img src="layout/banner_rebel_2011_468x60.gif"></a></div>
			</div>
			<div id="busqueda2">
				<span class="cajas_busqueda2"><a href="busqueda.php?clase=Cometas" title="Cometas"><img src="layout/CatKites.jpg"></a> </span>
				<span class="cajas_busqueda2"><a href="busqueda.php?clase=Tablas" title="Tablas"><img src="layout/CatTablas.jpg"></a> </span>
				<span class="cajas_busqueda2"><a href="busqueda.php?clase=Barras"><img src="layout/CatBarras.jpg" title="Barras"></a> </span>
				<span class="cajas_busqueda2_arneses"><a href="busqueda.php?clase=Arneses"><img src="layout/CatArneses.jpg" title="Arneses"></a> </span>
				<span class="cajas_busqueda2"><a href="busqueda.php?clase=Accesorios"><img src="layout/CatAccesorios.jpg" title="Accesorios"></a> </span>
				<!--<span class="cajas_busqueda2"><a href="#"><img src="layout/CatRopa.jpg" title="Ropa"></a> </span>
				<span class="cajas_busqueda2"><a href="#"><img src="layout/CatOtros.jpg" title="Otros"></a> </span>-->
			</div>
		</div>
		<div id="anuncio2">
		</div>
	</div>
	
		
<!--	<div id="menu1">	</div>
	<div id="busqueda_venta">
		<span id="busqueda">		</span>
		<span id="busqueda_rapida">		</span>
		<span id="vender">		</span>	</div>
	<div id="contenedor2">
		<div ="contenedor3">
			<div id="anuncio1">			</div>
			<div id="menu2">			</div>
		</div>
		<div id="anuncio2">		</div>
	</div>
	<div id="otros_links">
		<span id="otros">		</span>
		<span id="links">		</span>	</div>
	<div id="footer">	</div>-->
	
</div>

<iframe id="frame_pie" src="pie.html" frameborder="0" marginwidth="0" marginheight ="0" ">
</iframe>
</body>
</html>
