<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}


$las_webs=new webs;
if(!isset($_GET["codan"])) $codan="";
else {
	$codan=$_GET["codan"];
	$matriz_resultado=array();
	$matriz_resultado=$las_webs->datos_anuncio($codan);
	$las_webs->contador($codan,$matriz_resultado[0]["contador"]);
}

if($matriz_resultado[0]["titulo"]=="" or $matriz_resultado[0]["clase"]=="" or $matriz_resultado[0]["descripcion"]=="")
	 header('location: index.php');
	 
$medida1= $matriz_resultado[0]["medida1"];
$medida2= $matriz_resultado[0]["medida2"];
$medida3= $matriz_resultado[0]["medida3"];
$clase= $matriz_resultado[0]["clase"];
$tipo= $matriz_resultado[0]["tipo"];
$cod_usuario=$matriz_resultado[0]["cod_usuario"];
?>

<?php include("cabecera.php");?>
<script language="Javascript"  type="text/javascript" src="javascript/overlib.js"></script>
<script language="Javascript"  type="text/javascript" src="anuncio_script.js"></script>
<script src="ajax/anuncio_ajax.js"></script>
<script type="text/JavaScript" src="javascript/cloud-zoom.1.0.3.min.js"></script>

	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1" >
		<div class="bl_anuncio1">
			<div id="bl_imagenes">
				<div class="MainImageBox" id="display_image">		
                	<div>
                    	<a href='<?php echo $las_webs->carga_imagen($codan,0);?>' class = 'fancybox_anuncios' id=''>Ampliar</a>
                    </div>					
					<table id="MainImageTable" cellspacing="0" cellpadding="0" border="0">
						<tr>
							<td>
							<a href='<?php echo $las_webs->carga_imagen($codan,0);?>'
							class = 'cloud-zoom' id='zoom1'  rel="adjustX: 10, adjustY:-4">
							<img style="max-height:305px;max-width:368px;" src="imagenes/redimensionar.php?anchura=377&hmax=333&imagen=
							<?php echo $las_webs->carga_imagen($codan,0);?>" border="0"/></a>
							</td>
						</tr>
					</table>
				</div>
				
				<div style="clear:both"></div>
				
				<div id="thumbs">
					<div class="Thumbnail" >
						 <a href='<?php echo $las_webs->carga_imagen($codan,1);?>' class='cloud-zoom-gallery' title='Thumbnail 1'
        	rel="useZoom: 'zoom1', smallImage: 'imagenes/redimensionar.php?anchura=377&hmax=333&imagen=<?php echo $las_webs->carga_imagen($codan,1);?>' ">
        <img src="imagenes/redimensionar.php?imagen=<?php echo $las_webs->carga_imagen($codan,1);?>" alt = "Thumbnail 1" border="0"/></a>
					</div>
					
					<div class="Thumbnail">
						 <a href='<?php echo $las_webs->carga_imagen($codan,2);?>' class='cloud-zoom-gallery' title='Thumbnail 2'
        	rel="useZoom: 'zoom1', smallImage: 'imagenes/redimensionar.php?anchura=377&hmax=333&imagen=<?php echo $las_webs->carga_imagen($codan,2);?>' ">
        <img src="imagenes/redimensionar.php?imagen=<?php echo $las_webs->carga_imagen($codan,2);?>" alt = "Thumbnail 2" border="0"/></a>
					</div>
					
					<div class="Thumbnail">
						 <a href='<?php echo $las_webs->carga_imagen($codan,3);?>' class='cloud-zoom-gallery' title='Thumbnail 3'
        	rel="useZoom: 'zoom1', smallImage: 'imagenes/redimensionar.php?anchura=377&hmax=333&imagen=<?php echo $las_webs->carga_imagen($codan,3);?>' ">
        <img src="imagenes/redimensionar.php?imagen=<?php echo $las_webs->carga_imagen($codan,3);?>" alt = "Thumbnail 3" border="0"/></a>
					</div>
					
					<div class="Thumbnail">
						 <a href='<?php echo $las_webs->carga_imagen($codan,4);?>' class='cloud-zoom-gallery' title='Thumbnail 4'
        	rel="useZoom: 'zoom1', smallImage: 'imagenes/redimensionar.php?anchura=377&hmax=333&imagen=<?php echo $las_webs->carga_imagen($codan,4);?>' ">
        <img src="imagenes/redimensionar.php?imagen=<?php echo $las_webs->carga_imagen($codan,4);?>" alt = "Thumbnail 4" border="0"/></a>
					</div>
                    <div style="clear:both"></div>
				</div>
				
				
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style  addthis_32x32_style anuncio" addthis:url="http://www.negotiablekite.com/anuncio/<?php echo $codan ?>"  addthis:title="<?php echo $matriz_resultado[0]["titulo"]; ?>">
       
