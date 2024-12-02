<?
class employer_kyb
{

    static function lang()
    {

        $lang = json_encode(['resize_keyboard' => true, 'keyboard' => [[['text' => "O`zbek tili 🇺🇿"], ['text' => "Русский язык 🇷🇺"]], ]]);

        return $lang;
    }
	
	
	static function choose_role($lang){
		if($lang == 'ru'){
			$role = json_encode(['resize_keyboard' => true, 'keyboard' =>[[['text' => "Я работодатель 👤"], ['text' => "Я работник 👤"]], ]]);
		}
		if($lang == 'uz'){
			$role = json_encode(['resize_keyboard' => true, 'keyboard' =>[[['text' => "Men ish beruvchi 👤"], ['text' => "Men ishchi 👤"]], ]]);
		}
		
		return $role;
	}

	static function nazad($lang)
	{

		if($lang == 'ru') {
			$kyb= json_encode(['resize_keyboard' => true, 'keyboard' =>[[['text' => "Назад"]], ]]);
		}
		if($lang == 'uz') {
			$kyb = json_encode(['resize_keyboard' => true, 'keyboard' =>[[['text' => "Ortga"]], ]]);
		}


		return $kyb;
	}

	static function back($lang)
	{

		if($lang == 'ru') {
			$kyb= json_encode(['resize_keyboard' => true, 'keyboard' =>[[['text' => "Главное меню"]], ]]);
		}
		if($lang == 'uz') {
			$kyb = json_encode(['resize_keyboard' => true, 'keyboard' =>[[['text' => "Asosiy menu"]], ]]);
		}


		return $kyb;
	}
	
    
    static function reg($lang) {
	
		if ($lang == 'ru') {
		$start = json_encode([
	    'resize_keyboard'=>true,
	    'keyboard' => [
	        [['text' => "Регистрация ✅",'request_contact'=>true],],
	    ]
		]);
		}
		if ($lang == 'uz') {
		$start = json_encode([
	    'resize_keyboard'=>true,
	    'keyboard' => [
	        [['text' => "Ro`yxatdan o`tish ✅",'request_contact'=>true],],
	    ]
		]);
		} 
		return $start;
	}

    static function main_menu($lang)
    {
	    if ($lang == 'ru') {
		$menu = json_encode([
	    'resize_keyboard'=>true,
	    'keyboard' => [
	        [['text' => "Мои вакансии"], ['text' => "Мои компании"]],
	    ]
		]);
		}
		if ($lang == 'uz') {
		$menu = json_encode([
	    'resize_keyboard'=>true,
	    'keyboard' => [
	        [['text' => "Mening vakansiyalarim"],['text' => "Mening kompaniyalarim"]],
	    ]
		]);
		} 
		return $menu;
    }
	
    
    static function pagination($lang)
    {
	    $button[] = ["text" => "⬅️"];
	    $button[] = ["text" => "➡️"];
	    
	    if ($lang=='uz') {
		    $button[] = ["text" => "🏠 Asosiy menyu"];
	    }
	    
	    if ($lang=='ru') {
		    $button[] = ["text" => "🏠 Главное меню"];
	    }
	    
	    $kyb = array_chunk($button, 2);
	    
        $keyboard = ["resize_keyboard" => true, "keyboard" => $kyb];
        $rs = json_encode($keyboard);
        return $rs;
    }

    static function obuna()
    {
        $kyb[] = ["text" => "+ Obuna bo`lish", "url" => "https://t.me/evosoft_uzb"];
        $kyb[] = ["text" => "Tekshirish", "callback_data" => "check_obuna"];
        $kyb_final = array_chunk($kyb, 1);
        $keyboard = ["inline_keyboard" => $kyb_final];
        $rs = json_encode($keyboard);
        //$rs = array_merge($arr1,$arr2);
        return $rs;
    }
	
	
	
	
	static function my_companies($tg_users)
	{

		$cm_list = db::arr("SELECT * FROM `list_companies` WHERE CHAT_ID = '$tg_users[CHAT_ID]' AND ACTIVE = '1'");

		if ($tg_users['LANG'] == 'ru') {$add_btn[] = ["text" => "Добавить", "callback_data" => "add_new_company"];}
		if ($tg_users['LANG']  == 'uz') {$add_btn[] = ["text" => "Qoshish", "callback_data" => "add_new_company"];}

		$add_btn_final = array_chunk($add_btn, 1);

		if($cm_list != 'empty') {

			for ($i = 0; $i < count($cm_list); $i++){

				$callback = 'company_info_'.$cm_list[$i]['ID'];
				$items[] = ["text"=>$i+1,"callback_data"=>$callback];

			}

			$items_final = array_chunk($items, 5);

			$final_kyb = array_merge($items_final, $add_btn_final);

		}

		else { $final_kyb = $add_btn_final;}



		$keyboard = ["inline_keyboard" => $final_kyb];

		$rs = json_encode($keyboard);

		return $rs;
	}


