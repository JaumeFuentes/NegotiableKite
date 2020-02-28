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

function manage_ad_form($action = 'addnew', $id = 0, $position = '', $code = '', $active = 0)
{
	$target = '';
	switch($action)
	{
		case 'addnew':
			$target = 'ad_manager.php?act=addnew';
		break;
		case 'edit':
			$target = ($id != 0) ? 'ad_manager.php?act=edit&id='.$id : 'ad_manager.php?act=edit';
		break;
	}
	// generate form
	$form	=	'<form name="ad_manager" method="post" action="'.$target.'">';
	$form  .= '
	<table width="100%" border="0" cellpadding="4">
	  <tr>
		<td class="fieldtitle" width="10%">Name:</td>
		<td><input type="text" name="position" value="'.$position.'" size="40" /></td>
	  </tr>
	  <tr>
		<td class="fieldtitle" width="10%">Description:</td>
		<td><input type="text" name="description" value="'.$description.'" size="40" /></td>
	  </tr>
	  <tr>
		<td class="fieldtitle" valign="top">HTML Code:</td>
		<td><textarea name="code" cols="60" rows="7">'.$code.'</textarea></td>
	  </tr>
	  <tr>
		<td class="fieldtitle">Status</td>
		<td><label><input name="active" type="radio" value="0" />Inactive</label> <label><input name="active" type="radio" value="1" checked="checked"/> Active</label></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="Submit" value="Submit" class="btn btn-success" /></td>
	  </tr>
	</table>
	';	
	return $form;
}


$action = $_GET['act'];

$total_ads = count_entries('pm_ads', '', '');

?>
<!-- create new ad zone form modal -->
<div class="modal hide fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Create new ad zone</h3>
    </div>
    <form name="ad_manager" method="post" action="ad_manager.php?act=addnew">
        <div class="modal-body">
            <label>Name</label>
            <input type="text" name="position" value="" size="40" />
            
			<label>Description</label>
            <input type="text" name="description" value="" size="40" />
            
			<label>HTML Code for your Ad</label>
            <textarea name="code" cols="60" rows="7" class="span5"></textarea>
        </div>
        <div class="modal-footer">
        <input type="hidden" name="active" value="1" />
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
            <li><a href="#help-onthispage" data-toggle="tab">TPL Code</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="help-overview">
    		<p>The build-in ad manager allows you to define ads zones and assign advertisements within those ad zones.<br />An ad zone is an area on your site where you intend to place advertisements (e.g. header, under the video, registration page, under article, etc.). Once an ad zone is created all you have to do is insert the ad code. By using ad zones you can easily replace obsolete or low performing ads.</p>
            </div>
            <div class="tab-pane fade" id="help-onthispage">
			<p>The TPL code is the assigned variable you need to use in your current template. There are several presets that come with every installation of PHP Melody, as listed below.<br />In this case, no template modifications are required. Just paste in your ad code and you're ready to go.</p>
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
	<h2>Ads Manager</h2>
        
<?php

