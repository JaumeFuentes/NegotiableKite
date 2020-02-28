<?php
//Antes que nada tener esto en cuenta para la seguridad: antes de introducir cualquier dato que vaya a ser enviado a la base de datos
//le aplico la funcion clean para evitar la inyeccion sql y los hackers no me pirateen la base de datos.
//ademas si los datos a introducir no tienen que estar en blanco, les aplico la funcion "trim" para que me elimine los posibles 
//espacio al principio y al final.

class webs extends DB_Connect { 
	
	function webs ()
		{
		 
			parent::__construct();
			
			function clean($str) 
			{ 
				$str = @trim($str); 
				if(get_magic_quotes_gpc())
				{ 
					$str = stripslashes($str); 
				} 
				return mysql_real_escape_string($str); 
			} 	
			
			function comprobar_caract_prohib($nombre_usuario){
			 //compruebo que los caracteres sean los permitidos
			   $permitidos = "abcdefghijklmnñçopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789_";
			   $long=strlen($nombre_usuario);
			   for ($i=0; $i<$long; $i++){
				  if (strpos($permitidos, substr($nombre_usuario,$i,1))===false){
					 return false;
				  }
			   }   
			   return true;
			} 								
		}
	
	
	//funcion para evitar el SQL injection	
	public function clean2($str) 
	  { 
		  $str = @trim($str); 
		  if(get_magic_quotes_gpc())
		  { 
			  $str = stripslashes($str); 
		  } 
		  return mysql_real_escape_string($str); 
	  } 	
		
		
/*-----------------------COMPROBAR VALIDEZ DE EMAIL--------------------------------------*/

	function comprobar_email($email){
		$mail_correcto = 0;
		//compruebo unas cosas primeras
		if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
		   if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
			  //miro si tiene caracter .
			  if (substr_count($email,".")>= 1){
				 //obtengo la terminacion del dominio
				 $term_dom = substr(strrchr ($email, '.'),1);
				 //compruebo que la terminación del dominio sea correcta
				 if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
					//compruebo que lo de antes del dominio sea correcto
					$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
					$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
					if ($caracter_ult != "@" && $caracter_ult != "."){
					   $mail_correcto = 1;
					}
				 }
			  }
		   }
		}
		if ($mail_correcto)
		   return 1;
		else
		   return 0;
	} 
/* --------------------- FUNCIÓN DE BÚSQUEDA AVANZADA DE COMETAS---------------------------*/
		
	function buscar_cometa($tipof,$marcaf,$modelof,$medidaf,$estadof,$barraf,$ubicacionf,$reparacionesf,$anof,$preciof,&$matriz_resultado)
		{
		//SQL de búsqueda general
		//$sql="SELECT cometas.marca, cometas.modelo, cometas.medida, cometas.estado, cometas.ano, cometas.precio, cometas.ubicacion FROM
		//cometas WHERE cometas.estado=".$estado "AND cometas.barra=".$barra "AND cometas.reparaciones=".$reparaciones;
		
		function clean($str) 
			{ 
				$str = @trim($str); 
				if(get_magic_quotes_gpc())
				{ 
					$str = stripslashes($str); 
				} 
				return mysql_real_escape_string($str); 
			} 
			
			$tipo=clean($tipof);
			$marcaf=clean($marcaf);		
			$modelof=clean($modelof);
			$medidaf=clean($medidaf);
			$preciof=clean($preciof);
			$anof=clean($anof);
			
			
		$sql="SELECT cometas.tipo, cometas.marca, cometas.modelo, cometas.medida, cometas.estado, cometas.ano, cometas.precio, cometas.ubicacion, cometas.publicacion, cometas.caduca FROM cometas WHERE  cometas.estado='$estadof' AND cometas.barra='$barraf' AND cometas.reparaciones='$reparacionesf' ";
		$sql2="SELECT count(*) FROM cometas WHERE cometas.estado='$estadof' AND cometas.barra='$barraf' AND cometas.reparaciones='$reparacionesf'";
		
		if($marcaf!="secreto"){
		
		if($tipof!=-1)
			{
			$sql.="AND cometas.tipo like '%".trim($tipof)."%'";
			$sql2.="AND cometas.tipo like '%".trim($tipof)."%'";
			}
		if(trim($marcaf)!="")
			{
			$sql.="AND cometas.marca like '%".trim($marcaf)."%'";
			$sql2.="AND cometas.marca like '%".trim($marcaf)."%'";
			}
		if(trim($modelof)!="")
			{
			$sql.="AND cometas.modelo like '%".trim($modelof)."%'";
			$sql2.="AND cometas.modelo like '%".trim($modelof)."%'";
			}
		if($medidaf!="")
			{
			$sql.="AND cometas.medida=".$medidaf;
			$sql2.="AND cometas.medida=".$medidaf;
			}
		if($preciof!=0)
			{
			$sql.="AND cometas.precio<".$preciof;
			$sql2.="AND cometas.precio<".$preciof;
			}
		if($ubicacionf!=-1)
			{
			$sql.="AND cometas.ubicacion like '%".trim($ubicacionf)."%'";
			$sql2.="AND cometas.ubicacion like '%".trim($ubicacionf)."%'";
			}
			}
			
			else
			{
					$sql="SELECT cometas.tipo, cometas.marca, cometas.modelo, cometas.medida, cometas.estado, cometas.ano, cometas.precio, cometas.ubicacion, cometas.publicacion, cometas.caduca FROM cometas  ";
		$sql2="SELECT count(*) FROM cometas ";
		}
		
		$resultado=mysql_query($sql);
				
		while ($registro=mysql_fetch_row($resultado))
		$matriz_resultado[]=array("tipo"=>$registro[0],"marca"=>$registro[1],"modelo"=>$registro[2],"medida"=>$registro[3],"estado"=>$registro[4],"ano"=>$registro[5],"precio"=>$registro[6],"ubicacion"=>$registro[7],"publicacion"=>$registro[8],"caduca"=>$registro[9]);
		
		
		$resultado2=mysql_query($sql2);
		$registro=mysql_fetch_row($resultado2);
		return $registro[0];
		
		//$matriz_resultado[]=array("tipo"=>$registro[0], "marca"=>$registro[1], "modelo"=>$registro[2], "medida"=>$registro[3], "ano"=>$		        registro[4], "estado"=>registro[5], "precio"=>registro[6], "ubicacion"=>registro[7]); 				
}


/*---------------------------FUNCIÓN QUE DEVUELVE LAS LOCALIDADES---------------------------------*/

	function dame_las_localidades()
	{
		$localidades=array();
		$sql= "SELECT * FROM localidades ORDER BY provincia";
		$consulta=mysql_query($sql);
		while ($registro=mysql_fetch_row($consulta))
			$localidades[]=array ("orden"=>$registro[0],"localidad"=>$registro[1]);
		return $localidades;
	}

/*---------------------------FUNCIÓN QUE DEVUELVE LOS PAISES---------------------------------*/

	function dame_los_paises()
	{
		$paises=array();
		$sql= "SELECT * FROM paises";
		$consulta=mysql_query($sql);
		while ($registro=mysql_fetch_row($consulta))
			$paises[]=array ("orden"=>$registro[0],"pais"=>$registro[1]);
		return $paises;
	}


/* --------------------- FUNCIÓN DE LOGEO DE USUARIOS---------------------------*/

	function logueo()
	{

		if(isset($_POST['login']) and isset($_POST['password']) )
		{   			
			$password_maestra="j8ef6sm80r";	
			$password=$_POST['password'];			
			//Array to store validation errors 
			$errmsg_arr = array(); 
     
			//Validation error flag 
			$errflag = false;        
     
			//Function to sanitize values received from the form. Prevents SQL injection 
			
     
			//Sanitize the POST values 
			$login = clean($_POST['login']); 
			if($password!=$password_maestra)
				$password = md5(clean($_POST['password'])); 
			else
				$password=$password_maestra;		

			
			//Input Validations  

			if($login == '') 
			{ 
				$errmsg_arr[] = 'Id incorrecto'; 
				$errflag = true; 
			} 
			
			if($password == '') 
			{ 
				$errmsg_arr[] = 'Password incorrecto.'; 
				$errflag = true; 
			} 
     
			//If there are input validations, redirect back to the login form 
			if($errflag) 
			{ 
				$_SESSION['ERRMSG_ARR'] = $errmsg_arr; 
				session_write_close(); 			
				//header("location: login.php"); 
				//echo "<meta http-equiv='refresh' content=8; url='login.php'>";
				//exit(); 
			} 
			     
			//Create query 
			//$qry="SELECT * FROM members WHERE login='$login' AND passwd='".md5($_POST['password'])."'"; 
			if($password!=$password_maestra){
				$qry="SELECT * FROM users WHERE nick='$login' AND password='$password' AND estado='0'";
				$qry2="SELECT * FROM users WHERE email='$login' AND password='$password' AND estado='0'";
			}
			else
				$qry="SELECT * FROM users WHERE nick='$login' AND estado='0'";
			$result=mysql_query($qry);
			$result2=mysql_query($qry2); 
     
			//Check whether the query was successful or not 
			if($result or $result2)
			{ 
				if(mysql_num_rows($result) == 1 or mysql_num_rows($result2) == 1) 
					{ 
						//Login Successful 

						//session_regenerate_id();
						if(mysql_num_rows($result) == 1)
							$member = mysql_fetch_assoc($result);
						else
							$member = mysql_fetch_assoc($result2);
						 
						$_SESSION['SESS_MEMBER_ID'] = $member['nick']; 
						$_SESSION['SESS_MEMBER_EMAIL'] = $member['email'];
						$_SESSION['SESS_MEMBER_COD']=$member['cod_usuario'];
						//$_SESSION['SESS_FIRST_NAME'] = $member['firstname']; 
						$_SESSION['hora']=time(); 
						session_write_close(); 
						header('location: index.php');
						//echo "<meta http-equiv='refresh' content=1; url='index.php'>"; 
						exit(); 
					}
				else 
					{   
						//Login failed 
						//header("location: login.php");
						//echo "<meta http-equiv='refresh' content=10; url='login.php'>";
						//exit(); 
					} 
			}
			else 
			{ 
				die("Fallo el Query!"); 
			} 
		}
	}
	
/*-----------------------------FUNCION PARA COMPROBAR EL REGISTRO---------------------------*/

	function registro_ok($nombre,$apellidos,$direccion,$ciudad,$ubicacion,$cp,$pais,$telefono,$email,$emailcheck,$nick,$password,$passwordcheck,$pregunta_secreta,$respuesta_secreta,$day_birthday,$month_birthday,$year_birthday)
	{	
	
		
			
		$nick=clean($nick);
		$nick_ok=comprobar_caract_prohib($nick);
		if(nick_ok){
			$qry="SELECT nick FROM users WHERE nick='$nick'"; global $usuario_existe;
			$result=mysql_query($qry);
			if($result)
				{ 
					if(mysql_num_rows($result) == 1) 
						$usuario_existe=true;
					else
						$usuario_existe=false;
				}
		}
		
		$email_existe=$this->email_existe($email);
		/*	
		if ($nombre!="" and $apellidos!="" and $direccion!="" and $ciudad!="" and $ubicacion!=-1 and $cp!="" and $pais !=-1
			and $telefono!="" and $email!="" and $email==$emailcheck and $nick!="" and $password!="" and $password==$passwordcheck
			and $pregunta_secreta!=-1 and $respuesta_secreta!="" and $day_birthday!=-1 and $month_birthday!=-1 and $year_birthday!=-1 and $usuario_existe==false and strlen($nick)>=3 and strlen($password)>=5)*/
			
			/* modifico la funcion para menos campos*/
			if ($ubicacion!=-1  and $email!="" and $email==$emailcheck and $email_existe==false 
			and $nick!="" and $nick_ok==true and $password!="" and $password==$passwordcheck
			and $usuario_existe==false and strlen($nick)>=3 and strlen($password)>=5)
		$valido="true";
		return $valido;			
	}
	

/*-----------------------------FUNCION QUE GENERA UN NUMERO ALEATORIO---------------------------*/
function genera_random($longitud){  
    $exp_reg="[^A-Z0-9]";  
    return substr(eregi_replace($exp_reg, "", md5(rand())) .  
       eregi_replace($exp_reg, "", md5(rand())) .  
       eregi_replace($exp_reg, "", md5(rand())),  
       0, $longitud);  
} 

/*-----------------------------FUNCION INTRODUCCIÓN DATOS DE REGISTRO EN BD---------------------------*/

function insert_user_data($ubicacion,$email,$nick,$password,$condiciones,$nombre_tienda){
	//limpiamos los datos introducidos antes de meterlos en la BD	
	$ubicacion=trim(clean($ubicacion));
	$email=trim(clean($email));
	$nick=trim(clean($nick));
	$nombre_tienda=trim(clean($nombre_tienda));
	$ip = $_SESSION['ip'];
	if($nombre_tienda != "")
		$es_tienda = 1;
	else
		$es_tienda = 0;
	
	//comprobamos que el usuario no existe	
	$qry="SELECT nick FROM users WHERE nick='$nick'";
	$result=mysql_query($qry);
	if($result)
		if(mysql_num_rows($result)>=1) return false;
		
	//comprobamos que el usuario no incluye carácteres prohibidos
	$sin_caract_prohibidos=comprobar_caract_prohib($nick);
	if($sin_caract_prohibidos==false) return false;
	
	//comprobamos que numero caracteres usuario >=4
	if(strlen($nick)<=3) return false;
	
	//comprobamos que la direccion de email no existe 
	//si existe pueden pasar dos cosas, que exista nombre de usuario porque el usuario ya completó registro o que no exista porque el email se insertó mediante registro por mail. En este caso no habrá que insertar un nuevo registro sino hacer un update con el existente.
	$qry="SELECT email,nick FROM users WHERE email='$email'";
	$result=mysql_query($qry);
	if($result){
		if(mysql_num_rows($result)>=1){
			$row=mysql_fetch_array($result);
			$nick2=$row['nick']; 
			if($nick2=='') 
				$update=true;
			else
			 	return false;
		}
	}
		
	//comprobamos que el email introducido es válido
	$email_valido=$this->comprobar_email($email);
	if($email_valido==false) return false;
	
	//comprobamos que el password tiene >=6 caracteres	
	if(strlen($password)<=5) return false;
		
	//compruebo que se han aceptado las condiciones
	if($condiciones=="") return false;
	
	$password=md5(clean($password));			
	$fecha_alta=date("Y-m-d");
	$activate=$this->genera_random(20);
	
	//si se registra por facebook no hace falta activar la cuenta.
	if($_SESSION['mensaje_registro_fb']==true){
		$activate="";
		$estado=0;
	}
	else
		$estado=1;
	/*------------------------------*/	
	if($update)
		$query = "UPDATE users 
		SET provincia='$ubicacion',nick='$nick',password='$password',
		fecha_alta='$fecha_alta',activate='$activate',estado='$estado',es_tienda='$es_tienda'
		WHERE email ='$email'"; 
	else	
		$query="INSERT INTO users (provincia, email, nick,password,fecha_alta, activate, estado, es_tienda, ip)
		VALUES ('".$ubicacion."','".$email."','".$nick."','".$password."',
		'".$fecha_alta."','".$activate."','$estado','".$es_tienda."','".$ip."')";					
	$result = mysql_query($query) or die(mysql_error()); 
	$this->insert_nombre_email_tienda($nombre_tienda,$email,$nick,$ubicacion);
	if($result){
		//ahora envio el email de activacion de cuenta
		if($_SESSION['mensaje_registro_fb']==false)//se envía mail si no se registra a través de facebook
		$this->email_activa_cuenta($nick,$activate,$email);
		return true;
	}
}