	static function my_vacancies($tg_users)
	{

		$job_list = db::arr("SELECT * FROM `job_list` WHERE CHAT_ID = '$tg_users[CHAT_ID]' AND STATUS NOT IN ('draft', 'deleted')");

		if ($tg_users['LANG'] == 'ru') {$add_btn[] = ["text" => "Добавить", "callback_data" => "add_new_job"];}
		if ($tg_users['LANG']  == 'uz') {$add_btn[] = ["text" => "Qoshish", "callback_data" => "add_new_job"];}

		$add_btn_final = array_chunk($add_btn, 1);

		if($job_list != 'empty') {

			for ($i = 0; $i < count($job_list); $i++){

				$callback = 'job_info_'.$job_list[$i]['ID'];
				$items[] = ["text"=>$i+1,"callback_data"=>$callback];

			}

			$items_final = array_chunk($items, 5);

			$final_kyb = array_merge($items_final, $add_btn_final);

		}

		else { $final_kyb = $add_btn_final;}



		$keyboard = ["inline_keyboard" => $final_kyb];

		$rs = json_encode($keyboard);

		return $rs;
	}


	static function company_del_edit($id, $lang)
	{
		if ($lang == 'ru')
		{
			$kyb[] = ["text" => "Изменить", "callback_data" => "company_edit_" . $id];
			$kyb[] = ["text" => "Удалить", "callback_data" => "company_del_" . $id];
		}
		if ($lang  == 'uz')
		{
			$kyb[] = ["text" => "Ozgartirish", "callback_data" => "company_edit_" . $id];
			$kyb[] = ["text" => "O'chirish", "callback_data" => "company_del_" . $id];
		}


		$kyb_final = array_chunk($kyb, 1);
		$keyboard = ["inline_keyboard" => $kyb_final];

		$rs = json_encode($keyboard);

		return $rs;
	}

	static function job_info_kyb($id, $lang, $stat, $plan_id)
	{
		
		$plan_list = db::arr_s("SELECT * FROM `job_plan` WHERE ID = '$plan_id'");
		
		if ($lang == 'ru'){
			
			if($stat == 'not_active') $kyb[] = ["text" => "Активировать", "callback_data" => "job_activate_" . $id];
				
			if($plan_list['TYPE'] == 'free' and $stat == 'active') $kyb[] = ["text" => "Изменить тариф", "callback_data" => "change_plan_" . $id];			
				
			$kyb[] = ["text" => "Удалить", "callback_data" => "job_del_" . $id];
			
		}
		
		
		if ($lang  == 'uz'){
			
			if($stat == 'not_active') $kyb[] = ["text" => "Faollashtirish", "callback_data" => "job_activate_" . $id];
				
			if($plan_list['TYPE'] == 'free' and $stat == 'active') $kyb[] = ["text" => "Tarifni o'zgartirish", "callback_data" => "change_plan_" . $id];			
					
			$kyb[] = ["text" => "O'chirish", "callback_data" => "job_del_" . $id];
		}


		$kyb_final = array_chunk($kyb, 2);
		$keyboard = ["inline_keyboard" => $kyb_final];

		$rs = json_encode($keyboard);

		return $rs;
	}

	static function select_cat($lang)
	{
		$LANG = strtoupper($lang);
		$cat_list = db::arr("SELECT * FROM `job_category` WHERE ACTIVE = '1'");

		foreach ($cat_list as $v) $cat_arr[] = ['text' => $v['NAME_' . $LANG], 'callback_data' => 'cat_'. $v['ID']];

		$kyb_final = array_chunk($cat_arr, 2);
		$keyboard = ["inline_keyboard" => $kyb_final];

		$rs = json_encode($keyboard);

		return $rs;
	}

	static function select_company($chat_id){
		$company_list = db::arr("SELECT * FROM `list_companies` WHERE `CHAT_ID` = '$chat_id' AND `ACTIVE` = '1'");

		foreach ($company_list as $v) $company_arr[] = ['text' => $v['NAME']. ' - ' . $v['YUR_NAME'], 'callback_data' => 'company_'. $v['ID']];

		$kyb_final = array_chunk($company_arr, 2);
		$keyboard = ["inline_keyboard" => $kyb_final];

		$rs = json_encode($keyboard);

		return $rs;

	}

	static function select_plan($lang)
	{
		$LANG = strtoupper($lang);

		$plan_list = db::arr("SELECT * FROM `job_plan` WHERE `ACTIVE` = '1'");

		foreach ($plan_list as $v) $plan_arr[] = ['text' => $v['NAME_' .$LANG], 'callback_data' => 'plan_'. $v['ID']];

		$kyb_final = array_chunk($plan_arr, 1);
		$keyboard = ["inline_keyboard" => $kyb_final];

		$rs = json_encode($keyboard);

		return $rs;
	}

	static function select_plan_type($lang)
	{

		if($lang == 'uz') {
			$plan_type[] = ['text' => '1 kun', 'callback_data' => 'day'];
			$plan_type[] = ['text' => '1 hafta', 'callback_data' => 'week'];
			$plan_type[] = ['text' => '1 oy', 'callback_data' => 'month'];
		}

		if($lang == 'ru') {
			$plan_type[] = ['text' => '1 день', 'callback_data' => 'day'];
			$plan_type[] = ['text' => '1 неделя', 'callback_data' => 'week'];
			$plan_type[] = ['text' => '1 месяц', 'callback_data' => 'month'];
		}

		$kyb_final = array_chunk($plan_type, 1);
		$keyboard = ["inline_keyboard" => $kyb_final];

		$rs = json_encode($keyboard);

		return $rs;

	}

}
?>
