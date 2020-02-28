<?php 
include_once 'core/init.inc.php';
$las_webs=new webs;
?>

<?php include("cabecera.php");?>
	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
		<div id="bloque1_1">
						
			<div id="busqueda2">
			
				<?php				
				//recogemos los valores enviados por el link de activacion que mandamos por mail 
				if (isset($_GET['id'])) 
					{ 				
					$idval=$_GET['id']; 
					$activate2=$_GET['activatekey'];  
					
        			//y aqui es donde cambiamos el valor 1=desactivado  por valor 0=activado 
					
					$registrado=$las_webs->activa_cuenta($idval,$activate2);
					
					if($registrado==true)
						{
						echo "
						<div class='registro'>
							Registro de usuario 
						</div>
						<div id='cont_reg'>
							<div id='texto_icono'>
								<div id='texto'>Registro completado con &eacute;xito!</div>
								<div id='icono'></div>
							</div>
							<div id='icono_inicio'><a href='index.php' title='ir a la p&aacute;gina de inicio'></a></div>
							
							<div style='clear:both'></div>
						</div>";
						}
					else
						{
						echo "Error al intentar activar tu cuenta";				
         				}
					}
				else
					{ 
       				 echo "Activacion incompleta. Deja de hacer el pollo";        
       				 } 
         		?> 
				

			</div><!--Fin del div busqueda 2 -->
		</div>
		<div id="anuncio2">
		</div>
	</div>
</div>

<div id="frame_pie"><?php include("pie.html");?></div>
</iframe>
</body>
</html>
