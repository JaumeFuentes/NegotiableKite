<?php  
include_once 'core/init.inc.php';
//$url = 'https://graph.facebook.com/369144093150754/feed?access_token=138100716293644|IIp6IKwqdR7fqDgXtbPosC6lu64';
if(!isset($_POST['grupo'])) $grupo="";
else {$grupo=$_POST['grupo']; $_SESSION['grupo']=$_POST['grupo'];}

if(!isset($_POST['palabras'])) $palabras="";
else $palabras=$_POST['palabras'];

if(!isset($_POST['grupo_busq'])) $grupo_busq="";
else $grupo_busq=$_POST['grupo_busq'];

include "facebook/php-sdk/src/facebook.php";

$facebook = new Facebook(array(
  'appId'  => '138100716293644',
  'secret' => '5e784bac8bb0400ab274356d2bc5358e',
));
$access_token = $facebook->getAccessToken();




//Recojo informaci�n de GRUPOS
$id_grupos = array("369144093150754","293435004055168","224762604201060","231190773586092","169454919734989",
					"244447822316112","140157306070805","168478639917220");
$_SESSION['id_grupos'] = $id_grupos;
					
if(!isset($_POST['grupo_busq']) or $grupo_busq=="este"){					
	if(!isset($_SESSION['grupo'])){	
		if($_SESSION['feed'][0]==""){				
			$feed=$facebook->api($id_grupos[0].'/feed','GET',array('acces_token' => $acces_token,'limit' => 200));
			$_SESSION['feed'][0]=$feed;
		}
		else
			$feed=$_SESSION['feed'][0];
		$info_grupo = $facebook->api($id_grupos[0]);
	}
	for($i=0;$i<count($id_grupos);$i++){
		if($_SESSION['grupo']==$i+1){
			$info_grupo = $facebook->api($id_grupos[$i]);
			if($_SESSION['feed'][$i]==""){
				$feed=$facebook->api($id_grupos[$i].'/feed','GET',array('acces_token' => $acces_token,'limit' => 200));
				$_SESSION['feed'][$i]=$feed;
			}
			else
				$feed=$_SESSION['feed'][$i];
		}
	}
	$foto_grupo = $info_grupo['icon'];
	$nombre_grupo = $info_grupo['name'];
	$cantidad_grupos = 1;
}
if($grupo_busq=="todos"){
	for($i=0;$i<count($id_grupos);$i++){
		if($_SESSION['feed'][$i]==""){
			$feed[$i]=$facebook->api($id_grupos[$i].'/feed','GET',array('acces_token' => $acces_token,'limit' => 200));
			$_SESSION['feed'][$i]=$feed[$i];
			}
			else
				$feed[$i]=$_SESSION['feed'][$i];
	}
	$cantidad_grupos = count($id_grupos);
}


function url($text){
        $text = html_entity_decode($text);
        $text = " ".$text;
        $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_+.~#?&//=]+)',
                '<a href="\1" target="_blank">\1</a>', $text);
        $text = eregi_replace('(((f|ht){1}tps://)[-a-zA-Z0-9@:%_+.~#?&//=]+)',
                '<a href="\1" target="_blank">\1</a>', $text);
        $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_+.~#?&//=]+)',
        '\1<a href="http://\2" target="_blank">\2</a>', $text);
        $text = eregi_replace('([_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3})',
        '<a href="mailto:\1">\1</a>', $text);
        return $text;
} 

//funcion para encontrar palabra o palabras en texto
function encuentra($texto,$palabras){
	$array_palabras= explode(',',$palabras);
	$long_array = count($array_palabras);
	for($i=0;$i<$long_array;$i++){
		if(stristr($texto,$array_palabras[$i])!=true)
			return false;		
	}
	return true;
}

?>

