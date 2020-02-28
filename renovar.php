<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

$las_webs=new webs;

if (isset($_GET['codan'])) $codan=$_GET['codan'];
else $codan=""; 
if (isset($_GET['time'])) $time=$_GET['time'];
else $time=""; 
if (isset($_GET['ale'])) $ale=$_GET['ale'];
else $ale=""; 

if($codan!="" and $time!="" and $ale!=""){
	$renovado=$las_webs->renovar_anuncio($codan,$time,$ale);	
}		
?>

<?php include("cabecera.php");?>
	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
		<div id="modif_perfil">
			<div id="tit_users_busqueda">Renovaci&oacute;n de anuncio</div>
			
			<form id="cont_renovar" method="post" action="renovar.php">
			<?php
			if(!$renovado){
				echo "
					<div class='caja'>
						<div class='int_caja'>
							<div class='texto_caja'>ERROR</div>							
						</div>
					</div>";
				}
				else{
					echo"
					<div class='caja'>
						<div class='int_caja'>
							<div class='texto_caja modif'>Anuncio renovado correctamente<div class='checked'></div></div>	
							<div class='texto_caja modif'>
								<a href='http://www.negotiablekite.com/anuncio.php?codan=".$codan."'>Ver anuncio</a>
								<div class='checked2'></div>
							</div>	
							<div class='texto_caja modif'>
								<a href='http://www.negotiablekite.com'>Ir a la p&aacute;gina de inicio</a>
								<div class='checked3'></div>
							</div>	
							<div style='clear:both'></div>																		
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
