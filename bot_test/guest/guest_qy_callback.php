<?

$callback_data = explode("#", $callback_code);
if ($tg_users['EVENT_CODE'] == 'reg') {

	if ($callback_code == 'reg_start') {

		$msg = guest_msg::ask_name($tg_users['LANG']);
		bot::sendMessage($chat_id_in, $msg, NULL);
		event_code('ask_name', $chat_id_in);
	}
}

if ($tg_users['EVENT_CODE'] == 'start_zakaz_payment') {

	$pay_start = explode("_", $callback_code);
	if ($pay_start[0] == 'PAY') {

		db::query("UPDATE tg_users SET CURRENT_ORDER='$pay_start[1]' WHERE ID='$tg_users[ID]'");
		db::query("UPDATE ac_zakaz SET STATUS='order_process_start' WHERE ID='$pay_start[1]'");

		$order_data = db::arr_s("SELECT * FROM ac_zakaz WHERE ID='$pay_start[1]'");
		$msg = guest_msg::order_detail($tg_users['LANG'], $order_data);
		$kyb = json_encode(['remove_keyboard' => true]);
		bot::sendPhoto($chat_id_in, $msg, $kyb, $order_data['TOVAR_PHOTO']);

		$msg = guest_msg::pay_delivery($tg_users['LANG']);
		$kyb = guest_kyb::pay_delivery($tg_users['LANG']);
		bot::sendMessage($chat_id_in, $msg, $kyb);
		event_code('choose_delivery', $chat_id_in);
	}
}

if ($tg_users['EVENT_CODE'] == 'ask_network') {
	if (in_array($callback_code, ['telegram', 'instagram', 'facebook', 'acquaintances'])) {

		db::query("UPDATE `tg_users` SET `SOCIAL` = '$callback_code' WHERE `CHAT_ID` = '$chat_id_in'");

		$msg = guest_msg::ask_passport($tg_users['LANG']);
		bot::sendMessage($chat_id_in, $msg, NULL);
		event_code('ask_passport', $chat_id_in);

		$file_id = "AgACAgIAAxkBAAIEPmPQ8Oy0RenBJ487FkrHOAs2a5N5AAK9wzEbJYuISqnIT0_A7BJZAQADAgADeQADLQQ";
		bot::sendPhoto($chat_id_in, NULL, NULL, $file_id);
	} else {
		bot::sendMessage($chat_id_in, 'Неверный запрос | Sizni tushunmadim!', NULL);
	}
}

// $select_admin = db::arr_s("SELECT * FROM ac_adminka WHERE PHONE = '$tg_users[PHONE]' AND ACTIVE = 1");
// $url_link = db::arr_s("SELECT * FROM `url_link`");

// foreach(guest_kyb::current_report_arr() as $v){

// 	if($callback_code == "admin_".$v){
// 		$url = 'https://'.$url_link['URL'].'/report/report_pdf/mega_report_tg.php?type=admin&sana='.$v.'&admin_id='.$select_admin['ID'];

// 		//$json = json_encode($url);
// 		$check = file_get_contents($url);
// 		$kyb = guest_kyb::nazad($tg_users['LANG']);

// 		bot::sendMessage($chat_id_in, $check, $kyb);

// 	}
// }
if (in_array("admin", $callback_data)) {

	$select_admin = db::arr_s("SELECT * FROM ac_adminka WHERE PHONE = '$tg_users[PHONE]' AND ACTIVE = 1");
	$url_link = db::arr_s("SELECT * FROM `url_link`");
	$date = $callback_data[1];

	$url = generateUrl($select_admin["ID"], "admin", $date);

	$kyb = guest_kyb::nazad($tg_users['LANG']);
	$message = "Ваш отчет готов. <a href='$url'>Скачать</a>";
	bot::sendMessage($chat_id_in, $message, $kyb);
}

