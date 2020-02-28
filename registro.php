<?php
/***FUNCIONAMIENTO DEL REGISTRO***

En esta página hay un formulario desde el cual se rellenan los datos. estos datos son validados inicialmente con un archivo javascript incluido en registro.js. Además existe un fichero llamado registro_ajax.js hace llamadas al fichero registro_ajax.php para comprobar que el correo o usuario introducido no existen aunque simplemente lo indica, no bloquean el envio del formulario. de esto se encarga el fichhero registro.js, el cual una vez todo es correcto mediante ajax ejecuta el script registro_ajax_enviar.php. en este fichero se encuentra el codigo html para indicar que el envio ha sido correcto, así como las instancias a los objectos de la clase la cual incluye la función para introducir los datos en la base de datos. En esta función se deberá de comprobar de nuevo que:
	- el usuario no existe.
	- el usuario no incluye carácteres no permitidos.
	- el nombre de usuario >= 4 caracteres
	- la direccion de email no existe
	- la direccion de email es valida
	- password >= 6 caracteres.
	- Se han aceptado las condiciones
	
Una vez realizadas las comprobaciones, se aplica la funcion trim a los datos usuario, email y contraseña y se previene la inyeccion SQL con la funcion clean creada como constructor en la clase-

En el script registro_ajax_enviar.php tambien se hará la llamada a la funcion de envio de email para completar registro, definida en la clase maravillosa con todas las funciones de la pagina clase_webs.php!!!

Los usuarios que se registren mediante el email recibido de registro, entraran en la presente web mediante una variable pasada por GET llamada ale. Se realizará una búsqueda en la base de datos en la que coincida el número aleatorio seleccionando el email. En la funcion registro_ajax _enviar.php se comprobara si hay un numero aleatorio y si es asi se ejecutara la funcion de introduccion de datos del unuario sin necesidad de enviar email de activación*/
	
include_once 'core/init.inc.php';
if(isset($_SESSION['SESS_MEMBER_ID'])) header('location: index.php');

$las_webs=new webs;
?>

<?php
if(!isset($_POST["ubicacion"])) $ubicacion="";
else $ubicacion=$_POST["ubicacion"];

if(!isset($_POST["email"])) $email="";
else $email=$_POST["email"];
if(!isset($_POST["emailcheck"])) $emailcheck="";
else $emailcheck=$_POST["emailcheck"];
if(!isset($_POST["nick"])) $nick="";
else $nick=trim($_POST["nick"]);
if(!isset($_POST["password"])) $password="";
else $password=trim($_POST["password"]);
if(!isset($_POST["passwordcheck"])) $passwordcheck="";
else $passwordcheck=trim($_POST["passwordcheck"]);


if(!isset($_GET["ale"])) $aleatorio="";
else $aleatorio=$_GET["ale"];

?>

<?php include("cabecera.php");?>
<script language="Javascript"  type="text/javascript" src="/registro.js"></script>
<script src="javascript/jquery.alphanumeric.pack.js"></script>
<script src="/ajax/registro_ajax.js"></script>
	
	<!--FIN DE LA CABECERA-->
	<div id="bloque1">
		<div id="bloque1_1">
			
			<div id="busqueda2">
				<div class="registro">
					Tu información de contacto  <span style="font-size:10px; color:black;  float:right; margin-right:5px;">Todos los campos son obligatorios</span>
				</div>
				<form >			
		
				<div class="nom_apel">
					<div class="nom">
						<span  >Provincia</span> <br />
						<?php
							$localidades=$las_webs->dame_las_localidades();
							echo "<select id='ubicacion' class='reqd' name='ubicacion'>";
								if(isset($_POST["ubicacion"]) and $_POST["ubicacion"]!=-1)
								echo "<option value=\"$ubicacion\">".$ubicacion."</option>";
								else
								echo "<option value=-1>Ubicación</option>";
								$numero_elementos=count($localidades); 
								for($i=0; $i<$numero_elementos; $i++)
									{$comunidad=$localidades[$i]["localidad"];
									echo "<option value=\"$comunidad\">".$comunidad."</option>";																					                               		 }	
							echo "</select>"; 
						?>
					</div>
					
				</div>
				
				<?php
				if(!$aleatorio  and $_SESSION['mensaje_registro_fb']==false){
				echo "
				<div class='nom_apel'>
					<div class='nom'>
						<span id='im'  >Dirección de correo electrónico </span> <br />
																			
						<input id='email' class='reqd email' type='text' size='32' maxlength='32' name='email' value=\"$email\" />
						
					</div>
				</div>
				
				<div class='nom_apel'>
					<div class='nom'>
						 <span id='iec'> Vuelve a introducir la direcci&oacute;n de correo electr&oacute;nico</span><br />
						
						<input class='email_ch' type='text' size='32' maxlength='32' name='emailcheck' value=\"$emailcheck\" />
					
					</div>
				</div>";
				}
				?>
				
				<div class="registro">
					Elige el seudónimo y la contraseña
				</div>
				
				<div class="nom_apel">
					<div class="nom">
						<span id="in">Elige tu nick (m&iacute;nimo 4 car&aacute;cteres)</span><br />
						<?php
						echo "<input id='nick' class='reqd nick' type='text' size='32' maxlength='17' name='nick' value=\"$nick\" />";
						?>
					</div>
				</div>
				
				<div class="nom_apel">
					<div class="nom">
						<span >Elige tu contrase&ntilde;a (mínimo 6 carácteres)</span> <br />
						<?php
						echo "<input id='password' class='reqd' type='password' size='32' maxlength='32' name='password' value=\"$password\" />";
						?>
					</div>
				</div>
				
				<div class="nom_apel">
					<div class="nom">
						 <span id="ic">Vuelve a escribir la contrase&ntilde;a</span><br />
						<?php
						echo "<input id='passwordcheck' class='reqd' type='password' size='32' maxlength='32' name='passwordcheck' value=\"$passwordcheck\" />";
						?>
					</div>
				</div>
				
				<div class="registro">
                ¿Quieres registrarte como tienda/negocio?
                </div>
				<div class="nom_apel">
					<div class="nom">
						SI<input  id="box_tienda" type="checkbox" name="condiciones" value="acepta"/>                
                    </div>
                </div>
                <div id="nombre_tienda" class="nom_apel" style="display:none">
                	<div class="nom">
                    	<span>Escribe el nombre de tu tienda / negocio</span><br />
                        <input type="text" name="nombre_tienda" value="" size="32" maxlength="32"/>
                    </div>                    
                    <b>*Una vez finalizado el registro podrás completar los datos de tu tienda en tu página personal</b>
                </div>
				
				
				<div class="registro">
					<?php 						
						echo"Continuar con el registro";
					?>
				</div>				
				<div class="nom_apel">
					<div class="nom">
						<input type="hidden" name="aleatorio" value="<?php echo $aleatorio; ?>" />
						<?php 
						echo "<br />";						
						echo"<input type='submit'  value='Continuar' />";
						?>
						<input id="box" class="box" type="checkbox" name="condiciones" value="acepta"/>
						<span id="condiciones">
							<a href="condiciones_uso.html" target="_blank"> Acepto las condiciones de uso y la pol&iacute;tica de privacidad
							</a>
						</span>
						
					</div>
					
				</div>
				<br /><br />
				</form>
			</div><!--Fin dek div busqueda 2 -->
			
		</div>
		<div id="anuncio2">
		</div>
	</div>
</div>


</iframe>
</body>
</html>
