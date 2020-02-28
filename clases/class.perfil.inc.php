<?php
class perfil extends DB_Connect{
	/**
	 * El nick del usuario a partir del cual se crea el perfil	 
	 *
     * @var string el nick del usuario
	 */
	private $user;	
	/**
	 * Media de todos los votos recibidos por el usuario
	 *
     * @var int media de votos
	 */
	private $votacion;
	
	/**
	 * El nombre del usuario el cual es el nick si es particular o tienda si es negocio
	 *
     * @var string el nombre del usuario/negocio
	 */
	private $nom_usuario;
	
	/**
	 * Se conecta a la base de datos y guarda el nick del usuario
	 *	 	 
	 * @param string $user el nick del usuario
	 * @return void
	 */	
	 	 
	function __construct($user){
		if($user){
			$this->user = $user;	
			//por defecto usamos el nick del usuario.
			// si es tienda lo cambiamos por el nombre de la tienda
			$this->nom_usuario = $user;
		}
		parent::__construct();		
	}
	
	
	/**
	 * Carga los datos de la tabla users y lo guarda en un array
	 * Tambien busca a partir del codigo de usuario (cod_user)
	 * las imagenes de perfil del usuario/tienda y las agrega al array.
	 *
	 * @param string $nick Es el nick del usuario
	 * @return array devuelve un array de datos del usuario de la base de datos
	 */
	public function loadUserData($nick){
		$query = "SELECT cod_usuario, provincia, email, puntuacion_vend, es_tienda, foto_perfil, estado, web, facebook, twitter
				FROM users WHERE nick ='$nick' AND estado ='0'";
		$row = mysql_query($query);
		if(mysql_num_rows($row)>=1){
			$datos_user = mysql_fetch_assoc($row);	
			if($datos_user['foto_perfil']=="")
				$datos_user['foto_perfil'] = "icono_perfil.png";
		}
		
		/*
		 * A partir del codigo de usuario encontrado buscamos en la
		 * tabla imagenes_prefil las direcciones de las imagenes
		 */
		 if($datos_user['cod_usuario']){
			$cod_usuario = $datos_user['cod_usuario'];
			$query = "SELECT direccion FROM imagenes_perfil WHERE cod_usuario = '$cod_usuario'";
			$row = mysql_query($query);
			while($datos = mysql_fetch_row($row))
				$direccion[] = $datos[0];
				
			/*
			 * Comprobamos si el usuario tiene imagenes principales publicadas.
			 * Si las tiene lo dejamos como esta y si no le indicamos la direccion
			 * url a no_foto
			 */			 
			for($i=0;$i<=2;$i++){
				if($direccion[$i]=="")
					$direccion[$i] = "no_foto.png";
			}
			
			/*
			 * Añadimos las imagenes al array
			 */	
			$datos_user['imagen1'] = $direccion[0];
			$datos_user['imagen2'] = $direccion[1];
			$datos_user['imagen3'] = $direccion[2];
		 }
		
		return $datos_user;		
	}
	
	
	public function loadDataSimple($dato_a_buscar,$tabla,$where,$referencia){
		$query = "SELECT ".$dato_a_buscar." FROM ".$tabla." WHERE ".$where." ='$referencia'";
		$row = mysql_query($query);
		if(mysql_num_rows($row)>=1){
			$datos_user = mysql_fetch_assoc($row);			
			return $datos_user[$dato_a_buscar];
		}
		else
			return false;
	}
	
	/**
	 * Carga los datos de la tabla tiendas y lo guarda en un array	 
	 *
	 * @param string $email es el email de la tienda que tiene que coincidir
	 * con el email del usuario en la tabla users
	 * @return array devuelve un array de datos de la tienda
	 */
	public function loadTiendaData($email){
		$query = "SELECT nombre_tienda, provincia, localidad, direccion, web, telefono, email, descripcion, marcas
				FROM tiendas WHERE email = '$email'";
		$row = mysql_query($query);
		$datos_tienda = mysql_fetch_assoc($row);	
		//$marcas = explode(',',$datos_tienda['marcas']);	
		$datos_tienda['cod_marcas_comas'] = $datos_tienda['marcas'];
		$datos_tienda['marcas'] = explode(',',$datos_tienda['marcas']);	
		
		if($datos_tienda)
		$this->nom_usuario =$datos_tienda['nombre_tienda'];
		
		return $datos_tienda;
	}
	
