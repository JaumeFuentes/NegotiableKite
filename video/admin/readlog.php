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

$showm = '7';
include('header.php');

$action = (int) $_GET['a'];
if ($action == 1 && ! csrfguard_check_referer('_admin_readlog'))
{
	$info_msg = '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
}
else if(!empty($action) && $action == 1) 
{
	mysql_query("TRUNCATE TABLE pm_log");
	$info_msg = '<div class="alert alert-success">The entire log has been deleted</div>';
}

echo csrfguard_form('_admin_readlog');

?>
<div id="adminPrimary">
    <div class="content">
    <div class="entry-count">
        <ul class="pageControls">
            <li>
                <div class="floatL"><strong class="blue"><?php echo pm_number_format(count_entries('pm_log', '', '')); ?></strong><span>entries</span></div>
                <div class="blueImg"><img src="img/ico-settings-new.png" width="18" height="18" alt="" /></div>
            </li>
        </ul><!-- .pageControls -->
    </div>
    <h2>System Log</h2>
    
    <?php echo $info_msg; ?>
    
    <div class="tablename">
    <h6></h6>
    <div class="qsFilter move-right">
    <div class="btn-group input-prepend">
    <a href="#" class="btn btn-small btn-danger" onClick="del_err_log()">Delete all</a>
    </div><!-- .btn-group -->
    </div><!-- .qsFilter -->
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered pm-tables tablesorter">
     <thead>
      <tr> 
        <th width="15%">Occured on</th>
        <th>Details</th>
        <th width="10%">Area</th>
      </tr>
     </thead>
     <tbody>
        <?php echo a_list_log('70'); ?>
     </tbody>	
    </table>
    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>