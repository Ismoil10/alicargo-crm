<?//PAGE ACTION CONTROL ?>
<?
if ($link_type=='single'){
	if ($_SESSION['page_cc'] == 'yandex_dostavka' and $_SESSION['page_action_cc']=='list'){require 'yandex_dostavka_list.php';} 
	if ($_SESSION['page_cc'] == 'yandex_dostavka' and $_SESSION['page_action_cc']=='detail'){require 'yandex_dostavka_detail.php';} 
}

if ($link_type=='multi'){
if ($_GET['page']=='yandex_dostavka' AND $_GET['page_action']=='list'){require 'yandex_dostavka_list.php';}
if ($_GET['page']=='yandex_dostavka' AND $_GET['page_action']=='detail'){require 'yandex_dostavka_detail.php';}
}
?>