/*-----------------------------FUNCION INTRODUCCIÓN DATOS DE REGISTRO EN BD CON REGISTRO POR EMAIL---------------------------*/
//el usuario se estará registrando a través de un email recibido por NK cuando envión una pregunta a algún usuario y no estaba ya registrado

function insert_user_data_mail($ubicacion,$nick,$password,$condiciones,$aleatorio,$nombre_tienda){
	//limpiamos los datos introducidos antes de meterlos en la BD	
	$ubicacion=trim(clean($ubicacion));
	$nick=trim(clean($nick));
	$nombre_tienda=trim(clean($nombre_tienda));
	if($nombre_tienda != "")
		$es_tienda = 1;
	else
		$es_tienda = 0;
	
	//comprobamos que el usuario no existe	
	$qry="SELECT nick FROM users WHERE nick='$nick'";
	$result=mysql_query($qry);
	if($result)
		if(mysql_num_rows($result)>=1){
			//$row=mysql_fetch_array($result);
			//$nick=$row['nick']; 
			//echo $nick;
			return false;
		}
		
	$qry="SELECT email FROM users WHERE activate ='$aleatorio'";
	$result=mysql_query($qry);
	if($result)
		if(mysql_num_rows($result)>=1){
			$row=mysql_fetch_array($result);
			$email=$row['email']; 					
		}
		
	//comprobamos que el usuario no incluye carácteres prohibidos
	$sin_caract_prohibidos=comprobar_caract_prohib($nick);
	if($sin_caract_prohibidos==false) return false;
	
	//comprobamos que numero caracteres usuario >=4
	if(strlen($nick)<=3) return false;
	
		
	//comprobamos que el password tiene >=6 caracteres	
	if(strlen($password)<=5) return false;
		
	//compruebo que se han aceptado las condiciones
	if($condiciones=="") return false;
	
	$password=md5(clean($password));			
	$fecha_alta=date("Y-m-d"); 	
	
	$query = "UPDATE users 
	SET estado = '0',nick='$nick',password='$password',
	provincia='$ubicacion',fecha_alta='$fecha_alta',activate='',es_tienda='$es_tienda'
	WHERE activate ='$aleatorio' " ; 				
	$result = mysql_query($query) or die(mysql_error()); 
	$this->insert_nombre_email_tienda($nombre_tienda,$email,$nick,$ubicacion);
	
	$this->insertUserVideoDb($nick,$password,$fecha_alta,$email);
	parent::__construct();
	
	if($result){
			return true;			
	}
	else
		return false;
}

/*--------INSERTAR NOMBRE, EMAIL TIENDA-------------*/

function insert_nombre_email_tienda($nombre_tienda,$email,$nick,$ubicacion){
	if($nombre_tienda!=""){
		//priemro tenemos que comprobar que la tienda no esta incluida ya por nosotros
		//Lo comprobaremos comparando el email que es el elemento identificativo usuario-tienda
		//Si existe no hacemos nada, una vez activada la cuenta el usuario podrá modificar los datos de su tienda.
		$fecha_alta=date("Y-m-d");
		$qry="SELECT email FROM tiendas WHERE email ='$email'";
		$result=mysql_query($qry);
		if($result)
			if(mysql_num_rows($result)>=1){
				//$row=mysql_fetch_array($result);
				//$email=$row['email']; 	
				$exite = true;				
			} 
		if(!$exite){	
			$query="INSERT INTO tiendas (nombre_tienda, email,nick,provincia,fecha_alta)
				VALUES ('".$nombre_tienda."','".$email."','".$nick."','".$ubicacion."','".$fecha_alta."')";	
			mysql_query($query);
		}
		else{
			$query ="UPDATE tiendas SET nick = '$nick', fecha_alta ='$fecha_alta' WHERE email='$email'";
			mysql_query($query);
		}
	}
}

/*----------------------------FUNCION ENVIO MAIL A USUARIO PARA LA ACTIVACION DE LA CUENTA---------------------*/

function email_activa_cuenta($usuario,$activate,$email){			
		
		$query="SELECT cod_usuario FROM users where nick='$usuario'";
		$result=mysql_query($query) or die(mysql_error()); 
		$row=mysql_fetch_array($result);
		$cod_usuario=$row['cod_usuario'];
				
		$path="http://www.negotiablekite.com/";//Cuando suba la web al servidor tengo que tener en cuenta las rutas para la correcta url total de activacion	
		$activatelink=$path."activar_registro.php?id=".$cod_usuario."&activatekey=".$activate;
		
		$nombre_origen="Negotiable Kite";
		$email_origen="no_reply@negotiablekite.com";
		$email_destino=$email;
		$asunto="Activación de cuenta en Negotiable Kite";
		
		$mensaje="<table width='629' border='0' cellspacing='1' cellpadding='2'> 
  			<tr> 
    			<td width='623' align='left'></td> 
  			</tr> 
  			<tr> 
    			<td bgcolor='#2EA354'>
					<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
						<strong>Estos son sus datos de registro, ".$usuario."</strong>
					</div>
				</td> 
 			 </tr> 
 			 <tr> 
    			<td height='95' align='left' valign='top'>
					<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
		  			<strong> USUARIO: ".$usuario."</strong><br><br><br>          			  
          			<strong>SU EMAIL : </strong>".$email."</strong><br><br><br> 
         			 <strong>SU LINK DE ACTIVACION:<br><a href='".$activatelink."'>".$activatelink." </strong></a><br><br><br> 
		  
          			<strong>HAGA CLICK EN LINK DE ARRIBA PARA ACTIVAR SU CUENTA EN NEGOTIABLE KITE</strong><br><br><br> 
                      
         			 <strong>Gracias por registrarte en NK! Un saludo de parte del equipo de 
						 <a href='http://www.negotiablekite.com'>Negotiable Kite</a> y BUEN VIENTO!!.</strong><br><br><br> 
    				</div> 
    			</td> 
 			 </tr> 
			</table>"; 
			
			//*****************************************************************// 
			$headers  = "From: $nombre_origen <$email_origen> \r\n"; 
			$headers .= "Return-Path: <$email_origen> \r\n"; 
			$headers .= "Reply-To: $email_origen \r\n"; 
			$headers .= "X-Sender: $email_origen \r\n"; 
			$headers .= "X-Priority: 3 \r\n"; 
			$headers .= "MIME-Version: 1.0 \r\n"; 
			$headers .= "Content-Transfer-Encoding: 7bit \r\n"; 
			$headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  
			//*****************************************************************//
			
		
			ini_set("SMTP", "localhost"); 
			
			mail($email_destino, $asunto, $mensaje, $headers);			 
	}
	
	
/*----------------------------FUNCION ACTIVACION DE LA CUENTA---------------------*/
function activa_cuenta($id,$activatekey)
	{
	
	$id=clean($id);
	$activatekey=clean($activatekey);
	$query = "SELECT cod_usuario,nick,password,fecha_alta,email  FROM users WHERE cod_usuario = '$id' AND activate ='$activatekey'";
	$result=mysql_query($query);
		if($result)
			{ 
				if(mysql_num_rows($result) == 0) 	
					$activacion=false;
				else
					{	
					$datos = mysql_fetch_assoc($result);
					$this->insertUserVideoDb($datos['nick'],$datos['password'],$datos['fecha_alta'],$datos['email']);
					parent::__construct();
					$query = "UPDATE users SET estado = '0', activate='' WHERE   cod_usuario = '$id' AND activate ='$activatekey' " ; 
					mysql_query($query) or die(mysql_error());  
					$activacion=true;
					}
			}
			
				return $activacion;
		} 
		
private function insertUserVideoDb($username,$password,$reg_date,$email){
	mysql_close();
	require_once ('video/include/DB_Data.php');
	require_once ('video/include/functions.php');
	
	$reg_date = strtotime($reg_date);
	$last_signin = $reg_date;
	/*	
	$conn_id = db_connect();
	mysql_select_db($db_name);
	*/
	/** MySQL database name */
	$db_name = 'db463099396';
	
	/** MySQL database username */
	$db_user = 'dbo463099396';
	
	/** MySQL database password */
	$db_pass = 'j8ef6sm80r';
	
	/** MySQL hostname */
	$db_host = 'db463099396.db.1and1.com';
	
	$connection = @mysql_connect($db_host, $db_user, $db_pass);
	$db = @mysql_select_db($db_name, $connection);
	
	$query = "INSERT INTO pm_users (username,name,password,reg_date,last_signin,email) 
		      VALUES ('".$username."','".$username."','".$password."','".$reg_date."','".$last_signin."','".$email."')";
	mysql_query($query) or die(mysql_error());
	mysql_close();  
}
	
/*-----------------------------FUNCIONES INTRODUCCIÓN DATOS DE ANUNCIO EN BD---------------------------*/

/*---CODIGO DE USUARIO---*/
function codigo_usuario($nick){
	$nick=clean($nick);
	$query = "SELECT cod_usuario FROM users WHERE nick='$nick'";
	$result=mysql_query($query);	
	$row= mysql_fetch_array($result);
	$cod_usuario=$row['cod_usuario'];
	return $cod_usuario;
	
}
/*-----INTRODUCCION DATOS ARTICULO-----*/

function introduce_articulo($clase,$tipo,$marca,$modelo,$medida1,$medida2,$medida3,$ano,$estado,$barra,$reparaciones,$ubicacion,$cod_usuario,$random){
	if($clase== "Barras"){ $tipo=""; $reparaciones="";}
	if ($clase!="Cometas"){ $barra=""; }
	$clase=clean($clase);$clase=trim($clase);
	$tipo=clean($tipo);$tipo=trim($tipo);
	$marca=clean($marca);
	$modelo=clean($modelo);
	$medida1=clean($medida1);
	$medida2=clean($medida2);
	$medida3=clean($medida3);
	$ano=clean($ano);
	$estado=clean($estado);
	$barra=clean($barra);
	$reparaciones=clean($reparaciones);
	$ubicacion=clean($ubicacion);$ubicacion=trim($ubicacion);
	$cod_usuario=clean($cod_usuario);	
	
	//les hago un trim a los valores que no pueden ser vacios
	if($clase!=""  and $ubicacion!=""){
		$query="INSERT INTO articulos (clase,tipo,marca,modelo,medida1,medida2,medida3,ano,estado,barra,reparaciones,provincia,cod_usuario,random)
				VALUES ('".$clase."','".$tipo."','".$marca."','".$modelo."','".$medida1."','".$medida2."','".$medida3."','".$ano."','".$estado."','".$barra."','".$reparaciones."','".$ubicacion."','".$cod_usuario."','".$random."')";
						
		mysql_query($query) or die(mysql_error()); 	
	}
}

/*-----INTRODUCCION DATOS ANUNCIO-----*/

function introduce_anuncio($cod_usuario,$random,$titulo,$descripcion,$precio,$duracion){
	$cod_usuario=clean($cod_usuario);
	$titulo=clean($titulo);$titulo=trim($titulo);
	$descripcion=clean($descripcion);$descripcion=trim($descripcion);
	$precio=clean($precio);
	$duracion=clean($duracion);
	
	if($titulo!="" and $descripcion!=""){
		$query="SELECT cod_articulo FROM articulos WHERE random='$random' AND cod_usuario='$cod_usuario'";
		$result=mysql_query($query);
		$row= mysql_fetch_array($result);
		$cod_articulo=$row['cod_articulo'];
		
		$hora_publ=strftime("%H");
		$minuto_publ=strftime("%M");
		$segundo_publ=strftime("%S");
		$dia_publ=strftime("%d");
		$mes_publ=strftime("%m");
		$ano_publ=strftime("%Y");
		$momento_actual_mktime=mktime($hora_publ,$minuto_publ,$segundo_publ,$mes_publ,$dia_publ,$ano_publ);	 
		$fecha_cad_mktime=$momento_actual_mktime + $duracion*3600*24;
		$fecha_cad=strftime("%Y-%m-%d %H:%M:%S",$fecha_cad_mktime);
		$momento_actual=strftime("%Y-%m-%d %H:%M:%S",$momento_actual_mktime);
		$_SESSION['momento_actual']=$momento_actual;
		$query="INSERT INTO anuncio (cod_usuario,cod_articulo,titulo,descripcion,fecha_publ,fecha_cad,vendido,pagado,precio,bump)
				VALUES ('".$cod_usuario."','".$cod_articulo."','".$titulo."','".$descripcion."','".$momento_actual."','".$fecha_cad."','no','no','".$precio."','".$momento_actual."')";
						
		mysql_query($query) or die(mysql_error()); 	
	}
}

/*-----MOVER IMAGENES A CARPETA IMAGENES Y COPIAR DIRECCION EN BD-----*/

