<a id="back-top" class="hidden-phone hidden-tablet" title="{$lang.top}">
    <i class="icon-chevron-up"></i>
    <span></span>
</a>
</div><!-- end wrapper -->

{if $ad_2 != ''}
<div class="pm-ad-zone" align="center">{$ad_2}</div>
{/if}

<footer>
<div class="row-fluid fixed960">
	<div class="span8">
    <ul>
    	<li><a href="{$smarty.const._URL}/index.{$smarty.const._FEXT}">{$lang.homepage}</a></li>
        <li><a href="{$smarty.const._URL}/contact_us.{$smarty.const._FEXT}">{$lang.contact_us}</a></li>
        {if $logged_in != '1' && $allow_registration == '1'}<li><a href="{$smarty.const._URL}/register.{$smarty.const._FEXT}">{$lang.register}</a></li>{/if}
        {if $logged_in == '1' && $s_power == '1'}<li><a href="{$smarty.const._URL}/admin/">{$lang.admin_area}</a></li>{/if}
        {if is_array($links_to_pages)}
          {foreach from=$links_to_pages key=k item=page_data}
            <li><a href="{$page_data.page_url}">{$page_data.title}</a></li>
          {/foreach}
        {/if}
    </ul>
    <p>
    {if $smarty.const._POWEREDBY == 1}{$lang.powered_by}<br />{/if}
    &copy; {$smarty.now|date_format:'%Y'} {$smarty.const._SITENAME}. {$lang.rights_reserved}
    </p>
    </div>
    <div class="span3">
	 
    </div>
    <div class="span1">
    {if count($langs_array) > 0}
     <ul id="lang_selector">
      <div class="btn-group dropup lang-selector hidden-phone" id="lang-selector">
      <a class="btn btn-link dropdown-toggle" data-toggle="dropdown" href="#"><img src="{$langs_array.$current_lang_id.ico}" width="16" height="10" alt="{$langs_array.$current_lang_id.title}" title="{$langs_array.$current_lang_id.title}" align="texttop"> <span class="hide">{$langs_array.$current_lang_id.title}</span> <span class="caret"></span></a>

      <ul class="dropdown-menu border-radius0 pullleft lang_submenu">
      {foreach from=$langs_array item=lang key=k}
       {if $k != $current_lang_id}
       <li><a href="#" title="{$lang.title}" name="{$k}" id="lang_select_{$k}">{$lang.title}</a></li>
       {/if}
      {/foreach}
      </ul>
    {/if}
    </div>
</div>
</footer>
<div id="lights-overlay"></div>
</div>

{literal}
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/bootstrap.min.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/jquery.cookee.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/jquery.validate.min.js" type="text/javascript"></script>
{/literal}
{if $p == "index"}
{literal}
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/jquery.carouFredSel-5.6.4-packed.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/jquery.touchwipe.min.js" type="text/javascript"></script>
{/literal}
{/if}
{literal}
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/jquery.tagsinput.min.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/jquery-scrolltofixed-min.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/jquery.uniform.min.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/jquery.ba-dotimeout.min.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}{literal}/js/melody.min.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/melody.min.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/lightbox.min.js" type="text/javascript"></script>
{/literal}

{if $p == "index"}
{literal}
<script type="text/javascript">
$(document).ready(function() {
	$("#pm-ul-wn-videos").carouFredSel({
		items				: 4,
		circular			: false,
		direction			: "left",
		height				: null,
		width       		: null,
		infinite			: false,
		responsive			: true,
		prev	: {	
			button	: "#pm-slide-prev",
			key		: "left"
		},
		next	: { 
			button	: "#pm-slide-next",
			key		: "right"
		},
	scroll		: {
		items			: null,		//	items.visible
		fx				: "scroll",
		easing			: "elastic",
		duration		: 400,
		wipe			: true,
		event			: "click",
	},
	auto: false
				
	});	
});

$(document).ready(function() {
	$("#pm-ul-top-videos").carouFredSel({
	items: 5,
	direction: "up",
	width: "variable",
	height:  "variable",
	circular: false,
	infinite: false,
	scroll: {
		fx: "fade",
		event: "click",
		wipe: true,
		duration: 150
	},
	auto: false,
		prev	: {	
			button	: "#pm-slide-top-prev",
			key		: "left"
		},
		next	: { 
			button	: "#pm-slide-top-next",
			key		: "right"
		}
	});	
});
</script>
{/literal}
{/if}
{if ! $logged_in}
    {literal}
    <script type="text/javascript">
    
        $('#header-login-form').on('shown', function () {
            $('.hocusfocus').focus();
        });
    
    </script>
    {/literal}
{/if}
{if $smarty.const._MOD_SOCIAL == '1'}
{literal}
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/waypoints.min.js" type="text/javascript"></script>
<script src="{/literal}{$smarty.const._URL}/templates/{$template_dir}{literal}/js/melody.social.min.js" type="text/javascript"></script> 

{/literal}
{/if}

{if $display_preroll_ad == true}
{literal}
<script src="{/literal}{$smarty.const._URL}{literal}/js/jquery.timer.min.js" type="text/javascript"></script>
<script type="text/javascript">

function timer_pad(number, length) {
	var str = '' + number;
	while (str.length < length) {str = '0' + str;}
	return str;
}

var preroll_timer;
var preroll_player_called = false; // backup 

$(document).ready(function(){

	var preroll_timer_current = {/literal}{$preroll_ad_data.duration}{literal} * 1000;
	
	preroll_timer = $.timer(function(){
	
		var seconds = parseInt(preroll_timer_current / 1000);
		var hours = parseInt(seconds / 3600);
		var minutes = parseInt((seconds / 60) % 60);
		var seconds = parseInt(seconds % 60);
		
		var output = "00";
		if (hours > 0) {
			output = timer_pad(hours, 2) +":"+ timer_pad(minutes, 2) +":"+ timer_pad(seconds, 2);
		} else if (minutes > 0) { 
			output = timer_pad(minutes, 2) +":"+ timer_pad(seconds, 2);
		} else {
			output = timer_pad(seconds, 1);
		}
		
		$('.preroll_timeleft').html(output);
		
		if (preroll_timer_current == 0 && preroll_player_called == false) {

			$.ajax({
		        type: "GET",
		        url: MELODYURL2 + "/ajax.php",
				dataType: "html",
		        data: {
					"p": "video",
					"do": "getplayer",
					"vid": "{/literal}{$preroll_ad_player_uniq_id}{literal}",
					"aid": "{/literal}{$preroll_ad_data.id}{literal}",
					"player": "{/literal}{$preroll_ad_player_page}{literal}"
		        },
		        dataType: "html",
		        success: function(data){
					$('#preroll_placeholder').replaceWith(data);
		        }
			});
			
			preroll_player_called = true;
			preroll_timer.stop();
		} else {
			preroll_timer_current -= 1000;
			if(preroll_timer_current < 0) {
				preroll_timer_current = 0;
			}
		}
	}, 1000, true);
});
</script>

{/literal}
{/if}
{$smarty.const._HTMLCOUNTER}
</body>
</html>