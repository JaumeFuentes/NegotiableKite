<?php
	include_once 'core/init.inc.php';
	$las_webs=new webs;
	
	if(!isset($_GET['id'])) $cod_usuario="";
	else $cod_usuario=$_GET['id'];
	if(!isset($_GET['activatekey'])) $activatekey="";
	else $activatekey=$_GET['activatekey'];
	if(!isset($_POST['pw'])) $pw="";
	else $pw=$_POST['pw'];
	if(!isset($_POST["form_enviado"])) $form_enviado="";
	else $form_enviado=$_POST["form_enviado"];
	
	if($cod_usuario=="" or $activatekey=="")
		header('location:index.php');
	else
		if($pw!="" and strlen($pw)>=6)
			$cambia_pw=$las_webs->cambia_contr($cod_usuario,$activatekey,$pw);
?>


<?php include("cabecera.php");?>
<script src="reestablcont.js"></script>

	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
		<div id="bloque1_1">
			<div id="recupcont">
				<div class="registro">Reestablecer contrase&ntilde;a</div>
				<?php
				if(!$form_enviado){
					echo "
					<form method='post' action=''>
						<label class='rc'>elige tu nueva contrase&ntilde;a (m&iacute;nimo 6 car&aacute;cteres) </label>
						<input id='pw' class='reqd' type='password' name='pw' value='' />
						<label id='texto_pw_chk' class='rc'>Introduce de nuevo la contrase&ntilde;a</label>
						<input class='reqd' type='password' name='pw_chk' value='' />
						<input type='hidden' name='form_enviado' value='true' /><br /><br />
						<input type='submit' value='enviar'/>
					</form>";
				}
				else{
					if($cambia_pw){
						echo "
						<div class='notifica'>
							<div class='texto_recont error'>
								Tu contrase&ntilde;a ha sido actualizada
							</div>
							<div class='icono_avisa ok'></div>
							<div style='clear:both'></div>
						</div>";
					}
					else{
						echo "
						<div class='notifica'>
							<div class='texto_recont error'>
								Parece que ha habido un error</span>
							</div>
							<div class='icono_avisa error'></div>
							<div style='clear:both'></div>
						</div>";
					}
				}
				?>
				
				
				
			</div>
		</div>
		
	</div>
</div>

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>