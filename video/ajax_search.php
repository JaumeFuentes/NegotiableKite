﻿<?php
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

require_once('config.php');
require_once('include/functions.php');
ob_end_clean();

$output 	 = '';

$queryString = trim($_POST['queryString']);
// Is there a posted query string?
if($queryString != '') 
{
	error_reporting(0);
	$queryString = secure_sql($queryString);
	$queryString = str_replace(array('%', ','), '', $queryString);
	
	//	only perform queries if the length of the search string is greather than 3 characters
	if(strlen($queryString) >= 3)
	{
		$num_res = 0;
		if(strlen($queryString) > 3)
		{
			$sql	 = "SELECT uniq_id, video_title FROM pm_videos 
						WHERE MATCH(video_title) 
						AGAINST ('$queryString') AS score 
						AND added <= '". time() ."' ORDER BY score ASC LIMIT 10";
			$query	 = @mysql_query($sql);
			$num_res = @mysql_num_rows($query);
		}
		if($num_res == 0)
		{
			$query = @mysql_query("SELECT video_title, uniq_id FROM pm_videos WHERE added <= '". time() ."' AND  (video_title LIKE '%$queryString%') LIMIT 10");
		}
		
		if($query)
		{
			while($result = mysql_fetch_array($query))
			{
				$output .= '<li onClick="fill(\''.$result['video_title'].'\');">';
				
				if (_THUMB_FROM == 2)	//	Localhost
				{
					$output .= '<img src="'. show_thumb($result['uniq_id']) .'" width="32" align="absmiddle" style="margin: 1px 8px 0 0;" alt="'. htmlentities($result['video_title']).'" />';
				}
				$output .= '<a href="'.makevideolink($result['uniq_id'], $result['video_title']).'" title="'. htmlentities($result['video_title']) .'">'.fewchars($result['video_title']."", 60).'</a>';
				$output .= '</li>';
			}
		} 
		else 
		{
			$output = $lang['search_results_msg3'];
		}
	}
}
echo $output;
exit();
?>