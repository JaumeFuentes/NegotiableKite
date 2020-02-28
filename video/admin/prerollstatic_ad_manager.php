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

$total_ads = count_entries('pm_preroll_ads', '', '');

?>

<!-- create new ad form modal -->
<div class="modal hide fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Create new pre-roll ad</h3>
    </div>
    <form name="ad_manager" method="post" action="prerollstatic_ad_manager.php?act=addnew">
        <div class="modal-body">
            <label>Name</label>
            <input type="text" name="name" value="" size="40" />
            
			<label>Duration (seconds)</label>
            <input type="text" name="duration" value="30" autocomplete="off" size="25" class="input-mini" />
            
			<label>Display to</label>
			<select name="user_group">
				<option value="0">All visitors</option>
				<option value="1">Logged-in users only</option>
				<option value="2">Visitors only</option>
			</select>
			
			<label>HTML Code for your Ad</label>
            <textarea name="code" cols="60" rows="7" class="span5"></textarea>
        </div>
        <div class="modal-footer">
        <input type="hidden" name="status" value="1" />
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button type="submit" name="Submit" value="Submit" class="btn btn-success" />Submit</button>
    </div>
    </form>
</div>

<div id="adminPrimary">
    <div class="row-fluid" id="help-assist">
        <div class="span12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#help-overview" data-toggle="tab">Overview</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="help-overview">
    		<p>Pre-roll static ads are ads which you can define to appear before the video player is loaded. These ads should work with any kind of video.</p>
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
	<h2>Pre-roll Static Ads Manager</h2>

<?php


if ($action != '' && $action != 'addnew')
{
	$id = (int) $_GET['id'];
			
	if ( ! $id)
	{
		?>
		<div class="alert alert-error">Invalid ad ID provided.</div>
		<?php
	}
}

switch($action)
{
	case 'addnew':
		if($_GET['act'] == 'addnew')
		{
			if(isset($_POST['Submit']))
			{
				$_POST['duration'] = abs((int) $_POST['duration']);
				// no need for too much form validation; all params have default values
				
				$result = create_preroll_ad($_POST);
				
				if ( ! $result)
				{
					?>
					<div class="alert alert-error">
						There was a problem while inserting the new ad in your database.
						<br />
						<strong>MySQL returned:</strong> <?php echo mysql_error();?>
					</div>
					<?php 
				}
				else
				{
					?>
					<div class="alert alert-success">
						Your ad has been created. 
					</div>
					<?php
				}
			}
		}
	break;
	
	case 'edit':
		
		if ($id)
		{
			if (isset($_POST['Submit']))
			{
				$ad_data = array('name' => trim($_POST['name']),
								 'duration' => abs((int) $_POST['duration']),
								 'user_group' => (int) $_POST['user_group'],
								 'code' => $_POST['code']
								);
				$result = update_preroll_ad($id, $ad_data);
				
				if ( ! $result)
				{
					?>
					<div class="alert alert-error">
						A problem was encountered while updating this ad.
						<br />
						<strong>MySQL returned:</strong> <?php echo mysql_error();?>
					</div>
					<?php
				}
				else
				{
					?>
					<div class="alert alert-success">The ad was updated.</a></div>
					<?php
				}
					
			}
		}
	
	break;
	
	case 'activate':
	case 'deactivate':
		
		if ($id)
		{	
			$sql = "UPDATE pm_preroll_ads 
					SET ";
			$sql .= ($action == "activate") ? " status='1' " : " status='0' ";
			$sql .= " WHERE id = '$id' ";
							
			if ( ! $result = mysql_query($sql))
			{
				?>
				<div class="alert alert-error">A problem was encountered while updating this ad.
					<br /> 
					<strong>MySQL returned:</strong> <?php echo mysql_error();?>
				</div>
				<?php
			}
			else
			{
				if ($action == "activate")
				{
					?>
					<div class="alert alert-success">The ad is now active.</div>
					<?php
				}
				else
				{
					?>
					<div class="alert alert-success">The ad was deactivated.</div>
					<?php
				}
			}
		}
		
	break;
	
	case 'delete':
	
		if ($id)
		{
			$result = delete_preroll_ad($id);
			if ( ! $result)
			{
				?>
				<div class="alert alert-error">A problem was encountered while updating this ad.
					<br /> 
					<strong>MySQL returned:</strong> <?php echo mysql_error();?>
				</div>
				<?php
			}
			else
			{
				?>
				<div class="alert alert-success">The ad was deleted.</div>
				<?php
			}
		}
		
	break;
}

if ($action != '')
{
	update_config('total_preroll_ads', count_entries('pm_preroll_ads', 'status', '1'));
}
?>


