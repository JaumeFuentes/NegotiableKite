<?php
session_start();
if(isset($_POST['desconexion'])) {session_destroy(); header('location: index');}
if(!isset($_SESSION['SESS_MEMBER_ID'])) header('location:login');

include "clase_webs.php";
$las_webs=new webs; 
?>
<?php
	if(!isset($_SESSION['user_fb']))
	include "facebook/functions/facebook.php";
?>

<?php include("cabecera.php");?>
<script language="Javascript"  type="text/javascript" src="/publicar_anuncio.js"></script>

<div id="fb-root"></div>
    
    <!-- *************************************************************-->
    <!-- The following code will load and initialize the JavaScript SDK with all common options 
    The best place to put this code is right after the opening <body> tag -->
    <!-- Visit http://developers.facebook.com/docs/reference/javascript/ for more info -->
    
    <script>
      window.fbAsyncInit = function() {
        FB.init({//visit http://developers.facebook.com/docs/reference/javascript/FB.init/ for mor info
          appId      : '138100716293644',
		  //channelURL : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File (optional)
          status     : true, // check login status
          cookie     : true, // enable cookies to allow the server to access the session
          xfbml      : true, // parse XFBML		
		  oauth		 : true  
        });

		 // Additional initialization code here
       
      };
		// Load the SDK Asynchronously
      (function(d){
         var js, id = 'facebook-jssdk'; if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
		 //tener en cuenta aqui poner en_US para ingles o es_LA para español
         js.src = "//connect.facebook.net/en_US/all.js";
         d.getElementsByTagName('head')[0].appendChild(js);
       }(document));
    </script>
	
	<script>
	function alerta(){
		document.getElementById("prev").onmouseover = prev_fb;
		document.getElementById("prev").onmouseout = no_prev_fb;
	}
	
	function prev_fb(){	
	document.getElementById("prev_fb").style.display="block";
	titulo = document.getElementById("titulo").value;
	document.getElementById("messageBoddy").innerHTML=titulo;	
	descrip = $("#area").val();	
	$("#description").html(descrip);
	
	var profileId='<?php echo $_SESSION['SESS_MEMBER_ID_FACEBOOK']; ?>';
	var profilePicture='https://graph.facebook.com/'+profileId+'/picture';
	var imagen1=$('#imagen1').val();
	
	//esto lo pongo porque el valor leido del input file con el explorer y el chrome, me pone un un c:/fackepath primero
	//asi que lo tengo que quitar para quedarme con el nombre del archivo
	if(imagen1.substr(0,2)=='C:')
		imagen1=imagen1.substr(12,imagen1.length);
				
	if(imagen1!=''){
		direccImagen1='imagenes_temporales/imagen1'+'<?php echo $_SESSION['SESS_MEMBER_ID'] ?>'+'_'+imagen1;		
	}
	else{
		direccImagen1='iconos/logo2.png';		
	}
	$('#img_anun_fb').attr('src',direccImagen1);
	
	var id_fb=$('#id_fb').val();
	var direcProfilePic='https://graph.facebook.com/'+id_fb+'/picture';	
	$('#foto img').attr('src',direcProfilePic);
	
	var name_fb=$('#name_fb').val();
	$('#name').html(name_fb);
	
	$("#bloque1").css({ opacity: 0.3 });
	}
	
	function no_prev_fb(){
		document.getElementById("prev_fb").style.display="none";
		$("#bloque1").css({ opacity: 1 });
	}
	
	function FbLogin() {
		FB.login(function(response) {
   			if (response.authResponse) {
				var datos="de_anuncio=si";
    	   		//window.location.reload(); 
				$('#log_select').html('::conectando::');
				$.ajax({url:'facebook/functions/facebook.php',
						data:datos,
						success:function(msg){$('#log_select').html(msg); alerta();}
				});				
   			} 
			else {
    	   	 console.log('User cancelled login or did not fully authorize.');
  		    }
 		 }, {scope: 'email,publish_stream'});
	}
   </script>
   
   
	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1" >
		<div class="registro">
			INTRODUCE LA INFORMACIÓN DE TU ANUNCIO <span style="font-size:10px; color:black;  float:right; margin-right:5px;">(*) campo obligatorio</span>
		</div>
	<br />
		<form id="form_anuncio" name="formu" action="comprobar_anuncio.php" method="post" enctype="multipart/form-data">
		
		<div id="clase_articulo" class="bloques_publ_anuncio">
			<div class="texto">Clase de artículo (*) </div>
			<div class="opciones"> 
				<select id="clase" name="clase" class="reqd">
					<option value="" selected="selected">-Clase de artículo-</option>
					<option value="Cometas">Cometas</option>
					<option value="Tablas">Tablas</option>
					<option value="Barras">Barras</option>
					<option value="Arneses">Arneses</option>
					<option value="Accesorios">Accesorios</option>
				</select>
			</div>
		</div>		
			
		<div id="tipo" class="bloques_publ_anuncio">
			<div class="texto">Tipo (*) </div>
			<div  class="opciones">
				<select id="opciones_tipo" name="tipo" class="reqd">
					<option></option>
				</select>
			</div>
		</div>
		
		<div id="marca" class="bloques_publ_anuncio">
			<div class="texto">Marca</div>
			<div class="opciones">
				<input type="text" size="30" name="marca" value=""/>
			</div>
		</div>
		
		<div id="modelo" class="bloques_publ_anuncio">
			<div class="texto">Modelo</div>
			<div class="opciones">
				<input type="text" size="30" name="modelo" id="modelo_input" value=""/>
			</div>
		</div>
		
		<div id="medida" class="bloques_publ_anuncio medida">
			<div class="texto">Medida</div>
			<div class="opciones" id="medidadeloscojones"></div>
		</div>
		
		<div id="ano" class="bloques_publ_anuncio">
			<div class="texto">Año artículo</div>
			<div class="opciones">
				<input type="text" size="4" name="ano" value="" class="isNum"/>
				<span>&nbsp; ejemplo: 2010</span>
			</div>
		</div>
		
		<div id="estado" class="bloques_publ_anuncio">
			<div class="texto">Estado del artículo</div>
			<div class="opciones">
				<input type="radio" name="estado" value="nuevo" checked="checked"/> Nuevo
				&nbsp;&nbsp;
				<input type="radio" name="estado" value="usado" /> Usado
			</div>
		</div>
		
		<div id="incluye_barra" class="bloques_publ_anuncio">
			<div class="texto">¿Incluye barra?</div>
			<div class="opciones">
				<input type="radio" name="barra" value="si" checked="checked"/> Si
				&nbsp;&nbsp;
				<input type="radio" name="barra" value="no" /> No
			</div>
		</div>
		
		<div id="reparaciones" class="bloques_publ_anuncio">
			<div class="texto">¿Tiene reparaciones?</div>
			<div class="opciones">
				<input type="radio" name="reparaciones" value="si" /> Si
				&nbsp;&nbsp;
				<input type="radio" name="reparaciones" value="no" checked="checked" /> No
			</div>
		</div>
		
		<div id="provincia" class="bloques_publ_anuncio">
			<div class="texto">Provincia (*)</div>
			<div class="opciones">				
				<?php
					$localidades=$las_webs->dame_las_localidades();
					echo "<select name='ubicacion' class='reqd'>";
						if(isset($_POST["ubicacion"]) and $_POST["ubicacion"]!=-1)
						echo "<option value=\"$ubicacion\">".$ubicacion."</option>";
						else
						echo "<option value=''>Ubicación</option>";
						$numero_elementos=count($localidades); 
						for($i=0; $i<$numero_elementos; $i++)
							{$comunidad=$localidades[$i]["localidad"];
							echo "<option value=\"$comunidad\">".$comunidad."</option>";																					                               		 }	
					echo "</select>"; 
				?>
			</div>			
		</div>
		
		<div id="titulo2" class="bloques_publ_anuncio">
			<div class="texto">T&iacute;tulo del anuncio (*)</div>
			<div class="opciones">
				<input id="titulo" type="text" size="50" name="titulo" maxlength="50" value="" class="reqd"/>
			</div>
		</div>
		
		<div id="descripcion" class="bloques_publ_anuncio">
			<div class="texto">Descripci&oacute;n del anuncio(*)</div>
			<div class="opciones">
				<textarea  id="area" cols="50" rows="10" name="descripcion" class="reqd"></textarea>
				<br />
				<span id="info"> 0 car&aacute;cteres escritos (max 800)</span>
			</div>
		</div>
		
		<div id="precio" class="bloques_publ_anuncio">
			<div class="texto">Precio (*)</div>
			<div class="opciones">
				<input type="text" size="5" name="precio" maxlength="5" value="" class="reqd isNum"/> &nbsp;€
			</div>
		</div>
		
		<div id="duracion" class="bloques_publ_anuncio">
			<div class="texto">Duraci&oacute;n del anuncio</div>
			<div class="opciones">
				<select id="duracion" name="duracion">
					<option value=60 selected="selected">60 d&iacute;as</option>
					<option value=40>40 d&iacute;as</option>
					<option value=30>30 d&iacute;as</option>
					<option value=15>15 d&iacute;as</option>
				</select>
			</div>
		</div>
		
		<div id="texto_foto" class="bloques_publ_anuncio">
			<div class="texto"></div>
			<div class="opciones">
				<span style="font-weight:bold; color:#33CC00"> Los anuncios con fotos tienen muchas mas posibilidades de &eacute;xito </span><br />
				<span> Formato de las imágenes: JPEG o GIF o BMP o PNG. Tama&ntilde;o m&aacute;ximo 1 Mb. </span>
			</div>
		</div>
		
		<div class="bloques_publ_anuncio">
			<div class="texto">Elegir imagen 1</div>
			<div class="opciones">
				<input type="file" name="imagen1" id="imagen1" onchange="checkear(this,'ver1'); "/> 
				
				<input type="hidden" disabled name="maxpeso" value="1500000" />	<!--peso max de 1,5 Mb-->		
				<input type="hidden" disabled name="maxancho" value="3000" />	<!--3000-->			
				<input type="hidden" disabled name="maxalto" value="3000" /><!--3000-->	
				<!--<input type="hidden" name="objetivo" value="ver1" />-->
			</div>
		</div>
		
		<div class="bloques_publ_anuncio">
			<div class="texto">Elegir imagen 2</div>
			<div class="opciones">
				<input type="file" name="imagen2" id="imagen2" onchange="checkear(this,'ver2'); "/> 				
				
				
			</div>
		</div>
		
		<div class="bloques_publ_anuncio">
			<div class="texto">Elegir imagen 3</div>
			<div class="opciones">
				<input type="file" name="imagen3" id="imagen3" onchange="checkear(this,'ver3'); "/> 
			</div>
		</div>
		
		<div class="bloques_publ_anuncio">
			<div class="texto">Elegir imagen 4</div>
			<div class="opciones">
				<input type="file" name="imagen4" id="imagen4" onchange="checkear(this,'ver4'); "/> 
			</div>
		</div>
		<div class="bloques_publ_anuncio">
			<div class="texto"></div>
			<div class="opciones">
				<div style="float:left">
					<table>
						<tr>
							<td colspan="2" align="center">
								<input type="radio" name="main_image" id="main_image_1" value="1" checked="checked">
								<label for="main_image_1" style="font-size:10px">imagen principal</label>
							</td>
						</tr>
						<tr>
							<td valign="top" align="right"><span style="font-weight:bold">1</span></td>
							<td align="center">
								<div id="image_upload_1" style="width:100px; height:100px ">									
									<iframe  src="previsor.php" id="ver1" name="ver1" frameborder="0" marginwidth="0" marginheight ="0" style="display: block; 
									margin: auto;  width: 100%; height: 100%;">
									</iframe>							
								</div>
							</td>
						</tr>
						<tr>
							<td>
						  <td align="center">
									<a style="text-decoration:none; color:#666666;" id="remove_image_1" href="#" onclick="borrar('ver1');">Eliminar</a>
						  </td>
							</td>
						</tr>
					</table>
				</div>
			<!--  --> 
				<div style="float:left">
					<table>
						<tr>
							<td colspan="2" align="center">
								<input type="radio" name="main_image" id="main_image_2" value="2">
								<label for="main_image_1" style="font-size:10px">imagen principal</label>
							</td>
						</tr>
						<tr>
							<td valign="top" align="right"><span style="font-weight:bold">2</span></td>
							<td align="center">
								<div id="image_upload_2" style="width:100px; height:100px">
									<iframe  src="previsor.php" id="ver2" name="ver2" frameborder="0" marginwidth="0" marginheight ="0" style="display: block; 
									margin: auto;  width: 100%; height: 100%;">
									</iframe>									
								</div>
							</td>
						</tr>
						<tr>
							<td>
						  <td align="center">
									<a style="text-decoration:none; color:#666666;" class="remove_image" id="remove_image_2" href="#" onclick="borrar('ver2');">Eliminar</a>
						  </td>
							</td>
						</tr>
					</table>
				</div>
			<!--  --> 
				<div style="float:left">
					<table>
						<tr>
							<td colspan="2" align="center">
								<input type="radio" name="main_image" id="main_image_3" value="3">
								<label for="main_image_3" style="font-size:10px">imagen principal</label>
							</td>
						</tr>
						<tr>
							<td valign="top" align="right"><span style="font-weight:bold">3</span></td>
							<td align="center">
								<div id="image_upload_3" style="width:100px; height:100px">
									<iframe  src="previsor.php" id="ver3" name="ver3" frameborder="0" marginwidth="0" marginheight ="0" style="display: block; 
									margin: auto;  width: 100%; height: 100%;">
									</iframe>									
								</div>
							</td>
						</tr>
						<tr>
							<td>
						  <td align="center">
									<a style="text-decoration:none; color:#666666;" class="remove_image" id="remove_image_3" href="#" onclick="borrar('ver3');">Eliminar</a>
						  </td>
							</td>
						</tr>
					</table>
				</div>
			<!--  --> 
				<div style="float:left">
					<table>
						<tr>
							<td colspan="2" align="center">
								<input type="radio" name="main_image" id="main_image_4" value="4">
								<label for="main_image_4" style="font-size:10px">imagen principal</label>
							</td>
						</tr>
						<tr>
							<td valign="top" align="right"><span style="font-weight:bold">4</span></td>
							<td align="center">
								<div id="image_upload_4" style="width:100px; height:100px">
									<iframe  src="previsor.php" id="ver4" name="ver4" frameborder="0" marginwidth="0" marginheight ="0" style="display: block; 
									margin: auto;  width: 100%; height: 100%;">
									</iframe>									
								</div>
							</td>
						</tr>
						<tr>
							<td>
						  <td align="center">
									<a style="text-decoration:none; color:#666666;" class="remove_image" id="remove_image_4" href="#" onclick="borrar('ver4');">Eliminar</a>
						  </td>
							</td>
						</tr>
					</table>
	
				</div>
			</div>
		</div>		
		
		<div class="bloques_publ_anuncio">
			<div class="texto"></div>
			<div class="opciones">
				<hr />
				
					<div id="caja_fb">
						<span id="texto">
							Publica tu anuncio en facebook! 
						</span>						
						<div id="log_select">													
							<?php
								if(!$_SESSION['user_fb']){
									echo '   
										<div id="login_fb">											
											<div id="login_boton publ">
												 <a href="javascript:FbLogin();"><img src="iconos/fb_login_button.png" border="0"/></a>
											</div>
										</div>';
									echo '<input style="display:none" id="name_fb" type="text" value='.$_SESSION['SESS_MEMBER_NAME_FACEBOOK'].' />';
									echo '<input style="display:none" id="id_fb" type="text" value='.$_SESSION['SESS_MEMBER_ID_FACEBOOK'].' />';
								}
								else{
									echo '<div id="pre_box">
										 	 <input id="box" class="box" type="checkbox" name="publ_fb" value="acepta"/>
										 	 <span id="prev">Vista previa</span>
										  </div>';
									echo '<select id="grupo_fb" name="grupo_fb">
											<option value='.$_SESSION['SESS_MEMBER_ID_FACEBOOK'].'>En tu muro</option>';
										if(count($_SESSION['groups']['data']>0)){
											for($i=0;$i<=count($_SESSION['groups']['data']);$i++)
												echo '<option value='.$_SESSION['groups']['data'][$i]['id'].'>'.$_SESSION['groups']['data'][$i]['name'].'</option>';
										}
									echo '</select>';									
									
									echo '<input style="display:none" id="name_fb" type="text" value='.$_SESSION['SESS_MEMBER_NAME_FACEBOOK'].' />';
									echo '<input style="display:none" id="id_fb" type="text" value='.$_SESSION['SESS_MEMBER_ID_FACEBOOK'].' />';
								}
							?>
							
						</div>
                        <div style="clear:both"></div>
					</div>
				
			</div>
		</div>
		
		<div class="bloques_publ_anuncio">
			<div class="texto"></div>
			<div class="opciones ult">
				<hr />
				<p>
					<input type="submit" value="Continuar" />
					<input id="box" class="box" type="checkbox" name="condiciones" value="acepta"/>
					<span id="condiciones">
						<a href="condiciones_uso.html" target="_blank"> Acepto las condiciones de uso y la pol&iacute;tica de privacidad
						</a>
					</span>
				</p> 
			</div>
		</div>
		
		</form>		
		<div id="linea_verde5"></div>
	</div><!--Final div bloque1-->
</div>

<div id="frame_pie"><?php include("pie.html");?></div>


<!-- PREVISUALIZACION DE ANUNCIO EN FACEBOOK -->

<div id="prev_fb">
	<div id="foto">
		<img src="https://graph.facebook.com/<?php echo $_SESSION['SESS_MEMBER_ID_FACEBOOK']; ?>/picture">	</div>
	<div id="mainWrapper">
		<div id="name"></div>
		<div id="messageBoddy"></div>
		<div id="imageBlock">
			<div id="image">
				<img id='img_anun_fb' src="">	
			</div>
			<div id="block">
				<div id="title">NEGOTIABLE KITE</div>
				<div id="caption">www.negotiablekite.com</div>
				<div id="description"></div>
			</div>
		</div>	
		<div id="separador_fb"></div>
		<div id="imageblock2">
			<div id="icono_fb">
				<img src="iconos/minilogo.gif">			</div>
			<div id="like_comment">Like . Comment </div>
		</div>
	</div>
	<div id="separador_fb"></div>
</div>

<!-- FIN PREVISUALIZACION -->

</body>
</html>
