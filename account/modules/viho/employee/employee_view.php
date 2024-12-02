<?
if ($link_type=='single'){
	if ($_SESSION['page_cc'] == 'employee' and $_SESSION['page_action_cc']=='list'){require 'employee_list.php';} 
	if ($_SESSION['page_cc'] == 'employee' and $_SESSION['page_action_cc']=='detail'){require 'employee_detail.php';} 
}

if ($link_type=='multi'){
if ($_GET['page']=='employee' AND $_GET['page_action']=='list'){require 'employee_list.php';}
if ($_GET['page']=='employee' AND $_GET['page_action']=='detail'){require 'employee_detail.php';}
}
?>