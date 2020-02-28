</div><!-- #wrapper -->
<div class="clearfix"></div>

<footer class="row-fluid" id="footer">

	<p>Powered by <a href="http://www.phpsugar.com/phpmelody.html?utm_source=install_footer" target="_blank">PHP Melody <?php echo _PM_VERSION; ?></a> &copy; <?php echo date('Y'); ?><br />


	<a href="http://www.phpsugar.com/customer_care.html?utm_source=install_footer" target="_blank">Customer Care</a> / <a href="http://www.phpsugar.com/forum/" target="_blank">Support Forums</a>
    </p>
</footer>

<div class="modal hide fade" id="addVideo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="myModalLabel">Add video</h3>
</div>
<div class="modal-body" style="margin:0;padding:0;">
<table cellpadding="0" cellspacing="0" width="100%" class="pm-add-tables">
  <tr>
    <td width="13%" align="center" style="text-align:center; height:60px"><img src="img/ico-add-yt.png" width="56" height="26" alt="" /></td>
    <td width="83%" align="left">
    <form name="search_yt_videos" action="import.php?action=search" method="post" class="form-inline">
    <input name="keyword" type="text" value="" placeholder="Type keywords to search for..." style="width:282px" /> 
	<input type="hidden" name="autofilling" value="1" />
	<input type="hidden" name="autodata" value="1" />
    <input type="hidden" name="results" value="20"> <button type="submit" name="submit" class="btn" id="searchVideos" data-loading-text="Searching...">Search</button> <span class="searchLoader"><img src="img/ico-loading.gif" width="16" height="16" /></span>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" style="text-align:center;"><img src="img/ico-add-link.png" width="28" height="29" alt="" /></td>
    <td align="left">
    <form name="add" action="addvideo.php?step=2" method="post" onSubmit="return checkFields(this);" class="form-inline">
    <input type="text" id="addvideo_direct_input" name="url" placeholder="http://" style="width:282px" /> 
    <input type="hidden" name="" value=""> 
    <button type="submit" id="addvideo_direct_submit" name="Submit" value="Step 2" class="btn">Continue</button> <span class="addLoader"><img src="img/ico-loading.gif" width="16" height="16" /></span>
    </form>
    </td>
  </tr>
  <tr>
    <td align="center" style="text-align:center;"><img src="img/ico-add-local.png" width="42" height="30" alt="" /></td>
    <td align="left">
    <form id="upload_flv" enctype="multipart/form-data" action="upload_file.php" method="post" style="margin-bottom:0;">
    <span id="uploader">
        <label for="myFile"> </label>
        <input name="MAX_FILE_SIZE" value="<?php echo (int) get_true_max_filesize(); ?>" type="hidden" />
        <input name="mediafile" id="myFile" type="file" />
        <input type="submit"  name="submit" id="upload_submit" value="Step 2 &rarr;" class="btn" />
    </span>
    </form>
    </td>
  </tr>
</table>
</div>
</div>

<script src="js/bootstrap.min.js" type="text/javascript"></script>
<script src="js/jquery.ajaxmanager.js" type="text/javascript"></script>
<script src="js/jq.cookie.js" type="text/javascript"></script>
<script src="js/jquery.ba-dotimeout.min.js" type="text/javascript"></script>

<?php if($load_tagsinput == 1): ?>
<script src="js/jquery.tagsinput.js" type="text/javascript"></script>
<?php endif; ?>
<script src="js/melody.js" type="text/javascript"></script>

<script type="text/javascript" src="js/jquploader/jquery.flash.js"></script>
<script type="text/javascript" src="js/jquploader/jquery.jqUploader.js"></script>
<script type="text/javascript">
$("#uploader").jqUploader({
	uploadScript:		'../../upload_file.php?PHPSESSID=<?php echo session_id();?>',
	afterScript:		'addvideo.php?step=2',
	background:			"FFFFFF",
	barColor:			"666666",
	allowedExt:     	"*.flv; *.mp4; *.wmv; *.mov; *.divx; *.avi; *.mkv; *.asf; *.wma; *.mp3; *.m4v; *.m4a; *.3gp; *.3g2",
	allowedExtDescr: 	"(*.flv,*.mp4,*.wmv,*.mov,*.divx,*.avi,*.mkv, *.asf, *.wma, *.mp3, *.m4v, *.m4a, *.3gp, *.3g2)",
	width:				450,
	height:				50,
	src:				'js/jquploader/jqUploader.swf',
	hideSubmit:			true,
	errorSizeMessage: 	'The FLV is too big!',
	validFileMessage: 	'now click "Upload" to proceed',
	progressMessage:  	'Please wait, uploading ',
	endMessage:    	  	'The video has been uploaded.',
	maxFileSize: 		<?php echo (int) get_true_max_filesize(); ?>
});
</script>

