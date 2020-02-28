$(document).ready(function(){
	$(".links_nk .boton").mousedown(function(){
		var cssObj = {
			'border-bottom' : 'none',
			'border-right' : 'none',
			'border-top' : '2px solid #BBBBBB',
			'border-left' : '2px solid #BBBBBB'
		};
		$(this).css(cssObj);										
	});
	
	$(".links_nk .boton").mouseup(function(){
		var cssObj = {
			'border-bottom' : '2px solid #BBBBBB',
			'border-right' : '2px solid #BBBBBB',
			'border-top' : 'none',
			'border-left' : 'none'
		};
		$(this).css(cssObj);										
	});
});