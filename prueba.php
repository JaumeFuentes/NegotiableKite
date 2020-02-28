<?php
include_once 'clase_webs.php';
include_once 'clases/class.link_.inc.php';
include_once 'clases/class.links.inc.php';
$link = new Links;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="es">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />



<title>NEGOTIABLE KITE | Kitesurf segunda mano | Kitesurf nuevo | Anuncios  | Ocasion | Kites , Tablas , etc ...</title>
<link rel="stylesheet" href="estilos.css" type="text/css" />
<link rel="stylesheet" href="css/cloud-zoom.css" type="text/css" />
<link rel="stylesheet" href="css/anuncios_fb.css" type="text/css" />
<link rel="shortcut icon" href="/iconos/favicon.ico" />
<link rel="stylesheet" href="css/prettyPhoto.css" /> 



<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="javascript/prettyphoto/custom_jQuery.js"></script>
<script type="text/javascript" src="javascript/prettyphoto/jquery.prettyPhoto.js"></script>


</head>

<body>
<div id="detalle_nk"></div>
<div id="top_negro">
	<ul id="menu">
        <li><a href="/blog">Blog</a></li>
        <li><a href="/links">Links</a>
            <ul>
                <li><a href="/links/foros">Foros</a>
               		 <ul>
                		<?php $link->createList('foros'); ?>
            		</ul>
                </li>
                <li><a href="links/blogs">Blogs</a>
                	<ul>
                		<?php $link->createList('blogs'); ?>
            		</ul>                	
                </li>
                <li><a href="links/videos">Videos</a>
                	<ul>
                		<?php $link->createList('videos'); ?>
            		</ul>                	
                </li>
                <li><a href="links/meteo">Meteo</a>
                    <ul>
                		<?php $link->createList('meteo'); ?>
            		</ul>                	
                </li>
                <li><a href="links/webcams">Webcams</a>
              	    <ul>
                		<?php $link->createList('webcams'); ?>
            		</ul>                	
                </li>
                <li><a href="links/revistas">Revistas</a>
                	<ul>
                		<?php $link->createList('revistas'); ?>
            		</ul>                	
                </li>
                <li><a href="links/webs">Webs</a>
                	<ul>
                		<?php $link->createList('webs'); ?>
            		</ul>                	
                </li>
                <li><a href="links/clubs">Clubs</a>
                	<ul>
                		<?php $link->createList('clubs'); ?>
            		</ul>                	
                </li>    
            </ul>
        </li>
        <li><a href="contact.html?iframe=true&amp;width=530&amp;height=370" rel="prettyPhoto">Contacto</a></li>
    </ul>
</div>




<div id="cuerpo">
	
	
	
    
    
	
	
    

	<!--FIN DE LA CABECERA-->



					
				
<div id="bloque1">
		<div id="bloque1_1">
			<ul>
						
						<li id="mail"><a href="contact.html?iframe=true&amp;width=530&amp;height=370" rel="prettyPhoto">Email</a></li>
						
					</ul>
			
		</div>
		<div id="anuncio2">
		</div>
	</div>
</div>


</body>
</html>
