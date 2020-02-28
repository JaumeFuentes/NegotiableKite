<?php /* Smarty version 2.6.20, created on 2013-03-25 21:34:34
         compiled from footer.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'footer.tpl', 27, false),)), $this); ?>
<a id="back-top" class="hidden-phone hidden-tablet" title="<?php echo $this->_tpl_vars['lang']['top']; ?>
">
    <i class="icon-chevron-up"></i>
    <span></span>
</a>
</div><!-- end wrapper -->

<?php if ($this->_tpl_vars['ad_2'] != ''): ?>
<div class="pm-ad-zone" align="center"><?php echo $this->_tpl_vars['ad_2']; ?>
</div>
<?php endif; ?>

<footer>
<div class="row-fluid fixed960">
	<div class="span8">
    <ul>
    	<li><a href="<?php echo @_URL; ?>
/index.<?php echo @_FEXT; ?>
"><?php echo $this->_tpl_vars['lang']['homepage']; ?>
</a></li>
        <li><a href="<?php echo @_URL; ?>
/contact_us.<?php echo @_FEXT; ?>
"><?php echo $this->_tpl_vars['lang']['contact_us']; ?>
</a></li>
        <?php if ($this->_tpl_vars['logged_in'] != '1' && $this->_tpl_vars['allow_registration'] == '1'): ?><li><a href="<?php echo @_URL; ?>
/register.<?php echo @_FEXT; ?>
"><?php echo $this->_tpl_vars['lang']['register']; ?>
</a></li><?php endif; ?>
        <?php if ($this->_tpl_vars['logged_in'] == '1' && $this->_tpl_vars['s_power'] == '1'): ?><li><a href="<?php echo @_URL; ?>
/admin/"><?php echo $this->_tpl_vars['lang']['admin_area']; ?>
</a></li><?php endif; ?>
        <?php if (is_array ( $this->_tpl_vars['links_to_pages'] )): ?>
          <?php $_from = $this->_tpl_vars['links_to_pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['page_data']):
?>
            <li><a href="<?php echo $this->_tpl_vars['page_data']['page_url']; ?>
"><?php echo $this->_tpl_vars['page_data']['title']; ?>
</a></li>
          <?php endforeach; endif; unset($_from); ?>
        <?php endif; ?>
    </ul>
    <p>
    <?php if (@_POWEREDBY == 1): ?><?php echo $this->_tpl_vars['lang']['powered_by']; ?>
<br /><?php endif; ?>
    &copy; <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, '%Y') : smarty_modifier_date_format($_tmp, '%Y')); ?>
 <?php echo @_SITENAME; ?>
. <?php echo $this->_tpl_vars['lang']['rights_reserved']; ?>

    </p>
    </div>
    <div class="span3">
	 
    </div>
    <div class="span1">
    <?php if (count ( $this->_tpl_vars['langs_array'] ) > 0): ?>
     <ul id="lang_selector">
      <div class="btn-group dropup lang-selector hidden-phone" id="lang-selector">
      <a class="btn btn-link dropdown-toggle" data-toggle="dropdown" href="#"><img src="<?php echo $this->_tpl_vars['langs_array'][$this->_tpl_vars['current_lang_id']]['ico']; ?>
" width="16" height="10" alt="<?php echo $this->_tpl_vars['langs_array'][$this->_tpl_vars['current_lang_id']]['title']; ?>
" title="<?php echo $this->_tpl_vars['langs_array'][$this->_tpl_vars['current_lang_id']]['title']; ?>
" align="texttop"> <span class="hide"><?php echo $this->_tpl_vars['langs_array'][$this->_tpl_vars['current_lang_id']]['title']; ?>
</span> <span class="caret"></span></a>

      <ul class="dropdown-menu border-radius0 pullleft lang_submenu">
      <?php $_from = $this->_tpl_vars['langs_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['lang']):
?>
       <?php if ($this->_tpl_vars['k'] != $this->_tpl_vars['current_lang_id']): ?>
       <li><a href="#" title="<?php echo $this->_tpl_vars['lang']['title']; ?>
" name="<?php echo $this->_tpl_vars['k']; ?>
" id="lang_select_<?php echo $this->_tpl_vars['k']; ?>
"><?php echo $this->_tpl_vars['lang']['title']; ?>
</a></li>
       <?php endif; ?>
      <?php endforeach; endif; unset($_from); ?>
      </ul>
    <?php endif; ?>
    </div>
</div>
</footer>
<div id="lights-overlay"></div>
</div>

<?php echo '
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/bootstrap.min.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/jquery.cookee.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/jquery.validate.min.js" type="text/javascript"></script>
'; ?>

<?php if ($this->_tpl_vars['p'] == 'index'): ?>
<?php echo '
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/jquery.carouFredSel-5.6.4-packed.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/jquery.touchwipe.min.js" type="text/javascript"></script>
'; ?>

<?php endif; ?>
<?php echo '
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/jquery.maskedinput-1.3.min.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/jquery.tagsinput.min.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/jquery-scrolltofixed-min.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/jquery.uniform.min.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/jquery.ba-dotimeout.min.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
<?php echo '/js/melody.min.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/melody.min.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/lightbox.min.js" type="text/javascript"></script>
'; ?>


<?php if ($this->_tpl_vars['p'] == 'index'): ?>
<?php echo '
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
'; ?>

<?php endif; ?>
<?php if (! $this->_tpl_vars['logged_in']): ?>
    <?php echo '
    <script type="text/javascript">
    
        $(\'#header-login-form\').on(\'shown\', function () {
            $(\'.hocusfocus\').focus();
        });
    
    </script>
    '; ?>

<?php endif; ?>
<?php if (@_MOD_SOCIAL == '1'): ?>
<?php echo '
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/waypoints.min.js" type="text/javascript"></script>
<script src="'; ?>
<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/js/melody.social.min.js" type="text/javascript"></script> 

'; ?>

<?php endif; ?>

<?php if ($this->_tpl_vars['display_preroll_ad'] == true): ?>
<?php echo '
<script src="'; ?>
<?php echo @_URL; ?>
<?php echo '/js/jquery.timer.min.js" type="text/javascript"></script>
<script type="text/javascript">

function timer_pad(number, length) {
	var str = \'\' + number;
	while (str.length < length) {str = \'0\' + str;}
	return str;
}

var preroll_timer;
var preroll_player_called = false; // backup 

$(document).ready(function(){

	var preroll_timer_current = '; ?>
<?php echo $this->_tpl_vars['preroll_ad_data']['duration']; ?>
<?php echo ' * 1000;
	
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
		
		$(\'.preroll_timeleft\').html(output);
		
		if (preroll_timer_current == 0 && preroll_player_called == false) {

			$.ajax({
		        type: "GET",
		        url: MELODYURL2 + "/ajax.php",
				dataType: "html",
		        data: {
					"p": "video",
					"do": "getplayer",
					"vid": "'; ?>
<?php echo $this->_tpl_vars['preroll_ad_player_uniq_id']; ?>
<?php echo '",
					"aid": "'; ?>
<?php echo $this->_tpl_vars['preroll_ad_data']['id']; ?>
<?php echo '",
					"player": "'; ?>
<?php echo $this->_tpl_vars['preroll_ad_player_page']; ?>
<?php echo '"
		        },
		        dataType: "html",
		        success: function(data){
					$(\'#preroll_placeholder\').replaceWith(data);
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

'; ?>

<?php endif; ?>
<?php echo @_HTMLCOUNTER; ?>

</body>
</html>