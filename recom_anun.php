<?php
include_once 'core/init.inc.php';
$las_webs=new webs;

if(!isset($_POST["nombre_recom"])) $nombre_recom="";
else $nombre_recom=trim($_POST["nombre_recom"]);
if(!isset($_POST["email_rec"])) $email_rec="";
else $email_rec=trim($_POST["email_rec"]);
if(!isset($_POST["check_cond"])) $check_cond="";
else $check_cond=$_POST["check_cond"];
if(!isset($_GET["codan"])) $codan="";
else $codan=$_GET["codan"];

if($nombre_recom!="" and $email_rec!="" and $check_cond!="" )
	$enviado_ok=$las_webs->recomienda_anuncio($nombre_recom,$email_rec,$codan)
	
?>
<html >
<head>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script src="/javascript/recom_anun.js"></script>

<style type="text/css" >

html,body{	
	overflow: hidden;
	background-color: #eeeeee;	
	padding:0px
	margin:0px;
}

form{
	padding-left:10px;
}

form input[type=text]{
	width:400px;
}

form input[type=submit]{
	cursor: pointer;	
	border:1px solid #a6a498;
	color:#666666;
	margin-top:5px;
	float:left;
	font-family:"Arial Black";
	font-size:11px;
}
#condiciones a{
	text-decoration:none;
	color:#000000;
}

.invalid {
	background-color: #FF9;
	border: 2px red inset;
}

#enviado_ok_anuncio2{
	height:37px;
	width:37px;
	background:url(iconos/checked2.png) no-repeat;
	margin-left:10px;
	float:left;
}

</style>
</head>
<body >

<form action="" method="post">
	<div>
		<div>
			<label>tu nombre (*)</label>
		</div>
		<input type="text" class="reqd" name="nombre_recom" value="<?php echo $nombre_recom;?>" />
	</div>
	<div>
		<div>
			<label>correo electrónico de tu amigo (*)</label>
		</div>
		<input type="text" class="reqd email" name="email_rec" value="" />
	</div>
	<div>
		<input type="checkbox" class="box" name="check_cond" value="check_cond" />
		<span id="condiciones">
			<a href="condiciones_uso.html" target="_blank"> Acepto las condiciones de uso y la pol&iacute;tica de privacidad
			</a>
		</span>
	</div>
	<input type="submit" value="enviar" />
	<?php if($enviado_ok==true)
			echo "<div id='enviado_ok_anuncio2'></div>";				
	?>
</form>


</body>
</html>
