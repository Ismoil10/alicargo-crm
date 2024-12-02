<?

if ($_GET['page']=='routes' AND $_GET['page_action']=='list'){
	
	$_SESSION['page_cc'] = 'routes';		
	$_SESSION['page_action_cc'] = 'list';
	
	if ($link_type=='single'){LocalRedirect('index.php');}	
	
}

if ($_GET['page']=='routes' AND $_GET['page_action']=='detail'){
	
	$_SESSION['page_cc'] = 'routes';		
	$_SESSION['page_action_cc'] = 'detail';
	
	if ($link_type=='single'){LocalRedirect('index.php');}	
	
}
	
?>