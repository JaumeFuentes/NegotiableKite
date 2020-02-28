<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}


$las_webs=new webs;
if(!isset($_GET["codan"])) $codan="";
else $codan=$_GET["codan"];

if(isset($_SESSION['SESS_MEMBER_ID']))	
	$usuario=$_SESSION['SESS_MEMBER_ID'];


if(!isset($_POST["marca"])) $marca="";
else $marca=$_POST["marca"];
if(!isset($_POST["modelo"])) $modelo="";
else $modelo=$_POST["modelo"];
if(!isset($_POST["medida1"])) $medida1="";
else $medida1=$_POST["medida1"];
if(!isset($_POST["medida2"])) $medida2="";
else $medida2=$_POST["medida2"];
if(!isset($_POST["medida3"])) $medida3="";
else $medida3=$_POST["medida3"];
if(!isset($_POST["ano"])) $ano="";
else $ano=$_POST["ano"];
if(!isset($_POST["estado"])) $estado="";
else $estado=$_POST["estado"];
if(!isset($_POST["reparaciones"])) $reparaciones="";
else $reparaciones=$_POST["reparaciones"];
if(!isset($_POST["titulo"])) $titulo="";
else $titulo=$_POST["titulo"];
if(!isset($_POST["descripcion"])) $descripcion="";
else $descripcion= nl2br($_POST["descripcion"]);
if(!isset($_POST["precio"])) $precio="";
else $precio=$_POST["precio"];
if(!isset($_POST["main_image"])) $main_image="";
else $main_image=$_POST["main_image"];

$editado=$las_webs->editar_anuncio($usuario,$titulo,$precio,$marca,$modelo,$medida1,$medida2,$medida3,$ano,$estado,$reparaciones,$descripcion,$codan);
$las_webs->edit_images($codan,$usuario,"imagenes_temporales/",$main_image)

?>

<?php include("cabecera.php");?>
	
	<!--FIN DE LA CABECERA-->
	
	<div id="bloque1" >
		
		<?php 
		if($editado==true){
			echo "
			<div id='anun_publ'>
				<div id='tit_anun_publ'>Anuncio Editado</div>
				<div id='caja_anun_publ'>
					<div class='caja1'>
						<div class='texto_ap'>Tu anuncio se ha modificado correctamente</div>
						<div class='icono checked'></div>
					</div>
					<div class='caja1'>
						<div class='texto_ap'>Puedes ver tu anuncio pinchando <a href='anuncio.php?codan=".$codan."'>AQUI</a></div>
						<div class='icono flecha'></div>
					</div>
				</div>
			</div>";	
		}
		 else echo "error"; 
		?>		
		
	</div><!--Final div bloque1-->
</div>

<div id="frame_pie"><?php include("pie.html");?></div>

</body>
</html>
