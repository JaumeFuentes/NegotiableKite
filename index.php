<?php
include_once 'core/init.inc.php';
require('video/config.php');
require_once('video/include/user_functions.php');
$new_videos = get_video_list('added', 'desc', 0,8);
$blog = new blog;
$posts_blog = $blog->bloquePosts();
$link = new Links;
$tienda = new Tiendas;


$_SESSION['enviado']=false;
$_SESSION['insertado']=false;	

if(isset($_POST['desconexion'])) {session_destroy(); header('location: index.php');}
?>

<?php 	
	$las_webs=new webs;	
	$anuncios = new anuncios(); 	
	$marcas=$las_webs->marcas_mas_anunciadas();	 
?>

<?php
if(!isset($_SESSION['user_fb'])){
include "facebook/functions/facebook.php";
}	

if($_SESSION['user_fb'] or $user){
	$email_fb=$_SESSION['SESS_MEMBER_EMAIL_FACEBOOK'];		
	$registrado=$las_webs->comprueba_existe_mail_fb($email_fb);			
}
?>

<?php include_once("cabecera.php");?>

	
<script>
	function no_gracias(){
		$("#registrate").slideUp(1000);
		$("#cabecera").css({ opacity: 1 });	
		$("#bloque1").css({ opacity: 1 });		
	}
</script>

<script src="javascript/infinitecarousel/jquery.infinitecarousel3.js"></script>
<script>
$(document).ready(function(){
	$('#carousel').infiniteCarousel({
		inView:6,
		autoPilot:true,
		margin:0,
		displayProgressRing:false,
		displayTime:2000,
		transitionSpeed :2000
	});
});
</script>
	
<div id="registrate">
	<div id="top"></div>
	<div id="borde_iz"></div>
	<div id="cuerpo_reg">	
		<div id="texto">COMPLETA TU REGISTRO EN NEGOTIABLE KITE EN UNOS SEGUNDOS!</div>
		<div id="aceptar"><a href="registro.php">VALE!</a></div>
		<div id="rechazar"><a href="javascript:no_gracias()">No, gracias</a></div>
	</div>
	<div id="borde_der"></div>
	<div id="bottom"></div>
</div>

<script>
	function registrate(){
		$("#registrate").slideDown(1000);
		$("#cabecera").css({ opacity: 0.5 });	
		$("#bloque1").css({ opacity: 0.5 });		
	}
