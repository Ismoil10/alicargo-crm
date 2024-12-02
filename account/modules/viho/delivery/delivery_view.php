<?//PAGE ACTION CONTROL ?>
<?
if ($link_type=='single'){
	if ($_SESSION['page_cc'] == 'delivery' and $_SESSION['page_action_cc']=='list'){require 'delivery_list.php';} 
	if ($_SESSION['page_cc'] == 'delivery' and $_SESSION['page_action_cc']=='detail'){require 'delivery_detail.php';} 
}

if ($link_type=='multi'){
if ($_GET['page']=='delivery' AND $_GET['page_action']=='list'){require 'delivery_list.php';}
if ($_GET['page']=='delivery' AND $_GET['page_action']=='detail'){require 'delivery_detail.php';}
}
?>