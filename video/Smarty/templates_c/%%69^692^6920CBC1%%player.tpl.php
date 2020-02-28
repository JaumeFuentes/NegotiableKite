<?php /* Smarty version 2.6.20, created on 2013-03-24 22:08:22
         compiled from player.tpl */ ?>
<?php if ($this->_tpl_vars['video_data']['restricted'] == '1' && ! $this->_tpl_vars['logged_in']): ?>
<div class="restricted-video border-radius4">
    <h2><?php echo $this->_tpl_vars['lang']['restricted_sorry']; ?>
</h2>
	<p><?php echo $this->_tpl_vars['lang']['restricted_register']; ?>
</p>
	<div class="restricted-login">
	<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => 'user-auth-login-form.tpl', 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
    </div>
</div>
<?php else: ?>
<?php if ($this->_tpl_vars['page'] == 'detail'): ?>
  <?php if ($this->_tpl_vars['video_data']['video_player'] == 'flvplayer'): ?>
	<?php echo '
	<div id="Playerholder">
		You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
		a browser with JavaScript support.
	</div>
	<script type="text/javascript">
	var clips = "[ { name: \'ClickToPlay\', overlayId: \'play\' },";
	'; ?>
	
	 <?php if ($this->_tpl_vars['total_video_ads'] > 0): ?>
	  <?php echo ' 
	  
	   clips = clips + "{ name: \'Advertisment\', url: \''; ?>
<?php echo @_URL2; ?>
/videoads.php?h=<?php echo $this->_tpl_vars['video_ad_hash']; ?>
<?php echo '\', linkUrl:  \''; ?>
<?php echo @_URL2; ?>
/videoads.php?h=<?php echo $this->_tpl_vars['video_ad_hash']; ?>
%26tz=t<?php echo '\', linkWindow: \''; ?>
<?php echo $this->_tpl_vars['video_ad_target']; ?>
<?php echo '\', controlEnabled: false, showOnLoadBegin: true },";
	  '; ?>

	 <?php endif; ?>
	<?php echo '
	
	clips = clips + " { name: \''; ?>
<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
<?php echo '\', url: \''; ?>
<?php echo @_URL2; ?>
/videos.php?vid=<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
<?php echo '\' } ]";
	
	var flashvars = {
		config: "{ playList: " + clips + ", useSmoothing: true, baseURL: \'\', autoPlay: '; ?>
<?php echo @_AUTOPLAY; ?>
<?php echo ', autoBuffering: '; ?>
<?php echo @_AUTOBUFF; ?>
<?php echo ', startingBufferLength: 2, bufferLength: 5, loop: false,hideControls: false,initialScale: \'fit\', showPlayListButtons: false, useNativeFullScreen: true,controlBarGloss: \'high\', controlsOverVideo: \'locked\', watermarkUrl: \''; ?>
<?php echo @_WATERMARKURL; ?>
<?php echo '\', showWatermark: \''; ?>
<?php echo @_WATERMARKSHOW; ?>
<?php echo '\', watermarkLinkUrl: \''; ?>
<?php echo @_WATERMARKLINK; ?>
<?php echo '\', controlBarBackgroundColor: \'0x'; ?>
<?php echo @_BGCOLOR; ?>
<?php echo '\', progressBarColor1: \'0xFFFFFF\', progressBarColor2: \'0x000000\', timeDisplayFontColor: \'0x'; ?>
<?php echo @_TIMECOLOR; ?>
<?php echo '\', noVideoClip: { url: \''; ?>
<?php echo @_URL; ?>
/<?php echo @_UPFOLDER; ?>
/notfound.jpg<?php echo '\' }, menuItems: [ false, false, true, true, true, false, false ], showStopButton: true, useHwScaling: false, showOnLoadBegin: true }"
	};
	
	var params = {
		allowfullscreen: "true",
		allowScriptAccess: "always",
		wmode: "opaque"
	};
	var attributes = {};
	swfobject.embedSWF("'; ?>
<?php echo @_URL2; ?>
<?php echo '/player.swf", "Playerholder", "'; ?>
<?php echo @_PLAYER_W; ?>
<?php echo '", "'; ?>
<?php echo @_PLAYER_H; ?>
<?php echo '", "9.0.115", false, flashvars, params, attributes);
	</script>
	'; ?>

	
  <?php elseif ($this->_tpl_vars['video_data']['video_player'] == 'jwplayer'): ?>
  
		<div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
		<?php echo '
			<script type="text/javascript">					
				var flashvars = {
					'; ?>

					<?php if ($this->_tpl_vars['video_data']['source_id'] == 0 || $this->_tpl_vars['video_data']['source_id'] == 0): ?>
						file: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['file']; ?>
',
						streamer: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['streamer']; ?>
',
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['provider'] != ''): ?> provider: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['provider']; ?>
',
						<?php endif; ?>
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['startparam'] != ''): ?> 'http.startparam': '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['startparam']; ?>
',
						<?php endif; ?>
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['loadbalance'] != ''): ?> 'rtmp.loadbalance': '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['loadbalance']; ?>
',
						<?php endif; ?>
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['subscribe'] != ''): ?> 'rtmp.subscribe': '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['subscribe']; ?>
',
						<?php endif; ?>
					<?php elseif ($this->_tpl_vars['video_data']['source_id'] == 3): ?>
						<?php echo '
						file: \''; ?>
