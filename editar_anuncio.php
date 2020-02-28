<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}


$las_webs=new webs;
if(!isset($_GET["codan"])) $codan="";
else $codan=$_GET["codan"];
$matriz_resultado=array();
$matriz_resultado=$las_webs->datos_anuncio($codan);

if($matriz_resultado[0]["titulo"]=="" or $matriz_resultado[0]["clase"]=="" or $matriz_resultado[0]["descripcion"]=="")
	 header('location: index.php');
	 
$medida1= $matriz_resultado[0]["medida1"];
$medida2= $matriz_resultado[0]["medida2"];
$medida3= $matriz_resultado[0]["medida3"];
$clase= $matriz_resultado[0]["clase"];
$tipo= $matriz_resultado[0]["tipo"];
?>

<?php include("cabecera.php");?>

<?php echo"<input type='hidden' id='clasejs' name='".$clase."' value='".$clase."' />";?>
<?php echo"<input type='hidden' id='tipojs' name='".$tipo."' value='".$tipo."' />";?>
<?php echo"<input type='hidden' id='medida1js' name='".$medida1."' value='".$medida1."' />";?>
<?php echo"<input type='hidden' id='medida2js' name='".$medida2."' value='".$medida2."' />";?>
<?php echo"<input type='hidden' id='medida3js' name='".$medida3."' value='".$medida3."' />";?>
<script language="Javascript"  type="text/javascript" src="/editar_anuncio.js"></script>


	<!--FIN DE LA CABECERA-->
	<div id="bloque1" >
		
		
		<div class="bl_anuncio1_editar">
			<form action="anuncio_editado.php?codan=<?php echo $codan; ?>" method="post" enctype="multipart/form-data">
			<div id="bl_imagenes_editar">
				<div class="MainImageBox" id="display_image">					
					<table id="MainImageTable" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td>
							<img id="detalle_image"  src='imagenes/redimensionar.php?anchura=377&hmax=333&imagen=<?php echo $las_webs->carga_imagen($codan,0);?>'>
							</td>
						</tr>
					</table>
				</div>
				
				<div style="clear:both"></div>
				
				<div id="thumbs">
					
					<div id="contenedor_thumb">
						<div id="selec_img_ppal">
							<input type="radio" name="main_image" id="main_image_1" value="1" checked="checked">
							<label for="main_image_1" style="font-size:10px">imagen principal</label>

						</div>
						<div class="Thumbnail editar" >				
							<iframe  src="previsor2.php?thumb=1&codan=<?php echo $codan ?>" id="ver1" name="ver1" frameborder="0" marginwidth="0" marginheight ="0" style="display: block; margin: auto;  width: 100%; height: 100%;">
							</iframe> 						
	
							<div class="upload">
								<input type="file" name="imagen1" id="imagen1" onChange="checkear(this,'ver1'); "/>
							</div>
							<input type="hidden" disabled name="maxpeso" value="1500000" />	<!--peso max de 1,5 Mb-->		
							<input type="hidden" disabled name="maxancho" value="30000" />	<!--30000-->			
							<input type="hidden" disabled name="maxalto" value="30000" /><!--30000-->	 
						</div>
					</div>
					
					
					
					<div id="contenedor_thumb">
						<div id="selec_img_ppal">
							<input type="radio" name="main_image" id="main_image_1" value="2" >
							<label for="main_image_1" style="font-size:10px">imagen principal</label>

						</div>
						<div class="Thumbnail editar">
							<iframe  src="previsor2.php?thumb=2&codan=<?php echo $codan ?>" id="ver2" name="ver2" frameborder="0" marginwidth="0" marginheight ="0" style="display: block; margin: auto;  width: 100%; height: 100%;">
							</iframe>	
							<div class="upload">
								<input type="file" name="imagen2" id="imagen2" onChange="checkear(this,'ver2'); "/>
							</div>					
						</div>
					</div>
					
					<div id="contenedor_thumb">
						<div id="selec_img_ppal">
							<input type="radio" name="main_image" id="main_image_1" value="3" >
							<label for="main_image_1" style="font-size:10px">imagen principal</label>

						</div>	
						<div class="Thumbnail editar">
							<iframe  src="previsor2.php?thumb=3&codan=<?php echo $codan ?>" id="ver3" name="ver3" frameborder="0" marginwidth="0" marginheight ="0" style="display: block; margin: auto;  width: 100%; height: 100%;">
							</iframe>
							<div class="upload">
								<input type="file" name="imagen3" id="imagen3" onChange="checkear(this,'ver3'); "/>
							</div>
						</div>
					</div>
					
					<div id="contenedor_thumb">
						<div id="selec_img_ppal">
							<input type="radio" name="main_image" id="main_image_1" value="4" >
							<label for="main_image_1" style="font-size:10px">imagen principal</label>

						</div>	
						<div class="Thumbnail editar">
							<iframe  src="previsor2.php?thumb=4&codan=<?php echo $codan ?>" id="ver4" name="ver4" frameborder="0" marginwidth="0" marginheight ="0" style="display: block; margin: auto;  width: 100%; height: 100%;">
							</iframe>
							<div class="upload">
								<input type="file" name="imagen4" id="imagen4" onChange="checkear(this,'ver4'); "/>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="datos_anuncio">		
				<div id="titulo_anuncio">						
					 <?php echo "<input type='text' class='reqd' name='titulo' value='".$matriz_resultado[0]["titulo"]."' maxlength='50' size='50'/>"; ?>
				</div>				
				<div id="info_anuncio">
					<div class="campos_info_anuncio e">Ubicaci&oacute;n: <span class="variab_anun"> <?php echo $matriz_resultado[0]["provincia"]; ?> </span></div>
					<div class="campos_info_anuncio e">Fecha publicaci&oacute;n:<span class="variab_anun">  <?php echo $matriz_resultado[0]["fecha_publ"]; ?></span></div>
					<div class="campos_info_anuncio e">Fecha expiraci&oacute;n: <span class="variab_anun"> <?php echo $matriz_resultado[0]["fecha_cad"]; ?></span></div>
					<div class="campos_info_anuncio e">Precio:<span class="variab_anun p"> 
						<?php echo "<input type='text' class='reqd isNum' name='precio' value='".$matriz_resultado[0]["precio"]."' maxlength='5' size='5'/>"; ?></span>&nbsp;€</div>
				</div>
				
			</div>	
			
			<div class="datos_anuncio">
				<div class="registro edit_anun">
				CARACTERÍSTICAS DEL ARTÍCULO
				</div>
				<div class="caract_articulo">
					<div class="campos_info_anuncio e"><span class="m">Marca:</span> <span class="variab_anun m">
						<?php echo "<input type='text' class='reqd' name='marca' value='".$matriz_resultado[0]["marca"]."' maxlength='30' size='30'/>"; ?></span></div>
					<div class="campos_info_anuncio e"><span class="m">Modelo: </span><span class="variab_anun m"> 
						<?php echo "<input type='text' class='reqd' name='modelo' value='".$matriz_resultado[0]["modelo"]."' maxlength='30' size='30'/>"; ?></span></div>
					<div id="medida" class="campos_info_anuncio e"><span class="m">Medida: </span>
						<div class="variab_anun">					 
							<div  id="opciones_medida"></div>
						</div>
					</div>
					<div class="campos_info_anuncio a e"><div class="m a">A&ntilde;o: </div><span class="variab_anun pa"> 
						<?php echo "<input type='text' name='ano' class='isNum' value='".$matriz_resultado[0]["ano"]."' maxlength='4' size='4'/>"; ?></span></div>
				</div>
				<div class="caract_articulo">
					<div class="campos_info_anuncio">Estado:  <div class="radio">
						<?php echo "<input type='radio' name='estado' value='nuevo'"; if($matriz_resultado[0]["estado"]=="nuevo")echo "checked='checked'"; echo"/> Nuevo
								</div>
								<div class='radio'>
								<input type='radio' name='estado' value='usado'"; if($matriz_resultado[0]["estado"]=="usado")echo "checked='checked'"; echo"/> Usado";   ?></div></div>
					<!--<div class="campos_info_anuncio">Barra: <?php //echo $matriz_resultado[0]["barra"]; ?></div>-->
					<div class="campos_info_anuncio e">Reparaciones: <div class="radio"> 
						<?php echo "<input type='radio' name='reparaciones' value='si'"; if($matriz_resultado[0]["reparaciones"]=="si")echo "checked='checked'"; echo"/> Si
								</div>
								<div class='radio'>
								<input type='radio' name='reparaciones' value='no'"; if($matriz_resultado[0]["reparaciones"]=="no")echo "checked='checked'"; echo"/> No";   ?></div></div>
				</div>
			</div>		
			
		</div>
		
		
		
		<div class="bl_anuncio1_editar">
			<div class="registro">
				DESCRIPCIÓN DEL ANUNCIO
			</div>
			<div id="descrip_anuncio">
			
			<?php echo "<textarea name='descripcion' class='reqd' cols='108' rows='10' >".preg_replace('`<br(?: /)?>([\\n\\r])`', '$1',$matriz_resultado[0]["descripcion"])."</textarea>"; ?>
			

			</div>
			<input type="submit" value="Enviar Cambios" />
			</form>
		</div>
		
	</div><!--Final div bloque1-->
</div>

<div id="frame_pie"><?php include("pie.html");?></div>

</body>
</html>
