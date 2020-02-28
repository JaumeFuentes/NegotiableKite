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
if($action == 1) 
{ 
	// REMOVE VIDEO, COMMENTS, RATINGS AND REPORTS
	mysql_query("TRUNCATE TABLE pm_searches");
	$info_msg = '<div class="alert alert-success">The search history was cleared successfully.</div>';
}
?>
<div id="adminPrimary">
    <div class="content">
    <div class="entry-count">
        <ul class="pageControls">
            <li>
                <div class="floatL"><strong class="blue"><?php echo pm_number_format(count_entries('pm_searches', '', '')); ?></strong><span>searches</span></div>
                <div class="blueImg"><img src="img/ico-search-new.png" width="18" height="17" alt="" /></div>
            </li>
        </ul><!-- .pageControls -->
    </div>
	<h2>Search Log</h2>

	<?php echo $info_msg; ?>
    
    <div class="tablename">
    <h6></h6>
    <div class="qsFilter move-right">
    <div class="btn-group input-prepend">
    <a href="#" onClick="del_all_searches()" class="btn btn-small btn-danger">Clear history</a>
    </div><!-- .btn-group -->
    </div><!-- .qsFilter -->
    </div>
    <table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered pm-tables tablesorter">
     <thead>
      <tr> 
        <th width="40">Rank</th>
        <th>Search keywords</th>
        <th width="10%">Queries</th>
      </tr>
     </thead>
     <tbody>
        <?php echo a_list_searches('50'); ?>
     </tbody>
    </table>
    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>