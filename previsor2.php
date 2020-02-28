<?php
	
	include_once 'core/init.inc.php';
	$las_webs=new webs;
		
	//funcion para comprobar si el direcctorio esta vacio
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
			for($i=0; $i<$num_archivos; $i++){				
				if(substr($archivos[$i],0,7) == $imagen_actual){
					$imagen_existe = true;  
					$fichero_a_borrar = $archivos[$i];
				}
			} 					
				  
		}  
		return $imagen_existe;
	}
	

	if(isset($_GET["num_imagen"])){
		$numero_imagen = $_GET["num_imagen"];
		if($numero_imagen == "ver1") $imagen = "imagen1";
		if($numero_imagen == "ver2") $imagen = "imagen2";
		if($numero_imagen == "ver3") $imagen = "imagen3";
		if($numero_imagen == "ver4") $imagen = "imagen4";
	}
	
	if(isset($_GET["thumb"])){
		$thumb = $_GET["thumb"];
		$codan= $_GET["codan"];
		$fichero=$las_webs->carga_imagen($codan,$thumb);
	}
	
	
if(!$fichero){
	$defecto = "iconos/icono-camara.jpg";
	$Ok = isset($_FILES[$imagen]);
	$url = ($Ok) ? $_FILES[$imagen]["tmp_name"] : $defecto;
	$long_nom_arch=strlen($_FILES[$imagen]['name']);
	list($anchura, $altura, $tipoImagen, $atributos) = getimagesize($url);
	$error = (isset($atributos)) ? 0 : 1;
	$los_tipos = array("gif", "jpg", "png");
	//$tipo = ($Ok) ? "image/".$los_tipos[$tipoImagen - 1] : "image/jpg";
	$tipo = ($Ok) ? $los_tipos[$tipoImagen - 1] : "jpg";
	$tam = filesize($url);
	$OkTam = isset($_POST["maxpeso"]);
	$OkAncho = isset($_POST["maxancho"]);
	$OkAlto = isset($_POST["maxalto"]);
	$maxTam = ($OkTam) ? (int) $_POST["maxpeso"]: 100000;
	$maxAncho = ($OkAncho) ? (int) $_POST["maxancho"]: 640;
	$maxAlto = ($OkAlto) ? (int) $_POST["maxalto"]: 480;
	$error += ($tam <= $maxTam) ? 0 : 2;
	$ancho = ($error == 1) ? 0 : $anchura;
	$alto = ($error == 1) ? 0 : $altura;
	$error += ($ancho <= $maxAncho) ? 0 : 4;
	$error += ($alto <= $maxAlto) ? 0 : 8;
	$error += ($long_nom_arch <= 40) ? 0 : 16;
	$directorio="imagenes_temporales/";
	$fichero = ($Ok && ($error == 0)) ? $directorio.$imagen.$_SESSION['SESS_MEMBER_ID']."_".$_FILES[$imagen]['name'] : $defecto;
	if($Ok && ($error == 0)){
		if(directorio_vacio($directorio)==false){
			//$num_imagen=substr($fichero,0,6);
			if(comprueba_fichero($directorio,$imagen)==true and $_SESSION["fichero_anterior"]!="iconos/icono-camara.jpg")
				unlink("imagenes_temporales/".$fichero_a_borrar);
		}			
		move_uploaded_file($_FILES[$imagen]['tmp_name'],$fichero);
	}
	$onload = ($Ok) ? "onload='parent.datosImagen($tam, $ancho, $alto, $error)'": '';	
	
	$_SESSION["tipo"] = ($error == 0) ? $tipo : "image/jpg";
	
	if(isset($_GET["num_imagen_a_borrar"])){
		$numero_imagen_a_borrar = $_GET["num_imagen_a_borrar"];
		if($numero_imagen_a_borrar == "ver1") $imagen_a_borrar = "imagen1";
		if($numero_imagen_a_borrar == "ver2") $imagen_a_borrar = "imagen2";
		if($numero_imagen_a_borrar == "ver3") $imagen_a_borrar = "imagen3";
		if($numero_imagen_a_borrar == "ver4") $imagen_a_borrar = "imagen4";
		
		if(comprueba_fichero($directorio,$imagen_a_borrar)==true)
			unlink("imagenes_temporales/".$fichero_a_borrar);
		
	}
	
}	
	
	
?>
<html >
<head>
<style type="text/css" >

html,body{	
	overflow: hidden;
	background-color: #eeeeee;	
	padding:0px
	margin:0px;
}

</style>
</head>
<body <?php echo $onload;?>>
<?php
echo "<img src='".$fichero."' height=100% width=100% >";
	
?>

</body>
</html>
