<?php
class Tienda_ {
	public $nombre_tienda;
	public $provincia;
	public $localidad;
	public $direccion;
	public $web;
	public $telefono;
	public $email;
	public $descripcion;
	public $nick;
	
	public function __construct($tienda){
		if ( is_array($tienda) ){
			$this->nombre_tienda = $tienda['nombre_tienda'];
			$this->provincia = $tienda['provincia'];
			$this->localidad = $tienda['localidad'];
			$this->direccion = $tienda['direccion'];
			$this->web = $tienda['web'];
			$this->telefono = $tienda['telefono'];
			$this->email = $tienda['email'];
			$this->descripcion = $tienda['descripcion'];
			$this->nick = $tienda['nick'];
		}
		else
		{
		throw new Exception("No event data was supplied.");
		}
	}
}
?>