<?php echo $this->_tpl_vars['video_data']['direct']; ?>
<?php echo '\',
						'; ?>

					<?php else: ?>		
						<?php echo '
						file: \''; ?>
<?php echo @_URL2; ?>
<?php echo '/videos.php?vid='; ?>
<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
<?php echo '\',
						type: \'video\',
						'; ?>

					<?php endif; ?>
					<?php echo '
					enablejs: \'true\',
					backcolor: \''; ?>
<?php echo @_BGCOLOR; ?>
<?php echo '\',
					frontcolor: \''; ?>
<?php echo @_TIMECOLOR; ?>
<?php echo '\',
					screencolor: \'000000\',
					repeat: \'false\',
					autostart: \''; ?>
<?php echo @_AUTOPLAY; ?>
<?php echo '\', 
					logo: \''; ?>
<?php echo @_WATERMARKURL; ?>
<?php echo '\',
					linktarget: \'_blank\',
					link: \''; ?>
<?php echo @_WATERMARKLINK; ?>
<?php echo '\',
					image: \''; ?>
<?php echo $this->_tpl_vars['video_data']['preview_image']; ?>
<?php echo '\',
					bufferlength: \'5\',
					controlbar: \'bottom\',
                   			\'shownavigation\':\'true\',
					\'skin\': \''; ?>
<?php echo @_URL2; ?>
<?php echo '/skins/'; ?>
<?php echo @_JWSKIN; ?>
<?php echo '\',
					\'plugins\': \''; ?>
<?php echo @_URL2; ?>
<?php echo '/drelated.swf,timeslidertooltipplugin-2,sharing-3\',
					\'sharing.link\': \''; ?>
<?php echo $this->_tpl_vars['video_data']['video_href']; ?>
<?php echo '\',
					\'sharing.code\': encodeURIComponent(\''; ?>
<?php echo $this->_tpl_vars['embedcode']; ?>
<?php echo '\'),
					\'drelated.dxmlpath\': \''; ?>
<?php echo @_URL2; ?>
<?php echo '/relatedclips.php?vid='; ?>
<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
<?php echo '\',
					\'drelated.dposition\': \'center\', // center, bottom, top
					\'drelated.dskin\': \''; ?>
<?php echo @_URL2; ?>
<?php echo '/skins/grayskin2.swf\', //link to the skin
					\'drelated.dtarget\': \'_self\' // where to open the related videos when clicked on
				};
			
				var params = {
					wmode: \'opaque\',
					allowfullscreen: \'true\',
					allowscriptaccess: \'always\',
					allownetworking: \'all\'
				};
	
				var attributes = {
					name: \''; ?>
<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
<?php echo '\',
					id: \''; ?>
<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
<?php echo '\'
				};
				'; ?>
