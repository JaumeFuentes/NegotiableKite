<script type="text/javascript">

	// Loading ...
	document.getElementById("loading").style.display="block";
	
	function addLoadEvent(func) {
	  var oldonload = window.onload;
	  if (typeof window.onload != 'function') {
		window.onload = func;
	  } else {
		window.onload = function() {
		  if (oldonload) {
			oldonload();
		  }
		  func();
		}
	  }
	}
	
	addLoadEvent(function() {
	  document.getElementById("loading").style.display="none";
	});

    //$('#sideNav') .css({'min-height': (($('.content').height()))+'px'});
	
	//===== Color picker =====//
<?php if($load_colorpicker == 1): ?>

	$("#bg_bar").colorpicker().on("changeColor", function(ev){
		hex = ev.color.toHex();
		$("#bg_bar").val(hex);
	});
	$("#play_timer").colorpicker().on("changeColor", function(ev){
		hex = ev.color.toHex();
		$("#play_timer").val(hex);
	});
<?php endif; ?>

<?php if($load_uniform == 1): ?>
	$("input:file").uniform();
<?php endif; ?>

	$('#test-email').click(function(event){
		event.preventDefault();
		$('#loader').show();
		$.ajax({
			url: 'settings.php',
			data: {
				action: 'testmail',
				mail_server	: $('input[name=mail_server]').val(),
				mail_port	: $('input[name=mail_port]').val(),
				mail_user	: $('input[name=mail_user]').val(),
				mail_pass	: $('input[name=mail_pass]').val(),
				mail_smtp	: $('input[name=issmtp]:checked').val(),
				contact_email: $('input[name=contact_mail]').val()
			},
			type: 'POST',
			dataType: 'json',
			success: function(data){
				$('#test-email-response').html(data['message']).show();
				$('#loader').hide();
			}
		});
		return false;
	});

	$(".editadzone").click(function(){ // Click to only happen on announce links
		$("#adzoneid").val($(this).data('id'));
	});

<?php if($load_scrolltofixed == 1): ?>
	$('#stack-controls').scrollToFixed({ 
		bottom: 0,
		limit: $('#stack-controls').offset().top, //.top
		preFixed: function() { $(this).css({'background-color' : '#FFF', 'box-shadow' : '2px 0 6px #CCC', 'padding' : '5px 20px' }); },
		postFixed: function() { $(this).css({'background-color': '', 'box-shadow' : 'none', 'padding' : '10px 0px'}); }
	});

	$('#import-nav').scrollToFixed({ 
        preFixed: function() { $(this).css({'background-color' : '#FFF', 'box-shadow' : '2px 0 6px #CCC', 'padding-right' : '10px' }); $(this).find('h2').css('visibility', 'hidden'); },
        postFixed: function() { $(this).css({'background-color': '', 'box-shadow' : 'none', 'padding-right' : '0px'}); $(this).find('h2').css('visibility', 'visible'); }
	});
	/*$('#sideNav').scrollToFixed({ bottom: 0, limit: $('#wrapper').offset().top });*/

<?php endif; ?>
<?php if($load_tagsinput == 1): ?>
	var tidyTags = function(e){
		var tags = ($(e.target).val() + ',' + e.tags).split(',');
		var target = $(e.target);
		target.importTags('');
		for (var i = 0, z = tags.length; i<z; i++) {
			var tag = $.trim(tags[i]);
			if (!target.tagExist(tag)) {
				target.addTag(tag);
			}
		}
	}
	$('input[id^="tags_addvideo_"]').tagsInput({
		onAddTag : function(tag){
		if(tag.indexOf(',') > 0){
			tidyTags({target: 'input[id^="tags_addvideo_"]', tags : tag});
			 }
		 },
		'removeWithBackspace' : true,
		'height':'auto',
		'width':'auto',
		'defaultText':'',
		'minChars' : 3,
		'maxChars' : 90
	});
<?php endif; ?>

	$("img[name='video_thumbnail']").click(function() {
		
		var img = $(this);
		var row_id = $(this).attr('rowid');
		var ul = img.parents('.thumbs_ul_import');
		var li = img.parent();
		var tr = img.parents('div');	
		var input = $('#thumb_url_'+ row_id);
	
		if ( ! li.hasClass('stack-thumb-selected'))
		{
			ul.children().removeClass('stack-thumb-selected').addClass('stack-thumb');
			li.addClass('stack-thumb-selected');
			input.val(img.attr('src'));
		}
	});


<?php if($load_ibutton == 1): ?>
	$('.on_off :checkbox').iButton({
		duration: 80,
		labelOn: "",
		labelOff: "",
		enableDrag: false 
	});

    $("#checkall").click(function () {
		$('.on_off :checkbox').iButton("repaint");
		if($('.on_off :checkbox').is(":checked")) {
		  $('.video-stack').addClass("stack-selected");
		}else {
		  $('.video-stack').removeClass("stack-selected");
		}
    });