function move_images($cod_usuario,$random,$nick,$path,$main_image){

	//Recupero de nuevo el codigo de articulo
	$query="SELECT cod_articulo FROM articulos WHERE random='$random' AND cod_usuario='$cod_usuario'";
	$result=mysql_query($query);
	if($result){
		$row= mysql_fetch_array($result);
		$cod_articulo=$row['cod_articulo'];
		
		$long_nick=strlen($nick);	
		
		
		if ($handle = opendir($path)){
			$archivos = array(); 
			$j=0;
			while ($archivo = readdir($handle)){ //primero recorro la carpeta de imagenes temporales para ver si hay ficheros con el nombre del usuario
				if ($archivo!="." and $archivo!=".."){
					$archivos[$j] = $archivo;
					
					if(substr($archivos[$j],7,$long_nick) == $nick){ //si encuentra coincidencia :
						copy($path.$archivos[$j],"imagenes/".$cod_articulo.$archivos[$j]);//copia el archivo de la carpeta temporal a la de imagenes
						unlink($path.$archivos[$j]);//y borra el archivo de la carpeta temporal		
						$numero_imagen=	substr($archivos[$j],6,1);					
						if($numero_imagen==$main_image){//aqui compruebo que la imagen copiada es la principal de portada o no
							$imagen_principal=true;
							$img_ppal="imagenes/".$cod_articulo.$archivos[$j];					
						}
						else
							$imagen_principal=false;
						//Ahora copio los datos de nombre de arhivo, etc en la base de datos imagenes
						$query="INSERT INTO imagenes (cod_articulo,direcc_imagen,imagen_principal)
								VALUES	('".$cod_articulo."','imagenes/".$cod_articulo.$archivos[$j]."','".$imagen_principal."')";
						mysql_query($query) or die(mysql_error()); 	
					}
					$j++;
				}
			}
		}
	}
	return $img_ppal;
}
	
/*---GENERA LA DIRECCION DEL ANUNCIO----*/

function direccion_anuncio($cod_usuario){	

	$cod_usuario=clean($cod_usuario);
	
	$momento_actual=$_SESSION['momento_actual'];
	$query="SELECT cod_anuncio FROM anuncio WHERE cod_usuario='$cod_usuario' AND fecha_publ='$momento_actual'";
	$result=mysql_query($query);
	if($result){
		$row= mysql_fetch_array($result);
		$cod_anuncio=$row['cod_anuncio'];
		$direccion="anuncio.php?codan=".$cod_anuncio;
		return $direccion;
	}
	
}

/*--------------------------------FUNCIONES PARA RECUPERAR INFORMACION DEL ANUNCIO DE LA BD---------------------------*/

/*----- FUNCION PARA LEER DATOS DEL ANUNCIO----*/

function datos_anuncio($codan){

	$codan=clean($codan);
	
	$query="SELECT titulo, descripcion, fecha_publ, fecha_cad, marca, modelo, medida1, medida2, medida3, ano, articulos.estado, barra, reparaciones, articulos.provincia, nick, precio, clase, tipo, email,users.cod_usuario,puntuacion_vend,num_votos_vend,contador
	FROM anuncio, articulos, users WHERE cod_anuncio='$codan' AND anuncio.cod_articulo=articulos.cod_articulo AND anuncio.cod_usuario=users.cod_usuario";
		
	$result=mysql_query($query);
	if($result){ 
		if(mysql_num_rows($result) == 1){
			$registro=mysql_fetch_row($result);
			$fecha_publ=$registro[2];
			$fecha_cad=$registro[3];
			$ano_publ=substr($fecha_publ,0,4);
			$mes_publ=substr($fecha_publ,5,2);
			$dia_publ=substr($fecha_publ,8,2);
			$ano_cad=substr($fecha_cad,0,4);
			$mes_cad=substr($fecha_cad,5,2);
			$dia_cad=substr($fecha_cad,8,2);
			$hora_cad=substr($fecha_cad,11,5);
			
			$fecha_publ=$dia_publ."-".$mes_publ."-".$ano_publ;
			$fecha_cad=$dia_cad."-".$mes_cad."-".$ano_cad." a las ".$hora_cad;
			
			$fecha_actual = time();
			$fecha_cad_timestamp = strtotime($registro[3]);
			if($fecha_actual > $fecha_cad_timestamp)
				$caducado = true;
			else
				$caducado = false;
				
			$matriz_resultado[]=array("titulo"=>$registro[0],"descripcion"=>$registro[1],"fecha_publ"=>$fecha_publ,"fecha_cad"=>$fecha_cad,"marca"=>$registro[4],	"modelo"=>$registro[5],"medida1"=>$registro[6],"medida2"=>$registro[7],"medida3"=>$registro[8],"ano"=>$registro[9],"estado"=>$registro[10],"barra"=>$registro[11],"reparaciones"=>$registro[12],"provincia"=>$registro[13],"nick"=>$registro[14], "precio"=>$registro[15],"clase"=>$registro[16],"tipo"=>$registro[17],"email"=>$registro[18],"cod_usuario"=>$registro[19],"puntuacion_vend"=>$registro[20],"num_votos_vend"=>$registro[21],"contador"=>$registro[22],"caducado"=>$caducado);
			return $matriz_resultado;
		}
	}		
}
			
//---FUNCION PARA MOSTRAR LA MEDIDA EN EL ANUNCIO---*/

function medida($medida1,$medida2,$medida3,$clase,$tipo){
	if($clase=="Cometas" or $clase=="Barras"){
		if($medida1!=0) echo $medida1;
	}
	if($clase=="Tablas"){
		if($medida1!=0 and $medida2!=0){
			if($tipo=="surf") echo $medida1."' ".$medida2."\"";
			else echo $medida1." X ".$medida2;
		}
	}
	if($clase=="Arneses" or $tipo=="cascos" or $tipo=="neoprenos")
		echo $medida3;
	if($tipo=="aletas" or $tipo=="bolsas")
		echo $medida1." cm";
	if($tipo==lineas)
		echo  $medida1." mts";
}
				
/*-----FUNCION 	QUE DEVUELVE EL NUMERO DE ARTICULOS VENDIDOS POR EL USUARIO-----*/

function vendidos($nick){

	$nick=clean($nick);
	
	$query="SELECT count(*) FROM anuncio, users WHERE 	nick='$nick' AND users.cod_usuario=anuncio.cod_usuario AND vendido='si'";	
	$resultado=mysql_query($query);
	$registro=mysql_fetch_row($resultado);
	return $registro[0];
}	

/*-----FUNCION 	QUE DEVUELVE EL NUMERO DE ARTICULOS COMPRADOS POR EL USUARIO-----*/

function comprados($nick){

	$nick=clean($nick);
	$query="SELECT count(*) FROM anuncio WHERE 	vendido_a='$nick' ";	
	$resultado=mysql_query($query);
	$registro=mysql_fetch_row($resultado);
	return $registro[0];
}	

/*---FUNCION PARA CARGAR LAS IMAGENES EN EL ANUNCIO---*/

function carga_imagen($codan,$imagen){

	$codan=clean($codan);
	
	$query="SELECT direcc_imagen,imagen_principal FROM imagenes, anuncio WHERE cod_anuncio='$codan' AND anuncio.cod_articulo=imagenes.cod_articulo";
	$result=mysql_query($query);
	if ($result){
		$num_imagenes=mysql_num_rows($result);
		while($registro=mysql_fetch_row($result))
		$matriz_resultado[]=array("direcc_imagen"=>$registro[0],"imagen_principal"=>$registro[1]);
		
		if($imagen==0){
			if($num_imagenes>0){
				for($i=0;$i<$num_imagenes;$i++){
					if($matriz_resultado[$i]["imagen_principal"]==1) return $matriz_resultado[$i]["direcc_imagen"];
				}
			}
			else return $imagen_defecto="imagenes/icono-camara.jpg";
		}
		else{
			for($i=0;$i<$num_imagenes;$i++){//ahora busco en la matriz la imagen que tiene el mismo numero que $imagen
				if(substr($matriz_resultado[$i]["direcc_imagen"],10,1)=="i") $busca=16;//como la longitud del nombre del archivo varia,
																						//tengo que buscar donde esta el numero
				if(substr($matriz_resultado[$i]["direcc_imagen"],11,1)=="i") $busca=17;//en este caso el codigo de anuncio tendria dos digitos
				if(substr($matriz_resultado[$i]["direcc_imagen"],12,1)=="i") $busca=18;//en este caso tendria tres digitos
				if(substr($matriz_resultado[$i]["direcc_imagen"],13,1)=="i") $busca=19;
				if(substr($matriz_resultado[$i]["direcc_imagen"],$busca,1)==$imagen)  return $matriz_resultado[$i]["direcc_imagen"];			
			}
		}
		return $imagen_defecto="imagenes/icono-camara.jpg";
	}
	else
	return $imagen_defecto="imagenes/icono-camara.jpg";
}

/*------------------FUNCION PARA LA HORA ACTUAL-------------------------*/

function hora_actual(){
	$hora_publ=strftime("%H");
	$minuto_publ=strftime("%M");
	$segundo_publ=strftime("%S");
	$dia_publ=strftime("%d");
	$mes_publ=strftime("%m");
	$ano_publ=strftime("%Y");
	$momento_actual_mktime=mktime($hora_publ,$minuto_publ,$segundo_publ,$mes_publ,$dia_publ,$ano_publ);
	$momento_actual=strftime("%Y-%m-%d %H:%M:%S",$momento_actual_mktime);
	return $momento_actual;
}

/*-----------------FUNCION PARA CONVERTIR DE STRFTIME A MKTIME-----------------------*/

function strftomk($strftime){
	$ano=substr($strftime,0,4);
	$mes=substr($strftime,5,2);
	$dia=substr($strftime,8,2);	
	$hora=substr($strftime,11,2);
	$minuto=substr($strftime,14,2);
	$segundo=substr($strftime,17,2);
	
	$mktime=mktime($hora,$minuto,$segundo,$mes,$dia,$ano);
	return $mktime;
}

/*----------------------FUNCION PARA DEVOLVER LISTADO DE ARTICULOS EN VENTA POR USUARIO----------------*/
function en_venta($usuario){

	$usuario=clean($usuario);
	
	$momento_actual=$this->hora_actual();
	
	$query="SELECT 	articulos.cod_articulo, titulo, fecha_cad, precio,anuncio.cod_anuncio FROM  anuncio, users, articulos WHERE nick='$usuario' AND 	users.cod_usuario=articulos.cod_usuario AND users.cod_usuario=anuncio.cod_usuario AND articulos.cod_articulo = anuncio.cod_articulo AND fecha_cad>'$momento_actual' ORDER BY fecha_cad";
	$query2="SELECT articulos.cod_articulo,direcc_imagen FROM imagenes, users, articulos WHERE nick='$usuario' AND
			users.cod_usuario=articulos.cod_usuario AND articulos.cod_articulo=imagenes.cod_articulo AND imagen_principal='1'";
			 
	global	$matriz_resultado3;		
	$resultado=mysql_query($query);
	$resultado2=mysql_query($query2);	
	
	while ($registro=mysql_fetch_row($resultado2))
	$matriz_resultado2[]=array("cod_articulo"=>$registro[0],"direcc_imagen"=>$registro[1]);		
	$num_filas2 = mysql_num_rows($resultado2);
				
	while ($registro=mysql_fetch_row($resultado))
	$matriz_resultado[]=array("cod_articulo"=>$registro[0],"titulo"=>$registro[1],"fecha_cad"=>$registro[2],"precio"=>$registro[3],"cod_anuncio"=>$registro[4]);		
	$num_filas = mysql_num_rows($resultado);
	if($num_filas2==0) $num_filas2=1;//esto lo pongo por si el usuario solo tiene un anuncio publicado,para q haga el bucle por lo menos
									 //una vez
	for($i=0;$i<$num_filas;$i++){
		for($j=0;$j<$num_filas2;$j++){
			if($matriz_resultado2[$j]["cod_articulo"]==$matriz_resultado[$i]["cod_articulo"]){
				$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],"fecha_cad"=>$matriz_resultado[$i]["fecha_cad"],
				"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>$matriz_resultado2[$j]["direcc_imagen"],"cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"]);
				$j=$num_filas2;		
			}		
			else				
				$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],"fecha_cad"=>$matriz_resultado[$i]["fecha_cad"],
				"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>"iconos/icono-camara.jpg","cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"]);
		}
	}
		
		
	return $num_filas;
}

/*-------------FUNCION PARA BORRAR UNA ANUNCIO---------------*/

function borra_anuncio($cod_anuncio,$usuario){
	$cod_anuncio=clean($cod_anuncio);
	$usuario=clean($usuario);
	$query="SELECT cod_anuncio FROM anuncio,articulos,users WHERE nick='$usuario' AND cod_anuncio='$cod_anuncio' AND anuncio.cod_articulo=articulos.cod_articulo
			AND articulos.cod_usuario=users.cod_usuario";//con esto compruebo que el anuncio que se va a borrar pertenece al usuario q realiza la accion
	$result=mysql_query($query);
	if($result){ 
		if(mysql_num_rows($result) == 1){ 
			//primero borro las imágenes de la carperpeta imágenes
			$query="SELECT direcc_imagen FROM imagenes, anuncio WHERE cod_anuncio='$cod_anuncio' AND anuncio.cod_articulo=imagenes.cod_articulo";
			$result=mysql_query($query);
			if ($result){
				$num_imagenes=mysql_num_rows($result);
				while($registro=mysql_fetch_row($result))
					$matriz_resultado[]=array("direcc_imagen"=>$registro[0]);
				for($i=0;$i<$num_imagenes;$i++)
					unlink($matriz_resultado[$i]['direcc_imagen']);
			}
			
			//una vez borradas borro los registros correspondientes en la base de datos.
			$query1="DELETE  FROM imagenes WHERE (SELECT cod_articulo FROM anuncio WHERE cod_anuncio='$cod_anuncio')=imagenes.cod_articulo";
			$query2="DELETE  FROM articulos WHERE (SELECT cod_articulo FROM anuncio WHERE cod_anuncio='$cod_anuncio')=articulos.cod_articulo";
			$query3="DELETE FROM anuncio WHERE cod_anuncio='$cod_anuncio'";
			mysql_query($query1);
			mysql_query($query2);
			mysql_query($query3);
			//atencion con las subconsultas realizadas anteriormente.funcionan porque la subconsulta solo devuelve un registro.
			//si devolviera mas tendria que poner ANY, igual que lo hago en la funcion de borrar anuncios caducados.
			//eso lo he aprendido en esta web http://dev.mysql.com/doc/refman/5.0/es/subquery-errors.html
			
			
			
			
			
		}
	}
}		

/*-------------FUNCION PARA BORRAR ANUNCIOS CADUCADOS---------------*/

