<?php
class Links extends DB_Connect{
	function __construct(){
		parent::__construct();
	}
	
	private function loadData(){
		$sql = "SELECT id, seccion, nombre, url, descripcion, puntuacion, clicks FROM links";
		$resultado=mysql_query($sql);
		if($resultado){
			while ($registro=mysql_fetch_row($resultado))
				$links[]=array("link_id"=>$registro[0],"link_seccion"=>$registro[1],"link_nombre"=>$registro[2],
				"link_url"=>$registro[3],"link_descripcion"=>$registro[4],"link_puntuacion"=>$registro[5],
				"link_clicks"=>$registro[6]);					
			return $links;
		}
		else { 
			die("Fallo el Query!"); 
		} 
	}
	
	private function createLinkObj(){
		$arr = $this->loadData();
		$links = array();
		foreach ( $arr as $link ){
			try{
				$links[] = new Link_($link);
			}
			catch ( Exception $e )
			{
			die ( $e->getMessage() );
			}			
		}
		return $links;		
	}
	
	public function createList($seccion){
		$links = $this->createLinkObj();
		foreach ( $links as $link ){
			if($seccion==$link->seccion)
				$listaLink .= '<li><a href="'.$link->url.'" class ="link_menu linkId'.$link->id.'" target="_blank">'.$link->nombre.'</a></li>';
		}
		return $listaLink;
	}
	
	public function addClick($id){
		if($id){
			$sql = "UPDATE links SET clicks=clicks+1 WHERE id = '$id'";
			mysql_query($sql);
			$sql = "SELECT clicks FROM links WHERE id = '$id'";
			$row = mysql_query($sql);
			$result = mysql_fetch_assoc($row); 
			$clicks = $result['clicks'];
			return $clicks;
		}		
	}
	
	public function generateLinks($seccion){
		$k=0;
		$links = $this->createLinkObj();
		foreach ( $links as $link ){
			if($seccion==$link->seccion){
				$k%2!=0? $addclass = "" : $addclass = "odd";
				echo '
					<div class="link_box '.$addclass.'">
						<div class="tit_click">
							<div class="titulo">
								<a href="'.$link->url.'" class ="link_menu linkId'.$link->id.'" target="_blank">'.$link->nombre.'</a>                	
							</div>
							<div class="clicks">
								<img src="../layout/icono_clicks.png" />
								<span><b class="clicks'.$link->id.'">'.$link->clicks.'</b></span>&nbsp;clicks
							</div>                
						</div>
						<div class="descripcion">
							'.$link->descripcion.'
						</div>
					</div>';
				$k++;
			}
		}
	}
	
	public function generaListaLinks(){
		$secciones = array('foros','blogs','videos','meteo','webcams','revistas','webs','clubs');
		$listaLinks = '<ul>';
		foreach($secciones as $seccion){
			$listaLinks .= '
				<li><a href="/links/'.$seccion.'">'.$seccion.'</a>
					 <ul>';
						$listaLinks .= $this->createList($seccion);
			$listaLinks .= '
					</ul>
				</li>';
		}
		$listaLinks .= '</ul>';
		return $listaLinks;
		
	}
					
	
}
		
		
?>