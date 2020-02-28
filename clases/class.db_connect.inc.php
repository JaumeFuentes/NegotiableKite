<?php
class DB_Connect {
	var $DBHost;
	var $DBUser;
	var $DBPass;
	var $DBName;
	
	 protected function __construct(){
		$this->DBHost="db370324546.db.1and1.com";
		$this->DBUser="dbo370324546";
		$this->DBPass="j8ef6sm80r";
		$this->DBName="db370324546";
		 		
		 if($_SESSION['servidor']=='192.168.1.159' or $_SESSION['servidor']=="superchauen.sytes.net"){		 
			 $this->DBHost="localhost";
			 $this->DBUser="root";
			 $this->DBPass="000177";
			 $this->DBName="db370324546";
		 }
		 
		 
			 $this->DBHost="localhost";
			 $this->DBUser="root";
			 $this->DBPass="";
			 $this->DBName="db370324546";
		 
		
		 //compruebo que el servidor responde
		 @mysql_connect($this->DBHost,$this->DBUser,$this->DBPass)
		 	or die("NO SE PUEDE CONECTAR AL SERVIDOR MYSQL");
			
		//intentamos seleccionar la base de datos negotiable
		if(!mysql_select_db($this->DBName))
			die("NO SE PUEDE SELECCIONAR LA BASE DE DATOS NEGOTIABLE");
	}
}

?>