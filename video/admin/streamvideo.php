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

$showm = '2';
/*
$load_uniform = 0;
$load_ibutton = 0;
$load_tinymce = 0;
$load_swfupload = 0;
$load_colorpicker = 0;
$load_prettypop = 0;
*/
$load_scrolltofixed = 1;
$load_chzn_drop = 1;
$load_tagsinput = 1;
$load_uniform = 1;
$load_tinymce = 1;
$load_swfupload = 1;
include('header.php');

define('PHPMELODY', true);

$step = 2;

$inputs = array();

if ($_POST['submit'] != '')
{
	$return_msg = '';
	
	foreach ($_POST as $k => $v)
	{
		if ( ! is_array($_POST[$k]))
			$_POST[$k] = stripslashes(trim($v));
	}
	
	if (strlen($_POST['video_title']) == 0)
	{
		$return_msg = 'Insert the video title';
	}
	else if ((is_array($_POST['category']) && count($_POST['category']) == 0) || ( ! isset($_POST['category'])))
	{
		$return_msg = 'Please select a category for this video';
	}
	
	if ($return_msg == '')
	{
		$video_details = array(	'uniq_id' => '',
								'video_title' => '',
								'description' => '',
								'yt_id' => '',
								'category' => '',
								'submitted' => '',
								'source_id' => 0,
								'language' => 1,
								'age_verification' => 0,
								'url_flv' => '',
								'yt_thumb' => '',
								'mp4' => '',
								'direct' => '',
								'tags' => '', 
								'featured' => 0,
								'added' => '',
								'restricted' => 0, 
								'jw_flashvars' => array('provider' => '',
														'startparam' => '',
														'loadbalance' => '', 
														'subscribe' => ''
												  )
							);
						
		$video_details['submitted']   = $userdata['username'];
		$video_details['featured'] 	  = (int) $_POST['featured'];
		$video_details['description'] = $_POST['description'];
		$video_details['yt_thumb'] 	  = $_POST['yt_thumb'];
		$video_details['video_title'] = $_POST['video_title'];
		$video_details['category'] 	  = (is_array($_POST['category'])) ? implode(',', $_POST['category']) : $_POST['category'];
		$video_details['tags'] 		  = $_POST['tags'];
		$video_details['direct']	  = $_POST['direct'];
		$video_details['restricted']  = $_POST['restricted'];
		$video_details['jw_flashvars']['provider'] 			= $_POST['jw_provider'];
		if ($_POST['jw_provider'] == 'rtmp')
		{
			$video_details['jw_flashvars']['loadbalance'] 	= $_POST['jw_rtmp_loadbalance'];
			$video_details['jw_flashvars']['subscribe'] 	= $_POST['jw_rtmp_subscribe'];
		}
		else if ($_POST['jw_provider'] == 'http')
		{
			$video_details['jw_flashvars']['startparam'] 	= trim($_POST['jw_startparam']);
		}
		
		// file + streamer combination makes our url_flv unique
		$video_details['url_flv'] = trim($_POST['jw_file']) .';'. trim($_POST['jw_streamer']);
		
		$added = validate_item_date($_POST);
		if ($added === false)
		{
			$return_msg .= 'Invalid date given <br />';
		}
		else
		{
			$video_details['added'] = pm_mktime($added);
		}
		
		// check if stream has been added previously
		if ($video_details['url_flv'] != '')
		{
			$sql = "SELECT uniq_id, COUNT(*) as total_found FROM pm_videos WHERE url_flv = '". secure_sql($video_details['url_flv']) ."'";
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result);
			mysql_free_result($result);
			
			if ($row['total_found'] > 0)
			{
				$return_msg .= 'The video you\'re trying to add was found in your database. ';
				$return_msg .= '<a href="'. _URL .'/watch.php?vid='. $row['uniq_id'] .'" />View</a> or <a href="modify.php?vid='. $row['uniq_id'] .'">Edit</a> this video.';
			}
		}
		
		//	generate unique id;
		$found = 0;
		$uniq_id = '';
		$i = 0;
		do
		{
			$found = 0;
			$str = md5(time());
			$uniq_id = substr($str, 0, 9);
			if(count_entries('pm_videos', 'uniq_id', $uniq_id) > 0)
				$found = 1;
		} while($found === 1);

		$video_details['uniq_id'] = $uniq_id;
		$video_details['yt_id'] = $uniq_id;
		
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
				$return_msg .= $img->error;
			}
			else
			{
				$img->save_resizedimage(_THUMBS_DIR_PATH, $new_thumb_name);
			}
			$video_details['yt_thumb'] = $new_thumb_name . "." . strtolower($img->output);
		}
		else if (strlen($video_details['yt_thumb']) > 0)
		{
			//	download thumbnail
			require_once( "./src/other.php");

			$img = download_thumb($video_details['yt_thumb'], _THUMBS_DIR_PATH, $uniq_id);
			if($img === false)
			{
				$return_msg .= "An error occurred while downloading the thumbnail!<br />";
			}
		}

		if (strlen($return_msg) == 0)
		{
			
			$new_video = insert_new_video($video_details, $new_video_id);
			if($new_video !== true)
			{
				$return_msg = "<em>A problem occurred! Couldn't add the new stream to your database;</em><br /><strong>MySQL Reports:</strong> ".$new_video[0]."<br /><strong>Error Number:</strong> ".$new_video[1]."<br />";
			}
			else
			{
				//	tags?
				if($video_details['tags'] != '')
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
				
				$step = 3;
				$return_msg = 'The stream has been added.';
			}
		}
	}	//	endif $return_msg == ''

	$inputs = $_POST;
}

