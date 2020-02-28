<?php

//este escript es llamado mediante ajax desde un script en estado_envio
//es para comprobar los emails que faltan por enviar.
include "../clases/phpmailer/class.phpmailer.php";
include "../clases/clase_email.php";
!isset($_REQUEST['grupo'])? $grupo="" : $grupo=$_REQUEST['grupo'];
$objeto_email = new clase_emails;
echo $objeto_email->emails_restantes($grupo);

?>