<?

if ($message=='/start'){
		
}
elseif ($message=='/alicargo_guest') {
	
	db::query("UPDATE `tg_users` SET `ROLE`='guest' WHERE `CHAT_ID`='$chat_id'");
	$msg = "FOYDALANUVCHI RO`LIGA O`TDINGIZ";
	$kyb = pochta_kyb::remove_keyboard();
	bot::sendMessage($chat_id,$msg,$kyb);
	event_code('draft', $chat_id);
	
} elseif ($message=='/menu') {
	
	$msg = "POCHTA PANELGA XUSH KELIBSIZ!
	
	PROTSESGA TUSHGAN ZAKAZ NOMERINI KIRITING";
	//$kyb = guest_kyb::admin();
	bot::sendMessage($chat_id, $msg, NULL);
	event_code('pochta_enter', $chat_id);
	
	
} else {
	
	if ($tg_users['EVENT_CODE'] == 'pochta_enter') {
		
		$msg = "Zakazlar:";
		$kyb = pochta_kyb::zakaz_list($message);
			
			if ($kyb == "null") {
				bot::sendMessage($chat_id, "ZAKAZ TOPILMADI!", NULL);
			} else {
				bot::sendMessage($chat_id, $msg, $kyb);
			}
			
		/*
		if ($message == 'ZAKAZ') {
			
			$msg = "ZAKAZ NOMERINI KIRITING";
			//$kyb = admin_kyb::admin();
			bot::sendMessage($chat_id, $msg, NULL);
			event_code('zakaz_search', $chat_id);
			
		}
		*/
		
	}
	
	$zakaz_number = explode("_", $tg_users['EVENT_CODE']);
	if ($zakaz_number[0] == 'zakazphoto') {
	
	if (isset($output['message']['photo'])) {
		
		$photo = bot::getHighQuality($output['message']['photo']);
		
		$zakaz_details = db::arr_s("SELECT * FROM `ac_zakaz` WHERE ID='$zakaz_number[1]'");
		
		db::query("UPDATE `ac_zakaz` SET `POCHTA_PHOTO`='$photo[file_id]' WHERE ID='$zakaz_number[1]'");
		
		//bot::sendPhoto($chat_id, '', NULL, $photo);
		//$file_id = "AgACAgIAAxkBAAIEP2PQ8OzKbXI70lk9S192Og-ucl7zAALNwzEbJYuIStCvsahUrHy3AQADAgADeQADLQQ";
$msg = "ZAKAZ NOMER: <b>$zakaz_number[1]</b>
KLIENT KOD: <b>$zakaz_details[CLIENT_CODE]</b>
<b>$zakaz_details[WEIGHT] KG</b>  <b>$$zakaz_details[PRICE] KG</b>

ZAKAZINGIZNI POCHTADAN CHIQARIB YUBORDIK!

TASDIQLASH UCHUN HA TUGMASINI BOSING! BOSHIDAN OLISH UCHUN YO`Q NI BOSING";

		$kyb = pochta_kyb::yes_no();
		bot::sendPhoto($chat_id, $msg, $kyb, $photo['file_id']);
		event_code("zakazapprove_".$zakaz_number[1], $chat_id);

	} else {
		//$msg = guest_msg::ask_passport($tg_users['LANG']);
		bot::sendMessage($chat_id, "XATO! RASIM JONATING", NULL);
	}
	
	}
	
	if ($tg_users['EVENT_CODE'] == 'zakaz_search') {
		
		//bot::sendMessage($chat_id, "Hell", NULL);
		/*	
		$orders = db::arr("SELECT * FROM `ac_zakaz`");
		
		foreach ($orders as $o) {
			$zakaz_ids[] = $o['ID'];
		}
		
		if (in_array($message, $zakaz_ids)) {
		*/	
			$msg = "Zakazlar:";
			$kyb = admin_kyb::zakaz_list($message);
				
				if ($kyb == "null") {
					bot::sendMessage($chat_id, "ZAKAZ TOPILMADI!", NULL);
				} else {
					bot::sendMessage($chat_id, $msg, $kyb);
				}
			
			
			//event_code('zakaz_search', $chat_id);
		/*	
		} else {
			
			$msg = "ZAKAZ TOPILMADI!";
			bot::sendMessage($chat_id, $msg, NULL);
			
		}
		*/
		
	}
	
}

?>