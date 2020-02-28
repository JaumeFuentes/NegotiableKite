<?php
include_once 'core/init.inc.php';

$las_webs=new webs;

if(isset($_POST[login]) and isset($_POST[password]))
$las_webs->logueo();
?>

<?php include("cabecera.php");?>
	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
		<div id="bloque1_1">
			<form id="loginForm" class="login" name="loginForm" method="post" action="login.php"> 
				<div id="caja_tit">Inserte su nombre de usuario y contrase&ntilde;a</div>
				<div id="caja_login">
					<div class="caja_login2">
						<label>Usuario o email:</label>
						<input name="login" type="text" id="" />
					</div>
					<div class="caja_login2">
						<label>Contrase&ntilde;a:</label>
						<input type="password" name="password" id="" />
					</div>
					<input name="Submit" type="submit" id="entrar" value="Login" />
					<div class="caja_login2 links">
						<a href="registro.php">Regístrate</a>&nbsp;| 
						<a href="recupera_contrasena.php">¿Has olvidado la contrase&ntilde;a?</a>
					</div>
				</div>
			</form> 
			
		</div>
		<div id="anuncio2">
		</div>
	</div>
</div>

<div id="frame_pie"><?php include("pie.html");?></div></div>
</body>
</html>
