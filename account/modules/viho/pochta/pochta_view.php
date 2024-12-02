<?//PAGE ACTION CONTROL ?>
<?
if ($link_type=='single'){
	if ($_SESSION['page_cc'] == 'pochta' and $_SESSION['page_action_cc']=='list'){require 'pochta_list.php';} 
	if ($_SESSION['page_cc'] == 'pochta' and $_SESSION['page_action_cc']=='detail'){require 'pochta_detail.php';} 
	if ($_SESSION['page_cc'] == 'pochta' and $_SESSION['page_action_cc']=='cart'){require 'pochta_cart.php';} 
	if ($_SESSION['page_cc'] == 'pochta' and $_SESSION['page_action_cc']=='demo'){require 'demo.php';} 
}

if ($link_type=='multi'){
if ($_GET['page']=='pochta' AND $_GET['page_action']=='list'){require 'pochta_list.php';}
if ($_GET['page']=='pochta' AND $_GET['page_action']=='detail'){require 'pochta_detail.php';}
if ($_GET['page']=='pochta' AND $_GET['page_action']=='cart'){require 'pochta_cart.php';}
if ($_GET['page']=='pochta' AND $_GET['page_action']=='demo'){require 'demo.php';}
}
?>