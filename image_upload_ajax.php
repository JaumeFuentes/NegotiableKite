<?php	
/**
 * Este fichero se encarga de subir las imagenes a los directorios correspondientes
 * Se comprueban varias cosas: que se ha pasado una imagen, que el tipo de imagen es correcto, 
 * que se cumplen especificaciones de tamaño y peso.
 * Una vez comprobado eso se comprueba si la imagen correspondiente ya existe. Si es asi,
 * primero se borra la existente y luego se carga la nueva.
 * Tambien se renombran los nombres de los ficheros a subir con el formato imagen[numero][nick_usuario][nombre_archivo]
 */
 
set_time_limit(120);
 
include_once 'core/init.inc.php';
$perfil = new perfil($_SESSION['SESS_MEMBER_ID']);
$las_webs = new webs;
//imagen 1 corresponde a la imagen de perfil
// las otras tres corresponden a las imagenes de tienda o varias de usuarios
if(isset($_GET["num_imagen"])){
	$numero_imagen = $_GET["num_imagen"];
	if($numero_imagen == "ver1") $imagen = "imagen1";
	if($numero_imagen == "ver2") $imagen = "imagen2";
	if($numero_imagen == "ver3") $imagen = "imagen3";
	if($numero_imagen == "ver4") $imagen = "imagen4";
}
		
/**
 * Comprueba si existen ficheros en un directorio
 *
 * @param string $path es la direccion del directorio
 * @return boolean devuelve true si el directorio esta vacio
 */
function directorio_vacio($path){
	$vacio = true;	
		if ($handle = opendir($path))   
			{        
			while (false !== ($file = readdir($handle)))   
				{  
				if ($file != "." && $file != "..")            
					$vacio = false;            
				}
			closedir($handle);    
		}  
	return $vacio;
}

/**
 * Comprueba si un fichero ya existe en un directorio
 * La imagen a comprobar sera de la forma imagen[numero][nick] (pej: imagen1superchauen
 * Devuelve true si la imagen existe pero tambien se crea una variable global con el nombre del fichero
 *
 * @param string $path es la direccion del directorio
 * @param string $imagen_actual es la imagen a comprobar si existe.
 * @return boolean devuelve true si la imagen existe
 */	
function comprueba_fichero($path,$imagen_actual){
	global $fichero_a_borrar;
	if ($handle = opendir($path)){ 
		$archivos = array();  
		$imagen_existe = false;
		$j=0;						
		while ($archivo = readdir($handle)){  
			if ($archivo!="." and $archivo!=".."){ 
				$archivos[$j] = $archivo;
				$j++;
			}
		}
		closedir($handle);  
		$num_archivos=count($archivos);
		
		/**
		 * calculamos la longitud del nick
		 * Esto se hace porque del nombre del archivo interesa conocer la parte imagen[numero][nick]
		 * lo cual equivale a siete posiciones para imagen[numero] mas la longitud del nick
		 */
		$lnguser = strlen($_SESSION['SESS_MEMBER_ID']);
		$k = 7 + $lnguser;	
		for($i=0; $i<$num_archivos; $i++){							
			if(substr($archivos[$i],0,$k) == $imagen_actual){
				$imagen_existe = true;  
				$fichero_a_borrar = $archivos[$i];
				break;
			}
		} 					
			  
	}  
	return $imagen_existe;
}
	

	
	
	
	
	
$defecto = "iconos/icono-camara.jpg";
$Ok = isset($_FILES[$imagen]);
$url = ($Ok) ? $_FILES[$imagen]["tmp_name"] : $defecto;
$long_nom_arch=strlen($_FILES[$imagen]['name']);
list($anchura, $altura, $tipoImagen, $atributos) = getimagesize($url);
$error = (isset($atributos)) ? 0 : 1;
$los_tipos = array("gif", "jpg", "png","jpeg");
//$tipo = ($Ok) ? "image/".$los_tipos[$tipoImagen - 1] : "image/jpg";
$tipo = ($Ok) ? $los_tipos[$tipoImagen - 1] : "jpg";
$tam = filesize($url);

//el tamaño equivale a bytes
//le pongo un limite de 6 megas que es un huevaco
$maxTam = 6000000;
$maxAncho =  6400000;
$maxAlto =  4800000;
$error += ($tam <= $maxTam) ? 0 : 2;
$ancho = ($error == 1) ? 0 : $anchura;
$alto = ($error == 1) ? 0 : $altura;
$error += ($ancho <= $maxAncho) ? 0 : 4;
$error += ($alto <= $maxAlto) ? 0 : 8;
//$error += ($long_nom_arch <= 100) ? 0 : 16;
$nom_archivo = $las_webs->genera_random(20);

if($imagen == "imagen1")
	$directorio="fotos_perfil/";
else
	$directorio="imagenes_perfil/";
//especificamos el nombre del fichero	
$fichero = ($Ok && ($error == 0)) ? $directorio.$imagen.$_SESSION['SESS_MEMBER_ID']."_".$nom_archivo.".".$tipo : $defecto;

//si hay imagen pasada y no existe errores	
if($Ok && ($error == 0)){
	// comprobamos que el directorio no esta vacio 
	if(directorio_vacio($directorio)==false){
		//comprobamos si la imagen que estamos subiendo ya existe
		//si existe la borramos y la reemplazamos por la nueva
		if(comprueba_fichero($directorio,$imagen.$_SESSION['SESS_MEMBER_ID'])==true and $_SESSION["fichero_anterior"]!="iconos/icono-camara.jpg")
			unlink($directorio.$fichero_a_borrar);
	}			
	$movido = move_uploaded_file($_FILES[$imagen]['tmp_name'],$fichero);
	if($movido)
		$perfil->insertPerfilImage($fichero,$imagen);
}
	/*
	
	$_SESSION["tipo"] = ($error == 0) ? $tipo : "image/jpg";
	
	if(isset($_GET["num_imagen_a_borrar"])){
		$numero_imagen_a_borrar = $_GET["num_imagen_a_borrar"];
		if($numero_imagen_a_borrar == "ver1") $imagen_a_borrar = "imagen1";
		if($numero_imagen_a_borrar == "ver2") $imagen_a_borrar = "imagen2";
		if($numero_imagen_a_borrar == "ver3") $imagen_a_borrar = "imagen3";
		if($numero_imagen_a_borrar == "ver4") $imagen_a_borrar = "imagen4";
		
		if(comprueba_fichero($directorio,$imagen_a_borrar)==true)
			unlink("imagenes_temporales/".$fichero_a_borrar);
		
	}*/
	
?>

<?php
echo $fichero;	
?>
