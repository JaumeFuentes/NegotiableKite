{include file='header.tpl' p="detail"} 
<div id="wrapper">
    <div class="container-fluid">
	<div class="row-fluid">
        <div class="span8">
		<div id="primary">
<div class="row-fluid">
	<div class="span12">
        {if $logged_in && $is_admin == 'yes'}
        <a href="{$smarty.const._URL}/admin/modify.php?vid={$video_data.uniq_id}" rel="tooltip" class="btn btn-mini pull-right" title="{$lang.edit} ({$lang._admin_only})" target="_blank">{$lang.edit}</a>
        {/if}
        <h1 class="entry-title">{$video_data.video_title}</h1>
        <div class="row-fluid">
            <div class="span6">
            {if $video_data.featured == 1}
                <span class="label label-featured">{$lang.featured}</span>
            {/if}
            </div>
            <div class="span6">
            <div id="lights-div"><a class="lightOn" href="#">{$lang.lights_off}</a></div>
            </div>
        </div>
        <div class="pm-player-full-width">
	   	    <div id="video-wrapper">
            {if $display_preroll_ad == true}
            <div id="preroll_placeholder" class="border-radius4">
            <div class="preroll_countdown">
                        {$lang.preroll_ads_timeleft} <span class="preroll_timeleft">{$preroll_ad_data.timeleft_start}</span>
            </div>
                        {$preroll_ad_data.code}
            </div>
            {else}
                        {include file="player.tpl" page="detail"}
            {/if}
	        </div><!--#video-wrapper-->
            <div class="pm-video-control">
            <div class="row-fluid">
            <div class="span9">
            <small>{$lang.articles_published} <time datetime="{$video_data.html5_datetime}" title="{$video_data.full_datetime}">{$video_data.time_since_added} {$lang.ago}</time> {$lang.articles_by}  <a href="{$smarty.const._URL}/profile.{$smarty.const._FEXT}?u={$video_data.author_username}">{$video_data.author_name}</a> {$lang._in} {$category_name}</small> 
            <div class="clearfix"></div>

            <button class="btn btn-small border-radius0 {if $bin_rating_vote_value == 1}active{/if}" id="bin-rating-like" type="button"><i class="icon-thumbs-up"></i> {$lang._like}</button>
            <button class="btn btn-small border-radius0 {if $bin_rating_vote_value == 0 && $bin_rating_vote_value !== false}active{/if}" id="bin-rating-dislike" type="button"><i class="icon-thumbs-down"></i></button>
            <button class="btn btn-small border-radius0" type="button" data-toggle="button" id="pm-vc-share">{$lang._share}</button>
            <input type="hidden" name="bin-rating-uniq_id" value="{$video_data.uniq_id}">
            {if $logged_in}
                
                {if $isfavorite == '1'}
                <!--{$lang.dp_alt_1}-->
                <form name="addtofavorites" id="addtofavorites" class="form-inline" action="">
                    <input type="hidden" value="{$video_data.uniq_id}" name="fav_video_id">
                    <input type="hidden" value="{$s_user_id}" name="fav_user_id">
                    <button class="btn btn-small border-radius0 active" id="fav_save_button" type="button">{$lang.remove_from_fav}</button>
                </form>
                {elseif $smarty.const._FAV_LIMIT == $countfavorites}
                 <a href="{$smarty.const._URL}/favorites.php?a=show" class="btn btn-small border-radius0">{$lang.dp_alt_2}</a>
                {else}
                <form name="addtofavorites" id="addtofavorites" class="form-inline" action="">
                    <input type="hidden" value="{$video_data.uniq_id}" name="fav_video_id">
                    <input type="hidden" value="{$s_user_id}" name="fav_user_id">
                    <button class="btn btn-small border-radius0" id="fav_save_button" type="button">{$lang.add_to_fav}</button>
                </form>
                {/if}
            {else}
              <!--{$lang.dp_alt_1}-->
            {/if}
            <button class="btn btn-small border-radius0" type="button" data-toggle="button" id="pm-vc-report" title="{$lang.report_video}"><i class="icon-flag"></i></button>
            </div>
            
            <div class="span3">
            <span class="pm-vc-views">
			<strong>{$video_data.site_views_formatted}</strong>
            <small>{$lang.views}</small>
            </span>
            <div class="clearfix"></div>
            <div class="progress" title="{$video_data.up_vote_count_formatted} {$lang._likes}, {$video_data.down_vote_count_formatted} {$lang._dislikes}">
              <div class="bar bar-success" id="rating-bar-up-pct" style="width: {$video_data.up_pct}%;"></div>
              <div class="bar bar-danger" id="rating-bar-down-pct" style="width: {$video_data.down_pct}%;"></div>
            </div>
            </div>
            </div>
            </div>
            
		<div id="bin-rating-response" class="hide well well-small"></div>
		<div id="bin-rating-like-confirmation" class="hide well well-small alert alert-well">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
		<p>{$lang.confirm_like}</p>
			<div class="row-fluid">
                <div class="span3 panel-1">
                <a href="http://www.facebook.com/sharer.php?u={$facebook_like_href}&amp;t={$facebook_like_title}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on FaceBook"><img src="{$smarty.const._URL}/templates/{$template_dir}/img/facebook-icon.jpg" alt=""></a>
                <a href="http://twitter.com/home?status=Watching%20{$facebook_like_title}%20on%20{$facebook_like_href}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on Twitter"><img src="{$smarty.const._URL}/templates/{$template_dir}/img/twitter-icon.jpg"  alt=""></a>
				<a href="https://plus.google.com/share?url={$facebook_like_href}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on Google+"><img
  src="{$smarty.const._URL}/templates/{$template_dir}/img/google-icon.jpg" alt=""></a>
                </div>
                <div class="span9 panel-3">
                <div class="input-prepend"><span class="add-on">URL</span><input name="share_video_link" id="share_video_link" type="text" value="{$video_data.video_href}" class="span11" onClick="SelectAll('share_video_link');"></div>
                </div>
            </div>
        </div>
		<div id="bin-rating-dislike-confirmation" class="hide-dislike hide well well-small">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p>{$lang.confirm_dislike}</p>
        </div>


		<div id="pm-vc-report-content" class="hide well well-small alert alert-well">
			<div id="report-confirmation" class="hide"></div>
			<form name="reportvideo" action="" method="POST" class="form-inline">
			  <input type="hidden" id="name" name="name" class="input-small" value="{if $logged_in}{$s_name}{/if}">
			  <input type="hidden" id="email" name="email" class="input-small" value="{if $logged_in}{$s_email}{/if}">
			
			  <select name="reason" class="input-medium inp-small">
				<option value="{$lang.report_form1}" selected="selected">{$lang.report_form1}</option>
				<option value="{$lang.report_form4}">{$lang.report_form4}</option>
				<option value="{$lang.report_form5}">{$lang.report_form5}</option>
				<option value="{$lang.report_form6}">{$lang.report_form6}</option>
				<option value="{$lang.report_form7}">{$lang.report_form7}</option>
			  </select>
			  
			  {if ! $logged_in}
			  	<input type="text" name="imagetext" class="input-small inp-small" autocomplete="off" placeholder="{$lang.confirm_comment}">
			    <button class="btn btn-small btn-link" onclick="document.getElementById('securimage-report').src = '{$smarty.const._URL}/include/securimage_show.php?sid=' + Math.random(); return false;"><i class="icon-refresh"></i> </button>
			    <img src="{$smarty.const._URL}/include/securimage_show.php?sid={echo_securimage_sid}" id="securimage-report" alt="" class="border-radius3">
			  {/if}
			  <button type="submit" name="Submit" class="btn btn-danger" value="{$lang.submit_send}">{$lang.report_video}</button>
			  <input type="hidden" name="p" value="detail">
			  <input type="hidden" name="do" value="report">
			  <input type="hidden" name="vid" value="{$video_data.uniq_id}">
			</form>
		</div>

        <div id="pm-vc-share-content" class="alert alert-well">
			<div class="row-fluid">
                <div class="span4 panel-1">
                <div class="input-prepend"><span class="add-on">URL</span><input name="video_link" id="video_link" type="text" value="{$video_data.video_href}" class="input-medium" onClick="SelectAll('video_link');"></div>
                </div>
                <div class="span5 panel-2">
                <button class="btn border-radius0" type="button" id="pm-vc-embed">{$lang._embed}</button>
                <button class="btn border-radius0" type="button" data-toggle="button" id="pm-vc-email"><i class="icon-envelope"></i> {$lang.email_video}</button>
                </div>
                <div class="span3 panel-3">
                <a href="http://www.facebook.com/sharer.php?u={$facebook_like_href}&amp;t={$facebook_like_title}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on FaceBook"><img src="{$smarty.const._URL}/templates/{$template_dir}/img/facebook-icon.jpg"></a>
                <a href="http://twitter.com/home?status=Watching%20{$facebook_like_title}%20on%20{$facebook_like_href}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on Twitter"><img src="{$smarty.const._URL}/templates/{$template_dir}/img/twitter-icon.jpg"></a>
				<a href="https://plus.google.com/share?url={$facebook_like_href}" onclick="javascript:window.open(this.href,
  '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" rel="tooltip" title="Share on Google+"><img
  src="{$smarty.const._URL}/templates/{$template_dir}/img/google-icon.jpg" alt="" /></a>  
                </div>
            </div>

            <div id="pm-vc-embed-content">
              <hr />
    		  <textarea name="pm-embed-code" id="pm-embed-code" rows="3" class="span12" onClick="SelectAll('pm-embed-code');">{$embedcode_to_share}</textarea>
        	</div>
            <div id="pm-vc-email-content">
              <hr />
		<div id="share-confirmation" class="hide well well-small"></div>
	            <form name="sharetofriend" action="" method="POST" class="form-inline">
	              <input type="text" id="name" name="name" class="input-small inp-small" value="{$s_name}" placeholder="{$lang.your_name}">
	              <input type="text" id="email" name="email" class="input-small inp-small" placeholder="{$lang.friends_email}">
		          {if ! $logged_in}   
					  <input type="text" name="imagetext" class="input-small inp-small" autocomplete="off" placeholder="{$lang.confirm_comment}">
		              <button class="btn btn-small btn-link" onclick="document.getElementById('securimage-share').src = '{$smarty.const._URL}/include/securimage_show.php?sid=' + Math.random(); return false;"><i class="icon-refresh"></i> </button>
					  <img src="{$smarty.const._URL}/include/securimage_show.php?sid={echo_securimage_sid}" id="securimage-share" alt="">
				  {/if}
				  <input type="hidden" name="p" value="detail">
				  <input type="hidden" name="do" value="share">
				  <input type="hidden" name="vid" value="{$video_data.uniq_id}">
	              <button type="submit" name="Submit" class="btn btn-success">{$lang.submit_send}</button>
	            </form>
        	</div>
        </div>
        </div><!--end pm-player-full-width -->
	</div>