<?php echo $this->_tpl_vars['jw_flashvars_override']; ?>
<?php echo '
				swfobject.embedSWF(\''; ?>
<?php echo @_URL2; ?>
<?php echo '/jwplayer.swf\', \'Playerholder\', \''; ?>
<?php echo @_PLAYER_W; ?>
<?php echo '\', \''; ?>
<?php echo @_PLAYER_H; ?>
<?php echo '\', \'9.0.115\', false, flashvars, params, attributes);
			</script>
	    '; ?>
	
	
  <?php elseif ($this->_tpl_vars['video_data']['video_player'] == 'jwplayer6'): ?>
		<div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
		<?php echo '
		<script type="text/javascript" src="'; ?>
<?php echo @_URL2; ?>
<?php echo '/jwplayer.js"></script>
        <script type="text/javascript">
        	var flashvars = {
                    '; ?>

                        <?php if ($this->_tpl_vars['video_data']['source_id'] == 0 || $this->_tpl_vars['video_data']['source_id'] == 0): ?>
                            file: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['file']; ?>
',
                            streamer: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['streamer']; ?>
',
                            <?php echo 'rtmp: {'; ?>

                            <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['provider'] != ''): ?> provider: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['provider']; ?>
',
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['startparam'] != ''): ?> startparam: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['startparam']; ?>
',
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['loadbalance'] != ''): ?> loadbalance: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['loadbalance']; ?>
',
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['subscribe'] != ''): ?> subscribe: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['subscribe']; ?>
',
                            <?php endif; ?>
                            },
                        <?php elseif ($this->_tpl_vars['video_data']['source_id'] == 3): ?>
                            <?php echo '
                            file: \''; ?>
<?php echo $this->_tpl_vars['video_data']['direct']; ?>
<?php echo '\',
                            '; ?>

                        <?php elseif ($this->_tpl_vars['video_data']['source_id'] == 1): ?>
                            <?php echo '
                            file: \''; ?>
<?php echo @_URL2; ?>
<?php echo '/uploads/videos/'; ?>
<?php echo $this->_tpl_vars['video_data']['url_flv']; ?>
<?php echo '\',
                            '; ?>

        				<?php else: ?>		
                            <?php echo '
                            file: \''; ?>
<?php echo $this->_tpl_vars['video_data']['url_flv']; ?>
<?php echo '\',
                            '; ?>

                        <?php endif; ?>
                        <?php echo '
        				primary: "flash",
                        width: "100%",
                        height: "'; ?>
<?php echo @_PLAYER_H_INDEX; ?>
<?php echo '",
                        image: \''; ?>
<?php echo $this->_tpl_vars['video_data']['preview_image']; ?>
<?php echo '\',
                        sharing: {
                          code: encodeURI(\''; ?>
<?php echo $this->_tpl_vars['embedcode']; ?>
<?php echo '\'),
                          link: "'; ?>
<?php echo $this->_tpl_vars['video_data']['video_href']; ?>
<?php echo '"
                        },
        				autostart: \''; ?>
<?php echo @_AUTOPLAY; ?>
<?php echo '\', 
                    };
                    '; ?>
<?php echo $this->_tpl_vars['jw_flashvars_override']; ?>
<?php echo '
            jwplayer("Playerholder").setup(flashvars);
        </script>
	    '; ?>


  <?php elseif ($this->_tpl_vars['video_data']['video_player'] == 'embed'): ?>
	<?php if ($this->_tpl_vars['total_video_ads'] > 0): ?>
		<?php echo '
		<script type="text/javascript">
		var Player;
		var embed_code = '; ?>
