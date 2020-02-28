<?php
// +------------------------------------------------------------------------+
// | PHP Melody ( www.phpsugar.com )
// +------------------------------------------------------------------------+
// | PHP Melody IS NOT FREE SOFTWARE
// | If you have downloaded this software from a website other
// | than www.phpsugar.com or if you have received
// | this software from someone who is not a representative of
// | PHPSUGAR, you are involved in an illegal activity.
// | ---
// | In such case, please contact: support@phpsugar.com.
// +------------------------------------------------------------------------+
// | Developed by: PHPSUGAR (www.phpsugar.com) / support@phpsugar.com
// | Copyright: (c) 2004-2013 PHPSUGAR. All rights reserved.
// +------------------------------------------------------------------------+

if ($_POST['do'] == 'checkurl')
{
	if ($_POST['url'] == '')
	{
		exit();
	}

	session_start();
	require('../config.php');
	include_once(ABSPATH . 'include/user_functions.php');
	include_once(ABSPATH . 'include/islogged.php');
	include(ABSPATH .'admin/functions.php');
	
	if ( ! $logged_in || ( ! is_admin() && ! is_moderator() && ! is_editor()))
	{
		exit();
	}
	if (is_editor() || (is_moderator() && !mod_can('manage_videos')))
	{
		exit();
	}
	
	$msg = '';
	$msg_color = '';
	
	$url = trim($_POST['url']);
	$url = secure_sql($url);
	$uniq_id = '';
	
	if (strpos($url, 'youtube.com'))
	{
		preg_match("/v=([^(\&|$)]*)/", $url, $matches);
		$url = 'http://www.youtube.com/watch?v='. $matches[1];
	}

	$sql = "SELECT uniq_id FROM pm_videos_urls 
			WHERE direct = '". $url ."'";
	$result = @mysql_query($sql);
	if ( ! $result)
	{
		$msg = 'MySQL error';
		$msg_color = 'red';
	}
	if (mysql_num_rows($result) > 0)
	{
		$row = mysql_fetch_assoc($result);
		$uniq_id = $row['uniq_id'];
		
		$msg = 'This URL was already added into your database! <a href="modify.php?vid='. $uniq_id. '">Edit</a> video.';
		$msg_color = 'red';
	}
	else
	{
		$msg = '';
		$msg_color = 'green';
	}
	mysql_free_result($result);
	
	if (strlen($msg) > 0)
	{
		echo '<small><i><span style="color: '. $msg_color .';">'. $msg .'</span></i></small>';
	}
	
	exit(); // the end
}


$showm = '2';
/*
$load_uniform = 0;
$load_ibutton = 0;
$load_tinymce = 0;
$load_swfupload = 0;
$load_colorpicker = 0;
$load_prettypop = 0;
*/
if(isset($_GET['step'])) {
$load_scrolltofixed = 1;
$load_chzn_drop = 1;
$load_tagsinput = 1;
$load_uniform = 1;
$load_tinymce = 1;
$load_swfupload = 1;
}
include('header.php');

define('PHPMELODY', true);

$message = '';
$allowed_ext = array('.flv', '.mp4', '.mov', '.wmv', '.divx', '.avi', '.mkv', '.asf', '.wma', '.mp3', '.m4v', '.m4a', '.3gp', '.3g2');

$step = (int) $_GET['step'];
if($step == '')
	$step = 1;


if($step == 2 && isset($_POST['Submit']))
{
	if(trim($_POST['url']) == '')
	{
		$step = 1;
		$message = '<div class="alert alert-danger">Please provide a valid URL.</div>';	
	}
}


