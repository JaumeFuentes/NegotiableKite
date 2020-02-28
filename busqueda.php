<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}


$las_webs=new webs;

if(!isset($_POST['orden_b'])) $orden="";
else {$orden=$_POST['orden_b']; $_SESSION['orden_b']=$orden;}

$matriz_resultado3=array();
if(isset($_GET["clase"])){
	$clase=$_GET["clase"];
	if(isset($_GET["dato_busqueda"])){
		$dato_busqueda=$_GET["dato_busqueda"];
		$num_enventa=$las_webs->simple_anuncios($clase,$dato_busqueda,$_SESSION['orden_b']);
	}
	else
	$num_enventa=$las_webs->anuncios($clase,$_SESSION['orden_b']);
}
?>

<?php
if(!isset($_POST["tipo"])) $tipo=$_SESSION['tipo'];
else {$tipo=$_POST["tipo"]; $_SESSION['tipo']=$tipo;}
if(!isset($_POST["marca"])) $marca=$_SESSION['marca'];
else {$marca=$_POST["marca"]; $_SESSION['marca']=$marca;}
if(!isset($_POST["modelo"])) $modelo=$_SESSION['modelo'];
else {$modelo=$_POST["modelo"]; $_SESSION['modelo']=$modelo;}
if(!isset($_POST["medida1"])) $medida1=$_SESSION['medida1'];
else {$medida1=$_POST["medida1"]; $_SESSION['medida1']=$medida1;}
if(!isset($_POST["medida2"])) $medida2=$_SESSION['medida2'];
else {$medida2=$_POST["medida2"]; $_SESSION['medida2']=$medida2;}
if(!isset($_POST["medida3"])) $medida3=$_SESSION['medida3'];
else {$medida3=$_POST["medida3"]; $_SESSION['medida3']=$medida3;}
if(!isset($_POST["ano"])) $ano=$_SESSION['ano'];
else {$ano=$_POST["ano"]; $_SESSION['ano']=$ano;}
if(!isset($_POST["estado"])) $estado=$_SESSION['estado'];
else {$estado=$_POST["estado"]; $_SESSION['estado']=$estado;}
if(!isset($_POST["barra"])) $barra=$_SESSION['barra'];
else {$barra=$_POST["barra"]; $_SESSION['barra']=$barra;}
if(!isset($_POST["reparaciones"])) $reparaciones=$_SESSION['reparaciones'];
else {$reparaciones=$_POST["reparaciones"]; $_SESSION['reparaciones']=$reparaciones;}
if(!isset($_POST["ubicacion"])) $ubicacion=$_SESSION['ubicacion'];
else {$ubicacion=$_POST["ubicacion"]; $_SESSION['ubicacion']=$ubicacion;}
if(!isset($_POST["precio"])) $precio=$_SESSION['precio'];
else {$precio=$_POST["precio"]; $_SESSION['precio']=$precio;}
if(!isset($_POST["duracion"])) $duracion=$_SESSION['duracion'];
else {$duracion=$_POST["duracion"]; $_SESSION['duracion']=$duracion;}
?>

<?php 
if(isset($_GET["avanzado"])){
	$clase=$_GET["claseav"];
	$num_enventa=$las_webs->avanzado_anuncios($clase,$tipo,$marca,$modelo,$medida1,$medida2,$medida3,$ano,$estado,$barra,$reparaciones,$ubicacion,$precio,$_SESSION['orden_b']);
}
?>

<?php include("cabecera.php");?>

