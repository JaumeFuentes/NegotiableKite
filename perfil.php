<?php
include_once 'core/init.inc.php';
if(!isset($_GET['user'])) $user="";
else{
	$user=$_GET['user'];		
}
	
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

$las_webs=new webs;
!isset($_REQUEST['seccion_link'])? $seccion_link="foros" : $seccion_link=$_REQUEST['seccion_link'];

?>

<?php include("cabecera.php");?>
<script src="javascript/links.js"></script>
<script src="ajax/coment_perfil_ajax.js"></script>
	<!--FIN DE LA CABECERA-->
	
	<div id="bloque1">
    	<div id="bloque1_1">
        <?php
           $perfil = new perfil($user);
		   $perfil->generaPerfil();
        ?>    
        </div>
        
        <div id="anuncio2">
           
        </div>
        <div style="clear:both"></div>
	</div><!--bloque 1-->
    
	
</div>

<div id="frame_pie"></div>
</body>
</html>
