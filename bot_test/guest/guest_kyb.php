<?
class guest_kyb
{
	static function zakaz_button($lang)
	{

		if ($lang == 'ru') {
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Мои заказы"],],
				]
			]);
		}
		if ($lang == 'uz') {
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Mening zakazlarim"],],
				]
			]);
		}
		return $start;
	}

	static function user_reports($lang){
		if($lang == 'ru'){
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Добавить нового клиента"]],
					[['text' => "База клиентов"],['text' => "Текущий отчет"]],
					[['text' => "Назад"]]
				]
			]);
		}
		if($lang == 'uz'){
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Yangi mijoz"]],
					[['text' => "Mijozlar bazasi"],['text' => "Joriy xisobot"]],
					[['text' => "Ortga"]]
				]
			]);
		}
		return $start;
	}

	/*static function send_video($lang){
		if($lang == 'ru'){
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Отправить видео"]],
					[['text' => "Назад"]]
				]
			]);
		}
		if($lang == 'uz'){
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Video yuborish"]],
					[['text' => "Orqaga"]]
				]
			]);
		}
		return $start;
	}*/

	static function confirm_video($lang){
		if($lang == 'ru'){
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Отправить"]],
					[['text' => "Отмена"]]
				]
			]);
		}
		if($lang == 'uz'){
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Yuborilsin"]],
					[['text' => "Bekor qilinsin"]]
				]
			]);
		}
		return $start;
	}

	static function add_user($lang){
		if($lang == 'ru'){
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Назад"]]
				]
			]);
		}
		if($lang == 'uz'){
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Ortga"]]
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

static function current_report_arr(){
		$month_text = ['01.'=> 'янв','02.'=>'фев','03.'=>'март','04.'=>'апр','05.'=>'май','06.'=>'июн','07.'=>'июл','08.'=>'авг','09.'=>'сент','10.'=>'окт','11.'=>'ноя','12.'=>'дек'];

$year = date('Y');
$month = date('m');

if ($month==12){
$dates = new DatePeriod(new DateTime(($year).'-1'), new DateInterval('P1M'), new DateTime(date(($year+1).'-1')));	
}else{
$dates = new DatePeriod(new DateTime(($year-1).'-'.($month+1)), new DateInterval('P1M'), new DateTime(date($year.'-'.($month+1))));
}
$date_strings_ok = array_map(function($d) { return $d->format('m.Y'); }, iterator_to_array($dates));


$arr =array_combine($date_strings_ok, $date_strings_ok); ;
foreach ($month_text as $k2=>$v2){$arr = str_replace($k2,$v2.'.',$arr);}

foreach ($arr as $k=>$v){$rs[] = $k;}	

return $rs;
}	

static function current_report($lang){
		$month_text = ['01.'=> 'янв','02.'=>'фев','03.'=>'март','04.'=>'апр','05.'=>'май','06.'=>'июн','07.'=>'июл','08.'=>'авг','09.'=>'сент','10.'=>'окт','11.'=>'ноя','12.'=>'дек'];

if ($lang=='ru'){

$year = date('Y');
$month = date('m');

if ($month==12){
$dates = new DatePeriod(new DateTime(($year).'-1'), new DateInterval('P1M'), new DateTime(date(($year+1).'-1')));	
}else{
$dates = new DatePeriod(new DateTime(($year-1).'-'.($month+1)), new DateInterval('P1M'), new DateTime(date($year.'-'.($month+1))));
}
$date_strings_ok = array_map(function($d) { return $d->format('m.Y'); }, iterator_to_array($dates));


$arr =array_combine($date_strings_ok, $date_strings_ok); ;
foreach ($month_text as $k2=>$v2){$arr = str_replace($k2,$v2.'.',$arr);}

foreach ($arr as $k=>$v){
$final_arr[] = ["text"=>$v,"callback_data"=>'admin#'.$k];	
}

$items =  array_chunk($final_arr,2);
$keyboard = ["inline_keyboard" => $items];	
$start = json_encode($keyboard);		
}
if ($lang=='uz'){

	$year = date('Y');
	$month = date('m');
	
	if ($month==12){
	$dates = new DatePeriod(new DateTime(($year).'-1'), new DateInterval('P1M'), new DateTime(date(($year+1).'-1')));	
	}else{
	$dates = new DatePeriod(new DateTime(($year-1).'-'.($month+1)), new DateInterval('P1M'), new DateTime(date($year.'-'.($month+1))));
	}
	$date_strings_ok = array_map(function($d) { return $d->format('m.Y'); }, iterator_to_array($dates));
	
	
	$arr =array_combine($date_strings_ok, $date_strings_ok); ;
	foreach ($month_text as $k2=>$v2){$arr = str_replace($k2,$v2.'.',$arr);}
	
	foreach ($arr as $k=>$v){
	$final_arr[] = ["text"=>$v,"callback_data"=>'admin#'.$k];	
	}
	
	$items =  array_chunk($final_arr,2);
	$keyboard = ["inline_keyboard" => $items];	
	$start = json_encode($keyboard);		
	}
	return $start;
}

static function district_type($lang){
	if ($lang == 'ru') {
		$select_district = db::arr("SELECT * FROM ac_rayon WHERE ACTIVE = 1");
	foreach($select_district as $v){
		$arr[] = ["text" => $v['NAME_RU'], "callback_data" => 'district_'.$v['ID']];
	}

	$items = array_chunk($arr, 2);
	$keyboard = ["inline_keyboard" => $items];
	$start = json_encode($keyboard);

	}
	if ($lang == 'uz') {
		$select_district = db::arr("SELECT * FROM ac_rayon WHERE ACTIVE = 1");
	foreach($select_district as $v){
		$arr[] = ["text" => $v['NAME_UZ'], "callback_data" => 'district_'.$v['ID']];
	}

	$items = array_chunk($arr, 2);
	$keyboard = ["inline_keyboard" => $items];
	$start = json_encode($keyboard);

	}
	return $start;
}

static function nazad($lang){
	if ($lang == 'ru') {
		$start = json_encode([
			'inline_keyboard' =>  [
					[['text' => "Назад", 'callback_data' => "go_back"]]
			]
		]);
	}
	if ($lang == 'uz') {
		$start = json_encode([
			'inline_keyboard' =>  [
				[['text' => "Orqaga", 'callback_data' => "go_back"]]
			]
		]);
	}
	return $start;
}

	static function social_networks($lang){
		if ($lang == 'ru') {
			$start = json_encode([
				'inline_keyboard' =>  [
						[['text' => "Telegram", 'callback_data' => "telegram"]],
						[['text' => "Instagram", 'callback_data' => "instagram"]],
						[['text' => "Facebook", 'callback_data' => "facebook"]],
						[['text' => "От знакомых", 'callback_data' => "acquaintances"]]
				]
			]);
		}
		if ($lang == 'uz') {
			$start = json_encode([
				'inline_keyboard' =>  [
					[['text' => "Telegram", 'callback_data' => "telegram"]],
					[['text' => "Instagram", 'callback_data' => "instagram"]],
					[['text' => "Facebook", 'callback_data' => "facebook"]],
					[['text' => "Tanishlar orqali", 'callback_data' => "acquaintances"]]
				]
			]);
		}
		return $start;
	}

	static function confirm_address($lang)
	{

		if ($lang == 'ru') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Да, в этот адрес", 'callback_data' => "yes"], ['text' => "Нет, в другой адрес", 'callback_data' => "no"]],
				]
			]);
		}

		if ($lang == 'uz') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Ha, shu manzilga", 'callback_data' => "yes"], ['text' => "Yo`q, boshqa manzilga", 'callback_data' => "no"]],
				]
			]);
		}

		return $start;
	}

	static function pay_delivery($lang)
	{

		if ($lang == 'ru') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Самовывоз", 'callback_data' => "pickup"], ['text' => "Почта(Вилоятга)", 'callback_data' => "pochta"]],
					[['text' => "Ташкент доставка", 'callback_data' => "dostavka"],['text' => "Яндекс доставка(Ташкент)", 'callback_data' => "yandex"]]
				]
			]);
		}

		if ($lang == 'uz') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Mustaqil olib ketish", 'callback_data' => "pickup"], ['text' => "Pochta(Viloyatga)", 'callback_data' => "pochta"]],
					[['text' => "Toshkent bo'ylab yetkazib berish ", 'callback_data' => "dostavka"],['text' => "Yandex dostavka orqali", 'callback_data' => "yandex"]]
				]
			]);
		}

		return $start;
	}

	static function payment_type($lang)
	{

		if ($lang == 'ru') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Наличные", 'callback_data' => "cash"], ['text' => "Перевод на карту", 'callback_data' => "card"]],
				]
			]);
		}

		if ($lang == 'uz') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Naqd", 'callback_data' => "cash"], ['text' => "Karta", 'callback_data' => "card"]],
				]
			]);
		}

		return $start;
	}

	static function card_type($lang)
	{

		if ($lang == 'ru') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Перевод на карту", 'callback_data' => "card"]],
				]
			]);
		}

		if ($lang == 'uz') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Karta", 'callback_data' => "card"]],
				]
			]);
		}

		return $start;
	}

	static function zakaz_list($zakaz_list)
	{

		if ($zakaz_list == 'empty') {

			$rs = "null";
		} else {
			foreach ($zakaz_list as $zl) {
				$items[] = ["text" => $zl['ID'], "callback_data" => "PAY_" . $zl['ID']];
			}

			$items_final = array_chunk($items, 1);

			$keyboard = ["inline_keyboard" => $items_final];

			$rs = json_encode($keyboard);
		}
		return $rs;
	}

	static function start($lang)
	{

		if ($lang == 'ru') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Регистрация ✅", 'callback_data' => "reg_start"],],
				]
			]);
		}

		if ($lang == 'uz') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "Ro`yxatdan o`tish ✅", 'callback_data' => "reg_start"],],
				]
			]);
		}

		return $start;
	}

	static function admin()
	{

		$lang = json_encode(['resize_keyboard' => true, 'keyboard' => [[['text' => "ZAKAZ"],],]]);

		return $lang;
	}

	static function lang()
	{

		$lang = json_encode(['resize_keyboard' => true, 'keyboard' => [[['text' => "O`zbek tili 🇺🇿"], ['text' => "Русский язык 🇷🇺"]],]]);

		return $lang;
	}


	static function choose_role($lang)
	{
		if ($lang == 'ru') {
			$role = json_encode(['resize_keyboard' => true, 'keyboard' => [[['text' => "Я работодатель 👤"], ['text' => "Я работник 👤"]],]]);
		}
		if ($lang == 'uz') {
			$role = json_encode(['resize_keyboard' => true, 'keyboard' => [[['text' => "Men ish beruvchi 👤"], ['text' => "Men ishchi 👤"]],]]);
		}

		return $role;
	}

	static function ask_name($lang)
	{

		if ($lang == 'ru') {
			$start = json_encode([
				'remove_keyboard' => true
			]);
		}
		if ($lang == 'uz') {
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Регистрация ✅", 'request_contact' => true],],
				]
			]);
		}
		return $start;
	}

	static function reg($lang)
	{

		if ($lang == 'ru') {
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Регистрация ✅", 'request_contact' => true],],
				]
			]);
		}
		if ($lang == 'uz') {
			$start = json_encode([
				'resize_keyboard' => true,
				'keyboard' => [
					[['text' => "Регистрация ✅", 'request_contact' => true],],
				]
			]);
		}
		return $start;
	}

	static function main_menu($lang)
	{
		$LANG = strtoupper($lang);
		foreach (db::arr("SELECT * FROM job_category WHERE ACTIVE=1") as $v) {
			$kyb[] = ["text" => $v['NAME_' . $LANG]];
		}
		$kyb_final = array_chunk($kyb, 2);
		$keyboard = ["resize_keyboard" => true, "keyboard" => $kyb_final];
		$rs = json_encode($keyboard);
		return $rs;
	}

	static function pagination($lang)
	{
		$button[] = ["text" => "⬅️"];
		$button[] = ["text" => "➡️"];

		if ($lang == 'uz') {
			$button[] = ["text" => "🏠 Asosiy menyu"];
		}

		if ($lang == 'ru') {
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


	static function company_info($lang, $id)
	{
		if ($lang == 'ru') {
			$kyb[] = ["text" => "ℹ  О Компании", "callback_data" => "company_info_" . $id];
		}
		if ($lang == 'uz') {
			$kyb[] = ["text" => "ℹ Kompaniya haqida", "callback_data" => "company_info_" . $id];
		}


		$kyb_final = array_chunk($kyb, 1);
		$keyboard = ["inline_keyboard" => $kyb_final];
		$rs = json_encode($keyboard);

		return $rs;
	}


	static function choose_country($lang)
	{
		$LANG = strtoupper($lang);

		$country_list = db::arr("SELECT * FROM `country_list` WHERE STATUS NOT IN ('0')");

		foreach ($country_list as $v) {
			$button[] = ['text' => $v['NAME_' . $LANG]];
		}

		$kyb = array_chunk($button, 2);

		$keyboard = ["resize_keyboard" => true, "keyboard" => $kyb];
		$rs = json_encode($keyboard);
		return $rs;
	}

	static function delete_keyboard()
	{

		$start = json_encode([
			'remove_keyboard' => true
		]);

		return $start;
	}

	static function reject_keyboard($lang)
	{

		if ($lang == 'ru') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "ВВОД", 'callback_data' => "otkaz_start"],],
				]
			]);
		}

		if ($lang == 'uz') {
			$start = json_encode([
				'inline_keyboard' => [
					[['text' => "KIRITISH", 'callback_data' => "otkaz_start"],],
				]
			]);
		}

		return $start;
	}
}
