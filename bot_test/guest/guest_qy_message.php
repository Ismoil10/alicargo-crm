<?

if ($message=='/start' or $message=='\/start'){
	
	if ($tg_users['STATUS'] == 'new') {
	$msg = guest_msg::lang();
	$kyb = guest_kyb::lang();
	bot::sendMessage($chat_id, $msg,$kyb);
	event_code('choose_lang', $chat_id);
	}
	
	if ($tg_users['STATUS'] == 'draft') {
	bot::sendMessage($chat_id, guest_msg::wait_confirm($tg_users['LANG']), NULL);
	//$msg = admin_msg::zakaz_status($tg_users['LANG'], $zakaz_aprrove[1]);
	//$kyb = admin_kyb::zakaz_button($tg_users['LANG']);
	//bot::sendMessage($tg_users['CHAT_ID'], 'Asosiy menu', $kyb);
	//event_code('main_menu', $tg_users['CHAT_ID']);
	}
	
	if ($tg_users['STATUS'] == 'pay_wait') {
	$msg = guest_msg::pay_wait($tg_users['LANG']);
	bot::sendMessage($chat_id, $msg, NULL);
	}
	
	if ($tg_users['STATUS'] == 'ask_pochta') {
	//bot::sendMessage($chat_id, guest_msg::wait_confirm($tg_users['LANG']), NULL);
	//$msg = admin_msg::zakaz_status($tg_users['LANG'], $zakaz_aprrove[1]);
	$kyb = admin_kyb::zakaz_button($tg_users['LANG']);
	bot::sendMessage($tg_users['CHAT_ID'], 'Asosiy menu', $kyb);
	event_code('main_menu', $tg_users['CHAT_ID']);
	}
	
} elseif (($message=='/menu' OR $message=='\/menu') AND $tg_users['CODE']!=NULL) {
	$msg = guest_msg::menu_word($tg_users['LANG']);
	$kyb = admin_kyb::zakaz_button($tg_users['LANG']);
	bot::sendMessage($tg_users['CHAT_ID'], $msg, $kyb);
	event_code('main_menu', $tg_users['CHAT_ID']);
}
elseif($message == "/id"){
	bot::sendMessage($tg_users['CHAT_ID'], $tg_users['ROLE'],null);
} elseif ($message=='/alicargo_admin'){

	$msg = "MAXFIY KODNI KIRITING:";
	// $kyb = guest_kyb::lang();
	db::query("UPDATE `tg_users` SET `STATUS`='ask_admin' WHERE `CHAT_ID`='$chat_id'");
	bot::sendMessage($chat_id,$msg,NULL);
	event_code('write_password', $chat_id);

}

elseif ($message=='/alicargo_pochta'){

	$msg = "MAXFIY KODNI KIRITING:";
	// $kyb = guest_kyb::lang();
	db::query("UPDATE `tg_users` SET `STATUS`='ask_pochta' WHERE `CHAT_ID`='$chat_id'");
	bot::sendMessage($chat_id,$msg,NULL);
	event_code('write_password_pochta', $chat_id);

} elseif($message == "/admin"){

		$select_admin = db::arr_s("SELECT * FROM ac_adminka WHERE PHONE = '$tg_users[PHONE]' AND ACTIVE = 1");
		if($tg_users['PHONE'] == $select_admin['PHONE']){
			//$json = json_encode($select_admin);
			$msg = guest_msg::admin_role($tg_users['LANG']);
			$kyb = guest_kyb::user_reports($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, $kyb);
			event_code('user_reports', $chat_id);
		}else{
			$msg = guest_msg::admin_role_not_found($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, NULL);
		}
	}