?>
<script type="text/javascript">
	$(document).ready(function(){
		switch ($('select[name="jw_provider"]').val())
		{
			default:
			case '':
				$('.provider_http').hide();
				$('.provider_rtmp').hide();
			break;
			case 'rtmp':
				$('.provider_http').hide();
			break;
			case 'http':
				$('.provider_rtmp').hide();
			break;
			
		}
		
		$('select[name="jw_provider"]').change(function(){
			switch(($(this).val()))
			{
				default:
				case '':
					$('.provider_http').fadeOut('fast');
					$('.provider_rtmp').fadeOut('fast');
				break;
				case 'rtmp':
					$('.provider_http').hide();
					$('.provider_rtmp').fadeIn('slow');
				break;
				case 'http':
					$('.provider_rtmp').hide();
					$('.provider_http').fadeIn('slow');
				break;
			}
		});
	});
</script>
<div id="adminPrimary">
    <div class="row-fluid" id="help-assist">
        <div class="span12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#help-overview" data-toggle="tab">Overview</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="help-overview">
<p>You can use PHP MELODY to add live video streams. Each new submission has a few required fields such as Title, Stream URL and Category. Other options listed on this page are optional.</p>
<p>Assigning a thumbnail can be done either by URL input or direct upload. If you'd rather use a URL instead of uploading your thumbnail, click on the thumbnail image to reveal the hidden field.</p>
<p>Each submission can be published at a specified date in the future if needed. Also, all your videos can placed behind a registration wall thus, increasing your registration rate.</p>
            <p></p>
            </div>
          </div>
        </div> <!-- /tabbable -->
        </div><!-- .span12 -->
    </div><!-- /help-assist -->
    <div class="content">
	<a href="#" id="show-help-assist">Help</a>
	<h2>Add Video Stream</h2>
    
