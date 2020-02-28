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
$showm = '3';
$load_scrolltofixed = 1;
$load_chzn_drop = 1;
$load_tagsinput = 1;
$load_tinymce = 1;
$load_swfupload = 1;
include('header.php');

$mode = ($_GET['mode'] != '') ? $_GET['mode'] : 'add';
$category_type = $_GET['type']; // 'video' or 'article'
$category_id = (int) $_GET['cid'];


$form_data = $errors = array();
$success_add = $success_edit = $show_footer_early = false;

$categories_dropdown_options = array('first_option_text' => '- Root -', 
									 'attr_class' => 'category_dropdown span12',
									 'spacer' => '&mdash;',
									 'selected' => 0,
									 'db_table' => ($category_type == 'video') ? 'pm_categories' : 'art_categories'
									);

// $all_categories -> narrowing to a single array to work with; simpler this way
$all_categories = ($category_type == 'video') ? load_categories() : load_categories(array('db_table' => 'art_categories'));

$category_data = $all_categories[$category_id];

if ($mode == 'edit' && empty($category_id))
{
	$errors[] = 'Invalid category ID.';
}
else if ($mode == 'edit')
{
	$form_data = $category_data;
	$categories_dropdown_options['selected'] = $category_data['parent_id'];
}

if ($_POST['save'] != '' && count($errors) == 0)
{
	foreach ($_POST as $k => $v)
	{
		$_POST[$k] = stripslashes( trim($v) );
	}
	
	switch ($mode)
	{
		case 'add':
			
			$parent_cid = (int) $_POST['category'];
			$parent_cid = ($parent_cid < 0) ? 0 : $parent_cid;
			
			$name = $_POST['name'];
			$name = str_replace('&amp;', '"', $name);
			
			$tag = $_POST['tag'];
			$description = $_POST['description'];
			$meta_title = $_POST['meta_title'];
			$meta_keywords = $_POST['meta_keywords'];
			$meta_description = $_POST['meta_description'];
			
			if (empty($tag) || empty($name))
			{
				$errors[] = '<code>Category name</code> and <code>Slug</code> are mandatory fields.';
			}
			else
			{
				if( ! preg_match('/(^[a-z0-9_-]+)$/i', $tag)) 
				{
					$errors[] = 'Please make sure that the Slug is typed properly (no spaces, just latin characters [a-z, A-Z], numbers [0-9], "_" and "-").';
				}
				
				if (count($all_categories) > 0)
				{
					foreach ($all_categories as $id => $c)
					{
						if ($c['tag'] == $tag)
						{
							$errors[] = 'This slug is already used for <code>'. $c['name'] .'</code> category.';
							break;
						}
					}
				}
			}
			
			if (count($errors) == 0)
			{
				$sql_table = ($category_type == 'video') ? 'pm_categories' : 'art_categories';
				
				// get position of the last category
				$sql = "SELECT MAX(position) as max  
 						  FROM $sql_table 
						 WHERE parent_id = '". $parent_cid ."'";
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				mysql_free_result($result);
				
				$position = ($row['max'] > 0) ? ($row['max'] + 1) : 1;
				
				if ($category_type == 'video')
				{
					$meta_tags = '';

					if ($meta_title != '' || $meta_keywords != '' || $meta_description != '')
					{
						$meta_tags = array('meta_title' => str_replace('"', '&quot;', $meta_title),
										   'meta_keywords' => str_replace('"', '&quot;', $meta_keywords),
										   'meta_description' => str_replace('"', '&quot;', $meta_description)
										  );
						$meta_tags = serialize($meta_tags);
					}

					$sql = "INSERT INTO pm_categories (parent_id, tag, name, published_videos, total_videos, position, description, meta_tags) 
								 VALUES ('". $parent_cid ."', 
								 		 '". secure_sql($tag) ."', 
										 '". secure_sql($name) ."', 
										 0, 
										 0, 
										 ". $position .", 
										 '". secure_sql($description) ."',
										 '". secure_sql($meta_tags) ."'
										)";
					if ( ! ($result = mysql_query($sql)))
					{
						$errors[] = 'A problem occurred while creating the new category.<br /><strong>MySQL Reported:</strong>: '.mysql_error();
					}
					else
					{
						$success_add = true;
						$show_footer_early = true;
					}
				}
				else
				{
					$_POST['name'] = $name;
					$result = art_insert_category($_POST);
					if ($result['type'] == 'error')
					{
						$errors[] = $result['msg'];
					}
					else
					{
						$success_add = true;
						$show_footer_early = true;
					}
				}
			}
			
			$form_data = $_POST;
			$categories_dropdown_options['selected'] = $form_data['category'];
			
		break;
		
		case 'edit':
			
			$parent_cid = (int) $_POST['category'];
			$parent_cid = ($parent_cid < 0) ? 0 : $parent_cid;
			$parent_cid = ($parent_cid == $category_data['id']) ? $category_data['parent_id'] : $parent_cid; 
			
			$name = $_POST['name'];
			$name = str_replace('&amp;', '"', $name);
			$tag = $_POST['tag'];
			$description = $_POST['description'];
			$meta_title = $_POST['meta_title'];
			$meta_keywords = $_POST['meta_keywords'];
			$meta_description = $_POST['meta_description'];
			
			if (empty($tag) || empty($name))
			{
				$errors[] = '<code>Category name</code> and <code>Slug</code> are mandatory fields.';
			}
			else
			{
				if ($tag != $category_data['tag'] && ! preg_match('/(^[a-z0-9_-]+)$/i', $tag))
				{
					$errors[] = 'Please make sure that the Slug is typed properly (no spaces, just latin characters [a-z, A-Z], numbers [0-9], "_" and "-").';
				}

				if ($tag != $category_data['tag'])
				{
					foreach ($all_categories as $id => $c)
					{
						if ($c['tag'] == $tag && $c['id'] != $category_data['id'])
						{
							$errors[] = 'This slug is already used for <code>'. $c['name'] .'</code> category.';
							break;
						}
					}
				}
			}
			
			if (count($errors) == 0)
			{
				$position = $category_data['position'];

				if ($parent_cid != $category_data['parent_id'])
				{
					// EDITME @todo on edit, don't let the current category become a child of itself.
					
					$sql_table = ($category_type == 'video') ? 'pm_categories' : 'art_categories';
					// get position of the last category
					$sql = "SELECT MAX(position) as max  
	 						  FROM $sql_table 
							 WHERE parent_id = '". $parent_cid ."'";
					$result = mysql_query($sql);
					$row = mysql_fetch_assoc($result);
					mysql_free_result($result);
					
					$position = ($row['max'] > 0) ? ($row['max'] + 1) : 1;
				}
				
				$meta_tags = '';

				if ($meta_title != '' || $meta_keywords != '' || $meta_description != '')
				{
					$meta_tags = array('meta_title' => str_replace('"', '&quot;', $meta_title),
									   'meta_keywords' => str_replace('"', '&quot;', $meta_keywords),
									   'meta_description' => str_replace('"', '&quot;', $meta_description)
									  );
					$meta_tags = serialize($meta_tags);
				}

				if ($category_type == 'video')
				{
					$sql = "UPDATE pm_categories 
							SET parent_id = '". $parent_cid ."', 
								tag =  '". secure_sql($tag) ."', 
								name = '". secure_sql($name) ."',
								position = '". $position ."', 
								description = '". secure_sql($description) ."',
								meta_tags = '". secure_sql($meta_tags) ."'
							WHERE id = '$category_id'";

					if ( ! ($result = mysql_query($sql)))
					{
						$errors[] = 'A problem occurred while updating the category.<br /><strong>MySQL Reported:</strong>: '.mysql_error();
					}
					else
					{
						$sql = "UPDATE pm_categories 
								SET position = position - 1
								WHERE parent_id = '". $category_data['parent_id'] ."' 
								  AND position > '". $category_data['position'] ."'";
						mysql_query($sql);

						$success_edit = true;
						$show_footer_early = false;
					}
				}
				else
				{
					$result = art_update_category($category_id, array('name' => $name,
																	  'tag' => $tag,
																	  'old_tag' => $category_data['tag'],
																	  'parent_id' => $parent_cid,
																	  'position' => $position,
																	  'description' => $description,
																	  'meta_title' => $meta_title,
																	  'meta_keywords' => $meta_keywords,
																	  'meta_description' => $meta_description
																	 )
												);

					if ($result['type'] == 'error')
					{
						$errors[] = $result['msg'];
					}
					else
					{
						$success_edit = true;
						$show_footer_early = false;
					}
				}
			}
			
			$form_data = $_POST;
			$categories_dropdown_options['selected'] = $form_data['category'];
			
		break;
	}
}