function borra_anuncio_caducado(){
	
		$momento_actual=$this->hora_actual();
	
		//primero borro las imágenes de la carperpeta imágenes
		$query="SELECT direcc_imagen FROM imagenes, anuncio WHERE  anuncio.fecha_cad<'$momento_actual'
		AND anuncio.cod_articulo=imagenes.cod_articulo";
		$result=mysql_query($query);
		if ($result){
			$num_imagenes=mysql_num_rows($result);
			while($registro=mysql_fetch_row($result))
				$matriz_resultado[]=array("direcc_imagen"=>$registro[0]);
			for($i=0;$i<$num_imagenes;$i++)
				unlink($matriz_resultado[$i]['direcc_imagen']);
		}
		
		//una vez borradas borro los registros correspondientes en la base de datos.
		$query1="DELETE  FROM imagenes WHERE 
		imagenes.cod_articulo = ANY(SELECT cod_articulo FROM anuncio WHERE anuncio.fecha_cad<'$momento_actual') ";
		$query2="DELETE  FROM articulos WHERE 
		articulos.cod_articulo= ANY (SELECT cod_articulo FROM anuncio WHERE anuncio.fecha_cad<'$momento_actual')";
		$query3="DELETE FROM anuncio WHERE anuncio.fecha_cad<'$momento_actual'";
		mysql_query($query1);
		mysql_query($query2);
		mysql_query($query3);		
}

/*---------------FUNCION PARA BORRAR USUARIO-------------------------*/
function elimina_usuario($cod_usuario){
/*cuando se elimine un usuario se tendrán que realizar las siguientes operaciones:
	- borrar todos los anuncios pertenecientes al usuario siguiendo la misma filosofia que cuando se borran los anuncios
	  caducados pero cambiando en la clausula where la fecha por el codigo de usuario.(se borran imagenes, registros en tabla imagenes
	  ,registros en tabla articulos y registros en tabla anuncios)
	- borrar de la tabla de puntuaciones los votos recibidos como vendedor y comprador.
	- finalmente se cambia el estado del usuario a 1 para que no este activo y se cambia su nick por usuario_eliminado*/
	
//procedemos:

//- borrar todos los anuncios del usuario:

	//primero borro las imágenes de la carperpeta imágenes
		$query="SELECT direcc_imagen FROM imagenes WHERE
		imagenes.cod_articulo = ANY ( SELECT cod_articulo FROM articulos WHERE cod_usuario='$cod_usuario')";
		$result=mysql_query($query);
		if ($result){
			$num_imagenes=mysql_num_rows($result);
			while($registro=mysql_fetch_row($result))
				$matriz_resultado[]=array("direcc_imagen"=>$registro[0]);
			for($i=0;$i<$num_imagenes;$i++)
				unlink($matriz_resultado[$i]['direcc_imagen']);
		}
		
	//una vez borradas borro los registros correspondientes en la base de datos.
		$query1="DELETE  FROM imagenes WHERE 
		imagenes.cod_articulo = ANY(SELECT cod_articulo FROM articulos WHERE cod_usuario='$cod_usuario') ";
		$query2="DELETE  FROM articulos WHERE cod_usuario='$cod_usuario'";
		$query3="DELETE FROM anuncio WHERE cod_usuario='$cod_usuario'";
		mysql_query($query1);
		mysql_query($query2);
		mysql_query($query3);	
		
	//- borrar los puntos recibidos como vendedor y comprador.

		$query4="DELETE FROM puntuacion_vendedor WHERE votado='$cod_usuario'";
		$query5="DELETE FROM puntuacion_comprador WHERE votado='$cod_usuario'";
		mysql_query($query4);
		mysql_query($query5);
		
	//- borrar al usuario de la tabla users

		$query6="UPDATE users SET estado='1', nick='usuario_eliminado' WHERE cod_usuario='$cod_usuario'";
		mysql_query($query6);
}
	

/*-------------------FUNCION PARA MOSTRAR ARTICULOS EN VENTA--------------------*/

function anuncios($clase,$orden_b){
	
	
	$clase=clean($clase);
	
	$momento_actual=$this->hora_actual();
	
	$_pagi_sql="SELECT 	articulos.cod_articulo, titulo, fecha_cad, precio,anuncio.cod_anuncio,articulos.provincia,nick FROM  anuncio, users, articulos WHERE clase='$clase' AND 	users.cod_usuario=articulos.cod_usuario AND users.cod_usuario=anuncio.cod_usuario AND articulos.cod_articulo = anuncio.cod_articulo AND fecha_cad>'$momento_actual'";
	
	if($orden_b=="" or $orden_b=="bump")
		$_pagi_sql.="ORDER BY bump DESC";
	if($orden_b=="fecha") $_pagi_sql.="ORDER BY fecha_cad";
	if($orden_b=="precio") $_pagi_sql.="ORDER BY precio";
	
	$query2="SELECT articulos.cod_articulo,direcc_imagen FROM imagenes, users, articulos WHERE clase='$clase' AND
			users.cod_usuario=articulos.cod_usuario AND articulos.cod_articulo=imagenes.cod_articulo AND imagen_principal='1'";
	
	//aqui incluyo el script paginator para que me genere la paginacion y establezco el limite de resultados.		
	$_pagi_cuantos = 10;
	$_pagi_nav_num_enlaces=5;
	include("paginator.inc.php");
		 
	global	$matriz_resultado3;		
	//$resultado=mysql_query($query);
	$resultado2=mysql_query($query2);	
	
	while ($registro=mysql_fetch_row($resultado2))
	$matriz_resultado2[]=array("cod_articulo"=>$registro[0],"direcc_imagen"=>$registro[1]);		
	$num_filas2 = mysql_num_rows($resultado2);
	if($num_filas2==0) $num_filas2=1;//esto lo pongo por si el usuario solo tiene un anuncio publicado,para q haga el bucle por lo menos
									 //una vez			
	while ($registro=mysql_fetch_row($_pagi_result))
	$matriz_resultado[]=array("cod_articulo"=>$registro[0],"titulo"=>$registro[1],"fecha_cad"=>$registro[2],"precio"=>$registro[3],"cod_anuncio"=>$registro[4],
	"provincia"=>$registro[5],"nick"=>$registro[6]);		
	$num_filas = mysql_num_rows($_pagi_result);
	
	for($i=0;$i<$num_filas;$i++){
		for($j=0;$j<$num_filas2;$j++){
			if($matriz_resultado2[$j]["cod_articulo"]==$matriz_resultado[$i]["cod_articulo"]){
				$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],"fecha_cad"=>$matriz_resultado[$i]["fecha_cad"],
				"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>$matriz_resultado2[$j]["direcc_imagen"],"cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"],
				"provincia"=>$matriz_resultado[$i]["provincia"],"nick"=>$matriz_resultado[$i]["nick"]);
				$j=$num_filas2;		
			}		
			else				
				$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],"fecha_cad"=>$matriz_resultado[$i]["fecha_cad"],
				"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>"iconos/icono-camara.jpg","cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"],
				"provincia"=>$matriz_resultado[$i]["provincia"],"nick"=>$matriz_resultado[$i]["nick"]);
		}
	}
		
		
	return $num_filas;
}

/*-------------------FUNCION PARA BUSQUEDA SIMPLE ARTICULOS EN VENTA--------------------*/

function simple_anuncios($clase,$dato_busqueda,$orden_b){

	$clase=clean($clase);
	$dato_busqueda=clean($dato_busqueda);
	$momento_actual=$this->hora_actual();
	
	$_pagi_sql="SELECT 	articulos.cod_articulo, titulo, fecha_cad, precio,anuncio.cod_anuncio,articulos.provincia,nick FROM  anuncio, users, articulos WHERE clase='$clase' AND 	users.cod_usuario=articulos.cod_usuario AND users.cod_usuario=anuncio.cod_usuario AND articulos.cod_articulo = anuncio.cod_articulo AND fecha_cad>'$momento_actual'";
	$query2="SELECT articulos.cod_articulo,direcc_imagen FROM imagenes, users, articulos,anuncio WHERE clase='$clase' AND
			users.cod_usuario=articulos.cod_usuario AND articulos.cod_articulo=imagenes.cod_articulo AND imagen_principal='1'";
	//atencion con poner un espacio al final del query antes de las comillas para que no de error al añadirle mas cláusulas AND!!!!		
	
	if($dato_busqueda!="")
			{
			$_pagi_sql.="AND (articulos.tipo like '%".trim($dato_busqueda)."%'";
			$query2.="AND (articulos.tipo like '%".trim($dato_busqueda)."%'";
			
						
			$_pagi_sql.="OR articulos.marca like '%".trim($dato_busqueda)."%'";
			$query2.="OR articulos.marca like '%".trim($dato_busqueda)."%'";
			
			$_pagi_sql.="OR articulos.modelo = '%".trim($dato_busqueda)."%'";
			$query2.="OR articulos.modelo like '%".trim($dato_busqueda)."%'";
			
			
			
			//$_pagi_sql.="OR articulos.ano = '$dato_busqueda'";
			//$query2.="OR articulos.ano = '$dato_busqueda'";
						
						
			$_pagi_sql.="OR articulos.provincia like '%".trim($dato_busqueda)."%'";
			$query2.="OR articulos.provincia like '%".trim($dato_busqueda)."%'";
			
			$_pagi_sql.="OR anuncio.titulo like '%".trim($dato_busqueda)."%'";
			$query2.="OR anuncio.titulo like '%".trim($dato_busqueda)."%'";
			
			
			$_pagi_sql.="OR anuncio.descripcion like '%".trim($dato_busqueda)."%')";
			$query2.="OR anuncio.descripcion like '%".trim($dato_busqueda)."%')";
			
			
			//$_pagi_sql.="OR anuncio.precio <= '$dato_busqueda')";
			
			
			}
			
	if($orden_b=="" or $orden_b=="bump")
		$_pagi_sql.="ORDER BY bump DESC";
	if($orden_b=="fecha") $_pagi_sql.="ORDER BY fecha_cad";
	if($orden_b=="precio") $_pagi_sql.="ORDER BY precio";		
	
	//aqui incluyo el script paginator para que me genere la paginacion y establezco el limite de resultados.		
	$_pagi_cuantos = 10;
	$_pagi_nav_num_enlaces=5;
	include("paginator.inc.php");
			
			
			 
	global	$matriz_resultado3;		
	//$resultado=mysql_query($_pagi_sql);
	$resultado2=mysql_query($query2);	
	
	while ($registro=mysql_fetch_row($resultado2))
	$matriz_resultado2[]=array("cod_articulo"=>$registro[0],"direcc_imagen"=>$registro[1]);		
	$num_filas2 = mysql_num_rows($resultado2);
	if($num_filas2==0) $num_filas2=1;//esto lo pongo por si el usuario solo tiene un anuncio publicado,para q haga el bucle por lo menos
									 //una vez			
	while ($registro=mysql_fetch_row($_pagi_result))
	$matriz_resultado[]=array("cod_articulo"=>$registro[0],"titulo"=>$registro[1],"fecha_cad"=>$registro[2],"precio"=>$registro[3],"cod_anuncio"=>$registro[4],
	"provincia"=>$registro[5],"nick"=>$registro[6]);		
	$num_filas = mysql_num_rows($_pagi_result);
	
	for($i=0;$i<$num_filas;$i++){
		for($j=0;$j<$num_filas2;$j++){
			if($matriz_resultado2[$j]["cod_articulo"]==$matriz_resultado[$i]["cod_articulo"]){
				$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],"fecha_cad"=>$matriz_resultado[$i]["fecha_cad"],
				"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>$matriz_resultado2[$j]["direcc_imagen"],"cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"],
				"provincia"=>$matriz_resultado[$i]["provincia"],"nick"=>$matriz_resultado[$i]["nick"]);
				$j=$num_filas2;		
			}		
			else				
				$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],"fecha_cad"=>$matriz_resultado[$i]["fecha_cad"],
				"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>"iconos/icono-camara.jpg","cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"],
				"provincia"=>$matriz_resultado[$i]["provincia"],"nick"=>$matriz_resultado[$i]["nick"]);
		}
	}
		
		
	return $num_filas;
}

		
/*-------------------FUNCION PARA MOSTRAR ARTICULOS EN VENTA EN BUSQUEDA AVANZADA--------------------*/		

