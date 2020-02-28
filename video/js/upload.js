$(document).ready(function() {
	$("#duration").mask("99:99");
	
	$('input[name="mediafile"]').change(function(){
		$('#error-placeholder').hide();
		$('#upload-video-extra').slideDown();
	
	});
	
	$('input[type="submit"]').click(function(){
	
		var error_div = $('#error-placeholder');
		
		if ($('input[name="mediafile"]').val() == '') {
			error_div.html(pm_lang.validate_select_file).show();
			return false;
		}
		if ($('input[name="video_title"]').val() == '') {
			error_div.html(pm_lang.validate_video_title).show(); 
			return false;
		}
		if ($('select[name="category"]').val() == '-1') {
			error_div.html(pm_lang.choose_category).show();
			return false;
		}
				
	});
});