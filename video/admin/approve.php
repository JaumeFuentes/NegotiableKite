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

$showm	= '2';
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
$load_prettypop = 1;
include('header.php');

$action	 = $_GET['a'];
$id 	 = (int) $_GET['vid'];
$page	 = (int) $_GET['page'];

if($_POST['Submit'] != '')
{
	if($_POST['Submit'] == 'Delete checked')
		$action = 'delvids';
}

if($page == '' || !is_numeric($page))
   $page = 1;

$limit = (isset($_COOKIE['aa_videos_per_page'])) ? $_COOKIE['aa_videos_per_page'] : 30;

$from = $page * $limit - ($limit);


switch($action)
{
	case 'deleted':
		$info_msg = "<div class=\"alert alert-success\">The selected entry was removed.</div>";
	break;
	
	case 'approve':
		if($id == '')	break;
		
		if ( ! csrfguard_check_referer('_admin_approve'))
		{
			$info_msg = '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
			break;
		}
		
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

		$temp	= array();
		$query = mysql_query("SELECT * FROM pm_temp WHERE id = '".$id."'");
		$input = mysql_fetch_assoc($query);
		mysql_free_result($query);

		$video_details['video_title']	=	$input['video_title'];
		$video_details['description']	=	$input['description'];
		$video_details['submitted']		=	$input['username'];
		$video_details['direct']		=	$input['url'];
		$video_details['category']		=	$input['category'];
		$video_details['submitted']		=	$input['username'];
		$video_details['source_id']		=	$input['source_id'];
		$video_details['language']		=	$input['language'];
		$video_details['tags']			=	$input['tags'];

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
		
		
		//	fetch information about this video
		if ($input['source_id'] != $sources['localhost']['source_id'])
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
				$video_details['url_flv']	=	$input['url'];
			}
			else
			{
				$video_details['url_flv']	=	$temp['url_flv'];
			}
			
			$video_details['mp4']		=	$temp['mp4'];
			$video_details['yt_length']	=	$temp['yt_length'];
			$video_details['yt_thumb']	=	$temp['yt_thumb'];
		}
		else // user uploaded video
		{
			$video_details['url_flv'] = $input['url'];
			$video_details['direct'] = $input['url'];
			$video_details['yt_length'] = $input['yt_length'];
			
			if ($input['thumbnail'] != '')
			{
				$ext = strtolower(array_pop(explode('.', $input['thumbnail'])));
				if (rename(_THUMBS_DIR_PATH . $input['thumbnail'], _THUMBS_DIR_PATH . $uniq_id . '-1.'. $ext))
				{
					$input['thumbnail'] =  $uniq_id . '-1.'. $ext;
				}
				
				$video_details['yt_thumb'] = _THUMBS_DIR . $input['thumbnail'];	
			}
			else
			{
				$video_details['yt_thumb'] = '';
			}
		}

		$video_details['uniq_id'] = $uniq_id;

		//	download thumbnail
		if ('' != $video_details['yt_thumb'] && $video_details['source_id'] != $sources['localhost']['source_id'])
		{
			$img = download_thumb($video_details['yt_thumb'], _THUMBS_DIR_PATH, $uniq_id);
		}
		
		foreach($video_details as $k => $v)
		{
			$video_details[$k] = str_replace("&amp;", "&", $v);
		}
		
		//	Ok, let's add this video to our database
		$new_video = insert_new_video($video_details, $new_video_id);
		
		if($new_video !== true)
		{
			$info_msg = '<div class="alert alert-error"><em>Ouch, sorry! Could not insert new video in your database;</em><br /><strong>MySQL Reported:</strong> ".$new_video[0]."<br /><strong>Error Number:</strong> '.$new_video[1].'</div>';				
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
			
			if (_MOD_SOCIAL)
			{
				$act_type = ($video_details['source_id'] == $sources['localhost']['source_id']) ? ACT_TYPE_UPLOAD_VIDEO : ACT_TYPE_SUGGEST_VIDEO; 
				
				log_activity(array(
							'user_id' => username_to_id($video_details['submitted']),
							'activity_type' => $act_type,
							'object_id' => $new_video_id,
							'object_type' => ACT_OBJ_VIDEO,
							'object_data' => $video_details
							)
					);
					

			}
			
			$info_msg = '<div class="alert alert-success">Video has been approved!<br />Would you like to <a href="modify.php?vid='.$uniq_id.'">edit</a> it now?</div>'; 
		}

		//	remove the suggested video from 'pm_temp'
		@mysql_query("DELETE FROM pm_temp WHERE id = '".$id."'");
	break;
	
	case 'delall':
		
		if ( ! csrfguard_check_referer('_admin_approve'))
		{
			$info_msg = '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
			break;
		}
			
		$files = array();
		$sql = "SELECT url FROM pm_temp WHERE source_id = '1'";
		$result = mysql_query($sql);
		
		if (mysql_num_rows($result) > 0)
		{
			while ($row = mysql_fetch_assoc($result))
			{
				$files[] = $row['url'];
			}
			mysql_free_result($result);
		}
		
		if (count($files) > 0)
		{
			foreach ($files as $k => $filename)
			{
				if (file_exists(_VIDEOS_DIR_PATH . $filename) && strlen($filename) > 0)
				{
					unlink(_VIDEOS_DIR_PATH . $filename);
				}
			}
		}
		
		mysql_query("TRUNCATE TABLE pm_temp");
		$info_msg = '<div class="alert alert-success">All pending videos have been removed.</div>';
	break;
	
	case 'delvid':
		
		if ( ! csrfguard_check_referer('_admin_approve'))
		{
			$info_msg = '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
			break;
		}
		
		$sql = "SELECT url, source_id, thumbnail FROM pm_temp WHERE id = '". $id ."'";
		$result = mysql_query($sql);
		$video = mysql_fetch_assoc($result);
		mysql_free_result($result);
		
		if ($video['source_id'] == 1)
		{
			if (file_exists(_VIDEOS_DIR_PATH . $video['url']) && strlen($video['url']) > 0)
			{
				unlink(_VIDEOS_DIR_PATH . $video['url']);
			}
			if ($video['thumbnail'] != '')
			{
				unlink(_THUMBS_DIR_PATH . $video['thumbnail']);
			}
		}

		@mysql_query("DELETE FROM pm_temp WHERE id = '".$id."'");
	
		echo '<meta http-equiv="refresh" content="0;URL=approve.php?a=deleted&page='. $page .'" />';
		exit();
	break;
	case 'delvids':
		
		if ( ! csrfguard_check_referer('_admin_approve'))
		{
			$info_msg = '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
			break;
		}
		
		if($_POST['Submit'] == 'Delete checked')
		{
			$video_ids = array();
			$video_ids = $_POST['video_ids'];
			
			$total_ids = count($video_ids);
			if($total_ids > 0)
			{
				$in_arr = '';
				for($i = 0; $i < $total_ids; $i++)
				{
					$in_arr .= "'" . $video_ids[ $i ] . "', ";
				}
				$in_arr = substr($in_arr, 0, -2);
				if(strlen($in_arr) > 0)
				{
					$videos = array();
					$sql = "SELECT url, source_id, thumbnail FROM pm_temp WHERE id IN (". $in_arr .") AND source_id = '1'";
					$result = mysql_query($sql);
					
					while ($row = mysql_fetch_assoc($result))
					{
						$videos[] = $row;
					}
					mysql_free_result($result);
					
					$sql = "DELETE FROM pm_temp WHERE id IN (" . $in_arr . ")";
					$result = @mysql_query($sql);
					if(!$result)
						$info_msg = '<div class="alert alert-error">There was an error while updating your database.<br />MySQL returned: '.mysql_error().'</div>';
					else
						$info_msg = '<div class="alert alert-success">The selected videos were removed.</div>';
					
					if (count($videos) > 0)
					{
						foreach ($videos as $k => $video)
						{
							if (file_exists(_VIDEOS_DIR_PATH . $video['url']))
							{
								unlink(_VIDEOS_DIR_PATH . $video['url']);
							}
							if ($video['thumbnail'] != '')
							{
								unlink(_THUMBS_DIR_PATH . $video['thumbnail']);
							}
						}
					}
				}
			}
		}	
	break;
} //	end switch