'<?php echo $this->_tpl_vars['video_data']['embed_code']; ?>
'<?php echo ';
	
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
				ajax_request("video", "do=request&vid='; ?>
<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
<?php echo '", "#embed_Playerholder", "html");
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
		var clips = "[ { name: \'ClickToPlay\', overlayId: \'play\' }, { name: \'Advertisment\', url: \''; ?>
<?php echo @_URL2; ?>
/videoads.php?h=<?php echo $this->_tpl_vars['video_ad_hash']; ?>
<?php echo '\', linkUrl:  \''; ?>
<?php echo @_URL2; ?>
/videoads.php?h=<?php echo $this->_tpl_vars['video_ad_hash']; ?>
%26tz=t<?php echo '\', linkWindow: \''; ?>
<?php echo $this->_tpl_vars['video_ad_target']; ?>
<?php echo '\', controlEnabled: false, showOnLoadBegin: true } ]";
		
		var flashvars = {
			config: "{ playList: " + clips + ", useSmoothing: true, baseURL: \'\', autoPlay: '; ?>
<?php echo @_AUTOPLAY; ?>
<?php echo ', autoBuffering: '; ?>
<?php echo @_AUTOBUFF; ?>
<?php echo ', startingBufferLength: 2, bufferLength: 5, loop: false,hideControls: false,initialScale: \'fit\', showPlayListButtons: false, useNativeFullScreen: true,controlBarGloss: \'high\', controlsOverVideo: \'locked\', watermarkUrl: \''; ?>
<?php echo @_WATERMARKURL; ?>
<?php echo '\', showWatermark: \''; ?>
<?php echo @_WATERMARKSHOW; ?>
<?php echo '\', watermarkLinkUrl: \''; ?>
<?php echo @_WATERMARKLINK; ?>
<?php echo '\', controlBarBackgroundColor: \'0x'; ?>
<?php echo @_BGCOLOR; ?>
<?php echo '\', progressBarColor1: \'0xFFFFFF\', progressBarColor2: \'0x000000\', timeDisplayFontColor: \'0x'; ?>
<?php echo @_TIMECOLOR; ?>
<?php echo '\', noVideoClip: { url: \''; ?>
<?php echo @_URL; ?>
/<?php echo @_UPFOLDER; ?>
/notfound.jpg<?php echo '\' }, menuItems: [ false, false, true, true, true, false, false ], showStopButton: true, useHwScaling: false, showOnLoadBegin: true }"
		};
		
		var params = {
			allowfullscreen: "true",
			allowScriptAccess: "always",
			wmode: "opaque"
		};
		var attributes = {};
		
		swfobject.embedSWF("'; ?>
<?php echo @_URL2; ?>
<?php echo '/player.swf", "Playerholder", "'; ?>
<?php echo @_PLAYER_W; ?>
<?php echo '", "'; ?>
<?php echo @_PLAYER_H; ?>
<?php echo '", "9.0.115", false, flashvars, params, attributes);
		</script>
		'; ?>

 	<?php else: ?>
		<div id="Playerholder">
			<noscript>
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
			</noscript>
			<?php echo $this->_tpl_vars['video_data']['embed_code']; ?>

		</div>
    <?php endif; ?>
   <?php endif; ?>
<?php endif; ?>


<?php if ($this->_tpl_vars['page'] == 'index'): ?>
  <?php if ($this->_tpl_vars['video_data']['video_player'] == 'flvplayer'): ?>
		<?php echo '
		<div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
	
		<script type="text/javascript">
	
		var clips = "[ { name: \'ClickToPlay\', overlayId: \'play\' }, { name: \'\', url: \''; ?>
<?php echo @_URL2; ?>
/videos.php?vid=<?php echo $this->_tpl_vars['voth']; ?>
<?php echo '\' } ]";
		
		var flashvars = {
			config: "{ playList: " + clips + ", showPlayList: true,useSmoothing: true, baseURL: \'\', autoPlay: '; ?>
<?php echo @_AUTOPLAY; ?>
<?php echo ', autoBuffering: '; ?>
<?php echo @_AUTOBUFF; ?>
<?php echo ', startingBufferLength: 2, bufferLength: 5, loop: false,hideControls: false,initialScale: \'fit\', showPlayListButtons: false, useNativeFullScreen: true,controlBarGloss: \'high\', controlsOverVideo: \'ease\', controlBarBackgroundColor: \'0x'; ?>
<?php echo @_BGCOLOR; ?>
<?php echo '\', progressBarColor1: \'0xFFFFFF\', progressBarColor2: \'0x000000\', timeDisplayFontColor: \'0x'; ?>
<?php echo @_TIMECOLOR; ?>
<?php echo '\', noVideoClip: { url: \''; ?>
<?php echo @_URL; ?>
/<?php echo @_UPFOLDER; ?>
/notfound.jpg<?php echo '\' },	useHwScaling: false,showMenu: false }"
		};
		var params = {
			allowfullscreen: "true",
			allowScriptAccess: "always",
			wmode: "transparent"
		};
		var attributes = {};
		swfobject.embedSWF("player.swf", "Playerholder", "'; ?>
<?php echo @_PLAYER_W_INDEX; ?>
<?php echo '", "'; ?>
<?php echo @_PLAYER_H_INDEX; ?>
<?php echo '", "9.0.115", false, flashvars, params, attributes);
		</script>
		'; ?>

  
  <?php elseif ($this->_tpl_vars['video_data']['video_player'] == 'jwplayer'): ?>
	   <div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
		<?php echo '
			<script type="text/javascript">
				var flashvars = {
					'; ?>

					<?php if ($this->_tpl_vars['video_data']['source_id'] == 0 || $this->_tpl_vars['video_data']['source_id'] == 0): ?>
						file: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['file']; ?>
',
						streamer: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['streamer']; ?>
',
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['provider'] != ''): ?> provider: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['provider']; ?>
',
						<?php endif; ?>
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['startparam'] != ''): ?> 'http.startparam': '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['startparam']; ?>
',
						<?php endif; ?>
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['loadbalance'] != ''): ?> 'rtmp.loadbalance': '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['loadbalance']; ?>
',
						<?php endif; ?>
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['subscribe'] != ''): ?> 'rtmp.subscribe': '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['subscribe']; ?>
',
						<?php endif; ?>
					<?php elseif ($this->_tpl_vars['video_data']['source_id'] == 3): ?>
						<?php echo '
						file: \''; ?>
