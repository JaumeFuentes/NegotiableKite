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

$do = (int) $_GET['do'];
$uniq_id = trim($_GET['vid']);

if(strlen($uniq_id) < 10 && strlen($uniq_id) > 5)
{
	if(!ctype_alnum($uniq_id))
		$uniq_id = '';
	else
		$uniq_id = secure_sql($uniq_id);
}
else
	$uniq_id = '';

// START PROCESSING THE FORM
if( isset($_POST['Submit']) && $uniq_id != '') {
	foreach($_POST as $k => $v)
	{
		$_POST[$k] = htmlspecialchars($v);
	}

	// check captcha code
    include ("include/securimage.php");
    $img = new Securimage();
    $valid = $img->check($_POST['imagetext']);

	$post_email = trim($_POST['email']);
	$post_name = secure_sql(trim($_POST['name']));
	$post_reason = secure_sql(trim($_POST['reason']));
	
	if (!is_real_email_address($post_email)) {
		$err_email = $lang['register_err_msg2'];
		$smarty->assign('err_email', $err_email);
	}

	if( !$valid ) {
		$err_captcha = $lang['register_err_msg1'];
	} elseif ($valid && is_real_email_address($post_email)) {
		$confirm_send = '1';
		$smarty->assign('confirm_send', $confirm_send);
		
		$video = request_video($uniq_id);
		
		if ( ! is_user_logged_in() && $video['restricted'] == '1')
		{
			echo $lang['registration_req']; 
			exit(); 
		}
		
		report_video($uniq_id, $do, $post_reason, $post_name);
	}
}
elseif(isset($_POST['Submit']) && $uniq_id == '')
{
	die("Invalid video ID");
}
	// ASSIG ERRORS 
	$smarty->assign('err_captcha', $err_captcha);
	// END ERRORS 
	$smarty->assign('template_dir', $template_f);
	$smarty->assign('vid', $uniq_id);
	$smarty->assign('do', $do);
	$smarty->assign('post_email', $post_email);
	$smarty->assign('post_name', $post_name);
	$smarty->assign('post_reason', $post_reason);

if($do == 0) { // reporting video
	$smarty->assign('title', $lang['report_vp']);
}

elseif($do == 1) { // reporting comment
	$smarty->assign('title', $lang['report_vc']);
}

else {
echo $lang['browse_msg1'];
exit;
}
$smarty->display('report_header.tpl');
$smarty->display('report_video.tpl');
$smarty->display('report_footer.tpl');

?>