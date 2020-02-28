<?php
// +------------------------------------------------------------------------+
// | PHP Melody ( www.phpsugar.com )
// +------------------------------------------------------------------------+
// | PHP Melody IS NOT FREE SOFTWARE
// | If you have downloaded this software from a website other
// | than www.phpsugar.com or if you have received
// | this software from someone who is not a representative of
// | PHPSUGAR, you are involved in an illegal activity.
// | ---
// | In such case, please contact: support@phpsugar.com.
// +------------------------------------------------------------------------+
// | Developed by: PHPSUGAR (www.phpsugar.com) / support@phpsugar.com
// | Copyright: (c) 2004-2013 PHPSUGAR. All rights reserved.
// +------------------------------------------------------------------------+

session_start();
require('config.php');
require_once('include/functions.php');
require_once('include/user_functions.php');
require_once('include/islogged.php');
$modframework->trigger_hook('suggest_top');

if ($config['allow_user_suggestvideo'] == '0')
{
	header('Location: '. _URL .'/index.'. _FEXT);
	exit();
}

if( !is_user_logged_in() )
{
	header("Location: "._URL. "/login."._FEXT);
	exit();
}

// define meta tags
$meta_title = $lang['suggest'];
$meta_description = '';
$form_action = 'suggest.'._FEXT;

$sources	  =	fetch_video_sources();
$temp = array();

foreach ($sources as $id => $src)
{
	if (is_int($id) && $id > 2 && $id != 14)
	{
		if ($src['source_name'] != 'quicktime' && $src['source_name'] != 'windows media player')
		{
			$temp[$id] = $src;
		}
	}
}
$sources = $temp;
unset($temp);


$countries_list = array();

if(isset($_POST['Submit'])) { // Submit new video
	$required_fields = array('yt_id' => "URL",
							 'category' => $lang['category'],
							 'video_title' => $lang['video'], 
							 );
	foreach( $_POST as $key => $value) {
		$value = trim($value);
		if(array_key_exists(strtolower($key), $required_fields) && empty($value) )
			$errors[$key] = $required_fields[$key]." ".$lang['register_err_msg8'];
		$_POST[$k] = htmlspecialchars($value);
	}
	if($_POST['category'] == '-1') {
		$errors['category'] = $lang['choose_category'];
	}
	//	check if the source is available
	$url = trim($_POST['yt_id']);
	$url = str_replace('https', 'http', $url);
	$url = str_replace('youtu.be/', 'youtube.com/watch?v=', $url);
	
	//$sources	  =	fetch_video_sources();
	$use_this_src = -1;
	
	$modframework->trigger_hook('suggest_validate');
	foreach($sources as $src_id => $source)
	{
		if($source['source_name'] != 'localhost' && $source['source_name'] != 'other')
		{
			if(@preg_match($source['source_rule'], $url))
			{
				$use_this_src = $source['source_id'];
				break;
			}
		}
	}
	
	if($url != '' && $use_this_src == -1)
	{
		$errors['yt_id'] = $lang['suggest_msg5'];
	}
	
	if( count($errors) == 0 )
	{
	// prepare everything for mysql
	$url = secure_sql($url);
	$description = trim($_POST['description']);
	$description = nl2br($description);
	$description = removeEvilTags($description);
	$description = secure_sql($description);

	if(_STOPBADCOMMENTS == '1') {
	$description = search_bad_words($description);
	}
	$description = word_wrap_pass($description);
	
	$video_title = 		secure_sql($_POST['video_title']);
	$video_title = 		str_replace( array("<", ">"), '', $video_title);
	$submitted = secure_sql($userdata['username']);
	$category = secure_sql($_POST['category']);
	$yt_id = specialchars($yt_id, 0);
	$video_title = specialchars($video_title, 0); 
	$user_id = $userdata['id'];
	$tags = removeEvilTags($_POST['tags']);
	$tags = secure_sql($tags);

	$modframework->trigger_hook('suggest_check');
	//	Lookup this URL in the database, check for existence to avoid duplication.
	$query = mysql_query("SELECT uniq_id FROM pm_videos_urls WHERE direct = '".$url."'");
	$count = mysql_num_rows($query);

	$query2 = mysql_query("SELECT id FROM pm_temp WHERE url = '".$url."'");
	$count2 = mysql_num_rows($query2);

	@mysql_free_result($query);
	@mysql_free_result($query2);
	$modframework->trigger_hook('suggest_insert');
	
	if($count > 0) 
	{
		$smarty->assign('success', 3); // Already exists in database
	}
	elseif($count2 > 0) 
	{
		$smarty->assign('success', 4); // Already exists in pm_temp table - waiting for approval
	} 
	else 
	{
		$sql = "INSERT INTO pm_temp (url, video_title, description, tags, category, username, user_id, added, source_id, language) 
											VALUES ('".$url."', '".$video_title."', '".$description."', '".$tags."', '".$category."', '".$submitted."', '".$user_id."', '".time()."', '".$use_this_src."', '1')";

		$query = @mysql_query($sql);
		$modframework->trigger_hook('suggest_added');
		$smarty->assign('success', 1);
	}
    }
	else
	{
		$_POST['video_title'] = str_replace('"', '', $_POST['video_title']);
		$_POST['tags'] = str_replace('"', '', $_POST['tags']);
		$_POST['yt_id'] = str_replace('"', '', $_POST['yt_id']);
		$smarty->assign('success', 0);
		$smarty->assign('errors', $errors);
	}
}

$smarty->assign('form_action', $form_action);
$smarty->assign('errors', $errors);
$smarty->assign('categories_dropdown', categories_dropdown(array('selected' => $_POST['category'], 'attr_class' => 'span5')));
$smarty->assign('sources', $sources); 

// --- DEFAULT SYSTEM FILES - DO NOT REMOVE --- //
$smarty->assign('meta_title', $meta_title);
$smarty->assign('meta_description', $meta_description);
$smarty->assign('template_dir', $template_f);
$modframework->trigger_hook('suggest_bottom');
$smarty->display('suggest.tpl');
?>