function add_video_form($video_details = array())
{
	global $modframework;
	$categories_dropdown_options = array(
									'attr_name' => 'category[]',
									'attr_id' => 'main_select_category',
									'select_all_option' => false,
									'spacer' => '&mdash;',
									'selected' => 0,
									'other_attr' => 'multiple="multiple"'
									);

	if($video_details['url_flv'] == '') {
		$video_lookup = '<div class="alert alert-warning"><strong>Sorry, no video found at that location.</strong> Please try again or use another source.  <a href="http://www.phpsugar.com/customer_care.html" target="_blank" class="btn btn-mini btn-blue pull-right">SUGGEST NEW SOURCE</a></div>';
	} else {
		//$video_lookup = '<div class="alert alert-success">The video was found, you can go ahead with this submission.</div>';
	}

?>
<form method="post" enctype="multipart/form-data" action="addvideo.php?step=3" name="addvideo_form_step2" onsubmit="return validateFormOnSubmit(this, 'Please fill in the required fields (highlighted) or make sure the URL you entered at STEP 1 is valid.')">

<div class="container row-fluid" id="post-page">
    <div class="span9">
	<?php echo $video_lookup; ?>
    <div class="widget border-radius4 shadow-div">
    <h4>Title &amp; Description</h4>
    <div class="control-group">
    <input name="video_title" type="text" id="must" value="<?php echo str_replace('"', '&quot;', $video_details['video_title']); ?>" style="width: 99%;" />
    <div class="controls">

    </div>
    </div>
    
    <div class="control-group">
	<div class="pull-right" style=" position: absolute; top: -5px; right: 0px;">
	<script type="text/javascript">
    $(function(){
        $('#ButtonPlaceHolder').swfupload({
            upload_url: "upload_image.php",
            
            file_size_limit : "<?php echo ($upload_max_filesize > 0) ? $upload_max_filesize.'' : '0';?>",
            file_types : "*.jpg;*.png;*.gif",
            file_types_description : "Image files",
            file_upload_limit : 30,
            flash_url : "js/swfupload/swfupload.swf",
            button_width : 114,
            button_height : 29,
            custom_settings : {
                progressTarget : "fsUploadProgress"
            },
            post_params: {
                    "PHPSESSID" : "<?php echo session_id(); ?>"
                    },
            // Button settings
            //button_image_url: "js/swfupload/upload.png",
            button_placeholder_id: "ButtonPlaceHolder",
            button_width: "124",
            button_height: "20",
            button_text: '<span class="button">Upload images</span>',
            button_text_style: '.button { text-align: center; font-size: 11px; font-weight: normal;font-family: "Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", Geneva, Verdana, sans-serif;letter-spacing:0; }',
            button_text_top_padding: 3,
            button_text_left_padding: 0,
            //button_window_mode: "window",
            button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
            button_cursor: SWFUpload.CURSOR.HAND,
            debug: false
        })
            .bind('fileQueued', function(event, file){
                var listitem='<li id="'+file.id+'" >'+
                    'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
                    '<div class="progressbar" ><div class="progress" ></div></div>'+
                    '<p class="status" >Pending</p>'+
                    '<span class="cancel" >&nbsp;</span>'+
                    '</li>';
                $('#uploadLog').append(listitem);
                $('li#'+file.id+' .cancel').bind('click', function(){
                    var swfu = $.swfupload.getInstance('#swfupload-control');
                    swfu.cancelUpload(file.id);
                    $('li#'+file.id).slideUp('fast');
                });
                // start the upload since it's queued
                $(this).swfupload('startUpload');
            })
            .bind('fileQueueError', function(event, file, errorCode, message){
                alert('Size of the file '+file.name+' is greater than the limit');
            })
            .bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
                $('#fsUploadProgress').text('Uploaded: '+numFilesSelected+' file(s)');
            })
            .bind('uploadStart', function(event, file){
                $('#uploadLog li#'+file.id).find('p.status').text('Uploading...');
                $('#uploadLog li#'+file.id).find('span.progressvalue').text('0%');
                $('#uploadLog li#'+file.id).find('span.cancel').hide();
            })
            .bind('uploadProgress', function(event, file, bytesLoaded){
                //Show Progress
                var percentage=Math.round((bytesLoaded/file.size)*100);
                $('#uploadLog li#'+file.id).find('div.progress').css('width', percentage+'%');
                $('#uploadLog li#'+file.id).find('span.progressvalue').text(percentage+'%');
            })
            .bind('uploadSuccess', function(event, file, serverData){
                var item=$('#uploadLog li#'+file.id);
                item.find('div.progress').css('width', '100%');
                item.find('span.progressvalue').text('100%');
                var pathtofile='<a href="uploads/'+file.name+'" target="_blank" >view &raquo;</a>';
                item.addClass('success').find('p.status').html('Uploaded!');
                if ($("#wysiwygtextarea-WYSIWYG").length > 0)
                {
                    $("#wysiwygtextarea-WYSIWYG").contents().find("body").append(serverData);
                }
                else if ($("#textarea-WYSIWYG").length > 0)
                {
                    var textarea = $("#textarea-WYSIWYG").val();
                    $("#textarea-WYSIWYG").val(textarea + serverData);
                }
                setTimeout( function() {
                $('#uploadLog li#'+file.id).fadeOut('slow');
                }, 2000);
            })
            .bind('uploadComplete', function(event, file){
                // upload has completed, try the next one in the queue
                $(this).swfupload('startUpload');
            })
        
    });	
    </script>
    <span class="btn btn-mini btn-upload"><span id="ButtonPlaceHolder"></span></span>
    <small><div id="fsUploadProgress"></div></small>
    <div id="divStatus"></div>
	<ol id="uploadLog"></ol>
    </div>
    </div>
    
    <div class="controls">
	<textarea name="description" cols="100" id="textarea-WYSIWYG" class="tinymce" style="height: 300px;width:100%"><?php echo $video_details['description']; ?></textarea>
    <span class="autosave-message">&nbsp;</span>
    </div>
    </div>

    </div><!-- .span8 -->
    <div class="span3">
		<div class="widget border-radius4 shadow-div">
		<h4>Thumbnail</h4>
            <div class="control-group container-fluid">
            <div class="controls row-fluid">
			<div class="">
            <a href="#" id="show-thumb" rel="tooltip" title="Click to add a thumbnail from an URL"><img src="<?php echo $video_details['yt_thumb']; ?>" width="100" height="70" id="must" class="img-polaroid" style="display:block;min-width:100px;min-height:70px; background:url('img/no-thumbnail.jpg') no-repeat center center;" /></a>
            </div><!-- .span4 -->
			<div class="">
                <?php
                if($video_details['source_id'] == 1 || $video_details['source_id'] == 2)
                {
                ?>
                <br />
                <input type="file" name="thumb" onChange="javascript: if(this.value!='') yt_thumb.disabled='disabled'; else yt_thumb.disabled=''"/>
                <?php
                }
                ?>
                <div id="show-opt-thumb">
                <br />
                <input type="text" name="yt_thumb" value="<?php echo $video_details['yt_thumb']; ?>" class="bigger span10" placeholder="http://" /> <i class="icon-info-sign" rel="tooltip" data-position="top" title="The thumbnail will refresh after you hit the 'Submit' button."></i>
                </div>
            </div><!-- .span8 -->
            </div><!-- .controls .row-fluid -->
            </div>
        </div><!-- .widget -->
        
		<div class="widget border-radius4 shadow-div">
		<h4>Category</h4>
            <div class="control-group">
            <div class="controls">
            <input type="hidden" name="categories_old" value="<?php echo $r['category'];?>"  />
            <?php 
			$categories_dropdown_options = array(
											'attr_name' => 'category[]',
											'attr_id' => 'main_select_category must',
											'attr_class' => 'category_dropdown span12',
											'select_all_option' => false,
											'spacer' => '&mdash;',
											'selected' => explode(',', $r['category']),
											'other_attr' => 'multiple="multiple"'
											);
			echo categories_dropdown($categories_dropdown_options);
            ?>
            </div>
            </div>
		</div><!-- .widget -->
        
        <div class="widget border-radius4 shadow-div">
        <h4>Publish</h4>
			<?php
            if($video_details['yt_length'] > 0) {	
                $yt_minutes = intval($video_details['yt_length'] / 60); 
                $yt_seconds = intval($video_details['yt_length'] % 60); 
            } else {
                $yt_minutes = 0;
                $yt_seconds = 0;
            }
            ?>
            <div class="control-group">
            <label class="control-label" for="">Duration: <span id="value-yt_length"><strong><?php echo sec2min($video_details['yt_length']);?></strong></span> <a href="#" id="show-duration">Edit</a></label>
            <div class="controls" id="show-opt-duration">
            <input type="text" name="yt_min" id="yt_length" value="<?php echo $yt_minutes; ?>" size="4" class="smaller-select" /> <small>min.</small>
            <input type="text" name="yt_sec" id="yt_length" value="<?php echo $yt_seconds; ?>" size="3" class="smaller-select" /> <small>sec.</small>
            <input type="hidden" name="yt_length" id="yt_length" value="<?php echo trim(($yt_minutes * 60) + $yt_seconds); ?>" />
            </div>
            </div>
            
            <div class="control-group">
            <label>Featured: <span id="value-featured"><strong>no</strong></span> <a href="#" id="show-featured">Edit</a></label>
            <div class="controls" id="show-opt-featured">
                <label><input type="checkbox" name="featured" id="featured" value="1" <?php if($video_details['featured'] == 1) echo 'checked="checked"';?> /> Yes, mark as featured</label>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label reqreg" for="">Requires registration: <span id="value-register"><strong>no</strong></span> <a href="#" id="show-visibility">Edit</a></label>
            <div class="controls" id="show-opt-visibility">
                <label class="checkbox inline"><input type="radio" name="restricted" id="restricted" value="1" <?php echo ($video_details['restricted'] == '1') ? 'checked="checked"' : '';?> /> Yes</label> 
                <label class="checkbox inline"><input type="radio" name="restricted" id="restricted" value="0" <?php echo ($video_details['restricted'] != '1') ? 'checked="checked"' : '';?> /> No</label>
            </div>
            </div>

            <div class="control-group">
            <label class="control-label" for="">Publish: <span id="value-publish"><strong>immediately</strong></span> <a href="#" id="show-publish">Edit</a></label>
            <div class="controls" id="show-opt-publish">
            <?php echo ($_POST['date_month'] != '') ? show_form_item_date( pm_mktime($_POST) ) : show_form_item_date();	?>
            </div>
            </div>
            <?php 
            $modframework->trigger_hook('admin_addvideo_publishoptions');
            ?>
        </div><!-- .widget -->

		<div class="widget border-radius4 shadow-div">
		<h4>Tags</h4>
            <div class="control-group">
            <div class="controls">
                <div class="tagsinput" style="width: 100%;">
                <input type="text" name="tags" value="<?php echo $video_details['tags']; ?>" id="tags_addvideo_1" />
                </div>
            </div>
            </div>
        </div><!-- .widget -->
        <?php 
		$modframework->trigger_hook('admin_addvideo_input');
		?>
    </div>
    
