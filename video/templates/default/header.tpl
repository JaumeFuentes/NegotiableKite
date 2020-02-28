<!DOCTYPE html>
<!--[if IE 7 | IE 8]>
<html class="ie" dir="ltr" lang="en">
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html dir="ltr" lang="en">
<!--<![endif]-->
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=1024,maximum-scale=1.0">
<title>{$meta_title}</title>
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=edge,chrome=1">  
{if $no_index == '1'}
<meta name="robots" content="noindex,nofollow">
<META NAME="GOOGLEBOT" CONTENT="NOINDEX, NOFOLLOW">
{/if}
<meta name="title" content="{$meta_title}" />
<meta name="keywords" content="{$meta_keywords}" />
<meta name="description" content="{$meta_description}" />
<link rel="shortcut icon" href="{$smarty.const._URL}/{$smarty.const._UPFOLDER}/favicon.ico">
{if $rss == "video-category"}
<link rel="alternate" type="application/rss+xml" title="{$meta_title}" href="{$smarty.const._URL}/rss.php?c={$cat_id}" />
{elseif $rss == "article-category"}
<link rel="alternate" type="application/rss+xml" title="{$meta_title}" href="{$smarty.const._URL}/rss.php?c={$cat_id}&feed=articles" />
{/if}

<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" media="screen" href="{$smarty.const._URL}/templates/{$template_dir}/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" media="screen" href="{$smarty.const._URL}/templates/{$template_dir}/css/bootstrap-responsive.min.css">
<!--[if lt IE 9]>
<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" media="screen" href="{$smarty.const._URL}/templates/{$template_dir}/css/new-style.css">
<link rel="stylesheet" type="text/css" media="screen" href="{$smarty.const._URL}/templates/{$template_dir}/css/uniform.default.min.css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,700italic,400,700" rel="stylesheet" type="text/css">
<!--[if IE]>
{literal}
<link rel="stylesheet" type="text/css" media="screen" href="{/literal}{$smarty.const._URL}{literal}/templates/{/literal}{$template_dir}{literal}/css/new-style-ie.css">
{/literal}
<link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:700" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:700italic" rel="stylesheet" type="text/css">
<![endif]-->

<link rel="stylesheet" type="text/css" media="screen" href="{$smarty.const._URL}/../estilos.css">

{literal}
<script type="text/javascript">
	
	var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23066176-2']);
 _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
{/literal}

<script type="text/javascript">
 var MELODYURL = "{$smarty.const._URL}";
 var MELODYURL2 = "{$smarty.const._URL2}";
 var TemplateP = "{$smarty.const._URL}/templates/{$template_dir}";
 var _LOGGEDIN_ = {if $logged_in} true {else} false {/if};
</script>
{literal}
<script type="text/javascript">
 var pm_lang = {
	lights_off: "{/literal}{$lang.lights_off}{literal}",
	lights_on: "{/literal}{$lang.lights_on}{literal}",
	validate_name: "{/literal}{$lang.validate_name}{literal}",
	validate_username: "{/literal}{$lang.validate_username}{literal}",
	validate_pass: "{/literal}{$lang.validate_pass}{literal}",
	validate_captcha: "{/literal}{$lang.validate_captcha}{literal}",
	validate_email: "{/literal}{$lang.validate_email}{literal}",
	validate_agree: "{/literal}{$lang.validate_agree}{literal}",
	validate_name_long: "{/literal}{$lang.validate_name_long}{literal}",
	validate_username_long: "{/literal}{$lang.validate_username_long}{literal}",
	validate_pass_long: "{/literal}{$lang.validate_pass_long}{literal}",
	validate_confirm_pass_long: "{/literal}{$lang.validate_confirm_pass_long}{literal}",
	choose_category: "{/literal}{$lang.choose_category}{literal}",
 	validate_select_file: "{/literal}{$lang.upload_errmsg10}{literal}",
 	validate_video_title: "{/literal}{$lang.validate_video_title}{literal}",
	onpage_delete_favorite_confirm: "{/literal}{$lang.myfavorites_delete_alert_confirm}{literal}",
	please_wait: "{/literal}{$lang.please_wait}{literal}",
 }
</script>
{/literal}

<script type="text/javascript" src="{$smarty.const._URL}/js/swfobject.js"></script>

{if $facebook_image_src != ''}
<link rel="image_src" href="{$facebook_image_src}" />
{if $video_data.source_id == 3}
	<link rel="video_src" href="{$video_data.direct}"/>
{else}
	<link rel="video_src" href="{$smarty.const._URL2}/videos.php?vid={$video_data.uniq_id}"/>
{/if}
<meta property="og:image" content="{$facebook_image_src}" />
{/if}
<style type="text/css">{$theme_customizations}</style>
{if isset($mm_header_inject)}{$mm_header_inject}{/if}



