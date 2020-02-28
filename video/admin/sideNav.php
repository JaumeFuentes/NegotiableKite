<div id="wrapper">
    <div id="adminSecondary" class="sideNav-bg">
    <div id="adminmenushadow"></div>
    <ul id="sideNav" role="navigation">
    
    <?php
    if (is_moderator() || is_editor())
    {
        // Index
		?>
        <li class="pm-menu <?php if($showm == '1') { echo 'active'; } ?>">
        <a href="index.php"><img src="img/ico-dash-new.png" width="26" height="25"> <span>Dashboard</span></a>
        </li>        
        <?php
		// Videos
		if ($mod_can['manage_videos']) 
		{
        ?>

        <li class="pm-menu has-subcats <?php if($showm == '2') { echo 'active'; } ?>">
        <a href="videos.php"><img src="img/ico-videos-new.png" width="26" height="25"> <span>Videos</span></a><?php if($tab_video_total > 0) {?><span class="pm-menu-count"><?php echo $tab_video_total; ?></span><?php } ?>
        <ul class="pm-sub-menu">
            <li><a href="addvideo.php">Add Video from URL</a></li>
            <li><a href="embedvideo.php">Embed video</a></li>
            <li><a href="streamvideo.php">Add video stream</a></li>
            <li><a href="import.php">Import from Youtube</a></li>
            <li><a href="import_user.php">Import from Youtube User</a></li>
            <li><a href="reports.php">Reported Videos</a><?php if($crps > 0) {?><span class="pm-submenu-count"><?php echo $crps; ?></span><?php } ?></li>
            <li><a href="approve.php">Approve Videos</a><?php if($vapprv > 0) {?><span class="pm-submenu-count"><?php echo $vapprv; ?></span><?php } ?></li>
            <?php $modframework->admin_submenu(2);?>
        </ul>
        </li>
        <?php
        }

        // Articles
        if ($mod_can['manage_articles'] || is_editor()) 
        {
        	if ( $config['mod_article'] == 1 ) 
			{
		?>
        <li class="pm-menu has-subcats <?php if($showm == 'mod_article') { echo 'active'; } ?>">
        <a href="articles.php"><img src="img/ico-articles-new.png" width="26" height="23"> <span>Articles</span></a>
        <ul class="pm-sub-menu">
        <li><a href="article_manager.php?do=new">Post a new article</a></li>
        <li><a href="articles.php">Manage articles</a></li>
        </ul>
        </li>
    	<?php 
			}
		}
		// Comments
		if ($mod_can['manage_comments'])
		{
		?>
        <li class="pm-menu has-subcats <?php if($showm == '4') { echo 'active'; } ?>">
        <a href="comments.php"><img src="img/ico-comments-new.png" width="24" height="22"> <span>Comments</span></a><?php if($tab_comments > 0) {?><span class="pm-menu-count"><?php echo $tab_comments; ?></span><?php } ?>
        <ul class="pm-sub-menu">
        <li><a href="comments.php?page=1&filter=videos">Video comments</a></li>
		<?php 
        if ( $config['mod_article'] == 1 ) {
        ?>
        <li><a href="comments.php?page=1&filter=articles">Article comments</a></li>
		<?php } ?>
        <li><a href="comments.php?filter=flagged&page=1">Flagged Comments</a><?php if($flagged_comments > 0) {?><span class="pm-submenu-count"><?php echo $flagged_comments; ?></span><?php } ?></li>
        <li><a href="comments.php?filter=pending&page=1">Pending Comments</a><?php if($pending_comments > 0) {?><span class="pm-submenu-count"><?php echo $pending_comments; ?></span><?php } ?></li>
        <li><a href="blacklist.php">Abuse Prevention</a></li>
        </ul>
        </li>
        <?php
        }
        // Users
        if ($mod_can['manage_users'])
        {
		?>
        <li class="pm-menu has-subcats <?php if($showm == '6') { echo 'active'; } ?>">
        <a href="members.php"><img src="img/ico-users-new.png" width="26" height="25"> <span>Users</span></a>
        <ul class="pm-sub-menu">
        <li><a href="add_user.php">Add New User</a></li>
		<li><a href="banlist.php">Banned Users</a></li>
		<?php if (_MOD_SOCIAL) : ?>
		<li><a href="activity-stream.php">Activity Stream</a></li>
		<?php endif;?>
        <?php $modframework->admin_submenu(6);?>
        </ul>
        </li>
        <?php
        }

    } // end  if (is_moderator() || is_editor())
    else
    {
    ?>
    
        <li class="pm-menu <?php if($showm == '1') { echo 'active'; } ?>">
        <a href="index.php"><img src="img/ico-dash-new.png" width="26" height="25"> <span>Dashboard</span></a>
        </li>
        <li class="pm-menu has-subcats <?php if($showm == '2') { echo 'active'; } ?>">
        <a href="videos.php"><img src="img/ico-videos-new.png" width="26" height="25"> <span>Videos</span></a><?php if($tab_video_total > 0) {?><span class="pm-menu-count"><?php echo $tab_video_total; ?></span><?php } ?>
        <ul class="pm-sub-menu">
            <li><a href="addvideo.php">Add Video from URL</a></li>
            <li><a href="streamvideo.php">Add video stream</a></li>
            <li><a href="import.php">Import from Youtube</a></li>
            <li><a href="import_user.php">Import from Youtube User</a></li>
            <li><a href="embedvideo.php">Embed video</a></li>
            <li><a href="reports.php">Reported Videos</a><?php if($crps > 0) {?><span class="pm-submenu-count"><?php echo $crps; ?></span><?php } ?></li>
            <li><a href="approve.php">Approve Videos</a><?php if($vapprv > 0) {?><span class="pm-submenu-count"><?php echo $vapprv; ?></span><?php } ?></li>
            <?php $modframework->admin_submenu(2);?>
        </ul>
        </li>
    	
        <?php if ( $config['mod_article'] == 1 ) { ?>
        <li class="pm-menu has-subcats <?php if($showm == 'mod_article') { echo 'active'; } ?>">
        <a href="articles.php"><img src="img/ico-articles-new.png" width="26" height="23"> <span>Articles</span></a>
        <ul class="pm-sub-menu">
        <li><a href="article_manager.php?do=new">Post a new article</a></li>
        <li><a href="articles.php">Manage articles</a></li>
        </ul>
        </li>
    	<?php } ?>

        <li class="pm-menu has-subcats <?php if($showm == 'mod_pages') { echo 'active'; } ?>">
        <a href="pages.php"><img src="img/ico-page-new.png" width="26" height="25"> <span>Pages</span></a>
        <ul class="pm-sub-menu">
        <li><a href="page_manager.php?do=new">Create new page</a></li>
        <li><a href="pages.php">Manage pages</a></li>
        </ul>
        </li>
    
        <li class="pm-menu has-subcats <?php if($showm == '3') { echo 'active'; } ?>">
        <a href="cat_manager.php"><img src="img/ico-cats-new.png" width="26" height="25"> <span>Categories</span></a>
        <ul class="pm-sub-menu">
        	<li><a href="cat_manager.php">Video categories</a></li>
            <?php if ( $config['mod_article'] == 1 ) { ?>
            <li><a href="article_categories.php">Article categories</a></li>
            <?php } ?>
        </ul>
        </li>

        <li class="pm-menu has-subcats <?php if($showm == '4') { echo 'active'; } ?>">
        <a href="comments.php"><img src="img/ico-comments-new.png" width="24" height="22"> <span>Comments</span></a><?php if($tab_comments > 0) {?><span class="pm-menu-count"><?php echo $tab_comments; ?></span><?php } ?>
        <ul class="pm-sub-menu">
        <li><a href="comments.php?page=1&filter=videos">Video comments</a></li>
		<?php 
        if ($config['mod_article'] == '1' && (is_admin() || (is_moderator() && mod_can('manage_comments')))) {
        ?>
        <li><a href="comments.php?page=1&filter=articles">Article comments</a></li>
		<?php } ?>
        <li><a href="comments.php?filter=flagged&page=1">Flagged Comments</a><?php if($flagged_comments > 0) {?><span class="pm-submenu-count"><?php echo $flagged_comments; ?></span><?php } ?></li>
        <li><a href="comments.php?filter=pending&page=1">Pending Comments</a><?php if($pending_comments > 0) {?><span class="pm-submenu-count"><?php echo $pending_comments; ?></span><?php } ?></li>
        <li><a href="blacklist.php">Abuse Prevention</a></li>
        </ul>
        </li>
    
        <li class="pm-menu has-subcats <?php if($showm == '6') { echo 'active'; } ?>">
        <a href="members.php"><img src="img/ico-users-new.png" width="26" height="25"> <span>Users</span></a>
        <ul class="pm-sub-menu">
        <li><a href="add_user.php">Add New User</a></li>
		<li><a href="banlist.php">Banned Users</a></li>
		<?php if (_MOD_SOCIAL) : ?>
		<li><a href="activity-stream.php">Activity Stream</a></li>
		<?php endif;?>
		<?php
		if (is_admin())
		{
		?>
		<li><a href="members_export.php" rel="tooltip" data-placement="right" title="A *.CSV file will be generated after clicking this link.">Export to CSV</a></li>
		<?php } ?>
        <?php $modframework->admin_submenu(6);?>
        </ul>
        </li>

        <li class="pm-menu has-subcats <?php if($showm == '9') { echo 'active'; } ?>">
        <a href="ad_manager.php"><img src="img/ico-ads-new.png" width="26" height="25"> <span>Advertisments</span></a>
        <ul class="pm-sub-menu">
        <li><a href="ad_manager.php">Ads Manager</a></li>
		<li><a href="prerollstatic_ad_manager.php">Pre-roll Static Ads</a>
        <li><a href="videoads.php">Pre-roll Video Ads</a></li>
        </ul>
        </li>
    
        <li class="pm-menu has-subcats <?php if($showm == '7') { echo 'active'; } ?>">
        <a href="statistics.php"><img src="img/ico-stats-new.png" width="26" height="25"> <span>Statistics &amp; Logs</span></a><?php if($tab_internallog > 0) {?><span class="pm-menu-count"><?php echo $tab_internallog; ?></span><?php } ?>
        <ul class="pm-sub-menu">
        <li><a href="show_searches.php">Search Log</a></li>
        <li><a href="readlog.php">System Log</a><?php if($tab_internallog > 0) {?><span class="pm-submenu-count"><?php echo $tab_internallog; ?></span><?php } ?></li>
        <li><a href="sys_phpinfo.php">PHP Configuration</a></li>
        </ul>
        </li>
            
        <li class="pm-menu has-subcats <?php if($showm == '8') { echo 'active'; } ?>">
        <a href="settings.php"><img src="img/ico-settings-new.png" width="26" height="25"> <span>Settings</span></a>
        <ul class="pm-sub-menu">
        <li><a href="settings_theme.php">Layout Settings</a></li>
        <li><a href="<?php echo csrfguard_url(_URL .'/admin/db_backup.php?restart=1', '_admin_backupdb');?>" rel="tooltip" data-placement="right" title="An *.SQL file will be generated after clicking this link.">Backup Database</a></li>
        <li><a href="sitemap.php" rel="tooltip" data-placement="right" title="Large sitemaps will take a while to generate.">Create Regular Sitemap</a></li>	
        <li><a href="video-sitemap.php">Create Video Sitemap</a></li>
        </ul>
        </li>
	<?php
	} // end #subNav
	?>
		<?php
        if (is_admin() ) {
		$modframework->show_admin_menu();
		$modframework->trigger_hook('admin_menu');
		}
		?>
        <li class="pm-menu-last"></li>
    
    </ul><!-- .sideNav -->
    </div><!-- #sideNav -->