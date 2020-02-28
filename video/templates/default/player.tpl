{if $video_data.restricted == '1' && ! $logged_in}
<div class="restricted-video border-radius4">
    <h2>{$lang.restricted_sorry}</h2>
	<p>{$lang.restricted_register}</p>
	<div class="restricted-login">
	{include file='user-auth-login-form.tpl'}
    </div>
</div>
{else}
{if $page == "detail"}
  {if $video_data.video_player == "flvplayer"}
	{literal}
	<div id="Playerholder">
		You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
		a browser with JavaScript support.
	</div>
	<script type="text/javascript">
	var clips = "[ { name: 'ClickToPlay', overlayId: 'play' },";
	{/literal}	
	 {if $total_video_ads > 0}
	  {literal} 
	  
	   clips = clips + "{ name: 'Advertisment', url: '{/literal}{$smarty.const._URL2}/videoads.php?h={$video_ad_hash}{literal}', linkUrl:  '{/literal}{$smarty.const._URL2}/videoads.php?h={$video_ad_hash}%26tz=t{literal}', linkWindow: '{/literal}{$video_ad_target}{literal}', controlEnabled: false, showOnLoadBegin: true },";
	  {/literal}
	 {/if}
	{literal}
	
	clips = clips + " { name: '{/literal}{$video_data.uniq_id}{literal}', url: '{/literal}{$smarty.const._URL2}/videos.php?vid={$video_data.uniq_id}{literal}' } ]";
	
	var flashvars = {
		config: "{ playList: " + clips + ", useSmoothing: true, baseURL: '', autoPlay: {/literal}{$smarty.const._AUTOPLAY}{literal}, autoBuffering: {/literal}{$smarty.const._AUTOBUFF}{literal}, startingBufferLength: 2, bufferLength: 5, loop: false,hideControls: false,initialScale: 'fit', showPlayListButtons: false, useNativeFullScreen: true,controlBarGloss: 'high', controlsOverVideo: 'locked', watermarkUrl: '{/literal}{$smarty.const._WATERMARKURL}{literal}', showWatermark: '{/literal}{$smarty.const._WATERMARKSHOW}{literal}', watermarkLinkUrl: '{/literal}{$smarty.const._WATERMARKLINK}{literal}', controlBarBackgroundColor: '0x{/literal}{$smarty.const._BGCOLOR}{literal}', progressBarColor1: '0xFFFFFF', progressBarColor2: '0x000000', timeDisplayFontColor: '0x{/literal}{$smarty.const._TIMECOLOR}{literal}', noVideoClip: { url: '{/literal}{$smarty.const._URL}/{$smarty.const._UPFOLDER}/notfound.jpg{literal}' }, menuItems: [ false, false, true, true, true, false, false ], showStopButton: true, useHwScaling: false, showOnLoadBegin: true }"
	};
	
	var params = {
		allowfullscreen: "true",
		allowScriptAccess: "always",
		wmode: "opaque"
	};
	var attributes = {};
	swfobject.embedSWF("{/literal}{$smarty.const._URL2}{literal}/player.swf", "Playerholder", "{/literal}{$smarty.const._PLAYER_W}{literal}", "{/literal}{$smarty.const._PLAYER_H}{literal}", "9.0.115", false, flashvars, params, attributes);
	</script>
	{/literal}
	
  {elseif $video_data.video_player == "jwplayer"}
  
		<div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
		{literal}
			<script type="text/javascript">					
				var flashvars = {
					{/literal}
					{if $video_data.source_id == 0 || $video_data.source_id == 0}
						file: '{$video_data.jw_flashvars.file}',
						streamer: '{$video_data.jw_flashvars.streamer}',
						{if $video_data.jw_flashvars.provider != ''} provider: '{$video_data.jw_flashvars.provider}',
						{/if}
						{if $video_data.jw_flashvars.startparam != ''} 'http.startparam': '{$video_data.jw_flashvars.startparam}',
						{/if}
						{if $video_data.jw_flashvars.loadbalance != ''} 'rtmp.loadbalance': '{$video_data.jw_flashvars.loadbalance}',
						{/if}
						{if $video_data.jw_flashvars.subscribe != ''} 'rtmp.subscribe': '{$video_data.jw_flashvars.subscribe}',
						{/if}
					{elseif $video_data.source_id == 3}
						{literal}
						file: '{/literal}{$video_data.direct}{literal}',
						{/literal}
					{else}		
						{literal}
						file: '{/literal}{$smarty.const._URL2}{literal}/videos.php?vid={/literal}{$video_data.uniq_id}{literal}',
						type: 'video',
						{/literal}
					{/if}
					{literal}
					enablejs: 'true',
					backcolor: '{/literal}{$smarty.const._BGCOLOR}{literal}',
					frontcolor: '{/literal}{$smarty.const._TIMECOLOR}{literal}',
					screencolor: '000000',
					repeat: 'false',
					autostart: '{/literal}{$smarty.const._AUTOPLAY}{literal}', 
					logo: '{/literal}{$smarty.const._WATERMARKURL}{literal}',
					linktarget: '_blank',
					link: '{/literal}{$smarty.const._WATERMARKLINK}{literal}',
					image: '{/literal}{$video_data.preview_image}{literal}',
					bufferlength: '5',
					controlbar: 'bottom',
                   			'shownavigation':'true',
					'skin': '{/literal}{$smarty.const._URL2}{literal}/skins/{/literal}{$smarty.const._JWSKIN}{literal}',
					'plugins': '{/literal}{$smarty.const._URL2}{literal}/drelated.swf,timeslidertooltipplugin-2,sharing-3',
					'sharing.link': '{/literal}{$video_data.video_href}{literal}',
					'sharing.code': encodeURIComponent('{/literal}{$embedcode}{literal}'),
					'drelated.dxmlpath': '{/literal}{$smarty.const._URL2}{literal}/relatedclips.php?vid={/literal}{$video_data.uniq_id}{literal}',
					'drelated.dposition': 'center', // center, bottom, top
					'drelated.dskin': '{/literal}{$smarty.const._URL2}{literal}/skins/grayskin2.swf', //link to the skin
					'drelated.dtarget': '_self' // where to open the related videos when clicked on
				};
			
				var params = {
					wmode: 'opaque',
					allowfullscreen: 'true',
					allowscriptaccess: 'always',
					allownetworking: 'all'
				};
	
				var attributes = {
					name: '{/literal}{$video_data.uniq_id}{literal}',
					id: '{/literal}{$video_data.uniq_id}{literal}'
				};
				{/literal}{$jw_flashvars_override}{literal}
				swfobject.embedSWF('{/literal}{$smarty.const._URL2}{literal}/jwplayer.swf', 'Playerholder', '{/literal}{$smarty.const._PLAYER_W}{literal}', '{/literal}{$smarty.const._PLAYER_H}{literal}', '9.0.115', false, flashvars, params, attributes);
			</script>
	    {/literal}	
	
  {elseif $video_data.video_player == "jwplayer6"}
		<div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
		{literal}
		<script type="text/javascript" src="{/literal}{$smarty.const._URL2}{literal}/jwplayer.js"></script>
        <script type="text/javascript">
        	var flashvars = {
                    {/literal}
                        {if $video_data.source_id == 0 || $video_data.source_id == 0}
                            file: '{$video_data.jw_flashvars.file}',
                            streamer: '{$video_data.jw_flashvars.streamer}',
                            {literal}rtmp: {{/literal}
                            {if $video_data.jw_flashvars.provider != ''} provider: '{$video_data.jw_flashvars.provider}',
                            {/if}
                            {if $video_data.jw_flashvars.startparam != ''} startparam: '{$video_data.jw_flashvars.startparam}',
                            {/if}
                            {if $video_data.jw_flashvars.loadbalance != ''} loadbalance: '{$video_data.jw_flashvars.loadbalance}',
                            {/if}
                            {if $video_data.jw_flashvars.subscribe != ''} subscribe: '{$video_data.jw_flashvars.subscribe}',
                            {/if}
                            },
                        {elseif $video_data.source_id == 3}
                            {literal}
                            file: '{/literal}{$video_data.direct}{literal}',
                            {/literal}
                        {elseif $video_data.source_id == 1}
                            {literal}
                            file: '{/literal}{$smarty.const._URL2}{literal}/uploads/videos/{/literal}{$video_data.url_flv}{literal}',
                            {/literal}
        				{else}		
                            {literal}
                            file: '{/literal}{$video_data.url_flv}{literal}',
                            {/literal}
                        {/if}
                        {literal}
        				primary: "flash",
                        width: "100%",
                        height: "{/literal}{$smarty.const._PLAYER_H_INDEX}{literal}",
                        image: '{/literal}{$video_data.preview_image}{literal}',
                        sharing: {
                          code: encodeURI('{/literal}{$embedcode}{literal}'),
                          link: "{/literal}{$video_data.video_href}{literal}"
                        },
        				autostart: '{/literal}{$smarty.const._AUTOPLAY}{literal}', 
                    };
                    {/literal}{$jw_flashvars_override}{literal}
            jwplayer("Playerholder").setup(flashvars);
        </script>
	    {/literal}

  {elseif $video_data.video_player == "embed"}
	{if $total_video_ads > 0}
		{literal}
		<script type="text/javascript">
		var Player;
		var embed_code = {/literal}'{$video_data.embed_code}'{literal};
	
		function init() {
			if (document.getElementById) {
				Player = document.getElementById("Playerholder");
			}
		}
		// wait for the page to fully load before initializing
		window.onload = init;
		
		function onClipDone(clip) {
			if (clip.name == "Advertisment") {
				Player.DoStop();
				swfobject.removeSWF("Playerholder");
				ajax_request("video", "do=request&vid={/literal}{$video_data.uniq_id}{literal}", "#embed_Playerholder", "html");
			}
		}
		</script>
		<div id="embed_Playerholder">
		 <div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		 </div>
		</div>
	
		<script type="text/javascript">
		var clips = "[ { name: 'ClickToPlay', overlayId: 'play' }, { name: 'Advertisment', url: '{/literal}{$smarty.const._URL2}/videoads.php?h={$video_ad_hash}{literal}', linkUrl:  '{/literal}{$smarty.const._URL2}/videoads.php?h={$video_ad_hash}%26tz=t{literal}', linkWindow: '{/literal}{$video_ad_target}{literal}', controlEnabled: false, showOnLoadBegin: true } ]";
		
		var flashvars = {
			config: "{ playList: " + clips + ", useSmoothing: true, baseURL: '', autoPlay: {/literal}{$smarty.const._AUTOPLAY}{literal}, autoBuffering: {/literal}{$smarty.const._AUTOBUFF}{literal}, startingBufferLength: 2, bufferLength: 5, loop: false,hideControls: false,initialScale: 'fit', showPlayListButtons: false, useNativeFullScreen: true,controlBarGloss: 'high', controlsOverVideo: 'locked', watermarkUrl: '{/literal}{$smarty.const._WATERMARKURL}{literal}', showWatermark: '{/literal}{$smarty.const._WATERMARKSHOW}{literal}', watermarkLinkUrl: '{/literal}{$smarty.const._WATERMARKLINK}{literal}', controlBarBackgroundColor: '0x{/literal}{$smarty.const._BGCOLOR}{literal}', progressBarColor1: '0xFFFFFF', progressBarColor2: '0x000000', timeDisplayFontColor: '0x{/literal}{$smarty.const._TIMECOLOR}{literal}', noVideoClip: { url: '{/literal}{$smarty.const._URL}/{$smarty.const._UPFOLDER}/notfound.jpg{literal}' }, menuItems: [ false, false, true, true, true, false, false ], showStopButton: true, useHwScaling: false, showOnLoadBegin: true }"
		};
		
		var params = {
			allowfullscreen: "true",
			allowScriptAccess: "always",
			wmode: "opaque"
		};
		var attributes = {};
		
		swfobject.embedSWF("{/literal}{$smarty.const._URL2}{literal}/player.swf", "Playerholder", "{/literal}{$smarty.const._PLAYER_W}{literal}", "{/literal}{$smarty.const._PLAYER_H}{literal}", "9.0.115", false, flashvars, params, attributes);
		</script>
		{/literal}
 	{else}
		<div id="Playerholder">
			<noscript>
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
			</noscript>
			{$video_data.embed_code}
		</div>
    {/if}
   {/if}
{/if}


