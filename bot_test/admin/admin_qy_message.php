<?

if ($message=='/start'){
		
}
elseif ($message=='/alicargo_guest') {
	
	db::query("UPDATE `tg_users` SET `ROLE`='guest', `STATUS`='new' WHERE `CHAT_ID`='$chat_id'");
	$msg = "FOYDALANUVCHI RO`LIGA O`TDINGIZ";
	$kyb = admin_kyb::remove_keyboard();
	bot::sendMessage($chat_id,$msg,$kyb);
	event_code('draft', $chat_id);
	
} else {
	
	if ($tg_users['EVENT_CODE'] == 'admin_enter') {
		
		$msg = "Zakazlar:";
		$kyb = admin_kyb::zakaz_list($message);
			
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
		if($tg_users['ROLE'] == 'admin'){
			if($message == 'Rassilka yuborish'){
				//$msg = admin_msg::send_doc($tg_users['LANG']);
				$msg = "<b>Rassilka yubormoqchimisiz?</b>";
				$kyb = admin_kyb::send_letter();
				//$kyb = guest_kyb::send_video($tg_users['LANG']);
				bot::sendMessage($chat_id, $msg, $kyb);
				event_code('send_letter', $chat_id);
			}
		
	}

	}

	if($tg_users['EVENT_CODE'] == 'send_letter'){
		if($message == "Ha"){
		$msg = admin_msg::send_doc($tg_users['LANG']);
		$kyb = admin_kyb::delete_keyboard();
		bot::sendMessage($chat_id, $msg, $kyb);
		event_code('send_doc', $chat_id);
		}else{
		$msg = "<b>Rassilka yuborish bekor qilindi</b>";
		$kyb = admin_kyb::rassilka();
		bot::sendMessage($chat_id, $msg, $kyb);
		event_code('admin_enter', $chat_id);
		}
	}

	if($tg_users['EVENT_CODE'] == 'send_doc'){
		if(isset($output['message'])){
			/*if (isset($output['message']['video'])){
	
				bot::sendVideoCaption($chat_id, $video, $caption);	
			}
			if (isset($output['message']['document'])){
	
				bot::sendDocumentCaption($chat_id, $doc, $caption);	
			}
			if (isset($output['message']['photo'])){
	
				bot::sendPhoto($chat_id, $caption, NULL, $file_id);	
			}
			if (isset($output['message']['text'])){

				bot::sendMessage($chat_id, $message, NULL);	
			}*/
			bot::forwardMessage($chat_id, $from_id, $msg_id);
			
			//$msg_idw = $msg_id+1;
			//$jsn = json_encode($mes);

			db::query("INSERT INTO `tg_rassilka` (`CREATED_DATE`, `FROM_CHAT_ID`, `MESSAGE_ID`) VALUES (now(), '$from_id', '$msg_id')");
			
			$msg = admin_msg::confirm_doc($tg_users['LANG']);
			$kyb = admin_kyb::confirm_doc($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, $kyb);
			event_code("confirm_doc", $chat_id);
		}
	}
	
	$zakaz_number = explode("_", $tg_users['EVENT_CODE']);
	if ($zakaz_number[0] == 'zakazphoto') {
	
	if (isset($output['message']['photo'])) {
		
		$photo = bot::getHighQuality($output['message']['photo']);
		
		$zakaz_details = db::arr_s("SELECT * FROM `ac_zakaz` WHERE ID='$zakaz_number[1]'");
		
		db::query("UPDATE `ac_zakaz` SET `TOVAR_PHOTO`='$photo[file_id]' WHERE ID='$zakaz_number[1]'");
		
		//bot::sendPhoto($chat_id, '', NULL, $photo);
		//$file_id = "AgACAgIAAxkBAAIEP2PQ8OzKbXI70lk9S192Og-ucl7zAALNwzEbJYuIStCvsahUrHy3AQADAgADeQADLQQ";
$msg = "ZAKAZ NOMER: <b>$zakaz_number[1]</b>
KLIENT KOD: <b>$zakaz_details[CLIENT_CODE]</b>

<b>$zakaz_details[WEIGHT] KG</b>  <b>$$zakaz_details[PRICE] KG</b>

TASDIQLASH UCHUN HA TUGMASINI BOSING! BOSHIDAN OLISH UCHUN YO`Q NI BOSING";

		$kyb = admin_kyb::yes_no();
		bot::sendPhoto($chat_id, $msg, $kyb, $photo['file_id']);


		$url = getTrackCodes($zakaz_number[1], "order");

		$codes = "Ваши трек-коды. <a href='$url'>Скачать</a>";

		bot::sendMessage($chat_id, $codes, null);

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