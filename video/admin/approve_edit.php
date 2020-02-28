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
$load_tagsinput = 0;
*/
$load_scrolltofixed = 1;
$load_chzn_drop = 1;
$load_tagsinput = 1;
$load_uniform = 1;
$load_tinymce = 1;
$load_swfupload = 1;
include('header.php');

$pm_temp_id = (int) $_GET['id'];
$r = array();
$errors = array();
$success = false;


if ($pm_temp_id)
{
	$sql = "SELECT * 
			FROM pm_temp 
			WHERE id = '". $pm_temp_id ."'";
	$result = mysql_query($sql);
	$r = mysql_fetch_assoc($result);
	mysql_free_result($result);
	
	$r['featured'] = 0;
	$r['restricted'] = 0;
	$r['site_views'] = 0;
	$r['submitted'] = $r['username'];
	$r['url_flv'] = $r['url'];
	$r['direct'] = $r['url'];
	$r['yt_thumb'] = ($r['thumbnail'] != '') ? _URL .'/uploads/thumbs/'. $r['thumbnail'] : '';
	$my_tags_str = $r['tags'];
	
}
else
{
	$errors[] = 'Missing suggested video ID';
}

if ($_POST['submit'] != '' && $pm_temp_id)
{
	$inputs = array();
	
	foreach($_POST as $k => $v)
	{
		if ( ! is_array($v))
		{
			$inputs[$k] = stripslashes(trim($v));
		}
		else
		{
			$inputs[$k] = $v;
		}
	}
	
	if (strlen($inputs['video_title']) == 0)
	{
		$errors[] = 'Insert the video title';
	}
	if ((is_array($inputs['category']) && count($inputs['category']) == 0) || ( ! isset($inputs['category'])))
	{
		$errors[] = 'Please select a category for this video';
	}
	
	$added = validate_item_date($_POST);
	
	if ($added === false)
	{
		$errors[] = 'Invalid publish date provided.';
		$result = false;
	}
	
	// save and approve video.
	if (count($errors) == 0)
	{
		define('PHPMELODY', true);
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
								'restricted' => 0 
								);
		$sources = a_fetch_video_sources();
		
		$video_details = array_merge($video_details, $inputs);
		
		$video_details['yt_length'] = ($inputs['yt_min'] * 60) + $inputs['yt_sec'];
		$video_details['added'] = pm_mktime($added);
		$video_details['site_views'] = $inputs['site_views_input'];
		//	generate unique id;
		$found = 0;
		$uniq_id = '';
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
		} while($found == 1);
		
		$video_details['uniq_id'] = $uniq_id;
		
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
			$inputs['yt_thumb'] = _URL."/uploads/thumbs/". $new_thumb_name . "." . strtolower($img->output);
			$video_details['yt_thumb'] = $inputs['yt_thumb'];
			
			// delete uploaded thumbnail
			if ($r['thumbnail'] != '' && $r['source_id'] == $sources['localhost']['source_id'])
			{
				if (file_exists(_THUMBS_DIR_PATH . $r['thumbnail']))
				{
					unlink(_THUMBS_DIR_PATH . $r['thumbnail']);
				}
			}
		}
		
		if ($inputs['yt_thumb'] != '' && $r['thumbnail'] != '' && $r['source_id'] == $sources['localhost']['source_id'])
		{
			// thumbnail URL changed?
			if ($inputs['yt_thumb'] != $r['yt_thumb'])
			{
				// delete uploaded thumbnail
				if (file_exists(_THUMBS_DIR_PATH . $r['thumbnail']))
				{
					unlink(_THUMBS_DIR_PATH . $r['thumbnail']);
				}
			}
		}
		
		
		//	fetch information about this video
		if ($inputs['source_id'] != $sources['localhost']['source_id'])
		{
			switch ($sources[ $video_details['source_id'] ]['source_name'])
			{
				case 'divx':
				case 'windows media player':
				case 'quicktime':
				case 'mp3':
					$video_details['source_id'] = $sources['other']['source_id'];
				break;
			}
			
			require_once( "./src/" . $sources[ $video_details['source_id'] ]['source_name'] . ".php");
			do_main($temp, $video_details['direct'], false);
			
			if($temp['yt_id'] == '')
			{
				$video_details['yt_id'] = substr( md5( time() ), 2, 9);
			}
			else
			{
				$video_details['yt_id'] = $temp['yt_id'];
			}
			
			if ($video_details['source_id'] == $sources['other']['source_id'])
			{
				$video_details['url_flv']	=	$video_details['direct'];
			}
			else
			{
				$video_details['url_flv']	=	$temp['url_flv'];
			}
			
			$video_details['mp4']		=	$temp['mp4'];
			
			if ($video_details['yt_thumb'] == '')
			{
				$video_details['yt_thumb']	= $temp['yt_thumb'];
			}
			
			if ($video_details['yt_length'] == 0)
			{
				$video_details['yt_length']	= (int) $temp['yt_length'];
			}
		}
		else // user uploaded video
		{
			if ($video_details['url_flv'] == '')
			{
				$video_details['url_flv'] = $r['url'];
			}

			if ($r['yt_thumb'] == $video_details['yt_thumb'])
			{
				// rename thumbnail
				$ext = strtolower(array_pop(explode('.', $r['thumbnail'])));
				if (rename(_THUMBS_DIR_PATH . $r['thumbnail'], _THUMBS_DIR_PATH . $uniq_id . '-1.'. $ext))
				{
					$r['thumbnail'] =  $uniq_id . '-1.'. $ext;
				}
				
				$inputs['yt_thumb'] = _THUMBS_DIR . $r['thumbnail'];
				$video_details['yt_thumb'] = $inputs['yt_thumb'];
			}
		}
		
		//	download thumbnail
		if ('' != $video_details['yt_thumb'] && $video_details['source_id'] != $sources['localhost']['source_id'])
		{
			$img = download_thumb($video_details['yt_thumb'], _THUMBS_DIR_PATH, $uniq_id);
		}
		
		foreach($video_details as $k => $v)
		{
			$video_details[$k] = str_replace("&amp;", "&", $v);
		}
		
		if (is_array($video_details['category']))
		{
			$video_details['category'] = implode(',', $video_details['category']);
		}

		//	Ok, let's add this video to our database
		$new_video = insert_new_video($video_details, $new_video_id);
		
		if ($new_video !== true)
		{
			$errors[] = '<em>Ouch, sorry! Could not insert new video in your database;</em><br /><strong>MySQL Reported: '.$new_video[0].'<br /><strong>Error Number:</strong> '.$new_video[1].'</div>';				
		}
		else
		{
			if($video_details['tags'] != '')
			{
				$tags = explode(",", $video_details['tags']);
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
			
			//	remove the suggested video from 'pm_temp'
			@mysql_query("DELETE FROM pm_temp WHERE id = '". $pm_temp_id ."'");
			
			$success = 'The video was saved and approved.</strong> <a href="'. _URL .'/watch.php?vid='. $uniq_id .'" target="_blank" title="Watch video">Watch this video</a>';
		}
		
	}
	
	$r = $inputs;
	$r['category'] = implode(',', $r['category']);
}

