<?php
include_once 'core/init.inc.php';

	$_SESSION['enviado']=false;
	$_SESSION['insertado']=false;
	
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}
?>

<?php include("cabecera.php");?>
	
	<!--FIN DE LA CABECERA-->
			

	<div id="bloque1">
		<div id="bloque1_1">
		<!--	<div id="anuncio1" >
				<div class="centrar-imagen"><a href="http://www.northkites.com/public/content/products/kites/rebel/index_esp.html"><img src="layout/banner_rebel_2011_468x60.gif"></a></div>
			</div>-->
			<div id="busqueda2">
				<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:comments href="www.negotiablekite.com" num_posts="30" width="500"></fb:comments>
				
			</div>
		</div>
		
		<div id="anuncio2">	
		
		</div>
		
		
	</div>
	
		

	
</div>

</body>
</html>
