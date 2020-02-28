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

$showm = 'mod_article';
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
$load_tinymce = 1;
$load_swfupload = 1;
include('header.php');

$action = $_GET['do'];
if ( ! in_array($action, array('edit', 'new', 'delete')) )
{
	$action = 'new';	//	default action
}

?>
<script type="text/javascript">
$(document).ready(function(){
	$("img[name='article_thumbnail']").click(function() {
		var img = $(this);
		var ul = img.parents('.thumbs_ul');
		var li = img.parent();
		var input = $("input[name='post_thumb_show']");
		
		if ( ! li.hasClass('art-thumb-selected'))
		{
			ul.children().removeClass('art-thumb-selected').addClass('art-thumb-default');
			li.addClass('art-thumb-selected');
			input.val(img.attr('src'));
		}
	});
});
</script>

<div id="adminPrimary">
    <div class="content">
<?php if ($action == 'edit') { ?>
<h2>Edit Article</h2>
<?php } else { ?>
<h2>Post New Article</h2>
<?php } ?>
<div id="display_result" style="display:none;"></div>

<?php
if ( ! $config['mod_article'])
{
  ?>
   <div class="alert alert-info">
	The Article Module is currently disabled. Please enable it from '<a href="settings.php">Settings</a> / Available Modules'.
   </div>
  </div>
  <?php
  include('footer.php');
  exit();
}

load_categories(array('db_table' => 'art_categories'));
if (count($_article_categories) == 0) 
{ 
?>
	<div class="alert alert-error">Please <a href="article_categories.php">create a category</a> first.</div>
<?php
}

$inputs = array();

if ('' != $_POST['submit'])
{
	$_POST['title'] = after_post_filter($_POST['title']);
	$_POST['tags'] = after_post_filter($_POST['tags']);
	
	if ($action == 'new')
	{
		$result = insert_new_article($_POST);
	}
	else if ($action == 'edit')
	{
		$result = update_article($_POST['id'], $_POST);
	}
	
	if ($result['type'] == 'error')
	{
		echo '<div class="alert alert-error"><strong>'. $result['msg'] .'</strong></div>';
	}
	else
	{
		if ($action == 'new')
		{
			echo '<div class="alert alert-success"><strong>'. $result['msg'] .'.</strong> <a href="'. _URL .'/article_read.php?a='.$result['article_id'].'&mode=preview" target="_blank" title="View article">See how it looks.</a></div>';

			echo '<input name="continue" type="button" value="&larr; Manage articles" onClick="location.href=\'articles.php\'" class="btn" /> ';
			echo ' <input name="add_new" type="button" value="Post a new article &rarr;" onClick="location.href=\'article_manager.php?do=new\'" class="btn btn-success" />';
			echo '</div></div>';
			
			include('footer.php');
			exit();
		}
		else
		{
			echo '<div class="alert alert-success"><strong>'. $result['msg'] .'</strong> <a href="'. _URL .'/article_read.php?a='. $_POST['id'] .'&mode=preview" target="_blank">See how it looks.</a></div>';
		}
	}	
}

if ($action == 'edit')
{
	$id = (int) $_GET['id'];
	if ($id == 0)
	{
		$action = 'new';
		$inputs = array();
		$inputs['allow_comments'] = 1;
		$inputs['status'] = 1;
		$inputs['author'] = $userdata['id'];
		$inputs['category_as_arr'] = array();
	}
	else
	{
		$inputs = get_article($id);
	}
}
else if ($action == 'new')
{
	if ('' != $_POST['submit'])
	{
		$inputs = $_POST;
	}
	else
	{
		$inputs['allow_comments'] = 1;
		$inputs['status'] = 1;
		$inputs['author'] = $userdata['id'];
	}
	if ( ! is_array($inputs['category_as_arr']))
	{
		$inputs['category_as_arr'] = array();
	}
}

$categories = art_get_categories();

//	Filter some fields before output
$inputs['title'] = pre_post_filter($inputs['title']);
$inputs['tags'] = pre_post_filter($inputs['tags']);

?>