<script type="text/javascript" src="js/vscheck.js"></script>
<script type="text/javascript">
	jQuery(function($){
		$(document).ready(function(){
			if(($.browser.msie)&(parseInt($.browser.version)<7)){
				$("img[src$='.png']").each(function(){$(this).addClass("png");});
				//$("span").each(function(){$(this).addClass("pngbg");});
			}
		});
	});
</script>
<?php if($load_colorpicker == 1): ?>
<script src="js/bootstrap-colorpicker.min.js" type="text/javascript"></script>
<?php endif; ?>
<?php if($load_tinymce == 1): ?>
<script src="js/tiny_mce/jquery.tinymce.js" type="text/javascript"></script>
<script type="text/javascript">
// Initializes all textareas with the tinymce class
$().ready(function() {
   $('textarea.tinymce').tinymce({
      script_url: 'js/tiny_mce/tiny_mce.js',
      disk_cache: true,
      theme : "advanced",
	  skin:"cirkuit",
	  language:"en",
	  plugins : "pdw,autosave,fullscreen,wordcount,lists,preview,paste,directionality,media,tabfocus",
      theme_advanced_buttons1 : "pdw_toggle,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,hr,|,formatselect,fontselect,fontsizeselect",
      theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
      theme_advanced_buttons3 : "removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,advhr,|,print,|,ltr,rtl,|,media,fullscreen",
	  theme_advanced_font_sizes: "12px,13px,14px,15px,16px,18px,20px",
	  font_size_style_values : "12px,13px,14px,15px,16px,18px,20px",
	  pdw_toggle_on : 1,
      pdw_toggle_toolbars : "2,3",
      theme_advanced_resizing : true,
      theme_advanced_resize_horizontal : false,
	  relative_urls : false
   });
});
</script>
<?php endif; ?>
<?php if ($load_jquery_ui) : ?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.1/themes/base/jquery-ui.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="http://code.jquery.com/ui/1.9.1/jquery-ui.js"></script>
<?php endif; ?>
<?php if ($showm == 'mod_article' || $showm == '3' || $showm == 'mod_pages' || $load_swfupload == 1): ?>
<script type="text/javascript" src="js/article.js"></script>
<script type="text/javascript" src="js/swfupload.js"></script>
<script type="text/javascript" src="js/swfupload.handlers.js"></script>
<script type="text/javascript" src="js/jquery.swfupload.js"></script>
<?php endif; ?>
<?php if($load_uniform == 1): ?>
<link rel="stylesheet" href="css/uniform.default.css" type="text/css" media="screen" charset="utf-8" />
<script src="js/jquery.uniform.min.js" type="text/javascript"></script>
<?php endif; ?>
<?php if($load_ibutton == 1): ?>
<script type="text/javascript" src="js/jquery.ibutton.js"></script>
<?php endif; ?>
<?php if($load_prettypop == 1): ?>
<link rel="stylesheet" href="css/prettyPop.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="js/jquery.prettyPhoto.js"></script>
<?php endif; ?>
<?php if($load_scrolltofixed == 1): ?>
<script type="text/javascript" src="js/jquery-scrolltofixed-min.js"></script>
<?php endif; ?>
<script type="text/javascript" src="js/a_general.js"></script>
<?php if($load_chzn_drop == 1): ?>
<script type="text/javascript" src="js/chosen.jquery.min.js"></script>
<?php endif; ?>
<script type="text/javascript" src="js/jquery.gritter.js"></script>

<script type="text/javascript">
	var show_pm_notes = $.cookie('showNotice');
	if (show_pm_notes != 'off') {
		$(document).ready(function () {
			<?php show_pm_notes(); ?>
		});
	}
</script>
<?php include("footer-js.php"); ?>
<?php
if (is_user_logged_in() && is_admin()) 
{
    $force = false;
    if ($_GET['forcesync'] == '1')
    {
        $force = true;
    }
    autosync($force);
}

if ($conn_id)
{
    mysql_close($conn_id);
}
?>

</body>
</html>