<?php
include_once 'core/init.inc.php';

if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}
if(!isset($_SESSION['SESS_MEMBER_ID'])) header('location:index.php');

$las_webs=new webs;

if(isset($_REQUEST["codan_el"])){
	$cod_anuncio=$_REQUEST["codan_el"];
	$las_webs->borra_anuncio($cod_anuncio,$_SESSION['SESS_MEMBER_ID']);
}
$matriz_resultado3=array();
$num_enventa=$las_webs->en_venta($_SESSION['SESS_MEMBER_ID']);
?>

<?php include("cabecera.php");?>

<script language="JavaScript">
function confirma (url) {
	
	if (confirm("¿Estás seguro de que quires eliminar este anuncio?")) location.replace(url);
}
</script>
	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
		<div id="tit_users">Lista de anuncios publicados</div>
		<div class="volver"><a href="mi_pagina.php">&laquo; Volver a la p&aacute;gina anterior</a></div>
	
		<?php
			for($i=0;$i<$num_enventa;$i++){
				$ano_cad=substr($matriz_resultado3[$i]['fecha_cad'],0,4);
				$mes_cad=substr($matriz_resultado3[$i]['fecha_cad'],5,2);
				$dia_cad=substr($matriz_resultado3[$i]['fecha_cad'],8,2);
				$matriz_resultado3[$i]['fecha_cad']=$dia_cad."/".$mes_cad."/".$ano_cad;
				$aununcio_a_eliminar="\"en_venta.php?codan_el=".$matriz_resultado3[$i]['cod_anuncio']."\"";
				echo '
            <div class="tabla"  id=tabla'.$i.'>
            	<div class="celda_imagen">
                	<a class="fancybox" href="'.$matriz_resultado3[$i]['direcc_imagen'].'">
						<img src="/imagenes/redimensionar.php?imagen='.$matriz_resultado3[$i]['direcc_imagen'].'" />
					</a>
                </div>
                <div class="dcha_tabla">
                	<div class="titulo">
                    	<a href="anuncio/'.$matriz_resultado3[$i]['cod_anuncio'].'">'.$matriz_resultado3[$i]['titulo'].'</a>
                    </div>
                    <div class="info_anun">
                    	<div class="info1">                        	
                            <span class="fecha">'.$matriz_resultado3[$i]['fecha_cad'].'</span>
                        </div>                        
                    </div>
                    <div class="bump" style="margin-top:5px;">';
					echo "
                    	<a id='eliminar' href='JavaScript:confirma(".$aununcio_a_eliminar.")'>Eliminar</a> /
						<a href='editar_anuncio.php?codan=".$matriz_resultado3[$i]['cod_anuncio']."'> Editar</a></td>
						";
					echo '
                    </div>					
                </div>
				<div class="info2">
					'.$matriz_resultado3[$i]['precio'].'€
				</div>
				<div style="clear:both"></div>
            </div>';
							
						/*
							<a id='eliminar' href='JavaScript:confirma(".$aununcio_a_eliminar.")'>Eliminar</a> /
						<a href='editar_anuncio.php?codan=".$matriz_resultado3[$i]['cod_anuncio']."'> Editar</a></td>*/
					
			}
		?>
				
		
	</div><!--Final div bloque1-->
</div>

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
