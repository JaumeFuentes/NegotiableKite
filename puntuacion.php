<?php
include_once 'core/init.inc.php';

if(isset($_POST[desconexion])) {session_destroy(); header('location: index.php');}

$las_webs=new webs;

if(!isset($_GET['cod_usuario'])) header('location: index.php');
else{ 
	$votado=$_GET['cod_usuario'];
	$nick_votado=$las_webs->nick_usuario($votado);
	if($nick_votado=="") header('location: index.php');
}

if(!isset($_SESSION['SESS_MEMBER_ID'])) header('location:login.php');
else{
	$votador=$las_webs->codigo_usuario($_SESSION['SESS_MEMBER_ID']);
}

?>


<?php include("cabecera.php");?>
<script language="Javascript"  type="text/javascript" src="/anuncio_script.js"></script>
<script language="Javascript"  type="text/javascript" src="/perfil.js"></script>
<script language="Javascript"  type="text/javascript" src="/puntuacion.js"></script>
<script src="/ajax/puntuacion_ajax.js"></script>

	<!--FIN DE LA CABECERA-->
	<div id="bloque1" >
	
	
	<div id="tit_users">Puntua a <?php echo $nick_votado; ?></div>
		
	<?php
	if($votado==$votador){
	echo "
		<form class='vendedor' >
			<div class=fieldseto>
				<div class=leyenda>Puntuar a ".$nick_votado." como vendedor</div>
				<div class='puntos'>";						
				echo "No puedes votarte a ti mismo
				</div>	
			</div>
		</form>";
	}
	else{
		
			echo "
			<form id='vendedor' class='vendedor' method='post' action=''>
				<div class=fieldseto>
					<div class=leyenda>Puntuar a ".$nick_votado." como vendedor</div>
					<div class='puntos'>";
						for($i=1;$i<11;$i++)
							echo "
							<div class='rad_boton'>
								<input class='radio' type='radio' name='puntos_vendedor' value='".$i."' />
							<div>".$i."
					</div></div>";
					echo "
					</div>
					<div class='aclaracion1'>&laquo;peor</div>
					<div class='aclaracion2'>mejor&raquo;</div>
					
					<label>Introduce un comentario</label>
					<input type='text' maxlength='70' name='comentario_vendedor' />
					<input type='hidden' value='".$votado."' name='votado' />
					<input type='hidden' value='".$votador."' name='votador' />
					<input type='hidden' value='".$nick_votado."' name='nick_votado' />
					<input type='submit' value='enviar' />
				</div>
			</form>";		
	}
			
	?>
	
	<?php
	if($votado==$votador){
	echo "
		<form class='vendedor' >
			<div class=fieldseto>
				<div class=leyenda>Puntuar a ".$nick_votado." como vendedor</div>
				<div class='puntos'>";						
				echo "No puedes votarte a ti mismo
				</div>	
			</div>
		</form>";
	}
	else{
		
			echo "
			<form id='comprador' class='vendedor' method='post' action=''>
				<div class=fieldseto>
					<div class=leyenda>Puntuar a ".$nick_votado." como comprador</div>
					<div class='puntos'>";
						for($i=1;$i<11;$i++)
							echo "
						<div class='rad_boton'>
							<input class='radio' type='radio' name='puntos_comprador' value='".$i."' />
						<div>".$i."</div></div>";
					echo "
					</div>
					<div class='aclaracion1'>&laquo;peor</div>
					<div class='aclaracion2'>mejor&raquo;</div>
					
					<label>Introduce un comentario</label>
					<input type='text' maxlength='70' name='comentario_comprador' />
					<input type='hidden' value='".$votado."' name='votado' />
					<input type='hidden' value='".$votador."' name='votador' />
					<input type='hidden' value='".$nick_votado."' name='nick_votado' />
								
					<input type='submit' value='enviar' />
				</div>
			</form>";		
	}
	?>
	
	<div class="notas">
		<div class="titulo_notas"> Notas sobre las votaciones </div>
		<ul>
			<li>Al votar a un usuario como comprador y/o vendedor, no podrás volver a votar a ese  usuario hasta pasados 4 días.
			</li>
			<li>Al votar a un usuario aparecerás en su lista pública de votos recibidos, pero tu puntuación será secreta.
			</li>
			<li>Para mantener tu puntuación secreta, tu nombre no aparecerá en la lista del usuario votado hasta que este no haya recibido un mínimo de 3 votos.
			</li>
		</ul>
	</div>
					
	<br /><br />
		
	</div><!--Final div bloque1-->
</div>

<div id="frame_pie"><?php include("pie.html");?></div>

</body>
</html>