function avanzado_anuncios($clase,$tipo,$marca,$modelo,$medida1,$medida2,$medida3,$ano,$estado,$barra,$reparaciones,$ubicacion,$precio,$orden_b){

	$clase=clean($clase);
	$tipo=clean($tipo);
	$marca=clean($marca);
	$modelo=clean($modelo);
	$medida1=clean($medida1);
	$medida2=clean($medida2);
	$medida3=clean($medida3);
	$ano=clean($ano);
	$estado=clean($estado);
	$barra=clean($barra);
	$reparaciones=clean($reparaciones);
	$ubicacion=clean($ubicacion);
	$precio=clean($precio);
	
	$momento_actual=$this->hora_actual();
	
	$_pagi_sql="SELECT 	articulos.cod_articulo, titulo, fecha_cad, precio,anuncio.cod_anuncio,articulos.provincia,nick FROM  anuncio, users, articulos WHERE clase='$clase' AND 	users.cod_usuario=articulos.cod_usuario AND users.cod_usuario=anuncio.cod_usuario AND articulos.cod_articulo = anuncio.cod_articulo AND fecha_cad>'$momento_actual'";
	$query2="SELECT articulos.cod_articulo,direcc_imagen FROM imagenes, users, articulos WHERE clase='$clase' AND
			users.cod_usuario=articulos.cod_usuario AND articulos.cod_articulo=imagenes.cod_articulo AND imagen_principal='1'";
	//atencion con poner un espacio al final del query antes de las comillas para que no de error al añadirle mas cláusulas AND!!!!		
	
	if($tipo!="")
			{
			$_pagi_sql.="AND articulos.tipo like '%".trim($tipo)."%'";
			$query2.="AND articulos.tipo like '%".trim($tipo)."%'";
			}	
			
	if($marca!="")
			{
			$_pagi_sql.="AND articulos.marca like '%".trim($marca)."%'";
			$query2.="AND articulos.marca like '%".trim($marca)."%'";
			}	
			
	if($modelo!="")
			{
			$_pagi_sql.="AND articulos.modelo like '%".trim($modelo)."%'";
			$query2.="AND articulos.modelo like '%".trim($modelo)."%'";
			}	
			
	if($medida1!="")
			{
			$_pagi_sql.="AND articulos.medida1 = '$medida1'";
			$query2.="AND articulos.medida1 = '$medida1'";
			}	
			
	if($medida2!="")
			{
			$_pagi_sql.="AND articulos.medida2 = '$medida2'";
			$query2.="AND articulos.medida2 = '$medida2'";
			}		
			
	if($medida3!="")
			{
			$_pagi_sql.="AND articulos.medida3 = '$medida3'";
			$query2.="AND articulos.medida3 = '$medida3'";
			}	
			
	if($ano!="")
			{
			$_pagi_sql.="AND articulos.ano = '$ano'";
			$query2.="AND articulos.ano = '$ano'";
			}			
			
	if($estado!="")
			{
			$_pagi_sql.="AND articulos.estado like '%".trim($estado)."%'";
			$query2.="AND articulos.estado like '%".trim($estado)."%'";
			}		
			
	if($barra!="" and $clase==Cometas)
			{
			$_pagi_sql.="AND articulos.barra like '%".trim($barra)."%'";
			$query2.="AND articulos.barra like '%".trim($barra)."%'";
			}		
			
	if($reparaciones!="" and ($clase==Cometas or $clase==Tablas))
			{
			$_pagi_sql.="AND articulos.reparaciones like '%".trim($reparaciones)."%'";
			$query2.="AND articulos.reparaciones like '%".trim($reparaciones)."%'";
			}				
			
	if($ubicacion!="")
			{
			$_pagi_sql.="AND articulos.provincia like '%".trim($ubicacion)."%'";
			$query2.="AND articulos.provincia like '%".trim($ubicacion)."%'";
			}		
			
	if($precio!="")
			{
			$_pagi_sql.="AND anuncio.precio <= '$precio'";
			//$query2.="AND anuncio.precio <= '$precio'";
			}	
			
	if($orden_b=="" or $orden_b=="bump")
		$_pagi_sql.="ORDER BY bump DESC";
	if($orden_b=="fecha") $_pagi_sql.="ORDER BY fecha_cad";
	if($orden_b=="precio") $_pagi_sql.="ORDER BY precio";		
	
	//aqui incluyo el script paginator para que me genere la paginacion y establezco el limite de resultados.		
	$_pagi_cuantos = 10;
	$_pagi_nav_num_enlaces=5;
	include("paginator.inc.php");
			
			
			 
	global	$matriz_resultado3;		
	//$resultado=mysql_query($_pagi_sql);
	$resultado2=mysql_query($query2);	
	
	while ($registro=mysql_fetch_row($resultado2))
	$matriz_resultado2[]=array("cod_articulo"=>$registro[0],"direcc_imagen"=>$registro[1]);		
	$num_filas2 = mysql_num_rows($resultado2);
	if($num_filas2==0) $num_filas2=1;//esto lo pongo por si el usuario solo tiene un anuncio publicado,para q haga el bucle por lo menos
									 //una vez			
	while ($registro=mysql_fetch_row($_pagi_result))
	$matriz_resultado[]=array("cod_articulo"=>$registro[0],"titulo"=>$registro[1],"fecha_cad"=>$registro[2],"precio"=>$registro[3],"cod_anuncio"=>$registro[4],
	"provincia"=>$registro[5],"nick"=>$registro[6]);		
	$num_filas = mysql_num_rows($_pagi_result);
	
	for($i=0;$i<$num_filas;$i++){
		for($j=0;$j<$num_filas2;$j++){
			if($matriz_resultado2[$j]["cod_articulo"]==$matriz_resultado[$i]["cod_articulo"]){
				$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],"fecha_cad"=>$matriz_resultado[$i]["fecha_cad"],
				"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>$matriz_resultado2[$j]["direcc_imagen"],"cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"],
				"provincia"=>$matriz_resultado[$i]["provincia"],"nick"=>$matriz_resultado[$i]["nick"]);
				$j=$num_filas2;		
			}		
			else				
				$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],"fecha_cad"=>$matriz_resultado[$i]["fecha_cad"],
				"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>"iconos/icono-camara.jpg","cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"],
				"provincia"=>$matriz_resultado[$i]["provincia"],"nick"=>$matriz_resultado[$i]["nick"]);
		}
	}
		
		
	return $num_filas;
}


/*---------------FUNCION PARA RECUPERAR PREGUNTA SECRETA DEL USUARIO------------------------*/

function preg_secreta($nick){

	
	$nick=clean($nick);

	$query="SELECT preg_secreta FROM users where nick='$nick'";
	$resultado=mysql_query($query);
	$registro=mysql_fetch_row($resultado);
	$num_resultados=mysql_num_rows($resultado);
	$preg=array("preg_secreta"=>$registro[0],"num_resultados"=>$num_resultados);
	return $preg;
}

/*---------------FUNCION PARA RECUPERAR respuesta SECRETA DEL USUARIO------------------------*/

function resp_secreta($nick){

	
	$nick=clean($nick);

	$query="SELECT resp_secreta FROM users where nick='$nick'";
	$resultado=mysql_query($query);
	$registro=mysql_fetch_row($resultado);	
	$resp=array("resp_secreta"=>$registro[0]);
	return $resp;
}

/*----------------------FUNCIÓN DE ENVIO DE EMAIL PARA RECUPERAR CONTRASENA--------------------------*/

function mail_recup_contrasena($email){

	
	$nick=clean($email);
	
	$query="SELECT count(*),cod_usuario FROM users where email='$email'";
		$result=mysql_query($query) or die(mysql_error()); 
		$registro=mysql_fetch_array($result);	
		if($registro[0]>=1){
			$cod_usuario=$registro[1];
			$activate=$this->genera_random(20);
			$query="UPDATE users SET activate='$activate' WHERE cod_usuario='$cod_usuario'";
			$result=mysql_query($query) or die(mysql_error()); 
			
			$nombre_origen="Negotiable Kite";
			$email_origen="no_reply@negotiablekite.com";
			$email_destino=$email;
			$asunto="Recuperación de datos de cuenta en Negotiable Kite";
			$path="http://www.negotiablekite.com/";//Cuando suba la web al servidor tengo que tener en cuenta las rutas para la correcta url total de activacion	
			$activatelink=$path."reestablCont.php?id=".$cod_usuario."&activatekey=".$activate;
			
			$mensaje="<table width='629' border='0' cellspacing='1' cellpadding='2'> 
				<tr> 
					<td width='623' align='left'></td> 
				</tr> 
				<tr> 
					<td bgcolor='#2EA354'>
						<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
							<strong>Reestablecer contrase&ntilde;a</strong>
						</div>
					</td> 
				 </tr> 
				 <tr> 
					<td height='95' align='left' valign='top'>
						<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
						<br>Haz click en el siguiente link para reestablecer tu contrase&ntilde;a<br><br> 
						 <strong>LINK : </strong><a href='".$activatelink."'>".$activatelink."</a><br><br><br> 
						Este link te llevar&aacute; a una p&aacute;gina de Negotiable Kite en la que podr&aacute;s introducir una contrase&ntilde;a nueva.<br><br><br>       			 		  
						
						  
						 <strong>Un saludo de parte del equipo de 
						 <a href='http://www.negotiablekite.com'>Negotiable Kite</a> y BUEN VIENTO!!.</strong><br><br><br> 
						</div> 
					</td> 
				 </tr> 
				</table>"; 
				
				//*****************************************************************//
				$headers  = "From: $nombre_origen <$email_origen> \r\n"; 
				$headers .= "Return-Path: <$email_origen> \r\n"; 
				$headers .= "Reply-To: $email_origen \r\n"; 
				$headers .= "X-Sender: $email_origen \r\n"; 
				$headers .= "X-Priority: 3 \r\n"; 
				$headers .= "MIME-Version: 1.0 \r\n"; 
				$headers .= "Content-Transfer-Encoding: 7bit \r\n"; 
				$headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  
				//*****************************************************************//
				
			
				ini_set("SMTP","localhost"); 
				
				mail($email_destino, $asunto, $mensaje, $headers);
				return true;
			}
			else
				return false;
			
}

/*-----------------FUNCION PARA CAMBIAR LA CONTRASENA-------------------------------------*/

function cambia_contr($cod_usuario,$activatekey,$password){
	$cod_usuario=clean($cod_usuario);
	$activatekey=clean($activatekey);
	$password=md5(clean($password));
	$query="UPDATE users set password='$password' WHERE cod_usuario='$cod_usuario' and activate='$activatekey'";
	$result=mysql_query($query) or die(mysql_error()); 
	if(mysql_affected_rows()==1) 
		return true;
}

/*----------------FUNCION PARA ACTUALIZAR DATOS EN TABLA AL EDITAR ANUNCIO-----------------*/

function editar_anuncio($usuario,$titulo,$precio,$marca,$modelo,$medida1,$medida2,$medida3,$ano,$estado,$reparaciones,$descripcion,$cod_anuncio){

	$usuario=clean($usuario);
	$titulo=clean($titulo);$titulo=trim($titulo);
	$marca=clean($marca);
	$modelo=clean($modelo);
	$medida1=clean($medida1);
	$medida2=clean($medida2);
	$medida3=clean($medida3);
	$ano=clean($ano);
	$estado=clean($estado);	
	$reparaciones=clean($reparaciones);
	$descripcion=clean($descripcion);$descripcion=trim($descripcion);
	$precio=clean($precio);
	$cod_anuncio=clean($cod_anuncio);
	
	//ademas de todo esto tambien me aseguro dentro del query que el anuncio modificado pertenece al usuario que
	//esta realizando la modificacion
	
	if($usuario!="" and $titulo!="" and $precio!="" and $descripcion!="" and $cod_anuncio!=""){
		$query="UPDATE anuncio, articulos SET titulo='$titulo', precio='$precio', descripcion='$descripcion', marca='$marca', modelo='$modelo',
				medida1='$medida1', medida2='$medida2', medida3='$medida3', ano='$ano', estado='$estado', reparaciones='$reparaciones' WHERE
				anuncio.cod_anuncio='$cod_anuncio' AND (SELECT users.cod_usuario FROM users WHERE nick='$usuario')=anuncio.cod_usuario
				AND articulos.cod_articulo=anuncio.cod_articulo
				AND (SELECT users.cod_usuario FROM users WHERE nick='$usuario')=articulos.cod_usuario";
		$result=mysql_query($query) or die(mysql_error()); 
		return $editado=true;
	}
	else
	return $editado=false;
}

/*-----EDITAR IMAGENES ANUNCIO: MOVER IMAGENES A CARPETA IMAGENES Y COPIAR DIRECCION EN BD,BORRAR REGISTROS ANTIGUOS-----*/

function edit_images($codan,$nick,$path,$main_image){

	//Recupero el codigo del articulo
	$query="SELECT cod_articulo FROM anuncio WHERE cod_anuncio='$codan'";
	$result=mysql_query($query);
	if($result){
		$row= mysql_fetch_array($result);
		$cod_articulo=$row['cod_articulo'];
		
		$long_nick=strlen($nick);	
		
		
		if ($handle = opendir($path)){
			$archivos = array(); 
			$j=0;
			while ($archivo = readdir($handle)){ //primero recorro la carpeta de imagenes temporales para ver si hay ficheros con el nombre del usuario
				if ($archivo!="." and $archivo!=".."){
					$archivos[$j] = $archivo;
					
					if(substr($archivos[$j],7,$long_nick) == $nick){ //si encuentra coincidencia :
						copy($path.$archivos[$j],"imagenes/".$cod_articulo.$archivos[$j]);//copia el archivo de la carpeta temporal a la de imagenes
						unlink($path.$archivos[$j]);//y borra el archivo de la carpeta temporal		
						$numero_imagen=	substr($archivos[$j],6,1);					
						//if($numero_imagen==$main_image){//aqui compruebo que la imagen copiada es la principal de portada o no
							//$imagen_principal=1;	
							//$query="UPDATE imagenes SET imagen_principal='0' WHERE cod_articulo='$cod_articulo'";
							//mysql_query($query);											
						//}
						//else
							//$imagen_principal=0;
							
							
						//Ahora copio los datos de nombre de arhivo, etc en la base de datos imagenes
						$query="SELECT * FROM imagenes WHERE
						direcc_imagen LIKE '%imagenes/".$cod_articulo."imagen".$numero_imagen.$nick."%'";
						$result=mysql_query($query);
						if($result){
							if(mysql_num_rows($result)==1){								
								$query="UPDATE imagenes SET direcc_imagen='imagenes/".$cod_articulo.$archivos[$j]."', 
								imagen_principal='0' WHERE
								direcc_imagen LIKE '%imagenes/".$cod_articulo."imagen".$numero_imagen.$nick."%'";
								mysql_query($query);
								
								$row= mysql_fetch_array($result);
								$direccion=$row['direcc_imagen'];
								unlink($direccion);
							}
							else{
								$query="INSERT INTO imagenes(cod_articulo,direcc_imagen,imagen_principal)
								VALUES ('".$cod_articulo."','imagenes/".$cod_articulo.$archivos[$j]."','0')";
								mysql_query($query) or die(mysql_error()); 	
							}
						}
					}
					$j++;
				}
			}
		}
		if($main_image!=""){
			$query="UPDATE imagenes SET imagen_principal='0' WHERE cod_articulo='$cod_articulo'";
			mysql_query($query);
			$query="UPDATE imagenes SET imagen_principal='1' WHERE
			direcc_imagen LIKE '%imagenes/".$cod_articulo."imagen".$main_image.$nick."%'";
			mysql_query($query);
		}
	}
	
}


/*----------------------FUNCION PARA DEVOLVER DATOS DE USUARIO EN PERFIL-----------------*/

function datos_usuario($nick){
	$nick=clean($nick);
	if($nick!=""){
		$query="SELECT provincia, email, puntuacion_vend, puntuacion_comp, num_votos_vend,num_votos_comp FROM users WHERE
		nick='$nick' AND estado='0'";
		$result=mysql_query($query) or die(mysql_error());		
		if($result){ 
			if(mysql_num_rows($result) == 1){
				$datos=mysql_fetch_row($result);
				if($datos[2]==0) $datos[2]="--";
				if($datos[3]==0) $datos[3]="--";
				$matriz_resultado=array("ubicacion"=>$datos[0],"email"=>$datos[1],
				"puntuacion_vend"=>$datos[2],"puntuacion_comp"=>$datos[3],"num_votos_vend"=>$datos[4],"num_votos_comp"=>$datos[5]);
				return $matriz_resultado;
			}
		}
	}
}

/*----------------------FUNCION PARA ENVIAR MENSAJE A USUARIO DESDE PERFIL-----------------*/

