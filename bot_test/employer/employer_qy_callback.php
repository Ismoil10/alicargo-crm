<?
$chat_id = $tg_users['CHAT_ID'];
$event_code = $tg_users['EVENT_CODE'];
$lang = $tg_users['LANG'];

if($event_code == 'my_companies'){

    if($callback_code == 'add_new_company'){

        $cm_list = db::arr("SELECT * FROM `list_companies` WHERE CHAT_ID = '$chat_id' AND ACTIVE = '0'");

        if($cm_list == 'empty') {
            $query = db::query("INSERT INTO `list_companies` (CHAT_ID, ACTIVE) VALUES ($chat_id, '0')");
        }

        $msg = employer_msg::in_company_name($lang);
        bot::sendMessage($chat_id, $msg, null);
        event_code('add_new_company_1', $chat_id);
    }

    foreach(db::arr("SELECT * FROM list_companies WHERE CHAT_ID = '$chat_id' AND ACTIVE = '1'") as $v){

        if($callback_code == 'company_info_' . $v['ID']){

            $url_link = db::arr_s("SELECT * FROM `url_link`");
            $url = $url_link['URL'] . $v['LOGO_URL'];

            $msg = employer_msg::company_info($v['ID'], $lang);
            $kyb = employer_kyb::company_del_edit($v['ID'], $lang);

            bot::sendPhoto($chat_id, $msg, $kyb, $url);

        }

        if($callback_code == 'company_del_' . $v['ID']){

            $delete = db::query("UPDATE list_companies SET ACTIVE = '0' WHERE ID = $v[ID]");

            $msg = employer_msg::company_del_text($lang);
            $kyb = employer_kyb::main_menu($lang);

            bot::deleteMessage($chat_id, $message_id);

            bot::sendMessage($chat_id, $msg, $kyb);

            event_code('main_menu', $chat_id);
        }

        if($callback_code == 'company_edit_' . $v['ID']){

            $update = db::query("UPDATE tg_users SET COMPANY_ID = '$v[ID]' WHERE CHAT_ID = '$chat_id'");

            $msg = employer_msg::in_company_name($lang);
            $kyb = employer_kyb::back($lang);

            bot::deleteMessage($chat_id, $message_id);

            bot::sendMessage($chat_id, $msg, $kyb);

            event_code('edit_company_1', $chat_id);
        }

    }


}