	private function generaListaMarcas($cod_marcas,$editar){
		foreach($cod_marcas as $cod_marca){
			$query = "SELECT marca, web FROM marcas WHERE cod_marcas = '$cod_marca'";
			$row = mysql_query($query);
			$result = mysql_fetch_assoc($row);
			if($result["marca"]){
				if(!$editar)
					echo '<div id="marca'.$cod_marca.'" class="marcas2">
							<a href="'.$result["web"].'">'.$result["marca"].'</a>
						  </div>';
				else
					echo '<div id="marca'.$cod_marca.'" class="marcas2">
						 	'.$result["marca"].'
							<span id="deleteMarca'.$cod_marca.'"class="deleteMarca">X</span>
						  </div>';
			}
		}			
	}
	
	
	/**
	 * Carga los datos de los anuncios publicados por el usuario y los guarda en una matriz	 
	 *
	 * Para encontrar la direccion de las imágenes  se busca en la tabla imagenes
	 * 
	 * @param int $cod_usuario es el codigo del usuario	
	 * @return array devuelve una matriz con los datos de un máximo de cuatro anuncios publicados por el usuario
	 */
	private function loadAnuncios($cod_usuario){
		if($cod_usuario){
			$momento_actual = $this->hora_actual();
			$query = "SELECT cod_articulo, cod_anuncio, titulo FROM anuncio WHERE
					 cod_usuario = '$cod_usuario' AND fecha_cad>'$momento_actual' LIMIT 5";
			$row = mysql_query($query);
			
			/*
			 * Iniciamos el bucle para crear la matriz.
			 * Al mismo tienpo en cada pasada buscamos en la tabla imagenes para ver si el articulo tiene
			 * una imagen publicada, y si es asi añadir la url al array.
			 */		
			while($datos = mysql_fetch_row($row)){
				/*
				 * Buscamos a ver si el artículo tiene imágenes
				 */
				$query2 = "SELECT direcc_imagen FROM imagenes WHERE cod_articulo = '$datos[0]' AND imagen_principal = '1'";
				$row2 = mysql_query($query2);
				$fetch = mysql_fetch_assoc($row2);
				$direcc_imagen = $fetch['direcc_imagen'];		
				/*
				 * Si no tiene imagen la variable $direcc_imagen estará vacío
				 */	
				 if($direcc_imagen=="")
				 	$direcc_imagen = "imagenes/icono-camara.jpg";
				$datos_anuncio[] = array("cod_articulo"=>$datos[0],"cod_anuncio"=>$datos[1],
				"titulo"=>$datos[2],"direcc_imagen"=>$direcc_imagen);
			}
			return $datos_anuncio;
		}
	}
	
	public function bloqueAnunPubl($cod_usuario){
		$anuncioData = $this->loadAnuncios($cod_usuario);
		$i=0;
		if(count($anuncioData)>=1){
				foreach($anuncioData as $anuncio){
					if($i<=3){
						if(strlen($anuncio['titulo'])>23)					
							$titulo_anuncio = substr($anuncio['titulo'],0,23)."...";
						else
							$titulo_anuncio = $anuncio['titulo'];
							
						echo '
				<div class="caja_enventa">
					<div class="titulo">
						<a href="anuncio/'.$anuncio['cod_anuncio'].'">'.$titulo_anuncio.'</a>
					</div>
					<div class="caja_imagen"><img src="imagenes/redimensionar.php?anchura=126&hmax=100&imagen='.$anuncio['direcc_imagen'].'" /></div>
				</div>';
					$i++;
					}
				}
				if(count($anuncioData)>4)
					echo '
			<div style="clear:both"></div>
			<br />
            <a href="en_venta_publ?user='.$this->user.'">Ver mas anuncios publicados por '.$this->nom_usuario.'</a>';
			
			}
			else
				echo $usuario." no tiene ning&uacute;n anuncio publicado";
			
			echo '
			 <div style="clear:both"></div>
			 <br />';
	}
	
	
	