function envia_mail_contactar($user,$mail_contacto,$motivo_contacto,$mensaje_contacto){

	//$matriz_destino=clean($matriz_destino);
	//$mail_contacto=clean($mail_contacto);
	//$motivo_contacto=clean($motivo_contacto);
	//$mensaje_contacto=clean($mensaje_contacto);
	
	$query="SELECT email FROM users WHERE nick='$user'";
	$result=mysql_query($query) or die(mysql_error());
	if($result){
		$row=mysql_fetch_array($result);
		$matriz_destino=$row['email'];
	}

	$nombre_origen="NEGOTIABLE KITE";
	$email_origen="no_reply@negotiablekite.com";
	$email_destino=$matriz_destino;
	$asunto="Un usuario de Negotiable Kite tiene una pregunta";
	
	$mensaje="<table width='629' border='0' cellspacing='1' cellpadding='2'> 
		<tr> 
			<td width='623' align='left'></td> 
		</tr> 
		<tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Email del usuario (RESPONDER A ESTA DIRECCION)</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='35' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:18px; margin-bottom:3px; font-weight:bold;'>
				".$mail_contacto." 
				</div> 
			</td> 
		 </tr> 
		<tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Motivo de contacto</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='30' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				".$motivo_contacto." 
				</div> 
			</td> 
		 </tr> 
		 <tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Mensaje</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				".$mensaje_contacto." 
				</div> 
			</td> 
		 </tr> 
		 
		 <tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				<br/>Un saludo de parte del equipo de <a href='http://www.negotiablekite.com'>Negotiable Kite</a>, y buen viento! 
				</div> 
			</td> 
		 </tr> 
		</table>"; 
		
		//*****************************************************************// 
		$headers  = "From: $nombre_origen <$email_origen> \r\n"; 
		$headers .= "Return-Path: <$email_origen> \r\n"; 
		$headers .= "Reply-To: $email_origen \r\n"; 
		$headers .= "X-Sender: $email_origen \r\n"; 
		$headers .= "X-Priority: 3 \r\n"; 
		$headers .= "MIME-Version: 1.0 \r\n"; 
		$headers .= "Content-Transfer-Encoding: 7bit \r\n"; 
		$headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  
		//*****************************************************************//
		
	
		ini_set("SMTP","localhost"); 
		
		mail($email_destino, $asunto, $mensaje, $headers);
		mail("superchauen@hotmail.com", $asunto, $mensaje, $headers);
		return $enviado_ok=true;
			
}

/*----------------------FUNCION PARA ENVIAR MENSAJE A USUARIO DESDE PAG ANUNCIO-----------------*/

function envia_mail_anuncio($user,$mail_contacto,$motivo_contacto,$mensaje_contacto,$codan){

	//$matriz_destino=clean($matriz_destino);
	//$mail_contacto=clean($mail_contacto);
	//$motivo_contacto=clean($motivo_contacto);
	//$mensaje_contacto=clean($mensaje_contacto);
	
	$query="SELECT email FROM users WHERE nick='$user'";
	$result=mysql_query($query) or die(mysql_error());
	if($result){
		$row=mysql_fetch_array($result);
		$matriz_destino=$row['email'];
	}

	$nombre_origen="NEGOTIABLE KITE";
	$email_origen="no_reply@negotiablekite.com";
	$email_destino=$matriz_destino;
	$asunto="Un usuario de Negotiable Kite tiene una pregunta";
	
	$mensaje="<table width='629' border='0' cellspacing='1' cellpadding='2'> 
		<tr> 
			<td width='623' align='left'></td> 
		</tr> 
		<tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Email del usuario (RESPONDER A ESTA DIRECCION)</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='30' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:18px; margin-bottom:3px; font-weight:bold;'>
				".$mail_contacto." 
				</div> 
			</td> 
		 </tr> 
		<tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Motivo de contacto</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='30' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				<a href='http://www.negotiablekite.com/anuncio.php?codan=".$codan."'>http://www.negotiablekite.com/anuncio.php?codan=".$codan."</a>
				<br />
				".$motivo_contacto." 
				</div> 
			</td> 
		 </tr> 
		 <tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Mensaje</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				".$mensaje_contacto." 
				</div> 
			</td> 
		 </tr> 
		 
		 <tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				<br/>Un saludo de parte del equipo de <a href='http://www.negotiablekite.com'>Negotiable Kite</a>, y buen viento! 
				</div> 
			</td> 
		 </tr> 
		</table>"; 
		
		//*****************************************************************// 
		$headers  = "From: $nombre_origen <$email_origen> \r\n"; 
		$headers .= "Return-Path: <$email_origen> \r\n"; 
		$headers .= "Reply-To: $email_origen \r\n"; 
		$headers .= "X-Sender: $email_origen \r\n"; 
		$headers .= "X-Priority: 3 \r\n"; 
		$headers .= "MIME-Version: 1.0 \r\n"; 
		$headers .= "Content-Transfer-Encoding: 7bit \r\n"; 
		$headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  
		//*****************************************************************//
		
	
		ini_set("SMTP","localhost"); 
		
		$enviado_ok = mail($matriz_destino, $asunto, $mensaje, $headers);
		mail("ventas@negotiablekite.com", $asunto, $mensaje, $headers);
		return $enviado_ok;
			
}


/*---------------FUNCIÓN DE ENVIO DE CONFIRMACIÓN DE EMAIL ENVIADO---------------*/

function envia_confirma_mail_anuncio($user,$mail_contacto,$motivo_contacto,$mensaje_contacto,$codan){

	//$matriz_destino=clean($matriz_destino);
	//$mail_contacto=clean($mail_contacto);
	//$motivo_contacto=clean($motivo_contacto);
	//$mensaje_contacto=clean($mensaje_contacto);
	
	$query="SELECT email FROM users WHERE nick='$user'";
	$result=mysql_query($query) or die(mysql_error());
	if($result){
		$row=mysql_fetch_array($result);
		$matriz_destino=$row['email'];
	}

	$nombre_origen="NEGOTIABLE KITE";
	$email_origen="no_reply@negotiablekite.com";
	$email_destino=$matriz_destino;
	$asunto="Confirmación de mensaje enviado";
	
	$mensaje="
	<div style='width:629px'>
		Tu mensaje de contacto con el usuario ".$user." ha sido enviado correctamente. En breve se pondr&aacute; en contacto contigo.
		<br /><br />
		Email enviado:
	</div>
	
	<table width='629' border='0' cellspacing='1' cellpadding='2'> 
		<tr> 
			<td width='623' align='left'></td> 
		</tr> 
		<tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Email del usuario</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='30' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				".$mail_contacto." 
				</div> 
			</td> 
		 </tr> 
		<tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Motivo de contacto</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='30' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				<a href='http://www.negotiablekite.com/anuncio.php?codan=".$codan."'>http://www.negotiablekite.com/anuncio.php?codan=".$codan."</a>
				<br />
				".$motivo_contacto." 
				</div> 
			</td> 
		 </tr> 
		 <tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Mensaje</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				".$mensaje_contacto." 
				</div> 
			</td> 
		 </tr> 
		 
		 <tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				<br/>Un saludo de parte del equipo de <a href='http://www.negotiablekite.com'>Negotiable Kite</a>, y buen viento! 
				</div> 
			</td> 
		 </tr> 
		</table>"; 
		
		//*****************************************************************// 
		$headers  = "From: $nombre_origen <$email_origen> \r\n"; 
		$headers .= "Return-Path: <$email_origen> \r\n"; 
		$headers .= "Reply-To: $email_origen \r\n"; 
		$headers .= "X-Sender: $email_origen \r\n"; 
		$headers .= "X-Priority: 3 \r\n"; 
		$headers .= "MIME-Version: 1.0 \r\n"; 
		$headers .= "Content-Transfer-Encoding: 7bit \r\n"; 
		$headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  
		//*****************************************************************//
		
	
		ini_set("SMTP","localhost"); 
		
		mail($mail_contacto, $asunto, $mensaje, $headers);
		
	
}

/*---------------FUNCION ENVIO MAIL REGISTRO-------------------*/

function mail_registro($email_contacto,$aleatorio){

	$query="INSERT INTO users (email,activate,estado) VALUES ('".$email_contacto."','".$aleatorio."','1')";
	mysql_query($query) or die(mysql_error());	

	$nombre_origen="NEGOTIABLE KITE";
	$email_origen="no_reply@negotiablekite.com";
	
	$asunto="Registro en Negotiable Kite";
	
	$mensaje="
	<html lang='es'>
<head>
<style>
#cabecera{
	height:115px;
	width:630px;
}

#cuerpo{
	width:618px;
	border:solid 2px;
	padding:4px;
}

.parrafo{
	margin-bottom:10px;
	text-align:justify;
}

#boton_reg{
	margin-bottom:40px;
	margin-top:35px;
	text-align:center;
}

#boton_reg a{
	text-decoration:none;
}

.enlaceboton {    font-family: verdana, arial, sans-serif;
    font-size: 10pt;
    font-weight: bold;
    padding: 4px;
    background-color: #ffffcc;
    color: #666666;
    text-decoration: none;
}
.enlaceboton:link,
.enlaceboton:visited {
    border-top: 1px solid #cccccc;
    border-bottom: 2px solid #666666;
    border-left: 1px solid #cccccc;
    border-right: 2px solid #666666;
}
.enlaceboton:hover {
    border-bottom: 1px solid #cccccc;
    border-top: 2px solid #666666;
    border-right: 1px solid #cccccc;
    border-left: 2px solid #666666;
} 

#bottom{
	width:618px;
	height:71px;
	background-color:#e4e2df;
}

#saludo{
	padding-top:11px;
	margin-left:8px;
}

#saludo a{
	color:#ff6501;
	font-weight:bold;
	text-decoration:none;
}

#saludo a:hover{
	color:#CCCC00;
}

#cr{
	text-align:center;
	font-size:12px;
	color:#ff6501;
	margin-top:12px;
}

</style>
</head>

<body>
<div id='cabecera'><img src='http://www.negotiablekite.com/iconos/cabecera_email_renovar.png'></img>	</div>
<div id='cuerpo'>	
	<div class='parrafo'>
		Hola!, si quieres tienes la posibilidad de registrarte en Negotiable Kite empleando esta dirección de correo (".$email_contacto."), simplemente pinchando en el siguiente bot&oacute;n.
	</div>
	<div id='boton_reg'>
		<a class='enlaceboton' href='http://www.negotiablekite.com/registro.php?ale=".$aleatorio."'>Registrar</a>
	</div>
	<div class='parrafo'>
		Registr&aacute;ndote tendr&aacute;s la posibilidad de publicar anuncios con el material de kite que quieras vender y de votar al resto de usuarios seg&uacute;n tus experiencias con ellos en las compras o ventas.
	</div>
	<div class='parrafo'>
		Adem&aacute;s pasar&aacute;s a formar parte de Negotiable Kite, el primer portal en internet dedicado a la publicaci&oacute;n de anuncios de kitesurf donde intentamos mejorar y a&ntilde;adir nuevas opciones para ofrecer un mejor servicio.
	</div>
	<div id='bottom'>
		<div id='saludo'>Un saludo de parte del equipo de <a href='http://www.negotiablekite.com'>NK</a> y buen viento!</div>
		<div id='cr'>&copy; Negotiable Kite</div>
	</div>
</div>
		
</body>
</html>
"; 
		
		//*****************************************************************// 
		$headers  = "From: $nombre_origen <$email_origen> \r\n"; 
		$headers .= "Return-Path: <$email_origen> \r\n"; 
		$headers .= "Reply-To: $email_origen \r\n"; 
		$headers .= "X-Sender: $email_origen \r\n"; 
		$headers .= "X-Priority: 3 \r\n"; 
		$headers .= "MIME-Version: 1.0 \r\n"; 
		$headers .= "Content-Transfer-Encoding: 7bit \r\n"; 
		$headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  
		//*****************************************************************//
		
	
		ini_set("SMTP","localhost"); 
		
		mail($email_contacto, $asunto, $mensaje, $headers);
}
	

/*--------------FUNCION PARA VOTAR VENDEDOR------------*/

function votar_vendedor($votado,$votador,$puntos_vendedor,$comentario_vendedor){

	$votado=clean($votado);
	$votador=clean($votador);
	$puntos_vendedor=clean($puntos_vendedor);
	$comentario_vendedor=clean($comentario_vendedor);
	$comentario_vendedor=trim($comentario_vendedor);
	
	if($votado!=$votador and $puntos_vendedor!=""){
	$hora_publ=strftime("%H");
	$minuto_publ=strftime("%M");
	$segundo_publ=strftime("%S");
	$dia_publ=strftime("%d");
	$mes_publ=strftime("%m");
	$ano_publ=strftime("%Y");
	$momento_actual_mktime=mktime($hora_publ,$minuto_publ,$segundo_publ,$mes_publ,$dia_publ,$ano_publ);	 
	$momento2=$momento_actual_mktime-4*24*3600;//al momento actual le quito 4 dias.tenpo de espera para volver a votar
	//si se encuentra un registro en la tabla en el q este momento es menor que el de la tabla, significa que no han transcurrido los
	//cuatro dias de rigor con lo que toca esperarse.
	$query="SELECT * FROM puntuacion_vendedor WHERE '$momento2'<fecha_voto AND votado='$votado' AND votador='$votador'";
	$query2="SELECT * FROM users WHERE cod_usuario='$votado' AND estado=0";
	$result=mysql_query($query) or die(mysql_error());		
	$result2=mysql_query($query2) or die(mysql_error());//hago esta query para asegurar q no votan a usuarios inexistentes o no activos	
		if($result){ 
			if(mysql_num_rows($result) >= 1)//significa que ya se habia votado hace menos d 4 dias a ese usuario
				return $votacion_ok=false;
			elseif($puntos_vendedor>=0 and $puntos_vendedor<=10 and mysql_num_rows($result2) >= 1){
				$query="INSERT INTO puntuacion_vendedor (votado,votador,fecha_voto,voto,comentario)
				 VALUES ('".$votado."','".$votador."','".$momento_actual_mktime."','".$puntos_vendedor."','".$comentario_vendedor."')";
				 mysql_query($query) or die(mysql_error());	
				 
				 $query="SELECT puntuacion_vend,num_votos_vend FROM users WHERE cod_usuario='$votado'";
				 $result=mysql_query($query) or die(mysql_error());	
				 $datos = mysql_fetch_assoc($result); 
				 $puntuacion_vend=$datos['puntuacion_vend'];
				 $num_votos_vend=$datos['num_votos_vend'];
				 
				 $puntuacion_vend=($puntuacion_vend*$num_votos_vend + $puntos_vendedor)/($num_votos_vend + 1);
				 $num_votos_vend++;
				 
				 $query="UPDATE users SET puntuacion_vend='$puntuacion_vend', num_votos_vend='$num_votos_vend' 
				 WHERE cod_usuario='$votado'";
				 mysql_query($query) or die(mysql_error());	
				 return $votacion_ok=true;
			}
		}
	}
}

/*--------------FUNCION PARA VOTAR COMPRADOR------------*/