<?php echo $this->_tpl_vars['video_data']['direct']; ?>
<?php echo '\',
						'; ?>

					<?php else: ?>		
						<?php echo '
						file: \''; ?>
<?php echo @_URL2; ?>
<?php echo '/videos.php?vid='; ?>
<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
<?php echo '\',
						type: \'video\',
						'; ?>

					<?php endif; ?>
					<?php echo '
					
					enablejs: \'true\',
					backcolor: \''; ?>
<?php echo @_BGCOLOR; ?>
<?php echo '\',
					frontcolor: \''; ?>
<?php echo @_TIMECOLOR; ?>
<?php echo '\',
					screencolor: \'000000\',
					repeat: \'false\',
					autostart: \''; ?>
<?php echo @_AUTOPLAY; ?>
<?php echo '\', 
					logo: \''; ?>
<?php echo @_WATERMARKURL; ?>
<?php echo '\',
					linktarget: \'_blank\',
					link: \''; ?>
<?php echo @_WATERMARKLINK; ?>
<?php echo '\',
					image: \''; ?>
<?php echo $this->_tpl_vars['video_data']['preview_image']; ?>
<?php echo '\',
					bufferlength: \'5\',
					controlbar: \'bottom\',
					\'skin\': \''; ?>
<?php echo @_URL2; ?>
<?php echo '/skins/'; ?>
<?php echo @_JWSKIN; ?>
<?php echo '\',
					\'plugins\': \'timeslidertooltipplugin-2\' 
				};
			
				var params = {
					wmode: \'transparent\',
					allowfullscreen: \'true\',
					allowscriptaccess: \'always\',
					allownetworking: \'all\'
				};

				var attributes = {};
				'; ?>
