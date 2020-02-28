<?php
include_once 'core/init.inc.php';
	
if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

$las_webs=new webs;
?>

<?php include("cabecera.php");?>

	<!--FIN DE LA CABECERA-->
	
	<div id="contenedor_users">
		<div id="tit_users">Compra-venta segura con Negotiable Kite</div>
        <div class="caja2">Realiza el pago de forma segura por Internet</div>
        <div class="caja2">Vende tu material de forma segura por Internet</div>
        <div class="caja2">
        	<p>
            	Las acciones de compra-venta en Internet pueden resultar peligrosas y en ocasiones podemos acabar siendo v�ctimas de una estafa y perder el dinero, el material o ambas cosas
            </p>
            <p>
            	Se depende de la buena fe de cada una de las partes lo cual entra�a siempre un riesgo ya que en la mayor�a de los casos se trata de desconocidos.
                </p>
            <p>
            	En Negotiable Kite somos conscientes de que esto es uno de los temas que mas preocupa a los usuarios y hace echar marcha atr�s en muchos casos.
             </p>
             <p> Es por eso que hemos decidido lanzar este servicio, especialmente interesante para particulares que deseen vender su material o comprarlo, actuando de mediadores entre ambas partes de forma que tu dinero y/o tu material estar� seguro y podr�s estar tranquilo de no sufrir ning�n enga�o.
             </p>
         
             <p>
             	El siguiente esquema explica el proceso (si, sabemos que lo nuestro no es dibujar):
             </p>
         
        </div>
        <div class="caja2">
        	<div class="esquema">
        		<img src="layout/esquema_servicio.png" />
            </div>	
        </div>
        
        <div class="caja2">
        	BENEFICIOS PARA EL COMPRADOR
        </div>
        <div class="caja2">
        	<ul>
            	<li>
                	Si no recibes el material, se te devuelve el dinero.
                </li>
                <li>
                	Si el estado del material no coincide con lo especificado, se te devuelve el dinero.
                </li>
                <li>
                	En cualquier caso tu dinero esta seguro.
                </li>
            </ul>
        </div>
		
		<div class="caja2">
        	BENEFICIOS PARA EL VENDEDOR
        </div>
        <div class="caja2">
        	<ul>
            	<li>
                	Garant�a de recibir el pago al enviar el material.
                </li>
                <li>
                	Nos aseguramos de que recibas el material en caso de que el comprador no este satisfecho.
                </li>
                <li>
                	Publicamos y promocionamos tu material en las principales redes sociales, grupos y foros para darle la mayor salida y aumentar las posibilidades de venta.
                </li>
                <li>
                	En cualquier caso tu material est� seguro.
                </li>
            </ul>
        </div>
        
        <div class="caja2">
        	<b>DESCRIPCI�N Y CONDICIONES DEL SERVICIO</b>
        </div>
        
        <div class="caja2">
        	<ol class="condiciones">
            	<li>
                	El comprador deber� de realizar el ingreso de la cantidad final acordada en la cuenta proporcionada por NK. Una vez se haya realizado el pago, NK dar� el visto bueno al vendedor para que realice el env�o.
                </li>
                <li>
                	El vendedor deber� de aportar a NK toda la informaci�n necesaria para comprobar el estado y seguimiento de env�o del paquete.
                </li>
                <li>
                	Una vez recibido el paquete, el comprador deber� de informar a NK de su llegada, en un plazo menor o igual a dos d�as laborables, y si cumple con las especificaciones proporcionadas por el vendedor. En caso de no informar de la llegada del paquete y confirm�ndose la entrega de este, se asumir� que el comprador est� conforme con el estado del paquete y que coincide con las descripciones dadas por el vendedor.
                </li>
                <li>
                	Una vez dado el visto bueno por el comprador NK realizar� el pago correspondiente al vendedor d�ndose por concluido el proceso.
                </li>
                <li>
                	En el caso del producto no coincidir con las descripciones dadas por el vendedor, el comprador podr� devolver el material debiendo aportar a NK toda la informaci�n necesaria para comprobar el estado y seguimiento de env�o del paquete.
                </li>
                <li>
                	Cuando el vendedor reciba el material devuelto por el comprador, deber� informar a NK de su llegada en un plazo menor o igual a dos d�as laborables. En caso de no informar de la llegada del paquete y confirm�ndose la entrega de este, se asumir� que todo est� correcto.
                </li>
                <li>
                	Tras la confirmaci�n por parte del vendedor que todo est� correcto, NK reembolsar� el importe a la cuenta especificada por el vendedor.
                </li>
                <li>
                	En el caso de concluirse el proceso de venta, el importe por el servicio ofrecido por NK es del 7% sobre el precio final acordado entre comprador y vendedor
                </li>
                <li>
                	En el caso de no concluirse el proceso de venta y realizarse el reembolso, el importe por el sevicio ofrecido por NK es del 3,5% sobre el precio final acordado entre el comprador y el vendedor.
                </li>
            </ol>
        
        </div>
		
		<?php echo"<p>".$_pagi_navegacion."</p>"; ?>

	
	</div><!--fin contenedor users-->
	
</div>

<div id="frame_pie"><?php include("pie.html");?></div>
</body>
</html>
