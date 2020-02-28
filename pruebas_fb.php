<?php
session_start();
	$_SESSION['enviado']=false;
	$_SESSION['insertado']=false;	
if(isset($_POST['desconexion'])) {session_destroy(); header('location: index.php');}
?>

<?php 
	
	include("clase_webs.php");
	$las_webs=new webs;
	$matriz_resultado3=array();
	$las_webs->ult_aun_publ();
	$marcas=array();
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

<?php include("cabecera.php");?>


<script src="javascript/carousel.js" type="text/javascript"></script>
<script type="text/javascript">
stepcarousel.setup({
	galleryid: 'carousel', //id of carousel DIV
	beltclass: 'belt', //class of inner "belt" DIV containing all the panel DIVs
	panelclass: 'panel', //class of panel DIVs each holding content
	autostep: {enable:false, moveby:2, pause:3000},
	panelbehavior: {speed:500, wraparound:true, persist:true},
	statusvars: ['statusA', 'statusB', 'statusC'], //register 3 variables that contain current panel (start), current panel (last), and total panels
	contenttype: ['external'] //content setting ['inline'] or ['external', 'path_to_external_file']
})
</script>



	
	<script>
		function no_gracias(){
			$("#registrate").slideUp(1000);
			$("#cabecera").css({ opacity: 1 });	
			$("#bloque1").css({ opacity: 1 });		
		}
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
			
		<?php 
		//print_r($_SESSION['friends']) 		
		/*for($i=0;$i<=count($_SESSION['friends']['data']);$i++){
			echo $_SESSION['friends']['data'][$i]['name'].'  '.$_SESSION['friends']['data'][$i]['id'].'<br />';
		}*/
		for($i=0;$i<=count($_SESSION['groups']['data']);$i++){
			echo $_SESSION['groups']['data'][$i]['name'].'  '.$_SESSION['groups']['data'][$i]['id'].'<br />';
		}
		
		?>
			
		</div>
		
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
		<a href="http://www.facebook.com/negotiable.kite1" target="_blank">
			<img src="iconos/facebook.gif" border="0"/>
		</a>
		<a href="http://twitter.com/#!/Negotiablekite" target="_blank">
			<img src="iconos/twitter.png" border="0" />
		</a>
	</div>
</div>



</body>
</html>