<?php echo $this->_tpl_vars['jw_flashvars_override']; ?>
<?php echo '
				swfobject.embedSWF(\'jwplayer.swf\', \'Playerholder\', \''; ?>
<?php echo @_PLAYER_W_INDEX; ?>
<?php echo '\', \''; ?>
<?php echo @_PLAYER_H_INDEX; ?>
<?php echo '\', \'9.0.115\', false, flashvars, params, attributes);
			</script>
		'; ?>
	

  <?php elseif ($this->_tpl_vars['video_data']['video_player'] == 'jwplayer6'): ?>
		<div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
		<?php echo '
		<script type="text/javascript" src="'; ?>
<?php echo @_URL2; ?>
<?php echo '/jwplayer.js"></script>
        <script type="text/javascript">
        var flashvars = {
                '; ?>

                    <?php if ($this->_tpl_vars['video_data']['source_id'] == 0 || $this->_tpl_vars['video_data']['source_id'] == 0): ?>
                        file: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['file']; ?>
',
                        streamer: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['streamer']; ?>
',
                        <?php echo 'rtmp: {'; ?>

                        <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['provider'] != ''): ?> provider: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['provider']; ?>
',
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['startparam'] != ''): ?> startparam: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['startparam']; ?>
',
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['loadbalance'] != ''): ?> loadbalance: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['loadbalance']; ?>
',
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['subscribe'] != ''): ?> subscribe: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['subscribe']; ?>
',
                        <?php endif; ?>
                        },
                    <?php elseif ($this->_tpl_vars['video_data']['source_id'] == 3): ?>
                        <?php echo '
                        file: \''; ?>
<?php echo $this->_tpl_vars['video_data']['direct']; ?>
<?php echo '\',
                        '; ?>

                    <?php elseif ($this->_tpl_vars['video_data']['source_id'] == 1): ?>
                        <?php echo '
                        file: \''; ?>
<?php echo @_URL2; ?>
<?php echo '/uploads/videos/'; ?>
<?php echo $this->_tpl_vars['video_data']['url_flv']; ?>
<?php echo '\',
                        '; ?>

    				<?php else: ?>		
                        <?php echo '
                        file: \''; ?>
<?php echo $this->_tpl_vars['video_data']['url_flv']; ?>
<?php echo '\',
                        '; ?>

                    <?php endif; ?>
                    <?php echo '
    				primary: "flash",
                    width: "100%",
                    height: "'; ?>
<?php echo @_PLAYER_H_INDEX; ?>
<?php echo '",
                    image: \''; ?>
<?php echo $this->_tpl_vars['video_data']['preview_image']; ?>
<?php echo '\',
                    sharing: {
                      code: encodeURI(\''; ?>
<?php echo $this->_tpl_vars['embedcode']; ?>
<?php echo '\'),
                      link: "'; ?>
<?php echo $this->_tpl_vars['video_data']['video_href']; ?>
<?php echo '"
                    },
    				autostart: \''; ?>
<?php echo @_AUTOPLAY; ?>
<?php echo '\', 
                };
        '; ?>
<?php echo $this->_tpl_vars['jw_flashvars_override']; ?>
<?php echo '
            jwplayer("Playerholder").setup(flashvars);
        </script>
	    '; ?>

          
  <?php elseif ($this->_tpl_vars['video_data']['video_player'] == 'embed'): ?>
		<div id="Playerholder">
			<noscript>
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
			</noscript>
			<?php echo $this->_tpl_vars['video_data']['embed_code']; ?>

		</div>
   <?php endif; ?>  
<?php endif; ?>


<?php if ($this->_tpl_vars['page'] == 'favorites'): ?>
  <?php if ($this->_tpl_vars['video_data']['video_player'] == 'flvplayer'): ?>
		<div class="playing">
		<div id="embed_Playerholder">
		  <div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		  </div>
		 </div>
		<?php echo '
		<script type="text/javascript">
	
		var clips = "[ { name: \'\', url: \''; ?>
