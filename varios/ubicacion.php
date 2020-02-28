<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>
<?php
function getIP(){
    if( isset( $_SERVER['HTTP_X_FORWARDED_FOR'] )) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if( isset( $_SERVER ['HTTP_VIA'] ))  $ip = $_SERVER['HTTP_VIA'];
    else if( isset( $_SERVER ['REMOTE_ADDR'] ))  $ip = $_SERVER['REMOTE_ADDR'];
    else $ip = null ;
    return $ip;
}
$ip = getIP();
echo $ip;
function GetUbicacionesIP($ip){
                                    
            $archivo_xml = "http://api.hostip.info/get_xml.php?ip=".$ip ."";            
            $ch = curl_init();
            $timeout = 0; // set to zero for no timeout
            curl_setopt ($ch, CURLOPT_URL, $archivo_xml);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $procedencia_xml = curl_exec($ch);
            curl_close($ch);
            
            //$procedencia_xml = file_get_contents($archivo_xml);
        
        
            if (empty($procedencia_xml)){
                $array["pais"] = "desconocido";
                $array["lugar"] = "desconocido";
                $array["sigla"] = "desconocido";
            }else{
                preg_match_all("|<Hostip>(.*)</Hostip>|sU", $procedencia_xml, $items);
                $lista_nodos = array();
                foreach ($items[1] as $key => $item)
                {
                    preg_match("|<gml:name>(.*)</gml:name>|s", $item, $mi_lugar);
                    preg_match("|<countryName>(.*)</countryName>|s", $item, $mi_pais);
                    preg_match("|<countryAbbrev>(.*)</countryAbbrev>|s", $item, $mi_sigla);
                    
                    $lista_nodos[$key]['mi_lugar'] = $mi_lugar[1];
                    $lista_nodos[$key]['mi_pais'] = $mi_pais[1];
                    $lista_nodos[$key]['mi_sigla'] = $mi_sigla[1];
                }
                
                for ($i = 0; $i < 1; $i++)
                {
                    $array["pais"] = $lista_nodos[$i]['mi_pais'];
                    $array["lugar"] = $lista_nodos[$i]['mi_lugar'];
                    $array["sigla"] = $lista_nodos[$i]['mi_sigla'];
                }
                $procedencia_xml = "";
            }
            
            return $array;
            
        }  
		$ubicaciones = array();
		$ubicaciones = GetUbicacionesIP($ip);
		echo "<br>";
		echo $ubicaciones["pais"];
		echo "<br>";
		echo $ubicaciones["lugar"];
		echo "<br>";
		echo $ubicaciones["sigla"];
?>
</body>
</html>