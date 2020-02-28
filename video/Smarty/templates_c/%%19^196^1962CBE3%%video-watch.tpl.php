<?php /* Smarty version 2.6.20, created on 2013-03-24 22:12:54
         compiled from video-watch.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'echo_securimage_sid', 'video-watch.tpl', 126, false),)), $this); ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'header.tpl', 'smarty_include_vars' => array('p' => 'detail')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?> 
<div id="wrapper">
    <div class="container-fluid">
	<div class="row-fluid">
        <div class="span8">
		<div id="primary">
<div class="row-fluid">
	<div class="span12">
        <?php if ($this->_tpl_vars['logged_in'] && $this->_tpl_vars['is_admin'] == 'yes'): ?>
        <a href="<?php echo @_URL; ?>
/admin/modify.php?vid=<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
" rel="tooltip" class="btn btn-mini pull-right" title="<?php echo $this->_tpl_vars['lang']['edit']; ?>
 (<?php echo $this->_tpl_vars['lang']['_admin_only']; ?>
)" target="_blank"><?php echo $this->_tpl_vars['lang']['edit']; ?>
</a>
        <?php endif; ?>
        <h1 class="entry-title"><?php echo $this->_tpl_vars['video_data']['video_title']; ?>
</h1>
        <div class="row-fluid">
            <div class="span6">
            <?php if ($this->_tpl_vars['video_data']['featured'] == 1): ?>
                <span class="label label-featured"><?php echo $this->_tpl_vars['lang']['featured']; ?>
</span>
            <?php endif; ?>
            </div>
            <div class="span6">
            <div id="lights-div"><a class="lightOn" href="#"><?php echo $this->_tpl_vars['lang']['lights_off']; ?>
</a></div>
            </div>
        </div>
        <div class="pm-player-full-width">
	   	    <div id="video-wrapper">
            <?php if ($this->_tpl_vars['display_preroll_ad'] == true): ?>
            <div id="preroll_placeholder" class="border-radius4">
            <div class="preroll_countdown">
                        <?php echo $this->_tpl_vars['lang']['preroll_ads_timeleft']; ?>
 <span class="preroll_timeleft"><?php echo $this->_tpl_vars['preroll_ad_data']['timeleft_start']; ?>
</span>
            </div>
                        <?php echo $this->_tpl_vars['preroll_ad_data']['code']; ?>

            </div>
            <?php else: ?>
                        <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "player.tpl", 'smarty_include_vars' => array('page' => 'detail')));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            <?php endif; ?>
	        </div><!--#video-wrapper-->
            <div class="pm-video-control">
            <div class="row-fluid">
            <div class="span9">
            <small><?php echo $this->_tpl_vars['lang']['articles_published']; ?>
 <time datetime="<?php echo $this->_tpl_vars['video_data']['html5_datetime']; ?>
" title="<?php echo $this->_tpl_vars['video_data']['full_datetime']; ?>
"><?php echo $this->_tpl_vars['video_data']['time_since_added']; ?>
 <?php echo $this->_tpl_vars['lang']['ago']; ?>
</time> <?php echo $this->_tpl_vars['lang']['articles_by']; ?>
  <a href="<?php echo @_URL; ?>
/profile.<?php echo @_FEXT; ?>
?u=<?php echo $this->_tpl_vars['video_data']['author_username']; ?>
"><?php echo $this->_tpl_vars['video_data']['author_name']; ?>
</a> <?php echo $this->_tpl_vars['lang']['_in']; ?>
 <?php echo $this->_tpl_vars['category_name']; ?>
</small> 
            <div class="clearfix"></div>

            <button class="btn btn-small border-radius0 <?php if ($this->_tpl_vars['bin_rating_vote_value'] == 1): ?>active<?php endif; ?>" id="bin-rating-like" type="button"><i class="icon-thumbs-up"></i> <?php echo $this->_tpl_vars['lang']['_like']; ?>
</button>
            <button class="btn btn-small border-radius0 <?php if ($this->_tpl_vars['bin_rating_vote_value'] == 0 && $this->_tpl_vars['bin_rating_vote_value'] !== false): ?>active<?php endif; ?>" id="bin-rating-dislike" type="button"><i class="icon-thumbs-down"></i></button>
            <button class="btn btn-small border-radius0" type="button" data-toggle="button" id="pm-vc-share"><?php echo $this->_tpl_vars['lang']['_share']; ?>
</button>
            <input type="hidden" name="bin-rating-uniq_id" value="<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
">
            <?php if ($this->_tpl_vars['logged_in']): ?>
                
                <?php if ($this->_tpl_vars['isfavorite'] == '1'): ?>
                <!--<?php echo $this->_tpl_vars['lang']['dp_alt_1']; ?>
-->
                <form name="addtofavorites" id="addtofavorites" class="form-inline" action="">
                    <input type="hidden" value="<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
" name="fav_video_id">
                    <input type="hidden" value="<?php echo $this->_tpl_vars['s_user_id']; ?>
" name="fav_user_id">
                    <button class="btn btn-small border-radius0 active" id="fav_save_button" type="button"><?php echo $this->_tpl_vars['lang']['remove_from_fav']; ?>
</button>
                </form>
                <?php elseif (@_FAV_LIMIT == $this->_tpl_vars['countfavorites']): ?>
                 <a href="<?php echo @_URL; ?>
/favorites.php?a=show" class="btn btn-small border-radius0"><?php echo $this->_tpl_vars['lang']['dp_alt_2']; ?>
</a>
                <?php else: ?>
                <form name="addtofavorites" id="addtofavorites" class="form-inline" action="">
                    <input type="hidden" value="<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
" name="fav_video_id">
                    <input type="hidden" value="<?php echo $this->_tpl_vars['s_user_id']; ?>
" name="fav_user_id">
                    <button class="btn btn-small border-radius0" id="fav_save_button" type="button"><?php echo $this->_tpl_vars['lang']['add_to_fav']; ?>
</button>
                </form>
                <?php endif; ?>
            <?php else: ?>
              <!--<?php echo $this->_tpl_vars['lang']['dp_alt_1']; ?>
-->
            <?php endif; ?>
            <button class="btn btn-small border-radius0" type="button" data-toggle="button" id="pm-vc-report" title="<?php echo $this->_tpl_vars['lang']['report_video']; ?>
"><i class="icon-flag"></i></button>
            </div>
            
            <div class="span3">
            <span class="pm-vc-views">
			<strong><?php echo $this->_tpl_vars['video_data']['site_views_formatted']; ?>
</strong>
            <small><?php echo $this->_tpl_vars['lang']['views']; ?>
</small>
            </span>
            <div class="clearfix"></div>
            <div class="progress" title="<?php echo $this->_tpl_vars['video_data']['up_vote_count_formatted']; ?>
 <?php echo $this->_tpl_vars['lang']['_likes']; ?>
, <?php echo $this->_tpl_vars['video_data']['down_vote_count_formatted']; ?>
 <?php echo $this->_tpl_vars['lang']['_dislikes']; ?>
">
              <div class="bar bar-success" id="rating-bar-up-pct" style="width: <?php echo $this->_tpl_vars['video_data']['up_pct']; ?>
%;"></div>
              <div class="bar bar-danger" id="rating-bar-down-pct" style="width: <?php echo $this->_tpl_vars['video_data']['down_pct']; ?>
%;"></div>
            </div>
            </div>
            </div>
            </div>
            
		<div id="bin-rating-response" class="hide well well-small"></div>
		<div id="bin-rating-like-confirmation" class="hide well well-small alert alert-well">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
		<p><?php echo $this->_tpl_vars['lang']['confirm_like']; ?>
</p>
			<div class="row-fluid">
                <div class="span3 panel-1">
                <a href="http://www.facebook.com/sharer.php?u=<?php echo $this->_tpl_vars['facebook_like_href']; ?>
&amp;t=<?php echo $this->_tpl_vars['facebook_like_title']; ?>
" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on FaceBook"><img src="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/img/facebook-icon.jpg" alt=""></a>
                <a href="http://twitter.com/home?status=Watching%20<?php echo $this->_tpl_vars['facebook_like_title']; ?>
%20on%20<?php echo $this->_tpl_vars['facebook_like_href']; ?>
" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on Twitter"><img src="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/img/twitter-icon.jpg"  alt=""></a>
				<a href="https://plus.google.com/share?url=<?php echo $this->_tpl_vars['facebook_like_href']; ?>
" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on Google+"><img
  src="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/img/google-icon.jpg" alt=""></a>
                </div>
                <div class="span9 panel-3">
                <div class="input-prepend"><span class="add-on">URL</span><input name="share_video_link" id="share_video_link" type="text" value="<?php echo $this->_tpl_vars['video_data']['video_href']; ?>
" class="span11" onClick="SelectAll('share_video_link');"></div>
                </div>
            </div>
        </div>
		<div id="bin-rating-dislike-confirmation" class="hide-dislike hide well well-small">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p><?php echo $this->_tpl_vars['lang']['confirm_dislike']; ?>
</p>
        </div>


		<div id="pm-vc-report-content" class="hide well well-small alert alert-well">
			<div id="report-confirmation" class="hide"></div>
			<form name="reportvideo" action="" method="POST" class="form-inline">
			  <input type="hidden" id="name" name="name" class="input-small" value="<?php if ($this->_tpl_vars['logged_in']): ?><?php echo $this->_tpl_vars['s_name']; ?>
<?php endif; ?>">
			  <input type="hidden" id="email" name="email" class="input-small" value="<?php if ($this->_tpl_vars['logged_in']): ?><?php echo $this->_tpl_vars['s_email']; ?>
<?php endif; ?>">
			
			  <select name="reason" class="input-medium inp-small">
				<option value="<?php echo $this->_tpl_vars['lang']['report_form1']; ?>
" selected="selected"><?php echo $this->_tpl_vars['lang']['report_form1']; ?>
</option>
				<option value="<?php echo $this->_tpl_vars['lang']['report_form4']; ?>
"><?php echo $this->_tpl_vars['lang']['report_form4']; ?>
</option>
				<option value="<?php echo $this->_tpl_vars['lang']['report_form5']; ?>
"><?php echo $this->_tpl_vars['lang']['report_form5']; ?>
</option>
				<option value="<?php echo $this->_tpl_vars['lang']['report_form6']; ?>
"><?php echo $this->_tpl_vars['lang']['report_form6']; ?>
</option>
				<option value="<?php echo $this->_tpl_vars['lang']['report_form7']; ?>
"><?php echo $this->_tpl_vars['lang']['report_form7']; ?>
</option>
			  </select>
			  
			  <?php if (! $this->_tpl_vars['logged_in']): ?>
			  	<input type="text" name="imagetext" class="input-small inp-small" autocomplete="off" placeholder="<?php echo $this->_tpl_vars['lang']['confirm_comment']; ?>
">
			    <button class="btn btn-small btn-link" onclick="document.getElementById('securimage-report').src = '<?php echo @_URL; ?>
/include/securimage_show.php?sid=' + Math.random(); return false;"><i class="icon-refresh"></i> </button>
			    <img src="<?php echo @_URL; ?>
/include/securimage_show.php?sid=<?php echo smarty_echo_securimage_sid(array(), $this);?>
" id="securimage-report" alt="" class="border-radius3">
			  <?php endif; ?>
			  <button type="submit" name="Submit" class="btn btn-danger" value="<?php echo $this->_tpl_vars['lang']['submit_send']; ?>
"><?php echo $this->_tpl_vars['lang']['report_video']; ?>
</button>
			  <input type="hidden" name="p" value="detail">
			  <input type="hidden" name="do" value="report">
			  <input type="hidden" name="vid" value="<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
">
			</form>
		</div>

        <div id="pm-vc-share-content" class="alert alert-well">
			<div class="row-fluid">
                <div class="span4 panel-1">
                <div class="input-prepend"><span class="add-on">URL</span><input name="video_link" id="video_link" type="text" value="<?php echo $this->_tpl_vars['video_data']['video_href']; ?>
" class="input-medium" onClick="SelectAll('video_link');"></div>
                </div>
                <div class="span5 panel-2">
                <button class="btn border-radius0" type="button" id="pm-vc-embed"><?php echo $this->_tpl_vars['lang']['_embed']; ?>
</button>
                <button class="btn border-radius0" type="button" data-toggle="button" id="pm-vc-email"><i class="icon-envelope"></i> <?php echo $this->_tpl_vars['lang']['email_video']; ?>
</button>
                </div>
                <div class="span3 panel-3">
                <a href="http://www.facebook.com/sharer.php?u=<?php echo $this->_tpl_vars['facebook_like_href']; ?>
&amp;t=<?php echo $this->_tpl_vars['facebook_like_title']; ?>
" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on FaceBook"><img src="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/img/facebook-icon.jpg"></a>
                <a href="http://twitter.com/home?status=Watching%20<?php echo $this->_tpl_vars['facebook_like_title']; ?>
%20on%20<?php echo $this->_tpl_vars['facebook_like_href']; ?>
" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on Twitter"><img src="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/img/twitter-icon.jpg"></a>
				<a href="https://plus.google.com/share?url=<?php echo $this->_tpl_vars['facebook_like_href']; ?>
" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on Google+"><img
  src="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/img/google-icon.jpg" alt="" /></a>  
                </div>
            </div>

            <div id="pm-vc-embed-content">
              <hr />
    		  <textarea name="pm-embed-code" id="pm-embed-code" rows="3" class="span12" onClick="SelectAll('pm-embed-code');"><?php echo $this->_tpl_vars['embedcode_to_share']; ?>
</textarea>
        	</div>
            <div id="pm-vc-email-content">
              <hr />
		<div id="share-confirmation" class="hide well well-small"></div>
	            <form name="sharetofriend" action="" method="POST" class="form-inline">
	              <input type="text" id="name" name="name" class="input-small inp-small" value="<?php echo $this->_tpl_vars['s_name']; ?>
" placeholder="<?php echo $this->_tpl_vars['lang']['your_name']; ?>
">
	              <input type="text" id="email" name="email" class="input-small inp-small" placeholder="<?php echo $this->_tpl_vars['lang']['friends_email']; ?>
">
		          <?php if (! $this->_tpl_vars['logged_in']): ?>   
					  <input type="text" name="imagetext" class="input-small inp-small" autocomplete="off" placeholder="<?php echo $this->_tpl_vars['lang']['confirm_comment']; ?>
">
		              <button class="btn btn-small btn-link" onclick="document.getElementById('securimage-share').src = '<?php echo @_URL; ?>
/include/securimage_show.php?sid=' + Math.random(); return false;"><i class="icon-refresh"></i> </button>
					  <img src="<?php echo @_URL; ?>
/include/securimage_show.php?sid=<?php echo smarty_echo_securimage_sid(array(), $this);?>
" id="securimage-share" alt="">
				  <?php endif; ?>
				  <input type="hidden" name="p" value="detail">
				  <input type="hidden" name="do" value="share">
				  <input type="hidden" name="vid" value="<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
">
	              <button type="submit" name="Submit" class="btn btn-success"><?php echo $this->_tpl_vars['lang']['submit_send']; ?>
</button>
	            </form>
        	</div>
        </div>
        </div><!--end pm-player-full-width -->
	</div>
</div>

<?php if ($this->_tpl_vars['ad_3'] != ''): ?>
<div class="pm-ad-zone" align="center"><?php echo $this->_tpl_vars['ad_3']; ?>
</div>
<?php endif; ?>

<?php if (! empty ( $this->_tpl_vars['video_data']['description'] )): ?>
<h2><?php echo $this->_tpl_vars['lang']['description']; ?>
</h2>
<div class="description text-exp">
    <p><?php echo $this->_tpl_vars['video_data']['description']; ?>
</p>
    <p class="show-more"><a href="#" class="show-now"><?php echo $this->_tpl_vars['lang']['show_more']; ?>
</a></p>
</div>
<?php endif; ?>

<?php if (! empty ( $this->_tpl_vars['tags'] )): ?>
<div class="video-tags">
	<strong><?php echo $this->_tpl_vars['lang']['tags']; ?>
</strong>: <?php echo $this->_tpl_vars['tags']; ?>

</div>
<?php endif; ?>

<?php if ($this->_tpl_vars['show_fb_like'] == '1'): ?>
<div style="display: block;">
<iframe src="http://www.facebook.com/plugins/like.php?href=<?php echo $this->_tpl_vars['facebook_like_href']; ?>
&amp;layout=standard&amp;show_faces=false&amp;width=400&amp;action=like&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:400px; height:35px;" allowTransparency="true"></iframe>
</div>
<?php endif; ?>

<h2><?php echo $this->_tpl_vars['lang']['post_comment']; ?>
</h2>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'comment-form.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php if (! $this->_tpl_vars['logged_in'] && ! $this->_tpl_vars['guests_can_comment']): ?>
	<?php echo $this->_tpl_vars['must_sign_in']; ?>

<?php endif; ?>

<h2><?php echo $this->_tpl_vars['lang']['comments']; ?>
</h2>
<div class="pm-comments comment_box">
<?php if ($this->_tpl_vars['comment_count'] == 0): ?>
    <ul class="pm-ul-comments">
    	<li id="preview_comment"></li>
    </ul>
    <div id="be_the_first"><?php echo $this->_tpl_vars['lang']['be_the_first']; ?>
</div>
<?php else: ?>
    <span id="comment-list-container">
		<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "comment-list.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<!-- comment pagination -->
		<?php if ($this->_tpl_vars['comment_pagination_obj'] != ''): ?>
			<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "comment-pagination.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
		<?php endif; ?>
	</span>
<?php endif; ?>
</div>
		</div><!-- #primary -->
        </div><!-- .span8 -->
        
        <div class="span4 pm-sidebar">
		<div id="secondary">
        <div class="widget-related widget" id="pm-related">
          <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#bestincategory" data-target="#bestincategory" data-toggle="tab"><?php echo $this->_tpl_vars['lang']['tab_related']; ?>
</a></li>
            <li> / </li>
            <li><a href="#popular" data-target="#popular" data-toggle="tab"><?php echo $this->_tpl_vars['lang']['_popular']; ?>
</a></li>
          </ul>
 
          <div id="pm-tabs" class="tab-content">
            <div class="tab-pane fade in active" id="bestincategory">
                <ul class="pm-ul-top-videos">
                <?php $_from = $this->_tpl_vars['related_video_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['related_video_data']):
?>
				  <li>
					<div class="pm-li-top-videos">
					<span class="pm-video-thumb pm-thumb-106 pm-thumb-top border-radius2">
					<span class="pm-video-li-thumb-info">
					<?php if ($this->_tpl_vars['related_video_data']['duration'] != 0): ?><span class="pm-label-duration border-radius3 opac7"><?php echo $this->_tpl_vars['related_video_data']['duration']; ?>
</span><?php endif; ?>
					</span>
                    <a href="<?php echo $this->_tpl_vars['related_video_data']['video_href']; ?>
" class="pm-thumb-fix pm-thumb-145"><span class="pm-thumb-fix-clip"><img src="<?php echo $this->_tpl_vars['related_video_data']['thumb_img_url']; ?>
" alt="<?php echo $this->_tpl_vars['related_video_data']['attr_alt']; ?>
" width="145"><span class="vertical-align"></span></span></a>
					</span>
					<h3 dir="ltr"><a href="<?php echo $this->_tpl_vars['related_video_data']['video_href']; ?>
" class="pm-title-link"><?php echo $this->_tpl_vars['related_video_data']['video_title']; ?>
</a></h3>
                    <div class="pm-video-attr">
                    	<span class="pm-video-attr-numbers"><small><?php echo $this->_tpl_vars['related_video_data']['views_compact']; ?>
 <?php echo $this->_tpl_vars['lang']['views']; ?>
</small></span>
                    </div>
					<?php if ($this->_tpl_vars['related_video_data']['featured']): ?>
					<span class="pm-video-li-info">
					    <span class="label label-featured"><?php echo $this->_tpl_vars['lang']['_feat']; ?>
</span>
					</span>
					<?php endif; ?>
					</div>
				  </li>
				<?php endforeach; else: ?>
				  <?php echo $this->_tpl_vars['lang']['top_videos_msg2']; ?>

				<?php endif; unset($_from); ?>
                </ul>
            </div>
            <div class="tab-pane fade" id="popular">
                <ul class="pm-ul-top-videos">
                <?php $_from = $this->_tpl_vars['popular_video_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['popular_video_data']):
?>
				  <li>
					<div class="pm-li-top-videos">
					<span class="pm-video-thumb pm-thumb-106 pm-thumb-top border-radius2">
					<span class="pm-video-li-thumb-info">
					<?php if ($this->_tpl_vars['popular_video_data']['duration'] != 0): ?><span class="pm-label-duration border-radius3 opac7"><?php echo $this->_tpl_vars['popular_video_data']['duration']; ?>
</span><?php endif; ?>
					</span>
                    <a href="<?php echo $this->_tpl_vars['popular_video_data']['video_href']; ?>
" class="pm-thumb-fix pm-thumb-145"><span class="pm-thumb-fix-clip"><img src="<?php echo $this->_tpl_vars['popular_video_data']['thumb_img_url']; ?>
" alt="<?php echo $this->_tpl_vars['popular_video_data']['attr_alt']; ?>
" width="145"><span class="vertical-align"></span></span></a>
					</span>
					<h3 dir="ltr"><a href="<?php echo $this->_tpl_vars['popular_video_data']['video_href']; ?>
" class="pm-title-link"><?php echo $this->_tpl_vars['popular_video_data']['video_title']; ?>
</a></h3>
                    <div class="pm-video-attr">
                    	<span class="pm-video-attr-numbers"><small><?php echo $this->_tpl_vars['popular_video_data']['views_compact']; ?>
 <?php echo $this->_tpl_vars['lang']['views']; ?>
</small></span>
                    </div>
					<?php if ($this->_tpl_vars['popular_video_data']['featured']): ?>
					<span class="pm-video-li-info">
					    <span class="label label-featured"><?php echo $this->_tpl_vars['lang']['_feat']; ?>
</span>
					</span>
					<?php endif; ?>
					</div>
				  </li>
				<?php endforeach; else: ?>
				  <?php echo $this->_tpl_vars['lang']['top_videos_msg2']; ?>

				<?php endif; unset($_from); ?>
                </ul>
            </div>
          </div>
          
        </div><!-- .shadow-div -->
        
		</div><!-- #secondary -->
        </div><!-- #sidebar -->
      </div><!-- .row-fluid -->
    </div><!-- .container-fluid -->
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'footer.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>