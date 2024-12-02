<?
class guest_msg {

	static function get_location($lang){
		if($lang == 'uz'){
			$text = "<b>Rahmat, buyurtmangiz tez orada yetib keladi!</b>";
		}

		if($lang == 'ru'){
			$text = "<b>Спасибо, ваш заказ скоро прибудет!</b>";
		}

		return $text;
	}

	static function send_location($lang){
		if($lang == 'uz'){
			$text = "<b>Buyurtmani yuborishimiz manzilini lokatsiyasi📍</b>
			
			LOKATSIYA JO`NATING - u yerga yetkazib beramiz";
		}

		if($lang == 'ru'){
			$text = "<b>Местоположение для отправки заказа📍</b>
			
			ОТПРАВЬТЕ ЛОКАЦИЮ - куда нужно будет доставить";
		}

		return $text;
	}

	static function district_type($lang){
		if($lang == 'uz'){
			$text = "Tumanni tanlang";
		}

		if($lang == 'ru'){
			$text = "Выберите район";
		}

		return $text;
	}
	
	static function admin_role_not_found($lang) {
		if ($lang == 'uz') {
			$text = "SIZ HOZIRDA ADMIN EMASSIZ, ADMIN BO`LISH UCHUN BIZ BILAN BOG`LANING";
		}
		if ($lang == 'ru') {
			$text = "В НАСТОЯЩЕЕ ВРЕМЯ ВЫ НЕ ЯВЛЯЕТЕСЬ АДМИНОМ, ЧТОБЫ СТАТЬ АДМИНОМ СВЯЖИТЕСЬ С НАМИ";
		}
			
		return $text;	
	}
	
	static function otkaz_data($key) {
		$otkaz_array = ['ism_otkaz'=>'ISM FAMILIYA', 'raqam_otkaz'=>'TELEFON RAQAM', 'adres_otkaz'=>'ADRES', 'p1_otkaz'=>'PASSPORTNI OLDI TARAFI','p2_otkaz'=> 'PASSPORTNI ORQA TARAFI', 'app_otkaz'=>'SKLAD SKRINSHOTI', 'pay_otkaz'=>'TO`LOV SKRINSHOTI'];
		
		$otkaz_event_code = ['ism_otkaz'=>'ask_name', 'raqam_otkaz'=>'ask_phone', 'adres_otkaz'=>'ask_adres', 'p1_otkaz'=>'ask_passport','p2_otkaz'=> 'ask_passport2', 'app_otkaz'=>'ask_app', 'pay_otkaz'=>'ask_payment'];
		
		return $otkaz_event_code[$key];
	}
	
	static function table_name($key) {
		
		$table = ['ism_otkaz'=>'ISM_FAMILIYA', 'raqam_otkaz'=>'PHONE', 'adres_otkaz'=>'ADRES', 'p1_otkaz'=>'P_PHOTO_1','p2_otkaz'=> 'P_PHOTO_2', 'app_otkaz'=>'APP_PHOTO', 'pay_otkaz'=>'OPLATA_PHOTO'];
		
		return $table[$key];
	}
	
	static function lang() {
		
		$text = "Tilni tanlang | Выберите язык";
		
		return $text;	
	}
	
	static function valid($lang) {
		if ($lang == 'uz') {
			$text = "SIZ NOTO’G’RI MA’LUMOT TURINI JO’NATDINGIZ, YUQORIYDAGI KO‘RSATMALARGA MUVOFIQ QILING 👆";
		}
		if ($lang == 'ru') {
			$text = "ВЫ ОТПРАВИЛИ НЕВЕРНЫЙ ТИП ДАННЫХ, ПОЖАЛУЙСТА СЛЕДУЙТЕ ИНСТРУКЦИЯМ ВЫШЕ 👆";
		}
			
		return $text;	
	}
	
	static function phone_valid($lang) {
		if ($lang == 'uz') {
			$text = "Telefon raqam noto`g`ri kiritilgan, boshidan 998 kodi bilan birga yozib kiriting 👆";
		}
		if ($lang == 'ru') {
			$text = "НОМЕР ТЕЛЕФОНА ВВЕДЕН НЕВЕРНО, ВВЕДИТЕ ПОВТОРНО ВМЕСТЕ С КОДОМ 998 👆";
		}
			
		return $text;	
	}
	
	static function menu_word($lang) {
		if ($lang == 'uz') {
			$text = "ASOSIY MENYU";
		}
		if ($lang == 'ru') {
			$text = "ГЛАВНОЕ МЕНЮ";
		}
			
		return $text;	
	}
	
	static function payment_type($lang) {
		if ($lang == 'uz') {
			$text = "TO`LOV TURINI TANLANG:";
		}
		if ($lang == 'ru') {
			$text = "ВЫБЕРИТЕ ТИП ОПЛАТЫ:";
		}
		return $text;	
	}
	
	static function zakaz_not_found($lang) {
		if ($lang == 'uz') {
			$text = "SIZDA HOZIR RASMIYLASHTIRISH KERAK BO`LGAN BUYURTMALAR MAVJUD EMAS";
		}
		if ($lang == 'ru') {
			$text = "В НАСТОЯЩЕЕ ВРЕМЯ У ВАС НЕТ ЗАКАЗОВ ДЛЯ ОФОРМЛЕНИЯ";
		}
		return $text;
	}
	
	static function order_detail($lang, $order_data) {
	
	$order_item = db::arr("SELECT * FROM `order_item` WHERE ORDER_ID='$order_data[ID]'");
	$msg = '';
	/*
	foreach ($order_item as $o) {
		$msg = $o['TRACK_CODE']."
".$msg;
	}
	*/
		if ($lang == 'uz') {
			$text = "BUYURTMA # <b>$order_data[ID]</b>
KG: $order_data[WEIGHT]
NARXI: $ $order_data[PRICE]
MIJOZ: $order_data[CLIENT_CODE]
	
<b>TREK KODLAR:</b>
$msg";
		}
		
		if ($lang == 'ru') {
			$text = "ЗАКАЗ # <b>$order_data[ID]</b>
КГ: $order_data[WEIGHT]
ЦЕНА: $ $order_data[PRICE]
КЛИЕНТ: $order_data[CLIENT_CODE]

<b>ТРЕК КОДЫ:</b>
$msg";
		}
			
		return $text;	
	}
	
	static function call_to_office($lang, $zakaz_nomer) {
		if ($lang == 'uz') {
			$text = "XURMATLI MIJOZ, SIZNI OFISIMIZDA KUTAMIZ
			
BUYURTMA RAQAMINGIZ: <b>$zakaz_nomer</b>";
		}
		if ($lang == 'ru') {
			$text = "УВАЖАЕМЫЙ ПОКУПАТЕЛЬ, ЖДЕМ ВАС В ОФИСЕ

НОМЕР ЗАКАЗА: <b>$zakaz_nomer</b>";
		}
		return $text;	
	}
	
	static function zakaz_list($lang) {
		if ($lang == 'uz') {
			$text = "SIZNING BUYURTMALARINGIZ

BUYURTMANI QABUL QILISH UCHUN PASDAGI BUYURTMA RAQAMINI BOSING:";
		}
		if ($lang == 'ru') {
			$text = "ВАШИ ЗАКАЗЫ

ДЛЯ ОФОРМЛЕНИЕ ЗАКАЗА, ПОЖАЛУЙСТА, НАЖМИТЕ НА НОМЕР ЗАКАЗА:";
		}
		return $text;	
	}
	
	static function approve_order_payment($lang, $order_id, $type) {
		
		if ($lang == 'uz') {
			if ($type == "pochta") {
				$text = "<b>TO`LOVINGIZ TASDIQLANDI</b>

BUYURTMA RAQAMI: <b>$order_id</b>
	
BUYURTMANGIZ TEZ KUNDA POCHTA ORAQALIK SIZGA YETIB BORADI";
			}
			
			if ($type == "pickup") {
				$text = "<b>TO`LOVINGIZ TASDIQLANDI</b>
				
BUYURTMA RAQAMI: <b>$order_id</b>
					
BUYURTMANGIZNI BIZNING OFISIMIZDAN OLIB KETISHINGIZ MUMKIN";
			}
		}
		
		if ($lang == 'ru') {
			if ($type == "pochta") {
				$text = "<b>ВАШ ПЛАТЕЖ ПОДТВЕРЖДЕН</b>
				
НОМЕР ЗАКАЗА: <b>$order_id</b>
					
В СКОРОМ ВРЕМЕНИ МЫ ВЫШЛЕМ ВАШ ЗАКАЗ ЧЕРЕЗ ПОЧТУ";
			}
						
			if ($type == "pickup") {
				$text = "<b>ВАШ ПЛАТЕЖ ПОДТВЕРЖДЕН</b>
				
НОМЕР ЗАКАЗА: <b>$order_id</b>
					
ВЫ МОЖЕТЕ ЗАБРАТЬ ВАШ ЗАКАЗ С НАШЕГО ОФИСА";
			}
		}
		return $text;	
	}	
	
	static function confirm_address($lang, $address) {
		if ($lang == 'uz') {
			$text = "POCHTANI QUYDAGI ADRES BO`YICHA YUBORAYLIKMI?

$address";
		}
		if ($lang == 'ru') {
			$text = "ОТПРАВИТЬ ПОЧТУ ПО НИЖЕУКАЗОННОМУ АДРЕСУ?
			
$address";
		}
			
		return $text;	
	}
	
	static function pay_delivery($lang) {
		if ($lang == 'uz') {
			$text = "BUYURTMANI O`ZINGIZ SKLADDAN OLIB KETASMI YOKI POCHTA ORQALIK CHIQARIB YUBORAYLIKMI?";
		}
		if ($lang == 'ru') {
			$text = "ВЫ САМИ ЗАБЕРЕТЕ ЗАКАЗ ИЛИ ОТПРАВИТЬ ВАМ ЧЕРЕЗ ПОЧТУ?";
		}
			
		return $text;	
	}
	
	static function pay_wait($lang) {
		if ($lang == 'uz') {
			$text = "<b>TO`LOVINGIZ TASDIQLANISHINI KUTING</b>
			
TO`LOVNI OPERATORLARIMIZ TASDIQLASHGANDAN SO`NG KEINGI BOSQICHGA O`TASIZ";
		}
		if ($lang == 'ru') {
			$text = "<b>ДОЖДИТЕCЬ ПОДТВЕРЖДЕНИЯ ВАШЕГО ПЛАТЕЖА</b>
			
ПОСЛЕ ПОДТВЕРЖДЕНИЯ ОПЛАТЫ НАШИМИ ОПЕРАТОРАМИ, ВЫ ПЕРЕЙДЕТЕ К СЛЕДУЮЩЕМУ ЭТАПУ";
		}
			
		return $text;	
	}
	
	static function error() {
		$text = "Sizni tushunmadim | Неверный запрос";	
		return $text;	
	}
	
	static function welcome($lang){
		if ($lang=='uz') {
		 $text = "<b>Assalomu alaykum, ALI BRAND CARGO telegram botiga xush kelibsiz!</b>";}
		
		if ($lang=='ru') {
			$text = "<b>Здравствуйте, добро пожаловать в телеграм-бот ALI BRAND CARGO!</b>";}
		
		return $text;	
	}
	
	static function start($lang){
		if ($lang=='uz') {
		 $text = "Ro`yxatdan o`tib ID olish uchun quydagi ma`lumotlarni tayyorlab qo`ying:
		
		1. ISM
		2. TELEFON RAQAM
		3. YETKAZIB BERISH UCHUN O`ZBEKISTON ADRESI
		4. PASSPORT yo`ki ID KARTA
		5. BUYURTMA BERISH UCHUN ILOVA (TAOBAO va hokazo)
		
<b>Agarda sizda barcha ma`lumotlar mavjud bo'lsa pasdagi «Ro`yxatdan o`tish ✅» tugmasini bosing</b> 👇";}
		
		
		if ($lang=='ru') {
			$text = "Для регистрации и получения ID подготовьте следующую информацию:
			
			1. ИМЯ
			2. НОМЕР ТЕЛЕФОНА
			3. АДРЕС ДОСТАВКИ В УЗБЕКИСТАНЕ
			4. ПАСПОРТ или ID карта
			5. ПРИЛОЖЕНИЕ ДЛЯ ЗАКАЗА (TAOBAO и т.д.)
			
<b>Если у вас есть вся информация, нажмите кнопку «Регистрация ✅» ниже</b> 👇";}
		
		return $text;	
	}
	
	static function wait_confirm($lang){
		if ($lang=='uz') {
		 $text = "<b>SIZNING MUROJATINGIZ KO`RIB CHIQILMOQDA. ILTIMOS, TASDIQLASHNI KUTING

HALI SIZ OLGAN KOD AKTIV EMAS

TASDIQLASHDAN SO`NG AKTIV BO`LADI
		 
BIZ OZIMIZ SIZGA BOT ORQALI XABAR BERAMIZ</b>";}
		
		
		if ($lang=='ru') {
			$text = "<b>ВАША ЗАЯВКА РАССМАТРИВАЕТСЯ. ПОЖАЛУЙСТА, ЖДИТЕ ПОДТВЕРЖДЕНИЯ
			
ПОЛУЧЕННЫЙ КОД ЕЩЕ НЕ АКТИВИРОВАН
			
ОН БУДЕТ АКТИВЕН ПОСЛЕ ПОДТВЕРЖДЕНИЯ
			
МЫ УВЕДОМИМ ВАС ЧЕРЕЗ БОТА</b>";
			}
		
		return $text;	
	}
	
	static function ask_name($lang){
		
		if ($lang=='uz') {
			$text = "<b>ISMINGIZNI PASSPORT BO`YICHA KIRITING</b>
	
MISOL: ADXAMOV BUNYOD AKROM O`G`LI";
		}
		
		if ($lang=='ru') {
			$text = "<b>ВВЕДИТЕ ВАШЕ ИМЯ В СООТВЕТСТВИИ С ПАСПОРТОМ</b>
			
ПРИМЕР: ADXAMOV BUNYOD AKROM O`G`LI";}
		
		return $text;	
	}
	
	static function ask_phone($lang){
		
		if ($lang=='uz') {
			$text = "<b>MUROJAT UCHUN TELEFON RAQAMINGIZNI KIRITING</b>
		
MISOL: +998 88 888 88 88";
		}
		
		if ($lang=='ru') {
			$text = "<b>ВВЕДИТЕ НОМЕР ТЕЛЕФОНА ДЛЯ СВЯЗИ</b>
			
ПРИМЕР: +998 88 888 88 88";
		}
		
		return $text;	
	}
	
	static function ask_adres($lang){
		
		if ($lang=='uz') {
			$text = "<b>YETKAZIB BERISH UCHUN TO`LIQ ADRESNI KIRITING</b>
		
MISOL: Samarqand viloyati, Samarqand shahri, Mustaqillik ko'chasi, 8";
		}
		
		if ($lang=='ru') {
			$text = "<b>ВВЕДИТЕ ПОЛНЫЙ АДРЕС ДЛЯ ДОСТАВКИ</b>
			
ПРИМЕР: Samarqand viloyati, Samarqand shahri, Mustaqillik ko'chasi, 8";
		}
		
		return $text;	
	}
	
	static function ask_network($lang){
		if ($lang=='uz') {
			$text = "<b>Bizni qanday topdingiz?</b>";
		}
		
		if ($lang=='ru') {
			$text = "<b>Как вы нашли нас?</b>";
		}
		return $text;
	}

	static function admin_role($lang){
		if ($lang=='uz') {
			$text = "<b>Admin roliga xush kelibsiz!</b>";
		}
		
		if ($lang=='ru') {
			$text = "<b>Добро пожаловать в роль администратора!</b>";
		}
		return $text;
	}

	static function add_user($lang){
		if ($lang=='uz') {
			$text = "<b>Yangi mijoz qo'shishingiz mumkin</b>

Mijoz qo`shih uchun uning telefon raqimini kiriting quydagi formatda kiriting ⬇️

MISOL: 998991112233";
		}
		
		if ($lang=='ru') {
			$text = "<b>Вы можете добавить нового клиента</b>

Введите номер клиента в следующем формате ⬇️

НАПРИМЕР: 998991112233";
		}
		return $text;
	}

	static function confirm_video($lang){
		if ($lang=='uz') {
			$text = "<b>Mijozlarga video yuborishni tasdiqlaysizmi?</b>";
		}
		
		if ($lang=='ru') {
			$text = "<b>Подтверждаете ли вы отправку видео клиентам?</b>";
		}
		return $text;
	}

	static function finish_video($lang){
		if ($lang=='uz') {
			$text = "<b>Video yuborildi</b>";
		}
		
		if ($lang=='ru') {
			$text = "<b>Видео отправлено</b>";
		}
		return $text;
	}

	static function current_report($lang){
		if ($lang=='uz') {
			$text = "<b>Buyurtmalar xisoboti</b>";
		}
		
		if ($lang=='ru') {
			$text = "<b>Отчет о заказах</b>";
		}
		return $text;
	}

	static function send_video($lang){
		if ($lang=='uz') {
			$text = "<b>Video yuborishingiz mumkin</b>";
		}
		
		if ($lang=='ru') {
			$text = "<b>Вы можете отправить видео</b>";
		}
		return $text;
	}

	static function end_report($lang){
		if ($lang=='uz') {
			$text = "<b>Xisobot bo'yicha ish yakunlandi</b>";
		}
		
		if ($lang=='ru') {
			$text = "<b>Работа над отчетом завершена</b>";
		}
		return $text;
	}

	static function connected_user($lang){
		if ($lang=='uz') {
			$text = "<b>Bu mijoz adminga ulangan</b>
			
Boshidan raqam kiriting, yoki `Ortga` tugmasini bosing";
		}
		
		if ($lang=='ru') {
			$text = "<b>Этот клиент подключен к администратору</b>

Введите номер заново или нажмите на кнопку `Назад`";
		}
		return $text;
	}

	static function add_phone($lang){
		if ($lang=='uz') {
			$text = "<b>Mijoz qo'shildi</b>";
		}
		
		if ($lang=='ru') {
			$text = "<b>Клиент добавлен</b>";
		}
		return $text;
	}

	static function adminka_menu($lang){
		if ($lang=='uz') {
			$text = "<b>Admin menyusiga qaytdingiz</b>";
		}
		
		if ($lang=='ru') {
			$text = "<b>Вы вернулись в меню админа</b>";
		}
		return $text;
	}

	static function ask_passport($lang){
		
		if ($lang=='uz') {
			$text = "<b>PASSPORT yoki ID KARTA ni 'OLDI' tarafini rasimga olib tashlang</b>
		
PASDAGI RASIMDA SIZGA MISOL KORSATILGAN 👇";
		}
		
		if ($lang=='ru') {
			$text = "<b>Отправьте ПЕРЕДНЮЮ сторону паспорта или ID карты как изображение</b>
			
НА ИЗОБРАЖЕНИИ НИЖЕ ПОКАЗАН ПРИМЕР 👇";
		}
		
		return $text;	
	}
	
	static function ask_passport2($lang){
		
		if ($lang=='uz') {
			$text = "<b>PASSPORT yoki ID KARTA ni 'ORQA' tarafini rasimga olib tashlang</b>
		
PASDAGI RASIMDA SIZGA MISOL KORSATILGAN 👇";
		}
		
		if ($lang=='ru') {
			$text = "<b>Отправьте ЗАДНЮЮ сторону паспорта или ID карты как изображение</b>
			
НА ИЗОБРАЖЕНИИ НИЖЕ ПОКАЗАН ПРИМЕР 👇";
		}
		
		return $text;	
	}
	
	static function zakaz_payment($lang, $order_data){
	
		db::query("UPDATE `ac_zakaz` SET `PAYMENT_TYPE` = 'card' WHERE `ID` = '$order_data[ID]'");
	$card_info = db::arr_s("SELECT * FROM `ac_card_info`");
	$kurs = db::arr_s("SELECT * FROM kurs_valyut WHERE ACTIVE=1");
	$som_price = $kurs['VALUE'] * $order_data['PRICE'];
	
	$obshiySom = $som_price + 15000;
	
	$som = number_format($som_price,0,'',' ');

	

	$orderTextUz = " 
TO’LOV SUMMASI: $som";

	$orderTextRu = "	
СУММА ОПЛАТЫ: $som";

	if($order_data['DELIVERY_TYPE'] == 'pochta'){
	if($order_data['WEIGHT'] < 1){
		$orderTextUz = "POCHTA UCHUN TO’lOV: 15 000 SO’M (Yukingiz 1kg yoki undan kam bo’lgani uchun) 

TO’LOV SUMMASI: $obshiySom";

		$orderTextRu = "ОПЛАТА ПОЧТЫ: 15 000 СУМ (При весе Вашего отправления 1 кг и менее)

СУММА ОПЛАТЫ: $obshiySom";

	}
	}
			if ($lang=='uz') {
				$text = "HOZIRGI KURS $kurs[VALUE]

BUYURTMANI SO`MDA NARXI: $som

$orderTextUz			

QUYDAGI KARTAGA SHU PULNI YUBORIB, TO`LOV SKRINSHOTINI YUBORING

$card_info[NUMBER]
$card_info[HOLDER]";
			}
			
		if ($lang=='ru') {
					$text = "ТЕКУЩИЙ КУРС $kurs[VALUE]

СУММА ЗАКАЗА В СУМАХ: $som	
$orderTextRu

ПЕРЕВЕДИТЕ ДЕНЬГИ НА КАРТУ НИЖЕ, И ОТПРАВЬТЕ СКРИНШОТ ПЛАТЕЖА

<code>$card_info[NUMBER]</code>
$card_info[HOLDER]";
		}
		
		return $text;	
	}
	
	static function ask_payment($lang){
		
		if ($lang=='uz') {
			$text = "KOD OLISH NARXI <b>20 000 UZS</b>
			
QUYDAGI KARTAGA PUL YUBORIB, TO`LOV SKRINSHOTINI YUBORING
			
8600140414125535
ERKINOV NODIR";
		}
		
		if ($lang=='ru') {
			$text = "ЦЕНА ПОЛУЧЕНИЯ КОДА <b>20 000 UZS</b>
			
ПЕРЕВЕДИТЕ ДЕНЬГИ НА КАРТУ НИЖЕ, И ОТПРАВЬТЕ СКРИНШОТ ПЛАТЕЖА

8600140414125535
ERKINOV NODIR";
		}
		
		return $text;	
	}
	
	static function ask_app($lang){
		
		if ($lang=='uz') {
			$text = "<b>VIDEONI KO`RIB BO`LGACH, SKLAD SKRINSHOTINI RASIM QILIB JO`NATING</b>";
		}
		
		if ($lang=='ru') {
			$text = "<b>ПОСЛЕ ПРОСМОТРА ВИДЕО, ОТПРАВЬТЕ СКРИНШОТ УСТАНОВЛЕННОГО СКЛАДА</b>";
		}
		
		return $text;	
	}
	
	static function sklad_message($lang,$code){
		
		if ($lang=='uz') {
			$text = "SIZNING VAQTINCHA KODINGIZ: <b>$code</b>
			
PASDAGI VIDEO INSTRUKCIYA BO'YICHA SKLAD MA`LUMOTLARINI TO`LDIRING VA SKRINSHOT QILIB YUBORING";
		}
		
		if ($lang=='ru') {
			$text = "ВАШ ВРЕМЕННЫЙ КОД: <b>$code</b>
			
СЛЕДУЙТЕ ВИДЕО-ИНСТРУКЦИЯМ НИЖЕ, ЗАПОЛНИТЕ ДЕТАЛИ СКЛАДА И ОТПРАВЬТЕ СКРИНШОТ";
		}
		
		return $text;	
	}
	
	static function reject_code($lang,$message){
				
				if ($lang=='uz') {
					$text = "XURAMTLI MIJOZ, QUYDAGI MA`LUMOTLAR <b>TASDIQLANISHDAN O`TMADI</b>:
					
".$message."
SHU MA`LUMOTLARNI BOSHIDAN KIRITISH UCHUN PASDAGI <b>KIRITISH</b> TUGMASINI BOSING";
				}
				
				if ($lang=='ru') {
					$text = "УВАЖАЕМЫЙ КЛИЕНТ, СЛЕДУЮЩИЕ ДАННЫЕ <b>НЕ ПРОШЛИ ПОДТВЕРЖДЕНИЕ</b>:
					
".$message."
ЧТОБЫ ЗАПОЛНИТЬ ЭТИ ДАННЫЕ ЗАНОВО НАЖИМТЕ НА КНОПКУ <b>ВВОД</b> НИЖЕ";
				}
				
				return $text;	
			}
	
	static function approved_code($lang,$code){
			
			if ($lang=='uz') {
				$text = "XURAMTLI MIJOZ, TABRIKLAYMIZ SIZNING KODINGIZ TASDIQLANDI!
				
SIZNING KODINGIZ: <b>$code</b>";
			}
			
			if ($lang=='ru') {
				$text = "УВАЖАЕМЫЙ ПОЛЬЗОВАТЕЛЬ, ВАШ КОД ПОДТВЕРЖДЕН, ПОЗДРАВЛЯЕМ!

ВАШ КОД: <b>$code</b>";
			}
			
			return $text;	
		}
		
	static function payment_reject($lang){
				
			if ($lang=='uz') {
				$text = "<b>TO`LOVINGIZ TASDIQLASHDAN O`TMADI</b>";
			}
			
			if ($lang=='ru') {
				$text = "<b>ВАШ ПЛАТЕЖ НЕ ПРОШЕЛ ПОДТВЕРЖДЕНИЕ</b>";
			}
			
			return $text;	
		}

	
}
?>