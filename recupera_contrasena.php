<?php
include_once 'core/init.inc.php';
$las_webs=new webs;
?>

<?php
if(!isset($_POST["form_enviado"])) $form_enviado="";
else $form_enviado=$_POST["form_enviado"];
if(!isset($_POST["email"])) $email="";
else{
	$email=trim($_POST["email"]);
	if ($email!="")
		$email_existe=$las_webs->mail_recup_contrasena($email);
}
?>

<?php include("cabecera.php");?>
<script src="recupera_contrasena.js"></script>

	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
		<div id="bloque1_1">
			<div id="recupcont">
				<div class="registro">Reestablecer contrase&ntilde;a</div>
				<form method="post" action="recupera_contrasena.php">
					<label>Introduce tu direcci&oacute;n de email:</label>
					<input class="email" type="text" name="email" value="" />
					<input type="hidden" name="form_enviado" value="true" />
					<input type="submit" value="enviar" />
				</form>
				
				<?php
				if($email_existe!=true and $form_enviado==true){
					echo "
						<div class='notifica'>
							<div class='texto_recont error'>
								El email introducido no se encuentra registrado en <span style='font-weight:bold'>NK</span>
							</div>
							<div class='icono_avisa error'></div>
							<div style='clear:both'></div>
						</div>";
				
				}
				elseif($form_enviado==true){
					echo "
						<div class='notifica'>
							<div class='texto_recont ok'>
								En breve recibir&aacute;s un email con un link con el que podr&aacute;s reestablecer tu contrase&ntilde;a
							</div>
							<div class='icono_avisa ok'></div>
							<div style='clear:both'></div>
						</div>";
				}
				?>
				
			</div>
		</div>
		
	</div>
</div>

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