<?php endif; ?>

	$('.on_off :checkbox').change(function () {
		if ($(this).attr("checked")) {
			$(this).closest('.video-stack').addClass("stack-selected");
		} 
		else {
		$(this).closest('.video-stack').removeClass("stack-selected");
		}
	});


	$(document).ready(function () {
		 $("input[id^='featured'][type=checkbox]").change(function () { $('#value-featured').text('updated').addClass('label label-success'); });
		 $("input[id^='visibility'][type=radio]").change(function () { $('#value-visibility').text('updated').addClass('label label-success'); });
		 $("input[id^='restricted'][type=radio]").change(function () { $('#value-register').text('updated').addClass('label label-success'); });
		 $("input[class^='pubDate']").change(function () { $('#value-publish').text('updated').addClass('label label-success'); });
		 $("select[class^='pubDate']").change(function () { $('#value-publish').text('updated').addClass('label label-success'); });
		 $("input[id^='site_views_input']").change(function () { $('#value-views').text('updated').addClass('label label-success'); });
		 $("input[id^='submitted']").change(function () { $('#value-submitted').text('updated').addClass('label label-success'); });
		 $("input[id^='allow_comments']").change(function () { $('#value-comments').text('updated').addClass('label label-success'); });
		 $("input[id^='yt_length']").change(function () { $('#value-yt_length').text('updated').addClass('label label-success'); });		 
	
         $("input[id^='import-'][type=checkbox]").each(function(){
             $(this).change(updateCount);
         });
         
         $("#checkall").each(function(){
             $(this).change(updateCount);
         });
         updateCount();
         
         function updateCount(){
             var count = $("input[id^='import-'][type=checkbox]:checked").size();
             
             $("#count").text(count);
             $("#status").toggle(count > 0);
         };

		var cc = $.cookie('list_grid');
		if (cc == 'g') {
			$('#vs-grid').addClass('vs-grid');
		} else {
			$('#vs-grid').removeClass('vs-grid');
		}

		var list_filter = $.cookie('list_filter');
		if (list_filter == null) {
			$('#showfilter-content').show();
		} else {
			$('#showfilter-content').hide();
		}	
	});

	$('#stacks').click(function() {
		$('#vs-grid').fadeOut(200, function() {
			$(this).addClass('vs-grid').fadeIn(200);
			$.cookie('list_grid', 'g');
		});
		return false;
	});
	
	$('#list').click(function() {
		$('#vs-grid').fadeOut(200, function() {
			$(this).removeClass('vs-grid').fadeIn(200);
			$.cookie('list_grid', null);
		});
		return false;
	});


	$("[rel=tooltip]").tooltip();
	$("[rel=popover]").popover();

	$('#myModal').modal({
	  keyboard: true,
	  show: false
	});

	$('#searchVideos').click(function() {
		$(".searchLoader").css({"display" : "inline"});
	});

	$('#addvideo_direct_submit').click(function() {
		$(".addLoader").css({"display" : "inline"});
	});	

	$('#submitImport').click(function() {
		$('#loading').show();
		$(".video-stack").css({"opacity" : "0.5"});
		$(".importLoader").css({"display" : "inline"});
	});
<?php if($load_chzn_drop == 1): ?>
	$('.category_dropdown').addClass("chzn-select");
	$(".chzn-select").chosen();
	$(".chzn-select-deselect").chosen({allow_single_deselect:true});
<?php endif; ?>

	$('#adminSecondary').css({'height': (($('#wrapper').height()))+'px'});
   /* $('.content').css({'height': (($('#adminSecondary').height()))+'px'});	*/


	$(document).ready(function() {	
		$('li.pm-menu').hover(function(){
			if ( ! $(this).hasClass('active')) {
				$('ul', this).stop().doTimeout( 'hover', 600, 'slideDown', 'fast' );
			}
		}, function(){
			if ( ! $(this).hasClass('active')) {
				$('ul', this).stop().doTimeout( 'hover', 0, 'slideUp', 300 );
			}
		});
	});

	//$('#showfilter').click(function() { $('#showfilter-content').slideToggle(100, function() { $.cookie('list_filter', 'open'); }); }); 
	$('#showfilter').click(function() {
		$('#showfilter-content').slideToggle(100, function() {
			if ($.cookie('list_filter') == null) {
				$.cookie('list_filter','close');
			} else {
				$.cookie('list_filter', null);
			}
		});
		return false;
	});
	$('#import-options').click(function() { $('#import-opt-content').slideToggle('fast'); });
	//$('#import-options').click(function() { $('#import-opt-content').slideToggle('fast'); });

	$('#show-comments').click(function() { $('#show-opt-comments').slideToggle('fast'); return false; });
	$('#show-restriction').click(function() { $('#show-opt-restriction').slideToggle('fast'); return false; });
	$('#show-visibility').click(function() { $('#show-opt-visibility').slideToggle('fast'); return false; });
	$('#show-publish').click(function() { $('#show-opt-publish').slideToggle('fast'); return false; });
	$('#show-thumb').click(function() { $('#show-opt-thumb').slideToggle('fast'); return false; });
	$('#show-featured').click(function() { $('#show-opt-featured').slideToggle('fast'); return false; });
	$('#show-user').click(function() { $('#show-opt-user').slideToggle('fast'); return false; });
	$('#show-views').click(function() { $('#show-opt-views').slideToggle('fast'); return false; });
	$('#show-vs1').click(function() { $('#show-opt-vs1').slideToggle('fast'); return false; });
	$('#show-vs2').click(function() { $('#show-opt-vs2').slideToggle('fast'); return false; });
	$('#show-vs3').click(function() { $('#show-opt-vs3').slideToggle('fast'); return false; });
	$('#show-duration').click(function() { $('#show-opt-duration').slideToggle('fast'); return false; });
	
	$('#show-help-assist').click(function() { $('#help-assist').slideToggle('fast'); $('#show-help-assist').toggleClass('opac5'); return false; });
	
	$('#show-playlists').click(function() { $('#playlists').slideToggle('normal'); $('#content-to-hide').fadeToggle(300); });

