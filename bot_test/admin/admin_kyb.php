<?
class admin_kyb
{
	static function zakaz_button($lang) {
	
		if ($lang == 'ru') {
		$start = json_encode([
		'resize_keyboard'=>true,
		'keyboard' => [
			[['text' => "Мои заказы"],],
		]
		]);
		}
		if ($lang == 'uz') {
		$start = json_encode([
		'resize_keyboard'=>true,
		'keyboard' => [
			[['text' => "Mening zakazlarim"],],
		]
		]);
		} 
		return $start;
	}

	static function confirm_doc($lang){
		if($lang == 'ru'){
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Отправить", 'callback_data'=>"send"]],
					[['text' => "Отмена", 'callback_data'=>"cancel"]]
				]
			]);
		}
		if($lang == 'uz'){
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Yuborilsin", 'callback_data'=>"send"]],
					[['text' => "Bekor qilinsin", 'callback_data'=>"cancel"]]
				]
			]);
		}
		return $start;
	}

	static function rassilka(){

		$start = json_encode([
			'resize_keyboard' => true,
			'keyboard' => [
				[['text' => "Rassilka yuborish"]]
			]
		]);
	return $start;
}

	static function send_letter(){

			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Yo'q"],['text' => "Ha"]]
				]
			]);
		
		return $start;
	}

	static function delete_keyboard()
	{

		$start = json_encode([
			'remove_keyboard' => true
		]);

		return $start;
	}
		
	static function yes_no() {
		$start = json_encode([
		'inline_keyboard' => [
			[['text' => "YOQ",'callback_data'=>"YOQ"],['text' => "HA",'callback_data'=>"HA"],],
		]
		]);
		return $start;
	}
	
	static function zakaz_list($search_key)
	{		
		$zakaz_list = db::arr("SELECT * FROM `ac_zakaz` WHERE ID LIKE '%$search_key%' AND ACTIVE=0 AND STATUS='new'");
		
		if ($zakaz_list == 'empty') {
			
			$rs = "null";
			
		} else {
			foreach ($zakaz_list as $zl) {
			$items[] = ["text"=>$zl['ID'],"callback_data"=>"ZK_".$zl['ID']];
			}
			
			$items_final = array_chunk($items, 1);	
			
			$keyboard = ["inline_keyboard" => $items_final];
			
			$rs = json_encode($keyboard);
		}
		return $rs;
	}
	
	static function remove_keyboard()
	{
	
		$lang = json_encode(['remove_keyboard' => true]);
	
		return $lang;
	} 

    static function lang()
    {

        $lang = json_encode(['resize_keyboard' => true, 'keyboard' => [[['text' => "O`zbek tili 🇺🇿"], ['text' => "Русский язык 🇷🇺"]], ]]);

        return $lang;
    } 
    
    static function reg($lang) {
	
		if ($lang == 'ru') {
		$start = json_encode([
	    'resize_keyboard'=>true,
	    'keyboard' => [
	        [['text' => "📌 Отправить",'request_contact'=>true],],
	    ]
		]);
		}
		if ($lang == 'uz') {
		$start = json_encode([
	    'resize_keyboard'=>true,
	    'keyboard' => [
	        [['text' => "📌 Jo'natish",'request_contact'=>true],],
	    ]
		]);
		} 
		return $start;
	}    
    
	static function choose_country($lang)
	{
		$LANG = strtoupper($lang);
		
		$country_list = db::arr("SELECT * FROM `country_list` WHERE STATUS NOT IN ('0')");
		
		foreach($country_list as $v)
		{
			$button[] = ['text' => $v['NAME_' .$LANG]];
		}
		
		$kyb = array_chunk($button, 2);
	    
        $keyboard = ["resize_keyboard" => true, "keyboard" => $kyb];
        $rs = json_encode($keyboard);
        return $rs;
		
	}
	
	
	static function main_menu($lang)
    {
	    if ($lang == 'ru') {
		$menu = json_encode([
	    'resize_keyboard'=>true,
	    'keyboard' => [
	        [['text' => "⚙️ Настройки"]],
	    ]
		]);
		}
		if ($lang == 'uz') {
		$menu = json_encode([
	    'resize_keyboard'=>true,
	    'keyboard' => [
	        [['text' => "⚙️ Sozlamalar"]],
	    ]
		]);
		} 
		return $menu;
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
	
	static function channels($tg_users)
	{
		
		$chat_id = $tg_users['CHAT_ID'];
		
		$channels_list = db::arr("SELECT * FROM `telegram_channels` WHERE `ADMIN_JSON` LIKE '%\"id\":$chat_id%' AND ACTIVE NOT IN ('0')");

		for ($i = 0; $i < count($channels_list); $i++){

		$callback = 'channel_info_'.$channels_list[$i]['ID'];
		$items[] = ["text"=>$i+1,"callback_data"=>$callback];

		}

		$items_final = array_chunk($items, 5);	
		
		$keyboard = ["inline_keyboard" => $items_final];

		$rs = json_encode($keyboard);

		return $rs;
	}
	
	
	static function channel_info($id, $lang)
	{
		if($lang == 'ru') $kyb[] = ['text' => 'Изменить', 'callback_data' => 'channel_edit_' .$id];
		if($lang == 'uz') $kyb[] = ['text' => 'O\'zgartirish', 'callback_data' => 'channel_edit_' .$id];
		
		$kyb_final = array_chunk($kyb, 1);
		$keyboard = ["inline_keyboard" => $kyb_final];

		$rs = json_encode($keyboard);

		return $rs;
	}
	
	static function category_list($lang, $id)
	{
		$LANG = strtoupper($lang);
		
		$channel_data = db::arr_s("SELECT * FROM `telegram_channels` WHERE ID = '$id'");		

		$category = db::arr_by_id("SELECT * FROM job_category WHERE ACTIVE = '1'");	

		foreach (json_decode($channel_data['SETTINGS_JSON'],true) as $k=>$v)
		{
	
			if ($v==1){$sts = '✔️';}else{$sts='➖';}
	
			$cat_name = $category[$k]['NAME_' . $LANG].' '.$sts;	
			$cat[] = ["text"=>$cat_name,"callback_data"=>'cat_'.$k];

		}
		
		if($lang == 'ru') $cat[] = ["text"=>'Подтвердить ✔️',"callback_data"=>'save'];
		if($lang == 'uz') $cat[] = ["text"=>'Tasdiqlash ✔️',"callback_data"=>'save'];
	
		$kyb_final = array_chunk($cat, 1);
		$keyboard = ["inline_keyboard" => $kyb_final];

		$rs = json_encode($keyboard);

		return $rs;
	}

}
?>
