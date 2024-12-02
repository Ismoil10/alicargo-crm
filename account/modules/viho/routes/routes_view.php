<?//PAGE ACTION CONTROL ?>
<?
if ($link_type=='single'){
	if ($_SESSION['page_cc'] == 'routes' and $_SESSION['page_action_cc']=='list'){require 'routes_list.php';} 
	if ($_SESSION['page_cc'] == 'routes' and $_SESSION['page_action_cc']=='detail'){require 'routes_detail.php';} 
}

if ($link_type=='multi'){
if ($_GET['page']=='routes' AND $_GET['page_action']=='list'){require 'routes_list.php';}
if ($_GET['page']=='routes' AND $_GET['page_action']=='detail'){require 'routes_detail.php';}
}
?>