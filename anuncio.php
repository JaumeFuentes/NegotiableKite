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
	 header('location: /notfound');
	 
if($matriz_resultado[0]["caducado"] == true)
	header('location: /notfound');
	 
$medida1= $matriz_resultado[0]["medida1"];
$medida2= $matriz_resultado[0]["medida2"];
$medida3= $matriz_resultado[0]["medida3"];
$clase= $matriz_resultado[0]["clase"];
$tipo= $matriz_resultado[0]["tipo"];
$cod_usuario=$matriz_resultado[0]["cod_usuario"];
?>

<?php
$perfil = new perfil($matriz_resultado[0]["nick"]);
$userData = $perfil->loadUserData($matriz_resultado[0]["nick"]);
if($userData['es_tienda'] == 1){
	$tiendaData = $perfil->loadTiendaData($userData['email']);
	$nombre_user = $tiendaData['nombre_tienda'];
	$tipo_usuario = "tienda";
}
else{
	$nombre_user = $matriz_resultado[0]["nick"];
	$tipo_usuario = "particular";
}
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
							class = 'cloud-zoom' id='zoom1'  rel="adjustX:10, adjustY:-4">
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
				<div class="info_anuncio">
					<ul>
                    	<li>
                        	<div class="heading">Ubicación:</div>
                            <div class="dato_anun"><?php echo $matriz_resultado[0]['provincia']; ?></div>
                            <div class="clear"></div>
                        </li>
                        <li>
                        	<div class="heading">Publicado el:</div>
                            <div class="dato_anun"><?php echo $matriz_resultado[0]['fecha_publ']; ?></div>
                            <div class="clear"></div>
                        </li>
                        <li>
                        	<div class="heading">Caduca el:</div>
                            <div class="dato_anun"><?php echo $matriz_resultado[0]['fecha_cad']; ?></div>
                            <div class="clear"></div>
                        </li>
                        <li>
                        	<div class="heading">Anuncio visto:</div>
                            <div class="dato_anun">
								<?php echo $matriz_resultado[0]["contador"]+1; ?>
                                <?php 
									if($matriz_resultado[0]["contador"]+1==1) echo "vez";
									if($matriz_resultado[0]["contador"]+1>1) echo "veces";
								?>
                            </div>
                            <div class="clear"></div>
                        </li>
                    </ul>
                    <div class="precio_anun"><?php echo $matriz_resultado[0]["precio"]; ?> €</div>
				</div>
				
			</div>	
			
			<div class="datos_anuncio">
				<div class="registro">
					DATOS DEL VENDEDOR
				</div>
				<div class="campos_info_anuncio">
                	
                    <div id="nombre_anun">
                    	<a href="perfil/<?php echo $matriz_resultado[0]["nick"]; ?>"><?php echo $nombre_user; ?></a>
                        <span class="<?php echo $tipo_usuario; ?>"><?php echo $tipo_usuario; ?></span>
                    </div>
                    <div>
                    	<div id="izda_anun">
                        	<div id="foto_perfil">
                        <img src="fotos_perfil/redimensionar.php?anchura=100&hmax=100&imagen=<?php echo $userData["foto_perfil"] ?>" />
                            </div>
                            <div class="op_con">
                            	<a href="perfil/<?php echo $matriz_resultado[0]["nick"] ?>#verComentarios">Opina</a>
                            </div>
                            <div>
								<?php $perfil->starsBlock($cod_usuario); ?>
                            </div>
                            
                        </div>                        
                         
                        <?php
						if( $matriz_resultado[0]["nick"] == "negotiablekite" ){
							$value = "Value";
							$style = "style='display:none'";
							$mail_contacto = "email@email.com";
							$enviar = "Contactar";
						}
						else{
							$value = "";
							$style = "";
							$mail_contacto = $_SESSION['SESS_MEMBER_EMAIL'];
							$enviar = "Enviar";
						}
						
						?>
                        <form  id="email" >
                            <fieldset>
                                <legend>Contacta con el Vendedor</legend>
                                    <div <?php echo $style;?> class="contenido_perfil">
                                        <div class="contenido_gen_perfil">Tu email de contacto:</div>
                                        <input class="reqd email" type="text" name="mail_contacto" value="<?php echo $mail_contacto; ?>" />
                                    </div>
                                    <label <?php echo $style;?>>motivo de contacto:</label>
                                    <input <?php echo $style;?> class="reqd" type="text" name="asunto" value="<?php echo $value;?>" />
                                    <label <?php echo $style;?>>mensaje:</label>
                                    <div class="area_enviar_perfil" <?php echo $style;?>>
                                        <textarea id="mensaje" class="reqd" name="mensaje" ><?php echo $value;?></textarea>
                                        <input type="hidden" name="user" value="<?php echo $matriz_resultado[0]["nick"];?>" />
                                        <input type="hidden" name="codan" value="<?php echo $codan;?>" />                             
                                    </div>
                                    
                                    <input  type="submit" value="<?php echo $enviar;?>" />
                                    <div class="clear"></div>
                            </fieldset>
                        </form>
                    </div>
                
                </div>
				
				
							
			</div>		
		<div style="clear:both"></div>	
		</div>
		
		
		<div class="bl_anuncio1">
			<div class="registro">
				CARACTERÍSTICAS DEL ARTÍCULO
			</div>
            <div class="info_anuncio">
                <ul>
                    <li>
                        <div class="heading">Marca:</div>
                        <div class="dato_anun"><?php echo $matriz_resultado[0]["marca"]; ?></div>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <div class="heading">Modelo:</div>
                        <div class="dato_anun"><?php echo $matriz_resultado[0]["modelo"]; ?></div>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <div class="heading">Medida:</div>
                        <div class="dato_anun"><?php $las_webs->medida($medida1,$medida2,$medida3,$clase,$tipo); ?></div>
                        <div class="clear"></div>
                    </li>
                </ul>
            </div>
             <div class="info_anuncio">
                <ul>
                    <li>
                        <div class="heading">Estado:</div>
                        <div class="dato_anun"><?php echo $matriz_resultado[0]["estado"]; ?></div>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <div class="heading">Reparaciones:</div>
                        <div class="dato_anun"><?php echo $matriz_resultado[0]["reparaciones"]; ?></div>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <div class="heading">Año:</div>
                        <div class="dato_anun"><?php echo $matriz_resultado[0]["ano"]; ?></div>
                        <div class="clear"></div>
                    </li>
                </ul>
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
        <br />
        <div class="bl_anuncio1">
			<div class="registro">
				ANUNCIOS PUBLICADOS POR <?php echo $nombre_user; ?>
			</div>
			<?php $perfil->bloqueAnunPubl($cod_usuario); ?>
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
