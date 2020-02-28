<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

$las_webs=new webs;

if(!isset($_POST['nick'])) $nick="";
else $nick=$_POST['nick'];

if(!isset($_POST['orden'])) $orden="";
else {$orden=$_POST['orden']; $_SESSION['orden']=$orden;}

$num_usuarios=$las_webs->recupera_usuarios($nick,$_SESSION['orden']);
?>

<?php include("cabecera.php");?>

	<!--FIN DE LA CABECERA-->
	
	<div id="contenedor_users">
		<div id="tit_users">Lista de usuarios de Negotiable Kite</div>
		<div id="cabecera_users">
			<form  action="users.php" method="post" class="busq_users">
				<label>Buscar usuario</label>
				<input type="text" maxlength="17" name="nick" value="<?php echo $nick; ?>"/>
				<input type="submit" value="Buscar" />
			</form>
			<form action="users.php" method="post" class="muestra_users">
				<label></label>
				<select name="orden" onchange="this.form.submit();">
					<?php
						if($_SESSION['orden']=="")
							echo "<option value='' selected='selected'>ordenar por</option> />";
						else
							echo "<option value='".$_SESSION['orden']."' selected='selected'>".$_SESSION['orden']."</option> />";
					?>
					
					<option value="fecha">fecha</option> />
					<option value="usuario">usuario</option>
				</select>
			</form>
			<div class="users">
				<?php echo $_pagi_totalReg; ?> Usuarios registrados
			</div>
		</div>
		<div id="listado_users">
						
			<?php
			if($num_usuarios>0)
			{	echo "
				<div id='head_users'>
						<div class='caja_users1'>Usuario</div>
						<div class='caja_users'>Ubicaci&oacute;n</div>
						<div class='caja_users'>Fecha alta</div>
						<!--<div class='caja_users'>Puntuaci&oacute;n vendedor</div>
						<div class='caja_users'>Puntuaci&oacute;n comprador</div>-->
					</div>";
					
				for($i=0;$i<$num_usuarios;$i++){
					if($matriz_resultado[$i]['puntuacion_vend']=="" or $matriz_resultado[$i]['puntuacion_vend']==0)
						{$matriz_resultado[$i]['puntuacion_vend']="--";$matriz_resultado[$i]['num_votos_vend']=0;}
					if($matriz_resultado[$i]['puntuacion_comp']=="" or $matriz_resultado[$i]['puntuacion_comp']==0)
						{$matriz_resultado[$i]['puntuacion_comp']="--"; $matriz_resultado[$i]['num_votos_comp']=0;}
					if($i%2==1) $clase="par"; else $clase="impar";
					$ano_alta=substr($matriz_resultado[$i]['fecha_alta'],0,4);
					$mes_alta=substr($matriz_resultado[$i]['fecha_alta'],5,2);
					$dia_alta=substr($matriz_resultado[$i]['fecha_alta'],8,2);
					$fecha_alta = $dia_alta."/".$mes_alta."/".$ano_alta;
					echo"					
					<div class='result_users ".$clase."'>
						<div class='caja_users prim'><a href='perfil/".$matriz_resultado[$i]["nick"]."'>".$matriz_resultado[$i]['nick']."</a></div>
						<div class='caja_users'>".$matriz_resultado[$i]['provincia']."</div>
						<div class='caja_users'>".$fecha_alta."</div>
						<!--<div class='caja_users'>".$matriz_resultado[$i]['puntuacion_vend']."
						 (".$matriz_resultado[$i]['num_votos_vend'].")</div>
						<div class='caja_users'>".$matriz_resultado[$i]['puntuacion_comp']."
						 (".$matriz_resultado[$i]['num_votos_comp'].")</div>-->				
					</div>";
				}
			}
			else{
				echo"
					<div class='result_users '>
						No se ha encontrado ningún resultado
					</div>";
				}
				
			?>
		</div>
		
		<?php echo"<p>".$_pagi_navegacion."</p>"; ?>

	
	</div><!--fin contenedor users-->
	
</div>

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
