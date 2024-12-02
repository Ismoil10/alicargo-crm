<?

if ($_GET['page']=='pochta' AND $_GET['page_action']=='list'){
	
	$_SESSION['page_cc'] = 'pochta';		
	$_SESSION['page_action_cc'] = 'list';
	
	if ($link_type=='single'){LocalRedirect('index.php');}	
	
}

if ($_GET['page']=='pochta' AND $_GET['page_action']=='detail'){
	
	$_SESSION['page_cc'] = 'pochta';		
	$_SESSION['page_action_cc'] = 'detail';
	
	if ($link_type=='single'){LocalRedirect('index.php');}	
	
}
if ($_GET['page']=='pochta' AND $_GET['page_action']=='demo'){
	
	$_SESSION['page_cc'] = 'pochta';		
	$_SESSION['page_action_cc'] = 'demo';
	
	if ($link_type=='single'){LocalRedirect('index.php');}	
	
}
if ($_GET['page']=='pochta' AND $_GET['page_action']=='cart'){
	
	$_SESSION['page_cc'] = 'pochta';		
	$_SESSION['page_action_cc'] = 'cart';
	
	if ($link_type=='single'){LocalRedirect('index.php');}	
	
}

?>