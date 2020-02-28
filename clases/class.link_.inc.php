<?php
class Link_ {
	public $id;
	public $seccion;
	public $nombre;
	public $url;
	public $descripcion;
	public $clicks;
	public $puntuacion;
	
	public function __construct($link){
		if ( is_array($link) ){
			$this->id = $link['link_id'];
			$this->seccion = $link['link_seccion'];
			$this->nombre = $link['link_nombre'];
			$this->url = $link['link_url'];
			$this->descripcion = $link['link_descripcion'];
			$this->clicks = $link['link_clicks'];
			$this->puntuacion = $link['link_puntuacion'];
		}
		else
		{
		throw new Exception("No event data was supplied.");
		}
	}
}
?>