<a href="http://www.addthis.com/bookmark.php?v=250&pubid=ra-506c68bd6dae587d" class="addthis_button_facebook"></a> 
<span class="addthis_separador">|</span>
<a href="http://www.addthis.com/bookmark.php?v=250&pubid=ra-506c68bd6dae587d" class="addthis_button_twitter"></a>
<span class="addthis_separador">|</span>
<a href="http://www.addthis.com/bookmark.php?v=250&pubid=ra-506c68bd6dae587d" class="addthis_button_gmail"></a>
<span class="addthis_separador">|</span>
<a href="http://www.addthis.com/bookmark.php?v=250&pubid=ra-506c68bd6dae587d" class="addthis_button_email"></a>
<span class="addthis_separador">|</span>
<a href="http://www.addthis.com/bookmark.php?v=250&pubid=ra-506c68bd6dae587d" class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div> 

<!-- AddThis Button END -->
				
			</div>
           
            
            
			<div class="datos_anuncio">		
				<div id="titulo_anuncio">		
					 <?php echo $matriz_resultado[0]["titulo"]; ?>
				</div>				
				<div id="info_anuncio">
					<div class="campos_info_anuncio">Ubicaci&oacute;n: <span class="variab_anun"> <?php echo $matriz_resultado[0]["provincia"]; ?> </span></div>
					<div class="campos_info_anuncio">Fecha publicaci&oacute;n:<span class="variab_anun">  <?php echo $matriz_resultado[0]["fecha_publ"]; ?></span></div>
					<div class="campos_info_anuncio">Fecha expiraci&oacute;n: <span class="variab_anun"> <?php echo $matriz_resultado[0]["fecha_cad"]; ?></span></div>
					<div class="campos_info_anuncio">Precio:<span class="variab_anun"> <?php echo $matriz_resultado[0]["precio"]; ?></span>&nbsp;€</div>
				</div>
				<div id="compra_anuncio">
					<div class="prop_compr">
						<!--<a href="puntuacion.php?cod_usuario=<?php echo $cod_usuario ?>">
							<div class="votar">Votar usuario</div></a>-->
							<div id="contador">
								Anuncio visto 
								<span style="font-weight:bold"><?php echo $matriz_resultado[0]["contador"]+1; ?> </span>
								<?php 
									if($matriz_resultado[0]["contador"]+1==1) echo "vez";
									if($matriz_resultado[0]["contador"]+1>1) echo "veces";
								?>
							</div>
					</div>					
				</div>
			</div>	
			
			<div class="datos_anuncio">
				<div class="registro">
					DATOS DEL VENDEDOR
				</div>
				<div class="campos_info_anuncio">Usuario: <span class="variab_anun nick">
					<a  href="perfil/<?php echo $matriz_resultado[0]["nick"]; ?>" title="ver perfil de <?php echo $matriz_resultado[0]["nick"]; ?>">
						<?php echo $matriz_resultado[0]["nick"]; ?>
					</a></span></div>
				<!--<div id="info_puntuacion" class="campos_info_anuncio">Puntuacion vendedor<span class="variab_anun"> 
					<?php echo $matriz_resultado[0]["puntuacion_vend"];?> (<?php echo $matriz_resultado[0]["num_votos_vend"];?>)</span> </div>-->
				
			<div id="caja_email">
				<form  id="email" >
				<fieldset>
					<legend>Contacta con el Vendedor</legend>
						<div class="contenido_perfil">
							<div class="contenido_gen_perfil">Tu email de contacto:</div>
							<input class="reqd email" type="text" name="mail_contacto" value="<?php echo $_SESSION['SESS_MEMBER_EMAIL']; ?>" />
						</div>
						<label>motivo de contacto:</label>
						<input class="reqd" type="text" name="asunto" value="" />
						<label>mensaje:</label>
						<div class="area_enviar_perfil">
							<textarea id="mensaje" class="reqd" name="mensaje" ></textarea>
							<input type="hidden" name="user" value="<?php echo $matriz_resultado[0]["nick"];?>" />
							<input type="hidden" name="codan" value="<?php echo $codan;?>" />
							<input  type="submit" value="enviar" />
						</div>
				</fieldset>
				</form>
			</div>				
			</div>		
		<div style="clear:both"></div>	
		</div>
		
		
		<div class="bl_anuncio1">
			<div class="registro">
				CARACTERÍSTICAS DEL ARTÍCULO
			</div>
				<div class="caract_articulo">
					<div class="campos_info_anuncio">Marca: <span class="variab_anun"> <?php echo $matriz_resultado[0]["marca"]; ?></span></div>
					<div class="campos_info_anuncio">Modelo: <span class="variab_anun"> <?php echo $matriz_resultado[0]["modelo"]; ?></span></div>
					<div class="campos_info_anuncio">Medida: <span class="variab_anun">
						 <?php $las_webs->medida($medida1,$medida2,$medida3,$clase,$tipo); ?></span></div>
					
				</div>
				<div class="caract_articulo">
					<div class="campos_info_anuncio">Estado:  <span class="variab_anun"><?php echo $matriz_resultado[0]["estado"]; ?></span></div>
					<!--<div class="campos_info_anuncio">Barra: <?php //echo $matriz_resultado[0]["barra"]; ?></div>-->
					<div class="campos_info_anuncio">Reparaciones: <span class="variab_anun"> <?php echo $matriz_resultado[0]["reparaciones"]; ?></span></div>
					<div class="campos_info_anuncio">A&ntilde;o: <span class="variab_anun"> <?php echo $matriz_resultado[0]["ano"]; ?></span></div>
				</div>
		</div>
		<div class="bl_anuncio1">
			<div class="registro">
				DESCRIPCIÓN DEL ANUNCIO
			</div>
			<div id="descrip_anuncio">
			
			<?php echo $matriz_resultado[0]["descripcion"]; ?>

			</div>
		</div>
		
		<div class="bl_anuncio1 coment_rec">
			<div class="coment_recom_anun">
				<div class="registro">Comentarios sobre el anuncio</div>	
					<div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:comments href="www.negotiablekite.com/anuncio.php?codan=<?php echo $codan;?>" num_posts="25" width="440"></fb:comments>
			</div>
			<div class="coment_recom_anun rec">	
				<div class="registro">Recomienda el anuncio</div>
				<iframe  src="recom_anun.php?codan=<?php echo $codan; ?>" frameborder="0" marginwidth="0" marginheight ="0" width="100%"></iframe>	
				
			</div>
		
		</div>
		
	</div><!--Final div bloque1-->		
	<div id="linea_verde5"></div>
</div>

<div id="guarda_dato"></div><!-- esto lo guardo para guardar el valor devuelto al ejecutar el script perfil.js de forma que si todos
los campos se han rellenado correctamente se guarda true y si no se guarda false. lo hago empleando el método de jquery data()
luego este valor es leido por el script perfil_ajax.php y si es true ejecuta la funcion ajax y si es falso devuelve false-->

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
