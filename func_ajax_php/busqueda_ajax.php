<?php
include_once '../core/init.inc.php';
$las_webs=new webs;
$matriz_resultado3=array();
!isset($_REQUEST['clase'])? $clase="" : $clase=$_REQUEST['clase'];
!isset($_REQUEST['codan'])? $codan="" : $codan=$_REQUEST['codan'];

$las_webs->bump($_SESSION['SESS_MEMBER_COD'],$codan);
$num_enventa=$las_webs->anuncios($clase,"bump");


?>


<?php  
				for($i=0;$i<$num_enventa;$i++){
					$matriz_resultado3[$i]['provincia']=htmlentities($matriz_resultado3[$i]['provincia']);
					$matriz_resultado3[$i]['titulo']=htmlentities($matriz_resultado3[$i]['titulo']);
					/*arreglo primero la fecha de caducidad*/
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
                        	<span>
								<a href="perfil.php?user='.$matriz_resultado3[$i]['nick'].'">
								  	'.$matriz_resultado3[$i]['nick'].'
								 </a>
							</span>&nbsp;|&nbsp;
                            <span>'.$matriz_resultado3[$i]['provincia'].'</span>&nbsp;|&nbsp;
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
			?>
		
					
			

