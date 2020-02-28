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

if ($config['allow_user_uploadvideo'] == '0')
{
	header('Location: '. _URL .'/suggest.'. _FEXT);
	exit();
}

if ( ! is_user_logged_in())
{
	header("Location: "._URL. "/login.php");
	exit();
}
$modframework->trigger_hook('upload_top');

$exec_limit = 300;
if ( ! ini_get('safe_mode'))
{
	if (ini_get('max_execution_time') < $exec_limit)
	{
		ini_set('max_execution_time', $exec_limit);
	}
	if (ini_get('max_input_time') < $exec_limit)
	{
		ini_set('max_input_time', $exec_limit);
	}
}

$errors = array();
$inputs = array();
$max_filesize_bytes = return_bytes($config['allow_user_uploadvideo_bytes']);

$whitelist	   = array('flv', 'mov', 'avi', 'divx', 'mp4', 'wmv', 'mkv',
						'asf', 'wma', 'mp3', 'm4v', 'm4a', '3gp', '3g2');

$allowed_types = array( 'video/x-flv', 	'video/quicktime', 'video/x-msvideo', 
						'video/x-divx', 'video/mp4', 'video/x-ms-wmv', 
						'application/octet-stream',  'video/avi', 'video/x-matroska',
						'video/x-ms-asf', 'audio/x-ms-wma',	'audio/mp4', 'video/3gpp', 
						'video/3gpp2', 'audio/mpeg', 'video/mpeg', 'application/force-download', 
						'audio/mp3', 'audio/mpeg3', 'video/x-m4v', 'audio/x-m4a');
					
$whitelist_img	  = array('jpg', 'gif', 'png', 'jpeg');
$allowed_types_img = array('image/png', 'image/gif', 'image/jpg', 'image/jpeg', 'image/pjpeg');
 
$form_action = 'upload.php';
$uploads_per_day = 20; // videos/day/user
$uploaded_today = 0;
$today_start = mktime(0, 0, 0);
$today_end	 = mktime(23, 59, 59);

// define meta tags
$meta_title = $lang['upload_video']; 
$meta_description = '';

if ($max_filesize_bytes == 0)
{
	$max_filesize_bytes = 1024 * 2048; // 2MB
}

$sql = "SELECT COUNT(*) as total 
		FROM pm_temp 
		WHERE user_id = '". $userdata['id'] ."' 
		  AND source_id = '1' 
		  AND added >= '". $today_start ."' 
		  AND added <= '". $today_end ."'";
$result = @mysql_query($sql);
$row = @mysql_fetch_assoc($result);
mysql_free_result($result);

$uploaded_today = $row['total'];

unset($sql, $result, $row);