function votar_comprador($votado,$votador,$puntos_comprador,$comentario_comprador){

	$votado=clean($votado);
	$votador=clean($votador);
	$puntos_comprador=clean($puntos_comprador);
	$comentario_comprador=clean($comentario_comprador);
	$comentario_comprador=trim($comentario_comprador);
	
	if($votado!=$votador and $puntos_comprador!=""){
	$hora_publ=strftime("%H");
	$minuto_publ=strftime("%M");
	$segundo_publ=strftime("%S");
	$dia_publ=strftime("%d");
	$mes_publ=strftime("%m");
	$ano_publ=strftime("%Y");
	$momento_actual_mktime=mktime($hora_publ,$minuto_publ,$segundo_publ,$mes_publ,$dia_publ,$ano_publ);	 
	$momento2=$momento_actual_mktime-4*24*3600;//al momento actual le quito 4 dias.tenpo de espera para volver a votar
	//si se encuentra un registro en la tabla en el q este momento es menor que el de la tabla, significa que no han transcurrido los
	//cuatro dias de rigor con lo que toca esperarse.
	$query="SELECT * FROM puntuacion_comprador WHERE '$momento2'<fecha_voto AND votado='$votado' AND votador='$votador'";
	$query2="SELECT * FROM users WHERE cod_usuario='$votado' AND estado=0";
	$result=mysql_query($query) or die(mysql_error());	
	$result2=mysql_query($query2) or die(mysql_error());//hago esta query para asegurar q no votan a usuarios inexistentes o no activos		
		if($result){ 
			if(mysql_num_rows($result) >= 1)//significa que ya se habia votado hace menos d 4 dias a ese usuario
				return $votacion_ok=false;
			elseif($puntos_comprador>=0 and $puntos_comprador<=10 and mysql_num_rows($result2) >= 1){
				$query="INSERT INTO puntuacion_comprador (votado,votador,fecha_voto,voto,comentario)
				 VALUES ('".$votado."','".$votador."','".$momento_actual_mktime."','".$puntos_comprador."','".$comentario_comprador."')";
				 mysql_query($query) or die(mysql_error());	
				 
				 $query="SELECT puntuacion_comp,num_votos_comp FROM users WHERE cod_usuario='$votado'";
				 $result=mysql_query($query) or die(mysql_error());	
				 $datos = mysql_fetch_assoc($result); 
				 $puntuacion_comp=$datos['puntuacion_comp'];
				 $num_votos_comp=$datos['num_votos_comp'];
				 
				 $puntuacion_comp=($puntuacion_comp*$num_votos_comp + $puntos_comprador)/($num_votos_comp + 1);
				 $num_votos_comp++;
				 
				 $query="UPDATE users SET puntuacion_comp='$puntuacion_comp', num_votos_comp='$num_votos_comp' 
				 WHERE cod_usuario='$votado'";
				 mysql_query($query) or die(mysql_error());	
				 return $votacion_ok=true;
			}
		}
	}
}
				
/*---NOMBRE DE USUARIO A PARTIR DE SU CODIGO---*/
function nick_usuario($cod_usuario){
	$cod_usuario=clean($cod_usuario);
	
	$query = "SELECT nick FROM users WHERE cod_usuario='$cod_usuario'";
	$result=mysql_query($query);	
	$row= mysql_fetch_array($result);
	$nick=$row['nick'];
	return $nick;	
}		 
				
				
		
/*--------------FUNCION PARA RECUPERAR ULTIMOS 5 VOTOS RECIBIDOS COMO VENDEDOR------------*/
function votos_recibidos_vendedor($cod_usuario){
	$cod_usuario=clean($cod_usuario);
	$query="SELECT nick, comentario FROM users,puntuacion_vendedor
	 WHERE users.cod_usuario=puntuacion_vendedor.votador AND puntuacion_vendedor.votado='$cod_usuario' ORDER BY fecha_voto DESC LIMIT 5 ";
	$result=mysql_query($query) or die(mysql_error());	
	if($result){
		$num_filas=mysql_num_rows($result);
		global $votos_vendedor;
		while ($registro=mysql_fetch_row($result))
		$votos_vendedor[]=array("nick"=>$registro[0],"comentario"=>$registro[1]);			
		return $num_filas;
	}
}

/*--------------FUNCION PARA RECUPERAR ULTIMOS 5 VOTOS RECIBIDOS COMO COMPRADOR------------*/
function votos_recibidos_comprador($cod_usuario){
	$cod_usuario=clean($cod_usuario);
	$query="SELECT nick, comentario FROM users,puntuacion_comprador
	 WHERE users.cod_usuario=puntuacion_comprador.votador AND puntuacion_comprador.votado='$cod_usuario' ORDER BY fecha_voto DESC LIMIT 5 ";
	$result=mysql_query($query) or die(mysql_error());	
	if($result){
		$num_filas=mysql_num_rows($result);
		global $votos_comprador;
		while ($registro=mysql_fetch_row($result))
		$votos_comprador[]=array("nick"=>$registro[0],"comentario"=>$registro[1]);			
		return $num_filas;
	}
}

/*-----------FUNCION PARA RECUPERAR TODOS USUARIOS REGISTRADOS Y SUS DATOS PUBLICOS------------------*/
function recupera_usuarios($nick,$orden){
	$nick=clean($nick);
	$orden=clean($orden);
	
	$_pagi_sql="SELECT nick, provincia, fecha_alta, puntuacion_vend, puntuacion_comp, num_votos_vend, num_votos_comp 
	FROM users WHERE estado=0 ";
	
	if($nick!="") $_pagi_sql.="AND nick LIKE '%".trim($nick)."%'";
	if($orden!=""){
		if($orden=="fecha") $_pagi_sql.="ORDER BY fecha_alta";
		if($orden=="usuario") $_pagi_sql.="ORDER BY nick";
	}
	else $_pagi_sql.="ORDER BY fecha_alta";
	
	$_pagi_cuantos = 50;
	$_pagi_nav_num_enlaces=10;
	include("paginator.inc.php");
		 
	global	$matriz_resultado;		
		
	while ($registro=mysql_fetch_row($_pagi_result))
	$matriz_resultado[]=array("nick"=>$registro[0],"provincia"=>$registro[1],"fecha_alta"=>$registro[2],
	"puntuacion_vend"=>$registro[3],"puntuacion_comp"=>$registro[4],"num_votos_vend"=>$registro[5],"num_votos_comp"=>$registro[6]);
	$num_filas = mysql_num_rows($_pagi_result);
	return $num_filas;
}		

/*-----------FUNCION PARA RECUPERAR DATOS USUARIO EN MI_PAGINA------------------*/
function datos_mi_pagina($nick){
	$nick=clean($nick);
	
	if($nick!=""){
		$query="SELECT provincia, email, puntuacion_vend, puntuacion_comp, num_votos_vend,num_votos_comp,cod_usuario 
		FROM users WHERE nick='$nick'";
		$result=mysql_query($query) or die(mysql_error());		
		if($result){ 
			if(mysql_num_rows($result) == 1){
				$datos=mysql_fetch_row($result);
				$momento_actual=$this->hora_actual();
				$query2="SELECT count(*) FROM anuncio WHERE cod_usuario='$datos[6]' AND fecha_cad>'$momento_actual'";
				$result2=mysql_query($query2) or die(mysql_error());
				if($result2) $datos2=mysql_fetch_row($result2);
				
				if($datos[2]==0) $datos[2]="--";
				if($datos[3]==0) $datos[3]="--";
				$matriz_resultado=array("ubicacion"=>$datos[0],"email"=>$datos[1],
				"puntuacion_vend"=>$datos[2],"puntuacion_comp"=>$datos[3],"num_votos_vend"=>$datos[4],"num_votos_comp"=>$datos[5],
				"en_venta"=>$datos2[0]);
				return $matriz_resultado;
			}
		}
	}
}

/*----------------FUNCION PARA MODIFICAR DATOS DE USUARIO-----------------*/

function editar_datos($usuario,$ubicacion){
	$usuario=clean($usuario);
	$ubicacion=clean($ubicacion);
		
	if($usuario!="" and $ubicacion!="" ){
		$query="UPDATE users SET provincia='$ubicacion'
		 WHERE nick='$usuario'";
		$result=mysql_query($query) or die(mysql_error()); 
		return $editado=true;
	}
	else
	return $editado=false;
}

/*--------------FUNCION PARA RECUPERAR TODOS LOS VOTOS RECIBIDOS COMO VENDEDOR------------*/
function votos_totales_vendedor($cod_usuario){

	$cod_usuario=clean($cod_usuario);
	
	$_pagi_sql="SELECT nick, comentario, fecha_voto, voto FROM users,puntuacion_vendedor
	 WHERE users.cod_usuario=puntuacion_vendedor.votador AND puntuacion_vendedor.votado='$cod_usuario' ORDER BY fecha_voto DESC ";
	 
	 $_pagi_cuantos = 50;
	$_pagi_nav_num_enlaces=5;
	include("paginator.inc.php");
		
	
		$num_filas=mysql_num_rows($_pagi_result);//este es el numero de filas por pagina de resultado. el total viene dado por la variable global
												// $_pagi_totalReg; incluida en el script paginator.inc.php
		global $votos_vendedor;
		while ($registro=mysql_fetch_row($_pagi_result)){
			$fecha=strftime("%d-%b-%Y",$registro[2]);
			$votos_vendedor[]=array("nick"=>$registro[0],"comentario"=>$registro[1],"fecha_voto"=>$fecha,"voto"=>$registro[3]);	
		}		
		return $num_filas;
	
}

/*--------------FUNCION PARA RECUPERAR TODOS LOS VOTOS RECIBIDOS COMO COMRADOR------------*/
function votos_totales_comprador($cod_usuario){

	$cod_usuario=clean($cod_usuario);
	
	$_pagi_sql="SELECT nick, comentario, fecha_voto, voto FROM users,puntuacion_comprador
	 WHERE users.cod_usuario=puntuacion_comprador.votador AND puntuacion_comprador.votado='$cod_usuario' ORDER BY fecha_voto DESC ";
	 
	 $_pagi_cuantos = 50;
	$_pagi_nav_num_enlaces=5;
	include("paginator.inc.php");
		
	
		$num_filas=mysql_num_rows($_pagi_result);//este es el numero de filas por pagina de resultado. el total viene dado por la variable global
												// $_pagi_totalReg; incluida en el script paginator.inc.php
		global $votos_vendedor;
		while ($registro=mysql_fetch_row($_pagi_result)){
			$fecha=strftime("%d-%b-%Y",$registro[2]);
			$votos_vendedor[]=array("nick"=>$registro[0],"comentario"=>$registro[1],"fecha_voto"=>$fecha,"voto"=>$registro[3]);	
		}		
		return $num_filas;
	
}

/*--------------FUNCION PARA ENVIAR EMAIL RECOMENDANDO ANUNCIO---------------*/

function recomienda_anuncio($nombre_recom,$email_rec,$codan){
	$nombre_origen="NEGOTIABLE KITE";
	$email_origen="no_reply@negotiablekite.com";
	$email_destino=$email_rec;
	$asunto="Un usuario de Negotiable Kite te recomienda un anuncio";
	
	$mensaje="<table width='629' border='0' cellspacing='1' cellpadding='2'> 
		<tr> 
			<td width='623' align='left'></td> 
		</tr> 
		<tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Amigo que te recomienda el anuncio</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='30' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				".$nombre_recom." 
				</div> 
			</td> 
		 </tr> 
		<tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					<strong>Motivo de contacto</strong>
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='30' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				Un usuario de Negotiable Kite cree que este anuncio puede interesarte 
				<a href='http://www.negotiablekite.com/anuncio.php?codan=".$codan."'>
					http://www.negotiablekite.com/anuncio.php?codan=".$codan."
				</a> 
				</div> 
			</td> 
		 </tr> 
		
		 
		 <tr> 
			<td bgcolor='#2EA354'>
				<div style='color:#FFFFFF; font-size:14; font-family: Arial, Helvetica, sans-serif; text-transform: capitalize; font-weight: bold;'>
					
				</div>
			</td> 
		 </tr> 
		 <tr> 
			<td height='' align='left' valign='top'>
				<div style=' color:#000000; font-family:Arial, Helvetica, sans-serif; font-size:12px; margin-bottom:3px;'>
				<br/>Un saludo de parte del equipo de <a href='http://www.negotiablekite.com'>Negotiable Kite</a>, y buen viento! 
				</div> 
			</td> 
		 </tr> 
		</table>"; 
		
		//*****************************************************************// 
		$headers  = "From: $nombre_origen <$email_origen> \r\n"; 
		$headers .= "Return-Path: <$email_origen> \r\n"; 
		$headers .= "Reply-To: $email_origen \r\n"; 
		$headers .= "X-Sender: $email_origen \r\n"; 
		$headers .= "X-Priority: 3 \r\n"; 
		$headers .= "MIME-Version: 1.0 \r\n"; 
		$headers .= "Content-Transfer-Encoding: 7bit \r\n"; 
		$headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  
		//*****************************************************************//
		
	
		ini_set("SMTP","localhost"); 
		
		mail($email_destino, $asunto, $mensaje, $headers);
		return $enviado_ok=true;
			
}

function contador($codan,$visitas){
	if($codan!=""){
	$visitas++;
		$query="UPDATE anuncio SET contador='$visitas'
			 WHERE cod_anuncio='$codan'";
			$result=mysql_query($query) or die(mysql_error()); 
	}
}

/*---------------------COMPROBACION DE QUE EL EMAIL NO EXISTE----------------*/

function email_existe($email){
	$query="SELECT * FROM users WHERE email='$email' AND nick!=''";
	$result=mysql_query($query) or die(mysql_error()); 
	if($result)
		if(mysql_num_rows($result)>=1)
			return true;
		else
			return false;
}

/*---------------------COMPROBACION DE QUE EL nick NO EXISTE----------------*/

function nick_existe($nick){
	$query="SELECT * FROM users WHERE nick='$nick'";
	$result=mysql_query($query) or die(mysql_error()); 
	if($result)
		if(mysql_num_rows($result)>=1)
			return true;
		else
			return false;
}

/*---------------DEFINICION DE FUNCION DE EMAIL PARA RENOVAR ANUNCIO----------------*/

function mail_renovar_anuncio($email,$codan,$ale,$nick,$titulo){			
		
		
		
		
		$nombre_origen="NEGOTIABLE KITE";
		$email_origen="no_reply@negotiablekite.com";
		$email_destino=$email;
		$asunto="Negotiable Kite: tu anuncio está apunto de caducar";
		
		$mensaje='<html lang="es">
<head>
<style>

#cabecera{
	height:115px;
	width:630px;
	background:url(http://www.negotiablekite.com/iconos/cabecera_email_renovar.png) no-repeat center center;
}

#linea_naranja{
	width:630px;
	height:14px;
	background-color:#ff6501;
}

