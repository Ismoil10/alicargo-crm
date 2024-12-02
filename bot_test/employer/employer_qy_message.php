<?

if ($message=='/start'){
	
    $q = db::query("UPDATE `tg_users` SET ROLE = 'guest' WHERE CHAT_ID = '$chat_id'");
	$msg = employer_msg::lang();
	$kyb = employer_kyb::lang();
	bot::sendMessage($chat_id, $msg,$kyb);
	event_code('choose_lang', $chat_id);

}
elseif ($message == '/role') {
	$msg = guest_msg::choose_role($tg_users['LANG']);
	$kyb = guest_kyb::choose_role($tg_users['LANG']);
	bot::sendMessage($chat_id, $msg,$kyb);
	event_code('choose_role', $chat_id);
}
else if ($message=='/menu') {
	$msg = employer_msg::menu($tg_users['LANG']);
	$kyb = employer_kyb::main_menu($tg_users['LANG']);
	bot::sendMessage($chat_id, $msg,$kyb);
	event_code('main_menu', $chat_id);
} 
else if ($message=='/lang') {
	$msg = employer_msg::lang();
	$kyb = employer_kyb::lang();
	bot::sendMessage($chat_id, $msg,$kyb);
	event_code('change_lang', $chat_id);
} 
else {

if($tg_users['EVENT_CODE'] == 'choose_role'){	
	
	if(in_array($message, ['Я работодатель 👤', 'Men ish beruvchi 👤'])) {
		$update_date = db::query("UPDATE `tg_users` SET `ROLE` = 'employer' WHERE CHAT_ID='$chat_id'"); 
		$msg = employer_msg::reg_success($tg_users['LANG']);
		$kyb = employer_kyb::main_menu($tg_users['LANG']);
		
	}
	if(in_array($message, ['Я работник 👤', 'Men ishchi 👤'])) {
		$update_date = db::query("UPDATE `tg_users` SET `ROLE` = 'guest' WHERE CHAT_ID='$chat_id'"); 
		$msg = guest_msg::reg_success($tg_users['LANG']);
		$kyb = guest_kyb::main_menu($tg_users['LANG']);
	}
	
	bot::sendMessage($chat_id, $msg,$kyb);
	event_code('main_menu', $chat_id);
	
}

if ($tg_users['EVENT_CODE']=='main_menu'){


	if(in_array($message, ["Мои компании","Mening kompaniyalarim"])){

        $cm_text = employer_msg::companies_text($tg_users['LANG']);
        $nazad = employer_kyb::back($tg_users['LANG']);

        bot::sendMessage($chat_id, $cm_text,$nazad);

		$msg = employer_msg::my_companies($tg_users);
		$kyb = employer_kyb::my_companies($tg_users);

		bot::sendMessage($chat_id, $msg, $kyb);

		event_code('my_companies', $chat_id);
	}


    elseif(in_array($message, ["Мои вакансии", "Mening vakansiyalarim"])){

            $cm_text = employer_msg::vacancies_text($tg_users['LANG']);
            $nazad = employer_kyb::back($tg_users['LANG']);

            bot::sendMessage($chat_id, $cm_text,$nazad);

            $msg = employer_msg::my_vacancies($tg_users);
            $kyb = employer_kyb::my_vacancies($tg_users);

            bot::sendMessage($chat_id, $msg, $kyb);

            event_code('my_vacancies', $chat_id);


    }

    else {
        bot::sendMessage($chat_id, employer_msg::error(),null);
    }

}

if($tg_users['EVENT_CODE'] == 'my_companies'){

    if(in_array($message, ["Главное меню","Asosiy menu"])){
        $msg = employer_msg::menu($tg_users['LANG']);
        $kyb = employer_kyb::main_menu($tg_users['LANG']);
        bot::sendMessage($chat_id, $msg,$kyb);
        event_code('main_menu', $chat_id);
    }

}

if($tg_users['EVENT_CODE'] == 'add_new_company_1'){

    if(in_array($message, ["Главное меню","Asosiy menu"])){
        $msg = employer_msg::menu($tg_users['LANG']);
        $kyb = employer_kyb::main_menu($tg_users['LANG']);
        bot::sendMessage($chat_id, $msg,$kyb);
        event_code('main_menu', $chat_id);
    }

    else {

        $query = db::query("UPDATE list_companies SET NAME = '$message' WHERE CHAT_ID = '$chat_id' AND ACTIVE = '0'");

        $msg = employer_msg::in_company_yurname($tg_users['LANG']);

        bot::sendMessage($chat_id, $msg, null);

        event_code('add_new_company_2', $chat_id);

    }

}

    if($tg_users['EVENT_CODE'] == 'add_new_company_2'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE list_companies SET YUR_NAME = '$message' WHERE CHAT_ID = '$chat_id' AND ACTIVE = '0'");

            $msg = employer_msg::in_company_desc($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('add_new_company_3', $chat_id);

        }

    }

    if($tg_users['EVENT_CODE'] == 'add_new_company_3'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE list_companies SET DESCRIPTION  = '$message' WHERE CHAT_ID = '$chat_id' AND ACTIVE = '0'");

            $msg = employer_msg::in_company_adress($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('add_new_company_4', $chat_id);

        }

    }

    if($tg_users['EVENT_CODE'] == 'add_new_company_4'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE list_companies SET ADRESS  = '$message' WHERE CHAT_ID = '$chat_id' AND ACTIVE = '0'");

            $msg = employer_msg::in_company_contact($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('add_new_company_5', $chat_id);

        }

    }

    if($tg_users['EVENT_CODE'] == 'add_new_company_5'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE list_companies SET CONTACTS  = '$message' WHERE CHAT_ID = '$chat_id' AND ACTIVE = '0'");

            $msg = employer_msg::in_company_logo($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('add_new_company_6', $chat_id);

        }

    }


    if($tg_users['EVENT_CODE'] == 'add_new_company_6'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        elseif (json_encode($file_id) != 'null'){

            $file =  save_file($file_id);

            $q['upd'] = db::query("UPDATE `list_companies` SET LOGO_URL = '$file[url]', ACTIVE = '1' WHERE CHAT_ID = '$chat_id' AND ACTIVE = '0'");
            $msg = employer_msg::logo_success($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg,$kyb);

            event_code('main_menu', $chat_id);

        } else {
            $msg = employer_msg::ne_foto($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg, null);
        }

    }

    if($tg_users['EVENT_CODE'] == 'edit_company_1') {

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE list_companies SET NAME = '$message' WHERE ID = '$tg_users[COMPANY_ID]'");

            $msg = employer_msg::in_company_yurname($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('edit_company_2', $chat_id);

        }
    }

    if($tg_users['EVENT_CODE'] == 'edit_company_2'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE list_companies SET YUR_NAME = '$message' WHERE ID = '$tg_users[COMPANY_ID]'");

            $msg = employer_msg::in_company_desc($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('edit_company_3', $chat_id);

        }

    }


    if($tg_users['EVENT_CODE'] == 'edit_company_3'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE list_companies SET DESCRIPTION  = '$message' WHERE ID = '$tg_users[COMPANY_ID]'");

            $msg = employer_msg::in_company_adress($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('edit_company_4', $chat_id);

        }

    }

    if($tg_users['EVENT_CODE'] == 'edit_company_4'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE list_companies SET ADRESS  = '$message' WHERE ID = '$tg_users[COMPANY_ID]'");

            $msg = employer_msg::in_company_contact($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('edit_company_5', $chat_id);

        }

    }

    if($tg_users['EVENT_CODE'] == 'edit_company_5'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE list_companies SET CONTACTS  = '$message' WHERE ID = '$tg_users[COMPANY_ID]'");

            $msg = employer_msg::in_company_logo($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('edit_company_6', $chat_id);

        }

    }


    if($tg_users['EVENT_CODE'] == 'edit_company_6'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        elseif (json_encode($file_id) != 'null'){

            $file =  save_file($file_id);

            $q['upd'] = db::query("UPDATE `list_companies` SET LOGO_URL = '$file[url]' WHERE ID = '$tg_users[COMPANY_ID]'");
            $msg = employer_msg::logo_success($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg,$kyb);

            event_code('main_menu', $chat_id);

        } else {
            $msg = employer_msg::ne_foto($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg, null);
        }

    }



    if($tg_users['EVENT_CODE'] == 'add_job_1'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {
            $query = db::query("UPDATE `job_list` SET TITLE = '$message' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

            $msg = employer_msg::select_cat($tg_users['LANG']);
            $kyb = employer_kyb::select_cat($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);

            event_code('add_job_2', $chat_id);
        }

    }

    if($tg_users['EVENT_CODE'] == 'add_job_2'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

    }

    if($tg_users['EVENT_CODE'] == 'add_job_3'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE `job_list` SET BODY = '$message' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

            $msg = employer_msg::salary($tg_users['LANG']);
        //    $kyb = employer_kyb::back($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,null);

            event_code('add_job_4', $chat_id);

        }

    }


    if($tg_users['EVENT_CODE'] == 'add_job_4'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE `job_list` SET SALARY = '$message' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

            $msg = employer_msg::contact_person($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('add_job_5', $chat_id);

        }

    }

    if($tg_users['EVENT_CODE'] == 'add_job_5'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE `job_list` SET CONTACT_NAME = '$message' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

           $msg = employer_msg::contacts($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg, null);

            event_code('add_job_6', $chat_id);

        }

    }

    if($tg_users['EVENT_CODE'] == 'add_job_6'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

        else {

            $query = db::query("UPDATE `job_list` SET CONTACT_PHONE = '$message' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

            $msg = employer_msg::select_company($tg_users['LANG']);
            $kyb = employer_kyb::select_company($chat_id);
            bot::sendMessage($chat_id, $msg, $kyb);

            event_code('add_job_7', $chat_id);

        }

    }

    if($tg_users['EVENT_CODE'] == 'add_job_7'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

    }

    if($tg_users['EVENT_CODE'] == 'add_job_8'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }


        elseif (json_encode($file_id) != 'null'){

            $file =  save_file($file_id);

            $draft_job = db::arr_s("SELECT ID FROM `job_list` WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");
			
			$now = date('Y-m-d H:i:s');
			
            $upd = db::query("UPDATE `zapros_list` SET DATE = '$now', FOTO_URL = '$file[url]', STATUS = 'waiting' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

            $q['upd'] = db::query("UPDATE `job_list` SET STATUS = 'waiting' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

            $msg = employer_msg::photo_success($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg,$kyb);

            event_code('main_menu', $chat_id);

            $url_link = db::arr_s("SELECT * FROM `url_link`");

            $url = $url_link['URL'].'/bot/api.php';

            $send_to_admin = post_query($url, ['status' => 'notification_to_admin', 'plan_type' => "paid", 'job_id' => $draft_job['ID'], 'url' => $url_link['URL'] . $file['url']]);

        } else {
            $msg = employer_msg::ne_foto($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg, null);
        }



    }

    if($tg_users['EVENT_CODE'] == 'my_vacancies'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }

    }
	
	if($tg_users['EVENT_CODE'] == 'choose_plan'){

        if(in_array($message, ["Главное меню","Asosiy menu"])){
            $msg = employer_msg::menu($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg,$kyb);
            event_code('main_menu', $chat_id);
        }
		
		elseif (json_encode($file_id) != 'null'){

            $file =  save_file($file_id);
		
			$now = date('Y-m-d H:i:s');
			
            $upd = db::query("UPDATE `zapros_list` SET DATE = '$now', FOTO_URL = '$file[url]', STATUS = 'waiting' WHERE JOB_LIST_ID = '$tg_users[JOB_ID]'");

			$zapros_list = db::arr_s("SELECT * FROM `zapros_list` WHERE JOB_LIST_ID = '$tg_users[JOB_ID]'");

            $q['upd'] = db::query("UPDATE `job_list` SET PLAN_ID = '$zapros_list[PLAN_ID]', STATUS = 'waiting' WHERE ID = '$tg_users[JOB_ID]'");

            $msg = employer_msg::photo_success($tg_users['LANG']);
            $kyb = employer_kyb::main_menu($tg_users['LANG']);

            bot::sendMessage($chat_id, $msg,$kyb);

            event_code('main_menu', $chat_id);

            $url_link = db::arr_s("SELECT * FROM `url_link`");

            $url = $url_link['URL'].'/bot/api.php';

            $send_to_admin = post_query($url, ['status' => 'notification_to_admin', 'plan_type' => "paid", 'job_id' => $tg_users['JOB_ID'], 'url' => $url_link['URL'] . $file['url']]);

        } else {
            $msg = employer_msg::ne_foto($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg, null);
        }

    }


}


?>