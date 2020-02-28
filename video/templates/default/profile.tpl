{include file='header.tpl' p="general"} 
<div id="wrapper" class="profile-page">
    <div class="container-fluid">
      <div class="row-fluid">
        <div class="span12">
		<div id="primary">
		<div class="span3">
        <div class="profile-avatar">
        <span class="img_polaroid"><img src="{$avatar}" border="0" alt="" class="img-polaroid" width="180" height="180"></span>
        </div>
        
        <div id="profile-tabs">
            <div class="tabbable tabs-left">
              <ul class="nav nav-tabs">
                {if $smarty.const._MOD_SOCIAL}
                 {if  $s_user_id == $profile_data.id}
					<li class="active"><a href="#pm-pro-activity-stream" data-toggle="tab">{$lang.activity_newsfeed}</a></li>
				 {/if}
				 {if $s_user_id == $profile_data.id || $am_following}
					<li><a href="#pm-pro-user-activity" data-toggle="tab">{$lang.my_activity}</a></li>
				 {/if}
				 {if $profile_data.id != $s_user_id}
					<li class="active"><a href="#pm-pro-about" data-toggle="tab">{$lang.about_me}</a></li>
					{else}
					<li><a href="#pm-pro-about" data-toggle="tab">{$lang.about_me}</a></li>
				 {/if}
                {else}
					<li class="active"><a href="#pm-pro-about" data-toggle="tab">{$lang.about_me}</a></li>
				{/if}
                <li><a href="#pm-pro-fav" data-toggle="tab">{$lang.my_favorites}</a></li>
                <li><a href="#pm-pro-own" data-toggle="tab">{$lang.mysubmissions}</a></li>
				{if $smarty.const._MOD_SOCIAL}
					<li><a href="#pm-pro-followers" data-toggle="tab">{$lang.activity_followers}</a></li>
					<li><a href="#pm-pro-following" data-toggle="tab">{$lang.activity_following}</a></li>
				{/if}
              </ul>
            </div> <!-- /tabbable -->
        </div>

        </div>
        <div class="span9 vertical-menu">
        	<div class="row-fluid">
            	<div class="span7">
                	<h2 class="username">{$full_name}{if $user_is_banned} <span class="label label-important">{$lang.user_account_banned_label}</span>{/if}
                    {if $smarty.const._MOD_SOCIAL && $logged_in == 1 && $s_user_id != $profile_data.id}
                        {if $profile_data.is_following_me}
                            <span class="label pm-follows">{$lang.follow_following_you}</span>
                        {/if}
                    {/if}
					</h2>
                    
                    <ul class="pm-pro-counts">
                        <li><span class="count-number">{$total_submissions}</span> <span class="count-what"><a href="#pm-pro-own" data-toggle="tab">{$lang.videos}</a></span></li>
						{if $smarty.const._MOD_SOCIAL}
                        <li><span class="count-number">{$profile_data.followers_count}</span> <span class="count-what"><a href="#pm-pro-followers" data-toggle="tab">{$lang.activity_followers}</a></span></li>
						<li class="last-li"><span class="count-number">{$profile_data.following_count}</span> <span class="count-what"><a href="#pm-pro-following" data-toggle="tab">{$lang.activity_following}</a></span></li>
						{/if}
                    </ul>
                </div>
            	<div class="span5">
                    <div align="right">
                        {if $smarty.const._MOD_SOCIAL && $logged_in == 1 && $s_user_id != $profile_data.id}
                            {include file='user-follow-button.tpl' profile_user_id=$profile_data.id}
                        {/if}
                    </div>
                </div>
            </div>

        	<div class="clearfix"></div>
		
		


