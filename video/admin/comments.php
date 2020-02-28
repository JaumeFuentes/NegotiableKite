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

// Update comment?
if ('' != $_POST['update'])
{
	session_start();
	require('../config.php');
	include_once(ABSPATH . 'include/user_functions.php');
	include_once(ABSPATH . 'include/islogged.php');
	include(ABSPATH .'admin/functions.php');
	
	$response = array('success' => false, 'msg' => '');
	
	if ( ! $logged_in )
	{
		$response['msg'] = 'Please log in first.';
		echo json_encode($response);
		exit();
	}
	if ( ! is_admin() || (is_moderator() && ! mod_can('manage_comments')))
	{
		$response['msg'] = 'Sorry, you do not have access to this area.';
		echo json_encode($response);
		exit();
	}
	
	$comment_id = (int) $_POST['comment_id'];
	if ($comment_id)
	{
		$comment = trim($_POST['comment_txt']);
		$comment = nl2br($comment);
		$comment = secure_sql($comment);
		
		$sql = "UPDATE pm_comments 
				SET comment = '". $comment ."' 
				WHERE id = '". $comment_id ."'";
		if ( ! $result = mysql_query($sql))
		{
			$response['msg'] = 'Comment editing failed. MySQL Error: '. mysql_error();
		}
		else
		{
			$response['success'] = true;
		}
	}
	
	echo json_encode($response);
	exit();
}


$showm = '4';
$load_scrolltofixed = 1;
include('header.php');

$vid 		= trim($_GET['vid']);
$action 	= $_GET['a'];
$comment_id = (int) trim($_GET['cid']);
$page 		= $_GET['page'];

$filter = '';
$filters = array('articles', 'videos', 'flagged', 'pending');

if(in_array(strtolower($_GET['filter']), $filters) !== false)
{
	$filter = strtolower($_GET['filter']);
}

if($page == 0)
	$page = 1;

$limit 		= 20;	//	comments per page
$from 		= $page * $limit - ($limit);