</div>

{if $ad_3 != ''}
<div class="pm-ad-zone" align="center">{$ad_3}</div>
{/if}

{if !empty($video_data.description)}
<h2>{$lang.description}</h2>
<div class="description text-exp">
    <p>{$video_data.description}</p>
    <p class="show-more"><a href="#" class="show-now">{$lang.show_more}</a></p>
</div>
{/if}

{if !empty($tags)}
<div class="video-tags">
	<strong>{$lang.tags}</strong>: {$tags}
</div>
{/if}

{if $show_fb_like == '1'}
<div style="display: block;">
<iframe src="http://www.facebook.com/plugins/like.php?href={$facebook_like_href}&amp;layout=standard&amp;show_faces=false&amp;width=400&amp;action=like&amp;colorscheme=light&amp;height=35" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:400px; height:35px;" allowTransparency="true"></iframe>
</div>
{/if}

<h2>{$lang.post_comment}</h2>
{include file='comment-form.tpl'}
{if ! $logged_in && ! $guests_can_comment}
	{$must_sign_in}
{/if}

<h2>{$lang.comments}</h2>
<div class="pm-comments comment_box">
{if $comment_count == 0}
    <ul class="pm-ul-comments">
    	<li id="preview_comment"></li>
    </ul>
    <div id="be_the_first">{$lang.be_the_first}</div>
{else}
    <span id="comment-list-container">
		{include file="comment-list.tpl"}
		<!-- comment pagination -->
		{if $comment_pagination_obj != ''}
			{include file="comment-pagination.tpl"}
		{/if}
	</span>
{/if}
</div>
		</div><!-- #primary -->
        </div><!-- .span8 -->
        
        <div class="span4 pm-sidebar">
		<div id="secondary">
        <div class="widget-related widget" id="pm-related">
          <ul class="nav nav-tabs" id="myTab">
            <li class="active"><a href="#bestincategory" data-target="#bestincategory" data-toggle="tab">{$lang.tab_related}</a></li>
            <li> / </li>
            <li><a href="#popular" data-target="#popular" data-toggle="tab">{$lang._popular}</a></li>
          </ul>
 
          <div id="pm-tabs" class="tab-content">
            <div class="tab-pane fade in active" id="bestincategory">
                <ul class="pm-ul-top-videos">
                {foreach from=$related_video_list key=k item=related_video_data}
				  <li>
					<div class="pm-li-top-videos">
					<span class="pm-video-thumb pm-thumb-106 pm-thumb-top border-radius2">
					<span class="pm-video-li-thumb-info">
					{if $related_video_data.duration != 0}<span class="pm-label-duration border-radius3 opac7">{$related_video_data.duration}</span>{/if}
					</span>
                    <a href="{$related_video_data.video_href}" class="pm-thumb-fix pm-thumb-145"><span class="pm-thumb-fix-clip"><img src="{$related_video_data.thumb_img_url}" alt="{$related_video_data.attr_alt}" width="145"><span class="vertical-align"></span></span></a>
					</span>
					<h3 dir="ltr"><a href="{$related_video_data.video_href}" class="pm-title-link">{$related_video_data.video_title}</a></h3>
                    <div class="pm-video-attr">
                    	<span class="pm-video-attr-numbers"><small>{$related_video_data.views_compact} {$lang.views}</small></span>
                    </div>
					{if $related_video_data.featured}
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
            </div>
            <div class="tab-pane fade" id="popular">
                <ul class="pm-ul-top-videos">
                {foreach from=$popular_video_list key=k item=popular_video_data}
				  <li>
					<div class="pm-li-top-videos">
					<span class="pm-video-thumb pm-thumb-106 pm-thumb-top border-radius2">
					<span class="pm-video-li-thumb-info">
					{if $popular_video_data.duration != 0}<span class="pm-label-duration border-radius3 opac7">{$popular_video_data.duration}</span>{/if}
					</span>
                    <a href="{$popular_video_data.video_href}" class="pm-thumb-fix pm-thumb-145"><span class="pm-thumb-fix-clip"><img src="{$popular_video_data.thumb_img_url}" alt="{$popular_video_data.attr_alt}" width="145"><span class="vertical-align"></span></span></a>
					</span>
					<h3 dir="ltr"><a href="{$popular_video_data.video_href}" class="pm-title-link">{$popular_video_data.video_title}</a></h3>
                    <div class="pm-video-attr">
                    	<span class="pm-video-attr-numbers"><small>{$popular_video_data.views_compact} {$lang.views}</small></span>
                    </div>
					{if $popular_video_data.featured}
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
            </div>
          </div>
          
        </div><!-- .shadow-div -->
        
		</div><!-- #secondary -->
        </div><!-- #sidebar -->
      </div><!-- .row-fluid -->
    </div><!-- .container-fluid -->
{include file='footer.tpl'}