?>
<div id="adminPrimary"> 
    <div class="content">
    <?php if ($mode == 'add') : ?>
	<h2>Add New <?php echo ($category_type == 'video') ? 'Video' : 'Article'; ?> Category</h2> 
	<?php else : ?>
	<h2>Edit <?php echo ($category_type == 'video') ? 'Video' : 'Article'; ?> Category: <?php echo $form_data['name'];?></h2>
	<?php endif; ?>
	
	<?php if (is_array($errors) && count($errors) > 0) : ?>
	<div class="alert alert-error">
		<?php if (count($errors) > 1) : ?>
		<ul>
		<?php foreach ($errors as $k => $err_msg) : ?>
		<li><?php echo $err_msg; ?></li>
		<?php endforeach; ?>
		</ul>
		<?php else : ?>
		<?php echo $errors[0]; ?>
		<?php endif; ?>
	</div>
	<?php endif;?>
	
	<?php if ($success_add) : ?>
	<div class="alert alert-success">
		Category <strong><?php echo $name;?></strong> was added successfully.
	</div>
	<hr />
	<?php if ($category_type == 'video') : ?>
	<a href="cat_manager.php" class="btn">&larr; Video Categories</a>
	<a href="edit_category.php?mode=add&type=video" class="btn btn-success">Add another video category &rarr;</a>
	<?php else : ?>
	<a href="article_categories.php" class="btn">&larr; Article Categories</a>
	<a href="edit_category.php?mode=add&type=article" class="btn btn-success">Add another article category &rarr;</a>
	<?php endif; ?>
	
	<?php if ($show_footer_early) : ?>
	    </div><!-- .content -->
	</div><!-- .primary -->
	<?php
	include('footer.php');
	exit();
	endif; // show_footer_early
	?>
	<?php endif; //if ($success_add) : ?>
	
	<?php if ($success_edit) : ?>
	<div class="alert alert-success">
		Category <strong><?php echo $name;?></strong> was updated.
	</div>
	<hr />
	<?php endif; ?>
	<?php if ($show_footer_early) : ?>
	    </div><!-- .content -->
	</div><!-- .primary -->
	<?php
	include('footer.php');
	exit();
	endif; // show_footer_early
	?>
	
	<form name="edit-category" method="POST" action="edit_category.php?mode=<?php echo $mode; ?>&type=<?php echo $category_type; echo ($mode == 'edit') ? '&cid='. $category_id : '';?>" class="form-horizontal">