	/**
	 * Carga los datos de las puntuaciones realizadas por los usuarios y las guarda en una matriz	 
	 *
	 * Además calcula la media de los votos recibidos y lo guarda en la variable $votacion,
	 * perteneciente a la clase
	 * 
	 * @param int $cod_usuario es el codigo del usuario	
	 * @return array devuelve una matriz con los datos de las votaciones y comentarios recibidos
	 */
	private function loadPuntuaciones($cod_usuario){
		$suma_puntos = 0;
		$cant_votos = 0;
		$query = "SELECT votador, fecha_voto, voto, comentario, tit_coment FROM puntuacion_vendedor WHERE votado = '$cod_usuario'";
		$row = mysql_query($query);
		while( $resultado = mysql_fetch_row($row)){
			
			$query2 = "SELECT nick FROM users WHERE cod_usuario = '$resultado[0]'";
			$row2 = mysql_query($query2);
			$fetch = mysql_fetch_assoc($row2);
			$nick_votador = $fetch['nick'];
			
			$urlStar = $this->urlStar($resultado[2]);
			
			$fecha_voto = date("d/m/Y",$resultado[1]);
			
			$datos_puntos[] = array ("votador"=>$nick_votador,"fecha_voto"=>$fecha_voto,
			"voto"=>$resultado[2],"comentario"=>$resultado[3],"titulo"=>$resultado[4],"urlStar"=>$urlStar);
			$suma_puntos += $resultado[2];
			$cant_votos++;
		}
		/*
		 * guardamos la media de los votos
		 */
		 if($cant_votos>=1)
			$this->votacion = $suma_puntos/$cant_votos;	
		 else			
		 	$this->votacion = 0;	
		return $datos_puntos;
	}
	
	public function InsertComment($nick_votado,$nick_votador,$fecha_voto,$voto,$comentario,$tit_coment){
		if($nick_votado and $nick_votador and $fecha_voto and $voto and $comentario and $tit_coment){
			$cod_votado = $this->loadDataSimple('cod_usuario','users','nick',$nick_votado);
			$cod_votador = $this->loadDataSimple('cod_usuario','users','nick',$nick_votador);
			$query = "INSERT INTO puntuacion_vendedor (votado, votador, fecha_voto, voto, comentario, tit_coment)
					  VALUES ('".$cod_votado."','".$cod_votador."','".$fecha_voto."','".$voto."','".$comentario."','".$tit_coment."')";
			$result = mysql_query($query) or die(mysql_error());
			return true;
		}
		else
			return false;
	}
		
	
	
