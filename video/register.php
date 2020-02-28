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

@header( 'Expires: Wed, 11 Jan 1984 05:00:00 GMT' );
@header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s' ) . ' GMT' );
@header( 'Cache-Control: no-cache, must-revalidate, max-age=0' );
@header( 'Pragma: no-cache' );

require('config.php');
require_once('include/functions.php');
require_once('include/user_functions.php');
require_once('include/islogged.php');
$modframework->trigger_hook('register_top');

$meta_title = $lang['create_account'].' - '._SITENAME;
$meta_description = $lang['register_msg3'];

if( is_user_logged_in() ) {
	header("Location: "._URL. "/index."._FEXT);
	exit();
}
// Initialize some variables
$form_action = 'register.'._FEXT;
$errors = array();
$nr_errors = 0;
$logged_in = 0;
$locations = array();
$show_countries_list = 1;
load_countries_list();

$smarty->assign('display_form', 'register');

if( isset($_POST['Register']) && $config['allow_registration'] == '1') 
{
	// check capcha code
    include ("include/securimage.php");
    $img = new Securimage();
    $valid_capcha = $img->check($_POST['imagetext']);
	if( !$valid_capcha ) {
		$errors['capcha'] = $lang['register_err_msg1'];
	}
	$required_fields = array('email' => $lang['your_email'],
							 'username' => $lang['username'], 
							 'pass' => $lang['password'], 
							 'confirm_pass' => $lang['confirm_pass'], 
							 'name' => $lang['your_name'],
							 );
	foreach( $_POST as $key => $value) {
		$value = trim($value);
		if(array_key_exists(strtolower($key), $required_fields) && empty($value) )
			$errors[$key] = $required_fields[$key]." ".$lang['register_err_msg8'];
	}
	$inputs = array();
	foreach($_POST as $key => $val)
	{
		$val = trim($val);
		$val = specialchars($val, 1);
		$inputs[$key] = $val;
	}
	$smarty->assign('inputs', $inputs);
	if($show_countries_list && $_POST['country'] == '-1') {
		$errors['country'] = $lang['choose_country'];
	}
	
	$nr_errors = count($errors);
	if($nr_errors == 0) {
		// grab the fields - values in variables and filter them for safety
		$email = 		trim($_POST['email']);
		$username =		trim($_POST['username']);
		$pass =			$_POST['pass'];
		$conf_pass = 	$_POST['confirm_pass'];
		$name = secure_sql($_POST['name']);
		$gender = secure_sql($_POST['gender']);
		$location = secure_sql($_POST['country']);
		// check if the requried fields are valid
			if($var = validate_email($email)) {
				if($var == 1) 
					$errors['email'] = $lang['register_err_msg2'];
				if($var == 2)
					$errors['email'] = $lang['register_err_msg3'];
			}

		if($var = check_username($username)) { 
			if($var == 1)
				$errors['username'] = $lang['register_err_msg4'];
			if($var == 2)
				$errors['username'] = $lang['register_err_msg5'];
			if($var == 3)
				$errors['username'] = $lang['register_err_msg6'];
		}
		
		if( strcmp($pass, $conf_pass)) { 
			$errors['pass'] = $lang['register_err_msg7'];
		}

	}// end if(nr_errors == 0);
	$modframework->trigger_hook('register_fields');
	$nr_errors = count($errors);
	
	if( $nr_errors ){
		$modframework->trigger_hook('register_show_form');
			
	
		$smarty->assign('form_action', $form_action);
		$smarty->assign('errors', $errors);
		$smarty->assign('show_countries_list', $show_countries_list);
		$smarty->assign('countries_list', $_countries_list);
		// --- DEFAULT SYSTEM FILES - DO NOT REMOVE --- //
		$smarty->assign('meta_title', $meta_title);
		$smarty->assign('meta_description', $meta_description);
		$smarty->assign('template_dir', $template_f);
		$smarty->display('user-auth.tpl');
		exit();
	}
	else { 
		// prepare everything for mysql
		$email = 		prepare_for_mysql($email);
		$username =		prepare_for_mysql($username);

		$sql = "INSERT INTO pm_users (username, password, email, name, gender, country, reg_date, last_signin, reg_ip, about, power, activation_key) VALUES ";
		
		$ip = addslashes($_SERVER['REMOTE_ADDR']);

		if($config['account_activation'] == AA_USER)
		{
			$activation_key = '';
			$activation_key = generate_activation_key();
			$sql .= "('".$username."', '".md5($pass)."', '".$email."', '".$name."', '".$gender."', '".$location."', '".time()."', '".time()."', '".$ip."', '', '".U_INACTIVE."', '".$activation_key."')";
		
		}
		elseif($config['account_activation'] == AA_DISABLED)
		{
			$sql .= "('".$username."', '".md5($pass)."', '".$email."', '".$name."', '".$gender."', '".$location."', '".time()."', '".time()."', '".$ip."', '', '".U_ACTIVE."', '')";
		}
		
		$result = @mysql_query($sql);
		if( ! $result )
		{
			echo $lang['login_msg11'].' <em>' . $config['contact_mail'] . "</em>";
			exit();
		}
		$user_id = @mysql_insert_id();
		
		if (_MOD_SOCIAL && $user_id)
		{
			log_activity(array('user_id' => $user_id, 'activity_type' => ACT_TYPE_JOIN));
		}

		//	MAILS
		if($config['account_activation'] == AA_USER)
		{	
			$activation_link  =    _URL;
			$activation_link .=    "/login." . _FEXT;
			$activation_link .=    "?do=activate&u=" . $user_id . "&key=" . $activation_key;
			
			// ** SENDING EMAIL ** //
	
			require_once("include/class.phpmailer.php");
			
				//*** DEFINING E-MAIL VARS
				$mailsubject = sprintf($lang['mailer_subj4'], _SITENAME);
				
				$array_content[]=array("mail_username", $username);  
				$array_content[]=array("mail_password", $pass);
				$array_content[]=array("mail_ip", $ip);
				$array_content[]=array("mail_sitename", _SITENAME);
				$array_content[]=array("mail_url", _URL);
				$array_content[]=array("mail_activation_link", $activation_link);
				//*** END DEFINING E-MAIL VARS
			
			if(file_exists('./email_template/'.$_language_email_dir.'/email_registration2.txt'))
			{
				$mail = send_a_mail($array_content, $email, $mailsubject, 'email_template/'.$_language_email_dir.'/email_registration2.txt');
			}
			elseif(file_exists('./email_template/english/email_registration2.txt'))
			{
				$mail = send_a_mail($array_content, $email, $mailsubject, 'email_template/english/email_registration2.txt');
			}
			elseif(file_exists('./email_template/email_registration2.txt'))
			{
				$mail = send_a_mail($array_content, $email, $mailsubject, 'email_template/email_registration2.txt');
			}
			else
			{
				@log_error(secure_sql('Error: Email template "email_registration2.txt" not found!'), 'Register Page', 1);
				$mail = TRUE;
			}
			if($mail !== TRUE)
			{
				@log_error($mail, 'Register Page', 1);
			}
			// ** END SENDING EMAIL ** //		
			$msg = $lang['register_msg4'];
			$modframework->trigger_hook('register_done_active');
		}
		elseif($config['account_activation'] == AA_DISABLED)
		{	
			// ** SENDING EMAIL ** //
	
			require_once("include/class.phpmailer.php");
			
				//*** DEFINING E-MAIL VARS
				$mailsubject = sprintf($lang['mailer_subj1'], _SITENAME);
				
				$array_content[]=array("mail_username", $username);  
				$array_content[]=array("mail_password", $pass);
				$array_content[]=array("mail_ip", $ip);
				$array_content[]=array("mail_sitename", _SITENAME);
				$array_content[]=array("mail_url", _URL);
				//*** END DEFINING E-MAIL VARS
			
			if(file_exists('./email_template/'.$_language_email_dir.'/email_registration.txt'))
			{
				$mail = send_a_mail($array_content, $email, $mailsubject, 'email_template/'.$_language_email_dir.'/email_registration.txt');
			}
			elseif(file_exists('./email_template/english/email_registration.txt'))
			{
				$mail = send_a_mail($array_content, $email, $mailsubject, 'email_template/english/email_registration.txt');
			}
			elseif(file_exists('./email_template/email_registration.txt'))
			{
				$mail = send_a_mail($array_content, $email, $mailsubject, 'email_template/email_registration.txt');
			}
			else
			{
				@log_error(secure_sql('Error: Email template "email_registration.txt" not found!'), 'Register Page', 1);
				$mail = TRUE;
			}
			if($mail !== TRUE)
			{
				@log_error($mail, 'Register Page', 1);
			}
			// ** END SENDING EMAIL ** //
			$modframework->trigger_hook('register_done_activation');
			
			$msg = $lang['register_msg5'];
		}
		
		$smarty->assign('success', 1);
		$smarty->assign('msg', $msg);
		$modframework->trigger_hook('register_done_display');
		$redir = get_last_referer();
		if( $redir === false){ 	
			$redir = '/index.'._FEXT;
		}
		$smarty->assign('redir', _URL . $redir);
		
// --- DEFAULT SYSTEM FILES - DO NOT REMOVE --- //
		$smarty->assign('meta_title', $meta_title);
		$smarty->assign('meta_description', $meta_description);
		$smarty->assign('template_dir', $template_f);
		$smarty->display('user-auth.tpl');
	}
}// end if($_POST['Register'] == "Register");
else{ 

	$modframework->trigger_hook('register_show_form');
		
	$smarty->assign('form_action', $form_action);
	$smarty->assign('show_group', $show_group);
	$smarty->assign('errors', $errors);
	$smarty->assign('show_countries_list', $show_countries_list);
	$smarty->assign('countries_list', $_countries_list);
	$smarty->assign('locations', $locations);
// --- DEFAULT SYSTEM FILES - DO NOT REMOVE --- //
	$smarty->assign('meta_title', $meta_title);
	$smarty->assign('meta_description', $meta_description);
	$smarty->assign('template_dir', $template_f);
	$smarty->display('user-auth.tpl');

} // end else;
?>