<?php 

$grupo=1;
?>
<html>
<head></head>
<body>
<div id="contador">hola</div>
</body>
</html>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
	var i=0;
	$(document).ready(function(){
							window.setInterval(scroll,2000);//ejecuta la funcion scroll cada 2000 ms							
						}						
					);
	function scroll(){
		datos="grupo=<?php echo $grupo ?>";								
		$.ajax({
			   url:'control_envio_mail.php',
			   data:datos,
			   success:function(msg){													  		 
						 $('#contador').html(msg);
						}
			   });	
	}
</script>

