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
include('header.php');

load_categories();

$pattern = '/(^[a-z0-9_-]+)$/i';

// UPDATE CATEGORY
if(!empty($_POST['update']) && $_POST['update'] == 'Update') {
	$cid = $_POST['cid'];
 	$tag = secure_sql(trim($_POST['tag']));
	$name = secure_sql(trim($_POST['name']));
	$parent_id = (int) $_POST['parent_id'];
	$old_tag = $_POST['old_tag'];

	if(empty($tag) || empty($name)) 
		$info_msg = '<div class="alert alert-error">Please don\'t leave any fields empty.</div>';	
	else {
		if( ! @preg_match($pattern, $tag)) {
		$info_err_msg = '<div class="alert alert-error">Please make sure that the Slug is typed properly (no spaces, just latin characters [a-z, A-Z], numbers [0-9], "_" and "-").</div>';
		} else {
			
			if (strcmp($old_tag, $tag) != 0)
			{
				$sql = "SELECT COUNT(*) as total_found 
						FROM pm_categories 
						WHERE tag = '". $tag ."'";
				$result = @mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				
				if ($row['total_found'] != 0)
				{
					$info_err_msg = '<div class="alert alert-error">This slug is already used by another category.</div>'; 
				}
				else
				{
					mysql_query("UPDATE pm_categories SET tag = '".$tag."', name = '".$name."' WHERE id = '".$cid."'");
					$info_msg = '<div class="alert alert-success">Category <strong>'.$name.'</strong> was updated.</div>';
					$_POST = array();
				}
			}
			else
			{
				mysql_query("UPDATE pm_categories SET name = '".$name."' WHERE id = '".$cid."'");
				$info_msg = '<div class="alert alert-success">Category <strong>'.$name.'</strong> was updated.</div>';
				$_POST = array();
			}
		}
	}
}

// ADD NEW CATEGORY
if(!empty($_POST['submit']) && $_POST['submit'] == 'Add category') {

	$parent_cid = $_POST['category']; // (parent_id)
	$cid = $_POST['cid'];
	$tag = secure_sql(trim($_POST['tag']));
	$name = secure_sql(trim($_POST['name']));
	
	if ($parent_cid < 0)
	{
		$parent_cid = 0;
	}
	
	if(empty($tag) || empty($name)) 
		$info_msg = '<div class="alert alert-error">Please don\'t leave any empty fields.</div>';	
	else {	
		$query = mysql_query("SELECT tag FROM pm_categories where tag = '".$tag."'");
		$result = mysql_num_rows($query);
		
		if($result == 0) {
		
			if( ! @preg_match($pattern, $tag)) {
			$info_err_msg = '<div class="alert alert-error">Please make sure that the slug contains allowed characters (use only letters, numbers, "_" and "-").</div>';
			} else {
				// get position of the last category
				$sql = "SELECT MAX(position) as max  
 						  FROM pm_categories 
						 WHERE parent_id = '". $parent_cid ."'";

				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				mysql_free_result($result);
				
				$position = ($row['max'] > 0) ? ($row['max'] + 1) : 1;
				
				$sql = "INSERT INTO pm_categories (parent_id, tag, name, published_videos, total_videos, position) 
							 VALUES ('". $parent_cid ."', '". $tag ."', '". $name ."', 0, 0, ". $position .")";
				 
				if ( ! ($result = mysql_query($sql)))
				{
					$info_msg  = '<div class="alert alert-error">There was a problem creating the new category.<br />';
					$info_msg .= '<strong>MySQL Reported:</strong>: '.mysql_error().'</div>';
				}
				else 
				{
					$info_msg = '<div class="alert alert-success">Category <strong>'.$name.'</strong> was added successfully.</div>';
					$_POST = array();
				}
			}
		
		} else {
				$info_msg = '<div class="alert alert-error">This slug is already used by another category.</div>';

		}
	}	
}
// DELETE (SUB)CATEGORY
if ($_GET['a'] == 1 && ! csrfguard_check_referer('_admin_catmanager'))
{
	$info_msg = '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
}
else if( !empty($_GET['cid']) && $_GET['a'] == 1)
{
	$info_msg = '';
	$cid = (int) $_GET['cid'];
	
	$categories = a_list_cats_simple();
	
	$parents = $children = array();
	foreach ($categories as $id => $cat_arr)
	{
		if ($cat_arr['parent_id'] == 0)
		{
			$parents[] = $cat_arr;
		}
		else
		{
			$children[$cat_arr['parent_id']][] = $cat_arr;
		}
	}
	
	$delete_ids = array();
	get_all_children($cid, $children, $delete_ids);
	
	// remember these values for later
	$parent_id = $categories[$cid]['parent_id'];
	$current_position = $categories[$cid]['position'];
	
	if (count($delete_ids) > 0)
	{
		$video_uniq_ids = array();
		$delete_ids_str = '';
		
		$delete_ids_str = implode(",", $delete_ids);
		
		$sql = "DELETE 
				FROM pm_categories 
				WHERE id IN (". $delete_ids_str .")";
		$result = mysql_query($sql);
		if ( ! $result) 
		{
			$info_msg  = '<div class="alert alert-error">There was a problem while updating your database!<br />';
			$info_msg .= '<strong>MySQL Reported:</strong>: '.mysql_error().'</div>';
		}
		
		// update positions for other categories
		$update_pos_ids = array();
		foreach ($categories as $id => $cat_arr)
		{
			if (($cat_arr['parent_id'] == $parent_id) && ($cat_arr['position'] > $current_position))
			{
				$update_pos_ids[] = $id;
			}
		}
		
		if (count($update_pos_ids) > 0)
		{
			$update_pos_ids = implode(',', $update_pos_ids);
			$sql = "UPDATE pm_categories 
					   SET position = position - 1 
					 WHERE id IN (". $update_pos_ids .")";
			$result = mysql_query($sql);
		}
		
	
		foreach ($delete_ids as $k => $id)
		{
			$delete_ids_str = '';
			foreach ($delete_ids as $k => $id)
			{
				$delete_ids_str .= "'". $id ."', ";
			}
			$delete_ids_str = substr($delete_ids_str, 0, -2);
			
			$videos = array();
			
			$sql = "UPDATE pm_videos 
					SET category = '0' 
					WHERE category IN (". $delete_ids_str .")";
			mysql_query($sql);
		}
	
		$info_msg = '<div class="alert alert-success">Category <strong>'.$categories[$cid]['name'].'</strong> was removed.';
		if (count($delete_ids) > 1)
		{
			$info_msg .= '<br />';
			$info_msg .= 'All existing subcategories have also been deleted.'; 
		}
		$info_msg .= '</div>';
	}
	
	unset($_video_categories);
}

