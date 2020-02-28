<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

include "clases/phpmailer/class.phpmailer.php";
include "clases/clase_email.php";


$clase_email = new clase_emails;
if(!isset($_GET["mail"])) $mail="";
else {
	$mail=$_GET["mail"];
	$mail = $clase_email->clean($mail);
	$clase_email->desactiva_email($mail);
}
?>

<?php include("cabecera.php");?>
<script language="Javascript"  type="text/javascript" src="javascript/overlib.js"></script>

	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1" >
    	<div id="tit_users">Desactivar avisos</div>
		Ok, los avisos para <?php echo $mail; ?> han sido desactivados.		
		
		
		
		
	</div><!--Final div bloque1-->		
	<div id="linea_verde5"></div>
</div>



<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