	/**
	 * Devuelve la direccion de la imagen de las estrellitas equivalente a la puntuacion	 
	 *	
	 * @param int $puntuacion es un numero del 0 al 10	
	 * @return array devuelve un array con la direccion de la imagen de las estrellitas
	 */
	private function urlStar($puntuacion){
		for($i=1; $i<=10;$i++){
			if($puntuacion<=$i){
				$num = $i;
				break;
			}
		}
		return $urlStar = "layout/estrellas/stars".$num.".gif";
	}
	
	
	//función que imprime el bloque de estrellitas
	public function starsBlock($cod_uauario){
		$puntuacionesData = $this->loadPuntuaciones($cod_uauario);		
		$urlStarMedia = $this->urlStar($this->votacion);
		echo '
		 <div id="estrellas">';
					if(count($puntuacionesData)<=0)
						echo '
						<img src="../layout/estrellas/stars0.gif" title="'.$usuario.' no ha recibido ningun voto" />
						<br />Sin votos';
					else{
						echo '	
                    	<img alt="'.$this->votacion.'" title="'.$this->votacion.'" src="'.$urlStarMedia.'" />
						<br />'.count($puntuacionesData).' ';
						(count($puntuacionesData) == 1) ? $voto = 'Voto' : $voto = 'Votos';
						echo $voto;
					}
						
					echo '
                    </div><!--Fin del div estrellas-->';
	}
	
	
	/**
	 * Devuelve un string con el formulario para enviar los comentarios y las puntuaciones	 
	 *
	 * Comprueba si el usuario ha iniciado sesión o no
	 * 	 
	 * @return string devuelve un string con el formulario para comentarios
	 */
	private function formulario(){
		
		if($_SESSION['SESS_MEMBER_ID'])
			$submit = '<input type="submit" value="Enviar" />';
		else
			$submit = '<p>Debes de <a href="login">Ininiciar sesi&oacute;n</a> primero para poder enviar comentarios</p>';
			
		$formulario = '
		<div id = "inluyeOpinion">
		<form action="" method="post" name="formOpinion" id="formOpinion">           		          
                <div class="formComentario">
                   <div style="display:none;" class="confirmOpina" id="confirmOpina">&nbsp;</div>
                   <div style="display:none;" class="errorAnuncio" id="opinaError">&nbsp;</div>
                   <div style="display:none;width:520px;border:1px solid blue;" id="sendOpinaBox">&nbsp;</div>
                   <p>
                       <strong><label for="idArgumento">A&ntilde;ade tu comentario:</label></strong>
                   </p>
				   <input type="hidden" name="nick_votado" value="'.$this->user.'" />
                   <input type="text" name="tit_coment" id="idTitleOpinion" class="reqd"/>
                   <select name="puntos" id="idRating" class="reqd">
                      <option value="-1" selected="">Puntua</option>                      
                      <option value="1">1 - Muy malo</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>
                      <option value="9">9</option>
                      <option value="10">10 - ExcelenteExcelente</option>
                   </select>
                   <textarea name="comentario" maxlength="3000" class="Inputrespuesta reqd" id="idOpinion" type="text"></textarea>	
				  '.$submit.'
				  </div>
            </form>
			</div>';
		return $formulario;
	}
	
	/**
	 * Imprime un texto de error si un usuario intenta contactar con vendedor sin estar registrado 
	 *	 
	 * 	 
	 * @return void solo imprime texto de error
	 */
	private function error($usuario){
		echo'
			<div class="error_perfil">
				<h3>
					Lo sentimos pero no hemos encontrado el perfil de '.$usuario.'. Esto puede deberse a dos causas:
				</h3>
				<ul>
					<li>
						 '.$usuario.' no est&aacute; registrado en Negotiable Kite
					</li>
					<li>
						Si que est&aacute; registrado pero no ha activado su cuenta
					</li>
				</ul>
			</div>';
	}
	
	
	public function insertPerfilImage($fichero,$num_img){
		$cod_usuario = $this->loadDataSimple('cod_usuario','users','nick',$_SESSION['SESS_MEMBER_ID']);
		$lnguser = strlen($_SESSION['SESS_MEMBER_ID']);
		$k = 23 + $lnguser;
		$ficheroTrim = substr($fichero,0,$k);
		
		if($num_img == "imagen1"){
			$tabla = "users";
			$campo = "foto_perfil";
			$query = "UPDATE ".$tabla." SET ".$campo." = '$fichero' WHERE cod_usuario = '$cod_usuario'";
			mysql_query($query) or die(mysql_error());
		}
		else{
			$tabla = "imagenes_perfil";
			$campo = "direccion";
			$query = "SELECT ".$campo." FROM ".$tabla." WHERE ".$campo." LIKE '%".$ficheroTrim."%'";
			$result = mysql_query($query)  or die(mysql_error());
			if(mysql_num_rows($result)>=1){
				$query = "UPDATE ".$tabla." SET ".$campo." = '$fichero' 
						  WHERE ".$campo." LIKE '%$ficheroTrim%' AND cod_usuario = '$cod_usuario'";
				mysql_query($query) or die(mysql_error());
			}
			else{
			$query = "INSERT INTO ".$tabla." (".$campo.",cod_usuario) VALUES ('".$fichero."','".$cod_usuario."') "; 
			mysql_query($query)  or die(mysql_error());
			}
		}
	}
	
