<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}
if(!isset($_SESSION['SESS_MEMBER_ID'])) header('location:registro.php');

include "facebook/functions/facebook.php";

$las_webs=new webs;
?>

<?php

if(!isset($_POST["clase"])) $clase="";
else $clase=$_POST["clase"];
if(!isset($_POST["tipo"])) $tipo="";
else $tipo=$_POST["tipo"];
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
if(!isset($_POST["barra"])) $barra="";
else $barra=$_POST["barra"];
if(!isset($_POST["reparaciones"])) $reparaciones="";
else $reparaciones=$_POST["reparaciones"];
if(!isset($_POST["ubicacion"])) $ubicacion="";
else $ubicacion=$_POST["ubicacion"];
if(!isset($_POST["titulo"])) $titulo="";
else $titulo=$_POST["titulo"];
if(!isset($_POST["descripcion"])) $descripcion="";
else $descripcion= nl2br($_POST["descripcion"]);
if(!isset($_POST["precio"])) $precio="";
else $precio=$_POST["precio"];
if(!isset($_POST["duracion"])) $duracion="";
else $duracion=$_POST["duracion"];
if(!isset($_POST["main_image"])) $main_image="";
else $main_image=$_POST["main_image"];
if(!isset($_POST["condiciones"])) $condiciones="";
else $condiciones=$_POST["condiciones"];
if(!isset($_POST["publ_fb"])) $publ_fb="";
else $publ_fb=$_POST["publ_fb"];
if(!isset($_POST["grupo_fb"])) $grupo_fb="";
else $grupo_fb=$_POST["grupo_fb"];

if($clase=="" or $ubicacion=="" or $titulo=="" or $descripcion=="" or $condiciones=="" or time()-60*1 < $_SESSION['momento_envio'])
	echo "<meta http-equiv='refresh' content='5; url=http://localhost' />";
?>


<?php include("cabecera.php");?>

	<!--FIN DE LA CABECERA-->
	<div id="bloque1" >
		
		<?php
		if(!isset($_SESSION['momento_envio'])) $_SESSION['momento_envio']=0;
		if($clase!="" and $ubicacion!="" and $titulo!="" and $descripcion!="" and condiciones!="" and time()-60*1 >=$_SESSION['momento_envio']){
			$cod_usuario=$las_webs->codigo_usuario($_SESSION['SESS_MEMBER_ID']);
			$random=$las_webs->genera_random(11);
			$las_webs->introduce_articulo($clase,$tipo,$marca,$modelo,$medida1,$medida2,$medida3,$ano,$estado,$barra,$reparaciones,$ubicacion,$cod_usuario,$random);
			$las_webs->introduce_anuncio($cod_usuario,$random,$titulo,$descripcion,$precio,$duracion);
			$img_ppal=$las_webs->move_images($cod_usuario,$random,$_SESSION['SESS_MEMBER_ID'],"imagenes_temporales/",$main_image);
			$_SESSION['momento_envio']=time(); 
			$direcc_anuncio=$las_webs->direccion_anuncio($cod_usuario);
			
			/***********POSTEAR EN FACEBOOK***************************/
			if($publ_fb){
				$facebook_post_array = array(
					"message" => $titulo,
					"description" => $descripcion,
					"link" => "http://www.negotiablekite.com/".$direcc_anuncio,
					"picture" => "http://www.negotiablekite.com/".$img_ppal,
				);
				$facebook->api($grupo_fb."/feed", "POST", $facebook_post_array);
			}
			
			/***********************************************************/
			
			
			//con la variable momento de envio, me aseguro de que pasan 1 minuto hasta que el usuario vuelve a publicar otro anuncio
			//asi evito que recargue la página y vuelva a introducir los datos en la BD			
			echo "
			<div id='anun_publ'>
				<div id='tit_anun_publ'>Anuncio publicado</div>
				<div id='caja_anun_publ'>
					<div class='caja1'>
						<div class='texto_ap'>¡Enhorabuena, tu anuncio ha sido publicado!</div>
						<div class='icono checked'></div>
					</div>
					<div class='caja1'>
						<div class='texto_ap'>Puedes ver tu anuncio pinchando <a href='".$las_webs->direccion_anuncio($cod_usuario)."'>AQUI</a></div>
						<div class='icono flecha'></div>
					</div>
				</div>
			</div>";					
		}		
		else
			echo "PARECE QUE HA HABIDO ALGÚN PROBLEMA";		
		?>
	</div><!--Final div bloque1-->
</div>

<div id="frame_pie"><?php include("pie.html");?></div>

</body>
</html>