</div>
<div class="clearfix"></div>
<input type="hidden" name="language" value="1" />
<input type="hidden" name="yt_id" value="<?php echo $video_details['yt_id']; ?>" />
<input type="hidden" name="url_flv" value="<?php echo $video_details['url_flv']; ?>" />
<input type="hidden" name="source_id" value="<?php echo $video_details['source_id']; ?>" />
<input type="hidden" name="submitted" value="<?php echo $video_details['submitted']; ?>" />
<input type="hidden" name="mp4" value="<?php echo $video_details['mp4']; ?>" />
<input type="hidden" name="direct" value="<?php echo $video_details['direct']; ?>" />
<input type="hidden" name="age_verification" value="0" />
    
<div id="stack-controls" class="list-controls">
<div class="pull-left">

</div>
<input type="submit" name="submit" value="Submit" class="btn btn-small btn-success" />
</div><!-- #list-controls -->

<?php
if($video_details['yt_id'] == '') 
	$video_details['yt_id'] = generate_activation_key(9); 
?>
</form>
<?php
}

$video_details = array(	'uniq_id' => '',
						'video_title' => '',
						'description' => '',
						'yt_id' => '',
						'yt_length' => '',
						'category' => '',
						'submitted' => '',
						'source_id' => '',
						'language' => '',
						'age_verification' => '',
						'url_flv' => '',
						'yt_thumb' => '',
						'mp4' => '',
						'direct' => '',
						'tags' => '', 
						'featured' => '',
						'added' => '',
						'restricted' => 0 
						);