	public function updateUserData($arrData,$user){
		if ( is_array($arrData) ){
			$las_webs = new webs;
			foreach($arrData as $data)
				$data = $las_webs->clean2($data);
			$query = "UPDATE users SET provincia = '".$arrData['provincia']."', web = '".$arrData['web']."',
					  facebook = '".$arrData['facebook']."', twitter = '".$arrData['twitter']."' WHERE nick = '$user'";
			mysql_query($query)  or die(mysql_error());
			
			$query = "UPDATE tiendas SET descripcion = '".$arrData['descripcion']."', marcas = '".$arrData['marcas']."',
					  direccion = '".$arrData['direccion']."', localidad = '".$arrData['localidad']."',
					  provincia = '".$arrData['provincia']."', telefono = '".$arrData['telefono']."',
					  web = '".$arrData['web']."' WHERE email = '".$_SESSION['SESS_MEMBER_EMAIL']."' ";
			mysql_query($query)  or die(mysql_error());
			return true;
		}
	}
		
	
	private function Optionmarcas(){
		$query = "SELECT cod_marcas, marca FROM marcas ORDER BY marca";
		$result = mysql_query($query) or die(mysql_error());
		while($registro = mysql_fetch_row($result)){			
			$Optionmarcas .= "<option name='hola' value=".$registro[0].">".$registro[1]."</option>";
		}
		echo $Optionmarcas;
	}
	
		
	/*------------------FUNCION PARA LA HORA ACTUAL-------------------------*/

