<?//PAGE ACTION CONTROL ?>
<?
if ($link_type=='single'){
	if ($_SESSION['page_cc'] == 'adminka' and $_SESSION['page_action_cc']=='list'){require 'adminka_list.php';} 
	if ($_SESSION['page_cc'] == 'adminka' and $_SESSION['page_action_cc']=='detail'){require 'adminka_detail.php';} 
}

if ($link_type=='multi'){
if ($_GET['page']=='adminka' AND $_GET['page_action']=='list'){require 'adminka_list.php';}
if ($_GET['page']=='adminka' AND $_GET['page_action']=='detail'){require 'adminka_detail.php';}
}
?>