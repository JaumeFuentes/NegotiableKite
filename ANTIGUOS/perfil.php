<?php
include_once 'core/init.inc.php';

if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}
//if(!isset($_SESSION['SESS_MEMBER_ID'])) header('location:index.php');

//esto lo hago para anular las variables utilizadas en la puntuacion y q se vuelva a poder puntuar.
//es importante poner esto en cada página desde la que se pueda acceder a la puntuacion.

//Nota:desde que empleo ajax en las votaciones, me parece que esto ya no hace falta.
$_SESSION['votacion_vendedor_ok']=false;
$_SESSION['votacion_comprador_ok']=false;
$_SESSION['votar_vendedor']=false;
$_SESSION['votar_comprador']=false;
unset($_SESSION['votacion_vendedor_ok']);
unset($_SESSION['votacion_comprador_ok']);
//////////////////////////////////////////////////////////////////////////////////////////////////

$las_webs=new webs;

if(!isset($_GET['user'])) $user="";
else{
	$user=$_GET['user'];	
	$matriz_resultado=$las_webs->datos_usuario($user);
	$cod_usuario=$las_webs->codigo_usuario($user);
	$num_filas_vendedor=$las_webs->votos_recibidos_vendedor($cod_usuario);
	$num_filas_comprador=$las_webs->votos_recibidos_comprador($cod_usuario);
	
}

?>

<?php include("cabecera.php");?>

<script language="Javascript"  type="text/javascript" src="javascript/overlib.js"></script>
<script language="Javascript"  type="text/javascript" src="/perfil.js"></script>
<script src="/ajax/perfil_ajax.js"></script>

	<!--FIN DE LA CABECERA-->
	<div id="tit_users">Perfil p&uacute;blico de <?php echo $user; ?></div>
		<div class="volver"><a href="javascript:history.back(-1);">&laquo; Volver a la p&aacute;gina anterior</a></div>
	<div id="contenedor_perfil">
		<div class="caja_perfil">
			<div class="titulo_perfil">Informaci&oacute;n del Usuario</div>
			<div class="contenido_perfil">
				<div class="contenido_gen_perfil">Usuario:</div>
				<div class="contenido_esp_perfil"><?php echo $user; ?></div>
			</div>
			<div class="contenido_perfil">
				<div class="contenido_gen_perfil">Ubicaci&oacute;n:</div>
				<div class="contenido_esp_perfil"><?php echo $matriz_resultado['ubicacion']; ?></div>
			</div>
			<div class="contenido_perfil">
				<div class="contenido_gen_perfil">Puntuaci&oacute;n media como comprador:</div>
				<div class="contenido_esp_perfil_2">
				<?php echo $matriz_resultado['puntuacion_vend']; ?> // 
				<?php echo $matriz_resultado['num_votos_vend']; ?> votos en total</div>				
			</div>
			<div class="contenido_perfil">
				<div class="contenido_gen_perfil">Puntuaci&oacute;n media como vendedor:</div>
				<div class="contenido_esp_perfil_2">
				<?php echo $matriz_resultado['puntuacion_comp']; ?> //
				<?php echo $matriz_resultado['num_votos_comp']; ?> votos en total</div>				
			</div>
			<div class="en_venta_perfil">
				<a href="en_venta_publ.php?user=<?php echo $user; ?>">Ver art&iacute;culos en venta del usuario</a>
			</div>
			<div class="en_venta_perfil">
				<a href="puntuacion.php?cod_usuario=<?php echo $cod_usuario; ?>">Puntuar usuario</a>
			</div>
		</div>
		<div id="caja_email" class="caja_perfil">
			<div class="titulo_perfil">Contactar con el Usuario</div>
			<form id="email" >
				<div class="contenido_perfil">
					<div class="contenido_gen_perfil">email de contacto:</div>
					<input class="reqd email" type="text" name="mail_contacto" />
				</div>
				<label>motivo de contacto:</label>
				<input class="reqd" type="text" name="asunto" value="" />
				<label>mensaje:</label>
				<textarea id="mensaje" class="reqd" name="mensaje" ></textarea>
				<input type="hidden" name="user" value="<?php echo $user;?>" />
				<input type="submit" value="enviar" />
			</form>				
		</div>
		<div style="clear:both"></div>
		<div class="caja_perfil_2">
		 	<div class="titulo_perfil">&Uacute;ltimos 5 votos como vendedor</div>	
				
				
				<?php 
				if($num_filas_vendedor>=3){
					echo "<table class='table'>";		
					for($i=0;$i<$num_filas_vendedor;$i++){
					echo"<tr><td class='nombre'><a href='perfil.php?user=".$votos_vendedor[$i]['nick']."'>
					".$votos_vendedor[$i]['nick']."</a></td><td class='coment'>\"".$votos_vendedor[$i]['comentario']."\"</td></tr>";
					}
					echo "</table>";
					echo"
					<div class='ver_votos'><a href='votos_vendedor.php?user=".$user."'>Ver todos los votos</a></div>";
				}
				else					
					echo "<div class='notifica'>".$user." todavía no ha recibido un m&iacute;nimo de 3 votos </div>";
				?>			
					
		</div>
		<div class="caja_perfil_2">
		 	<div class="titulo_perfil">&Uacute;ltimos 5 votos como comprador</div>		
				
				<?php	
				if($num_filas_comprador>=3){
					echo "<table class='table'>";		
					for($i=0;$i<$num_filas_comprador;$i++){
					echo"<tr><td class='nombre'><a href='perfil.php?user=".$votos_comprador[$i]['nick']."'>
					".$votos_comprador[$i]['nick']."</a></td><td class='coment'>\"".$votos_comprador[$i]['comentario']."\"</td></tr>";
					}
					echo "</table>";
					echo"
					<div class='ver_votos'><a href='votos_comprador.php?user=".$user."'>Ver todos los votos</a></div>";
				}
				else
					echo "<div class='notifica'>".$user." todavía no ha recibido un m&iacute;nimo de 3 votos </div>";
					?>	
						
					
		</div>
	</div><!--Final div contenedor_perfil-->
</div>

<div id="guarda_dato"></div><!-- esto lo guardo para guardar el valor devuelto al ejecutar el script perfil.js de forma que si todos
los campos se han rellenado correctamente se guarda true y si no se guarda false. lo hago empleando el método de jquery data()
luego este valor es leido por el script perfil_ajax.php y si es true ejecuta la funcion ajax y si es falso devuelve false-->

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
