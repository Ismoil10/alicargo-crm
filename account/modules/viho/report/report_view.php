<?//PAGE ACTION CONTROL ?>
<?
if ($link_type=='single'){
	if ($_SESSION['page_cc'] == 'report' and $_SESSION['page_action_cc']=='list'){require 'report_list.php';} 
	if ($_SESSION['page_cc'] == 'report' and $_SESSION['page_action_cc']=='detail'){require 'report_detail.php';} 
}

if ($link_type=='multi'){
if ($_GET['page']=='report' AND $_GET['page_action']=='list'){require 'report_list.php';}
if ($_GET['page']=='report' AND $_GET['page_action']=='detail'){require 'report_detail.php';}
}
?>