		function hora_actual(){
			$hora_publ=strftime("%H");
			$minuto_publ=strftime("%M");
			$segundo_publ=strftime("%S");
			$dia_publ=strftime("%d");
			$mes_publ=strftime("%m");
			$ano_publ=strftime("%Y");
			$momento_actual_mktime=mktime($hora_publ,$minuto_publ,$segundo_publ,$mes_publ,$dia_publ,$ano_publ);
			$momento_actual=strftime("%Y-%m-%d %H:%M:%S",$momento_actual_mktime);
			return $momento_actual;
		}
		
	
	public function generaPerfil(){
		$userData = $this->loadUserData($this->user);
		if(count($userData)<=0){
			$this->error($this->user);
			exit;
		}		
		//$anuncioData = $this->loadAnuncios($userData['cod_usuario']);
		$puntuacionesData = $this->loadPuntuaciones($userData['cod_usuario']);		
		$urlStarMedia = $this->urlStar($this->votacion);
		
		if($userData['es_tienda']==1){
			$tiendaData = $this->loadTiendaData($userData['email']);			
			$usuario = $tiendaData['nombre_tienda'];
			$direccion = $tiendaData['direccion'].", ".$tiendaData['localidad']."  (".$tiendaData['provincia'].")";
			$web = $tiendaData['web'];
			$tipo = "tienda";
		}
		else{
			$usuario = $this->user;
			$direccion = $userData['provincia'];
			$web = $userData['web'];
			$tipo = "particular";
		}
			
		echo '			
			<div id="tit_users">Perfil p&uacute;blico de '.$usuario.'</div>
            
            <div id="perfil_top">
            	<div id="izda"><!-- Inicio div Izda -->
                	<div id="foto_perfil">
                    	<img src="fotos_perfil/redimensionar.php?anchura=100&hmax=100&imagen='.$userData["foto_perfil"].'" />
                    </div>
                    <div class="op_con">
                    	<a href="perfil/'.$this->user.'#verComentarios">Opina</a>
                    </div>
                    <div class="op_con">
                    	<a href="contact_perfil.php?to='.$this->user.'&iframe=true&amp;width=530&amp;height=420" rel="prettyPhoto">Contacta</a>
                    </div>
                    <div id="estrellas">';
					if(count($puntuacionesData)<=0)
						echo '
						<img src="../layout/estrellas/stars0.gif" title="'.$usuario.' no ha recibido ningun voto" />
						<br />Sin votos';
					else{
						echo '	
                    	<img alt="'.$this->votacion.'" title="'.$this->votacion.'" src="'.$urlStarMedia.'" />
						<br />'.count($puntuacionesData).' ';
						(count($puntuacionesData) == 1) ? $voto = 'Voto' : $voto = 'Votos';
						echo $voto;
					}
						
					echo '
                    </div><!--Fin del div estrellas-->
                </div><!-- Fin div Izda -->
                <div id="dcha">
                	<div id="nombre">
                    	'.$usuario.' <span class="'.$tipo.'">'.$tipo.'</span>
                    </div>
                    <div id="bloque_fotos_tienda">
                    	<div class="foto_tienda">
							<a class="fancybox" href="'.$userData["imagen1"].'">
                        		<img src="imagenes_perfil/redimensionar.php?anchura=164&hmax=146&imagen='.$userData["imagen1"].'" />
							</a>
                        </div>
                        <div class="foto_tienda">
							<a class="fancybox" href="'.$userData["imagen2"].'">
                        	<img src="imagenes_perfil/redimensionar.php?anchura=164&hmax=146&imagen='.$userData["imagen2"].'" />
							</a>
                        </div>
                        <div class="foto_tienda">
							<a class="fancybox" href="'.$userData["imagen3"].'">
                        		<img src="imagenes_perfil/redimensionar.php?anchura=164&hmax=146&imagen='.$userData["imagen3"].'" />
							</a>
                        </div>
                    </div><!-- Fin del bloque fotos tienda -->
                </div><!-- Fin del bloque dcha -->
                <div style="clear:both"></div>
            </div><!-- Fin de perfil top-->';
			if($userData['es_tienda']==1){
				echo '
			<div class="des_marc">
            	<span class="dif">Descripci&oacute;n de la tienda:</span><br /> '.$tiendaData['descripcion'].'
            </div>
             <div class="des_marc">
             	<div class="dif marcas">Marcas:</div>';
			
				//introduzco el array de marcas y digo que false editar.
               $this->generaListaMarcas($tiendaData['marcas'],false);			   
			   echo '
                <div style="clear:both"></div>
            </div>';
			}
			echo '
			 <div class="registro perfil">
            	Ubicaci&oacute;n y contacto
            </div>
            
            <div class="des_marc">
                <span class="dif">Direcci&oacute;n:&nbsp;</span>'.$direccion.'
            </div>';
			if($userData['es_tienda']==1)
				echo '
            <div class="des_marc">
                <span class="dif">Email:&nbsp;</span>'.$userData['email'].'
            </div>			
            <div class="des_marc">
                <span class="dif">Tel&eacute;fono:&nbsp;</span>'.$tiendaData['telefono'].'
            </div>';
			echo '
            <div class="des_marc">
                <span class="dif">Web:&nbsp;</span><a href="'.$web.'" target="_blank">'.$web.'</a>
            </div>
            <div class="des_marc">
                <span class="dif">Facebook:&nbsp;</span><a href="'.$userData['facebook'].'" target="_blank">'.$userData['facebook'].'</a>
            </div>
            <div class="des_marc">
                <span class="dif">Twitter:&nbsp;</span><a href="'.$userData['twitter'].'" target="_blank">'.$userData['twitter'].'</a>
            </div>
            
            <div class="registro perfil">
            	Art&iacute;culos a la venta en Negotiable Kite
            </div>';			
            $this->bloqueAnunPubl($userData['cod_usuario']);
			
            echo '
             <div class="registro perfil">
            	Opiniones sobre '.$usuario.'
             </div>            
            
             <a class="ancor" style="text-decoration:none;" name="verComentarios"> </a>';
			 
			 //Bloque comentarios
			 if(count($puntuacionesData)<=0)
			 	echo $usuario." todav&iacute;a no ha recibido ning&uacute;n comentario. Se el primero!";
			 else{
				 foreach($puntuacionesData as $puntuacion){
					 echo '
					 <div class="comentarios">
              <div class="commentTiendaBox hreview">
                 <div class="commentTiendaLeft">
                 	<img alt=""  src="layout/comillas.gif">
                 </div>
                 <div>
                    <p class="bold">'.$puntuacion['titulo'].'
                    	<img alt="'.$puntuacion['voto'].'" title="'.$puntuacion['voto'].'" src="'.$puntuacion['urlStar'].'" class="rating">
                    </p>
                    <p class="description  text">
                    	'.$puntuacion['comentario'].'
                    </p>
                    <p class="reviewer dequien"><a href="perfil/'.$puntuacion['votador'].'">'.$puntuacion['votador'].'</a></p>
					<span class="dtreviewed dequien">'.$puntuacion['fecha_voto'].'</span>
                 </div>
              </div>
           </div>';
				 }
			 }
			 //Fin de los comentarios
			 
			 echo '
			 <div style="clear:both"></div>
			 <div id="addComment">
				 <div id="conoces_a" class="commentTiendaBox">
				  <div class="commentTiendaLeft">
					<img alt=""  src="layout/comillas.gif">
				  </div>
				  <div>
					 <p class="description  text">
						  &iquest;Conoces a <strong>'.$usuario.'</strong>, tienes experiencias que contar? A&ntilde;ade tu opini&oacute;n.
					 </p>
				  </div>
			   </div>';
			   echo $this->formulario();
			 echo '
			 </div>';//fin de add comment		
	}
	
