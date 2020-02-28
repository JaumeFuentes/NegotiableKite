<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

$las_webs=new webs;

if(!isset($_GET['user'])) $user="";
else{
	$user=$_GET['user'];
	$cod_usuario=$las_webs->codigo_usuario($user);
	$num_filas_vendedor=$las_webs->votos_totales_vendedor($cod_usuario);
}
?>

<?php include("cabecera.php");?>
	
	<!--FIN DE LA CABECERA-->
	
	<div id="contenedor_users" class="voto">
		<div id="tit_users_voto">Lista de votos de <?php echo $user; ?> como vendedor</div>
		<div id="cabecera_users" class="voto">
			
			<div class="users voto">
				<?php echo $_pagi_totalReg; ?> votos recibidos en total 
			</div>
		</div>
		<div id="listado_users" class="voto">
						
			<?php
			if($num_filas_vendedor>=3)
			{	echo "
				<div id='head_users' class='voto'>
						<div class='caja_users1'>Usuario</div>
						<div class='caja_users voto coment'>Comentario</div>
						
						<div class='caja_users voto fecha'>fecha del voto</div>						
					</div>";
					
				for($i=0;$i<$num_filas_vendedor;$i++){
					
					if($i%2==1) $clase="par"; else $clase="impar";
					echo"					
					<div class='result_users voto ".$clase."'>
						<div class='caja_users prim'><a href='perfil.php?user=".$votos_vendedor[$i]['nick']."'>".$votos_vendedor[$i]['nick']."</a></div>
						<div class='caja_users voto coment comentario'>\"".$votos_vendedor[$i]['comentario']."\"</div>
						
						<div class='caja_users voto fecha'>".$votos_vendedor[$i]['fecha_voto']."</div>
					</div>";
				}
			}
			else{
				echo"
					<div class='result_users '>
						No se como te las has apañado cabroncete pero esto no se puede hacer
					</div>";
				}
				
			?>
		</div>
		
		<?php echo"<p>".$_pagi_navegacion."</p>"; ?>

		<div style="clear:both"></div>
	</div><!--fin contenedor users-->
	<div id="linea_verde5"></div>
</div>

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
