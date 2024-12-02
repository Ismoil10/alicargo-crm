<?

class pochta_msg {
	
	static function zakaz_status($lang, $order_id)
	{
		
		if ($lang=='uz') $text = 'Xurmatli mijoz, sizda yangi zakaz mavjud. 

BUYURTMA # <b>'.$order_id.'</b>

Pasdagi "Mening zakazlarim" tugmasiga bosib unga to`lovni amalga oshiring';
		if ($lang=='ru') $text = 'Уважаемый покупатель, у вас новый заказ.

ЗАКАЗ # <b>'.$order_id.'</b>

Оплатите его, нажав кнопку "Мои заказы" ниже';
	
		return $text;
	}

	static function welcome(){
		
	$rs = "Xush kelibsiz hurmatli foydalanuvchi";	
		
	return $rs;}
	
	static function error() {
		$text = "Sizni tushunmadim | Неверный запрос";	
		return $text;	
	}
	
	static function lang() {
		
		$text = "Tilni tanlang | Выберите язык";
		
		return $text;	
	}

	static function menu($lang) {
		
		if ($lang=='uz') $text = "
/role - foydalanuvchi roliga otish uchun buyruq
/start - admin roliga otish uchun buyruq

<b>Asosiy menyu</b>";
		if ($lang=='ru') $text = "
/role - команда для смены роля
/start - команда для смены роля на админа

<b>Главное меню</b>";
		
		return $text;	
	}
		
	static function choose_country($lang)
	{
		if ($lang=='uz') $text = 'Iltimos, mamlakatni tanlang';
        if ($lang=='ru') $text = 'Пожалуйста, выберите страну';

        return $text;
	}
	
	static function in_developing($lang)
	{
		
		if ($lang=='uz') $text = 'Ishlab chiqilmoqda, boshqa variantni tanlang';
        if ($lang=='ru') $text = 'В разработке, пожалуйста выберите другой вариант';

        return $text;
		
	}
	
	static function channels_list($lang)
    {
        if ($lang == 'uz') $text = "<b>Guruhlar va kannalar ro'yhati </b>";
        if ($lang == 'ru') $text = "<b>Список каналов и групп</b>";

        return $text ;
    }
	
	
	static function channels ($tg_users)
	{
		$chat_id = $tg_users['CHAT_ID'];
		
        $channels_list = db::arr("SELECT * FROM `telegram_channels` WHERE `ADMIN_JSON` LIKE '%\"id\":$chat_id%' AND ACTIVE NOT IN ('0')");

        for ($i = 0; $i < count($channels_list); $i++){
            $mess .= ($i+1) . '. ' . $channels_list[$i]['NAME'] . PHP_EOL;
        }

        if ($tg_users['LANG'] == 'uz') $text = "Ba'tafsil ma'lumot olish uchun pasdagi tugmalardan birini bosing 👇🏼";
        if ($tg_users['LANG'] == 'ru') $text = "Выберите кнопку для просмотра подробных деталей  👇🏼";

        $message = $mess . PHP_EOL . $text;              

        return $message ;
    }
	
	static function channel_info($id, $lang)
	{
		$LANG = strtoupper($lang);
		
		$channel = db::arr_s("SELECT * FROM `telegram_channels` WHERE ID = '$id'");
		
		$category = db::arr("SELECT * FROM `job_category` WHERE ACTIVE = '1'");
		
$cat_name = '';
		
		foreach (json_decode($channel['SETTINGS_JSON'],true) as $k2=>$v2){
	
		if ($v2==1){$sts = '✔️';$cat_name = $cat_name . $category[$k2]['NAME_'.$LANG].' '.$sts.' 
';	}else{$sts='➖';}	

		}		
		
	
	if($lang == 'ru')
	{
		$text = "
<i>Назвние: $channel[NAME]</i>

<i>Количество участников: $channel[MEMBER_COUNT]</i>

<i>Список категорий:</i>

$cat_name

<i>Частота публикаций в день: $channel[JOB_QUANTITY]</i>";
	}
	
	if($lang == 'uz')
	{
		$text = "
<i>Nomi: $channel[NAME]</i>

<i>Obunachilar soni: $channel[MEMBER_COUNT]</i>

<i>Kategoriyalar ro'yhati:</i>

$cat_name

<i>Kunlik elonlar soni: $channel[JOB_QUANTITY]</i>";
	}

	return $text;
	}	
	
	
	static function category_list($lang)
	{
		if($lang == 'ru') $text = "Выберите категорию 👇🏼";
		if($lang == 'uz') $text = "Kategoriya tanlang 👇🏼";
		
		return $text;
	}
	
	static function job_quantity($lang)
	{
		if($lang == 'ru') $text = "Введите количество публикаций в день:";
		if($lang == 'uz') $text = "Kunlik elonlar sonini kiriting:";
		
		return $text;
	}

	static function edited_success($lang)
	{
		if($lang == 'ru') $text = "Данные успешно изменены!";
		if($lang == 'uz') $text = "Malumotlar muvofaqiyatli o'zgartirildi!";
		
		return $text;
	}
	
static function command_mess($lang)
{
if($lang == 'ru') $text = "
/role - команда для смены роля
/start - команда для смены роля на админа";
if($lang == 'uz') $text = "
/role - foydalanuvchi roliga otish uchun buyruq
/start - admin roliga otish uchun buyruq";
		
return $text;	
}
	
	
}
?>