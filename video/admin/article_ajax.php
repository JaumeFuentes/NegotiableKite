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


$illegal_chars = array(">", "<", "&", "'", '"');

$message = '';
$page	 = '';
$page	 = $_GET['p'];
$action  = $_GET['do'];

if ($page == '')
{
	exit();
}

switch ($page)
{
	case 'articles':
	 
		if (isset($_GET['do']))
		{
			switch ($action)
			{
				case 'delete':
					
					if ( ! csrfguard_check_referer('_admin_articles'))
					{
						echo '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
						exit();
					}
						
					$id = (int) $_GET['id'];
					if ($id > 0)
					{
						$result = delete_article($id);
						
						if ($result['type'] == 'error')
						{
							echo '<div class="alert alert-error">'. $result['msg'] .'</div>';
						}
						else
						{
							// refresh token
							echo csrfguard_form('_admin_articles');
							echo '<div class="alert alert-success">'. $result['msg'] .'</div>';
						}
					}

				break;
				
				default: 
					exit();
				break;
			}
		}
	
	break;
	
	case 'categories':
		
		if (isset($_GET['do']))
		{
			switch ($action)
			{
				case 'delete':	//	delete a category
		
					if ( ! csrfguard_check_referer('_admin_catmanager'))
					{
						echo '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
						exit();
					}
					
					$id = (int) $_GET['id']; 
					if ($id > 0)
					{
						$result = art_delete_category($id);
						if ($result['type'] == 'error')
						{
							echo '<div class="alert alert-error">'. $result['msg'] .'</div>';
						}
						else
						{
							echo csrfguard_form('_admin_catmanager');
							echo '<div class="alert alert-success">'. $result['msg'] .'</div>';
						}
					}
				
				break;
			}
		}
	break;
	
	default:
		exit();
	break;
}	//	end switch ($page)


exit();
?>