<div class="tablename">
<h6></h6>
<div class="qsFilter move-right pull-right">
<div class="btn-group input-prepend">
<a href="#addNew" class="btn btn-small btn-success" data-toggle="modal">Create new ad</a>
</div><!-- .btn-group -->
</div><!-- .qsFilter -->
</div>
<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered pm-tables tablesorter">
 <thead> 
  <tr>
    <th>Name</th>
	<th align="center" style="text-align:center" width="10%">Display duration</th>
    <th align="center" style="text-align:center" width="10%">Display to</th>
	<th align="center" style="text-align:center" width="10%">Impressions</th>
	<th align="center" style="text-align:center" width="15%">Status</th>
	<th align="center" style="text-align:center; width: 180px;">Action</th>
  </tr>	
 </thead>
 <tbody>
 	<?php
	
	$ads = array();
	
	if ($total_ads > 0 || ($total_ads == 0 && $action == 'addnew'))
	{
		$sql = "SELECT * FROM pm_preroll_ads 
				ORDER BY id DESC";
		$result = mysql_query($sql);
		while ($row = mysql_fetch_assoc($result))
		{
			$ads[] = $row;
		}
		mysql_free_result($result);
	}
	
	if (count($ads) > 0) : 
		foreach ($ads as $k => $ad) : 
	?>
		<tr>
			<td><?php echo $ad['name']; ?></td>
			<td align="center" style="text-align:center"><?php echo sec2min($ad['duration']);?></td>
		    <td align="center" style="text-align:center">
		    	<?php 
				switch($ad['user_group'])
				{
					case 0:
						echo 'All visitors'; 
					break;
					
					case 1:
						echo 'Logged-in users only';
					break;
					
					case 2:
						echo 'Visitors only';
					break;
				}
				?>
		    </td>
			<td align="center" style="text-align:center"><?php echo pm_number_format($ad['impressions']);?></td>
			<td align="center" style="text-align:center"><?php echo ($ad['status'] == 1) ? '<span class="label label-success">Active</span>' : '<span class="label">Inactive</span>';?></td>
			<td align="center" class="table-col-action" style="text-align:center;">
				<?php if ($ad['status'] == 0) : ?>
					<a href="prerollstatic_ad_manager.php?act=activate&id=<?php echo $ad['id'];?>" class="btn btn-mini btn-link" rel="tooltip" title="Activate Ad"><i class="icon-ok-sign"></i></a>
				<?php else : ?>
					<a href="prerollstatic_ad_manager.php?act=deactivate&id=<?php echo $ad['id'];?>" class="btn btn-mini btn-link" rel="tooltip" title="Deactivate Ad"><i class="icon-remove-sign"></i></a>
				<?php endif; ?>
				<a href="#" class="adzone_update_<?php echo $ad['id'];?> btn btn-mini btn-link" title="Edit"><i class="icon-pencil"></i></a> <a href="#" onClick="delete_ad('<?php echo str_replace(array('"', "'"), array('', "\'"), $ad['name']);?>', 'prerollstatic_ad_manager.php?act=delete&id=<?php echo $ad['id'];?>')" class="btn btn-mini btn-link" rel="tooltip" title="Delete"><i class="icon-remove" ></i> </a>
			</td>
		</tr>
		<tr>
			<td colspan="6" style="margin:0;padding:0;">
				<div id="adzone_update_<?php echo $ad['id'];?>">
					<div class="adzone_update_form" style="padding: 10px; margin: 10px;">
						<form name="adzone_update_<?php echo $ad['id'];?>" method="post" action="prerollstatic_ad_manager.php?act=edit&id=<?php echo $ad['id'];?>">
							<label>Name</label>
				            <input type="text" name="name" value="<?php echo htmlspecialchars($ad['name']);?>" size="40" />
				            
							<label>Duration (seconds)</label>
				            <input type="text" name="duration" value="<?php echo $ad['duration'];?>" autocomplete="off" size="25" class="input-mini" />
				            
							<label>Display to</label>
							<select name="user_group">
								<option value="0" <?php echo ($ad['user_group'] == 0) ? 'selected="selected"' : '';?>>All visitors</option>
								<option value="1" <?php echo ($ad['user_group'] == 1) ? 'selected="selected"' : '';?>>Logged-in users only</option>
								<option value="2" <?php echo ($ad['user_group'] == 2) ? 'selected="selected"' : '';?>>Visitors only</option>
							</select>
							
							<label>HTML Code for your Ad</label>
				            <textarea name="code" cols="60" rows="7" class="span5"><?php echo $ad['code'];?></textarea>
							
							<input type="submit" name="Submit" value="Submit" class="btn btn-mini btn-success border-radius0" />
							<a href="#" id="adzone_update_<?php echo $ad['id'];?>" class="btn-mini">Cancel</a>
						</form>
					</div>
				</div>
			</td>
		</tr>
	<?php 
		endforeach;
	else : ?>
	<tr>
		<td colspan="6">
			No pre-roll ads have been defined.
		</td>
	</tr>
	<?php endif;?>
 </tbody>
</table>
</div>	<!-- end div id="content" -->
<?php
include('footer.php');
?>