//	Batch Delete/Approve Comments/Remove flag
if (($_POST['Submit'] == 'Delete checked' || $_POST['Submit'] == 'Approve checked' || $_POST['Submit'] == 'Remove flag') &&  ! csrfguard_check_referer('_admin_comments'))
{	
	$info_msg = '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
}
else if($_POST['Submit'] == 'Delete checked' || $_POST['Submit'] == 'Approve checked' || $_POST['Submit'] == 'Remove flag')
{
	$video_ids = array();
	$video_ids = $_POST['video_ids'];
	
	$total_ids = count($video_ids);
	if($total_ids > 0)
	{
		$in_arr = '';
		for($i = 0; $i < $total_ids; $i++)
		{
			$in_arr .= $video_ids[ $i ] . ", ";
		}
		$in_arr = substr($in_arr, 0, -2);
		if(strlen($in_arr) > 0)
		{
			if($_POST['Submit'] == 'Approve checked')
			{
				$sql = "UPDATE pm_comments SET approved = '1' WHERE id IN (" . $in_arr . ")";
				$result = @mysql_query($sql);
	
				if(!$result)
					$info_msg = '<div class="alert alert-error">An error occured while updating your database.<br />MySQL returned: '.mysql_error().'</div>';
				else
					$info_msg = '<div class="alert alert-success">The selected comments have been approved.</div>';
				
				if (_MOD_SOCIAL)
				{
					$sql = "SELECT id, uniq_id, user_id 
							FROM pm_comments WHERE id IN (" . $in_arr . ")";
					$result = mysql_query($sql);
					while ($row = mysql_fetch_assoc($result))
					{
						if (strpos($row['uniq_id'], 'article-') !== false)
						{
							$id = array_pop(explode('-', $row['uniq_id']));
							$article = get_article($id);
							log_activity(array(
									'user_id' => $row['user_id'],
									'activity_type' => ACT_TYPE_COMMENT,
									'object_id' => $row['id'],
									'object_type' => ACT_OBJ_COMMENT,
									'object_data' => array(),
									'target_id' => $id,
									'target_type' => ACT_OBJ_ARTICLE,
									'target_data' => $article
									)
								);
						}
						else
						{
							$video = request_video($row['uniq_id']);
							log_activity(array(
									'user_id' => $row['user_id'],
									'activity_type' => ACT_TYPE_COMMENT,
									'object_id' => $row['id'],
									'object_type' => ACT_OBJ_COMMENT,
									'object_data' => array(),
									'target_id' => $video['id'],
									'target_type' => ACT_OBJ_VIDEO,
									'target_data' => $video
									)
								);
						}
					}
				}
			}
			else if ($_POST['Submit'] == 'Remove flag')
			{
				$sql = "UPDATE pm_comments SET report_count = '0' WHERE id IN (" . $in_arr . ")";
				$result = @mysql_query($sql);
				
				if ( ! $result)
				{
					$info_msg = '<div class="alert alert-error">An error occured while updating your database.<br />MySQL returned: '.mysql_error().'</div>';
				}
				else
				{
					@mysql_query("DELETE FROM pm_comments_reported WHERE comment_id IN (" . $in_arr . ")");
					$info_msg = '<div class="alert alert-success">The selected flags have been removed.</div>';
				}
			}
			else
			{
				if (_MOD_SOCIAL)
				{
					$sql = "SELECT id, uniq_id, user_id 
							FROM pm_comments WHERE id IN (" . $in_arr . ")";
					if ($result = mysql_query($sql))
					{
						while (	$row = mysql_fetch_assoc($result))
						{
							$sql = "DELETE FROM pm_activity 
									WHERE user_id = '". $row['user_id'] ."' 
									  AND activity_type = '". ACT_TYPE_COMMENT ."'
									  AND object_id = '". $row['id'] ."' 
									  AND object_type = '". ACT_OBJ_COMMENT ."'";
							@mysql_query($sql);
						}
						mysql_free_result($result);
					}
				}
				
				$sql = "DELETE FROM pm_comments WHERE id IN (" . $in_arr . ")";
				$result = @mysql_query($sql);
				
				if(!$result)
				{
					$info_msg = '<div class="alert alert-error">There was an error while updating your database.<br />MySQL returned: '.mysql_error().'</div>';
				}
				else
				{
					// remove reports
					$sql = "DELETE FROM pm_comments_reported WHERE comment_id IN (" . $in_arr . ")";
					$result = @mysql_query($sql);
					
					$in_arr = '';
					for($i = 0; $i < $total_ids; $i++)
					{
						if ($video_ids[ $i ] > 0)
						{
							$in_arr .= "'com-". $video_ids[ $i ] . "', ";
						}
					}
					$in_arr = substr($in_arr, 0, -2);
					
					// remove likes/dislikes
					$sql = "DELETE FROM pm_bin_rating_votes WHERE uniq_id IN (". $in_arr .")";
					$result = @mysql_query($sql);
					
					$info_msg = '<div class="alert alert-success">The selected comments have been deleted.</div>';
				}
			}
		}
	}
	else
		$info_msg = '<div class="alert alert-error">Please select something first.</div>';
}

switch($action)
{
	case 1:
		if (csrfguard_check_referer('_admin_comments'))
		{
			if (_MOD_SOCIAL)
			{
				$sql = "SELECT id, uniq_id, user_id 
						FROM pm_comments WHERE id = '" . $comment_id . "'";
				if ($result = mysql_query($sql))
				{
					$row = mysql_fetch_assoc($result);
					$sql = "DELETE FROM pm_activity 
							WHERE user_id = '". $row['user_id'] ."' 
							  AND activity_type = '". ACT_TYPE_COMMENT ."'
							  AND object_id = '". $row['id'] ."' 
							  AND object_type = '". ACT_OBJ_COMMENT ."'";
					@mysql_query($sql);
					mysql_free_result($result);
				}
			}
			@mysql_query("DELETE FROM pm_comments WHERE id = '".$comment_id."'");
			@mysql_query("DELETE FROM pm_comments_reported WHERE comment_id = '".$comment_id."'");
			@mysql_query("DELETE FROM pm_bin_rating_votes WHERE uniq_id = 'com-".$comment_id."'");
			$info_msg = '<div class="alert alert-info">Comment(s) deleted.</div>';
		}
		else
		{
			$info_msg = '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
		}
	break;
	case 2:
		if (csrfguard_check_referer('_admin_comments'))
		{
			@mysql_query("UPDATE pm_comments SET approved='1' WHERE id = '".$comment_id."'");
			
			if (_MOD_SOCIAL)
			{
				$sql = "SELECT id, uniq_id, user_id 
						FROM pm_comments WHERE id = '" . $comment_id . "'";
				$result = mysql_query($sql);
				$row = mysql_fetch_assoc($result);
				if (strpos($row['uniq_id'], 'article-') !== false)
				{
					$id = array_pop(explode('-', $row['uniq_id']));
					$article = get_article($id);
					log_activity(array(
							'user_id' => $row['user_id'],
							'activity_type' => ACT_TYPE_COMMENT,
							'object_id' => $row['id'],
							'object_type' => ACT_OBJ_COMMENT,
							'object_data' => array(),
							'target_id' => $id,
							'target_type' => ACT_OBJ_ARTICLE,
							'target_data' => $article
							)
						);
				}
				else
				{
					$video = request_video($row['uniq_id']);
					log_activity(array(
							'user_id' => $row['user_id'],
							'activity_type' => ACT_TYPE_COMMENT,
							'object_id' => $row['id'],
							'object_type' => ACT_OBJ_COMMENT,
							'object_data' => array(),
							'target_id' => $video['id'],
							'target_type' => ACT_OBJ_VIDEO,
							'target_data' => $video
							)
						);
				}
			}
			$info_msg = '<div class="alert alert-success">Comment(s) approved.</div>';
		}
		else
		{
			$info_msg = '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
		}
	break;
}

