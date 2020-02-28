<?php
class Tiendas extends DB_Connect{
	
	function __construct(){
		parent::__construct();
	}
	
	private function loadData(){
		$sql = "SELECT nombre_tienda, provincia, localidad, direccion, web, telefono, email, descripcion FROM tiendas
				ORDER BY provincia";
		$resultado=mysql_query($sql);
		if($resultado){
			$arr_tiendas_nk = $this->loadTiendasNk();
								
			while ($registro=mysql_fetch_row($resultado)){				
				foreach ( $arr_tiendas_nk as $tienda_nk ){					
					if($tienda_nk['email']==$registro[6]){
						$nick = $tienda_nk['nick'];						
						break;						
					}
					else
						$nick = "";
				}
				
				$tiendas[]=array("nombre_tienda"=>$registro[0],"provincia"=>$registro[1],"localidad"=>$registro[2],
				"direccion"=>$registro[3],"web"=>$registro[4],"telefono"=>$registro[5],
				"email"=>$registro[6],"descripcion"=>$registro[7],"nick"=>$nick);	
			}
			return $tiendas;
		}
		else { 
			die("Fallo el Query!"); 
		} 
	}
	
	private function loadTiendasNk(){
		$sql = "SELECT users.nick, tiendas.email FROM tiendas, users WHERE tiendas.email = users.email AND estado = '0'";
		$resultado=mysql_query($sql);
		if($resultado){
			while ($registro=mysql_fetch_row($resultado))
				$tiendas_nk[]=array("nick"=>$registro[0],"email"=>$registro[1]);	
										
			return $tiendas_nk;
		}
		else { 
			die("Fallo el Query2!"); 
		} 
	}
	
	
	private function createTiendaObj(){
		/*
		 * Load the events array
		 */
		$arr = $this->loadData();
		/*
		 * Create a new array, then organize the shops
		 * by the province
		 */
		$tiendas = array();
		foreach ( $arr as $tienda ){
			$provincia = $tienda['provincia'];			
			try
			{
			$tiendas[$provincia][] = new Tienda_($tienda);
			}
			catch ( Exception $e )
			{
			die ( $e->getMessage() );
			}
		}
		return $tiendas;		
	}
		
	
	public function generateTiendas($provincia){
		$k=0;
		$tiendas = $this->createTiendaObj();
		foreach($tiendas as $provincia=>$tienda){
			$k=0;
			echo '
				  <div class="tit_provincias">
				  	<div class="texto_provincias">'.$provincia.'</div>
					<div class="linea"></div>
				  </div>';
			echo '<div style="clear:both"></div>';
			//Foreach interno		
			foreach ( $tiendas[$provincia] as $tienda ){
				//if($seccion==$link->seccion){
					$k%2!=0? $addclass = "" : $addclass = "odd";
					echo '
						<div class="tiendas_box '.$addclass.'">
							<div class="tit_click">
								<div class="titulo">';
								if($tienda->web != ""){
									echo '
									<a href="'.$tienda->web.'" class ="" target="_blank">'.$tienda->nombre_tienda.'</a>  ';
								}
								else
									echo  $tienda->nombre_tienda;
								echo '             	
								</div>
								<div class="clicks">';
								if($tienda->nick!="")
									echo ' <img src="../layout/tiendas_nk.png" />';
									
								echo '	
								</div>                
							</div>
							<div class="descripcion">
								<div class="separa">
								'.$tienda->direccion.',&nbsp; '.$tienda->localidad.'&nbsp; ('.$tienda->provincia.')<br />
								</div>
								<div class="separa">
								'.$tienda->email.',&nbsp; '.$tienda->telefono.'<br />
								</div>';
								if($tienda->nick!=""){
									echo '
								<div class="links_nk">
									<span class="boton"><a href="perfil.php?user='.$tienda->nick.'">Ver perfil en NK</a></span>
									<span class="boton"><a href="en_venta_publ.php?user='.$tienda->nick.'">Anuncios publicados</a></span>
								</div>';
								}
								echo '
							</div>
						</div>';
					$k++;
				//}
			}//fin de foreach interno
		}//fin de foreach externo
	}	
	
	
	
	
	
}
		
		
?>