?>
<script language="javascript">
function checkFields(Form) {

	var msg;
	if(Form.elements.url.value == "")
		msg = "Please insert a link valid link as instructed below.";
	
	if(msg)
	{
		document.forms["add"].elements.url.style.background = "#FFDDDE";
		alert(msg);
		return false;
	}
	else 
		return true;
}
</script>

<div id="adminPrimary">
    <div class="row-fluid" id="help-assist">
        <div class="span12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#help-overview" data-toggle="tab">Overview</a></li>
            <li><a href="#help-onthispage" data-toggle="tab">Adding self-hosted video</a></li>
            <li><a href="#help-bulk" data-toggle="tab">Adding a remote video</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="help-overview">
            <p>This page makes adding videos from remote or even local sources as easy as copy/pasting a URL.</p>
            <p>The allowed URLs are either your self-hosted videos (*.flv, *.mp4, *.wmv, *.mov, etc.) or videos hosted by remote services (Youtube, Vimeo, Dailymotion, etc.)</p>
            <p>You can also use the "ADD VIDEO" button located in the header to quickly paste a video URL.</p>
            </div>
            <div class="tab-pane fade" id="help-onthispage">
              <p>If you decide to self-host videos, you can use a 3rd party service such as AWS S3 or even your own hosting provider. The form below allows you to add self-hosted videos from any location. Just paste the URL to your *.flv, *.mp4, *.wmv, *.mov video below.</p>
            </div>
            <div class="tab-pane fade" id="help-bulk">
            <p>Remote videos are hosted by 3rd party video sites. Below is a list of supported sites:</p>
             <ul style="height:120px; overflow-y: scroll; margin:0;padding:0; color:#666;">
             <?php
                $sources = a_fetch_video_sources();
                $sources = array_reverse($sources);
				$sources = array_sort($sources, 'source_name', SORT_ASC);
                $counter = 1;
                
                foreach ($sources as $k => $src)
                {
                    if (is_int($k) && $k >= 2): 
                    ?>
                    <li><?php echo $counter.'. '. ucfirst($src['source_name']);?> <small>(e.g. <?php echo $src['url_example'];?>)</small></li>
                    <?php 
                    $counter++;
                    endif;
                }
             ?>
             </ul>
             <p></p>
            <p>After pasting the desired  URL below, PHP Melody will automatically retrieve as much data as possible from the remote location. This includes, thumbnails, video title, description and so on. On some occasions you will have to add such data manually.</p>
            <p>Please note that no video files will be downloaded to your domain in this process.</p>
            </div>
          </div>
        </div> <!-- /tabbable -->
        </div><!-- .span12 -->
    </div><!-- /help-assist -->
    
    <div class="content">
	<a href="#" id="show-help-assist">Help</a>
	<h2>Add Video from URL</h2>
	<?php 
	
	echo $message; 

	load_categories();
	if (count($_video_categories) == 0) 
	{ 
	?>
		<div class="alert alert-error">Please <a href="cat_manager.php">create a category</a> first.</div>
	<?php
	}