if ($tg_users['EVENT_CODE'] == 'choose_delivery') {

	if (in_array($callback_code, ['pochta', 'pickup', 'dostavka', 'yandex'])) {

		db::query("UPDATE ac_zakaz SET DELIVERY_TYPE='$callback_code' WHERE ID='$tg_users[CURRENT_ORDER]'");

		if ($callback_code == 'pochta') {
			$msg = guest_msg::confirm_address($tg_users['LANG'], $tg_users['ADRES']);
			$kyb = guest_kyb::confirm_address($tg_users['LANG']);

			bot::sendDocument($chat_id_in, 'BQACAgIAAxkBAAED5eBj_1JuciCy3zS_pX1dK_Jo2qlUcwADJAACDHfBS-P49DFJWVXILgQ');
			bot::sendDocument($chat_id_in, 'BQACAgIAAxkBAAED5eFj_1Ju_W_hfpV37ZRPotW22SNGtQAC7iEAAkySiUi5Zf_fXKwQii4E');

			bot::sendMessage($chat_id_in, $msg, $kyb);
			event_code('confirm_address', $chat_id_in);
		}

		if ($callback_code == 'pickup') {
			$msg = guest_msg::payment_type($tg_users['LANG']);
			$kyb = guest_kyb::payment_type($tg_users['LANG']);
			bot::sendMessage($chat_id_in, $msg, $kyb);
			event_code('pickup_payment', $chat_id_in);
		}

		if ($callback_code == 'dostavka') {
		
			db::query("INSERT INTO `ac_location` 
			(`CHAT_ID`, 
			`ORDER_ID`, 
			`TYPE`, 
			`STATUS`, 
			`ACTIVE`) 
			VALUES 
			('$chat_id_in', 
			'$tg_users[CURRENT_ORDER]', 
			'$callback_code', 'new', '1')");

			$msg = guest_msg::district_type($tg_users['LANG']);
			$kyb = guest_kyb::district_type($tg_users['LANG']);

			bot::sendMessage($chat_id_in, $msg, $kyb);
			event_code('choose_district', $chat_id_in);
		}

		if ($callback_code == 'yandex') {
		
			db::query("INSERT INTO `ac_location` 
			(`CHAT_ID`, 
			`ORDER_ID`, 
			`TYPE`, 
			`STATUS`, 
			`ACTIVE`) 
			VALUES 
			('$chat_id_in', 
			'$tg_users[CURRENT_ORDER]', 
			'$callback_code', 
			'new', 
			'1')");

			$msg = guest_msg::send_location($tg_users['LANG']);

			bot::sendMessage($chat_id_in, $msg, null);
			event_code('send_location', $chat_id_in);
		}
	} else {
		bot::sendMessage($chat_id_in, 'Неверный запрос | Sizni tushunmadim!', NULL);
	}
}

if($tg_users['EVENT_CODE'] == 'choose_district'){
	$get_callback = explode('_', $callback_code);

	if($get_callback[0] == 'district'){
		
		db::query("UPDATE `ac_location` SET 
		`DISTRICT_ID` = '$get_callback[1]' 
		WHERE `CHAT_ID` = '$chat_id_in' 
		AND `STATUS` = 'new' 
		AND `ACTIVE` = '1'");

		$msg = guest_msg::send_location($tg_users['LANG']);
		bot::sendMessage($chat_id_in, $msg, null);
		event_code('send_location', $chat_id_in);
	}else{
		bot::sendMessage($chat_id_in, 'Неверный запрос | Sizni tushunmadim!', NULL);
	}
}


if ($tg_users['EVENT_CODE'] == 'pickup_payment') {
	if ($callback_code == 'cash') {
		// welcome to the office
		db::query("UPDATE `ac_zakaz` SET `PAYMENT_TYPE` = '$callback_code' WHERE `ID` = '$tg_users[CURRENT_ORDER]'");
		event_code('main_menu', $chat_id_in);
		$msg = guest_msg::call_to_office($tg_users['LANG'], $tg_users['CURRENT_ORDER']);
		$kyb = guest_kyb::zakaz_button($tg_users['LANG']);
		bot::sendMessage($chat_id_in, $msg, $kyb);
	}
	if ($callback_code == 'card') {
		// welcome to the office
		db::query("UPDATE `ac_zakaz` SET `PAYMENT_TYPE` = '$callback_code' WHERE `ID` = '$tg_users[CURRENT_ORDER]'");
		$order_data = db::arr_s("SELECT * FROM ac_zakaz WHERE ID='$tg_users[CURRENT_ORDER]'");
		$msg = guest_msg::order_detail($tg_users['LANG'], $order_data);
		bot::sendPhoto($chat_id_in, $msg, NULL, $order_data['TOVAR_PHOTO']);
		$msg = guest_msg::zakaz_payment($tg_users['LANG'], $order_data);
		bot::sendMessage($chat_id_in, $msg, NULL);
		event_code('wait_zakaz_payment', $chat_id_in);
	}
}

if ($tg_users['EVENT_CODE'] == 'confirm_address') {

	if ($callback_code == 'yes') {
		// make payment
		$order_data = db::arr_s("SELECT * FROM ac_zakaz WHERE ID='$tg_users[CURRENT_ORDER]'");
		$msg = guest_msg::order_detail($tg_users['LANG'], $order_data);
		bot::sendPhoto($chat_id_in, $msg, NULL, $order_data['TOVAR_PHOTO']);
		$msg = guest_msg::zakaz_payment($tg_users['LANG'], $order_data);
		bot::sendMessage($chat_id_in, $msg, NULL);
		event_code('wait_zakaz_payment', $chat_id_in);
	}

	if ($callback_code == 'no') {
		// enter address
		$msg = guest_msg::ask_adres($tg_users['LANG']);
		bot::sendMessage($chat_id_in, $msg, NULL);
		event_code('wait_zakaz_adres', $chat_id_in);
	}
}

if ($tg_users['EVENT_CODE'] == 'otkaz_start') {

	if ($callback_code == 'otkaz_start') {

		$otkaz_array = json_decode($tg_users['OTKAZ_DATA'], true);

		if (empty($otkaz_array)) {
			bot::sendMessage($chat_id_in, 'Tugadi', NULL);
		}
		$first_key = array_key_first($otkaz_array);

		if ($first_key == 'app_otkaz') {
			$code = get_code($tg_users['ID']);

			$msg = guest_msg::sklad_message($tg_users['LANG'], $code);
			bot::sendMessage($chat_id_in, $msg, NULL);

			$msg = "唛头：$code 
地址：广州市白云区江高镇珠江村沙滘路九巷36号 $code 
手机号：13922559194
收货人: $code";
			bot::sendMessage($chat_id_in, $msg, NULL);

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
			}*/

			bot::forwardMessage($tg_users['CHAT_ID'], '2679648', '2204599');
			bot::forwardMessage($tg_users['CHAT_ID'], '2679648', '2204600');
		}

		$function_name = guest_msg::otkaz_data($first_key);

		$msg = guest_msg::$function_name($tg_users['LANG']);
		bot::sendMessage($chat_id_in, $msg, NULL);
		event_code('otkaz_start_message', $chat_id_in);
		//event_code($first_key, $chat_id_in);

	}
}
