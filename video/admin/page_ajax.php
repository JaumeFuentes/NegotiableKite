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
require_once('../config.php');
include_once('functions.php');
include_once( ABSPATH . 'include/user_functions.php');
include_once( ABSPATH . 'include/islogged.php');

if ( ! defined('U_ADMIN'))
{
	define('U_ADMIN', 1);	//	1 by default
}

if( ! $logged_in || ! is_admin())
{
	exit();
}

$message = '';
$action  = $_GET['do'];

switch ($action)
{
	case 'delete':
		
		if ( ! csrfguard_check_referer('_admin_pages'))
		{
			echo '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
			exit();
		}
		
		$result = delete_page($_GET['id']);				
		if ($result['type'] == 'error')
		{
			echo '<div class="alert alert-error">'. $result['msg'] .'</div>';
		}
		else
		{
			echo csrfguard_form('_admin_pages');
			echo '<div class="alert alert-success">'. $result['msg'] .'</div>';
		}
		
		exit();

	break;
	
	default: 
		exit();
	break;
}

exit();
?>