// COUNT VIDEOS IN DB
$total_videos = count_entries('pm_temp', '', '');

if($total_videos - $from == 1)
	$page--;

$approve_nonce = csrfguard_raw('_admin_approve');

$videos = a_list_temp('', '', $from, $limit, $page); 

if($total_videos - $from == 1)
	$page++;

// generate smart pagination
$filename = ('' != $_SERVER['PHP_SELF']) ? basename($_SERVER['PHP_SELF']) : 'approve.php';
$pagination = '';

$pagination = a_generate_smart_pagination($page, $total_videos, $limit, 1, $filename, '');

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
            <p>In case you allow video suggestions or video uploads to your site, here is the place they will be awaiting your approval. This process requires human intervention to prevent any abuse or ill-intended attempts.
            You can preview each submitted videos by clicking the play button from the thumbnail image.</p>
            <p>Approve any satisfactory submissions by clicking on the &quot;check&quot; icon from the &quot;Actions&quot; column. The video will be published as submitted by the user but you can choose to modify it after approval.</p>
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
                <div class="floatL"><strong class="blue"><?php echo pm_number_format($total_videos); ?></strong><span>videos</span></div>
                <div class="blueImg"><img src="img/ico-videos-new.png" width="18" height="18" alt="" /></div>
            </li>
        </ul><!-- .pageControls -->
    </div>
	<h2>Videos Pending Approval</h2>
