<?php
include_once '../core/init.inc.php';
$las_webs=new webs;

$mail_destino=$_SESSION['mail_destino'];

!isset($_REQUEST['mail_contacto'])? $mail_contacto="" : $mail_contacto=$_REQUEST['mail_contacto'];
!isset($_REQUEST['asunto'])? $asunto="" : $asunto=$_REQUEST['asunto'];
!isset($_REQUEST['mensaje'])? $mensaje="" : $mensaje=nl2br($_REQUEST['mensaje']);
!isset($_REQUEST['user'])? $user="" : $user=$_REQUEST['user'];

if($mail_contacto!="" and $asunto!="" and $mensaje!="" and $user!="")
		$enviado_ok=$las_webs->envia_mail_contactar($user,$mail_contacto,$asunto,$mensaje);
		


?>

<div class="titulo_perfil">Contactar con el Usuario</div>
<form id="email" >
	<div class="contenido_perfil">
		<div class="contenido_gen_perfil">email de contacto:</div>
		<input class="reqd email" type="text" name="mail_contacto" value=""/>
	</div>
	<label>motivo de contacto:</label>
	<input class="reqd" type="text" name="asunto" value="" />
	<label>mensaje:</label>
	<textarea class="reqd" name="mensaje" ></textarea>
	<input type="hidden" name="user" value="<?php echo $user; ?>" />
	<input type="submit" value="enviar" />
</form>			
<?php
if($enviado_ok)
	echo "<div id='enviado_ok_anuncio2'></div>";
else
	echo "<div id='enviado_error_anuncio2'></div>";
?>
				