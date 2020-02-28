<?php
include_once 'core/init.inc.php';
$las_webs=new webs;

if(isset($_POST[login]) and isset($_POST[password]))
$las_webs->logueo();
?>

<?php include("cabecera.php");?>
	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
		<div id="bloque1_1">
			<div id="tit_users">Webs amigas</div>
            <div class="cont_wa">
            	<div class="img_wa">
                	<img src="logos_webs_amigas/logo_tribusurfers.png" />
                </div>
                <div class="cont_dd_wa">
                	<div class="dir_wa"><a href="http://www.tribusurfers.com" target="_blank">Tribusurfers</a></div>
                    <div class="des_wa">Web online de fundas de asientos de coches y furgonetas. Talla única, se adapta a cualquier asiento gracias a su concepción tipo "Calcetín".
Fabricadas con el saber hacer de las industria de tapicería de coches y con un diseño 100% hawaiano. Son transpirables y lavables.
Más accesorios - Más diseños. También fundas impermeables.</div>
                </div>
            </div>	
            
            <div class="cont_wa">
            	<div class="img_wa">
                	<img src="logos_webs_amigas/logo_hokuspokus.png" />
                </div>
                <div class="cont_dd_wa">
                	<div class="dir_wa"><a href="http://www.hokuspokus.es" target="_blank">Hokuspokus</a></div>
                    <div class="des_wa">HOKUSPOKUS es una marca de moda enfocada al kitesurf y para la gente que le gusta el estilo de vida en la playa. son camisetas 100% algodon y fabricacion española.<br />BORN TO FLY</div>
                </div>
            </div>
            
            <div class="cont_wa">
            	<div class="img_wa">
                	<img src="logos_webs_amigas/logo_nautica_nova.png" />
                </div>
                <div class="cont_dd_wa">
                	<div class="dir_wa"><a href="http://www.nauticanova.es/5-deportes-kayak-surf-wake-nautica-vela" target="_blank">Nautica Nova</a></div>
                    <div class="des_wa">NAUTICA NOVA, situada en Burriana (Castellón), pone a disposición de empresas y particulares un amplio catálogo de recambios y accesorios para embarcaciones y la práctica de deportes náuticos.</div>
                </div>
            </div>
            
            <div class="cont_wa">
            	<div class="img_wa">
                	<img src="logos_webs_amigas/logo_freekiters.png" />
                </div>
                <div class="cont_dd_wa">
                	<div class="dir_wa"><a href="http://www.freekiters.com/" target="_blank">FreeKiters</a></div>
                    <div class="des_wa">Todo sobre el Kitesurf: Guías de Viaje y Spots, Vídeos de Kite, Novedades, Estilo y mucho más. </div>
                </div>
            </div>
            
            <div class="cont_wa">
            	<div class="img_wa">
                	<img src="logos_webs_amigas/logo_nitroskite.png" />
                </div>
                <div class="cont_dd_wa">
                	<div class="dir_wa"><a href="http://www.nitroskite.com/" target="_blank">NitrosKite</a></div>
                    <div class="des_wa">Tienda de kitesurf online dedicada a la venta de material deportivo de kitesurf nuevo y de segunda mano, marcas NP surf,JP australia y Cabrinha. </div>
                </div>
            </div>
            		
		</div>
		<div id="anuncio2">
		</div>
	</div>
</div>

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
