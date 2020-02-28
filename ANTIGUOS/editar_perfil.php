<?php
include_once 'core/init.inc.php';	
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

$las_webs=new webs;

$ubicacion=$_SESSION['ubicacion'];

if(isset($_POST['ubicacion'])) {$ubicacion=$_POST['ubicacion']; $_SESSION['ubicacion']=$_POST['ubicacion'];}


//las variables SESSION las gasto para no tener que hacer una llamada a la base de datos cada vez que entro en la pagina

if(isset($_POST['ubicacion']))
	$editado=$las_webs->editar_datos($_SESSION['SESS_MEMBER_ID'],$ubicacion);	
?>

<?php include("cabecera.php");?>

	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
		<div id="modif_perfil">
			<div id="tit_users_busqueda">Modifica tus datos</div>
			<div class="volver"><a href="mi_pagina">&laquo; Volver a la p&aacute;gina anterior</a></div>
			<form id="cont_edit_perfil" method="post" action="editar_perfil">
			<?php
			if(!$editado){
				echo "
					<div class='caja'>
						<div class='int_caja'>
							<div class='texto_caja'>Provincia</div>";
							
								$localidades=$las_webs->dame_las_localidades();
								echo "<select class='reqd' name='ubicacion'>";
									
									echo "<option value=\"$ubicacion\">".$ubicacion."</option>";
									$numero_elementos=count($localidades); 
									for($i=0; $i<$numero_elementos; $i++)
										{$comunidad=$localidades[$i]["localidad"];
										echo "<option value=\"$comunidad\">".$comunidad."</option>";																					                               		 }	
								echo "</select>
							
						</div>
					</div>
					
					
					<input type='submit' value='enviar' />";
				}
				else{
					echo"
					<div class='caja'>
						<div class='int_caja'>
							<div class='texto_caja modif'>Datos modificados <div class='checked'></div></div>														
						</div>
					</div>";
				}
			?>
			</form>
		</div>
		
	</div>	
</div>


<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
