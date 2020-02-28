<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

!isset($_REQUEST['seccion_link'])? $seccion_link="foros" : $seccion_link=$_REQUEST['seccion_link'];

$tienda = new Tiendas;

?>

<?php include("cabecera.php");?>
<script src="javascript/links.js"></script>
<script src="javascript/tiendas.js"></script>
	<!--FIN DE LA CABECERA-->
	
	<div id="bloque1">
    	<div id="bloque1_1">
            <div id="tit_users">Tiendas</div>
            
            <?php					
                //$tienda->generateTiendas($provincia);
				$tienda->generateTiendas($provincia);
				
            ?>
        </div>
        
        <div id="anuncio2">
        	<div id="contact_links">
                Si estas registrado en NK y tu tienda no aparece en el listado,<br />
                <a rel="prettyPhoto" href="contact.html?iframe=true&amp;width=530&amp;height=370">envíanos un mensaje</a> indicando tu nombre de usuario.
            </div>            
        </div>
        <div style="clear:both"></div>
	</div><!--bloque 1-->
    
	
</div>

<div id="frame_pie"></div>
</body>
</html>
