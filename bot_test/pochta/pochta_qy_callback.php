<?

$event_code = $tg_users['EVENT_CODE'];
$lang = $tg_users['LANG'];
$chat_id = $tg_users['CHAT_ID'];

if ($event_code=='pochta_enter') {
	
	$zakaz_id = explode('_', $callback_code);
	
	if ($zakaz_id[0]=='ZK') {
		
		$zakaz = db::arr_s("SELECT * FROM `ac_zakaz` WHERE ID='$zakaz_id[1]'");
		$msg = "$zakaz_id[1] ZAKAZ UCHUN RASIM YUBORING: KLIENT $zakaz[CLIENT_CODE]";
		bot::sendMessage($chat_id, $msg, NULL);
		event_code("zakazphoto_".$zakaz_id[1], $chat_id);
	}
		
	
}

$zakaz_aprrove = explode("_", $tg_users['EVENT_CODE']);
	
if ($zakaz_aprrove[0] == 'zakazapprove') {
	
	if ($callback_code == 'HA') {
		// sendMessage to customer and start order accept chain
		$msg = "Rasim qabul qilindi!

KEINGI ZAKAZ NOMERINI KIRITING:";
		bot::sendMessage($chat_id, $msg, NULL);
		event_code('pochta_enter', $chat_id);
		
		db::query("UPDATE ac_zakaz SET TAKEN='1', STATUS='pochta_send' WHERE ID='$zakaz_aprrove[1]'");
		$zakaz_data = db::arr_s("SELECT * FROM ac_zakaz WHERE ID='$zakaz_aprrove[1]'");
		$user_data = db::arr_s("SELECT * FROM tg_users WHERE CODE='$zakaz_data[CLIENT_CODE]'");
		
		$msg = "ZAKAZ NOMER: <b>$zakaz_number[1]</b>
		KLIENT KOD: <b>$zakaz_data[CLIENT_CODE]</b>
		<b>$zakaz_data[WEIGHT] KG</b>  <b>$$zakaz_data[PRICE] KG</b>
		
		ZAKAZINGIZNI POCHTADAN CHIQARIB YUBORDIK!
		
		BA`TAFSIL MA`LUMOT RASIMDA KO`RSATILGAN";

		bot::sendPhoto($user_data['CHAT_ID'], $msg, NULL, $zakaz_data['POCHTA_PHOTO']);
		
	} 
	
	if ($callback_code == 'YOQ') {	
		$msg = "RASIMNI BOSHIDAN YUBORING";
		bot::sendMessage($chat_id, $msg, NULL);
		event_code("zakazphoto_".$zakaz_aprrove[1], $chat_id);
	}

}


?>