$comments_nonce = csrfguard_raw('_admin_comments');

//	Search
if(!empty($_GET['submit']) || !empty($vid))
{
	if(!empty($vid))
	{
		$comments = a_list_comments($vid, 'uniq_id', $from, $limit, $page);
	}
	else
	{
		$search_query = ($_POST['keywords'] != '') ? trim($_POST['keywords']) : trim($_GET['keywords']);
		$search_type = ($_POST['search_type'] != '') ? $_POST['search_type'] : $_GET['search_type'];
		$search_query = urldecode($search_query);
		$comments = a_list_comments($search_query, $search_type, $from, $limit, $page);
	}
	$total_comments = $comments['total'];
}
else 
{
	$total_comments = count_entries('pm_comments', '', '');
	
	if($total_comments - $from == 1)
		$page--;
		
	$comments = a_list_comments('', '', $from, $limit, $page, $filter);

	if($total_comments - $from == 1)
		$page++;
	
	$total_comments = $comments['total'];
}

// generate smart pagination
$filename = 'comments.php';
$uri = $_SERVER['REQUEST_URI'];
$uri = explode('?', $uri);
$uri[1] = str_replace(array("<", ">", '"', "'", '/'), '', $uri[1]);

$pagination = '';
$pagination = a_generate_smart_pagination($page, $total_comments, $limit, 1, $filename, $uri[1]);


