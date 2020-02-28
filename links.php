<?php
include_once 'core/init.inc.php';
	
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

$las_webs=new webs;
!isset($_REQUEST['seccion_link'])? $seccion_link="foros" : $seccion_link=$_REQUEST['seccion_link'];

?>

<?php include("cabecera.php");?>
<script src="javascript/links.js"></script>
	<!--FIN DE LA CABECERA-->
	
	<div id="bloque1">
    	<div id="bloque1_1">
            <div id="tit_users">Links&nbsp;<?php echo $seccion_link; ?></div>
            
            <?php		
                $link->generateLinks($seccion_link);
            ?>
        </div>
        
        <div id="anuncio2">
            <div id="contact_links">
                Si quieres incluir un link no dudes en ponerte en contacto con nosotros.<br />
                <a href="mailto:info@negotiablekite.com">info@negotiablekite.com</a>
            </div>
        </div>
        <div style="clear:both"></div>
	</div><!--bloque 1-->
    
	
</div>

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
