<?//PAGE ACTION CONTROL ?>
<?
if ($link_type=='single'){
	if ($_SESSION['page_cc'] == 'tg_rassilka' and $_SESSION['page_action_cc']=='list'){require 'tg_rassilka_list.php';} 
	if ($_SESSION['page_cc'] == 'tg_rassilka' and $_SESSION['page_action_cc']=='detail'){require 'tg_rassilka_detail.php';} 
}

if ($link_type=='multi'){
if ($_GET['page']=='tg_rassilka' AND $_GET['page_action']=='list'){require 'tg_rassilka_list.php';}
if ($_GET['page']=='tg_rassilka' AND $_GET['page_action']=='detail'){require 'tg_rassilka_detail.php';}
}
?>