<?php echo @_URL2; ?>
/videos.php?vid=<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
<?php echo '\' } ]";
		
		var flashvars = {
						config: "{ playList: " + clips + ", useSmoothing: true, baseURL: \'\', autoPlay: '; ?>
<?php echo @_AUTOPLAY; ?>
<?php echo ', autoBuffering: '; ?>
<?php echo @_AUTOBUFF; ?>
<?php echo ', startingBufferLength: 2, bufferLength: 5, loop: false,hideControls: false,initialScale: \'fit\', showPlayListButtons: false, useNativeFullScreen: true,controlBarGloss: \'high\', controlsOverVideo: \'locked\', watermarkUrl: \''; ?>
<?php echo @_WATERMARKURL; ?>
<?php echo '\', showWatermark: \''; ?>
<?php echo @_WATERMARKSHOW; ?>
<?php echo '\', watermarkLinkUrl: \''; ?>
<?php echo @_WATERMARKLINK; ?>
<?php echo '\', controlBarBackgroundColor: \'0x'; ?>
<?php echo @_BGCOLOR; ?>
<?php echo '\', progressBarColor1: \'0xFFFFFF\', progressBarColor2: \'0x000000\', timeDisplayFontColor: \'0x'; ?>
<?php echo @_TIMECOLOR; ?>
<?php echo '\', noVideoClip: { url: \''; ?>
<?php echo @_URL; ?>
/<?php echo @_UPFOLDER; ?>
/notfound.jpg<?php echo '\' }, menuItems: [ false, false, true, true, true, false, false ], showStopButton: true, useHwScaling: false, showOnLoadBegin: true }"
					};
		var params = {
						allowfullscreen: "true",
						allowScriptAccess: "always",
						wmode: "transparent"
					};
		var attributes = {};
		swfobject.embedSWF("'; ?>
<?php echo @_URL2; ?>
<?php echo '/player.swf", "Playerholder", "'; ?>
<?php echo @_PLAYER_W_FAVS; ?>
<?php echo '", "'; ?>
<?php echo @_PLAYER_H_FAVS; ?>
<?php echo '", "9.0.115", false, flashvars, params, attributes);
		</script>
		</div>
		'; ?>

		
  <?php elseif ($this->_tpl_vars['video_data']['video_player'] == 'jwplayer'): ?>
  
		<div class="playing">
		<div id="embed_Playerholder">
		  <div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		  </div>
		 </div>
		<?php echo '
			<script type="text/javascript">				        
				var flashvars = {
					'; ?>

					<?php if ($this->_tpl_vars['video_data']['source_id'] == 0 || $this->_tpl_vars['video_data']['source_id'] == 0): ?>
						file: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['file']; ?>
',
						streamer: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['streamer']; ?>
',
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['provider'] != ''): ?> provider: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['provider']; ?>
',
						<?php endif; ?>
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['startparam'] != ''): ?> 'http.startparam': '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['startparam']; ?>
',
						<?php endif; ?>
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['loadbalance'] != ''): ?> 'rtmp.loadbalance': '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['loadbalance']; ?>
',
						<?php endif; ?>
						<?php if ($this->_tpl_vars['video_data']['jw_flashvars']['subscribe'] != ''): ?> 'rtmp.subscribe': '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['subscribe']; ?>
',
						<?php endif; ?>
					<?php elseif ($this->_tpl_vars['video_data']['source_id'] == 3): ?>
						<?php echo '
						file: \''; ?>
<?php echo $this->_tpl_vars['video_data']['direct']; ?>
<?php echo '\',
						'; ?>

					<?php else: ?>		
						<?php echo '
						file: \''; ?>
<?php echo @_URL2; ?>
<?php echo '/videos.php?vid='; ?>
<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
<?php echo '\',
						type: \'video\',
						'; ?>

					<?php endif; ?>
					<?php echo '
					enablejs: \'true\',
					backcolor: \''; ?>
<?php echo @_BGCOLOR; ?>
<?php echo '\',
					frontcolor: \''; ?>
<?php echo @_TIMECOLOR; ?>
<?php echo '\',
					screencolor: \'000000\',
					repeat: \'false\',
					autostart: \''; ?>
<?php echo @_AUTOPLAY; ?>
<?php echo '\', 
					logo: \''; ?>
<?php echo @_WATERMARKURL; ?>
<?php echo '\',
					linktarget: \'_blank\',
					link: \''; ?>
<?php echo @_WATERMARKLINK; ?>
<?php echo '\',
					image: \''; ?>
<?php echo $this->_tpl_vars['video_data']['preview_image']; ?>
<?php echo '\',
					bufferlength: \'5\',
					controlbar: \'bottom\',
					\'skin\': \''; ?>
<?php echo @_URL2; ?>
<?php echo '/skins/'; ?>
<?php echo @_JWSKIN; ?>
<?php echo '\',
					\'plugins\': \'timeslidertooltipplugin-2\' 
				};
			
				var params = {
					wmode: \'transparent\',
					allowfullscreen: \'true\',
					allowscriptaccess: \'always\',
					allownetworking: \'all\'
				};
	
				var attributes = {};
				'; ?>
