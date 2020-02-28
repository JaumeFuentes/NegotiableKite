<?php
include_once 'core/init.inc.php';
isset($_REQUEST['to']) ? $vendedor = $_REQUEST['to'] : $vendedor = "";
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title></title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="javascript/prettyphoto/custom_jQuery_perfil.js"></script>
		<script type="text/javascript" src="javascript/prettyphoto/jquery.prettyPhoto.js"></script>
		<link rel="stylesheet" href="css/contact.css" /> 
		<link rel="stylesheet" href="css/prettyPhoto.css" /> 
	</head>
	<body>
		<!-- contact form -->
		<div id="form" class="form_contacto">
        
        <?php		
		if($_SESSION['SESS_MEMBER_ID']){
			echo '
			<form action="func_ajax_php/contact_ajax_perfil.php" method="post" id="contactform">            	
				
				<div id="contact_vendedor" style="display:none">
					<label>Vendedor</label>
					<input type="hidden" name="vendedor" class="inputbox text text-input" id="vendedor" value="'.$vendedor.'">
				</div>
				<div id="contact_asunto">
					<label>Asunto</label>
					<input type="text" name="asunto" class="inputbox text text-input" id="asunto"><br /><br />
				</div>
				<div id="contact_email">
					<label>Email</label><input type="text" name="email" value="'.$_SESSION['SESS_MEMBER_EMAIL'].'" class="inputbox text text-input" id="email"><br /><br />
				</div>
				<div id="contact_msg">
					<label>Mensaje</label><textarea name="message" rows="6" id="message" class="text-input"></textarea>
				</div>
				<div id="contact_send">
					<input type="submit" name="submit" class="button" id="submit_btn" value="Enviar">
				</div>
			</form>';
		}
		else
			echo 'Tienes que <a href="login" target="_blank">iniciar sesion</a> para enviar un mensaje<br /><br />
				  Si todav&iacute;a no tienes perfil, puedes <a href="registro" target="_blank">registrarte</a> en unos segundos';
		?>
            
		</div><!-- end contact form -->
	</body>
</html>