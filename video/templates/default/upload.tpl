{include file='header.tpl' no_index='1' p="upload"}
<div id="wrapper">
  <div class="container-fluid">
    <div class="row-fluid">
        <div class="span12 extra-space">
            <nav id="second-nav" class="tabbable" role="navigation">
                <ul class="nav nav-tabs pull-right">
                <li><a href="{$smarty.const._URL}/edit_profile.{$smarty.const._FEXT}">{$lang.edit_profile}</a></li>
                <li><a href="{$smarty.const._URL}/upload_avatar.{$smarty.const._FEXT}">{$lang.update_avatar}</a></li>
                <li><a href="{$smarty.const._URL}/favorites.{$smarty.const._FEXT}?a=show">{$lang.my_favorites}</a></li>
                {if $smarty.const._ALLOW_USER_SUGGESTVIDEO == '1'}
                <li><a href="{$smarty.const._URL}/suggest.{$smarty.const._FEXT}">{$lang.suggest}</a></li>
                {/if}
                {if $smarty.const._ALLOW_USER_UPLOADVIDEO == '1'}
                <li class="active"><a href="{$smarty.const._URL}/upload.{$smarty.const._FEXT}">{$lang.upload_video}</a></li>
                {/if}
                <li><a href="{$smarty.const._URL}/memberlist.{$smarty.const._FEXT}">{$lang.members_list}</a></li>
                </ul>
            </nav><!-- #site-navigation -->
        </div>
      </div>

      <div class="row-fluid">
       <div class="span12 extra-space">
		<div id="primary">

		<h1>{$lang.upload_video}</h1>
 		<hr />
		{if $success == 1}
			<div class="alert alert-success">
			{$lang.suggest_msg4}
			<br />
			<a href="upload.{$smarty.const._FEXT}">{$lang.add_another_one}</a> or <a href="index.{$smarty.const._FEXT}">{$lang.return_home}</a>
			</div>
		{elseif $success == 2}
			<div class="alert alert-success">
			{$lang.upload_errmsg11} 
			<a href="index.{$smarty.const._FEXT}">{$lang.return_home}</a>
			</div>
		{else}
			{if count($errors) > 0}
		        <div class="alert alert-warning">
		        <button type="button" class="close" data-dismiss="alert">&times;</button>
		        <ul class="subtle-list">
		            {foreach from=$errors item=v}
		            	<li>{$v}</li>                        
		            {/foreach}
		        </ul>
		        </div>
			{/if}
			<form class="form-horizontal" name="upload-video-form" id="upload-video-form" enctype="multipart/form-data" method="post" action="{$form_action}">
			<fieldset>
			    <div class="control-group">
			      <label class="control-label" for="mediafile">{$lang.upload_video1}</label>
			      <div class="controls">
			        <input type="file" name="mediafile" value="" size="40">
			        <input type="hidden" name="MAX_FILE_SIZE" value="{$max_file_size}">
					<span class="help-inline"><a href="#" rel="tooltip" title="*.flv,*.mp4,*.wmv,*.mov,*.divx,*.avi,*.mkv, *.asf, *.wma, *.mp3, *.m4v, *.m4a, *.3gp, *.3g2<br /> Maximum: {$upload_limit} "><i class="icon-info-sign"></i> </a></span>
			      </div>
			    </div>
			    <div class="control-group">
			      <label class="control-label" for="capture">{$lang.upload_video2}</label>
			      <div class="controls">
						<input type="file" name="capture" value="" size="40">
						<input type="hidden" name="MAX_FILE_SIZE" value="{$max_file_size}">
						<span class="help-inline"><a href="#" rel="tooltip" title="*.jpg, *.jpeg, *.gif, *.png"><i class="icon-info-sign"></i></a></span>
			      </div>
			    </div>
				<div class="hide" id="upload-video-extra">
					<div class="control-group">
				      <label class="control-label" for="video_title">{$lang.video}</label>
				      <div class="controls">
				      <input name="video_title" type="text" value="{$smarty.post.video_title}" class="input-large">
				      </div>
				    </div>
					<div class="control-group">
				      <label class="control-label" for="duration">{$lang._duration}</label>
				      <div class="controls">
				      <input name="duration" id="duration" type="text" value="{$smarty.post.duration}" class="input-mini" style="text-align: center;">
                      <span class="help-inline"><a href="#" rel="tooltip" title="{$lang.duration_format}"><i class="icon-info-sign"></i></a></span>
				      </div>
				    </div>
				    <div class="control-group">
				      <label class="control-label" for="category">{$lang.category}</label>
				      <div class="controls">
						{$categories_dropdown}
				      </div>
				    </div>
				    <div class="control-group">
				      <label class="control-label" for="description">{$lang.description}</label>
				      <div class="controls">
						<textarea name="description" class="span5" rows="5">{if $smarty.post.description}{$smarty.post.description}{/if}</textarea>
				      </div>
				    </div>
				    <div class="control-group">
				      <label class="control-label" for="tags">{$lang.tags}</label>
				      <div class="controls">
						<div class="tagsinput">
				          <input id="tags_upload" name="tags" type="text" class="tags" value="{$smarty.post.tags}"> <span class="help-inline"><a href="#" rel="tooltip" title="{$lang.suggest_ex}"><i class="icon-info-sign"></i></a></span>
				        </div>
				      </div>
				    </div>
				    {if isset($mm_upload_fields_inject)}{$mm_upload_fields_inject}{/if}
				    <div class="">
				      <div class="controls">
						<input name="Submit" type="submit" id="Submit" value="{$lang.submit_upload}" class="btn btn-success" data-loading-text="{$lang.submit_send}">
						<span id="uploading_gif">
						</span>
				      </div>
				    </div>
				</div><!-- #upload-video-extra -->
				<div class="alert hide" id="error-placeholder"></div>
			</fieldset>
			</form>
		{/if}
        </div><!-- #primary -->
        </div><!-- .span12 -->
    </div><!-- .row-fluid --> 
  </div>
  </div>
  <!-- .container-fluid -->
{include file='footer.tpl'} 