switch($action)
{
	case 'addnew':
		if($_GET['act'] == 'addnew')
		{
			if(isset($_POST['Submit']))
			{
				$arr_fields = array('position' => "Name", 'code' => "Code", 'active' => 'Status');
				$errors = '';
				foreach($_POST as $k => $v)
				{
					if(trim($v) == '' && array_key_exists($k, $arr_fields) === TRUE)
							$errors .= "<li>The '".$arr_fields[$k]."' field shouldn't be empty</li>";	
					//$_POST[$k] = str_replace('"', "", $v);
				}
				if($errors != '')
				{
					echo "<div class=\"alert alert-error\"><ul>".$errors."</ul></div>";
					echo manage_ad_form('addnew', 0, $_POST['position'], $_POST['code'], $_POST['active']);
				}
				else
				{
					$position = secure_sql($_POST['position']);
					$code = secure_sql($_POST['code']);
					$description = secure_sql($_POST['description']);
					$active = ($_POST['active'] == 1) ? 1 : 0;
					
					$query = mysql_query("INSERT INTO pm_ads SET position = '".$position."', description = '".$description."', code = '".$code."', active = '".$active."'");
					if(!$query)
						echo "<div class=\"alert alert-error\">There was a problem while inserting the new ad in your database<br />
							  <strong>MySQL returned:</strong> ".mysql_error()."</div>";
					else
					{
						$new_ad_id = mysql_insert_id();
						$msg = '<div class="alert alert-success">
						<h4>Done!</h4>
						<p>Your ad zone has been created. Since this is a new <strong>ad zone</strong>, you have manually add this ad zone to the desired location within the template.</p>
						<ol>
						<li>Pick the location for this new ad zone (e.g. header.tpl, index.tpl, footer.tpl)</li>
						<li>Paste the following code wherever you wish to display ads associate with this ad zone: <strong>{$ad_'.$new_ad_id.'}</strong></li>
						</ol>';
						if($_POST['active'] == 0)
							$msg .= "<br /><small>P.S. Don't forget to activate it.</small>";
						$msg .= '</div>';
						$msg .= '<input name="continue" type="button" value="&larr; Return to Ad Manager" onClick="location.href=\'ad_manager.php\'" class="btn" />';
						
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
			echo "<div class=\"alert alert-error\">ID is not a valid value or it is missing</div>";
		
		else
		{
			if(isset($_POST['Submit']))
			{
				$arr_fields = array('position' => "Name");
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
					echo manage_ad_form('edit', $id, $_POST['position'], $_POST['description'], $_POST['code'], $_POST['active']);
					echo "</div>";
					include('footer.php');
					exit();
				}
				$position = secure_sql($_POST['position']);
				$code = secure_sql($_POST['code']);
				$description = secure_sql($_POST['description']);
				$active = ($_POST['active'] == 1) ? 1 : 0;
				
				$query = mysql_query("UPDATE pm_ads SET position = '".$position."',
														description = '".$description."',
														code = '".$code."',
														active = '".$active."'
													WHERE id='".$id."'");
				if ( ! $query)
				{
					echo "<div class=\"alert alert-error\">There was a problem while inserting this new ad in your database<br />
						  <strong>MySQL returned:</strong> ".mysql_error()."</div>";
				}
				else
				{
					echo "<div class=\"alert alert-success\">The ad zone was updated!</a></div>";
					echo '<input name="continue" type="button" value="&larr; Return to Ad Manager page" onClick="location.href=\'ad_manager.php\'" class="btn" />';
				}
					
			}
			else
			{
				$query = mysql_query("SELECT * FROM pm_ads WHERE id='".$id."'");
				if(!$query)
				{
					echo "<div class=\"alert alert-error\">There was a problem getting data from your database<br />
							  <strong>MySQL returned:</strong> ".mysql_error()."</div>";
					echo "</div>";
					include('footer.php');
					exit();
				}
				
				$ad = mysql_fetch_assoc($query);
				if($ad['id'] == '')
					echo "<div class=\"alert alert-error\">The selected as was not found in your database. Maybe the database is corrupted.</div>";
				else
					echo manage_ad_form('edit', $ad['id'], $ad['position'], $ad['description'], $ad['code'], $ad['active']);
			}
		}
	
	break;
	
	case 'delete':
	case 'activate':
	case 'deactivate':
	case '':
	default:
	
		$total_ads = count_entries('pm_ads', '', '');

		if($action == 'delete')
		{
			$id = $_GET['id'];
			if($id <= 0 || !is_numeric($id) || $id == '')
				echo "<div class=\"alert alert-error\">Invalid or missing ID</div>";
			elseif(in_array($id, array(1, 2, 3, 4, 5)) !== FALSE)
			{
				echo "<div class=\"alert alert-error\">Sorry, the default ad spots cannot be removed. You can choose to disable them or create new ad zones.</div>";
			}
			else
			{
				$query = mysql_query("DELETE FROM pm_ads WHERE id = '".$id."'");
				if( !$query )
					echo "<div class=\"alert alert-error\">There was a problem while deleting this ad zone.<br /><strong>MySQL returned:</strong> ".mysql_error()."</div>";
				else
					echo "<div class=\"alert alert-success\">The ad zone was deleted.</div>";
			}
		}
		if($action == 'activate' || $action == 'deactivate')
		{
			$id = $_GET['id'];
			if($id <= 0 || !is_numeric($id) || $id == '')
				echo "<div class=\"alert alert-error\">Invalid or missing ID</div>";
			else
			{	
				$sql = '';
				if($action == "activate")
					$sql = "UPDATE pm_ads SET active='1' WHERE id = '".$id."' LIMIT 1";
				else
					$sql = "UPDATE pm_ads SET active='0' WHERE id = '".$id."' LIMIT 1";
				
				$query = mysql_query($sql);
				if( !$query )
					echo "<div class=\"alert alert-error\">A problem was encountered while activating/deactivating this ad zone.<br /><strong>MySQL returned:</strong> ".mysql_error()."</div>";
				else
				{
					if($action == "activate")
						echo "<div class=\"alert alert-success\">The ad zone is now active.</div>";
					else
						echo "<div class=\"alert alert-success\">The ad zone was deactivated.</div>";
				}
			}
		}
	?>


<div class="tablename">
<h6></h6>
<div class="qsFilter move-right pull-right">
<div class="btn-group input-prepend">
<?php if($action != 'addnew' && $action != 'edit') { ?>
<a href="#addNew" class="btn btn-small btn-success" data-toggle="modal">Create new ad zone</a>
<?php } ?>
</div><!-- .btn-group -->
</div><!-- .qsFilter -->
</div>
<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered pm-tables tablesorter">
 <thead> 
  <tr>
    <th>Name</th>
	<th align="center" style="text-align:center" width="10%">TPL Code</th>
    <th align="center" style="text-align:center" width="15%">Status</th>
	<th align="center" style="text-align:center; width: 180px;">Action</th>
  </tr>	
 </thead>
 <tbody>
  <?php
	 
	// display all ads
	$query = mysql_query("SELECT * FROM pm_ads ORDER BY id DESC");
	$display = '';
	$i = 0;
	while($row = mysql_fetch_assoc($query))
	{	
		$clean_title = str_replace(array('"', "'"), array('', "\'"), $row['position']);
		$col = ($i++ % 2) ? 'table_row1' : 'table_row2';
		$display = '';
		$display .= '<tr class="'.$col.'">';
		$display .= '<td><strong>'.$row['position'].'</strong> <br /><em><small>'.$row['description'].'</small></em></td>';
		$display .= '<td align="center" style="text-align:center">{$ad_'.$row['id'].'}</td>';
		$display .= '<td align="center" style="text-align:center"><small>';
		$display .= ($row['active'] == 1) ? "<span class=\"label label-success\">Active</span>" : "<span class=\"label\">Inactive</span>";
		$display .= '</small></td>';
		$display .= '<td align="center" class="table-col-action" style="text-align:center">';
			$display .= ($row['active'] == 0) ? ' <a href="ad_manager.php?act=activate&id='.$row['id'].'" class="btn btn-mini btn-link" rel="tooltip" title="Activate Ad"><i class="icon-ok-sign"></i></a>' : ' <a href="ad_manager.php?act=deactivate&id='.$row['id'].'" class="btn btn-mini btn-link" rel="tooltip" title="Deactivate Ad"><i class="icon-remove-sign"></i></a>';
			$display .= '<a href="#" class="adzone_update_'. $row['id'] .' btn btn-mini btn-link" title="Edit"><i class="icon-pencil"></i> </a> <a href="#" onClick="delete_ad(\''. $clean_title .'\', \'ad_manager.php?act=delete&id='.$row['id'].'\')" class="btn btn-mini btn-link" rel="tooltip" title="Delete"><i class="icon-remove" ></i> </a>';
		$display .= '</td>';
		$display .= '</tr>';
		$display .= '<tr><td colspan="5" style="margin:0;padding:0;"><div id="adzone_update_'. $row['id'] .'" name="'. $row['id'] .'">';
		//$display .= '<span>'.$row['code'].'</span>';
		
		$display .= '<div class="adzone_update_form" style="padding: 10px; margin: 10px;">';
		$display .=	'<form name="adzone_update_'. $row['id'] .'" method="post" action="ad_manager.php?act=edit&id='.$row['id'].'">';
		$display .= '
		  <label>Name</label>
		  <input type="text" name="position" value="'.$row['position'].'" size="40" />
		  <label>Description</label>
		  <input type="text" name="description" value="'.$row['description'].'" size="40" />
		  <label>HTML Code</label>
		  <textarea name="code" cols="60" rows="4" style="width: 95%;" >'.$row['code'].'</textarea>
		  <input type="hidden" name="active" value="'.$row['active'].'" />
		  <input type="submit" name="Submit" value="Submit" class="btn btn-mini btn-success border-radius0" />
		  <a href="#" id="adzone_update_'. $row['id'] .'" class="btn-mini">Cancel</a>';
		$display .= '</form>';
		$display .= '</div>';
		$display .= '</div>';
		$display .= '</td></tr>';

		echo $display;
	}
	mysql_free_result($query);
	break;
}

?>
 </tbody>
</table>
</div>	<!-- end div id="content" -->
<?php
include('footer.php');
?>