{if $page == "index"}
  {if $video_data.video_player == "flvplayer"}
		{literal}
		<div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
	
		<script type="text/javascript">
	
		var clips = "[ { name: 'ClickToPlay', overlayId: 'play' }, { name: '', url: '{/literal}{$smarty.const._URL2}/videos.php?vid={$voth}{literal}' } ]";
		
		var flashvars = {
			config: "{ playList: " + clips + ", showPlayList: true,useSmoothing: true, baseURL: '', autoPlay: {/literal}{$smarty.const._AUTOPLAY}{literal}, autoBuffering: {/literal}{$smarty.const._AUTOBUFF}{literal}, startingBufferLength: 2, bufferLength: 5, loop: false,hideControls: false,initialScale: 'fit', showPlayListButtons: false, useNativeFullScreen: true,controlBarGloss: 'high', controlsOverVideo: 'ease', controlBarBackgroundColor: '0x{/literal}{$smarty.const._BGCOLOR}{literal}', progressBarColor1: '0xFFFFFF', progressBarColor2: '0x000000', timeDisplayFontColor: '0x{/literal}{$smarty.const._TIMECOLOR}{literal}', noVideoClip: { url: '{/literal}{$smarty.const._URL}/{$smarty.const._UPFOLDER}/notfound.jpg{literal}' },	useHwScaling: false,showMenu: false }"
		};
		var params = {
			allowfullscreen: "true",
			allowScriptAccess: "always",
			wmode: "transparent"
		};
		var attributes = {};
		swfobject.embedSWF("player.swf", "Playerholder", "{/literal}{$smarty.const._PLAYER_W_INDEX}{literal}", "{/literal}{$smarty.const._PLAYER_H_INDEX}{literal}", "9.0.115", false, flashvars, params, attributes);
		</script>
		{/literal}
  
  {elseif $video_data.video_player == "jwplayer"}
	   <div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
		{literal}
			<script type="text/javascript">
				var flashvars = {
					{/literal}
					{if $video_data.source_id == 0 || $video_data.source_id == 0}
						file: '{$video_data.jw_flashvars.file}',
						streamer: '{$video_data.jw_flashvars.streamer}',
						{if $video_data.jw_flashvars.provider != ''} provider: '{$video_data.jw_flashvars.provider}',
						{/if}
						{if $video_data.jw_flashvars.startparam != ''} 'http.startparam': '{$video_data.jw_flashvars.startparam}',
						{/if}
						{if $video_data.jw_flashvars.loadbalance != ''} 'rtmp.loadbalance': '{$video_data.jw_flashvars.loadbalance}',
						{/if}
						{if $video_data.jw_flashvars.subscribe != ''} 'rtmp.subscribe': '{$video_data.jw_flashvars.subscribe}',
						{/if}
					{elseif $video_data.source_id == 3}
						{literal}
						file: '{/literal}{$video_data.direct}{literal}',
						{/literal}
					{else}		
						{literal}
						file: '{/literal}{$smarty.const._URL2}{literal}/videos.php?vid={/literal}{$video_data.uniq_id}{literal}',
						type: 'video',
						{/literal}
					{/if}
					{literal}
					
					enablejs: 'true',
					backcolor: '{/literal}{$smarty.const._BGCOLOR}{literal}',
					frontcolor: '{/literal}{$smarty.const._TIMECOLOR}{literal}',
					screencolor: '000000',
					repeat: 'false',
					autostart: '{/literal}{$smarty.const._AUTOPLAY}{literal}', 
					logo: '{/literal}{$smarty.const._WATERMARKURL}{literal}',
					linktarget: '_blank',
					link: '{/literal}{$smarty.const._WATERMARKLINK}{literal}',
					image: '{/literal}{$video_data.preview_image}{literal}',
					bufferlength: '5',
					controlbar: 'bottom',
					'skin': '{/literal}{$smarty.const._URL2}{literal}/skins/{/literal}{$smarty.const._JWSKIN}{literal}',
					'plugins': 'timeslidertooltipplugin-2' 
				};
			
				var params = {
					wmode: 'transparent',
					allowfullscreen: 'true',
					allowscriptaccess: 'always',
					allownetworking: 'all'
				};

				var attributes = {};
				{/literal}{$jw_flashvars_override}{literal}
				swfobject.embedSWF('jwplayer.swf', 'Playerholder', '{/literal}{$smarty.const._PLAYER_W_INDEX}{literal}', '{/literal}{$smarty.const._PLAYER_H_INDEX}{literal}', '9.0.115', false, flashvars, params, attributes);
			</script>
		{/literal}	

  {elseif $video_data.video_player == "jwplayer6"}
		<div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
		{literal}
		<script type="text/javascript" src="{/literal}{$smarty.const._URL2}{literal}/jwplayer.js"></script>
        <script type="text/javascript">
        var flashvars = {
                {/literal}
                    {if $video_data.source_id == 0 || $video_data.source_id == 0}
                        file: '{$video_data.jw_flashvars.file}',
                        streamer: '{$video_data.jw_flashvars.streamer}',
                        {literal}rtmp: {{/literal}
                        {if $video_data.jw_flashvars.provider != ''} provider: '{$video_data.jw_flashvars.provider}',
                        {/if}
                        {if $video_data.jw_flashvars.startparam != ''} startparam: '{$video_data.jw_flashvars.startparam}',
                        {/if}
                        {if $video_data.jw_flashvars.loadbalance != ''} loadbalance: '{$video_data.jw_flashvars.loadbalance}',
                        {/if}
                        {if $video_data.jw_flashvars.subscribe != ''} subscribe: '{$video_data.jw_flashvars.subscribe}',
                        {/if}
                        },
                    {elseif $video_data.source_id == 3}
                        {literal}
                        file: '{/literal}{$video_data.direct}{literal}',
                        {/literal}
                    {elseif $video_data.source_id == 1}
                        {literal}
                        file: '{/literal}{$smarty.const._URL2}{literal}/uploads/videos/{/literal}{$video_data.url_flv}{literal}',
                        {/literal}
    				{else}		
                        {literal}
                        file: '{/literal}{$video_data.url_flv}{literal}',
                        {/literal}
                    {/if}
                    {literal}
    				primary: "flash",
                    width: "100%",
                    height: "{/literal}{$smarty.const._PLAYER_H_INDEX}{literal}",
                    image: '{/literal}{$video_data.preview_image}{literal}',
                    sharing: {
                      code: encodeURI('{/literal}{$embedcode}{literal}'),
                      link: "{/literal}{$video_data.video_href}{literal}"
                    },
    				autostart: '{/literal}{$smarty.const._AUTOPLAY}{literal}', 
                };
        {/literal}{$jw_flashvars_override}{literal}
            jwplayer("Playerholder").setup(flashvars);
        </script>
	    {/literal}
          
  {elseif $video_data.video_player == "embed"}
		<div id="Playerholder">
			<noscript>
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
			</noscript>
			{$video_data.embed_code}
		</div>
   {/if}  
{/if}


