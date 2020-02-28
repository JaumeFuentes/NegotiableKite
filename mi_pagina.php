<?php
include_once 'core/init.inc.php';

if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}
if(!isset($_SESSION['SESS_MEMBER_ID'])) header('location:index.php');

$las_webs=new webs;
if($_SESSION['SESS_MEMBER_ID']!=""){
	$v_result=$las_webs->datos_mi_pagina($_SESSION['SESS_MEMBER_ID']);
	
	if($v_result['puntuacion_vend']=="" or $v_result['puntuacion_vend']==0)
		{$v_result['puntuacion_vend']="--"; $v_result['num_votos_vend']=0;}
	if($v_result['puntuacion_comp']=="" or $v_result['puntuacion_comp']==0)
		{$v_result['puntuacion_comp']="--"; $v_result['num_votos_comp']=0;}
		
	$_SESSION['ubicacion']=$v_result['ubicacion'];
	
}
?>

<?php include("cabecera.php");?>
	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
		<div id="bloque1_1">
			<div id="tit_users">Mi p&aacute;gina</div>
            
            <div class="menu_mipag">
				<div class="enlace">
					<span class="texto_mp"><a href="en_venta">Mis anuncios</a></span>				
				</div>
				<div class="linea_cab"></div>
				<div class="enlace">
					<span class="texto_mp"><a href="perfil/<?php echo $_SESSION['SESS_MEMBER_ID']; ?>">Mi perfil p&uacute;blico</a></span>
				</div>
                <div class="linea_cab"></div>
				<div class="enlace">
					<span class="texto_mp"><a href="editar_perfil">Modificar mis datos</a></span>
				</div>
			</div>
            
            <div id="cont_mipag">
            	<div class="titulo"><span>Resumen</span></div>
                <div class="linea">
                	<div class="dato">Nº de art&iacute;culos en venta:</div>
                    <div class="variable"><?php echo $v_result["en_venta"]; ?></div>
                </div>
                <!--
                 <div class="linea">
                	<div class="dato">Puntuaci&oacute;n como vendedor:</div>
                    <div class="variable"><?php echo $v_result["puntuacion_vend"]." (".$v_result["num_votos_vend"].")"; ?></div>
                </div>
                 <div class="linea">
                	<div class="dato">Puntuaci&oacute;n como comprador:</div>
                    <div class="variable"><?php echo $v_result["puntuacion_comp"]." (".$v_result["num_votos_comp"].")"; ?></div>
                </div>
                -->
                <div class="titulo"><span>Mis datos</span></div>
                <div class="linea">
                	<div class="dato">Nick:</div>
                    <div class="variable"><?php echo $_SESSION['SESS_MEMBER_ID']; ?></div>
                </div>
                <div class="linea">
                	<div class="dato">Provincia:</div>
                    <div class="variable"><?php echo $v_result["ubicacion"]; ?></div>
                </div>
                 <div class="linea">
                	<div class="dato">Email:</div>
                    <div class="variable"><?php echo $v_result["email"]; ?></div>
                </div>
            </div>
            			
		</div>
		<div id="anuncio2">
		</div>
	</div><!--Final div bloque1-->
</div>
<div id="frame_pie"><?php include("pie.html");?></div>

</body>
</html>