switch($step)
{

	case 1:		//	STEP 1
?>
<form name="add" action="addvideo.php?step=2" method="post" class="form-inline" onSubmit="return checkFields(this);">
<input type="text" id="addvideo_direct_input" name="url" size="30" class="input-xlarge" placeholder="http://" /> 
<input type="submit" id="addvideo_direct_submit" name="Submit" value="Step 2 &raquo;" class="btn" />
</form>
<hr />
<?php
	break;
	
	case 2:		//	STEP 2
	$modframework->trigger_hook('admin_addvideo_step2_pre');
		if(isset($_POST['Submit']) || $_GET['url'] != '' || isset($_POST['filename']))
		{
			if($_POST['url'] != '' || $_GET['url'] != '')
				$url = (isset($_POST['url'])) ? trim($_POST['url']) : trim($_GET['url']);
			
			if($_POST['submitted'] != '' || $_GET['submitted'] != '')
				$submitted = (isset($_POST['submitted'])) ? $_POST['submitted'] : trim($_GET['submitted']);
			else
				$submitted = $userdata['username'];
			/*
				MODE
				1 = Outsource (e.g. youtube)
				2 = Direct URL to video file
				3 = Direct URL/Path/Filename to video hosted locally
			*/
			
			$mode = 0;
			$temp = '';
			
			$url = str_replace('https', 'http', $url);
			$url = str_replace('youtu.be/', 'youtube.com/watch?v=', $url);
			
			//	Is this a direct link to a video file?
			if (strpos($url, '?') !== false)
			{
				$temp = explode('?', $url);
				$url = $temp[0];
			}
						
			$ext = '.'. strtolower(array_pop(explode('.', $url)));
			
			if (is_array($temp) && count($temp) > 0)
			{
				$url = '';
				$temp[0] = rtrim($temp[0], '?');
				$temp[0] = $temp[0] .'?';
				foreach ($temp as $k => $v)
				{
					$url .= $v;
				}
			}
			
			if(in_array($ext, $allowed_ext) && (preg_match('/photobucket\.com/', $url) == 0))
			{
				if(!is_url($url))
				{
					$mode = 3;
				}
				else if(strpos($url, _URL) !== false)
				{
					$mode = 3;
				}
				else
				{
					$mode = 2;
				}
			}
			elseif(is_url($url))
			{
				$mode = 1;
			}
			else	//	default;
			{
				$mode = 2;
			}
			if(isset($_POST['filename']) && $_POST['filename'] != '')
				$mode = 3;
			
			//	Build the $video_details array;
			switch($mode)
			{
				case 1: 	//	 Outsource (e.g. youtube); 
					$sources = a_fetch_video_sources();
					$use_this_src = -1;

					if($sources === false || count($sources) == 0)
					{
						$message = "There are no sources available.";
						break;
					}
					
					foreach($sources as $src_id => $source)
					{
						if($use_this_src > -1)
						{
							break;
						}
						else
						{
							if(@preg_match($source['source_rule'], $url))
							{
								$use_this_src = $source['source_id'];
							}
						}
					}

					if($use_this_src > -1)
					{
						if(!file_exists( "./src/" . $sources[ $use_this_src ]['source_name'] . ".php"))
						{
							$message = "File '/src/" . $sources[ $use_this_src ]['source_name'] . ".php'" . " not found.";
							break;
						}
						else
						{
							require_once( "./src/" . $sources[ $use_this_src ]['source_name'] . ".php");
							do_main($video_details, $url);
							
							$video_details['source_id'] = $use_this_src;
						}
					}
					else
					{
						$message = "<strong>This video site is not supported</strong>. For a full list of supported video sites please <a href=\"addvideo.php?step=1\">return to the previous page</a> and read the 'Instructions'.";
					}
				break;
				
				case 2:		//	2 = direct link to .flv/.mp4 (outsource)
					if(!is_url($url))
					{
						$message = '<strong>'.$url.'</strong><br />This doesn\'t look like a valid link. Please <a href="addvideo.php?step=1">return</a> and try again.';
						break;
					}
					$video_details['source_id'] = 2;
					$video_details['url_flv'] = $url;
					$video_details['direct'] = $url;
				break;
				case 3:		//	flv hosted locally or just uploaded
				
					if(isset($_POST['filename']) && $_POST['filename'] != '')
					{
						$contents = get_config('last_video');
						update_config('last_video', '');
						
						//	try the backup file
						if($contents == '')
						{
							$fp = fopen('tmp.pm', 'r');
							$contents = fread($fp, 512);
							fclose($fp);
						}
						
						//	clear file contents anyway
						$fp = fopen('tmp.pm', 'w');
						fwrite($fp, '');
						fclose($fp);
						
						if ($contents == '')	
						{
							$message  = 'Could not retreive the name of the uploaded file. ';
							$message .= '<br />Check your <a href="'. _URL .'/admin/readlog.php">System log</a> for any error messages.';
							
							if ( ! is_writable(ABSPATH . 'admin/tmp.pm'))
							{
								$message .= '<br />Make sure the "<em>/admin/tmp.pm</em>" file has the required permissions (0777) ';
								$message .= 'and then try uploading the video again.';
							}
						}
						else
						{
							//	get filename
							$content  = explode("/", $contents);
							$filename = $content[ count($content)-1 ];
							
							//	move the new file to the videos directory 
							$oldpath = $contents;
							$newpath = _VIDEOS_DIR_PATH . $filename;
							if(!rename($oldpath, $newpath))
							{
								$message  = 'Could not move uploaded file to the uploads directory. ';
								$message .= 'Make sure the uploads directory is writable (0777).';
								break;
							}
							$video_details['url_flv'] = $filename;
							$video_details['direct'] = $filename;
							
						}				
					}
					else
					{
						//	this means $url is either the path or a direct link to the .flv file whick is hosted locally(!)
						//	we only need the filename
						$temp = explode("/", $url);
						$video_details['url_flv'] = $temp[ count($temp)-1 ];
						unset($temp);
					}
					$sources = a_fetch_video_sources();
					
					$use_this_src = -1;
					foreach($sources as $src_id => $source)
						if($source['source_name'] == 'localhost')
							$use_this_src = $source['source_id'];
						$video_details['source_id'] = ($use_this_src != -1) ? $use_this_src : 1; //	1 = Default for LOCALHOST
				break;
			}
			$modframework->trigger_hook('admin_addvideo_step2_mid');
			//	Prevent adding the same video twice
			if ($video_details['direct'] != '')
			{
				$sql = "SELECT * FROM pm_videos_urls WHERE direct = '". $video_details['direct'] ."'";
				
				$result = mysql_query($sql);
				if (mysql_num_rows($result) > 0)
				{
					$row = mysql_fetch_assoc($result);
					mysql_free_result($result);
					
					$message .= '<strong>The video you\'re trying to add was found in your database. ';
					$message .= '</div><div><br />';
					$message .= '<input name="view_video" type="button" value="View" onClick="location.href=\''. _URL .'/watch.php?vid='. $row['uniq_id'] .'\'" class="btn" /> ';
					$message .= '<input name="edit_video" type="button" value="Edit video &raquo;" onClick="location.href=\'modify.php?vid='. $row['uniq_id'] .'\'" class="btn btn-info" />';
					$message .= '</strong>';
				}
				unset($row, $sql, $result);
			}
			if (strlen($message) == 0 && $video_details['url_flv'] != '')
			{
				$sql = "SELECT * FROM pm_videos WHERE url_flv = '". $video_details['url_flv'] ."'";
				
				$result = mysql_query($sql);
				if (mysql_num_rows($result) > 0)
				{
					$row = mysql_fetch_assoc($result);
					mysql_free_result($result);
					
					$message .= '<strong>The video you\'re trying to add was found in your database. ';
					$message .= '</div><div><br />';
					$message .= '<input name="view_video" type="button" value="View" onClick="location.href=\''. _URL .'/watch.php?vid='. $row['uniq_id'] .'\'" class="btn" /> ';
					$message .= '<input name="edit_video" type="button" value="Edit video &raquo;" onClick="location.href=\'modify.php?vid='. $row['uniq_id'] .'\'" class="btn btn-info" />';
					$message .= '</strong>';

				}
				unset($row, $sql, $result);
			}
			$modframework->trigger_hook('admin_addvideo_step2_post');
			if($message != '')
			{
				echo "<div class='alert alert-info'>".$message."</div>";
			}
			else	//	show form
			{
				$video_details['submitted'] = $submitted;
				add_video_form($video_details);
			}
		}	//	endif isset(POST or GET)
		else
		{
			echo "<a href=\"addvideo.php?step=1\">&larr; Please go to Step 1</a>";
			if ( ! headers_sent())
			{
				header("Location: addvideo.php?step=1");
			}
			else 
			{
				echo '<meta http-equiv="refresh" content="0;URL=addvideo.php?step=1" />';
			}
			exit();
		}
	break;
	case 3:		//	STEP 3
	
		$modframework->trigger_hook('admin_addvideo_step3_pre');

		if(isset($_POST['submit']))
		{
			$required_fields = array('video_title' => '"Video Title" is a required field and cannot be left blank',
									'url_flv' => 'Link to video file is missing', 
									'category' => 'Please choose at least one category for this video'
									);
			$message = '';
			
			foreach($video_details as $field => $value)
			{
				if ($field == 'category' && is_array($_POST[$field]))
				{
					$_POST[$field] = implode(',', $_POST[$field]);
				}
				$video_details[$field] = trim($_POST[$field]);
				if(trim($_POST[$field]) == '' && array_key_exists($field, $required_fields))
					$message .= $required_fields[$field] . '<br />';
			}

			$video_details['yt_length'] = ($_POST['yt_min'] * 60) + $_POST['yt_sec'];
			
			
			$added = validate_item_date($_POST);
			if ($added === false)
			{
				$message .= "Invalid date. Please correct it.<br />";
			}
			else
			{
				$video_details['added'] = pm_mktime($added);
			}
			
			if($message != '')
			{				
				echo "<div class='alert alert-error'>".$message."</div>";
				add_video_form($video_details);
				break;
			}
			else
			{
				$message = '';
				//	check if this video already exists
				if(count_entries('pm_videos', 'url_flv', $video_details['url_flv']) > 0)
				{
					$message .= "This video (".$video_details['url_flv'].") is already in your database. Please go back and make the right adjustments.<br />";
				}
				elseif( ($video_details['direct'] != "") && (count_entries('pm_videos_urls', 'direct', $video_details['direct']) > 0))
				{
					$message .= "This direct link <em>'".$video_details['direct']."'</em> already exists in your database. <br />Please go back and make the right adjustments.<br />";
				}
				else
				{
					//	generate unique id;
					$found = 0;
					$uniq_id = '';
					$i = 0;
					do
					{
						$found = 0;
						if(function_exists('microtime'))
							$str = microtime();
						else
							$str = time();
						$str = md5($str);
						$uniq_id = substr($str, 0, 9);
						if(count_entries('pm_videos', 'uniq_id', $uniq_id) > 0)
							$found = 1;
					} while($found === 1);
	
					$video_details['uniq_id'] = $uniq_id;
					$modframework->trigger_hook('admin_addvideo_step3_mid');
					
					//	upload or download thumbnail picture.
					if($_FILES['thumb']['name'] != '')
					{
						require_once('img.resize.php');
						$img = new resize_img();
						$img->sizelimit_x = THUMB_W_VIDEO;
						$img->sizelimit_y = THUMB_H_VIDEO;
						
						$new_thumb_name = $uniq_id . "-1";
						
						//	resize image and save it
						if($img->resize_image($_FILES['thumb']['tmp_name']) === false)
						{
							$message .= $img->error;
						}
						else
						{
							$img->save_resizedimage(_THUMBS_DIR_PATH, $new_thumb_name);
						}
						$video_details['yt_thumb'] = $new_thumb_name . "." . strtolower($img->output);
					}
					else
					{
						//	download thumbnail
						$sources = a_fetch_video_sources();
						$use_this_src = -1;
						
						foreach($sources as $src_id => $source)
						{
							if($src_id == $video_details['source_id'])
							{
								$use_this_src = $source['source_id'];
								break;
							}
						}
						require_once( "./src/" . $sources[ $use_this_src ]['source_name'] . ".php");

						if ('' != $video_details['yt_thumb'])
							$img = download_thumb($video_details['yt_thumb'], _THUMBS_DIR_PATH, $uniq_id);
						else 
							$img = true;
						
						//if($img === false)
						//	$message .= "An error occurred while downloading the thumbnail!<br />";
					}
				}
				
				if ($img === false)
				{
					echo "<div class='alert alert-error'>An error occurred while downloading the thumbnail!</div>";
				}
				
				if($message != '')
				{
					echo "<div class='alert alert-info'>".$message."</div>";
					echo '<br /><input name="add_new" type="button" value="&larr; Return" onClick="location.href=\'addvideo.php?step=1\'" class="btn" />';
				}
				else	//	Everything is good. Now we can add the new video to the database
				{
					if ($_POST['featured'] == '1')
					{
						$video_details['featured'] = 1;
					}
					else
					{
						$video_details['featured'] = 0;
					}
					$modframework->trigger_hook('admin_addvideo_step3_pre_video');
					$new_video = insert_new_video($video_details, $new_video_id);
					if($new_video !== true)
					{
						$message = "<em>A problem occurred! Couldn't add the new video in your database;</em><br /><strong>MySQL Reports:</strong> ".$new_video[0]."<br /><strong>Error Number:</strong> ".$new_video[1]."<br />";		
					}
					else
					{
						$modframework->trigger_hook('admin_addvideo_step3_post_video');
						//	tags?
						if(trim($_POST['tags']) != '')
						{
							$tags = explode(",", $_POST['tags']);
							foreach($tags as $k => $tag)
							{
								$tags[$k] = stripslashes(trim($tag));
							}
							//	remove duplicates and 'empty' tags
							$temp = array();
							for($i = 0; $i < count($tags); $i++)
							{
								if($tags[$i] != '')
									if($i <= (count($tags)-1))
									{
										$found = 0;
										for($j = $i + 1; $j < count($tags); $j++)
										{
											if(strcmp($tags[$i], $tags[$j]) == 0)
												$found++;
										}
										if($found == 0)
											$temp[] = $tags[$i];
									}
							}
							$tags = $temp;
							//	insert tags
							if(count($tags) > 0)
								insert_tags($uniq_id, $tags);
						}
						$message = "<strong>SUCCESS!</strong> The video has been added to your database.";
					}
					$modframework->trigger_hook('admin_addvideo_step3_final');
					echo "<div class='alert alert-success'>".$message."</div>";
			
					echo '<br /><input name="add_new" type="button" value="Add / upload new video" onClick="location.href=\'addvideo.php?step=1\'" class="btn btn-success" /> ';
					echo '<input name="import_new" type="button" value="Import from YouTube" onClick="location.href=\'import.php\'" class="btn btn-success" />';
				}
			}
		}	//	end if post['submit'];
		else
		{
			if(headers_sent())
			{
				echo '<meta http-equiv="refresh" content="0;URL=addvideo.php?step=1" />';
			}
			else
			{
				header("Location: addvideo.php?step=1");
			}
			exit();
		}
	break;
}
?>
    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>