if ($uploaded_today > $uploads_per_day)
{
	$smarty->assign('success', 2);
}
else
{
	if ($_POST['Submit'])
	{
		$del_tmp_file = false;
		$category_id = (int) $_POST['category'];
		$file = $_FILES['mediafile'];
		$img = $_FILES['capture'];
		$thumbnail = '';
		$modframework->trigger_hook('upload_start');
		
		$required_fields = array('video_title' => $lang['video']
								);
		
		foreach ($_POST as $key => $value) 
		{
			$value = unspecialchars(trim($value), 1);
			$_POST[$key] = $value;
			
			if (array_key_exists(strtolower($key), $required_fields) && empty($value))
				$errors[$key] = $required_fields[$key]." ".$lang['register_err_msg8'];
		}
		
		if ($category_id <= 0) 
		{
			$errors['category'] = $lang['choose_category'];
		}
		$modframework->trigger_hook('upload_thumb_before');
		
		// upload image
		$thumbnail = '';
		$ext = strtolower(array_pop(explode('.', $img['name'])));
		if (($img['size'] > 0 && $img['size'] <= $max_filesize_bytes) && strlen($img['name']) > 0 && $img['error'] == 0)
		{
			if (in_array($img['type'], $allowed_types_img) && in_array($ext, $whitelist_img))
			{
				do
				{
					$new_name  = md5($file['name'].rand(1,888));
					$new_name  = substr($new_name, 2, 10);
					$new_name .= '.'.$ext;
				} while (file_exists(_THUMBS_DIR_PATH . $new_name));

				$copy = @copy($img['tmp_name'], _THUMBS_DIR_PATH . $new_name); 
				if ($copy === TRUE)
				{
					$resize = resize_then_crop(_THUMBS_DIR_PATH . $new_name, _THUMBS_DIR_PATH . $new_name, THUMB_W_VIDEO, THUMB_H_VIDEO, "255", "255", "255", $allowed_types_img);

					if($resize != false)
					{
						$thumbnail = $new_name;
					}
				}
			}
		} 
		// end upload image
		$modframework->trigger_hook('upload_thumb_after');
		
		if (count($errors) > 0)
		{
			$del_tmp_file = true;
		}
		else
		{
			$ext = strtolower(array_pop(explode('.', $file['name'])));
			if (($file['size'] > 0 && $file['size'] <= $max_filesize_bytes) && strlen($file['name']) > 0 && $file['error'] == 0)
			{
				if (in_array($file['type'], $allowed_types) && in_array($ext, $whitelist))
				{					
					do
					{
						$new_name  = md5($file['name'].rand(1,888));
						$new_name  = substr($new_name, 2, 10);
						$new_name .= '.'.$ext;
					}
					while (file_exists(_VIDEOS_DIR_PATH . $new_name));
					$modframework->trigger_hook('upload_moveupload');
					
					if ($move = move_uploaded_file($file['tmp_name'], _VIDEOS_DIR_PATH . $new_name))
					{
						if ($_POST['duration'] != '')
						{
							$pieces = explode(':', $_POST['duration']);
							$pieces[0] = (int) $pieces[0];
							$pieces[1] = (int) $pieces[1];

							$duration = (int) ($pieces[0] * 60) + $pieces[1];
						}
						
						$description = trim($_POST['description']);
						$description = nl2br($description);
						$description = removeEvilTags($description);
						$description = secure_sql($description);
						if(_STOPBADCOMMENTS == '1')
							$description = search_bad_words($description);
						
						$description = word_wrap_pass($description);
					
						$video_title = 	secure_sql($_POST['video_title']);
						$video_title = 	str_replace( array("<", ">"), '', $video_title);
			
						$tags = removeEvilTags($_POST['tags']);
						$tags = secure_sql($tags);
						$modframework->trigger_hook('upload_insertvideo_before');
						
						$sql = "INSERT INTO pm_temp 
									(url, video_title, description, yt_length, tags, category, username, user_id, added, source_id, language, thumbnail) 
								VALUES ('". $new_name ."', 
										'". $video_title ."', 
										'". $description ."',
										'". $duration ."',
										'". $tags ."', 
										'". $category_id ."',
										'". $userdata['username'] ."',
										'". $userdata['id'] ."',
										'". time() ."',	'1', '1', 
										'". $thumbnail ."')";
						$result = @mysql_query($sql);
						$modframework->trigger_hook('upload_insertvideo_after');
						
						if ( ! $result)
						{
							$errors['mediafile'] = $lang['upload_errmsg1'];
						}
						else
						{
							//$smarty->assign('success', 1);
							header("Location: ". _URL .'/upload.'. _FEXT .'?uploaded=1');
							exit();
						}
					}
					else
					{
						$errors['mediafile'] = $lang['upload_errmsg1'];
					}
				}
				else
				{
					$errors['mediafile'] = $lang['upload_errmsg2'];
				}
				
			}
			else
			{
				$del_tmp_file = true;
				switch ($file['error'])
				{	

					case UPLOAD_ERR_INI_SIZE:
						$errors['mediafile'] = $lang['upload_errmsg3'];
					break;
					
					case UPLOAD_ERR_FORM_SIZE:
						$errors['mediafile'] = $lang['upload_errmsg4'];
					break;
					
					case UPLOAD_ERR_PARTIAL:
						$errors['mediafile'] = $lang['upload_errmsg5'];
					break;
					
					case  UPLOAD_ERR_NO_FILE:
						$errors['mediafile'] = $lang['upload_errmsg6'];
					break;
					
					case UPLOAD_ERR_NO_TMP_DIR:
						$errors['mediafile'] = $lang['upload_errmsg7'];
					break;
					
					case 7: //UPLOAD_ERR_CANT_WRITE:
						$errors['mediafile'] = $lang['upload_errmsg8'];
					break;
					
					case 8: //UPLOAD_ERR_EXTENSION:
						$errors['mediafile'] = $lang['upload_errmsg9'];
					break;
					
					default:
					case UPLOAD_ERR_OK:
						$errors['mediafile'] = $lang['upload_errmsg10'];
					break;
				}
			}
		}
		
		foreach ($_POST as $key => $value)
		{
			$_POST[$key] = specialchars($value, 1);
		}
		
		if ($del_tmp_file && strlen($file['tmp_name']) > 0)
		{
			@unlink($file['tmp_name']);
		}
		if ($del_tmp_file && strlen($img['tmp_name']) > 0)
		{
			@unlink($img['tmp_name']);
		}
	} // end if Submit
} // end if daily limit not reached

if ($_GET['uploaded'] == '1')
{
	$smarty->assign('success', 1);
}

$smarty->assign('form_action', $form_action);
$smarty->assign('errors', $errors);
$smarty->assign('categories_dropdown', categories_dropdown(array('selected' => $_POST['category'], 'attr_class' => 'span5')));
$smarty->assign('max_file_size', $max_filesize_bytes);
$smarty->assign('upload_limit', readable_filesize($max_filesize_bytes));
$smarty->assign('meta_title', $meta_title);
$smarty->assign('meta_description', $meta_description);
$smarty->assign('template_dir', $template_f);
$modframework->trigger_hook('upload_bottom');
$smarty->display('upload.tpl');
?>