<?php if($load_prettypop == 1): ?>
	$("a[rel^='prettyPop']").prettyPhoto({
		animationSpeed: 'fast', /* fast/slow/normal */
		padding: 40, /* padding for each side of the picture */
		opacity: 0.70, /* Value betwee 0 and 1 */
		showTitle: false, /* true/false */
		allowresize: false, /* true/false */
		counter_separator_label: '/', /* The separator for the gallery counter 1 "of" 2 */
		theme: 'dark_rounded', /* light_rounded / dark_rounded / light_square / dark_square */
		width: 500,
		height: 344,
		// flowplayer settings - start
		fp_bgcolor: '<?php echo '0x' . _BGCOLOR;?>',
		fp_timecolor: '<?php echo '0x' . _TIMECOLOR;?>',
		fp_swf_loc: '<?php echo _URL .'/player.swf';  ?>',
		// flowplayer settings - end 
		callback: function(){}
	});
<?php endif; ?>

	$('a[id^="show-more-"]').click(function(){
		var id = $(this).attr('id').match(/\d+$/);
		$(this).hide();
		$('#excerpt-'+id).hide();
		$('#full-text-'+id).show();
		$('#show-less-'+id).show();
		return false;
	});
	$('a[id^="show-less-"]').click(function(){
		var id = $(this).attr('id').match(/\d+$/);
		$(this).hide();
		$('#full-text-'+id).hide();
		$('#show-more-'+id).show();
		$('#excerpt-'+id).show();
		return false;
	});
	
	$(document).ready(function() {
		$('[placeholder]').focus(function() {
		  var input = $(this);
		  if (input.val() == input.attr('placeholder')) {
			input.val('');
			input.removeClass('placeholder');
		  }
		}).blur(function() {
		  var input = $(this);
		  if (input.val() == '' || input.val() == input.attr('placeholder')) {
			input.addClass('placeholder');
			input.val(input.attr('placeholder'));
		  }
		}).blur();
		$('[placeholder]').parents('form').submit(function() {
		  $(this).find('[placeholder]').each(function() {
			var input = $(this);
			if (input.val() == input.attr('placeholder')) {
			  input.val('');
			}
		  })
		});
	});
	
	/**/
	function validateFormOnSubmit(theForm, say_reason) {	
	 
	 var reason = say_reason;
	 var counter = 0;
	 
	 $("input,textarea").each(function(){
	 
		if($(this).attr('id') == "must")
		{
			if ($(this).attr("value").length == 0)
			{
				$(this).css("background", "#FFD2D2");
				counter++;
			}
			else
			{
				$(this).css("background", "#FFFFFF");
			}	
		}
	 });
	 
	 if (counter > 0) {
	   alert(reason);
	   return false;
	 }
	 return true;
	}


	function validateSearch(b_on_submit){
		if(document.forms['search'].keywords.value == '' || document.forms['search'].keywords.value == 'search'){
			alert('You did not enter a search term. Please try again.');
			if(b_on_submit == 'true')
				return false;
		}
		else{
			document.forms['search'].submit();
		}
	}
	function confirm_delete_all() {
		var confirm_msg = "You are about to delete all these selected items. Click 'Cancel' to stop or 'OK' to continue";	 // refers to articles, videos and users
		var response = false;
		if (confirm(confirm_msg)) {
		} else {
			return false;
		}
	}
/*	function SelectAll(id)
	{
		document.getElementById(id).focus();
		document.getElementById(id).select();
	}
*/
<?php if ($load_settings_theme_resources) : ?>
 $(document).ready(function(){
	$('#btn-remove-logo').click(function(){
		 if (confirm('Are you sure you want to delete the current logo?')) {
			$.ajax({
				url: '<?php echo _URL .'/admin/settings_theme.php'?>',
				data: {
					action: 'delete-logo'
				},
				type: 'POST',
				dataType: 'json',
				success: function(data){
					$('#btn-remove-logo').hide();
					$('#show-logo').html(" ");
				}
			});
		}
		return false;
	});
});
<?php endif;?>
</script>