else {


	if ($tg_users['EVENT_CODE'] == 'write_password' AND $tg_users['STATUS'] == 'ask_admin') {
			
		if ($message == "admin123456789") {
			db::query("UPDATE `tg_users` SET `ROLE`='admin' WHERE `CHAT_ID`='$chat_id'");
			$msg = "ADMIN PANELGA XUSH KELIBSIZ!

ZAKAZ NOMERINI KIRITING";
			$kyb = guest_kyb::rassilka();
			bot::sendMessage($chat_id, $msg, $kyb);
			event_code('admin_enter', $chat_id);
		} else {
			$msg = "PAROL NOTOG`RI";
			bot::sendMessage($chat_id, $msg, NULL);
			event_code('draft', $chat_id);
		}
		
	}


	
	if($tg_users['EVENT_CODE'] == 'send_location'){
		if(isset($output['message']['location'])){
			
			$order_data = db::arr_s("SELECT * FROM ac_zakaz WHERE ID = '$tg_users[CURRENT_ORDER]'");

			db::query("UPDATE `ac_location` SET 
			`LATITUDE` = '$latitude', 
			`LONGITUDE` = '$longitude', 
			`STATUS` = 'process' WHERE 
			`CHAT_ID` = '$chat_id' 
			AND `STATUS`='new' 
			AND `ACTIVE` = '1'");

			// $msg = guest_msg::get_location($tg_users['LANG']);
			// bot::sendMessage($chat_id, $msg, null);
			// event_code("main_menu", $chat_id);
			if($order_data['DELIVERY_TYPE'] == 'yandex'){
				$msg = guest_msg::order_detail($tg_users['LANG'], $order_data);
				bot::sendPhoto($chat_id, $msg, NULL, $order_data['TOVAR_PHOTO']);
				$msg = guest_msg::zakaz_payment($tg_users['LANG'], $order_data);
				bot::sendMessage($chat_id, $msg, NULL);
				event_code('wait_zakaz_payment', $chat_id);
			}else{
				$msg = guest_msg::payment_type($tg_users['LANG']);
				$kyb = guest_kyb::card_type($tg_users['LANG']);
				bot::sendMessage($chat_id, $msg, $kyb);
				event_code('pickup_payment', $chat_id);
				
			}
		}else{
			bot::sendMessage($chat_id, '<b>Пожалуйста, отправьте локацию!</b>', NULL);
		}
	}
	if($tg_users['EVENT_CODE'] == 'send_video'){
		if (isset($output['message']['video'])){
			$video = $output['message']['video']['file_id'];
			$caption = $output['message']['caption'];

			$msg = guest_msg::confirm_video($tg_users['LANG']);
			$kyb = guest_kyb::confirm_video($tg_users['LANG']);

			$insert = db::query("INSERT INTO `tg_rassilka` (`CREATED_DATE`, `TEXT`, `FILE_URL`) VALUES (now(), '$caption', '$video')");
			bot::sendVideoCaption($chat_id, $video, $caption);
			bot::sendMessage($chat_id, $msg, $kyb);
			event_code("confirm_video", $chat_id);
		}
	}

	if($tg_users['EVENT_CODE'] == 'confirm_video'){
		if(in_array($message, ["Отправить", "Yuborilsin"])){

		/*$insert = db::query("INSERT INTO `tg_rassilka` (`CREATED_DATE`, `TEXT`, `FILE_URL`) VALUES (now(), '$caption', '$video')");

		$tg_users = db::arr("SELECT * FROM tg_users WHERE CHAT_ID = '1586146743'");

		foreach($tg_users as $v){

		$last_id = $insert['ID'];
		$user_id = $v['ID'];
		$user_chat_id = $v['CHAT_ID'];

			db::query("INSERT INTO `message_log` 
			(`CREATE_DATE`,
			`TYPE`,
			`RASSILKA_ID`,
			`USER_ID`,
			`CHAT_ID`,
			) VALUES (
			now(),
			'all',
			'$last_id',
			'$user_id',
			'$user_chat_id'
			)");
		}*/
		$msg = guest_msg::finish_video($tg_users['LANG']);
		$kyb = guest_kyb::delete_keyboard();
		bot::sendMessage($chat_id, $insert['ID'], NULL);
		event_code("send_video", $chat_id);
	}
	}

	if ($tg_users['EVENT_CODE'] == 'write_password_pochta' AND $tg_users['STATUS'] == 'ask_pochta') {
				
		if ($message == "pochta123456789") {
			db::query("UPDATE `tg_users` SET `ROLE`='pochta' WHERE `CHAT_ID`='$chat_id'");
			$msg = "POCHTA PANELGA XUSH KELIBSIZ!

PROTSESGA TUSHGAN ZAKAZ NOMERINI KIRITING";
			//$kyb = guest_kyb::admin();
			bot::sendMessage($chat_id, $msg, NULL);
			event_code('pochta_enter', $chat_id);
		} else {
			$msg = "PAROL NOTOG`RI";
			bot::sendMessage($chat_id, $msg, NULL);
			event_code('draft', $chat_id);
		}
		
	}
	
	if ($tg_users['EVENT_CODE'] == 'main_menu') {
		
		if (in_array($message, ["Мои заказы", "Mening zakazlarim"])) {
			
			//$zakaz_list = db::arr("SELECT * FROM ac_zakaz WHERE CLIENT_CODE='$tg_users[CODE]' AND TAKEN<>'1' AND TOVAR_PHOTO IS NOT NULL AND PAYMENT_PHOTO IS NULL AND PAID<>'1'");
			$zakaz_list = db::arr("SELECT * FROM ac_zakaz WHERE CLIENT_CODE='$tg_users[CODE]' AND TAKEN<>'1' AND PAID<>'1'");
			$delivery = db::arr_s("SELECT * FROM ac_location WHERE ORDER_ID = '$tg_users[CURRENT_ORDER]' AND ACTIVE = 1");

			if (isset($zakaz_list[0]['ID']) and empty($delivery)) {
			$msg = guest_msg::zakaz_list($tg_users['LANG']);
			$kyb = guest_kyb::zakaz_list($zakaz_list);
			event_code('start_zakaz_payment', $chat_id);
			} else {
			$msg = guest_msg::zakaz_not_found($tg_users['LANG']);
			$kyb = NULL;
			}
			bot::sendMessage($chat_id, $msg, $kyb);
			
		}
		
	}
	
	if ($tg_users['EVENT_CODE'] == 'wait_zakaz_adres') {
			
			db::query("UPDATE `tg_users` SET `ADRES`='$message' WHERE `CHAT_ID`='$chat_id'");
			$msg = guest_msg::confirm_address($tg_users['LANG'], $message);
			$kyb = guest_kyb::confirm_address($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, $kyb);
			event_code('confirm_address', $chat_id);
			
	}
	
	if ($tg_users['EVENT_CODE'] == 'wait_zakaz_payment') {
		
		if (isset($output['message']['photo'])) {
			
			$photo = bot::getHighQuality($output['message']['photo']);
			$code = get_code($tg_users['ID']);
			
			db::query("UPDATE `ac_zakaz` SET `PAYMENT_PHOTO`='$photo[file_id]',`LAST_MODIFIED`=now(), `STATUS`='pay_approve' WHERE ID='$tg_users[CURRENT_ORDER]'");
			
			$msg = guest_msg::pay_wait($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, NULL);
			
			$msg = guest_msg::menu_word($tg_users['LANG']);
			$kyb = admin_kyb::zakaz_button($tg_users['LANG']);
			bot::sendMessage($tg_users['CHAT_ID'], $msg, $kyb);
			event_code('main_menu', $tg_users['CHAT_ID']);	
			//event_code('wait_zakaz_payment',$chat_id);
			
		} else {
			//$msg = guest_msg::ask_passport($tg_users['LANG']);
			bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
		}
		
	}
	
	if (in_array($tg_users['EVENT_CODE'],['choose_lang','change_lang'])){
		
		if ($message == 'O`zbek tili 🇺🇿'){
			$lang = 'uz';
			$update_lang = db::query("UPDATE `tg_users` SET `LANG` = 'uz' WHERE CHAT_ID='$chat_id'");
		}
		
		if ($message == 'Русский язык 🇷🇺'){
			$lang = 'ru';
			$update_lang = db::query("UPDATE `tg_users` SET `LANG` = 'ru' WHERE CHAT_ID='$chat_id'");
		}
		
		if (in_array($message, ['O`zbek tili 🇺🇿','Русский язык 🇷🇺'])) {
			
			if ($tg_users['EVENT_CODE']=='choose_lang') {
				
				$msg = guest_msg::welcome($lang);
				$kyb = guest_kyb::delete_keyboard();
				bot::sendMessage($chat_id, $msg, $kyb);				
				
				$msg = guest_msg::start($lang);
				$kyb = guest_kyb::start($lang);
				bot::sendMessage($chat_id, $msg, $kyb);
				event_code('reg', $chat_id);
			}
			
			if ($tg_users['EVENT_CODE']=='change_lang') {
				$msg = guest_msg::menu($lang);
				$kyb = guest_kyb::main_menu($lang);
				bot::sendMessage($chat_id, $msg,$kyb);
				event_code('main_menu', $chat_id);
			}
			
		} else {
			bot::sendMessage($chat_id, guest_msg::error(),null);
		}
		
	}
	
	if ($tg_users['EVENT_CODE'] == 'reg_start') {
		
	if ($tg_users['STATUS'] == 'new') {
		
	$msg = guest_msg::start($tg_users['LANG']);
	$kyb = guest_kyb::start($tg_users['LANG']);
	bot::sendMessage($chat_id, $msg, $kyb);
	event_code('reg', $chat_id);
	
	}
	
	if ($tg_users['STATUS'] == 'draft') {
		
	bot::sendMessage($chat_id, guest_msg::wait_confirm($tg_users['LANG']), NULL);
	
	}
}

	if ($tg_users['EVENT_CODE'] == 'ask_name') {
		
		if (isset($output['message']['text'])) {
			
			db::query("UPDATE `tg_users` SET `ISM_FAMILIYA`='$message' WHERE CHAT_ID='$chat_id'");
			
			$msg = guest_msg::ask_phone($tg_users['LANG']);
			$kyb = guest_kyb::zakaz_button($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, $kyb);
			event_code('main_menu', $chat_id);
		} else {
			bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
		}
		
	}
	
	if ($tg_users['EVENT_CODE'] == 'ask_phone') {
		
		if (isset($output['message']['text'])) {
			
			$formatted = preg_replace('/[^0-9.]+/', '', $output['message']['text']); // stringda faqat sonlarni qoldirish uchun
			
			// telefon raqamni 12 xonalik sonligini tekshirish uchun shartli operator
			if (strlen($formatted)==12) {
				db::query("UPDATE `tg_users` SET `PHONE`='$formatted' WHERE CHAT_ID='$chat_id'");
				
				$msg = guest_msg::ask_adres($tg_users['LANG']);
				bot::sendMessage($chat_id, $msg, NULL);
				event_code('ask_adres', $chat_id);
			} else {
				bot::sendMessage($chat_id, guest_msg::phone_valid($tg_users['LANG']), NULL);
			}
			
		} else {
			bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
		}
		
	}
	
	/*if($tg_users['EVENT_CODE'] == "ask_network"){
		if (isset($output['message']['text'])){
			if($message == "Slash admin"){
			$select_admin = db::arr_s("SELECT * FROM ac_adminka WHERE PHONE = '$tg_users[PHONE]' AND ACTIVE = 1");
			if($tg_users['PHONE'] == $select_admin['PHONE']){
				$json = json_encode($select_admin);
				bot::sendMessage($chat_id, $json, NULL);
			}else{
				bot::sendMessage($chat_id, "Not found", NULL);
			}
		}
	}
	}*/

	if ($tg_users['EVENT_CODE'] == 'ask_adres') {
		
		if (isset($output['message']['text'])) {
			
			db::query("UPDATE `tg_users` SET `ADRES`='$message' WHERE CHAT_ID='$chat_id'");
			
			$kyb = guest_kyb::social_networks($tg_users['LANG']);
			$msg = guest_msg::ask_network($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, $kyb);	
			event_code('ask_network', $chat_id);
			
		} else {
			bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
		}
		
	}

	/*if($tg_users['EVENT_CODE'] == 'ask_network'){
		
	}*/

	if($tg_users['EVENT_CODE'] == 'user_reports'){
		
		if(in_array($message, ["База клиентов", "Mijozlar bazasi"])){
			
			$admin = db::arr_s("SELECT * FROM ac_adminka WHERE PHONE='$tg_users[PHONE]'");
			
			$url = generateUrl($admin["ID"], "admin_users", '04.2024');

			$message = "База клиентов <a href='$url'>Скачать</a>";
			bot::sendMessage($chat_id, $message, NULL);
		}
		
		if(in_array($message, ["Добавить нового клиента", "Yangi mijoz"])){
				$msg = guest_msg::add_user($tg_users['LANG']);
				$kyb = guest_kyb::add_user($tg_users['LANG']);
				bot::sendMessage($chat_id, $msg, $kyb);
				event_code('add_user', $chat_id);
		
		}
		
	if(in_array($message, ["Текущий отчет", "Joriy xisobot"])){

		$admin = db::arr_s("SELECT * FROM ac_adminka WHERE PHONE = '$tg_users[PHONE]' AND ACTIVE = 1");
		
		$msg = guest_msg::current_report($tg_users['LANG']);
		$kyb = guest_kyb::current_report($tg_users['LANG'], $tg_users['PHONE']);
		bot::sendMessage($chat_id, $msg, $kyb);
		//event_code('current_reports', $chat_id);
	}

	if(in_array($message, ["Назад", "Ortga"])){
		$msg = guest_msg::menu_word($tg_users['LANG']);
		$kyb = admin_kyb::zakaz_button($tg_users['LANG']);
		bot::sendMessage($tg_users['CHAT_ID'], $msg, $kyb);
		event_code('main_menu', $tg_users['CHAT_ID']);
		//event_code('ask_network', $chat_id);

		//$msg = guest_msg::ask_network($tg_users['LANG']);
		//$kyb = guest_kyb::social_networks($tg_users['LANG']);
		//bot::sendMessage($chat_id, $message, null);
	}
	}

	if ($tg_users['EVENT_CODE'] == 'add_user') {
		if (isset($output['message']['text']) and $message != "Назад" and $message != "Ortga") {
			
			$phone = $output['message']['text'];

			$formatted = preg_replace('/[^0-9.]+/', '', $output['message']['text']); // stringda faqat sonlarni qoldirish uchun
			
			// telefon raqamni 12 xonalik sonligini tekshirish uchun shartli operator
			if (strlen($formatted)==12) {
			
			$new_user = db::arr_s("SELECT * FROM new_tg_users WHERE USER_PHONE = '$formatted' AND ACTIVE =1");
			$admin = db::arr_s("SELECT * FROM ac_adminka WHERE PHONE='$tg_users[PHONE]'");
			
			if ($formatted == $new_user['USER_PHONE']){
				$msg = guest_msg::connected_user($tg_users['LANG']);
				bot::sendMessage($chat_id, $msg, NULL);
			} else {
				
				$select_tgs = db::arr_s("SELECT * FROM tg_users WHERE PHONE='$formatted'");
				
				if ($select_tgs['PHONE']==$formatted) {
					$sql = "INSERT INTO `new_tg_users` (`CREATE_DATE`, `USER_CONNECTED_DATE`, `ADMIN_ID`, `USER_PHONE`, `USER_ID`, `USER_CODE`, `ACTIVE`) VALUES (now(), now(), '$admin[ID]', '$formatted', '$select_tgs[ID]','$select_tgs[CODE]', '1')";
				} else {
					$sql = "INSERT INTO `new_tg_users` (`CREATE_DATE`, `USER_CONNECTED_DATE`, `ADMIN_ID`, `USER_PHONE`, `ACTIVE`) 
					VALUES (now(), NULL, '$admin[ID]', '$formatted', '1')";
				}
				$insert = db::query($sql);
				
				$msg = guest_msg::add_phone($tg_users['LANG']);
				bot::sendMessage($chat_id, $msg, NULL);
				$kyb = guest_kyb::user_reports($tg_users['LANG']);
				$msg = guest_msg::adminka_menu($tg_users['LANG']);
				bot::sendMessage($chat_id, $msg, $kyb);
				event_code('user_reports', $chat_id);
			}
			
		} else {
			bot::sendMessage($chat_id, guest_msg::phone_valid($tg_users['LANG']), NULL);
		}
		}
		if(in_array($message, ["Назад", "Ortga"])){
			$kyb = guest_kyb::user_reports($tg_users['LANG']);
			$msg = guest_msg::adminka_menu($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, $kyb);
			event_code('user_reports', $chat_id);
		}
	}
	
	if ($tg_users['EVENT_CODE'] == 'ask_passport') {
		
		if (isset($output['message']['photo'])) {
			
			$photo = bot::getHighQuality($output['message']['photo']);
			
			db::query("UPDATE `tg_users` SET `P_PHOTO_1`='$photo[file_id]' WHERE CHAT_ID='$chat_id'");
			
			//bot::sendPhoto($chat_id, '', NULL, $photo);
			
			$msg = guest_msg::ask_passport2($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, NULL);
				
			$file_id = "AgACAgIAAxkBAAIEP2PQ8OzKbXI70lk9S192Og-ucl7zAALNwzEbJYuIStCvsahUrHy3AQADAgADeQADLQQ";
			bot::sendPhoto($chat_id, NULL, NULL, $file_id);
			event_code('ask_passport2', $chat_id);
		} else {
			//$msg = guest_msg::ask_passport($tg_users['LANG']);
			bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
		}
		
	}
	
	if ($tg_users['EVENT_CODE'] == 'ask_passport2') {
		
		if (isset($output['message']['photo'])) {
			
			$photo = bot::getHighQuality($output['message']['photo']);
			
			db::query("UPDATE `tg_users` SET `P_PHOTO_2`='$photo[file_id]' WHERE CHAT_ID='$chat_id'");
			
			//bot::sendPhoto($chat_id, '', NULL, $photo);
			
			/*
			$msg = guest_msg::ask_payment($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, NULL);
			event_code('ask_payment', $chat_id);
			*/
			
			$get_id = db::arr_s("SELECT * FROM `tg_users` WHERE `CODE` IS NULL AND ID>100 ORDER BY ID DESC");
			
			$delete_row = db::query("DELETE FROM `tg_users` WHERE ID='$get_id[ID]'");
			
			$code = get_code($get_id['ID']);
			
			db::query("UPDATE `tg_users` SET 
			`ID`='$get_id[ID]',
			`CODE`='$code',
			`UPDATE_DATE`=now(),
			`PAID`='1', 
			`STATUS`='paid'
			WHERE `ID`='$tg_users[ID]'");
			
			$sql = "INSERT INTO `tg_users` (`ID`,`CODE`,`CREATE_DATE`,`CHAT_ID`)VALUES ('$tg_users[ID]',NULL,now(),NULL)";
			$ins = db::query($sql);
			
			$tg_users = db::arr_s("SELECT * FROM `tg_users` WHERE `ID`='$get_id[ID]'");
				
				$code = get_code($tg_users['ID']);
				
				db::query("UPDATE `tg_users` SET `UPDATE_DATE`=now(), `CODE`='$code' WHERE CHAT_ID='$chat_id'");
							
				$msg = guest_msg::sklad_message($tg_users['LANG'], $code);
							
				bot::sendMessage($tg_users['CHAT_ID'], $msg, NULL);
								
$msg = "唛头：$code 
地址：广州市白云区江高镇珠江村沙滘路九巷36号 $code 
手机号：13922559194
收货人: $code";

				bot::sendMessage($tg_users['CHAT_ID'], $msg, NULL);
				/*	
				if ($tg_users['LANG']=='uz') {
					//$file_id = "BAACAgIAAxkBAAICz2PP2GEBW22_oZ5UpZQr79selVJuAAKpIQACb9FZShfJc7MvYN6ULQQ";
					//$file_id = "BAACAgIAAxkBAAEBdJRj2B4nGbH6K6ersOgDY2seEaW2RwACyCgAAlc5oUp5zTY6iqd9JS0E";
					$file_id_2 = "BAACAgIAAxkBAAEBdJVj2B4y1ekKLPz4Hptvcj48UgMvWAACySgAAlc5oUqmXt4Fd4mYMS0E";
				}
				if ($tg_users['LANG']=='ru') {
					$file_id = "BAACAgIAAxkBAAIC0WPP2V3xdA0Pyec3myZEsy-x72H7AAKrJAACb9FZSrJ7yG3UZGSALQQ";
				}
				
				bot::sendVideo($tg_users['CHAT_ID'], $file_id);
				
				if ($tg_users['LANG']=='uz') { 
					bot::sendVideo($tg_users['CHAT_ID'], $file_id_2);
				}
				*/
				
				bot::forwardMessage($tg_users['CHAT_ID'], '2679648', '2204599');
				bot::forwardMessage($tg_users['CHAT_ID'], '2679648', '2204600');
				bot::forwardMessage($tg_users['CHAT_ID'], '2679648', '3059647');
				
				$msg = guest_msg::ask_app($tg_users['LANG']);
				bot::sendMessage($tg_users['CHAT_ID'], $msg, NULL);
				
				event_code('ask_app', $chat_id);
				
		} else {
			//$msg = guest_msg::ask_passport($tg_users['LANG']);
			bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
		}
		
	}
	
	if ($tg_users['EVENT_CODE'] == 'ask_payment') {
		
		if (isset($output['message']['photo'])) {
			
			$photo = bot::getHighQuality($output['message']['photo']);
			$code = get_code($tg_users['ID']);
			
			db::query("UPDATE `tg_users` SET `UPDATE_DATE`=now(),`OPLATA_PHOTO`='$photo[file_id]', `CODE`='$code', `STATUS`='pay_wait' WHERE CHAT_ID='$chat_id'");
			
			$msg = guest_msg::pay_wait($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, NULL);
			event_code('wait_payment',$chat_id);
			
		} else {
			//$msg = guest_msg::ask_passport($tg_users['LANG']);
			bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
		}
		
	}
	
	if ($tg_users['EVENT_CODE'] == 'wait_payment') {
		$msg = guest_msg::pay_wait($tg_users['LANG']);
		bot::sendMessage($chat_id, $msg, NULL);
	}
	
	/*
	if ($tg_users['EVENT_CODE'] == 'ask_payment') {
			
			if (isset($output['message']['photo'])) {
				
				$photo = bot::getHighQuality($output['message']['photo']);
				$code = get_code($tg_users['ID']);
				
				db::query("UPDATE `tg_users` SET `OPLATA_PHOTO`='$photo[file_id]', `CODE`='$code' WHERE CHAT_ID='$chat_id'");
				
				$msg = guest_msg::sklad_message($tg_users['LANG'], $code);
				
				bot::sendMessage($chat_id, $msg, NULL);
					
				$msg = "唛头：$code 
	地址：广州市白云区江高镇珠江村沙滘路九巷36号 $code 
	手机号：13922559194
	收货人: $code";
				bot::sendMessage($chat_id, $msg, NULL);
					
				if ($tg_users['LANG']=='uz') {
					$file_id = "BAACAgIAAxkBAAICz2PP2GEBW22_oZ5UpZQr79selVJuAAKpIQACb9FZShfJc7MvYN6ULQQ";
				}
				if ($tg_users['LANG']=='ru') {
					$file_id = "BAACAgIAAxkBAAIC0WPP2V3xdA0Pyec3myZEsy-x72H7AAKrJAACb9FZSrJ7yG3UZGSALQQ";
				}
				
				bot::sendVideo($chat_id, $file_id);
				$msg = guest_msg::ask_app($tg_users['LANG']);
				bot::sendMessage($chat_id, $msg, NULL);
				event_code('ask_app', $chat_id);
			} else {
				//$msg = guest_msg::ask_passport($tg_users['LANG']);
				bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
			}
			
		}
	*/
	if ($tg_users['EVENT_CODE'] == 'ask_app') {
		
		if (isset($output['message']['photo'])) {
			
			$photo = bot::getHighQuality($output['message']['photo']);
			
			db::query("UPDATE `tg_users` SET `UPDATE_DATE`=now(), `APP_PHOTO`='$photo[file_id]',`STATUS`='draft' WHERE CHAT_ID='$chat_id'");
			
			//bot::sendPhoto($chat_id, '', NULL, $photo);
			
			$msg = guest_msg::wait_confirm($tg_users['LANG']);
			bot::sendMessage($chat_id, $msg, NULL);
			event_code('wait_confirmation', $chat_id);
		} else {
			//$msg = guest_msg::ask_passport($tg_users['LANG']);
			bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
		}
		
	}
	
	if ($tg_users['EVENT_CODE'] == 'wait_confirmation') {
		
		if (isset($message)) {
			$msg = guest_msg::wait_confirm($tg_users['LANG']);
			bot::sendMessage($chat_id,$msg, NULL);
			
		}
	
	}
	
	if ($tg_users['EVENT_CODE'] == 'otkaz_start_message') {
		
		$otkaz_array = json_decode($tg_users['OTKAZ_DATA'],true);
		
			$first_key = array_key_first($otkaz_array);	
			$table_name = guest_msg::table_name($first_key);
			$function_name = guest_msg::otkaz_data($first_key);
		
		
		if (in_array($first_key, ["ism_otkaz","raqam_otkaz","adres_otkaz"])) {
			if (isset($output['message']['text'])) {
				db::query("UPDATE `tg_users` SET `$table_name`='$message' WHERE `CHAT_ID`='$chat_id'");
				unset($otkaz_array[$first_key]);
				$json = json_encode($otkaz_array);
				db::query("UPDATE `tg_users` SET `OTKAZ_DATA`='$json' WHERE `CHAT_ID`='$chat_id'");
				
				if (empty($otkaz_array)) {
					db::query("UPDATE `tg_users` SET `STATUS`='draft', `UPDATE_DATE`=now()  WHERE `CHAT_ID`='$chat_id'");
					bot::sendMessage($chat_id, guest_msg::wait_confirm($tg_users['LANG']), NULL);
					event_code('wait_confirmation', $chat_id);				
				} else {
					$next_key = array_key_first($otkaz_array);
					$function_name = guest_msg::otkaz_data($next_key);			
					$msg = guest_msg::$function_name($tg_users['LANG']);
					bot::sendMessage($chat_id, $msg, NULL);
				}
				
			} else {
				bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
			}
		} 
		
		if (in_array($first_key, ["p1_otkaz","p2_otkaz","app_otkaz","pay_otkaz"])) {
			if (isset($output['message']['photo'])) {
				$photo = bot::getHighQuality($output['message']['photo']);
				db::query("UPDATE `tg_users` SET `$table_name`='$photo[file_id]',`STATUS`='draft' WHERE CHAT_ID='$chat_id'");
				unset($otkaz_array[$first_key]);
				$json = json_encode($otkaz_array);
				db::query("UPDATE `tg_users` SET `OTKAZ_DATA`='$json' WHERE `CHAT_ID`='$chat_id'");
				
				if (empty($otkaz_array)) {
					db::query("UPDATE `tg_users` SET `STATUS`='draft', `UPDATE_DATE`=now()  WHERE `CHAT_ID`='$chat_id'");
					bot::sendMessage($chat_id, guest_msg::wait_confirm($tg_users['LANG']), NULL);
					event_code('wait_confirmation', $chat_id);					
				} else {
					$next_key = array_key_first($otkaz_array);
					
					if ($next_key=='app_otkaz') {
					$code = get_code($tg_users['ID']);
					
					$msg = guest_msg::sklad_message($tg_users['LANG'], $code);	
					bot::sendMessage($chat_id, $msg, NULL);
						
$msg = "唛头：$code 
地址：广州市白云区江高镇珠江村沙滘路九巷36号 $code 
手机号：13922559194
收货人: $code";
			bot::sendMessage($chat_id, $msg, NULL);
			
			/*
			if ($tg_users['LANG']=='uz') {
				//$file_id = "BAACAgIAAxkBAAICz2PP2GEBW22_oZ5UpZQr79selVJuAAKpIQACb9FZShfJc7MvYN6ULQQ";
				$file_id = "BAACAgIAAxkBAAEBdJRj2B4nGbH6K6ersOgDY2seEaW2RwACyCgAAlc5oUp5zTY6iqd9JS0E";
				$file_id_2 = "BAACAgIAAxkBAAEBdJVj2B4y1ekKLPz4Hptvcj48UgMvWAACySgAAlc5oUqmXt4Fd4mYMS0E";
			}
			if ($tg_users['LANG']=='ru') {
				$file_id = "BAACAgIAAxkBAAIC0WPP2V3xdA0Pyec3myZEsy-x72H7AAKrJAACb9FZSrJ7yG3UZGSALQQ";
			}
			
			bot::sendVideo($tg_users['CHAT_ID'], $file_id);
			
			if ($tg_users['LANG']=='uz') { 
				bot::sendVideo($tg_users['CHAT_ID'], $file_id_2);
			}
			*/
			bot::forwardMessage($tg_users['CHAT_ID'], '2679648', '2204599');
			bot::forwardMessage($tg_users['CHAT_ID'], '2679648', '2204600');
			
					}
					$function_name = guest_msg::otkaz_data($next_key);			
					$msg = guest_msg::$function_name($tg_users['LANG']);
					bot::sendMessage($chat_id, $msg, NULL);
				}
				
			} else {
				bot::sendMessage($chat_id, guest_msg::valid($tg_users['LANG']), NULL);
			}
		}
				
	}

}


?>