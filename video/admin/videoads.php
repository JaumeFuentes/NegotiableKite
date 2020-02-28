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

$showm = '9';
include('header.php');

$action = $_GET['act'];
if( $action == '' || empty($action))
	$action = '';


function manage_ad_form($action = 'addnew', $id = 0, $name = '', $flv_url = '', $redirect_url = '', $redirect_type = '', $active = 0)
{
	$target = '';
	switch($action)
	{
		case 'addnew':
			$target = 'videoads.php?act=addnew';
		break;
		case 'edit':
			$target = ($id != 0) ? 'videoads.php?act=edit&id='.$id : 'videoads.php?act=edit';
		break;
	}
	// generate form
	$form	=	'<form name="videoad" method="post" action="'.$target.'">';
	$form  .= '
	<table width="100%" border="0" cellpadding="4">
	  <tr class="table_row1">
		<td class="fieldtitle" width="210px">Name:</td>
		<td><input type="text" name="name" value="'.$name.'" size="40" /></td>
	  </tr>
	  <tr  class="table_row1">
		<td class="fieldtitle" valign="top">Video URL<br /><small>Supported file types: <span style="color:#000">*.flv</span></small></td>
		<td><input type="text" name="flv_url" value="'.$flv_url.'" size="120" /></td>
	  </tr>
	  <tr  class="table_row1">
		<td class="fieldtitle" valign="top">Advertised URL</td>
		<td><input type="text" name="redirect_url" value="'.$redirect_url.'" size="120" /></td>
	  </tr>
	  <tr class="table_row1">
		<td class="fieldtitle" valign="top">Redirect Type</td>
		<td><label><input type="radio" name="redirect_type" value="0"';
			if($redirect_type == 0)
				$form .= ' checked ';
			$form .= ' /> Open <em>Advertised URL</em> in new window</label><br />';
			
		$form .= '<label><input type="radio" name="redirect_type" value="1"';
			if($redirect_type == 1)
				$form .= ' checked ';
			$form .= ' /> Open <em>Advertised URL</em> in the same window</label>';
	$form.= '</td>
	  </tr>
	  <tr  class="table_row1">
		<td class="fieldtitle">Status</td>
		<td><label><input name="status" type="radio" value="0" />Inactive</label> <label><input name="status" type="radio" value="1" checked/> Active</label></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="Submit" value="Submit" class="btn" /></td>
	  </tr>
	</table>
	';	
	return $form;
}
?>
<style>
label input {
  line-height: 1em;
  padding: 0;
  margin: 0;
  margin-left: 4px;
  line-height: 0;
  top: -3px;
  position: relative;
  font-weight: normal;
}
</style>
<div id="adminPrimary">
    <div class="row-fluid" id="help-assist">
        <div class="span12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#help-overview" data-toggle="tab">Overview</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="help-overview">
    		<p>Video ads are clickable pre-roll video ads that appear at specified intervals. To enable video ads, you need to provide a *.FLV video ad and use FlowPlayer as your default player. At this time the pre-roll ads only work with this player. </p>
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
	            <div class="floatL"><strong class="blue"><?php echo pm_number_format($total_ads); ?></strong><span>ad(s)</span></div>
	            <div class="blueImg"><img src="img/ico-ads-new.png" width="19" height="18" alt="" /></div>
	        </li>
	    </ul><!-- .pageControls -->
	</div>
	<h2>Pre-roll Video Ads Manager</h2>

<?php

