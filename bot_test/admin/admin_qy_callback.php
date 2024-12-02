<?

$event_code = $tg_users['EVENT_CODE'];
$lang = $tg_users['LANG'];
$chat_id = $tg_users['CHAT_ID'];
$role = $tg_users['ROLE'];

if ($event_code=='admin_enter') {
	
	$zakaz_id = explode('_', $callback_code);
	
	if ($zakaz_id[0]=='ZK') {
		
		$zakaz = db::arr_s("SELECT * FROM `ac_zakaz` WHERE ID='$zakaz_id[1]'");
		$msg = "$zakaz_id[1] ZAKAZ UCHUN RASIM YUBORING: KLIENT $zakaz[CLIENT_CODE]";
		bot::sendMessage($chat_id, $msg, NULL);
		event_code("zakazphoto_".$zakaz_id[1], $chat_id);
	}
		
	
}

if($role == 'admin'){
if($event_code == 'confirm_doc'){
	if($callback_code == 'send'){

	$file_id = db::arr_s("SELECT * FROM tg_rassilka ORDER BY ID ASC");

	$all_users = db::arr("SELECT * FROM tg_users");

	foreach($all_users as $v){

	$last_id = $file_id['ID'];
	$user_id = $v['ID'];
	$user_chat_id = $v['CHAT_ID'];

		db::query("INSERT INTO `message_log` 
		(`CREATE_DATE`,
		`TYPE`,
		`RASSILKA_ID`,
		`USER_ID`,
		`CHAT_ID`
		) VALUES (
		 now(),
		'all',
		'$last_id',
		'$user_id',
		'$user_chat_id'
		)");
	}
	$msg = admin_msg::finish_doc($tg_users['LANG']);
	$kyb = admin_kyb::rassilka();
	bot::sendMessage($chat_id, $msg, $kyb);
	event_code("admin_enter", $chat_id);
}

if($callback_code == 'cancel'){
	/*$msg = admin_msg::cancel_doc($tg_users['LANG']);*/
	$msg = "<b>Jo'natma bekor qilindi</b>";
	$kyb = admin_kyb::rassilka();
	bot::sendMessage($chat_id, $msg, $kyb);
	event_code("admin_enter", $chat_id);
}
}
}

$zakaz_aprrove = explode("_", $tg_users['EVENT_CODE']);
	
if ($zakaz_aprrove[0] == 'zakazapprove') {
	
	if ($callback_code == 'HA') {
		// sendMessage to customer and start order accept chain
		$msg = "Rasim qabul qilindi!

KEINGI ZAKAZ NOMERINI KIRITING:";
		bot::sendMessage($chat_id, $msg, NULL);
		event_code('admin_enter', $chat_id);
		
		db::query("UPDATE ac_zakaz SET STATUS='tovar_photo_added' WHERE ID='$zakaz_aprrove[1]'");
		$zakaz_data = db::arr_s("SELECT * FROM ac_zakaz WHERE ID='$zakaz_aprrove[1]'");
		$user_data = db::arr_s("SELECT * FROM tg_users WHERE CODE='$zakaz_data[CLIENT_CODE]'");
		
		$msg = admin_msg::zakaz_status($user_data['LANG'], $zakaz_aprrove[1]);
		$kyb = admin_kyb::zakaz_button($user_data['LANG']);
		bot::sendMessage($user_data['CHAT_ID'], $msg, $kyb);
		event_code('main_menu', $user_data['CHAT_ID']);
	} 
	
	if ($callback_code == 'YOQ') {	
		$msg = "RASIMNI BOSHIDAN YUBORING";
		bot::sendMessage($chat_id, $msg, NULL);
		event_code("zakazphoto_".$zakaz_aprrove[1], $chat_id);
	}

}


?>