if($event_code == 'add_job_2'){

    $cat_list = db::arr("SELECT * FROM `job_category` WHERE ACTIVE = '1'");

    foreach ($cat_list as $v){

        if($callback_code == 'cat_' . $v['ID']){
            $query = db::query("UPDATE `job_list` SET CAT_ID = '$v[ID]' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

            $msg = employer_msg::job_desc($lang);
        //    $kyb = employer_kyb::back($lang);

            bot::sendMessage($chat_id, $msg, null);

            event_code('add_job_3', $chat_id);
        }

    }

}

if($event_code == 'add_job_7'){

    $company_list = db::arr("SELECT * FROM `list_companies` WHERE `CHAT_ID` = '$chat_id' AND `ACTIVE` = '1'");

    foreach ($company_list as $v){

        if($callback_code == 'company_' . $v['ID']){
            $query = db::query("UPDATE `job_list` SET COMPANY_ID = '$v[ID]' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

            $msg = employer_msg::select_plan($lang);
            $kyb = employer_kyb::select_plan($lang);

            bot::sendMessage($chat_id, $msg, $kyb);

            event_code('add_job_8', $chat_id);
        }

    }

}

if($event_code == 'add_job_8'){

    $job_plan_list = db::arr("SELECT * FROM `job_plan` WHERE `ACTIVE` = '1'");

    $draft_job = db::arr_s("SELECT ID FROM `job_list` WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

    foreach ($job_plan_list as $v){

        if($callback_code == 'plan_' . $v['ID']){

            if($v['TYPE'] == 'free') {

                $upd = db::query("UPDATE `zapros_list` SET STATUS = 'waiting', SUMMA = '0', PLAN_ID = '$v[ID]' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

                $query = db::query("UPDATE `job_list` SET PLAN_ID = '$v[ID]', STATUS = 'waiting' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

                $msg = employer_msg::job_sent_to_admin($lang);
                $kyb = employer_kyb::main_menu($lang);

                bot::sendMessage($chat_id, $msg, $kyb);

                event_code('main_menu', $chat_id);

                $url_link = db::arr_s("SELECT * FROM `url_link`");

                $url = $url_link['URL'].'/bot/api.php';

                $send_to_admin = post_query($url, ['status' => 'notification_to_admin', 'plan_type' => "free", 'job_id' => $draft_job['ID']]);

            }

            else {

                $upd = db::query("UPDATE `zapros_list` SET SUMMA = '$v[PRICE]', PLAN_ID = '$v[ID]' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

                $query = db::query("UPDATE `job_list` SET PLAN_ID = '$v[ID]' WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

                $msg = employer_msg::payment_text($lang, $v['ID']);

                bot::sendMessage($chat_id, $msg, null);

            }

        }

    }

}

if($event_code == 'my_vacancies') {

    if($callback_code == 'add_new_job') {

        $company_list = db::arr("SELECT * FROM `list_companies` WHERE `CHAT_ID` = '$chat_id' AND `ACTIVE` = '1'");

        if($company_list != 'empty') {

            $my_job_list = db::arr_s("SELECT * FROM `job_list` WHERE CHAT_ID = '$chat_id' AND STATUS = 'draft'");

            if($my_job_list == 'empty') {

                $ins = db::query("INSERT INTO `job_list` (CHAT_ID, STATUS) VALUES ('$chat_id', 'draft')");
				
				$now = date('Y-m-d H:i:s');
				
                $ins_zapros = db::query("INSERT INTO `zapros_list` (`DATE`, `JOB_LIST_ID`, `CHAT_ID`, `STATUS`) VALUES ('$now', '$ins[ID]', '$chat_id', 'draft');");

            }

            $msg = employer_msg::company_title($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg, null);

            event_code('add_job_1', $chat_id);

        }

        else {

            $msg = employer_msg::please_add_copmany($tg_users['LANG']);
            bot::sendMessage($chat_id, $msg, null);

        }


    }

    foreach(db::arr("SELECT * FROM job_list WHERE CHAT_ID = $chat_id AND STATUS NOT IN ('draft', 'deleted')") as $v) {

        if ($callback_code == 'job_info_' . $v['ID']) {

            $msg = employer_msg::job_info($v['ID'], $lang);
            $kyb = employer_kyb::job_info_kyb($v['ID'], $lang, $v['STATUS'], $v['PLAN_ID']);

            bot::sendMessage($chat_id, $msg, $kyb);

        }

        if($callback_code == 'job_del_' . $v['ID']){

            $delete = db::query("UPDATE job_list SET STATUS = 'deleted', ACTIVE = '0' WHERE ID = $v[ID]");

            $msg = employer_msg::job_del_text($lang);
            $kyb = employer_kyb::main_menu($lang);

            bot::deleteMessage($chat_id, $message_id);

            bot::sendMessage($chat_id, $msg, $kyb);

            event_code('main_menu', $chat_id);
        }
		
		if($callback_code == 'job_activate_' . $v['ID']){
			
			$q[] = db::query("UPDATE tg_users SET JOB_ID = '$v[ID]' WHERE CHAT_ID = '$chat_id'");
			
			$msg = employer_msg::select_plan($lang);
			$kyb = employer_kyb::select_plan($lang);
			
			bot::sendMessage($chat_id, $msg, $kyb);
			
			event_code('choose_plan', $chat_id);
			
		}
		
		if($callback_code == 'change_plan_' .$v['ID']){
			
			$q[] = db::query("UPDATE tg_users SET JOB_ID = '$v[ID]' WHERE CHAT_ID = '$chat_id'");
			
			$msg = employer_msg::select_plan($lang);
			$kyb = employer_kyb::select_plan($lang);
			
			bot::sendMessage($chat_id, $msg, $kyb);
			
			event_code('choose_plan', $chat_id);
			
		}

    }
}

if($event_code == 'choose_plan') 
{
	
	$job_plan_list = db::arr("SELECT * FROM `job_plan` WHERE `ACTIVE` = '1'");
	
	foreach ($job_plan_list as $v){

        if($callback_code == 'plan_' . $v['ID']){

            if($v['TYPE'] == 'free') {

                $upd = db::query("UPDATE `zapros_list` SET STATUS = 'waiting', SUMMA = '0', PLAN_ID = '$v[ID]' WHERE JOB_LIST_ID = '$tg_users[JOB_ID]'");

                $query = db::query("UPDATE `job_list` SET PLAN_ID = '$v[ID]', STATUS = 'waiting' WHERE ID = '$tg_users[JOB_ID]'");

                $msg = employer_msg::job_sent_to_admin($lang);
                $kyb = employer_kyb::main_menu($lang);

                bot::sendMessage($chat_id, $msg, $kyb);

                event_code('main_menu', $chat_id);

                $url_link = db::arr_s("SELECT * FROM `url_link`");

                $url = $url_link['URL'].'/bot/api.php';

                $send_to_admin = post_query($url, ['status' => 'notification_to_admin', 'plan_type' => "free", 'job_id' => $tg_users['JOB_ID']]);

            }

            else {

                $upd = db::query("UPDATE `zapros_list` SET SUMMA = '$v[PRICE]', PLAN_ID = '$v[ID]' WHERE JOB_LIST_ID = '$tg_users[JOB_ID]'");

                $msg = employer_msg::payment_text($lang, $v['ID']);

                bot::sendMessage($chat_id, $msg, null);

            }

        }

    }
	
}
    

?>