<?php 
if(isset($_POST['encender']))
	exec("sudo ./encender");
	
if(isset($_POST['apagar']))
	exec("sudo ./apagar");	
 ?>
 
<form method="post" action="">
	<input type="hidden" name="encender" value="si" />
	<input type="submit" value="encender led" />	
</form>

<form method="post" action="">
	<input type="hidden" name="apagar" value="si" />
	<input type="submit" value="apagar led" />	
</form>