<div class="container row-fluid" id="post-page">
    <div class="span9">
    <div class="widget border-radius4 shadow-div">
    <h4>Title &amp; Description</h4>
    <div class="control-group">
    <input type="text" name="name" id="must" value="<?php echo str_replace('"', '&quot;', $form_data['name']); ?>" style="width: 99%;" />
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
	<div class="clear"></div>
    <div class="controls">
    <textarea name="description" cols="100" id="textarea-WYSIWYG" class="tinymce" style="height: 300px;width:100%"><?php echo $form_data['description']; ?></textarea>
    <span class="autosave-message">&nbsp;</span>
    </div>
    </div>
    </div>
    
    </div><!-- .span8 -->

    <div class="span3">

    <div class="widget border-radius4 shadow-div">
    <h4>Slug <i class="icon-info-sign" rel="tooltip" title="Define how the URL will look in your address bar. No need to include an extension (.html)."></i></h4>
        <div class="control-group">
        <div class="controls">
            <input name="tag" id="page_name" type="text" class="default span12" value="<?php echo $form_data['tag']; ?>" size="50" style="width:95%" />
            <small>Updating this field will have an impact on SEO for pages already indexed</small>

            <div id="preview_url" class="small-ok">
            <?php 
                if(_SEOMOD == 1) 
                {
            ?>
                 <small>Live preview: <?php echo _URL."/browse-"; ?><span id="preview_complete_url"><?php echo ($form_data['tag'] != '') ? $form_data['tag'] : '';?></span>-1.html</small>
            <?php
                } else {
            ?>
                 <small>Live preview: <?php echo _URL."/category.php?cat="; ?><span id="preview_complete_url"></span></small>
            <?php			
                }
            ?>
            </div>
        </div>
        </div>
    </div><!-- .widget -->
            
    <div class="widget border-radius4 shadow-div">
    <h4>Parent Category</h4>
        <div class="control-group">
        <div class="controls">
		<?php echo categories_dropdown($categories_dropdown_options);?>
        </div>
        </div>
    </div><!-- .widget -->

    <div class="widget border-radius4 shadow-div">
    <h4>Meta Title</h4>
        <div class="control-group">
        <div class="controls">
        	<input type="text" name="meta_title" class="default span12" value="<?php echo str_replace('"', '&quot;', $form_data['meta_title']);?>" />
        </div>
        </div>
    </div><!-- .widget -->
      
    <div class="widget border-radius4 shadow-div">
    <h4>Meta Keywords</h4>
        <div class="control-group">
        <div class="controls">
            <div class="tagsinput" style="width: 100%;">
            <input type="text" name="meta_keywords" value="<?php echo str_replace('"', '&quot;', $form_data['meta_keywords']);?>" id="tags_addvideo_1" size="50" />
            </div>
        </div>
        </div>
    </div><!-- .widget -->

    <div class="widget border-radius4 shadow-div">
    <h4>Meta Description</h4>
        <div class="control-group">
        <div class="controls">
            <textarea name="meta_description" rows="1" style="width:95%" /><?php echo str_replace('"', '&quot;', $form_data['meta_description']);?></textarea>
        </div>
        </div>
    </div><!-- .widget -->
    
    </div>
</div>
<div class="clearfix"></div>

      
    <div id="stack-controls" class="list-controls">
    <div class="pull-left">
    </div>
    <input type="submit" name="save" value="<?php echo ($mode == 'add') ? 'Submit' : 'Save';?>" class="btn btn-success" />
    </div><!-- #list-controls -->
	
	</form>

	<?php echo csrfguard_form('_admin_catmanager'); ?>
    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>