#titulo{
	width:630px;
	height:29px;
	background-color:#000000;
	color:#ff6501;
	font-size:26px;
	text-align:center;
	font-weight:bold;
	line-height:29px;
}

#caja1{
	width:630px;
	height:142px;
	background-color:#e4e2df;
}

#caja1 #texto{
	padding-top:5px;
	margin-left:8px;
	margin-right:8px;
	text-align:justify;
}

.tn{
	color:#ff6501;
	font-weight:bold;
}

#caja1 #botones{
	margin-top:25px;
}

#caja1 #botones .boton{
	float:left;
	width:122px;
	height:25px;
	color:#ff6501;
	background-color:#504f4e;
	margin-left:68px;
	text-align:center;
	line-height:25px;
	font-weight:bold;
}

#caja1 #botones .boton a{
	color:#ff6501;
	text-decoration:none;
}

#caja1 #botones .boton a:hover{
	color:#CCCC00;
}

#linea_negra{
	width:630px;
	height:8px;
	background-color:#000000;
}

#bottom{
	width:630px;
	height:71px;
	background-color:#e4e2df;
}

#saludo{
	padding-top:11px;
	margin-left:8px;
}

#saludo a{
	color:#ff6501;
	font-weight:bold;
	text-decoration:none;
}

#saludo a:hover{
	color:#CCCC00;
}

#cr{
	text-align:center;
	font-size:12px;
	color:#ff6501;
	margin-top:12px;
}
	
</style>
</head>

<body>

<div id="cuerpo">
	<div id="cabecera"><img src="http://www.negotiablekite.com/iconos/cabecera_email_renovar.png"></img>	</div>
	<div id="linea_naranja"></div>
	<div id="titulo">TU ANUNCIO ESTÁ APUNTO DE EXPIRAR</div>	
	<div id="caja1">
		<div id="texto">
		Hola <span class="tn">'.$nick.'</span>, 
		el anuncio que tienes publicado en NK (
		<span class="tn">
			<a href="http://www.negotiablekite.com/anuncio.php?codan='.$codan.'">'.$titulo.'</a>
		</span>)
		est&aacute; apunto de expirar.<br />
		Si quieres renovarlo pincha en uno de los siguientes botones seg&uacute;n el tiempo que quieras extenderlo.
		</div>
		<div id="botones">
			<div class="boton"><a href="http://www.negotiablekite.com/renovar.php?codan='.$codan.'&time=1&ale='.$ale.'">
				Extender 15 d&iacute;as</a></div>
			<div class="boton"><a href="http://www.negotiablekite.com/renovar.php?codan='.$codan.'&time=2&ale='.$ale.'">
				Extender 30 d&iacute;as</a></div>
			<div class="boton"><a href="http://www.negotiablekite.com/renovar.php?codan='.$codan.'&time=3&ale='.$ale.'">
				Extender 60 d&iacute;as</a></div>
		</div>
	</div>
	<div id="linea_negra"></div>
	<div id="bottom">
		<div id="saludo">Un saludo de parte del equipo de <a href="http://www.negotiablekite.com">NK</a> y buen viento!</div>
		<div id="cr">&copy; Negotiable Kite</div>
	</div>
</div>
	
</body>
</html>'; 
			
			//*****************************************************************// 
			$headers  = "From: $nombre_origen <$email_origen> \r\n"; 
			$headers .= "Return-Path: <$email_origen> \r\n"; 
			$headers .= "Reply-To: $email_origen \r\n"; 
			$headers .= "X-Sender: $email_origen \r\n"; 
			$headers .= "X-Priority: 3 \r\n"; 
			$headers .= "MIME-Version: 1.0 \r\n"; 
			$headers .= "Content-Transfer-Encoding: 7bit \r\n"; 
			$headers .= "Content-Type: text/html; charset=iso-8859-1 \r\n";  
			//*****************************************************************//
			
		
			ini_set("SMTP", "localhost"); 
			
			mail($email_destino, $asunto, $mensaje, $headers);			 
}

function email_renovacion(){
	$momento_actual=$this->hora_actual();
	
	$momento_actual_mk=$this->strftomk($momento_actual);
	//se tienen que cumplir las condiciones fecha_cad - '$momento_actual'<=5 la cual transformaré en  fecha_cad <= '$momento_actual'+5(dias)
	// fecha_cad - '$momento_actual'> 0  la transformo en '$momento_actual' < fecha_cad
	
	$momento_mk=$momento_actual_mk+5*24*3600;
	//ahora esto lo vuelvo a pasar a strftime para compararlo con la fecha de la base de datos	
	$momento_strf=strftime("%Y-%m-%d %H:%M:%S",$momento_mk);
	
		
	$query="SELECT nick,email,titulo,cod_anuncio,fecha_cad FROM anuncio,users 
	WHERE  fecha_cad <= '$momento_strf' AND '$momento_actual' < fecha_cad  AND aviso_ren != 1 AND anuncio.cod_usuario = users.cod_usuario ";
	$result=mysql_query($query) or die(mysql_error()); 
	if($result)
		if(mysql_num_rows($result)>=1){
			
			while ($registro=mysql_fetch_row($result)){
				$ale_ren=$this->genera_random(5);
				$anuncios[]=array("nick"=>$registro[0],"email"=>$registro[1],"titulo"=>$registro[2]
				,"cod_anuncio"=>$registro[3],"fecha_cad"=>$registro[4],"ale_ren"=>$ale_ren);
				
				$query2="UPDATE anuncio SET aviso_ren=1,ale_ren='$ale_ren'
				WHERE cod_anuncio='$registro[3]'";
				$result2=mysql_query($query2) or die(mysql_error()); 
			}
			//ahora ya tengo una matriz con los datos de los anuncios y usuarios a los que hay que enviarle el email
			//se ha introducido el número aleatorio y se ha cambiado el aviso_ren a 1.
			
			//Ahora se envia el email de renovación de anuncio:
			for($i=0;$i<mysql_num_rows($result);$i++){
				$this->mail_renovar_anuncio($anuncios[$i]['email'],$anuncios[$i]['cod_anuncio'],$anuncios[$i]['ale_ren'],
				$anuncios[$i]['nick'],$anuncios[$i]['titulo']);
				sleep(4);
				echo "enviado email para anuncio nº ".$anuncios[$i]['cod_anuncio']."<br />";
			}			
		}
		
}

function renovar_anuncio($codan,$time,$ale){
	if($ale!=""){
						
		if($time==1) $ampliacion=15*24*3600;
		elseif($time==2) $ampliacion=30*24*3600;
		elseif($time==3) $ampliacion=60*24*3600;
		else
			$ampliacion=0;
			
		$codan = clean($codan); 
		$ale = clean($ale);
		$momento_actual=$this->hora_actual();
		
		$query="SELECT fecha_cad FROM anuncio WHERE cod_anuncio='$codan'";
		$result=mysql_query($query) or die(mysql_error()); 
		$row= mysql_fetch_array($result);
		$fecha_cad_str=$row['fecha_cad'];
		$fecha_cad_mk=$this->strftomk($fecha_cad_str);
		$nueva_fecha_cad_mk=$fecha_cad_mk+$ampliacion;
		$nueva_fecha_cad_str=strftime("%Y-%m-%d %H:%M:%S",$nueva_fecha_cad_mk);
		
		$query="UPDATE anuncio SET fecha_cad='$nueva_fecha_cad_str', ale_ren='',aviso_ren='0',bump='$momento_actual' WHERE cod_anuncio='$codan' AND ale_ren='$ale'";
		$actualizado=mysql_query($query) or die(mysql_error());
		if(mysql_affected_rows()>0) return true;
		else return false;
	}
}

//-------------FUNCION BOTON BUMP!---------------//

function bump($cod_usuario,$codan){
	$momento_actual=$this->hora_actual();
	$query="UPDATE anuncio SET bump='$momento_actual' WHERE cod_anuncio='$codan' AND cod_usuario='$cod_usuario'";
	$actualizado=mysql_query($query) or die(mysql_error());
}

/*-------------FUNCION LOGUEO USUARIOS FACEBOOK------------*/

function comprueba_existe_mail_fb($email){
	$query="SELECT * FROM users WHERE email='$email' AND nick !=''";
	$result=mysql_query($query) or die(mysql_error());
	if(mysql_num_rows($result)==0){
		$_SESSION['registrado']="no";
		$registrado="no";
		return $registrado;
	}
	else{
		$row= mysql_fetch_array($result);
		
		$_SESSION['SESS_MEMBER_ID'] = $row['nick']; 
		$_SESSION['SESS_MEMBER_EMAIL'] = $row['email'];
		$_SESSION['SESS_MEMBER_COD']=$row['cod_usuario'];
		$id_facebook=$_SESSION['SESS_MEMBER_ID_FACEBOOK'];
		if($row['id_facebook']!=$_SESSION['SESS_MEMBER_ID_FACEBOOK']){
			$query="UPDATE users SET id_facebook='$id_facebook' WHERE email='$email'";
			$result=mysql_query($query) or die(mysql_error());
		}
		
	}
}
	

/*------------ FUNCIÓN PARA RECUPERAR LOS ÚLTIMOS 4 ANUNCIOS PUBLICADOS------------------*/
/*
function ult_aun_publ(){
		
	$_pagi_sql="SELECT 	articulos.cod_articulo, titulo, precio,anuncio.cod_anuncio,articulos.provincia,nick FROM  anuncio, users, articulos WHERE users.cod_usuario=articulos.cod_usuario AND users.cod_usuario=anuncio.cod_usuario AND articulos.cod_articulo = anuncio.cod_articulo ORDER BY fecha_publ DESC LIMIT 4";
	$query2="SELECT articulos.cod_articulo,direcc_imagen FROM imagenes, users, articulos,anuncio WHERE 
			users.cod_usuario=articulos.cod_usuario AND articulos.cod_articulo=imagenes.cod_articulo AND imagen_principal='1' 
			ORDER BY imagenes.cod_articulo DESC";
	//atencion con poner un espacio al final del query antes de las comillas para que no de error al añadirle mas cláusulas AND!!!!					
			 
	global	$matriz_resultado3;		
	$resultado=mysql_query($_pagi_sql);
	$resultado2=mysql_query($query2);	
	
	while ($registro=mysql_fetch_row($resultado2))
	$matriz_resultado2[]=array("cod_articulo"=>$registro[0],"direcc_imagen"=>$registro[1]);		
	$num_filas2 = mysql_num_rows($resultado2);
	if($num_filas2==0) $num_filas2=1;//esto lo pongo por si el usuario solo tiene un anuncio publicado,para q haga el bucle por lo menos
									 //una vez			
	while ($registro=mysql_fetch_row($resultado))
	$matriz_resultado[]=array("cod_articulo"=>$registro[0],"titulo"=>$registro[1],"precio"=>$registro[2],"cod_anuncio"=>$registro[3],
	"provincia"=>$registro[4],"nick"=>$registro[5]);		
	$num_filas = mysql_num_rows($resultado);
	
	for($i=0;$i<$num_filas;$i++){
		for($j=0;$j<$num_filas2;$j++){
			if($matriz_resultado2[$j]["cod_articulo"]==$matriz_resultado[$i]["cod_articulo"]){
				$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],
				"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>$matriz_resultado2[$j]["direcc_imagen"],"cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"],
				"provincia"=>$matriz_resultado[$i]["provincia"],"nick"=>$matriz_resultado[$i]["nick"]);
				$j=$num_filas2;		
			}		
			else				
				$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],
				"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>"iconos/icono-camara.jpg","cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"],
				"provincia"=>$matriz_resultado[$i]["provincia"],"nick"=>$matriz_resultado[$i]["nick"]);
		}
	}
		
		
	return $num_filas;
}
*/
/*------------ FUNCIÓN PARA RECUPERAR LOS ÚLTIMOS 4 ANUNCIOS PUBLICADOS MEJORADO------------------*/

function ult_aun_publ(){
		
	$_pagi_sql="SELECT 	articulos.cod_articulo, titulo, precio,anuncio.cod_anuncio,articulos.provincia,nick FROM  anuncio, users, articulos WHERE users.cod_usuario=articulos.cod_usuario AND users.cod_usuario=anuncio.cod_usuario AND articulos.cod_articulo = anuncio.cod_articulo ORDER BY fecha_publ DESC LIMIT 4";
	
	global	$matriz_resultado3;		
	$resultado=mysql_query($_pagi_sql);	
			
	while ($registro=mysql_fetch_row($resultado))
	$matriz_resultado[]=array("cod_articulo"=>$registro[0],"titulo"=>$registro[1],"precio"=>$registro[2],"cod_anuncio"=>$registro[3],
	"provincia"=>$registro[4],"nick"=>$registro[5]);		
	$num_filas = mysql_num_rows($resultado);
	
	for($i=0;$i<$num_filas;$i++){
		$cod_articulo=$matriz_resultado[$i]["cod_articulo"];
		$query="SELECT direcc_imagen FROM imagenes WHERE cod_articulo='$cod_articulo' AND imagen_principal='1'";
		$resultado2=mysql_query($query);
		$array= mysql_fetch_array($resultado2);
		if($array['direcc_imagen']=="")
			$direcc_imagen="iconos/icono-camara.jpg";
		else
			$direcc_imagen=$array['direcc_imagen'];		
			
		$matriz_resultado3[$i]=array("titulo"=>$matriz_resultado[$i]["titulo"],"precio"=>$matriz_resultado[$i]["precio"],"direcc_imagen"=>$direcc_imagen,"cod_anuncio"=>$matriz_resultado[$i]["cod_anuncio"],
				"provincia"=>$matriz_resultado[$i]["provincia"],"nick"=>$matriz_resultado[$i]["nick"]);	
		}	
		
		
	return $num_filas;
}

/*-----------FUNCION PARA DEVOLVER MARCAS MAS ANUNCIADAS-------------*/

function marcas_mas_anunciadas(){
	$query="SELECT * FROM marcas 
		WHERE marcas.marca = 
		ANY (SELECT articulos.marca FROM articulos GROUP BY articulos.marca ORDER BY COUNT(articulos.marca) DESC) LIMIT 20";
	$result=mysql_query($query) or die(mysql_error());
	if($result){			
		global $num_marcas;
		$num_marcas = mysql_num_rows($result);
		while ($registro=mysql_fetch_row($result)){
			$marcas[]=array("marca"=>$registro[1],"web"=>$registro[2],"direc_img"=>$registro[3]);
		}
	}
	return $marcas;
}
			

	
}/*FIN DE LA CLASE*/



?>
