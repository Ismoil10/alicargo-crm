<?
if ($link_type=='single'){
	if ($_SESSION['page_cc'] == 'orders_report' and $_SESSION['page_action_cc']=='list'){require 'orders_report_list.php';} 
	if ($_SESSION['page_cc'] == 'orders_report' and $_SESSION['page_action_cc']=='detail'){require 'orders_report_detail.php';} 
}

if ($link_type=='multi'){
  if ($_GET['page']=='orders_report' AND $_GET['page_action']=='list'){require 'orders_report_list.php';}
  if ($_GET['page']=='orders_report' AND $_GET['page_action']=='detail'){require 'orders_report_detail.php';}
}
?>