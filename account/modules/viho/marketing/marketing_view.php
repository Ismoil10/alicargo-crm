<?//PAGE ACTION CONTROL ?>
<?
if ($link_type=='single'){
	if ($_SESSION['page_cc'] == 'marketing' and $_SESSION['page_action_cc']=='list'){require 'marketing_list.php';} 
	if ($_SESSION['page_cc'] == 'marketing' and $_SESSION['page_action_cc']=='detail'){require 'marketing_detail.php';} 
}

if ($link_type=='multi'){
if ($_GET['page']=='marketing' AND $_GET['page_action']=='list'){require 'marketing_list.php';}
if ($_GET['page']=='marketing' AND $_GET['page_action']=='detail'){require 'marketing_detail.php';}
}
?>