?>
<div id="adminPrimary">
    <div class="content">
    <h2>Edit Suggested/Uploaded Video</h2>
	
	<?php if ($success) : ?>
		<div class="alert alert-success">
			<?php echo $success;?>
		</div>
		<hr />
		<a href="approve.php" class="btn">&larr; Approve videos</a> 
		<a href="modify.php?vid=<?php echo $uniq_id;?>" class="btn">Edit</a>
		</div><!-- .content -->
		</div><!-- .primary -->
		<?php
		include('footer.php');
		exit();
		?>	
	<?php endif;?>
	
	<?php if (count($errors) > 0): ?>
		<div class="alert alert-error">
			<ul>
			<?php foreach ($errors as $k => $error) : ?>
			<li><?php echo $error;?></li>
			<?php endforeach; ?>
			</ul>
		</div>
	<?php endif; ?>
	
	<form name="update" enctype="multipart/form-data" action="approve_edit.php?id=<?php echo $pm_temp_id; ?>" method="post" onsubmit="return validateFormOnSubmit(this, 'Please fill in the required fields (highlighted)')">
	<div class="container row-fluid" id="post-page">
    <div class="span9">
    <div class="widget border-radius4 shadow-div">
    <h4>Title &amp; Description</h4>
    <div class="control-group">
    <input name="video_title" type="text" id="must" value="<?php echo htmlspecialchars($r['video_title']); ?>" style="width: 99%;" />
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
    <textarea name="description" cols="100" id="textarea-WYSIWYG" class="tinymce" style="height: 300px;width:100%"><?php echo $r['description']; ?></textarea>
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
            <a href="#" id="show-thumb" rel="tooltip" title="Click to add a thumbnail from an URL"><img src="<?php echo $r['yt_thumb']; ?>" width="100" height="70" id="must" style="display:block;min-width:80;min-height:50px; background:url('img/no-thumbnail.jpg') no-repeat center center;" /></a>
            </div><!-- .span4 -->
			<div class="">
                <br />
                <input type="file" name="thumb" onChange="javascript: if(this.value!='') yt_thumb.disabled='disabled'; else yt_thumb.disabled=''"/>
                <div id="show-opt-thumb">
                <br />
                <input type="text" name="yt_thumb" id="must" value="<?php echo $r['yt_thumb']; ?>" class="bigger span10" placeholder="http://" /> <i class="icon-info-sign" rel="tooltip" data-position="top" title="The thumbnail will refresh after you hit the 'Submit' button."></i>
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
            if($r['yt_length'] > 0) {	
                $yt_minutes = intval($r['yt_length'] / 60); 
                $yt_seconds = intval($r['yt_length'] % 60); 
            } else {
                $yt_minutes = 0;
                $yt_seconds = 0;
            }
            ?>
            <div class="control-group">
            <label class="control-label" for="">Duration: <span id="value-yt_length"><strong><?php echo sec2min($r['yt_length']);?></strong></span> <a href="#" id="show-duration">Edit</a></label>
            <div class="controls" id="show-opt-duration">
            <input type="text" name="yt_min" id="yt_length" value="<?php echo $yt_minutes; ?>" size="4" class="smaller-select" /> <small>min.</small>
            <input type="text" name="yt_sec" id="yt_length" value="<?php echo $yt_seconds; ?>" size="3" class="smaller-select" /> <small>sec.</small>
            <input type="hidden" name="yt_length" id="yt_length" value="<?php echo trim(($yt_minutes * 60) + $yt_seconds); ?>" />
            </div>
            </div>
            
            <div class="control-group">
            <label>Featured: <span id="value-featured"><strong><?php if($r['featured'] == 1) { echo 'yes'; } else { echo 'no'; } ?></strong></span> <a href="#" id="show-featured">Edit</a></label>
            <div class="controls" id="show-opt-featured">
                <label><input type="checkbox" name="featured" id="featured" value="1" <?php if($r['featured'] == 1) echo 'checked="checked"';?> /> Yes, mark as featured</label>
            </div>
            </div>

            <div class="control-group">
            <label class="control-label" for="">Requires registration: <span id="value-register"><strong><?php if($r['restricted'] == 1) { echo 'yes'; } else { echo 'no'; } ?></strong></span> <a href="#" id="show-visibility">Edit</a></label>
            <div class="controls" id="show-opt-visibility">
                <label class="checkbox inline"><input type="radio" name="restricted" id="restricted" value="0" <?php if ($r['restricted'] == 0) echo 'checked="checked"'; ?> /> No</label> 
                <label class="checkbox inline"><input type="radio" name="restricted" id="restricted" value="1" <?php if ($r['restricted'] == 1) echo 'checked="checked"'; ?> /> Yes</label>
            </div>
            </div>

            <div class="control-group">
            <label class="control-label" for="">Views: <span id="value-views"><strong><?php echo $r['site_views'];?></strong></span> <a href="#" id="show-views">Edit</a></label>
            <div class="controls" id="show-opt-views">
            <input type="hidden" name="site_views" value="<?php echo $r['site_views'];?>" />
            <input type="text" name="site_views_input" id="site_views_input" value="<?php echo $r['site_views']; ?>" size="10" class="bigger span2" />
            </div>
            </div>

            <div class="control-group">
            <label class="control-label" for="">Submitted by: <span id="value-submitted"><strong><?php echo htmlspecialchars($r['submitted']); ?></strong></span> <a href="#" id="show-user">Edit</a></label>
            <div class="controls" id="show-opt-user">
            <input type="text" name="submitted" id="submitted" value="<?php echo htmlspecialchars($r['submitted']); ?>" class="bigger span2" />
            </div>
            </div>

            <div class="control-group">
            <label class="control-label" for="">Published: <span id="value-publish"><strong><?php echo date("M d, Y", $r['added']);?></strong></span> <a href="#" id="show-publish">Edit</a></label>
            <div class="controls" id="show-opt-publish">
            <?php //echo ($_POST['date_month'] != '') ? show_form_item_date( pm_mktime($_POST) ) : show_form_item_date($r['date']);	?>
            <?php echo show_form_item_date($r['added']);?>
            </div>
            </div>
        </div><!-- .widget -->

		<div class="widget border-radius4 shadow-div">
		<h4>Tags</h4>
            <div class="control-group">
            <div class="controls">
                <div class="tagsinput" style="width: 100%;">
                <input type="text" name="tags" value="<?php echo $my_tags_str; ?>"  id="tags_addvideo_1" />
                </div>
            </div>
            </div>
        </div><!-- .widget -->
    </div>
    
</div>
<div class="clearfix"></div>


<input type="hidden" name="categories_old" value="<?php echo $r['category'];?>" />
<input type="hidden" name="language" value="1" />
<input type="hidden" name="source_id" value="<?php echo $r['source_id']; ?>" />
<input type="hidden" name="user_id" value="<?php echo $r['user_id'];?>" />
<input type="hidden" name="url_flv" value="<?php echo $r['url_flv']; ?>" />
<input type="hidden" name="direct" value="<?php echo $r['direct']; ?>" />
    
<div id="stack-controls" class="list-controls">
<div class="pull-left">

</div>
<input name="submit" type="submit" value="Save &amp; Approve" class="btn btn-small btn-success" />
</div><!-- #list-controls -->
</form>

    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>	