<?php echo $this->_tpl_vars['jw_flashvars_override']; ?>
<?php echo '
				swfobject.embedSWF(\''; ?>
<?php echo @_URL2; ?>
<?php echo '/jwplayer.swf\', \'Playerholder\', \''; ?>
<?php echo @_PLAYER_W_FAVS; ?>
<?php echo '\', \''; ?>
<?php echo @_PLAYER_H_FAVS; ?>
<?php echo '\', \'9.0.115\', false, flashvars, params, attributes);
			</script>
		</div>
		'; ?>


  <?php elseif ($this->_tpl_vars['video_data']['video_player'] == 'jwplayer6'): ?>
		<div id="Playerholder">
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
		</div>
		<?php echo '
		<script type="text/javascript" src="'; ?>
<?php echo @_URL2; ?>
<?php echo '/jwplayer.js"></script>
        <script type="text/javascript">
        var flashvars = {
                '; ?>

                    <?php if ($this->_tpl_vars['video_data']['source_id'] == 0 || $this->_tpl_vars['video_data']['source_id'] == 0): ?>
                        file: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['file']; ?>
',
                        streamer: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['streamer']; ?>
',
                        <?php echo 'rtmp: {'; ?>

                        <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['provider'] != ''): ?> provider: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['provider']; ?>
',
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['startparam'] != ''): ?> startparam: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['startparam']; ?>
',
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['loadbalance'] != ''): ?> loadbalance: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['loadbalance']; ?>
',
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['video_data']['jw_flashvars']['subscribe'] != ''): ?> subscribe: '<?php echo $this->_tpl_vars['video_data']['jw_flashvars']['subscribe']; ?>
',
                        <?php endif; ?>
                        },
                    <?php elseif ($this->_tpl_vars['video_data']['source_id'] == 3): ?>
                        <?php echo '
                        file: \''; ?>
<?php echo $this->_tpl_vars['video_data']['direct']; ?>
<?php echo '\',
                        '; ?>

                    <?php elseif ($this->_tpl_vars['video_data']['source_id'] == 1): ?>
                        <?php echo '
                        file: \''; ?>
<?php echo @_URL2; ?>
<?php echo '/uploads/videos/'; ?>
<?php echo $this->_tpl_vars['video_data']['url_flv']; ?>
<?php echo '\',
                        '; ?>

    				<?php else: ?>		
                        <?php echo '
                        file: \''; ?>
<?php echo $this->_tpl_vars['video_data']['url_flv']; ?>
<?php echo '\',
                        '; ?>

                    <?php endif; ?>
                    <?php echo '
    				primary: "flash",
                    width: "100%",
                    height: "'; ?>
<?php echo @_PLAYER_H_INDEX; ?>
<?php echo '",
                    image: \''; ?>
<?php echo $this->_tpl_vars['video_data']['preview_image']; ?>
<?php echo '\',
                    sharing: {
                      code: encodeURI(\''; ?>
<?php echo $this->_tpl_vars['embedcode']; ?>
<?php echo '\'),
                      link: "'; ?>
<?php echo $this->_tpl_vars['video_data']['video_href']; ?>
<?php echo '"
                    },
    				autostart: \''; ?>
<?php echo @_AUTOPLAY; ?>
<?php echo '\', 
                };
        '; ?>
<?php echo $this->_tpl_vars['jw_flashvars_override']; ?>
<?php echo '
            jwplayer("Playerholder").setup(flashvars);
        </script>
	    '; ?>
  
  <?php elseif ($this->_tpl_vars['video_data']['video_player'] == 'embed'): ?>
  		
		<div class="playing">
		 <div id="embed_Playerholder">
		  <div id="Playerholder">
			<noscript>
			You need to have the <a href="http://www.macromedia.com/go/getflashplayer">Flash Player</a> installed and
			a browser with JavaScript support.
			</noscript>
			<?php echo $this->_tpl_vars['video_data']['embed_code']; ?>

		  </div>
		 </div>
		 </div>
   <?php endif; ?>
<?php endif; ?>
<?php endif; ?>