?>
<div id="adminPrimary">
    <div class="row-fluid" id="help-assist">
        <div class="span12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#help-overview" data-toggle="tab">Overview</a></li>
            <li><a href="#help-onthispage" data-toggle="tab">Filtering</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="help-overview">
            <p>Comments posted on your site, are organized into &quot;video comments&quot; and &quot;article comments&quot;. An icon will represent the comment type. Selecting the &quot;COMMENTS&quot; item from the menu will list all existing comments with the latest ones showing first.</p>
			<p>If the site has comment moderation enabled, pending comments will also appear in the list. To approve a comment click the &quot;check&quot; icon from the &quot;Actions&quot; column.</p>
			<p>Hovering any existing message, both published and pending approval allows for easy in-line editing. This is helpful when it comes to removing unsolicited advertising, sensitive data and so on.</p>
            </div>
            <div class="tab-pane fade" id="help-onthispage">
            <p>Listing pages such as this one contain a filtering area which comes in handy when dealing with a large number of entries. The filtering options is always represented by a gear icon positioned on the top right area of the listings table. Clicking this icon usually reveals a  search form and one or more drop-down filters.</p>
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
                <div class="floatL"><strong class="blue"><?php echo pm_number_format($total_comments); ?></strong><span>comment(s)</span></div>
                <div class="blueImg"><img src="img/ico-comments-new.png" width="19" height="13" alt="" /></div>
            </li>
        </ul><!-- .pageControls -->
    </div>
	<h2><?php if($filter == 'articles') { ?>Article <?php } elseif($filter == 'videos') { ?>Video <?php } else {} ?> Comments</h2>
	<?php echo $info_msg; ?>
    
    <div class="tablename">
    <h6><?php if (!empty($filter)) { ?><button type="button" id="" class="btn btn-link btn-mini btn-danger" onClick="parent.location='comments.php'">Remove filter</button><?php } ?>
	<?php if (!empty($_GET['keywords'])) { ?>SEARCH RESULTS FOR "<em><?php echo $_GET['keywords']; ?></em>"<?php } ?></h6>
        <div class="pull-right">
        <button type="button" class="btn btn-link btn-options" data-toggle="button" id="showfilter"><img src="img/ico-options.gif" width="30" height="18" /></button>
        </div>
    </div>
    
    <div class="tablename tablenameLight2" id="showfilter-content">
    <div class="row-fluid">
    <div class="span4">
        <form name="search" action="comments.php" method="get" class="form-search" onsubmit="return validateSearch('true');">
        <div class="input-append">
        <input type="text" name="keywords" value="<?php echo $_GET['keywords']; ?>" />
        <select name="search_type" class="input-small">
         <option value="comment" <?php echo ($_GET['search_type'] == "comment") ? 'selected="selected"' : ''; ?> >Comment</option>
         <option value="uniq_id" <?php echo ($_GET['search_type'] == "uniq_id") ? 'selected="selected"' : ''; ?> >Video Unique ID</option>
         <option value="username" <?php echo ($_GET['search_type'] == "username") ? 'selected="selected"' : ''; ?> >Username</option>
         <option value="ip" <?php echo ($_GET['search_type'] == "ip") ? 'selected="selected"' : ''; ?> >IP Address</option>
        </select> 
        <button name="submit" type="submit" value="Search" class="btn" />Search</button>
        </div>
        </form>
    </div>
    <div class="span8">
    
    <div class="qsFilter pull-right">
    <div class="btn-group input-prepend">
      <div class="form-filter-inline">
	  <?php
      if(!empty($_GET['filter'])) {
      ?>
      <button type="button" id="appendedInputButtons" class="btn btn-danger" onClick="parent.location='comments.php'">Remove filter</button>
      <?php } else { ?>
      <button type="button" id="appendedInputButtons" class="btn">Filter</button>
      <?php } ?>
		<form name="other_filter" action="comments.php" class="form-inline">
	      <select name="URL" onChange="window.parent.location=this.form.URL.options[this.form.URL.selectedIndex].value">
	        <option value="comments.php">choose ...</option>
    		<option value="comments.php?filter=flagged&page=1" <?php if ($filter == 'flagged') echo 'selected="selected"'; ?>>Flagged</option>
            <option value="comments.php?filter=pending&page=1" <?php if ($filter == 'pending') echo 'selected="selected"'; ?>>Pending</option>
		  </select>
		</form>
      </div><!-- .form-filter-inline -->
    </div><!-- .btn-group -->
    </div><!-- .qsFilter -->
    
    </div>
    </div>
    </div>
     <?php 
	/*
	 * */
	$form_action = 'comments.php?page='. $page;
	
	$form_action .= ($filter != '') ? '&filter='. $filter : '';
	$form_action .= ($_GET['vid'] != '') ? '&vid='. $_GET['vid'] : '';
	$form_action .= ($_GET['keywords'] != '') ? '&keywords='. $_GET['keywords'] .'&search_type='. $_GET['search_type'] .'&submit=Search' : '';
	?>
    <form name="comments_checkboxes" action="<?php echo $form_action;?>" method="post">
    <table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered pm-tables">
     <thead>
      <tr>
        <th align="center" width="20"><input type="checkbox" name="checkall" onclick="checkUncheckAll(this);"/></th>
        <th align="center" style="text-align:center" width="20"> </th>
        <th width="250">Comment for</th>
        <th width="100">Added</th>
        <th>Comment</th>
        <th width="120">Posted by</th>
        <th width="100">IP</th>
        <th width="130" style="width: 90px">Action</th>
      </tr>
     </thead>
     <tbody>

        <?php echo $comments['comments']; ?>
        <tr><td colspan="8" class="tableFooter"><div class="pagination pull-right"><?php echo $pagination; ?></div></td></tr>
     </tbody>
    </table>


    <div class="clearfix"></div>
    
    <div id="stack-controls" class="list-controls">
    <div class="pull-left">

    </div>
	<div class="btn-toolbar">
		<div class="btn-group">
		<input type="submit" name="Submit" value="Remove flag" class="btn btn-small btn-blueish" />
		</div>
		
		<div class="btn-group">
		<input type="submit" name="Submit" value="Approve checked" class="btn btn-small btn-success">
		<input type="submit" name="Submit" value="Delete checked" class="btn btn-small btn-danger">
		</div>
	</div>
    </div><!-- #list-controls -->
   
	<input type="hidden" name="_pmnonce" id="_pmnonce<?php echo $comments_nonce['_pmnonce'];?>" value="<?php echo $comments_nonce['_pmnonce'];?>" />
	<input type="hidden" name="_pmnonce_t" id="_pmnonce_t<?php echo $comments_nonce['_pmnonce'];?>" value="<?php echo $comments_nonce['_pmnonce_t'];?>" />
    
    </form>

    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>