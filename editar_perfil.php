<?php
include_once 'core/init.inc.php';	
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

?>

<?php include("cabecera.php");?>
<script src="ajax/edita_perfil_ajax.js"></script>
<script src="javascript/edita_perfil_marcas.js"></script>
<script src="ajax/ajaxupload.3.5.js"></script>

	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
    	<div id="bloque1_1">
        <?php
           $perfil = new perfil($_SESSION['SESS_MEMBER_ID']);
		   $perfil->generaEditaPerfil();
        ?>    
        </div>        
        <div id="anuncio2">
            
        </div>
        <div style="clear:both"></div>
	</div>	
   
</div>


<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