<div class="tab-content">

			{if $smarty.const._MOD_SOCIAL && $profile_data.id == $s_user_id}
            <div class="tab-pane fade" id="pm-pro-about">
			{else}
			<div class="tab-pane fade in active" id="pm-pro-about">
			{/if}
              <ul class="pm-pro-data">
                  <li><i class="icon-map-marker"></i> {$country}</li>
                  <li><i class="icon-user"></i> {$reg_date}</li>
                  <li><i class="icon-off"></i> {$status}</li>
                  <li><i class="icon-eye-open"></i> {$last_seen}</li>
              </ul>
            <h4>{$lang.about_me}</h4>
            {if !empty($about)}
            <p>{$about}</p>
            {else}
			<p>{$lang.profile_msg_about_empty}</p>
            {/if}
	  		{if isset($mm_profile_info_inject)}{$mm_profile_info_inject}{/if}

			<h4>{$lang._social}</h4>
            <ul class="pm-pro-social">
			{if isset($social_website) && $social_website != ''} 
				<li><a href="{$social_website}" target="_blank"><img src="{$smarty.const._URL}/templates/{$template_dir}/img/ico_social_site.png" width="16" height="16" alt="{$lang.profile_social_website}" border="0"> {$social_website}</a></li>
			{else}
				<li><img src="{$smarty.const._URL}/templates/{$template_dir}/img/ico_social_site.png" width="16" height="16" alt="{$lang.profile_social_website}" border="0" class="ico-social-none"> n/a</li>
			{/if} 
			{if isset($social_facebook) && $social_facebook != ''}
				<li><a href="{$social_facebook}" target="_blank"><img src="{$smarty.const._URL}/templates/{$template_dir}/img/ico_social_fb.png" width="16" height="16" alt="{$lang.profile_social_fb}" border="0"> {$social_facebook}</a></li>
			{else}
				<li><img src="{$smarty.const._URL}/templates/{$template_dir}/img/ico_social_fb.png" width="16" height="16" alt="{$lang.profile_social_website}" border="0" class="ico-social-none"> n/a</li>
			{/if}
			{if isset($social_twitter) && $social_twitter != ''}
				<li><a href="{$social_twitter}" target="_blank"><img src="{$smarty.const._URL}/templates/{$template_dir}/img/ico_social_twitter.png" width="16" height="16" alt="{$lang.profile_social_twitter}" border="0"> {$social_twitter}</a></li>
			{else}
				<li><img src="{$smarty.const._URL}/templates/{$template_dir}/img/ico_social_twitter.png" width="16" height="16" alt="{$lang.profile_social_twitter}" border="0" class="ico-social-none"> n/a</li>
			{/if}
			{if isset($social_lastfm) && $social_lastfm != ''}
				<li><a href="{$social_lastfm}" target="_blank"><img src="{$smarty.const._URL}/templates/{$template_dir}/img/ico_social_lastfm.png" width="16" height="16" alt="{$lang.profile_social_lastfm}" border="0"> {$social_lastfm}</a></li>
			{else}
				<li><img src="{$smarty.const._URL}/templates/{$template_dir}/img/ico_social_lastfm.png" width="16" height="16" alt="{$lang.profile_social_lastfm}" border="0" class="ico-social-none"> n/a</li>
			{/if}
			{if isset($mm_profile_webfields_inject)}{$mm_profile_webfields_inject}{/if}
			</ul>

            </div>
            <div class="tab-pane fade" id="pm-pro-fav">
            <h4>{$lang.my_favorites}</h4>

            {if $favorite == 1}
                <ul class="pm-ul-browse-videos thumbnails">
                {foreach from=$fav_video_list key=k item=video_data}
                  <li>
                    <div class="pm-li-video">
                        <span class="pm-video-thumb pm-thumb-145 pm-thumb border-radius2">
                        <span class="pm-video-li-thumb-info">
                        {if $video_data.yt_length != 0}<span class="pm-label-duration border-radius3 opac7">{$video_data.duration}</span>{/if}
                        {if $video_data.mark_new}<span class="label label-new">{$lang._new}</span>{/if}
                            {if $video_data.mark_popular}<span class="label label-pop">{$lang._popular}</span>{/if}
                        </span>
                        <a href="{$video_data.video_href}" class="pm-thumb-fix pm-thumb-145"><span class="pm-thumb-fix-clip"><img src="{$video_data.thumb_img_url}" alt="{$video_data.video_title}" width="145"><span class="vertical-align"></span></span></a>
                        </span>
                        
                        <h3 dir="ltr"><a href="{$video_data.video_href}" class="pm-title-link" title="{$video_data.video_title}">{$video_data.video_title}</a></h3>
                        <div class="pm-video-attr">
                            <span class="pm-video-attr-author">{$lang.articles_by} <a href="{$video_data.author_profile_href}">{$video_data.author_username}</a></span>
                            <span class="pm-video-attr-since"><small>{$lang.added} <time datetime="{$video_data.html5_datetime}" title="{$video_data.full_datetime}">{$video_data.time_since_added} {$lang.ago}</time></small></span>
                            <span class="pm-video-attr-numbers"><small>{$video_data.views_compact} {$lang.views} / {$video_data.likes_compact} {$lang._likes}</small></span>
                        </div>
                        <p class="pm-video-attr-desc">{$video_data.excerpt}</p>
                        {if $video_data.featured}
                        <span class="pm-video-li-info">
                            <span class="label label-featured">{$lang._feat}</span>
                        </span>
                        {/if}
                    </div>
                  </li>
                {foreachelse}
                    {$lang.profile_msg_list_empty}
                {/foreach}
                </ul>
        	 {else}
             {$lang.favorites_msg2}
             {/if} <!-- /$favorite -->
            </div>
            <div class="tab-pane fade" id="pm-pro-own">
            <h4>{$lang.submittedby} {$full_name}</h4>

            <ul class="pm-ul-browse-videos thumbnails">
            {foreach from=$submitted_video_list key=k item=video_data}
              <li>
                <div class="pm-li-video">
                    <span class="pm-video-thumb pm-thumb-145 pm-thumb border-radius2">
                    <span class="pm-video-li-thumb-info">
                    {if $video_data.yt_length != 0}<span class="pm-label-duration border-radius3 opac7">{$video_data.duration}</span>{/if}
                    {if $video_data.mark_new}<span class="label label-new">{$lang._new}</span>{/if}
                        {if $video_data.mark_popular}<span class="label label-pop">{$lang._popular}</span>{/if}
                    </span>
                    <a href="{$video_data.video_href}" class="pm-thumb-fix pm-thumb-145"><span class="pm-thumb-fix-clip"><img src="{$video_data.thumb_img_url}" alt="{$video_data.video_title}" width="145"><span class="vertical-align"></span></span></a>
                    </span>
                    
                    <h3 dir="ltr"><a href="{$video_data.video_href}" class="pm-title-link" title="{$video_data.video_title}">{$video_data.video_title}</a></h3>
                    <div class="pm-video-attr">
                        <span class="pm-video-attr-author">{$lang.articles_by} <a href="{$video_data.author_profile_href}">{$video_data.author_username}</a></span>
                        <span class="pm-video-attr-since"><small>{$lang.added} <time datetime="{$video_data.html5_datetime}" title="{$video_data.full_datetime}">{$video_data.time_since_added} {$lang.ago}</time></small></span>
                        <span class="pm-video-attr-numbers"><small>{$video_data.views_compact} {$lang.views} / {$video_data.likes_compact} {$lang._likes}</small></span>
                    </div>
                    <p class="pm-video-attr-desc">{$video_data.excerpt}</p>
                    {if $video_data.featured}
                    <span class="pm-video-li-info">
                        <span class="label label-featured">{$lang._feat}</span>
                    </span>
                    {/if}
                </div>
              </li>
            {foreachelse}
                {$lang.top_videos_msg2}
            {/foreach}
            </ul>
            
            {if count($submitted_video_list) == 16}
            <a href="search.php?keywords={$username}&btn=Search&t=user" class="btn btn-small" title="{$lang.profile_watch_all}">{$lang.profile_watch_all}</a>
            {/if}
            </div>
			{if $smarty.const._MOD_SOCIAL}
			<div class="tab-pane fade" id="pm-pro-followers">
			<h4>{$lang.activity_followers}</h4>
				<div id="pm-pro-followers-content"></div>
			</div>
			
			<div class="tab-pane fade" id="pm-pro-following">
			<h4>{$lang.activity_following}</h4>
				<div id="pm-pro-following-content"></div>
			</div>

			{if $s_user_id == $profile_data.id || $am_following}
			<div class="tab-pane fade" id="pm-pro-user-activity"> 
			<h4>{$lang.my_activity}</h4>
				<div id="pm-pro-user-activity-content"></div>
			</div>
			{/if}
			
			{if $s_user_id == $profile_data.id}
			<div class="tab-pane fade in active" id="pm-pro-activity-stream">
			<h4>{$lang.activity_newsfeed}</h4>
                <form name="user-update-status" method="post" action="" onsubmit="update_status();return false;" >
                    <textarea class="span12" name="post-status" ></textarea>
                    <br />
                    <button type="submit" name="btn-update-status" class="btn btn-blue" />{$lang.status_update}</button>
                </form>
				<div id="pm-pro-activity-stream-content">
					{include file='activity-stream.tpl'}
				</div>
			</div>
			{/if}
			{/if}
			
          </div><!-- /tab-content -->
          
        </div>

		<input type="hidden" name="profile_user_id" value="{$profile_data.id}" />
		</div><!-- #primary -->
        </div><!-- #content -->
      </div><!-- .row-fluid -->
    </div><!-- .container-fluid -->
{include file='footer.tpl'}