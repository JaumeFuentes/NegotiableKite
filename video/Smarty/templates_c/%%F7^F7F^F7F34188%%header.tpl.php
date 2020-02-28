<?php /* Smarty version 2.6.20, created on 2013-03-26 17:38:14
         compiled from header.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'dropdown_menu_video_categories', 'header.tpl', 262, false),array('function', 'dropdown_menu_article_categories', 'header.tpl', 270, false),)), $this); ?>
<?php $this->_cache_serials['/home/superchauen/web/negotiablekite/video/Smarty/templates_c/%%F7^F7F^F7F34188%%header.tpl.inc'] = 'a9c15fc0f0dc6962ac99272a401cdd92'; ?>﻿<!DOCTYPE html>
<!--[if IE 7 | IE 8]>
<html class="ie" dir="ltr" lang="en">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html dir="ltr" lang="en">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=1024,maximum-scale=1.0">
<title><?php echo $this->_tpl_vars['meta_title']; ?>
</title>
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=edge,chrome=1">  
<?php if ($this->_tpl_vars['no_index'] == '1'): ?>
<meta name="robots" content="noindex,nofollow">
<META NAME="GOOGLEBOT" CONTENT="NOINDEX, NOFOLLOW">
<?php endif; ?>
<meta name="title" content="<?php echo $this->_tpl_vars['meta_title']; ?>
" />
<meta name="keywords" content="<?php echo $this->_tpl_vars['meta_keywords']; ?>
" />
<meta name="description" content="<?php echo $this->_tpl_vars['meta_description']; ?>
" />
<link rel="shortcut icon" href="<?php echo @_URL; ?>
/<?php echo @_UPFOLDER; ?>
/favicon.ico">
<?php if ($this->_tpl_vars['rss'] == "video-category"): ?>
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->_tpl_vars['meta_title']; ?>
" href="<?php echo @_URL; ?>
/rss.php?c=<?php echo $this->_tpl_vars['cat_id']; ?>
" />
<?php elseif ($this->_tpl_vars['rss'] == "article-category"): ?>
<link rel="alternate" type="application/rss+xml" title="<?php echo $this->_tpl_vars['meta_title']; ?>
" href="<?php echo @_URL; ?>
/rss.php?c=<?php echo $this->_tpl_vars['cat_id']; ?>
&feed=articles" />
<?php endif; ?>

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/css/bootstrap-responsive.min.css">
<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/css/new-style.css">
<link rel="stylesheet" type="text/css" media="screen" href="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/css/uniform.default.min.css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700" rel="stylesheet" type="text/css">
<!--[if IE]>
<?php echo '
<link rel="stylesheet" type="text/css" media="screen" href="'; ?>
<?php echo @_URL; ?>
<?php echo '/templates/'; ?>
<?php echo $this->_tpl_vars['template_dir']; ?>
<?php echo '/css/new-style-ie.css">
'; ?>

<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:700italic" rel="stylesheet" type="text/css">
<![endif]-->

<link rel="stylesheet" type="text/css" media="screen" href="<?php echo @_URL; ?>
/../estilos.css">

<?php echo '
<script type="text/javascript">
	
	var _gaq = _gaq || [];
  _gaq.push([\'_setAccount\', \'UA-23066176-2\']);
 _gaq.push([\'_trackPageview\']);

  (function() {
    var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;
    ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';
    var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
'; ?>


<script type="text/javascript">
 var MELODYURL = "<?php echo @_URL; ?>
";
 var MELODYURL2 = "<?php echo @_URL2; ?>
";
 var TemplateP = "<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
";
 var _LOGGEDIN_ = <?php if ($this->_tpl_vars['logged_in']): ?> true <?php else: ?> false <?php endif; ?>;
</script>
<?php echo '
<script type="text/javascript">
 var pm_lang = {
	lights_off: "'; ?>
<?php echo $this->_tpl_vars['lang']['lights_off']; ?>
<?php echo '",
	lights_on: "'; ?>
<?php echo $this->_tpl_vars['lang']['lights_on']; ?>
<?php echo '",
	validate_name: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_name']; ?>
<?php echo '",
	validate_username: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_username']; ?>
<?php echo '",
	validate_pass: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_pass']; ?>
<?php echo '",
	validate_captcha: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_captcha']; ?>
<?php echo '",
	validate_email: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_email']; ?>
<?php echo '",
	validate_agree: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_agree']; ?>
<?php echo '",
	validate_name_long: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_name_long']; ?>
<?php echo '",
	validate_username_long: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_username_long']; ?>
<?php echo '",
	validate_pass_long: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_pass_long']; ?>
<?php echo '",
	validate_confirm_pass_long: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_confirm_pass_long']; ?>
<?php echo '",
	choose_category: "'; ?>
<?php echo $this->_tpl_vars['lang']['choose_category']; ?>
<?php echo '",
 	validate_select_file: "'; ?>
<?php echo $this->_tpl_vars['lang']['upload_errmsg10']; ?>
<?php echo '",
 	validate_video_title: "'; ?>
<?php echo $this->_tpl_vars['lang']['validate_video_title']; ?>
<?php echo '",
	onpage_delete_favorite_confirm: "'; ?>
<?php echo $this->_tpl_vars['lang']['myfavorites_delete_alert_confirm']; ?>
<?php echo '",
	please_wait: "'; ?>
<?php echo $this->_tpl_vars['lang']['please_wait']; ?>
<?php echo '",
 }
</script>
'; ?>


<script type="text/javascript" src="<?php echo @_URL; ?>
/js/swfobject.js"></script>

<?php if ($this->_tpl_vars['facebook_image_src'] != ''): ?>
<link rel="image_src" href="<?php echo $this->_tpl_vars['facebook_image_src']; ?>
" />
<?php if ($this->_tpl_vars['video_data']['source_id'] == 3): ?>
	<link rel="video_src" href="<?php echo $this->_tpl_vars['video_data']['direct']; ?>
"/>
<?php else: ?>
	<link rel="video_src" href="<?php echo @_URL2; ?>
/videos.php?vid=<?php echo $this->_tpl_vars['video_data']['uniq_id']; ?>
"/>
<?php endif; ?>
<meta property="og:image" content="<?php echo $this->_tpl_vars['facebook_image_src']; ?>
" />
<?php endif; ?>
<style type="text/css"><?php echo $this->_tpl_vars['theme_customizations']; ?>
</style>
<?php if (isset ( $this->_tpl_vars['mm_header_inject'] )): ?><?php echo $this->_tpl_vars['mm_header_inject']; ?>
<?php endif; ?>



</head>
<body>
<?php if ($this->_tpl_vars['maintenance_mode']): ?>
	<div class="alert alert-danger" align="center"><strong>Currently running in maintenance mode.</strong></div>
<?php endif; ?>
<?php if (isset ( $this->_tpl_vars['mm_body_top_inject'] )): ?><?php echo $this->_tpl_vars['mm_body_top_inject']; ?>
<?php endif; ?>


<div id="detalle_nk"></div>
<div id="top_negro">
	<ul id="menu">
        <!--<li><a href="/blog">Blog</a></li>-->
        <li><a href="http://www.negotiablekite.com">Inicio</a>
        <li><a href="/anuncios/cometas">Anuncios</a>
        <li><a href="/video">Videos</a>
        <li><a href="/tiendas">Tiendas</a>
        <li><a href="/links">Links</a>
            <?php echo $this->_tpl_vars['listaLinks']; ?>

        </li>
        <li><a href="<?php echo @_URL; ?>
/../contact.html?iframe=true&amp;width=530&amp;height=370" rel="prettyPhoto">Contacto</a></li>
    </ul>
    <?php if ($this->_tpl_vars['logged_in'] != '1'): ?>
    	<div id="registrate_top">
        	<a href="/registro.php">REGISTRATE</a>
        </div>
    <?php endif; ?>
</div>
<div id="cuerpo">


<header class="wide-header" id="overview">
<div class="row-fluid fixed960">
    <div class="span3" style="width:88px;">
	  <?php if ($this->_tpl_vars['_custom_logo_url'] != ''): ?>
	  	<a href="<?php echo @_URL; ?>
/index.<?php echo @_FEXT; ?>
" rel="home"><img src="<?php echo $this->_tpl_vars['_custom_logo_url']; ?>
" alt="<?php echo @_SITENAME; ?>
" title="<?php echo @_SITENAME; ?>
" border="0" /></a>
	  <?php else: ?>
      	<h1 class="site-title"><a href="<?php echo @_URL; ?>
/index.<?php echo @_FEXT; ?>
" rel="home"><?php echo @_SITENAME; ?>
</a></h1>
	  <?php endif; ?>
   </div>
   <div id="tit_slo"></div>
   <div class="span3 hidden-phone" style="float:right; width:21%">
    <div id="user-pane" class="border-radius4">
        <div class="user-data">
        <span class="user-avatar">
        <?php if ($this->_tpl_vars['logged_in'] != '1'): ?>
        <a href="<?php echo @_URL; ?>
/login.<?php echo @_FEXT; ?>
"><img src="<?php echo @_URL; ?>
/templates/<?php echo $this->_tpl_vars['template_dir']; ?>
/img/pm-avatar.png" width="40" height="40" alt=""></a>
        <span class="greet-links">
        <div class="ellipsis"><strong><?php echo $this->_tpl_vars['lang']['_welcome']; ?>
</strong></div>
        <span class="avatar-img"><a class="primary ajax-modal" data-toggle="modal" data-backdrop="true" data-keyboard="true" href="#header-login-form"><?php echo $this->_tpl_vars['lang']['login']; ?>
</a><?php if ($this->_tpl_vars['allow_registration'] == '1'): ?> / <a href="<?php echo @_URL; ?>
/register.<?php echo @_FEXT; ?>
"><?php echo $this->_tpl_vars['lang']['register']; ?>
</a><?php endif; ?></span>
        </span>
        </div>
        <?php else: ?>        
        <span class="avatar-img">
        <?php if (@_MOD_SOCIAL && $this->_tpl_vars['logged_in'] && $this->_tpl_vars['notification_count'] > 0): ?>
        	<span class="notifications border-radius3"><?php echo $this->_tpl_vars['notification_count']; ?>
</span>
        <?php else: ?>
        <?php endif; ?>
        <a href="#" id="notification_counter" title="<?php echo $this->_tpl_vars['lang']['notifications']; ?>
"><img src="<?php echo $this->_tpl_vars['s_avatar_url']; ?>
" width="40" height="40" alt=""></a>
        </span>
        
        <span class="greet-links">
        <div class="ellipsis"><strong><a href="<?php echo @_URL; ?>
/profile.php?u=<?php echo $this->_tpl_vars['s_username']; ?>
"><?php echo $this->_tpl_vars['s_name']; ?>
</a></strong></div>
        <?php if (@_ALLOW_USER_SUGGESTVIDEO == '1'): ?><a href="<?php echo @_URL; ?>
/suggest.<?php echo @_FEXT; ?>
"><?php echo $this->_tpl_vars['lang']['suggest']; ?>
</a><?php endif; ?><?php if (@_ALLOW_USER_UPLOADVIDEO == '1' && @_ALLOW_USER_SUGGESTVIDEO == '1'): ?> / <?php endif; ?><?php if (@_ALLOW_USER_UPLOADVIDEO == '1'): ?> <a href="<?php echo @_URL; ?>
/upload.<?php echo @_FEXT; ?>
"><?php echo $this->_tpl_vars['lang']['upload']; ?>
</a><?php endif; ?>
        </span>
        </div>
        <div class="user-menu dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#"><i class="icon-chevron-down"></i></a>
            <ul class="dropdown-menu pull-right pm-ul-user-menu" role="menu" aria-labelledby="dLabel">
            <?php if ($this->_tpl_vars['is_admin'] == 'yes' || $this->_tpl_vars['is_moderator'] == 'yes' || $this->_tpl_vars['is_editor'] == 'yes'): ?>
            <li><a href="<?php echo @_URL; ?>
/admin/index.php"><?php echo $this->_tpl_vars['lang']['admin_area']; ?>
</a></li>
            <?php endif; ?>
            <li><a tabindex="-1" href="<?php echo @_URL; ?>
/edit_profile.<?php echo @_FEXT; ?>
"><?php echo $this->_tpl_vars['lang']['edit_profile']; ?>
</a></li>
            <?php if (@_ALLOW_USER_SUGGESTVIDEO == '1'): ?>
            <li><a tabindex="-1" href="<?php echo @_URL; ?>
/suggest.<?php echo @_FEXT; ?>
"><?php echo $this->_tpl_vars['lang']['suggest']; ?>
</a></li>
            <?php endif; ?>
            <?php if (@_ALLOW_USER_UPLOADVIDEO == '1'): ?>
            <li><a tabindex="-1" href="<?php echo @_URL; ?>
/upload.<?php echo @_FEXT; ?>
"><?php echo $this->_tpl_vars['lang']['upload_video']; ?>
</a></li>
            <?php endif; ?>
            <li><a tabindex="-1" href="<?php echo @_URL; ?>
/favorites.php?a=show"><?php echo $this->_tpl_vars['lang']['my_favorites']; ?>
</a></li>
            <li><a tabindex="-1" href="<?php echo @_URL; ?>
/memberlist.<?php echo @_FEXT; ?>
"><?php echo $this->_tpl_vars['lang']['members_list']; ?>
</a></li>
            <?php if (isset ( $this->_tpl_vars['mm_menu_logged_inject'] )): ?><?php echo $this->_tpl_vars['mm_menu_logged_inject']; ?>
<?php endif; ?>
            <li class="divider"></li>
            <li><a tabindex="-1" href="<?php echo @_URL; ?>
/login.<?php echo @_FEXT; ?>
?do=logout"><?php echo $this->_tpl_vars['lang']['logout']; ?>
</a></li>
            </ul>
        </div>
        <?php endif; ?>
        </span>
    
        <?php if (! $this->_tpl_vars['logged_in']): ?>
        <div class="modal hide" id="header-login-form" role="dialog" aria-labelledby="header-login-form-label"> <!-- login modal -->
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h3 id="header-login-form-label">Login</h3>
            </div>
            <div class="modal-body">
                <p></p>
                <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include(array('smarty_include_tpl_file' => "user-auth-login-form.tpl", 'smarty_include_vars' => array()));
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    
	<?php if (@_MOD_SOCIAL && $this->_tpl_vars['logged_in']): ?><!--//$notification_count > 0}-->
		<div class="hide" id="notification_temporary_display_container"></div>
	<?php endif; ?>
    </div>
   <div class="span6 wide-header-pad">
    <?php if ($this->_tpl_vars['p'] == 'article'): ?>
    <form style="margin:0;" action="<?php echo @_URL; ?>
/article.php" method="get" id="search" name="search" onsubmit="return validateSearch('true');">
    <div class="controls">
      <div class="input-append">
        <input class="span10" id="appendedInputButton" size="16" name="keywords" type="text" placeholder="<?php echo $this->_tpl_vars['lang']['submit_search']; ?>
" x-webkit-speech speech onwebkitspeechchange="this.form.submit();"><button class="btn" type="submit"><i class="icon-search"></i></button>
      </div>
    </div>
    </form>
    <?php else: ?>
    <form style="margin:0;" action="<?php echo @_URL; ?>
/search.php" method="get" id="search" name="search" onsubmit="return validateSearch('true');">
    <div class="controls">
      <div class="input-append">
        <input class="span10" id="appendedInputButton" size="16" name="keywords" type="text" placeholder="<?php echo $this->_tpl_vars['lang']['submit_search']; ?>
" x-webkit-speech="x-webkit-speech" onwebkitspeechchange="this.form.submit();" <?php if (@_SEARCHSUGGEST == 1): ?>onkeyup="lookup(this.value);" onblur="fill();" autocomplete="off"<?php endif; ?>><button class="btn" type="submit"><i class="icon-search"></i></button>
      </div>
      <div class="suggestionsBox" id="suggestions" style="display: none;">
          <div class="suggestionList input-xlarge" id="autoSuggestionsList">
          </div>
      </div>
    </div>
    </form>
    <?php endif; ?>
   </div>

    
</div>
</header>
<nav class="wide-nav">
    <div class="row-fluid fixed960">
        <span class="span12">
		<div class="navbar">
              <div class="navbar-inner">
                <div class="container">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <div class="nav-collapse">
                    <ul class="nav">
                    
                      <li><a href="<?php echo @_URL; ?>
/index.<?php echo @_FEXT; ?>
" class="wide-nav-link"><?php echo $this->_tpl_vars['lang']['homepage']; ?>
</a></li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle wide-nav-link" data-toggle="dropdown"><?php echo $this->_tpl_vars['lang']['category']; ?>
 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        <?php echo list_categories(array(), $this);?>

                        </ul>
                      </li>
                      
					  <?php if (@_MOD_ARTICLE == 1): ?>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle wide-nav-link" data-toggle="dropdown"><?php echo $this->_tpl_vars['lang']['articles']; ?>
 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
						<?php if ($this->caching && !$this->_cache_including): echo '{nocache:a9c15fc0f0dc6962ac99272a401cdd92#0}'; endif;echo smarty_art_html_list_categories(array(), $this);if ($this->caching && !$this->_cache_including): echo '{/nocache:a9c15fc0f0dc6962ac99272a401cdd92#0}'; endif;?>

                        </ul>
                      </li>
					  <?php endif; ?>
                      <li><a href="<?php echo @_URL; ?>
/topvideos.<?php echo @_FEXT; ?>
" class="wide-nav-link"><?php echo $this->_tpl_vars['lang']['top_videos']; ?>
</a></li>
                      <li><a href="<?php echo @_URL; ?>
/newvideos.<?php echo @_FEXT; ?>
" class="wide-nav-link"><?php echo $this->_tpl_vars['lang']['new_videos']; ?>
</a></li>
                      <li><a href="<?php echo @_URL; ?>
/randomizer.php" rel="nofollow" class="wide-nav-link"><?php echo $this->_tpl_vars['lang']['random_video']; ?>
</a></li>
                      <?php if (isset ( $this->_tpl_vars['mm_menu_always_inject1'] )): ?><?php echo $this->_tpl_vars['mm_menu_always_inject1']; ?>
<?php endif; ?>		
                      <li><a href="<?php echo @_URL; ?>
/contact_us.<?php echo @_FEXT; ?>
" class="wide-nav-link"><?php echo $this->_tpl_vars['lang']['contact_us']; ?>
</a></li>
                      <?php if (isset ( $this->_tpl_vars['mm_menu_always_inject2'] )): ?><?php echo $this->_tpl_vars['mm_menu_always_inject2']; ?>
<?php endif; ?>		
                      <?php if ($this->_tpl_vars['logged_in'] != 1 && isset ( $this->_tpl_vars['mm_menu_notlogged_inject'] )): ?><?php echo $this->_tpl_vars['mm_menu_notlogged_inject']; ?>
<?php endif; ?>
                    </ul>
                    <?php if (is_array ( $this->_tpl_vars['links_to_pages'] )): ?>
                    <ul class="nav pull-right">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle wide-nav-link" data-toggle="dropdown"><?php echo $this->_tpl_vars['lang']['pages']; ?>
 <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                              <?php $_from = $this->_tpl_vars['links_to_pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['k'] => $this->_tpl_vars['page_data']):
?>
                                <li><a href="<?php echo $this->_tpl_vars['page_data']['page_url']; ?>
"><?php echo $this->_tpl_vars['page_data']['title']; ?>
</a></li>
                              <?php endforeach; endif; unset($_from); ?>
                        </ul>
                      </li>
                    </ul>
                    <?php endif; ?>

                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div><!-- /navbar -->
       </span>
    </div>
</nav>
<a id="top"></a>
<?php if ($this->_tpl_vars['ad_1'] != ''): ?>
<div class="pm-ad-zone" align="center"><?php echo $this->_tpl_vars['ad_1']; ?>
</div>
<?php endif; ?>