</head>
<body>
{if $maintenance_mode}
	<div class="alert alert-danger" align="center"><strong>Currently running in maintenance mode.</strong></div>
{/if}
{if isset($mm_body_top_inject)}{$mm_body_top_inject}{/if}


<div id="detalle_nk"></div>
<div id="top_negro">
	<ul id="menu">
        <!--<li><a href="/blog">Blog</a></li>-->
        <li><a href="http://www.negotiablekite.com">Inicio</a>
        <li><a href="/anuncios/cometas">Anuncios</a>
        <li><a href="/video">Videos</a>
        <li><a href="/tiendas">Tiendas</a>
        <li><a href="/links">Links</a>
            {$listaLinks}
        </li>
        <li><a href="{$smarty.const._URL}/../contact.html?iframe=true&amp;width=530&amp;height=370" rel="prettyPhoto">Contacto</a></li>
    </ul>
    {if $logged_in != '1'}
    	<div id="registrate_top">
        	<a href="/registro.php">REGISTRATE</a>
        </div>
    {/if}
</div>
<div id="cuerpo">


<header class="wide-header" id="overview">
<div class="row-fluid fixed960">
    <div class="span3" style="width:88px;">
	  {if $_custom_logo_url != ''}
	  	<a href="{$smarty.const._URL}/index.{$smarty.const._FEXT}" rel="home"><img src="{$_custom_logo_url}" alt="{$smarty.const._SITENAME}" title="{$smarty.const._SITENAME}" border="0" /></a>
	  {else}
      	<h1 class="site-title"><a href="{$smarty.const._URL}/index.{$smarty.const._FEXT}" rel="home">{$smarty.const._SITENAME}</a></h1>
	  {/if}
   </div>
   <div id="tit_slo"></div>
   <div class="span3 hidden-phone" style="float:right; width:21%">
    <div id="user-pane" class="border-radius4">
        <div class="user-data">
        <span class="user-avatar">
        {if $logged_in != '1'}
        <a href="{$smarty.const._URL}/login.{$smarty.const._FEXT}"><img src="{$smarty.const._URL}/templates/{$template_dir}/img/pm-avatar.png" width="40" height="40" alt=""></a>
        <span class="greet-links">
        <div class="ellipsis"><strong>{$lang._welcome}</strong></div>
        <span class="avatar-img"><a class="primary ajax-modal" data-toggle="modal" data-backdrop="true" data-keyboard="true" href="#header-login-form">{$lang.login}</a>{if $allow_registration == '1'} / <a href="{$smarty.const._URL}/register.{$smarty.const._FEXT}">{$lang.register}</a>{/if}</span>
        </span>
        </div>
        {else}        
        <span class="avatar-img">
        {if $smarty.const._MOD_SOCIAL && $logged_in && $notification_count > 0}
        	<span class="notifications border-radius3">{$notification_count}</span>
        {else}
        {/if}
        <a href="#" id="notification_counter" title="{$lang.notifications}"><img src="{$s_avatar_url}" width="40" height="40" alt=""></a>
        </span>
        
        <span class="greet-links">
        <div class="ellipsis"><strong><a href="{$smarty.const._URL}/profile.php?u={$s_username}">{$s_name}</a></strong></div>
        {if $smarty.const._ALLOW_USER_SUGGESTVIDEO == '1'}<a href="{$smarty.const._URL}/suggest.{$smarty.const._FEXT}">{$lang.suggest}</a>{/if}{if $smarty.const._ALLOW_USER_UPLOADVIDEO == '1' && $smarty.const._ALLOW_USER_SUGGESTVIDEO == '1'} / {/if}{if $smarty.const._ALLOW_USER_UPLOADVIDEO == '1'} <a href="{$smarty.const._URL}/upload.{$smarty.const._FEXT}">{$lang.upload}</a>{/if}
        </span>
        </div>
        <div class="user-menu dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="#"><i class="icon-chevron-down"></i></a>
            <ul class="dropdown-menu pull-right pm-ul-user-menu" role="menu" aria-labelledby="dLabel">
            {if $is_admin == 'yes' || $is_moderator == 'yes' || $is_editor == 'yes'}
            <li><a href="{$smarty.const._URL}/admin/index.php">{$lang.admin_area}</a></li>
            {/if}
            <li><a tabindex="-1" href="{$smarty.const._URL}/edit_profile.{$smarty.const._FEXT}">{$lang.edit_profile}</a></li>
            {if $smarty.const._ALLOW_USER_SUGGESTVIDEO == '1'}
            <li><a tabindex="-1" href="{$smarty.const._URL}/suggest.{$smarty.const._FEXT}">{$lang.suggest}</a></li>
            {/if}
            {if $smarty.const._ALLOW_USER_UPLOADVIDEO == '1'}
            <li><a tabindex="-1" href="{$smarty.const._URL}/upload.{$smarty.const._FEXT}">{$lang.upload_video}</a></li>
            {/if}
            <li><a tabindex="-1" href="{$smarty.const._URL}/favorites.php?a=show">{$lang.my_favorites}</a></li>
            <li><a tabindex="-1" href="{$smarty.const._URL}/memberlist.{$smarty.const._FEXT}">{$lang.members_list}</a></li>
            {if isset($mm_menu_logged_inject)}{$mm_menu_logged_inject}{/if}
            <li class="divider"></li>
            <li><a tabindex="-1" href="{$smarty.const._URL}/login.{$smarty.const._FEXT}?do=logout">{$lang.logout}</a></li>
            </ul>
        </div>
        {/if}
        </span>
    
        {if ! $logged_in}
        <div class="modal hide" id="header-login-form" role="dialog" aria-labelledby="header-login-form-label"> <!-- login modal -->
            <div class="modal-header">
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                  <h3 id="header-login-form-label">Login</h3>
            </div>
            <div class="modal-body">
                <p></p>
                {include file="user-auth-login-form.tpl"}
            </div>
        </div>
        {/if}
    </div>
    
	{if $smarty.const._MOD_SOCIAL && $logged_in}<!--//$notification_count > 0}-->
		<div class="hide" id="notification_temporary_display_container"></div>
	{/if}
    </div>
   <div class="span6 wide-header-pad">
    {if $p == "article"}
    <form style="margin:0;" action="{$smarty.const._URL}/article.php" method="get" id="search" name="search" onsubmit="return validateSearch('true');">
    <div class="controls">
      <div class="input-append">
        <input class="span10" id="appendedInputButton" size="16" name="keywords" type="text" placeholder="{$lang.submit_search}" x-webkit-speech speech onwebkitspeechchange="this.form.submit();"><button class="btn" type="submit"><i class="icon-search"></i></button>
      </div>
    </div>
    </form>
    {else}
    <form style="margin:0;" action="{$smarty.const._URL}/search.php" method="get" id="search" name="search" onsubmit="return validateSearch('true');">
    <div class="controls">
      <div class="input-append">
        <input class="span10" id="appendedInputButton" size="16" name="keywords" type="text" placeholder="{$lang.submit_search}" x-webkit-speech="x-webkit-speech" onwebkitspeechchange="this.form.submit();" {if $smarty.const._SEARCHSUGGEST == 1}onkeyup="lookup(this.value);" onblur="fill();" autocomplete="off"{/if}><button class="btn" type="submit"><i class="icon-search"></i></button>
      </div>
      <div class="suggestionsBox" id="suggestions" style="display: none;">
          <div class="suggestionList input-xlarge" id="autoSuggestionsList">
          </div>
      </div>
    </div>
    </form>
    {/if}
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
                    
                      <li><a href="{$smarty.const._URL}/index.{$smarty.const._FEXT}" class="wide-nav-link">{$lang.homepage}</a></li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle wide-nav-link" data-toggle="dropdown">{$lang.category} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                        {dropdown_menu_video_categories}
                        </ul>
                      </li>
                      
					  {if $smarty.const._MOD_ARTICLE == 1}
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle wide-nav-link" data-toggle="dropdown">{$lang.articles} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
						{dropdown_menu_article_categories}
                        </ul>
                      </li>
					  {/if}
                      <li><a href="{$smarty.const._URL}/topvideos.{$smarty.const._FEXT}" class="wide-nav-link">{$lang.top_videos}</a></li>
                      <li><a href="{$smarty.const._URL}/newvideos.{$smarty.const._FEXT}" class="wide-nav-link">{$lang.new_videos}</a></li>
                      <li><a href="{$smarty.const._URL}/randomizer.php" rel="nofollow" class="wide-nav-link">{$lang.random_video}</a></li>
                      {if isset($mm_menu_always_inject1)}{$mm_menu_always_inject1}{/if}		
                      <li><a href="{$smarty.const._URL}/contact_us.{$smarty.const._FEXT}" class="wide-nav-link">{$lang.contact_us}</a></li>
                      {if isset($mm_menu_always_inject2)}{$mm_menu_always_inject2}{/if}		
                      {if $logged_in != 1 && isset($mm_menu_notlogged_inject)}{$mm_menu_notlogged_inject}{/if}
                    </ul>
                    {if is_array($links_to_pages)}
                    <ul class="nav pull-right">
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle wide-nav-link" data-toggle="dropdown">{$lang.pages} <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                              {foreach from=$links_to_pages key=k item=page_data}
                                <li><a href="{$page_data.page_url}">{$page_data.title}</a></li>
                              {/foreach}
                        </ul>
                      </li>
                    </ul>
                    {/if}

                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div><!-- /navbar -->
       </span>
    </div>
</nav>
<a id="top"></a>
{if $ad_1 != ''}
<div class="pm-ad-zone" align="center">{$ad_1}</div>
{/if}