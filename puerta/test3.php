<?php 
if(isset($_POST['encender'])){
	exec("sudo ./encender");
	//sleep(2);
	//exec("sudo ./apagar");	
}
	
if(isset($_POST['apagar']))
	exec("sudo ./apagar");	
 ?>
<htm>
<head>
<title>PUERTA GARAJE </title>
<style>
	#contenido{
		width:500px;
		margin-left:auto;
		margin-right:auto;
		text-align:center;
	}
	
	#formulario input[type=submit]{
		margin-top:50px;
		width:400px;
		height:200px;
		font-size:40px;
		font-family:Arial, Helvetica, sans-serif;
		color:#666;
		border:5px solid #ccc;
		text-align:center;
		cursor:pointer;
	}
	
</style>
</head>
<body>
<div id="contenido">
    <form id="formulario" method="post" action="">
        <input type="hidden" name="encender" value="si" />
        <input type="submit" value="Encender Luz" />	
    </form>
    <form id="formulario" method="post" action="">
        <input type="hidden" name="apagar" value="si" />
        <input type="submit" value="Apagar Luz" />	
    </form>
    <!--
    <form method="post" action="">
        <input type="hidden" name="apagar" value="si" />
        <input type="submit" value="apagar led" />	
    </form>-->
</div>
</body>
</head>