<script language="Javascript"  type="text/javascript" src="<?php echo $_SESSION['base_href'].'javascript/overlib.js'; ?>"></script>
<script language="Javascript"  type="text/javascript" src="<?php echo $_SESSION['base_href'].'busqueda.js'; ?>"></script>
<script src="<?php echo $_SESSION['base_href'].'ajax/busqueda_ajax.js'; ?>"></script>
<!-- Add fancyBox -->
	
	<!--FIN DE LA CABECERA-->
	
	<?php echo"<input type='hidden' id='clasejs' name='".$clase."' value='".$clase."' />";?>
	
	<div id="contenedor_busq">
   	 	<div id="tit_busqueda">Anuncios Kitesurf publicados de <?php echo $clase; ?></div>
		<div id="opciones_busqueda">
		<form id="form_busqueda" name="formu" action="busqueda.php?avanzado=si&claseav=<?php echo $clase; ?>" method="post" enctype="multipart/form-data">
			<div id="tipo" class="texto_opcion">
				<div class="texto2">
					Tipo:
				</div>
				<div class="opcion">
					<select id="opciones_tipo" name="tipo">
						<option></option>
					</select>
				</div>
			</div>
			<div class="rompedor"></div>
			<div class="texto_opcion">
				<div class="texto2">
					Marca:
				</div>
				<div class="opcion">
					<input type="text" size="22" name="marca" value="<?php echo $marca; ?>" />
				</div>
			</div>
			<div class="rompedor"></div>
			<div class="texto_opcion">
				<div class="texto2">
					Modelo:
				</div>
				<div class="opcion">
					<input type="text" size="22" name="modelo" id="modelo_input" value=""/>
				</div>
			</div>
			<div class="rompedor"></div>
			<div class="texto_opcion">
				<div class="texto2">
					Medida:
				</div>
				<div class="opcion">
					<div  id="medidadeloscojones" ></div>
				</div>
			</div>
			<div class="rompedor"></div>
			<div class="texto_opcion">
				<div class="texto2">
					A&ntilde;o:
				</div>
				<div class="opcion">
					<input type="text" size="4" name="ano" value="" class="isNum"/>
					<span>&nbsp; ejemplo: 2010</span>
				</div>
			</div>
			<div class="rompedor"></div>
			<div class="texto_opcion">
				<div class="texto2">
					Estado:
				</div>
				<div class="opcion">
					<input type="radio" name="estado" value="nuevo" /> Nuevo
					&nbsp;&nbsp;
					<input type="radio" name="estado" value="usado" /> Usado
				</div>
			</div>
			
			<div class="rompedor"></div>
			<div id="incluye_barra" class="texto_opcion">
				<div class="texto2">
					Barra:
				</div>
				<div class="opcion">
					<input type="radio" name="barra" value="si"/> Si
					&nbsp;&nbsp;
					<input type="radio" name="barra" value="no" /> No
				</div>
			</div>
			
			<div class="rompedor"></div>
			<div id="reparaciones" class="texto_opcion">
				<div class="texto2">
					Reparaciones:
				</div>
				<div class="opcion">
					<input type="radio" name="reparaciones" value="si" /> Si
					&nbsp;&nbsp;
					<input type="radio" name="reparaciones" value="no"  /> No
				</div>
			</div>
			<div class="rompedor"></div>
			<div class="texto_opcion">
				<div class="texto2">
					Provincia:
				</div>
				<div class="opcion">
					<?php
						$localidades=$las_webs->dame_las_localidades();
						echo "<select name='ubicacion' >";
							if(isset($_POST["ubicacion"]) and $_POST["ubicacion"]!='')
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
			<div class="rompedor"></div>
			<div class="texto_opcion">
				<div class="texto2">
					Precio:
				</div>
				<div class="opcion">
					<input type="text" size="5" name="precio" maxlength="5" value="" class="isNum"/> &nbsp;€
				</div>
			</div>
			
			<div class="texto_opcion">
				<input type="submit" value="Buscar" />
			</div>
		</form>
			
			<div class="texto_opcion">
				<form id="form_busqueda2" name="formu2" action="busqueda.php?clase=<?php echo $clase; ?>" method="post" >
					<input type="submit" value="Mostrar todos los art&iacute;culos" />
				</form>
			</div>					
		</div>
	
	
		<div id="bloque_busq">
			<div id="orden_datos">
				<div id="ordenar_busqueda">
					<form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" class="muestra_users">	
					Ordenar por: 			
						<select name="orden_b" onchange="this.form.submit();">
							<?php
								if($_SESSION['orden_b']=="")
									echo "<option value='bump' selected='selected'>bump!</option> />";
								else
									echo "<option value='".$_SESSION['orden_b']."' selected='selected'>".$_SESSION['orden_b']."</option> />";
							?>
							<option value="bump">bump!</option> 
							<option value="fecha">fecha</option> 
							<option value="precio">precio</option>
						</select>
						<span id="info_bump">&nbsp;&iquest;que es bump?</span>
					</form>
					
				</div>
				<div id="datos_busqueda" ><?php echo $_pagi_totalReg; ?> anuncios encontrados</div>
			</div>
			<div id="contenedor_anuncios">
			<?php
				for($i=0;$i<$num_enventa;$i++){/*
					echo "<table class='tabla'  id=tabla".$i.">
						<tr>
							<td rowspan='2' class='celda_imagen'>
								<a class='fancybox' href='".$matriz_resultado3[$i]['direcc_imagen']."'>
								<img src='/imagenes/redimensionar.php?imagen=".$matriz_resultado3[$i]['direcc_imagen']."' />
								</a>
							</td>
							<td rowspan='2'class='celda_titulo'><a href='anuncio/".$matriz_resultado3[$i]['cod_anuncio']."'>".$matriz_resultado3[$i]['titulo']."</a></td>
							<td class='celda_datos'>
								Expira:
								
							</td>
							<td rowspan='2' class='celda_datos_precio'>".$matriz_resultado3[$i]['precio']." €</td>
							<td  class='celda_datos' >
								".$matriz_resultado3[$i]['provincia']."					
							</td>
						</tr>
						<tr>
							<td class='celda_datos'>".$matriz_resultado3[$i]['fecha_cad']."</td>	
							";
							if($matriz_resultado3[$i]['nick']==$_SESSION['SESS_MEMBER_ID']){
								echo "<td>
									<form  class=bump id=bump".$i.">
										<input type='hidden' name=codan value=".$matriz_resultado3[$i]['cod_anuncio']." />
										<input type='submit' value='' />
									</form>
									</td>	";
							}
						echo "				
						</tr>
						</table>
						";
				}*/
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
                    <div class="bump">';
                    	if($matriz_resultado3[$i]['nick']==$_SESSION['SESS_MEMBER_ID']){
                            echo "
                                <form  class=bump id=bump".$i.">
                                    <input type='hidden' name=codan value=".$matriz_resultado3[$i]['cod_anuncio']." />
                                    <input type='submit' value='' />
                                </form>
                                ";
                        }
					echo '
                    </div>					
                </div>
				<div class="info2">
					'.$matriz_resultado3[$i]['precio'].'€
				</div>
				<div style="clear:both"></div>
            </div>';
			}
			?>
            
			</div>
					
			<?php echo"<p id='pagi_navegacion'>".$_pagi_navegacion."</p>"; ?>
			<div style="clear:both"></div>
		</div><!--Final bloque_busq-->
		<div style="clear:both"></div>	
	</div>
	
	<div id="linea_verde5"></div>	
	
</div>

<div id="frame_pie"><?php include("pie.html");?></div>

</body>
</html>