<?php include("cabecera.php");?>	

	<div id="bloque1">
		<div id="bloque1_1"> 
        
          	 <div id="cargando_fb">
       			 <img src="iconos/cargando.gif" />
        		<div id="texto_cargando">
              	  Debido a la gran cantidad de anuncios esta operacion puede tardar varios segundos, porfavor espere....
                </div>
   			 </div>    
             
        	<div id="tit_users">Buscador de anuncios en Facebook<span id="beta">Version beta 1.0</span></div>   
            	<div id="selecc_busca_fb">
                    <form action="" method="post" class="" id="grupos_fb">
                        <label></label>
                        <select id="select_grupo" name="grupo" onchange="this.form.submit();">    
                            <?php 
                            if(isset($_SESSION['grupo'])){
                                $info_grupo_option = $facebook->api($id_grupos[$_SESSION['grupo']-1]);
                                $nombre_grupo_option = $info_grupo_option['name'];
                                echo '<option value="'.$_SESSION['grupo'].' selected="selected">'.$nombre_grupo_option.'</option>';
                            }
                            else
                                echo '<option value="" selected="selected">Selecciona Grupo</option>';
                            for($i=0;$i<count($id_grupos);$i++){
                                $info_grupo_option = $facebook->api($id_grupos[$i]);
                                $nombre_grupo_option = $info_grupo_option['name'];
                                $j=$i+1;
                                echo'<option value="'.$j.'">'.$nombre_grupo_option.'</option>';
                            }
                            ?>			                       
                        </select>
                    </form>
                    
                    <form  action="" method="post" class="" id="buscar_grupos_fb">
                        <label></label>
                        <input id="text_busq_fb" type="text" maxlength="30" name="palabras" value="" placeholder="separar palabras con comas"/>
                        <input type="submit" value="Buscar" />
                        <input type="radio" value="este" name="grupo_busq" checked="checked"/> En este grupo
                        <input id="todos_grupos" type="radio" value="todos" name="grupo_busq" /> En todos los grupos
                    </form>
                    <script language="Javascript"  type="text/javascript" src="javascript/overlib.js"></script>                    			 					<script src="javascript/anuncios_fb.js"></script>						
                    <script src="javascript/jquery.placeholder.js"></script>
                    <script type="text/javascript">
						$('input, textarea').placeholder();
					</script>
                    
                    <?php					
						if($_SESSION['cargado'] != true)
							echo '<script src="ajax/afb_ajax.js"></script>';
					?>
                    
                    <div style="clear:both"></div>
                </div>   
                <div id="carga_grupos">
                    <img src="layout/barra_carga.gif" />
                </div>             
                <div id="ic_nom_grupo">         	
				<?php
				if($cantidad_grupos==1){			
					echo '<img src="'.$foto_grupo.'" id="icono_grupo_fb" />';
					echo '<span id="nombre_grupo_fb">'.$nombre_grupo.'</span>';
				}
				else{
					echo '<img src="layout/grupo_fb.png" id="icono_grupo_fb" />';
					echo '<span id="nombre_grupo_fb">TODOS LOS GRUPOS</span>';
				}
                ?>
            </div>
            
        <?php	
		
		if($cantidad_grupos==1){
			//echo "total anuncios".count($feed['data']);
		for($i=0;$i<count($feed['data']);$i++){
			$id_post = $feed['data'][$i]['id'];
			$direcc_post = "http://www.facebook.com/".$id_post;
			$posteador = $feed['data'][$i]['from']['name'];
			$id_posteador = $feed['data'][$i]['from']['id'];
			$foto_posteador = "https://graph.facebook.com/".$id_posteador."/picture";
			$message = $feed['data'][$i]['message'];
			$message = str_replace("€", "&euro;", $message);
			$message = utf8_decode($message);
			$message = url($message);
			
			$picture = $feed['data'][$i]['picture'];
			$link = $feed['data'][$i]['link'];
			$data = $feed['data'][$i]['created_time'];
			$year = substr($data,0,4);
			$month = substr($data,5,2);
			$day = substr($data,8,2);
			$time = substr($data,11,5);
			$data = $day."-".$month."-".$year." a las ".$time;
			
			
			if($palabras!="")
				$encontrado=encuentra($message,$palabras);
			
			if($encontrado or $palabras==""){
			
			echo '
			<div id="cont_anun_fb" class="anun_fb">
				<div id="prof_pic_fb">
					<img src="'.$foto_posteador.'" />
				</div>
				<div id="datos_anun_fb">
					<div id="user_fb">
						<a href="http://www.facebook.com/'.$id_posteador.'" target="_blank">'.$posteador.'</a>
					</div>
					<div id="links_fb">
						<div class="links">
							<a href="'.$direcc_post.'" target="_blank">Ver post</a>
						</div>
						<div class="links">';
							if($link!="")
								echo '<a href="'.$link.'" target="_blank">Ver link</a>';
							else
								echo '<span>Ver link</a>';
						echo'
						</div>
						<div class="links">
							Publicado el &nbsp; '.$data.'
						</div>
						<div style="clear:both"></div>
					</div>
					<div id="mens_anun_fb">
						'.$message.'
					</div>
					<div id="foto_anun_fb">
						';
						if($picture!=""){
							$picture_big = str_replace("s.jpg", "n.jpg;", $picture);							
							echo '
							<a class="fancybox" rel="group" href="'.$picture_big.'" style="display:none" >
								<img src="'.$picture.'" />
							</a>';							
						}
					echo '
					</div>
				</div>
				<div style="clear:both"></div>
			</div>';		}	
		}
		}
		
		if($cantidad_grupos>=2){
			/*$can_anun=0;
			for($k=0;$k<$cantidad_grupos;$k++){
				$can_anun=$can_anun+count($feed[$k]['data']);
			}
			echo "total anuncios".$can_anun;*/
			for($j=0;$j<$cantidad_grupos;$j++){
				for($i=0;$i<count($feed[$j]['data']);$i++){
					$id_post = $feed[$j]['data'][$i]['id'];
					$direcc_post = "http://www.facebook.com/".$id_post;
					$posteador = $feed[$j]['data'][$i]['from']['name'];
					$id_posteador = $feed[$j]['data'][$i]['from']['id'];
					$foto_posteador = "https://graph.facebook.com/".$id_posteador."/picture";
					$message = $feed[$j]['data'][$i]['message'];
					$message = str_replace("€", "&euro;", $message);
					$message = utf8_decode($message);
					$message = url($message);
					
					$picture = $feed[$j]['data'][$i]['picture'];
					$link = $feed[$j]['data'][$i]['link'];
					$data = $feed[$j]['data'][$i]['created_time'];
					$year = substr($data,0,4);
					$month = substr($data,5,2);
					$day = substr($data,8,2);
					$time = substr($data,11,5);
					$data = $day."-".$month."-".$year." a las ".$time;
					
					
					if($palabras!="")
						$encontrado=encuentra($message,$palabras);
					
					if($encontrado or $palabras==""){
					
					echo '
					<div id="cont_anun_fb" class="anun_fb">
						<div id="prof_pic_fb">
							<img src="'.$foto_posteador.'" />
						</div>
						<div id="datos_anun_fb">
							<div id="user_fb">
								<a href="http://www.facebook.com/'.$id_posteador.'" target="_blank">'.$posteador.'</a>
							</div>
							<div id="links_fb">
								<div class="links">
									<a href="'.$direcc_post.'" target="_blank">Ver post</a>
								</div>
								<div class="links">';
									if($link!="")
										echo '<a href="'.$link.'" target="_blank">Ver link</a>';
									else
										echo '<span>Ver link</a>';
								echo'
								</div>
								<div class="links">
									Publicado el &nbsp; '.$data.'
								</div>
								<div style="clear:both"></div>
							</div>
							<div id="mens_anun_fb">
								'.$message.'
							</div>
							<div id="foto_anun_fb">
								';
								if($picture!=""){
									$picture_big = str_replace("s.jpg", "n.jpg;", $picture);							
									echo '
									<a class="fancybox" rel="group" href="'.$picture_big.'">
										<img src="'.$picture.'" />
									</a>';							
								}
							echo '
							</div>
						</div>
						<div style="clear:both"></div>
					</div>';		}	
				}
			}
		}
		
?>     
		</div>
		
	</div>
</div>

<div id="frame_pie"><?php include("pie.html");?></div>


<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.0" type="text/css" media="screen" />
<script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js?v=2.1.0"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.3" type="text/css" media="screen" />
<script type="text/javascript" src="/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.3"></script>
<script type="text/javascript" src="/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.3"></script>

<link rel="stylesheet" href="/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.6" type="text/css" media="screen" />
<script type="text/javascript" src="/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.6"></script>

</body>
</html>


    
	  