$(document).ready( function(){	
	
		$(".link_menu").click(function(){			
			clase=this.className;			
			var id = clase.substr(16);
			datos="id="+id;
			$.ajax({
			   url:'func_ajax_php/links_ajax.php',
			   data:datos,
			   success:function(msg){
				   $('.clicks'+id).html(msg);				
				}
			});//cierro ajax
		});
	
	});