<?php 

	load_categories();
	if (count($_video_categories) == 0) 
	{ 
	?>
		<div class="alert alert-error">Please <a href="cat_manager.php">create a category</a> first.</div>
	<?php
	}
		
	if ($step == 2)
	{
		if (strlen($return_msg) > 0)
		{
			echo '<div class="alert alert-error">'. $return_msg .'</div>';
		}
?>	
	
<form method="post" enctype="multipart/form-data" action="streamvideo.php" name="embed_video" onsubmit="return validateFormOnSubmit(this, 'Please fill in the required fields (highlighted)')">

<div class="container row-fluid" id="post-page">
    <div class="span9">
    <div class="widget border-radius4 shadow-div">
    <h4>Title &amp; Description</h4>
    <div class="control-group">
    <input name="video_title" type="text" id="must" value="<?php echo $inputs['video_title']; ?>" style="width: 99%;" />
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
                var pathtofile='<a href="uploads/'+file.name+'" target="_blank" >view &rarr;</a>';
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
	<textarea name="description" cols="100" id="textarea-WYSIWYG" class="tinymce" style="height: 120px;width:100%"><?php echo $inputs['description']; ?></textarea>
    <span class="autosave-message">&nbsp;</span>
    </div>
    </div>

		<div class="widget border-radius4 shadow-div">
		<h4>Video Source</h4>
        <div class="control-group">
        <label>File <i class="icon-info-sign" rel="popover" data-trigger="hover" data-animation="true" title="" data-content="Internal URL of video or audio file you want to stream.<br />This is the equivalent of JW Player's <code><i>file</i></code> flashvar. "></i></label>
        <div class="controls" id="show-opt-vs1-show">
        <input name="jw_file" type="text" id="must" value="<?php echo $inputs['jw_file']; ?>" class="bigger span12" />
        </div>
        </div>

        <div class="control-group">
        <label>Streamer <i class="icon-info-sign" rel="popover" data-trigger="hover" data-animation="true" title="" data-content="Location of an RTMP or HTTP server instance to use for streaming."></i></label>
        <div class="controls" id="show-opt-vs2-show">
        <input name="jw_streamer" type="text" id="must" value="<?php echo $inputs['jw_streamer']; ?>" class="bigger span12" />
        </div>
        </div>
        
        <div class="control-group">
        <label>Provider (<small>Optional</small>) <i class="icon-info-sign" rel="popover" data-trigger="hover" data-animation="true" title="" data-content="RTMP or HTTP "></i></label>
        <div class="controls">
        <select name="jw_provider" class="span2">
            <option value=''></option>
            <option value="rtmp" <?php echo ($_POST['jw_provider'] == 'rtmp') ? 'selected="selected"' : '';?>>RTMP</option>
            <option value="http" <?php echo ($_POST['jw_provider'] == 'http') ? 'selected="selected"' : '';?>>HTTP</option>
        </select>
        </div>
        </div>
        
        <!-- .provider_rtmp -->
        <div class="control-group provider_rtmp">
        <label>Load Balancing (<small>Optional</small>) <i class="icon-info-sign" rel="popover" data-trigger="hover" data-animation="true" title="" data-content="This is the equivalent of JW Player's <code><i>rtmp.loadbalance</i></code> flashvar."></i></label>
        <div class="controls">
        <label><input class="checkbox inline" type="radio" name="jw_rtmp_loadbalance" value="true" <?php echo ($inputs['jw_rtmp_loadbalance'] == 'true') ? 'checked="checked"' : '';?> /> On</label> 
        <label><input class="checkbox inline" type="radio" name="jw_rtmp_loadbalance" value="" <?php echo ($inputs['jw_rtmp_loadbalance'] != 'true') ? 'checked="checked"' : '';?> /> Off</label>
        </div>
        </div>
        <!-- .provider_rtmp -->
        
        <!-- .provider_rtmp -->
        <div class="control-group provider_rtmp">
        <label>Subscribe (<small>Optional</small>) <i class="icon-info-sign" rel="popover" data-trigger="hover" data-animation="true" title="Warning" data-content="This is the equivalent of JW Player's <code>rtmp.subscribe</code> flashvar."></i></label>
        <div class="controls">
        <label><input class="checkbox inline" type="radio" name="jw_rtmp_subscribe" value="true" <?php echo ($inputs['jw_rtmp_subscribe'] == 'true') ? 'checked="checked"' : '';?> /> Yes</label> 
        <label><input class="checkbox inline" type="radio" name="jw_rtmp_subscribe" value="" <?php echo ($inputs['jw_rtmp_subscribe'] != 'true') ? 'checked="checked"' : '';?> /> No</label>
        </div>
        </div>
        <!-- .provider_rtmp -->
        <div class="control-group provider_http">
        <label>Startparam (<small>Optional</small>) <i class="icon-info-sign" rel="popover" data-trigger="hover" data-animation="true" title="" data-content="This is the equivalent of JW Player's <code><i>rtmp.startparam</i></code> flashvar."></i></label>
        <div class="controls">
        <input type="text" name="jw_startparam" value="<?php echo $inputs['jw_startparam'];?>" size="20" class="bigger span12" />
        </div>
        </div>
        <!-- .provider_rtmp -->

        </div><!-- .widget -->

    </div><!-- .span8 -->
    <div class="span3">
		<div class="widget border-radius4 shadow-div">
		<h4>Thumbnail</h4>
            <div class="control-group container-fluid">
            <div class="controls row-fluid">
			<div class="">
            <a href="#" id="show-thumb" rel="tooltip" title="Click to add a thumbnail from an URL"><img src="<?php echo $inputs['yt_thumb']; ?>" width="100" height="70" id="must" class="img-polaroid" style="display:block;min-width:100;min-height:70px; background:url('img/no-thumbnail.jpg') no-repeat center center;" /></a>
            </div><!-- .span4 -->
			<div class="">
            	<br />
                <input type="file" name="thumb" onChange="javascript: if(this.value!='') yt_thumb.disabled='disabled'; else yt_thumb.disabled=''"/>
                <div id="show-opt-thumb">
				<br />
                <input type="text" name="yt_thumb" value="<?php echo $inputs['yt_thumb']; ?>" class="bigger span10" placeholder="http://" /> <i class="icon-info-sign" rel="tooltip" data-position="top" title="The thumbnail will refresh after you hit the 'Submit' button."></i>
                </div>
            </div><!-- .span8 -->
            </div><!-- .controls .row-fluid -->
            </div>
        </div><!-- .widget -->

		<div class="widget border-radius4 shadow-div">
		<h4>Category</h4>
            <div class="control-group">
            <div class="controls">
			<?php
            $categories_dropdown_options = array(
                                                'attr_name' => 'category[]',
                                                'attr_id' => 'main_select_category',
												'attr_class' => 'category_dropdown span12',
                                                'select_all_option' => false,
                                                'spacer' => '&mdash;',
                                                'selected' => 0,
                                                'other_attr' => 'multiple="multiple"'
                                                );
            echo categories_dropdown($categories_dropdown_options);
            ?>
            </div>
            </div>
		</div><!-- .widget -->
        
        <div class="widget border-radius4 shadow-div">
        <h4>Publish</h4>
            <div class="control-group">
            <label>Featured: <span id="value-featured"><strong>no</strong></span> <a href="#" id="show-featured">Edit</a></label>
            <div class="controls" id="show-opt-featured">
                <label><input type="checkbox" name="featured" id="featured" value="1" <?php if($inputs['featured'] == 1) echo 'checked="checked"';?> /> Yes, mark as featured</label>
            </div>
            </div>

            <div class="control-group">
            <label class="control-label" for="">Requires registration: <span id="value-register"><strong>no</strong></span> <a href="#" id="show-visibility">Edit</a></label>
            <div class="controls" id="show-opt-visibility">
                <label class="checkbox inline"><input type="radio" name="restricted" id="restricted" value="1" <?php echo ($inputs['restricted'] == '1') ? 'checked="checked"' : '';?> /> Yes</label> 
                <label class="checkbox inline"><input type="radio" name="restricted" id="restricted" value="0" <?php echo ($inputs['restricted'] != '1') ? 'checked="checked"' : '';?> /> No</label>
            </div>
            </div>

            <div class="control-group">
            <label class="control-label" for="">Publish: <span id="value-publish"><strong>immediately</strong></span> <a href="#" id="show-publish">Edit</a></label>
            <div class="controls" id="show-opt-publish">
            <?php echo ($_POST['date_month'] != '') ? show_form_item_date( pm_mktime($_POST) ) : show_form_item_date();	?>
            </div>
            </div>
        </div><!-- .widget -->

		<div class="widget border-radius4 shadow-div">
		<h4>Tags</h4>
            <div class="control-group">
            <div class="controls">
                <div class="tagsinput" style="width: 100%;">
                <input type="text" name="tags" value="<?php echo $inputs['tags']; ?>" id="tags_addvideo_1" />
                </div>
            </div>
            </div>
        </div><!-- .widget -->

    </div>
    
</div>
<div class="clearfix"></div>
<input type="hidden" name="language" value="1" />
<input type="hidden" name="source_id" value="0" />
<input type="hidden" name="age_verification" value="0" />
    
<div id="stack-controls" class="list-controls">
<div class="pull-left">

</div>
<input type="submit" name="submit" value="Submit" class="btn btn-small btn-success" />
</div><!-- #list-controls -->


	</form>
	<br />
<?php
	}	//	endif step == 2
	else if ($step == 3)
	{
		echo '<div class="alert alert-success">'. $return_msg .'</div>';
		
		echo '<br />';
		echo '<div class="btn-group"><input name="embed_new" type="button" value="&larr; Add a new stream" onClick="location.href=\'streamvideo.php\'" class="btn btn-small" />';
		echo '<input name="add_new" type="button" value="Add / upload new video" onClick="location.href=\'addvideo.php?step=1\'" class="btn btn-small" />';
		echo '<input name="import_new" type="button" value="Import from YouTube" onClick="location.href=\'import.php\'" class="btn btn-small" />';
		echo '</div>';
	}
?>	
    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>