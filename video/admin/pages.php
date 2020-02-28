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

$showm = 'mod_pages';
$load_scrolltofixed = 1;
include('header.php');

$action = $_GET['do'];
if ( ! in_array($action, array('edit', 'new', 'delete')) )
{
	$action = 'new';	//	default action
}

?>
<div id="adminPrimary">
    <div class="row-fluid" id="help-assist">
        <div class="span12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#help-overview" data-toggle="tab">Overview</a></li>
            <li><a href="#help-onthispage" data-toggle="tab">Filtering</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade in active" id="help-overview">
            <p>Pages allow for easy content publishing. Pages can be used to things such as creating a &quot;Terms of agreement&quot; page, a promotion page or any other additional content you might need.<br />Published pages will appear as links in the footer of your site.</p>
            </div>
            <div class="tab-pane fade" id="help-onthispage">
            <p>Listing pages such as this one contain a filtering area which comes in handy when dealing with a large number of entries. The filtering options is always represented by a gear icon positioned on the top right area of the listings table. Clicking this icon usually reveals a  search form and one or more drop-down filters.</p>
            </div>
          </div>
        </div> <!-- /tabbable -->
        </div><!-- .span12 -->
    </div><!-- /help-assist -->
    <div class="content">
    <a href="#" id="show-help-assist">Help</a>
<?php
$action	= (int) $_GET['action'];
$current_page	= (int) $_GET['page'];

if($current_page == 0)
	$current_page = 1;


$total_pages = 0;
$limit = 20;
$from = $current_page * $limit - ($limit);

$filter = '';
$filters = array('public', 'private', 'mostviewed');
$filter_value = '';

if(in_array(strtolower($_GET['filter']), $filters) !== false)
{
	$filter = strtolower($_GET['filter']);
	$filter_value = $_GET['fv'];
}

//	Batch delete
if ($_POST['submit'] == "Delete checked" && ! csrfguard_check_referer('_admin_pages'))
{
	$info_msg =  '<div class="alert alert-error">Invalid token or session expired. Please refresh this page and try again.</div>';
}
else if ($_POST['submit'] == "Delete checked")
{
	if(count($_POST['checkboxes']) > 0)
	{
		$page_ids = array();
		foreach ($_POST['checkboxes'] as $k => $id)
		{
			$page_ids[] = (int) $id;
		}
		
		$result = mass_delete_pages($page_ids);
		
		if ($result['type'] == 'error')
		{
			$info_msg =  '<div class="alert alert-error">'. $result['msg'] .'</div>';
		}
		else
		{
			$info_msg =  '<div class="alert alert-success">'. $result['msg'] .'</div>';
		}
	}
	else
	{
		$info_msg =  '<div class="alert alert-info">Please select something first.</div>';
	}
}

if ('' != $_POST['submit'] && $_POST['submit'] == 'Search')
{
	$pages = list_pages($_POST['keywords'], $_POST['search_type'], $from , $limit); 
	$total_pages = count($pages);
}
else
{
	switch ($filter)
	{
		default:
		case 'mostviewed':
		
			$total_pages = $config['total_pages'];
		
		break;
		
		case 'private':
		
			$total_pages = count_entries('pm_pages', 'status', '0');
		
		break;

		case 'public':
		
			$total_pages = count_entries('pm_pages', 'status', '1');
		
		break;
	}
	$pages = list_pages('', '', $from , $limit, $filter, $filter_value);
}

// generate smart pagination
$filename = 'pages.php';
$pagination = '';

if( ! isset($_POST['submit']))
{
	$pagination = a_generate_smart_pagination($current_page, $total_pages, $limit, 5, $filename, '');
} 
	

?>
  <div class="entry-count">
      <ul class="pageControls">
          <li>
              <div class="floatL"><strong class="blue"><?php echo pm_number_format(count_entries('pm_pages', '', '')); ?></strong><span>page(s)</span></div>
              <div class="blueImg"><img src="img/ico-page-new.png" width="18" height="18" alt="" /></div>
          </li>
      </ul><!-- .pageControls -->
  </div>
  <h2>Pages <a class="label opac5" onClick="parent.location='page_manager.php?do=new'">+ add new</a></h2>
  <?php echo $info_msg; ?>
  
<div id="display_result" style="display:none;"></div>

<div class="tablename">
<h6><?php if (!empty($filter)) { ?><button type="button" id="" class="btn btn-link btn-mini btn-danger" onClick="parent.location='pages.php'">Remove filter</button><?php } ?></h6>
    <div class="pull-right">
    <button type="button" class="btn btn-link btn-options" data-toggle="button" id="showfilter"><img src="img/ico-options.gif" width="30" height="18" /></button>
    </div>
</div>

<div class="tablename tablenameLight2" id="showfilter-content">
<div class="row-fluid">
<div class="span4">
    <form name="search" action="pages.php" method="post" class="form-search" onsubmit="return validateSearch('true');">
        <div class="input-append">
        <input type="text" name="keywords" value="<?php echo $_POST['keywords']; ?>" class="search-query" placeholder="Enter keyword" />
        <button name="submit" type="submit" value="Search" class="btn" />Search</button>
        </div>
    </form>
