<?

if ($_GET['page']=='marketing' AND $_GET['page_action']=='list'){
	
	$_SESSION['page_cc'] = 'marketing';		
	$_SESSION['page_action_cc'] = 'list';
	
	if ($link_type=='single'){LocalRedirect('index.php');}	
	
}

if ($_GET['page']=='marketing' AND $_GET['page_action']=='detail'){
	
	$_SESSION['page_cc'] = 'marketing';		
	$_SESSION['page_action_cc'] = 'detail';
	
	if ($link_type=='single'){LocalRedirect('index.php');}	
	
}
	
?>