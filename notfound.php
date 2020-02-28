<?php
include_once 'core/init.inc.php';
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}
?>


<?php include("cabecera.php");?>
<script language="Javascript"  type="text/javascript" src="javascript/overlib.js"></script>
<script language="Javascript"  type="text/javascript" src="anuncio_script.js"></script>
<script src="ajax/anuncio_ajax.js"></script>
<script type="text/JavaScript" src="javascript/cloud-zoom.1.0.3.min.js"></script>

	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1" >
		
        <div id="text_notfound">
			<span style="font-size:50px;font-weight:bold;color:#666">UPPPPPS!!</span>       		
            <div><img height="300" style="border:2px solid #ccc" src="layout/ostiazo.jpg" /></div>
       		<span style="font-size:20px;color:#666">Parece que el anuncio que buscas ha caducado, ha sido ya vendido o no existe.</span>
		</div>
		
        
		
	</div><!--Final div bloque1-->		
	<div id="linea_verde5"></div>
</div>

<div id="guarda_dato"></div><!-- esto lo guardo para guardar el valor devuelto al ejecutar el script perfil.js de forma que si todos
los campos se han rellenado correctamente se guarda true y si no se guarda false. lo hago empleando el método de jquery data()
luego este valor es leido por el script perfil_ajax.php y si es true ejecuta la funcion ajax y si es falso devuelve false-->

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