<?php echo $info_msg; ?>


<div class="row-fluid">
<div class="span8">
</div><!-- .span8 -->
<div class="span4">
  <form name="videos_per_page" action="approve.php" method="get" class="form-inline pull-right">
  	<input type="hidden" name="page" value="1" />
  	<label><small>Videos/page</small></label>
    <select name="results" class="smaller-select" onChange="this.form.submit()" >
	<option value="10" <?php if($limit == 10) echo 'selected="selected"'; ?>>10</option>
	<option value="20" <?php if($limit == 20) echo 'selected="selected"'; ?>>20</option>
	<option value="50" <?php if($limit == 50) echo 'selected="selected"'; ?>>50</option>
	<option value="70" <?php if($limit == 70) echo 'selected="selected"'; ?>>70</option>
	<option value="100" <?php if($limit == 100) echo 'selected="selected"'; ?>>100</option>
    </select>
  </form>
</div>
</div>

<div class="tablename">
<h6><?php if (!empty($filter)) { ?><button type="button" id="" class="btn btn-link btn-mini btn-danger" onClick="parent.location='videos.php'">Remove filter</button><?php } ?><?php if (!empty($_POST['keywords'])) { ?>SEARCH RESULTS FOR "<em><?php echo $_POST['keywords']; ?></em>"<?php } ?></h6>
    <div class="pull-right">
    <button type="button" class="btn btn-link btn-options" data-toggle="button" id="showfilter"><img src="img/ico-options.gif" width="30" height="18" /></button>
    </div>
</div>

<div class="tablename tablenameLight2" id="showfilter-content">
<div class="row-fluid">
<div class="span12">

<div class="qsFilter pull-right">
<div class="btn-group">
  <div class="form-filter-inline">
  <a href="#" class="btn btn-danger border-radius0" rel="tooltip" title="Remove ALL (<?php echo $total_videos; ?>) pending videos." onClick="del_alltemp()">Delete all</a>
  </div>
</div>
</div>

</div>
</div>
</div>

<form name="approve_videos_checkboxes" action="approve.php?page=<?php echo $page;?>" method="post">

<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered pm-tables tablesorter">
 <thead>
  <tr> 
	<th align="center" style="text-align:center" width="20"><input type="checkbox" class="checkbox" name="checkall" onclick="checkUncheckAll(this);"/></th>
	<th width="15">&nbsp;</th>
    <th width="40%">Title &amp; Description</th>
	<th>Tags</th>
    <th>Submitted on</th>
	<th width="5%">Submitted by</th>
    <th>Category</th>
    <th align="center" style="text-align:center; width: 90px;">Action</th>
  </tr>
 </thead>
 <tbody>
	<?php echo $videos; ?>
    <tr><td colspan="8" class="tableFooter"><div class="pagination pull-right"><?php echo $pagination; ?></div></td></tr>
 </tbody>
</table>

    <div class="clearfix"></div>
    
    <div id="stack-controls" class="list-controls">
    <div class="pull-left">
    </div>
    <button type="submit" name="Submit" value="Delete checked" class="btn btn-small btn-danger">Delete checked</button>
	<input type="hidden" name="_pmnonce" id="_pmnonce<?php echo $approve_nonce['_pmnonce'];?>" value="<?php echo $approve_nonce['_pmnonce'];?>" />
	<input type="hidden" name="_pmnonce_t" id="_pmnonce_t<?php echo $approve_nonce['_pmnonce'];?>" value="<?php echo $approve_nonce['_pmnonce_t'];?>" />
    </div><!-- #list-controls -->

</form>

    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>