if ($_GET['move'] != '' && $_GET['id'] != '')
{
	$id = (int) $_GET['id'];
	
	if ($id > 0)
	{
		$cat = a_list_cats_simple();
		
		$limit = 0;
		$is_parent = false;
		$is_child = false;

		if ($cat[$id]['parent_id'] == 0)
		{
			foreach ($cat as $c_id => $c_arr)
			{
				if ($c_arr['parent_id'] == 0)
				{
					$is_parent = true;
					$limit++;
				}
			}
		}
		else
		{
			foreach ($cat as $c_id => $c_arr)
			{
				if ($c_arr['parent_id'] == $cat[$id]['parent_id'])
				{
					$is_child = true;
					$limit++;
				}
			}
		}
		
		$current_position = $cat[$id]['position'];
		$prev_cat_id = $next_cat_id = 0;
		
		// find neighbours 
		foreach ($cat as $c_id => $c_arr)
		{
			if ($c_arr['position'] == ($current_position - 1) && $c_arr['parent_id'] == $cat[$id]['parent_id'])
			{
				$prev_cat_id = $c_id;
			}
			
			if ($c_arr['position'] == ($current_position + 1) && $c_arr['parent_id'] == $cat[$id]['parent_id'])
			{
				$next_cat_id = $c_id;
			}
		}
		
		switch ($_GET['move'])
		{
			case 'up':
				
				if ($current_position > 1 && $current_position <= $limit && $prev_cat_id)
				{
					$sql_1 = "UPDATE pm_categories
							   SET position = '". ($cat[$prev_cat_id]['position'] + 1) ."' 
							 WHERE id = '". $prev_cat_id ."'";
					$sql_2 = "UPDATE pm_categories
							   SET position = '". ($cat[$id]['position'] - 1) ."' 
							 WHERE id = '". $id ."'";
				}
				
			break;
	
			case 'down':
				
				if ($current_position >= 1 && $current_position < $limit && $next_cat_id)
				{
					$sql_1 = "UPDATE pm_categories
							   SET position = '". ($cat[$id]['position'] + 1) ."' 
							 WHERE id = '". $id ."'";
					
					$sql_2 = "UPDATE pm_categories
							   SET position = '". ($cat[$next_cat_id]['position'] - 1) ."' 
							 WHERE id = '". $next_cat_id ."'";
				}
				
			break;
		}
		
		if ($sql_1 != '' && $sql_2 != '')
		{
			if ( ! ($result = mysql_query($sql_1)))
			{
				$info_msg  = '<div class="alert alert-error">A problem occured while updating the database!<br />';
				$info_msg .= '<strong>MySQL Reported:</strong>: '.mysql_error().'</div>';
			}
			else
			{
				if ( ! ($result = mysql_query($sql_2)))
				{
					$info_msg  = '<div class="alert alert-error">A problem occured while updating the database!<br />';
					$info_msg .= '<strong>MySQL Reported:</strong>: '.mysql_error().'</div>';
				}
			}
			
			unset($_video_categories);
		}
	}
	
	if ($info_msg == '')
	{
		echo '<meta http-equiv="refresh" content="0;URL=cat_manager.php?cid='. $id .'&moved='. $_GET['move'] .'" />';
		exit();
	}
}

