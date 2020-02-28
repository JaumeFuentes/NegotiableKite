function article_ajax_request(page, extra_params, output_sel, type) {
	
	var ret = false;
	
	if (type.length == 0)
	{
		type = "html";	
	}

	if (output_sel.length > 0)
	{
		$(output_sel).html('<img src="./img/ico-loading.gif" alt="Loading" id="loading" />Loading...').fadeIn('normal');
	}
	$.ajax({
		   type: "GET",
		   url: "./article_ajax.php", 
		   //cache: false, 
		   data: "p=" + page + "&" + extra_params,
		   dataType: type,
		   success: function(data) {
						if (output_sel.length > 0)
						{
							$(output_sel).html(data);
							$(output_sel).show();
						}
						ret = true;
					}
		   });
	return ret;
}

function onpage_delete_article(article_id, result_selector, tr_selector) {

	var confirm_msg = "You are about to remove this article and everything attached to it. Click 'Cancel' to stop, 'OK' to delete";
	var response = false;
	var pmnonce = $('#_pmnonce_admin_articles').val();
	var pmnonce_t = $('#_pmnonce_t_admin_articles').val();
	
	if (confirm(confirm_msg)) 
	{
		article_ajax_request("articles", "do=delete&id=" + article_id + "&_pmnonce="+ pmnonce + "&_pmnonce_t=" + pmnonce_t, result_selector, "html");
		$(tr_selector).fadeOut('normal');
	}
}

function onpage_delete_category(category_id, result_selector, tr_selector) {

	var confirm_msg = "You are about to delete this category and all subcategories attached to it as well.\nArticles from these categories will not be deleted.\n\nClick 'Cancel' to stop, 'OK' to delete";
	var response = false;
	var pmnonce = $('#_pmnonce_admin_catmanager').val();
	var pmnonce_t = $('#_pmnonce_t_admin_catmanager').val();
	
	if (confirm(confirm_msg)) 
	{
		article_ajax_request("categories", "do=delete&id=" + category_id + "&_pmnonce="+ pmnonce + "&_pmnonce_t=" + pmnonce_t, result_selector, "html");
		$(tr_selector).fadeOut('normal');
	}
}