{if $page == "favorites"}
  {if $video_data.video_player == "flvplayer"}
		<div class="playing">
		<div id="embed_Playerholder">
		  <div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		  </div>
		 </div>
		{literal}
		<script type="text/javascript">
	
		var clips = "[ { name: '', url: '{/literal}{$smarty.const._URL2}/videos.php?vid={$video_data.uniq_id}{literal}' } ]";
		
		var flashvars = {
						config: "{ playList: " + clips + ", useSmoothing: true, baseURL: '', autoPlay: {/literal}{$smarty.const._AUTOPLAY}{literal}, autoBuffering: {/literal}{$smarty.const._AUTOBUFF}{literal}, startingBufferLength: 2, bufferLength: 5, loop: false,hideControls: false,initialScale: 'fit', showPlayListButtons: false, useNativeFullScreen: true,controlBarGloss: 'high', controlsOverVideo: 'locked', watermarkUrl: '{/literal}{$smarty.const._WATERMARKURL}{literal}', showWatermark: '{/literal}{$smarty.const._WATERMARKSHOW}{literal}', watermarkLinkUrl: '{/literal}{$smarty.const._WATERMARKLINK}{literal}', controlBarBackgroundColor: '0x{/literal}{$smarty.const._BGCOLOR}{literal}', progressBarColor1: '0xFFFFFF', progressBarColor2: '0x000000', timeDisplayFontColor: '0x{/literal}{$smarty.const._TIMECOLOR}{literal}', noVideoClip: { url: '{/literal}{$smarty.const._URL}/{$smarty.const._UPFOLDER}/notfound.jpg{literal}' }, menuItems: [ false, false, true, true, true, false, false ], showStopButton: true, useHwScaling: false, showOnLoadBegin: true }"
					};
		var params = {
						allowfullscreen: "true",
						allowScriptAccess: "always",
						wmode: "transparent"
					};
		var attributes = {};
		swfobject.embedSWF("{/literal}{$smarty.const._URL2}{literal}/player.swf", "Playerholder", "{/literal}{$smarty.const._PLAYER_W_FAVS}{literal}", "{/literal}{$smarty.const._PLAYER_H_FAVS}{literal}", "9.0.115", false, flashvars, params, attributes);
		</script>
		</div>
		{/literal}
		
  {elseif $video_data.video_player == "jwplayer"}
  
		<div class="playing">
		<div id="embed_Playerholder">
		  <div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		  </div>
		 </div>
		{literal}
			<script type="text/javascript">				        
				var flashvars = {
					{/literal}
					{if $video_data.source_id == 0 || $video_data.source_id == 0}
						file: '{$video_data.jw_flashvars.file}',
						streamer: '{$video_data.jw_flashvars.streamer}',
						{if $video_data.jw_flashvars.provider != ''} provider: '{$video_data.jw_flashvars.provider}',
						{/if}
						{if $video_data.jw_flashvars.startparam != ''} 'http.startparam': '{$video_data.jw_flashvars.startparam}',
						{/if}
						{if $video_data.jw_flashvars.loadbalance != ''} 'rtmp.loadbalance': '{$video_data.jw_flashvars.loadbalance}',
						{/if}
						{if $video_data.jw_flashvars.subscribe != ''} 'rtmp.subscribe': '{$video_data.jw_flashvars.subscribe}',
						{/if}
					{elseif $video_data.source_id == 3}
						{literal}
						file: '{/literal}{$video_data.direct}{literal}',
						{/literal}
					{else}		
						{literal}
						file: '{/literal}{$smarty.const._URL2}{literal}/videos.php?vid={/literal}{$video_data.uniq_id}{literal}',
						type: 'video',
						{/literal}
					{/if}
					{literal}
					enablejs: 'true',
					backcolor: '{/literal}{$smarty.const._BGCOLOR}{literal}',
					frontcolor: '{/literal}{$smarty.const._TIMECOLOR}{literal}',
					screencolor: '000000',
					repeat: 'false',
					autostart: '{/literal}{$smarty.const._AUTOPLAY}{literal}', 
					logo: '{/literal}{$smarty.const._WATERMARKURL}{literal}',
					linktarget: '_blank',
					link: '{/literal}{$smarty.const._WATERMARKLINK}{literal}',
					image: '{/literal}{$video_data.preview_image}{literal}',
					bufferlength: '5',
					controlbar: 'bottom',
					'skin': '{/literal}{$smarty.const._URL2}{literal}/skins/{/literal}{$smarty.const._JWSKIN}{literal}',
					'plugins': 'timeslidertooltipplugin-2' 
				};
			
				var params = {
					wmode: 'transparent',
					allowfullscreen: 'true',
					allowscriptaccess: 'always',
					allownetworking: 'all'
				};
	
				var attributes = {};
				{/literal}{$jw_flashvars_override}{literal}
				swfobject.embedSWF('{/literal}{$smarty.const._URL2}{literal}/jwplayer.swf', 'Playerholder', '{/literal}{$smarty.const._PLAYER_W_FAVS}{literal}', '{/literal}{$smarty.const._PLAYER_H_FAVS}{literal}', '9.0.115', false, flashvars, params, attributes);
			</script>
		</div>
		{/literal}

  {elseif $video_data.video_player == "jwplayer6"}
		<div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
		{literal}
		<script type="text/javascript" src="{/literal}{$smarty.const._URL2}{literal}/jwplayer.js"></script>
        <script type="text/javascript">
        var flashvars = {
                {/literal}
                    {if $video_data.source_id == 0 || $video_data.source_id == 0}
                        file: '{$video_data.jw_flashvars.file}',
                        streamer: '{$video_data.jw_flashvars.streamer}',
                        {literal}rtmp: {{/literal}
                        {if $video_data.jw_flashvars.provider != ''} provider: '{$video_data.jw_flashvars.provider}',
                        {/if}
                        {if $video_data.jw_flashvars.startparam != ''} startparam: '{$video_data.jw_flashvars.startparam}',
                        {/if}
                        {if $video_data.jw_flashvars.loadbalance != ''} loadbalance: '{$video_data.jw_flashvars.loadbalance}',
                        {/if}
                        {if $video_data.jw_flashvars.subscribe != ''} subscribe: '{$video_data.jw_flashvars.subscribe}',
                        {/if}
                        },
                    {elseif $video_data.source_id == 3}
                        {literal}
                        file: '{/literal}{$video_data.direct}{literal}',
                        {/literal}
                    {elseif $video_data.source_id == 1}
                        {literal}
                        file: '{/literal}{$smarty.const._URL2}{literal}/uploads/videos/{/literal}{$video_data.url_flv}{literal}',
                        {/literal}
    				{else}		
                        {literal}
                        file: '{/literal}{$video_data.url_flv}{literal}',
                        {/literal}
                    {/if}
                    {literal}
    				primary: "flash",
                    width: "100%",
                    height: "{/literal}{$smarty.const._PLAYER_H_INDEX}{literal}",
                    image: '{/literal}{$video_data.preview_image}{literal}',
                    sharing: {
                      code: encodeURI('{/literal}{$embedcode}{literal}'),
                      link: "{/literal}{$video_data.video_href}{literal}"
                    },
    				autostart: '{/literal}{$smarty.const._AUTOPLAY}{literal}', 
                };
        {/literal}{$jw_flashvars_override}{literal}
            jwplayer("Playerholder").setup(flashvars);
        </script>
	    {/literal}  
  {elseif $video_data.video_player == "embed"}
  		
		<div class="playing">
		 <div id="embed_Playerholder">
		  <div id="Playerholder">
			<noscript>
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
			</noscript>
			{$video_data.embed_code}
		  </div>
		 </div>
		 </div>
   {/if}
{/if}
{/if}