</div>
<div class="span4">
    <div class="pull-right">
    </div>
</div>
<div class="span4">

    <div class="qsFilter pull-right">
    <form name="other_filter" action="pages.php" class="form-inline">
    <input type="hidden" name="filter" value="power" />
    <div class="btn-group input-prepend">
    <div class="form-filter-inline">
    <?php
    if(!empty($_GET['filter'])) {
    ?>
    <button type="button" class="btn btn-danger" onClick="parent.location='pages.php'">Remove filter</button>
    <?php } else { ?>
    <button type="button" class="btn">Filter</button>
    <?php } ?>
    <select name="URL" class="span2" onChange="window.parent.location=this.form.URL.options[this.form.URL.selectedIndex].value">
    <option value="">by status ...</option>
    <option value="pages.php?page=1&filter=mostviewed">Most viewed</option>
    <option value="pages.php?page=1&filter=public">Published date</option>
    <option value="pages.php?page=1&filter=private">Private</option>
    </select>
    </div>
    </div><!-- .btn-group -->
    </form>
    </div><!-- .qsFilter -->

</div>
</div>
</div>

<form name="pages_checkboxes" id="pages_checkboxes" action="pages.php?page=<?php echo $current_page;?>" method="post">
 <table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered pm-tables tablesorter">
 <thead>
   <tr>
	<th align="center" style="text-align:center" width="3%"><input type="checkbox" name="checkall" onclick="checkUncheckAll(this);"/></th>
	<th width="6"></th>
	<th width="60%">Title</th>
	<th width="5%">Views</th>
	<th width="10%">Author</th>	
    <th width="90">Added</th>
    <th width="120" style="width:00px;">Action</th>
   </tr>
  </thead>
  <tbody>
	<?php 
	
	/*
	 *  List existing pages
	 */ 
	if ( ! array_key_exists('type', $pages) && $total_pages > 0)
	{
		$alt = 1;
		
		foreach ($pages as $k => $page)
		{
			$col = ($alt % 2) ? 'table_row1' : 'table_row2';
			$alt++;
			
			?>
			 
			<tr class="<?php echo $col;?>" id="page-<?php echo $page['id'];?>">
			 <td align="center" style="text-align:center" width="3%">
			 	<input name="checkboxes[]" type="checkbox" value="<?php echo $page['id']; ?>" />
			 </td>
			 <td align="center" style="text-align:center">
			    <?php 
					if ($page['status'] == 0)
					{
						echo '<a href="#" rel="tooltip" title="This page is private. Only the Administrator can see this page."><i class="icon-eye-close"></i></a>';
					}
				?>
			 </td>
			 <td>
			   <a href="<?php echo _URL.'/page.php?p='. $page['id']; ?>" target="_blank"><?php echo $page['title']; ?></a>
     		 </td>
			 <td align="center" style="text-align:center"><?php echo pm_number_format($page['views']); ?></td>
			 <td align="center" style="text-align:center">
			  <?php 
			  	$author = fetch_user_advanced($page['author']);
				
				echo '<a href="edit_user_profile.php?uid='. $author['id'] .'" title="Edit">'. $author['username'] .'</a>';
			  ?>
			 </td>
			 <td align="center" style="text-align:center"><?php echo date('M d, Y', $page['date']); ?></td>
			 <td align="center" class="table-col-action" style="text-align:center; width: 90px;">
			  <a href="page_manager.php?do=edit&id=<?php echo $page['id'];?>" class="btn btn-mini btn-link"><i class="icon-pencil"></i> </a>
			  <a href="#" onclick="onpage_delete_page('<?php echo $page['id']; ?>', '#display_result', '#page-<?php echo $page['id'];?>')" class="btn btn-mini btn-link"><i class="icon-remove" ></i> </a>
			 </td>
		    </tr>
			
			<?php
		}
	}
	else	//	Error?
	{
		if (strlen($pages['msg']) > 0)
		{
			echo '<div class="alert alert-error">'. $pages['msg'] .'</div>';
		}
		
		if ($total_pages == 0)
		{
			?>
			<tr>
			 <td colspan="8" align="center" style="text-align:center">
			 Nothing found.
			 </td>
			</tr>
			<?php
		}
	}
	?>
	<tr><td colspan="7" class="tableFooter"><div class="pagination pull-right"><?php echo $pagination; ?></div></td></tr>
  </tbody>
 </table>

<div id="stack-controls" class="list-controls">
<div class="pull-left">

</div>
<input type="submit" name="submit" value="Delete checked" class="btn btn-small btn-danger" onClick="return confirm_delete_all();" /> 
</div><!-- #list-controls -->
<?php echo csrfguard_form('_admin_pages');?>
</form>
    </div><!-- .content -->
</div><!-- .primary -->
<?php
include('footer.php');
?>