	public function generaEditaPerfil(){
		$userData = $this->loadUserData($this->user);
		if(count($userData)<=0){
			$this->error($this->user);
			exit;
		}		
				
		$las_webs = new webs;
		$provincias=$las_webs->dame_las_localidades();
		if($userData['es_tienda']==1){
			$tiendaData = $this->loadTiendaData($userData['email']);			
			$usuario = $tiendaData['nombre_tienda'];			
			$provinciaData = $tiendaData['provincia'];
			$web = $tiendaData['web'];
		}
		else{
			$usuario = $this->user;			
			$provinciaData = $userData['provincia'];
			$web = $userData['web'];
		}
			
		echo '			
			<div id="tit_users">Edita los datos de tu perfil</div>
            
            <div id="perfil_top">
            	<div id="izda">
                	<div id="foto_perfil">
						<div id="preview1">
                    		<img id="thumb1" src="fotos_perfil/redimensionar.php?anchura=100&hmax=100&imagen='.$userData["foto_perfil"].'" />
						</div>
                    </div>			
					<div class="upload_img"	>	
						<form action="image_upload_ajax.php?num_imagen=ver1" id="newHotnessForm1">		
							<input type="file" size="20" id="imageUpload1" class="">  
						</form>
					</div>
                </div>
				
                <div id="dcha">
                	<div id="nombre">
                    	'.$usuario.'
                    </div>
                    <div id="bloque_fotos_tienda">';					
					
					/****************************************************/
					for($i=1;$i<=3;$i++){
						$j = $i+1;						
						echo '
						<div style="float:left">
							<div class="foto_tienda editar">
								<div id="preview'.$j.'">
									<a id="href'.$j.'" class="fancybox" href="'.$userData["imagen".$i].'">
										<img id="thumb'.$j.'" src="imagenes_perfil/redimensionar.php?anchura=164&hmax=146&imagen='.$userData["imagen".$i].'" />
									</a>
								</div>							
							</div>
							<div style="clear:both"></div>							
							
							<div class="upload_img"	style="margin-top:5px;">	
								<form action="image_upload_ajax.php?num_imagen=ver'.$j.'" id="newHotnessForm'.$j.'">		
									<input type="file" size="20" id="imageUpload'.$j.'" class="">  
								</form>
							</div>							
						
						</div>';}
					/****************************************************/
                     
						
					echo '	
                    </div><!-- Fin bloque fotos tienda-->
                </div><!-- Fin bloque derecha-->
				
                <div style="clear:both"></div>
            </div><!-- Fin de perfil top-->';
			
			/*****************************************************************************************************/
			echo '<form id="editaPerfil">
				  <!-Esto se usa para indicar al javascript que dato emplear dependiendo de si el perfil es tienda o particular -->
				  <input type="hidden" name="es_tienda" value="'.$userData['es_tienda'].'" />';
			
			if($userData['es_tienda']==1){
				echo '
			<div class="des_marc">
            	<span class="dif">Descripci&oacute;n de la tienda:</span><br />
				<textarea id="descripcion" name="descripcion">'.str_replace('<br />', "\n",$tiendaData['descripcion']).'</textarea>
            </div>
			
			 <div class="des_marc">
			 	A&ntilde;ade las marcas de tu tienda / negocio:
			 	<select id="select_marcas">
					<option value="-1">A&ntilde;ade marcas</option>';
			
					$this->Optionmarcas();
				echo '
				</select>
				&nbsp;&nbsp;(Si no encuentras una marca, porfavor <a rel="prettyPhoto" href="contact.html?iframe=true&width=530&height=370">contactanos</a>)
			</div>
			 
             <div class="des_marc">';
			 // introduzco el array de marcas y digo que true editar
			 $this->generaListaMarcas($tiendaData['marcas'],true);
			 echo '<span id="addMarcas"></span>';
             echo '	
                <div style="clear:both"></div>
            </div>'; 
			echo'
			<input id="input_marcas" name="marcas" type="hidden" value="'.$tiendaData['cod_marcas_comas'].'" />
			';}//Fin de datos de descripcion de tienda y marcas
			
			echo '
			 <div class="registro perfil">
            	Ubicaci&oacute;n y contacto
            </div>';
			
            if($userData['es_tienda']==1){
				echo '
            <div class="des_marc">
                <span class="dif">Direcci&oacute;n:&nbsp;</span>
					<input type="text" name="direccion" value="'.$tiendaData['direccion'].'" />
            </div>
			
			<div class="des_marc">
                <span class="dif">Localidad:&nbsp;</span>
					<input type="text" name="localidad" value="'.$tiendaData['localidad'].'" />
            </div>';
			}
			echo '
			<div class="des_marc">
                <span class="dif">Provincia:&nbsp;</span><br />
					<select name="provincia">';
					foreach($provincias as $provincia){
						($provinciaData == $provincia['localidad']) ? $selected = "selected" : $selected = "";
						echo '
						<option '.$selected.' value="'.$provincia['localidad'].'">'.$provincia['localidad'].'</option>';
					}
					echo '	
					</select>
            </div>';
			
			if($userData['es_tienda']==1)
				echo '           		
            <div class="des_marc">
                <span class="dif">Tel&eacute;fono:&nbsp;</span>
				<input name="telefono" type="text" value="'.$tiendaData['telefono'].'" />
            </div>';
			echo '
            <div class="des_marc">
                <span class="dif">Web:&nbsp;</span>'; 
				$web = substr($web,7);
				echo '
				<input name="web" type="text" value="http://'.$web.'" />&nbsp;&nbsp;(El formato debe de ser http://direccion_web)
            </div>
            <div class="des_marc">
                <span class="dif">Facebook:&nbsp;</span>';
				$userData['facebook'] = substr($userData['facebook'],7);
				echo '
				<input name="facebook" type="text" value="http://'.$userData['facebook'].'" />&nbsp;&nbsp;(El formato debe de ser http://direccion_web)
            </div>
            <div class="des_marc">
                <span class="dif">Twitter:&nbsp;</span>';
				$userData['twitter'] = substr($userData['twitter'],7);
				echo '
				<input name="twitter" type="text" value="http://'.$userData['twitter'].'" />&nbsp;&nbsp;(El formato debe de ser http://direccion_web)
            </div>';
			echo '
				<input type="submit" value="Enviar cambios" />
				<span id="respuesta2"></div>
			</form>';		
	}
	
}

?>