<form name="write_article" method="post" action="article_manager.php?do=<?php echo $action; ?>&id=<?php echo $_GET['id'];?>" onsubmit="return validateFormOnSubmit(this, 'Please fill in the required fields (highlighted).')">

<div class="container row-fluid" id="post-page">

    <div class="span9">
    <div class="widget border-radius4 shadow-div">
    <h4>Title &amp; Description</h4>
    <div class="control-group">
	<input name="title" type="text" id="must" value="<?php echo $inputs['title']; ?>" style="width: 99%;" />

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
    <textarea name="content" cols="100" id="textarea-WYSIWYG" class="tinymce" style="height: 350px;width:100%"><?php echo $inputs['content']; ?></textarea>
    <span class="autosave-message">&nbsp;</span>

    </div>
    </div>
    </div>
    
    </div><!-- .span8 -->

    <div class="span3">


		<div class="widget border-radius4 shadow-div">
		<h4>Category</h4>
            <div class="control-group">
            <div class="controls">
            <input type="hidden" name="categories_old" value="<?php echo $inputs['category'];?>"  />
            <?php 
            //$checklist_options = array('selected' => explode(',', $inputs['category']), 'ul_wrapper' => false);
            //echo art_cats_checklist($categories, $checklist_options);

            $categories_dropdown_options = array(
                        'db_table' => 'art_categories',
                        'attr_name' => 'categories[]',
                        'attr_id' => 'select_category-'. $counter,
						'attr_class' => 'category_dropdown span12',
                        'select_all_option' => false,
                        'spacer' => '&mdash;',
                        'selected' => explode(',', $inputs['category']), 
                        'other_attr' => 'multiple="multiple" size="3"',
                        'option_attr_id' => 'check_ignore'
                        );
            echo categories_dropdown($categories_dropdown_options);
            ?>
            </div>
            </div>
		</div><!-- .widget -->
        
        <div class="widget border-radius4 shadow-div">
        <h4>Publish</h4>
            <div class="control-group">
            <label>Comments: <span id="value-comments"><strong><?php if ($inputs['allow_comments'] == 1) { echo 'allowed'; } else { echo 'closed'; } ?></strong></span> <a href="#" id="show-comments">Edit</a></label>
            <div class="controls" id="show-opt-comments">
                <label><input name="allow_comments" id="allow_comments" type="checkbox" value="1" <?php if ($inputs['allow_comments'] == 1) echo 'checked="checked"';?> /> Allow comments on this article</label>
            </div>
            </div>
            
            <div class="control-group">
            <label class="control-label" for="">Visibility: <span id="value-visibility"><strong><?php if ($inputs['status'] == 0) { echo 'draft'; } else { echo 'public'; } ?></strong></span> <a href="#" id="show-visibility">Edit</a></label>
            <div class="controls" id="show-opt-visibility">
                <label class="checkbox inline"><input type="radio" name="status" id="visibility" value="0" <?php if ($inputs['status'] == 0) echo 'checked="checked"'; ?> /> Draft</label> 
                <label class="checkbox inline"><input type="radio" name="status" id="visibility" value="1" <?php if ($inputs['status'] == 1) echo 'checked="checked"'; ?> /> Public</label>
            </div>
            </div>

            <div class="control-group">
            <label>Sticky: <span id="value-featured"><strong><?php if($inputs['featured'] == 1) { echo 'yes'; } else { echo 'no'; } ?></strong></span> <a href="#" id="show-featured">Edit</a></label>
            <div class="controls" id="show-opt-featured">
                <label><input type="checkbox" name="featured" id="featured" value="1" <?php if($inputs['featured'] == 1) echo 'checked="checked"';?> /> Yes, stick to front page</label>
            </div>
            </div>

            <div class="control-group">
            <label class="control-label" for="">Requires registration: <span id="value-register"><strong><?php if($inputs['restricted'] == 1) { echo 'yes'; } else { echo 'no'; } ?></strong></span> <a href="#" id="show-restriction">Edit</a></label>
            <div class="controls" id="show-opt-restriction">
                <label class="checkbox inline"><input type="radio" name="restricted" id="restricted" value="0" <?php if ($inputs['restricted'] == 0) echo 'checked="checked"'; ?> /> No</label> 
                <label class="checkbox inline"><input type="radio" name="restricted" id="restricted" value="1" <?php if ($inputs['restricted'] == 1) echo 'checked="checked"'; ?> /> Yes</label>
            </div>
            </div>
                        
            <div class="control-group">
            <label class="control-label" for="">Publish: <span id="value-publish"><strong><?php if(empty($inputs['date'])) { echo 'immediately'; } else { echo date('M d, Y @ G:i',$inputs['date']); }?> </strong></span> <a href="#" id="show-publish">Edit</a></label>
            <div class="controls" id="show-opt-publish">
            <?php echo ($_POST['date_month'] != '') ? show_form_item_date( pm_mktime($_POST) ) : show_form_item_date($inputs['date']);	?>
            </div>
            </div>
        </div><!-- .widget -->

		<div class="widget border-radius4 shadow-div">
		<h4>Tags</h4>
            <div class="control-group">
            <div class="controls">
                <div class="tagsinput" style="width: 100%;">
                <input name="tags" type="text" value="<?php echo $inputs['tags']; ?>"  id="tags_addvideo_1" size="50" />
                </div>
            </div>
            </div>
        </div><!-- .widget -->


		<div class="widget border-radius4 shadow-div">
		<h4>Post thumbnail</h4>
            <div class="control-group">
            <div class="controls">
                <?php
            
                    $all_meta = $inputs['meta']['*'];
                    $total_thumbs = count($all_meta['post_thumb']);
                          
                    if ($total_thumbs > 0)
                    { 
                        echo '<ul class="thumbs_ul">';
                        
                        // display current selected thumbnail
                        if ($inputs['meta']['post_thumb_show'] != '')
                        {
                            echo '<li class="art-thumb-selected"><img src="img/bg-selected.gif" alt="" border="0" style="display:none" /><img src="'. _ARTICLE_ATTACH_DIR . $inputs['meta']['post_thumb_show'] .'" width="'. THUMB_W_ARTICLE .'" height="'. THUMB_H_ARTICLE .'" alt="Thumb 1" name="article_thumbnail" /></li>';	
                        }
                        
                        // display next thumbnails available for this post.
                        $limit = 10;
                        for ($i = 0; $i < $limit; $i++)
                        {
                            if (strlen($all_meta['post_thumb'][$i]) > 0)
                            {
                                if ($all_meta['post_thumb'][$i] != $inputs['meta']['post_thumb_show'])
                                {
                                    echo '<li class="art-thumb-default"><img src="img/bg-selected.gif" alt="" border="0" style="display:none" /><img src="'. _ARTICLE_ATTACH_DIR . $all_meta['post_thumb'][$i] .'" width="'. THUMB_W_ARTICLE .'" height="'. THUMB_H_ARTICLE .'"  alt="Thumb '. ($i + 2) .'" name="article_thumbnail" /></li>';
                                }
                                else
                                {
                                    $limit++;
                                }
                                
                                if ($limit > 99)
                                {
                                    break;
                                }
                            }
                        }
                        echo '</ul>';
                    } 
                    else
                    {
                        echo '<em>There are no thumbnails associated with this article. To create a thumbnail for this article first upload images within this post, then "Save" it.</em>';
                    }
                ?>
                <div class="clearfix"></div>
                    <input type="hidden" name="post_thumb_show" value="<?php if ($inputs['meta']['post_thumb_show'] != '') echo $inputs['meta']['post_thumb_show'];?>" />
            </div>
            </div>
        </div><!-- .widget -->
    </div>
    
</div>
<div class="clearfix"></div>


<input type="hidden" name="author" value="<?php  echo $inputs['author'];?>" />
<input type="hidden" name="id" value="<?php echo $inputs['id'];?>" />

<div id="stack-controls" class="list-controls">
<div class="pull-left">

</div>
<input name="cancel" type="button" value="Cancel" onClick="location.href='articles.php'" class="btn btn-small" />
<input name="submit" type="submit" <?php echo ($action == 'edit') ? 'value="Save"' : 'value="Publish"';?> class="btn btn-small btn-success" />
</div><!-- #list-controls -->
    
</form>


    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>