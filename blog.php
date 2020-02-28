<?php
include_once 'core/init.inc.php';
	$_SESSION['enviado']=false;
	$_SESSION['insertado']=false;	
if(isset($_POST['desconexion'])) {session_destroy(); header('location: index.php');}
?>


<?php include("cabecera.php");?>

	<!--FIN DE LA CABECERA-->
	
	<div id="bloque1">		
        	<iframe id="blog" class="auto-height" frameborder="0" marginwidth="0" marginheight ="0" src="http://negotiablekite.blogspot.com.es" scrolling="auto"></iframe>		
		</div>
        
		<div style="clear:both"></div>		
	<div id="linea_verde5"></div>	
</div>

<div style="clear:both"></div>	
<div id="pie_index">
	<div id="frame_pie_index"><?php include("pie.html");?></div>	
</div>
</body>
</html>