switch($action)
{
	case 'addnew':
		if($_GET['act'] == 'addnew')
		{
			if(isset($_POST['Submit']))
			{
				
				$arr_fields = array('name' => "Name", 'flv_url' => "Video Ad location", 'redirect_url' => 'Advertised URL', 'status' => 'Status');
				$errors = '';
				foreach($_POST as $k => $v)
				{
					if(trim($v) == '' && array_key_exists($k, $arr_fields) === TRUE)
							$errors .= "<li>The '".$arr_fields[$k]."' field shouldn't be empty</li>";	
				}
				if($errors != '')
				{
					$info_msg = "<div class=\"alert alert-error\"><ul>".$errors."</ul></div><br />";
					echo manage_ad_form('addnew', 0, $_POST['name'], $_POST['flv_url'], $_POST['redirect_url'], $_POST['redirect_type'], $_POST['status']);
				}
				else
				{
					$status = ($_POST['status'] == 1) ? 1 : 0;
					$redirect_url = trim($_POST['redirect_url']);
					$name = trim($_POST['name']);
					$flv_url = trim($_POST['flv_url']);
					$redirect_type = trim($_POST['redirect_type']);
					$hash = md5( rand(0,123) . time() );
					
					if( !preg_match("/http:\/\//", $redirect_url) )
						$redirect_url = "http://".$redirect_url;
					if( !preg_match("/http:\/\//", $flv_url) )
						$flv_url = "http://".$flv_url;
					
					$sql = "INSERT INTO pm_videoads SET hash = '".$hash."',
														name = '".secure_sql($name)."', 
														flv_url = '".secure_sql($flv_url)."',
														redirect_url = '".secure_sql($redirect_url)."', 
														redirect_type = '".secure_sql($redirect_type)."',
														status = '".$status."'";
														
					
					$query = mysql_query($sql);
					if(!$query)
						$info_msg = "<div class=\"alert alert-error\">There was a problem while inserting new ad in database<br />
							  <strong>MySQL returned:</strong> ".mysql_error()."</div>";
					else
					{
						//$new_ad_id = mysql_insert_id();
						$msg = '<div class="alert alert-success">The video ad was successfully created.';
						if($status == 0)
							$msg .= "<br /><small>P.S. Don't forget to activate it.</small>";
						$msg .= '</div>';
						$msg .= '<input name="continue" type="button" value="&larr; Return to the Video Ad Manager" onClick="location.href=\'videoads.php\'" class="btn" />';
						
						echo $msg;
					}
				}
			}
			else
			{
				echo manage_ad_form('addnew');
			}
		}	
	break;
	
	case 'edit':
		$id = $_GET['id'];
		if($id <= 0 || !is_numeric($id) || $id == '')
			$info_msg = "<div class=\"alert alert-error\">Invalid or missing ID</div>";
		
		else
		{
			if(isset($_POST['Submit']))
			{
				$arr_fields = array('name' => "Name", 'flv_url' => "Video Ad location", 'redirect_url' => 'Advertised URL', 'status' => 'Status');
				$errors = '';
				foreach($_POST as $k => $v)
				{
					if(trim($v) == '' && array_key_exists($k, $arr_fields) === TRUE)
							$errors .= "<div class=\"alert alert-error\">The '".$arr_fields[$k]."' field shouldn't be empty</div>";	
					//$_POST[$k] = str_replace('"', "", $v);
				}				
				if($errors != '')
				{
					echo $errors."<br />";
					echo manage_ad_form('addnew', $id, $_POST['name'], $_POST['flv_url'], $_POST['redirect_url'], $_POST['redirect_type'], $_POST['status']);
					echo "</div>";
					include('footer.php');
					exit();
				}
				$status = ($_POST['status'] == 1) ? 1 : 0;
				$redirect_url = trim($_POST['redirect_url']);
				$name = trim($_POST['name']);
				$flv_url = trim($_POST['flv_url']);
				$redirect_type = trim($_POST['redirect_type']);
				
				if( !preg_match("/http:\/\//", $redirect_url) )
					$redirect_url = "http://".$redirect_url;					
				if( !preg_match("/http:\/\//", $flv_url) )
					$flv_url = "http://".$flv_url;
				
				$sql = "UPDATE pm_videoads SET name = '".secure_sql($name)."', 
												flv_url = '".secure_sql($flv_url)."',
												redirect_url = '".secure_sql($redirect_url)."', 
												redirect_type = '".secure_sql($redirect_type)."',
												status = '".$status."'
										 WHERE id = '".$id."' ";
				$query = mysql_query($sql);
				if(!$query)
				{
					$info_msg = "<div class=\"alert alert-error\">There was a problem while inserting new ad in database<br />
						  <strong>MySQL returned:</strong> ".mysql_error()."</div>";
				}
				else
				{
					$info_msg = "<div class=\"alert alert-success\">Updated successfully!</a></div>";
					echo "<div class=\"alert alert-success\">Updated successfully!</a></div>";
					echo '<input name="continue" type="button" value="&larr; Return to the Video Ad Manager" onClick="location.href=\'videoads.php\'" class="btn" />';
				}
			}
			else
			{
				$query = mysql_query("SELECT * FROM pm_videoads WHERE id='".$id."'");
				if(!$query)
				{
					$info_msg = "<div class=\"alert alert-error\">There was a problem with retrieving data from your database<br />
							  <strong>MySQL returned:</strong> ".mysql_error()."</div>";
					echo "</div>";
					include('footer.php');
					exit();
				}
				
				$ad = mysql_fetch_assoc($query);
				if($ad['id'] == '')
					$info_msg = "<div class=\"alert alert-error\">Cannot find this ad in your database.</div>";
				else
					echo manage_ad_form('edit', $ad['id'], $ad['name'], $ad['flv_url'], $ad['redirect_url'], $ad['redirect_type'], $ad['status']);
			}
		}
	
	break;
	case 'delete':
	case 'activate':
	case 'deactivate':
	case 'reset':
	default:
		
		$total_ads = count_entries('pm_videoads', '', '');
		
		if($action == 'delete')
		{
			$id = $_GET['id'];
			if($id <= 0 || !is_numeric($id) || $id == '')
				$info_msg = "<div class=\"alert alert-error\">Invalid or missing ID</div>";
			else
			{
				$query = mysql_query("DELETE FROM pm_videoads WHERE id = '".$id."'");
				if( !$query )
					$info_msg = "<div class=\"alert alert-error\">Sorry, we cannot delete this ad. <br /><strong>MySQL returned:</strong> ".mysql_error()."</div>";
				else
					$info_msg = "<div class=\"alert alert-success\">Deleted!</div>";
			}
		}
		if($action == 'activate' || $action == 'deactivate')
		{
			$id = $_GET['id'];
			if($id <= 0 || !is_numeric($id) || $id == '')
				$info_msg = "<div class=\"alert alert-error\">Invalid or missing ID</div>";
			else
			{	
				$sql = '';
				if($action == "activate")
					$sql = "UPDATE pm_videoads SET status='1' WHERE id = '".$id."' LIMIT 1";
				else
					$sql = "UPDATE pm_videoads SET status='0' WHERE id = '".$id."' LIMIT 1";
				
				$query = mysql_query($sql);
				if( !$query )
					$info_msg = "<div class=\"alert alert-error\">There was a problem while activating/deactivating your ad<br /><strong>MySQL returned:</strong> ".mysql_error()."</div>";
				else
				{
					if($action == "activate")
						$info_msg = "<div class=\"alert alert-success\">The ad is now active.</div>";
					else
						$info_msg = "<div class=\"alert alert-success\">The ad was deactivated.</div>";
				}
			}
		}
		if($action == 'reset')
		{
			$id = $_GET['id'];
			if($id <= 0 || !is_numeric($id) || $id == '')
				$info_msg = "<div class=\"alert alert-error\">Invalid or missing ID</div>";
			else
			{
				$sql = "UPDATE pm_videoads SET impressions='0', clicks='0' WHERE id='".$id."'";
				$query = mysql_query($sql);
				if( !$query )
					$info_msg = "<div class=\"alert alert-error\">Something went wrong.<br /><strong>MySQL returned:</strong> ".mysql_error()."</div>";
			}
		}
	?>

<?php
if ($config['video_player'] == 'jwplayer')
{
?>
<div class="alert alert-error">
Sorry, this feature is not compatible with the 'JW FLV Player' at this time. Use Flowplayer to enable video ads.
</div>
<?php } ?>

<?php echo $info_msg; ?>


<div class="modal hide fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
<h3 id="myModalLabel">Create a new video ad</h3>
</div>
<form name="ad_manager" method="post" action="videoads.php?act=addnew">
<div class="modal-body">
<label>Name</label>
<input type="text" name="name" value="" size="40" />

<label>Video Ad URL <a href="#" rel="tooltip" title="Supported file types: *.flv"><i class="icon-info-sign"></i></a></label>
<input type="text" name="flv_url" value="" size="120" placeholder="http://" />

<label>Advertised URL</label>
<input type="text" name="redirect_url" value="" size="120" placeholder="http://" />

<input type="hidden" name="redirect_type" value="1" />
<input type="hidden" name="active" value="1" />
</div>

<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
<button type="submit" name="Submit" value="Submit" class="btn btn-success" />Submit</button>
</div>
</form>
</div>


<div class="tablename">
<h6></h6>
<div class="qsFilter move-right pull-right">
<div class="btn-group input-prepend">
<?php if($action != 'addnew' && $action != 'edit') { ?>
<a href="#addNew" class="btn btn-small btn-success" data-toggle="modal">Create a new video ad</a>
<?php } ?>
</div><!-- .btn-group -->
</div><!-- .qsFilter -->
</div>    
<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered pm-tables tablesorter">
 <thead> 
  <tr>
    <th>Name</th>
	<th width="8%">Impressions</th>
	<th width="7%">Clicks</th>
	<th width="7%">CTR</th>
    <th width="10%">Status</th>
	<th width="23%" style="width: 180px;">Action</th>
  </tr>
 </thead>
 <tbody>
 
  <?php
	
	// display all ads
	$query = mysql_query("SELECT * FROM pm_videoads ORDER BY id ASC");
	$display = '';
	$i = 0;
	while($row = mysql_fetch_assoc($query))
	{	
		$clean_title = str_replace(array('"', "'"), array('', "\'"), $row['name']);
		$col = ($i++ % 2) ? 'table_row1' : 'table_row2';
		$display = '';
		$display .= '<tr class="'.$col.'">';
		$display .= '<td>'.$row['name'].'</td>';
		$display .= '<td align="center" style="text-align:center">'.$row['impressions'].'</td>';
		$display .= '<td align="center" style="text-align:center">'.$row['clicks'].'</td>';
		$display .= '<td align="center" style="text-align:center">';
			$display .= "<strong>";
			if($row['clicks'] == 0 && $row['impressions'] == 0)
			{
				$display .= '0';
			}
			else
			{
				$display .= round( ($row['clicks']*100/$row['impressions']), 2);
			}
		$display .='%</strong></td>';
		$display .= '<td align="center" style="text-align:center" class="table-col-action">';
			$display .= "<small>";
			$display .= ($row['status'] == 1) ? "<span class=\"label label-success\">Active</span>" : "<span class=\"label\">Inactive</span>";
			$display .= "</small>";
		$display .= '</td>';
		$display .= '<td align="center" class="table-col-action" style="text-align:center">';
			$display .= ($row['status'] == 0) ? ' <a href="videoads.php?act=activate&id='.$row['id'].'" class="btn btn-mini btn-link" rel="tooltip" title="Activate Ad"><i class="icon-ok-sign"></i></a>' : ' <a href="videoads.php?act=deactivate&id='.$row['id'].'" class="btn btn-mini btn-link" rel="tooltip" title="Deactivate Ad"><i class="icon-remove-sign"></i></a>';
			$display .= ' <a href="videoads.php?act=reset&id='.$row['id'].'"  class="btn btn-mini btn-link" rel="tooltip" title="Reset CTR"><i class="icon-minus-sign"></i></a>';
			$display .= '<a href="#" class="adzone_update_'. $row['id'] .' btn btn-mini btn-link" rel="tooltip" title="Edit"><i class="icon-pencil"></i> </a> <a href="#" onClick="delete_ad(\''. $clean_title .'\', \'videoads.php?act=delete&id='.$row['id'].'\')" class="btn btn-mini btn-link" rel="tooltip" title="Delete"><i class="icon-remove" ></i> </a>';
		$display .= '</td>';
		$display .= '</tr>';

		$display .= '<tr><td colspan="6" style="margin:0;padding:0;"><div id="adzone_update_'. $row['id'] .'" name="'. $row['id'] .'">';

		//$display .= '<span class="adzone_update_hover">'. $row['code'] .'</span>'; 
		$display .= '<div class="adzone_update_form" style="padding: 10px; margin: 10px;">'; 
		$display .=	'<form name="adzone_update_'. $row['id'] .'" method="post" action="videoads.php?act=edit&id='.$row['id'].'">';
		$display .= '
					<label>Name</label>
					<input type="text" name="name" value="'.$row['name'].'" size="40" />
					<label>Video Ad URL</label>
					<input type="text" name="flv_url" value="'.$row['flv_url'].'" size="40" />
					<label>Advertised URL</label>
					<input type="text" name="redirect_url" value="'.$row['redirect_url'].'" size="40" />
					
					<label>Redirect Type</label>';
		  
		$display .= '<label><input type="radio" name="redirect_type" value="0"';
			if($row['redirect_type'] == 0)
				$display .= ' checked ';
			$display .= ' /> <small>Open <em>Advertised URL</em> in new window</small></label>';
			
		$display .= '<label><input type="radio" name="redirect_type" value="1"';
			if($row['redirect_type'] == 1)
				$display .= ' checked ';
			$display .= ' /> <small>Open <em>Advertised URL</em> in the same window</small></label>
				  <input type="submit" name="Submit" value="Submit" class="btn btn-mini btn-success border-radius0" />
				  <a href="#" id="adzone_update_'. $row['id'] .'" class="btn-mini">Cancel</a>';
		
		$display .= '<input type="hidden" name="status" value="'.$row['status'].'" />';
		$display .= '</form>';
		$display .= '</div>';
		$display .= '</div>';
		$display .= '</td></tr>';

		echo $display;
	}

	if($i == 0) {
		echo '<tr><td colspan="6">No video ads have been defined.</td></tr>';	
	}
	mysql_free_result($query);
	
	$total_active_ads = count_entries('pm_videoads', 'status', '1');
	update_config('total_videoads', $total_active_ads);
	
	break;
}

?>
 </tbody>
</table>
    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>