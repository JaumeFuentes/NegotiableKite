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

// Not sure how to configure? Please read the Installation Manual PDF
// +------------------------------------------------------------------------+



// Full URL without any trailing slash (e.g http://www.example.com)
if($_SESSION['servidor']=='192.168.1.159' or $_SESSION['servidor']=="superchauen.sytes.net")
	define('_URL', 'http://192.168.1.159/video');	
else
	define('_URL', 'http://www.negotiablekite.com/video');

//-- Customer ID --//
// Replace "YOUR_CUSTOMER_ID" below with the assigned "Customer ID".
// The "Customer ID" is found in the order confirmation emails or in your Customer Account
// If you don't know your "Customer ID" email support at support@phpsugar.com
define('_CUSTOMER_ID', 'PS63d5a645b21');	

// ========================================================= //
//-- MySQL Backup Directory --//
define('BKUP_DIR', 'temp');	//	WITHOUT any trailing slash
define('_POWEREDBY', 0);

@header('CONTENT-TYPE: text/html; charset=utf-8');
define('ABSPATH', dirname(__FILE__).'/'); 

//-- MySQL Settings --//
require_once( ABSPATH.'include/DB_Data.php');

if ( ! file_exists('install.php') ) 
{
	require_once( ABSPATH.'include/settings.php');
}
else
{
	if ( ! defined('PM_DOING_INSTALL'))
	{
		die('<div align="center" style="font-family: Arial, sans-serif; color: #555; margin: 60px 0; line-height: 1.6em;"><img src="admin/img/login-logo.png"> <br /> <br /> <br />If you haven\'t installed PHP Melody yet, <a href="install.php">start the installation process</a> now. <br> Otherwise, remove <strong>install.php</strong> from your server.');
	}
}
?>