</script>
	
	<!--FIN DE LA CABECERA-->
	
	<div id="bloque1">
		<div id="bloque1_1">
            <div class="caja3">                
                <div class="def">
                    Publicaci&oacute;n de anuncios de material de Kitesurf nuevo o de segunda mano, 
                    para profesionales y particulares.
                </div>                                
            </div>
            <div class="linea_verde4"></div>
			<div style="clear:both"></div>
            
            <a href="http://www.surfertarifa.com" target="_blank"><img src="logos_webs_amigas/surfer.jpg" /></a>
            
            <div class="linea_verde4"></div>
			<div style="clear:both"></div>
            
            <h2>ULTIMOS ANUNCIOS PUBLICADOS</h2>
            <div class="contenedor_index">
            <?php
				$anuncios->bloqueAnunPubl2();
			?>    
            </div>
							
            <div class="linea_verde4"></div>
			<div style="clear:both"></div>
            
            <h2>NUEVOS VIDEOS</h2>
            <div class="contenedor_index">
            <?php				
				print_video_list($new_videos);
			?>    
            </div>
            
            <div class="linea_verde4"></div>
			<div style="clear:both"></div>
            
            <h2>NUEVAS TIENDAS REGISTRADAS</h2>
            <div class="contenedor_index">
            <?php				
				$tienda->generateTiendas($provincia,4);
			?>    
            </div>
            
            <div class="linea_verde4"></div>
			<div style="clear:both"></div>
            
            <h2>ANUNCIOS MAS VISTOS</h2>
            <div class="contenedor_index">
            <?php				
				$anuncios->bloqueAnunPubl3();
			?>    
            </div>
            
            <div class="linea_verde4"></div>
			<div style="clear:both"></div>
            
            <h2>ULTIMAS ENTRADAS PUBLICADAS</h2>
            <div class="contenedor_index">
            <?php				
				
				echo $posts_blog;
			?>    
            </div>
            
            <div class="linea_verde4"></div>
			<div style="clear:both"></div>
            
            <h2>MARCAS MAS ANUNCIADAS EN NEGOTIABLE KITE</h2>
            <div class="contenedor_index">
           		<ul id="carousel">
                <?php
				for($i=0;$i<=$num_marcas;$i++){
					echo '
					<li>
						<a href="'.$marcas[$i]['web'].'" target="_blank" title="'.$marcas[$i]['marca'].'"  style="text-align:center">
						<img width="117" height="70" alt="'.$marcas[$i]['marca'].'" src="'.$marcas[$i]['direc_img'].'" />
						<p><strong>'.$marcas[$i]['marca'].'</strong></p>
						</a>
					</li>';
				}
				?>   
                </ul>
            </div>
            <br />
           
            <div class="linea_verde4"></div>
			<div style="clear:both"></div>
				
            <div class="caja3">
                <span>
                    En <b>Negotiable Kite</b> podrás anunciar <b>gratis</b> tus <b>cometas</b>, <b>tablas</b>, <b>arneses</b>, <b>neoprenos</b> y todo lo relacionado con el <b>kitesurf</b>, tanto si es <b>nuevo</b> como de <b>segunda mano</b>.<br /><br />
                    Es un servicio para ayudar a <b>particulares</b> y a <b>empresas</b> a vender su material de kitesurf. Proporcionamos un servicio de <b>distribución automática</b> de anuncios con publicación instantánea en principales foros de kite y redes sociales para que lleguen al mayor número de gente.<br /> <br />
                    Negotiable Kite ayuda a los kiters que quieran <b>comprar</b> una cometa, tabla, etc con un buscador avanzado de anuncios, proporcionando información sobre el material en el que se está interesado y asesorando para una <b>compra segura</b>.
                </span>                    
            </div>
                
            <div class="linea_verde4"></div>
            <div style="clear:both"></div>    
				
		  	<div class="texto_inicio">Comenta que piensas y recomi&eacute;ndanos si te gusta:</div>
				
            <div id="fb">
                <div id="coment_fb">
                    <div id="comment">
                        <div id="fb-root"></div><fb:comments href="www.negotiablekite.com" num_posts="1" width="380"></fb:comments>
                    </div>
                    <div id="num_comment">
                        <iframe src="http://www.facebook.com/plugins/comments.php?locale=es_ES&href=www.negotiablekite.com/fb.php&permalink=1" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:130px; height:16px;" allowTransparency="true"></iframe> 
                    </div>
                </div>
                <div id="like_fb">
                    <iframe src="http://www.facebook.com/plugins/like.php?locale=es_ES&href=www.negotiablekite.com&amp;send=false&amp;layout=standard&amp;width=300&amp;show_faces=true&amp;action=recommend&amp;colorscheme=light&amp;font=arial&amp;height=80" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:80px;" allowTransparency="true"></iframe>
                </div>		
                <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>	
            </div>
			
		</div><!--fin bloque1_1 -->
		
		<div id="anuncio2">	
			<?php
			if(!$user and !isset($_SESSION['user_fb'])){
				echo '
					<div id="login_fb">
						<div id="conecta_fb">
						</div>
						<div id="login_boton">
							 <a href="javascript:FbLogin();"><img src="iconos/fb_login_button.png" border="0"/></a>
						</div>
					</div>';
					$_SESSION['mensaje_registro_fb']=false;
			}
			else
				if($registrado=="no" and $_SESSION['mensaje_registro_fb']==false and isset($_SESSION['user_fb'])){
					echo "<script> registrate(); </script>";
					$_SESSION['mensaje_registro_fb']=true;
				}
			?>
            <div id="icanfb">            	
                <div id="boton_icanfb">                	
                    <a href="afb"><img border="0" src="layout/busc_an_fb.png"></a>
                </div>
                <div id="texto_icanfb">
                	<ul>
                    	<li>Todos los anuncios de Kite en Facebook incluidos en una sola pagina</li>
                        <li>Buscador de anuncios integrado</li>                        
                        <li>Links a grupos, posts y usuarios, todo relacionado con el kitesurf</li>
                    </ul>
                </div>
            </div>
            <div style="margin-top:10px; margin-right:0; border:1px solid #eee; text-align:right;">
            <script type="text/javascript"><!--
				google_ad_client = "ca-pub-7222187738460026";
				/* Anuncio1 */
				google_ad_slot = "2091033508";
				google_ad_width = 160;
				google_ad_height = 600;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
            </div>
		</div>
		<div style="clear:both"></div>		
		
	</div>
	
		
<div id="linea_verde5"></div>	
</div>
<div style="clear:both"></div>	
<div id="pie_index">
	<div id="frame_pie_index"><?php include("pie.html");?></div>
	<div class="iconos_redes">
		<a href="http://wisuki.com/profile/NegotiableKite" target="_blank">
			<img src="iconos/wisuki.png" border="0"/>
		</a>	
		<a href="http://www.facebook.com/groups/369144093150754/" target="_blank">
			<img src="iconos/facebook.gif" border="0"/>
		</a>
		<a href="http://twitter.com/#!/Negotiablekite" target="_blank">
			<img src="iconos/twitter.png" border="0" />
		</a>
	</div>
</div>

</body>
</html>