$total_categories = count_entries('pm_categories', '', '');

$categories_dropdown_options = array('first_option_text' => '- Root -', 
									 'attr_class' => 'inline',
									 'spacer' => '&mdash;',
									 'selected' => $_POST['category']
									);
?>
<div id="adminPrimary">
    <div class="row-fluid" id="help-assist">
        <div class="span12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#help-overview" data-toggle="tab">Overview</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="help-overview">
            <p>Categories are separated into Video and Article categories. The Article Categories appear only if the Article Module is enabled.</p>
			<p>At the top of the page there's a form to quickly add new categories as needed. Below you'll find a list of your current category tree. Categories can be moved up or down depending on the desired hierarchy.<br />Editing existing categories can be made without leaving the page. Simply hover the category to edit.</p>
			<p>Adding a new category requires a &quot;slug&quot;, which is the URL-friendly version of the category name. Categories can be placed in the &quot;root&quot; or in an existing category making it a subcategory.</p>
            </div>
          </div>
        </div> <!-- /tabbable -->
        </div><!-- .span12 -->
    </div><!-- /help-assist -->
    <div class="content">
    <a href="#" id="show-help-assist">Help</a>
    <div class="entry-count">
        <ul class="pageControls">
            <li>
                <div class="floatL"><strong class="blue"><?php echo pm_number_format($total_categories); ?></strong><span>categories</span></div>
                <div class="blueImg"><img src="img/ico-cats-new.png" width="18" height="17" alt="" /></div>
            </li>
        </ul><!-- .pageControls -->
    </div>
	<h2>Video Categories <a class="label opac5" onClick="parent.location='edit_category.php?mode=add&type=video'">+ add new</a></h2>

<?php echo $info_err_msg;?>
<?php echo $info_msg;?>
<?php if ($_GET['moved'] == 'up' || $_GET['moved'] == 'down') : ?>
<div class="alert alert-success">Category <strong><?php echo $_video_categories[$_GET['cid']]['name'];?></strong> moved <?php echo $_GET['moved']; ?>.</div>
<?php endif; ?>


<form name="search" action="cat_manager.php" method="post" class="form-inline">
<input name="name" type="text" value="<?php if($_POST['name'] != '') { echo $_POST['name']; } ?>" placeholder="Category name" size="22" />
<input name="tag" type="text" value="<?php if($_POST['tag'] != '') { echo $_POST['tag']; } ?>" placeholder="Slug" size="10" class="span2" /> 
<a href="#" rel="tooltip" title="Slugs are used in the URL and can only contain numbers, letters, dashes and underscores."><i class="icon-info-sign" rel="tooltip" title="Slugs are used in the URL and can only contain numbers, letters, dashes and underscores."></i></a>
Create in
<?php echo categories_dropdown($categories_dropdown_options); ?>
<button name="submit" type="submit" value="Add category" class="btn btn-success" />Add category</button>
</form>
<hr />
<div class="tablename">
<h6>Existing Video Categories</h6>
<div class="qsFilter">
<div class="btn-group input-prepend">
</div><!-- .btn-group -->
</div><!-- .qsFilter -->
</div>

<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered pm-tables tablesorter">
 <thead>
  <tr>
  	<th width="3%">ID</th>
	<th width="30%">Category Name</th>
    <th width="35%">Slug</th>
    <th width="15%">Parent Category</th>
	<th width="5%">Videos</th>
	<th width="5%">Position</th>
    <th width="10%" align="center" style="with: 90px;">Action</th>
  </tr>
 </thead>
 <tbody>
	<?php
	echo a_list_cats();
	?>
 </tbody>
</table>
<?php echo csrfguard_form('_admin_catmanager'); ?>
    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>