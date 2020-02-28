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

$showm = '1';
include('header.php');
include_once('syndicate_news.php');
?>
<?php if(file_exists("db_update.php")) { ?>
<div class="dbupdate-bar">
<strong>Important: <a href="db_update.php" target="_blank">Click here</a> to finalize the update process.</strong>
</div>
<?php } ?>

<div id="adminPrimary">
    <div class="row-fluid" id="help-assist">
        <div class="span12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#help-overview" data-toggle="tab">Overview</a></li>
            <li><a href="#help-onthispage" data-toggle="tab">Navigation</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="help-overview">
    		<p></p>
            <p>Welcome to your dashboard! This page contains a quick overview of your excellent video site.</p>
            <p>A brief glance at the <strong>Quick Stats</strong> panel below will reveal all the important numbers. Actions requiring your attention will appear in dark orange, while critical items will appear in red. Such actions include comments and/or videos awaiting approval, reported videos, etc..</p>
            <p>The <strong>Quick Stats</strong> blocks of information are also clickable and act as shortcuts to the various areas of this administration panel.</p>
            <p>The <strong>Updates</strong> section is will keep you informed about critical PHP MELODY updates as well as current developments. New notifications will appear highlighted and they will stay so for 14 days.</p>
            </div>
            <div class="tab-pane fade" id="help-onthispage">
<p>The right hand top corner acts as a shortcuts area as well as an information center. Regardless of the page you're browsing, you'll always be able to see items which require your immediate attention. These notifications will appear as an item in your personal menu.</p>
<p>Regardless of the page you're browsing the &quot;Add Video&quot; button allows you to post, search and upload videos with a single click. These three forms will appear in the &quot;Add Video&quot; window. The first form (Youtube Import) allows you to quickly search the Youtube API for any sort of video imaginable. It's by far the easiest and most efficient way to add content to your site. The second form (Direct Input) allows you to simply paste any video URL, both of local and remotely hosted videos from any of the 50+ supported sources (Vimeo, DailyMotion, etc.). The third form allows you to upload your latest creations.</p>
<p>The left hand side navigation is partitioned by content type: videos, articles, pages, categories, comments, users and so on. Each of these menu items is clickable and most contain submenus which will appear on hover. The left hand side navigation also displays a notification in the form of a small icon containing a number with a red background. Those numbers indicate the required actions demanding your attention. Such notifications will include reported videos, videos pending approval and so on.</p>
            </div>
          </div>
        </div> <!-- /tabbable -->
        </div><!-- .span12 -->
    </div><!-- /help-assist -->
    
    <div class="content">
	<a href="#" id="show-help-assist">Help</a>

    <h2>Quick Stats</h2>
	<div class="row-fluid">
    <ul class="qsData">
        <li>
            <a href="videos.php">
                <span class="number"><?php echo $config['total_videos']; ?></span>
                <span class="head">Video<?php echo ($config['total_videos'] == 1) ? '' : 's'; ?></span>
            </a>
        </li>
        <li>
            <a href="approve.php">
            	<?php
				$vapprv = count_entries('pm_temp', '', '');
				?>
				<span class="number <?php if($vapprv > 0) {?>qspending<?php } ?>"><?php echo $vapprv; ?></span>
                <span class="head <?php if($vapprv > 0) {?>qspending<?php } ?>">Pending Approval</span>
            </a>
        </li>
        <li>
            <a href="reports.php">
                <span class="number <?php if($crps > 0) {?>qsreported<?php } ?>"><?php echo $crps; ?></span>
                <span class="head <?php if($crps > 0) {?>qsreported<?php } ?>">Reported video<?php echo ($crps == 1) ? '' : 's';?></span>
            </a>
        </li>
        <li>
            <a href="comments.php">
                <span class="number"><?php echo $comments_count = count_entries('pm_comments', '', ''); ?></span>
                <span class="head">Comment<?php echo ($comments_count == 1) ? '' : 's';?></span>
            </a>
        </li>
        <li>
            <a href="comments.php">
				<span class="number <?php if($capprv > 0) {?>qspending<?php } ?>"><?php echo $capprv; ?></span>
                <span class="head <?php if($capprv > 0) {?>qspending<?php } ?>">New Comment<?php echo ($capprv == 1) ? '' : 's';?></span>
            </a>
        </li>
        <li>
            <a href="members.php">
                <span class="number"><?php echo $member_count = count_entries('pm_users', '', ''); ?></span>
                <span class="head">Member<?php echo ($member_count == 1) ? '' : 's';?></span>
            </a>
        </li>
<?php
if (_MOD_ARTICLE == 1)
{
?>
        <li>
            <a href="articles.php">
                <span class="number"><?php echo $config['total_articles']; ?></span>
                <span class="head">Article<?php echo ($config['total_articles'] == 1) ? '' : 's';?></span>
            </a>
        </li>
<?php
}
?>
        <li>
            <a href="pages.php">
                <span class="number"><?php echo $config['total_pages']; ?></span>
                <span class="head">Page<?php echo ($config['total_pages'] == 1) ? '' : 's';?></span>
            </a>
        </li>
    </ul>
	</div>
    
	<h2>Updates</h2>
    <ul class="morning-news border-radius3" id="morning-news">
    <?php echo cache_this('get_rss_news', 'home_news'); ?>
    </ul>

    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>