<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

$las_webs=new webs;

if(!isset($_GET['user'])) $user="";
else $user=$_GET['user'];


$matriz_resultado3=array();
$num_enventa=$las_webs->en_venta($user);


?>

<?php include("cabecera.php");?>
	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
	
		<div id="tit_users">Anuncios publicados por <?php echo $user; ?></div>
		<div class="volver"><a href="javascript:history.back(-1);">&laquo; Volver a la p&aacute;gina anterior</a></div>
	
		<?php
		if($num_enventa>0){
			for($i=0;$i<$num_enventa;$i++){
				$ano_cad=substr($matriz_resultado3[$i]['fecha_cad'],0,4);
				$mes_cad=substr($matriz_resultado3[$i]['fecha_cad'],5,2);
				$dia_cad=substr($matriz_resultado3[$i]['fecha_cad'],8,2);
				$matriz_resultado3[$i]['fecha_cad']=$dia_cad."/".$mes_cad."/".$ano_cad;
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
                    <div class="bump">
                    	
                    </div>					
                </div>
				<div class="info2">
					'.$matriz_resultado3[$i]['precio'].'€
				</div>
				<div style="clear:both"></div>
            </div>';
			}
		}
		else{
		echo $user." no tiene ning&uacute;n anuncio publicado";
		}
		?>
				
		
	</div><!--Final div bloque1-->
</div>

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
