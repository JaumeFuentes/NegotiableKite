// JavaScript Document
window.onload = initForm;


function initForm() {
	
	
	 document.getElementById("eliminar").onclick = eliminar;
	 
	  if(confirm("Are you sure you want to do that?"))
		alert("Anuncio eliminado");
	else
		//this.href="en_venta.php;
		alert("Anuncio");
	
}
	


function eliminar() {
	
	if(confirm("Are you sure you want to do that?"))
		alert("Anuncio eliminado");
	else
		//this.href="en_venta.php;
		alert("Anuncio");
			
}
