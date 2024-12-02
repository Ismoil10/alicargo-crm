<?

class employer_msg {

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
	
	static function choose_role($lang){
		if ($lang=='uz') $text = "<b>Iltimos, rolingizni tanlang!</b>";
		if ($lang=='ru') $text = "<b>Пожалуйста, выберите роль!</b>";
		
		return $text;	
	} 

	static function menu($lang) {
		
		if ($lang=='uz') $text = "<b>Asosiy menyu</b>";
		if ($lang=='ru') $text = "<b>Главное меню</b>";
		
		return $text;	
	}
	
	static function reg($lang) {
		
		if ($lang=='uz') $text = "Salom, ro`yxatdan o`ting";
		if ($lang=='ru') $text = "Пожалуйста, пройдите регистрацию";
		
		return $text;	
	}
	
	static function reg_success($lang) {
		
		if ($lang=='uz') $text = 'Muvafaqiyatli ro\'yxatdan o\'tingiz!';
		if ($lang=='ru') $text = 'Вы успешно прошли регистрацию!';
		
		return $text;	
	}
	
	static function my_companies ($tg_users){
		
		$cm_list = db::arr("SELECT * FROM `list_companies` WHERE CHAT_ID = '$tg_users[CHAT_ID]' AND ACTIVE = '1'");

        if($cm_list != 'empty') {

            for ($i = 0; $i < count($cm_list); $i++){
                $mess .= ($i+1) . '. ' . $cm_list[$i]['YUR_NAME'] . PHP_EOL;
            }


            if ($tg_users['LANG'] == 'uz') $text = "Kompaniya xaqida ba'tafsil ma'lumot olish uchun pasdagi tugmalardan birini bosing 👇🏼";
            if ($tg_users['LANG'] == 'ru') $text = "Выберите кнопку для просмотра подробных деталей компании 👇🏼";

            $message = $mess . PHP_EOL . $text;
        }

        else {

            if ($tg_users['LANG'] == 'uz') $message = "Sizda kompaniya mavjud emas";
            if ($tg_users['LANG'] == 'ru') $message = "У вас пока нет компаний";

        }


		
		return $message ;
	}


    static function my_vacancies ($tg_users){

        $job_list = db::arr("SELECT * FROM `job_list` WHERE CHAT_ID = '$tg_users[CHAT_ID]' AND STATUS NOT IN ('draft', 'deleted')");

        if($job_list != 'empty') {

            for ($i = 0; $i < count($job_list); $i++){
                $mess .= ($i+1) . '. ' . $job_list[$i]['TITLE'] . PHP_EOL;
            }


            if ($tg_users['LANG'] == 'uz') $text = "Vakansiya xaqida ba'tafsil ma'lumot olish uchun pasdagi tugmalardan birini bosing 👇🏼";
            if ($tg_users['LANG'] == 'ru') $text = "Выберите кнопку для просмотра подробных деталей вакансии 👇🏼";

            $message = $mess . PHP_EOL . $text;
        }

        else {

            if ($tg_users['LANG'] == 'uz') $message = "Sizda vakansiya mavjud emas";
            if ($tg_users['LANG'] == 'ru') $message = "У вас пока нет вакансий";

        }

        return $message ;
    }

    static function companies_text($lang)
    {
        if ($lang == 'uz') $text = "<b>Kompaniyalarim ro'yhati </b>";
        if ($lang == 'ru') $text = "<b>Список компаний</b>";

        return $text ;
    }

    static function vacancies_text($lang)
    {
        if ($lang == 'uz') $text = "<b>Vakansiyalarim ro'yhati </b>";
        if ($lang == 'ru') $text = "<b>Список вакансий</b>";

        return $text ;
    }
	
	static function job_list($lang,$text) {
		
		if ($lang=='uz') $text = "
		$text
		
		Koproq vakansiya ko`rish uchun pasdagi tugmalar orqali keingi sahifaga otkazin 👇🏼";
		
		if ($lang=='ru') $text = "
		$text
		
		Чтобы посмотреть больше вакансий, используйте кнопки управления 👇🏼";
		
		return $text;	
	}

    static function in_company_name($lang){
        if ($lang == 'uz') $text = "<i>Kompaniya nomi *</i> *";
        if ($lang == 'ru') $text = "<i>Название компании</i> *";

        return $text ;
    }

    static function in_company_yurname($lang){
        if ($lang == 'uz') $text = "<i>Kompaniya yuridik nomi</i> *";
        if ($lang == 'ru') $text = "<i>Юридическое название компании</i> *";

        return $text ;
    }


    static function in_company_desc($lang){
        if ($lang == 'uz') $text = "<i>Kompaniya haqida qisqacha ma'lumot</i> *";
        if ($lang == 'ru') $text = "<i>Краткое описание компании</i> *";

        return $text ;
    }

    static function in_company_adress($lang){
        if ($lang == 'uz') $text = "<i>Kompaniya manzili</i> *";
        if ($lang == 'ru') $text = "<i>Адрес компании</i> *";

        return $text ;
    }

    static function in_company_contact($lang){
        if ($lang == 'uz') $text = "<i>Kompaniya telefon raqamlari</i> *";
        if ($lang == 'ru') $text = "<i>Номер телефона компании</i> *";

        return $text ;
    }

    static function in_company_logo($lang){
        if ($lang == 'uz') $text = "<i>Kompaniya logotipini</i> *";
        if ($lang == 'ru') $text = "<i>Логотип компании</i> *";

        return $text ;
    }


    static function company_del_text($lang){
        if ($lang == 'uz') $text = "Kompaniya muvofaqiyatli o'chirildi!";
        if ($lang == 'ru') $text = "Компания успешно удалена!";

        return $text ;
    }

    static function job_del_text($lang){
        if ($lang == 'uz') $text = "Vakansiya muvofaqiyatli o'chirildi!";
        if ($lang == 'ru') $text = "Вакансия успешно удалена!";

        return $text ;
    }



    static function company_info($id, $lang){

        $data = db::arr_s("SELECT * FROM list_companies WHERE ID = $id");

        if ($lang == 'uz') $text = "
$data[NAME] - $data[YUR_NAME]
        
$data[DESCRIPTION]
        
Adres: $data[ADRESS]
         
Telefon: $data[CONTACTS]";

        if ($lang == 'ru') $text = "
$data[NAME] - $data[YUR_NAME]
        
$data[DESCRIPTION]
        
Адрес: $data[ADRESS]
         
Телефон: $data[CONTACTS]";

        return $text ;
    }


    static function job_info($id, $lang){
		
		$LANG = strtoupper($lang);
		
        $status_text_ru = array("waiting" => "В ожидании подтверждения", "rejected" => "Отказано", "not_active" => "Не активный", "active" => "Активен");
        $status_text_uz = array("waiting" => "Tasdiq kutulmoqda", "rejected" => "Qaytarildi", "not_active" => "Faol emas", "active" => "Faol");

        $data = db::arr_s("SELECT jl.*, jp.NAME_RU as PLAN_RU, jp.NAME_UZ as PLAN_UZ FROM job_list jl LEFT JOIN job_plan jp ON jp.ID = jl.PLAN_ID WHERE jl.ID = $id");

        $status_ru = $status_text_ru[$data[STATUS]];
        $status_uz = $status_text_uz[$data[STATUS]];

        if ($lang == 'uz') $text = "
$data[TITLE]

<i>Oylik:</i>
$data[SALARY]   

<i>Tavsifi:</i>     
$data[BODY]

<i>Aloqa uchun:</i>         
$data[CONTACT_NAME] - $data[CONTACT_PHONE]

<i>Tarif: </i> $data[PLAN_UZ]
<i>Status: </i> $status_uz";

        if ($lang == 'ru') $text = "
$data[TITLE]

<i>Зарплата:</i>
$data[SALARY]   

<i>Описание:</i>     
$data[BODY]

<i>Контактное лицо:</i>         
$data[CONTACT_NAME] - $data[CONTACT_PHONE]

<i>Тариф: </i> $data[PLAN_RU]
<i>Статус: </i> $status_ru";

        return $text ;
    }

    static function company_title($lang)
    {
        if ($lang == 'uz') $text = "<i>Vakansiya sarlavhasi</i> *

Misol, Savdo bo'limiga xodim talab qilinadi";
        if ($lang == 'ru') $text = "<i>Заголовок вакансии</i> *

Например, Требуется сотрудник в отдел продаж";

        return $text ;
    }

    static function select_cat($lang)
    {
        if ($lang == 'uz') $text = "<i>Kategoriya</i>*";
        if ($lang == 'ru') $text = "<i>Категория</i> *";

        return $text ;
    }

    static function job_desc($lang)
    {
        if ($lang == 'uz') $text = "<i>Tavsifi</i> *
		

Vakansiyadan qanday tafsilotlarni bilishni xohlagan bo'lardingiz. Va ularni tavsifga qo'shing :)";
        if ($lang == 'ru') $text = "<i>Описание</i> *

Подумайте, какие подробности вы хотели бы узнать из вакансии. И добавьте их в описание :)";

        return $text ;
    }

    static function salary($lang)
    {
        if ($lang == 'uz') $text = "<i>Ish haqi</i> *

Misol, 1 500 000 - 2 500 000 so'm";
        if ($lang == 'ru') $text = "<i>Зарплата</i> *
		
Например, 1 500 000 - 2 500 000 сум";

        return $text ;
    }

    static function contact_person($lang)
    {
        if ($lang == 'uz') $text = "<i>Aloqa qiluvchi shaxs</i> *";
        if ($lang == 'ru') $text = "<i>Контактное лицо</i> *";

        return $text ;
    }

    static function contacts($lang){
        if ($lang == 'uz') $text = "<i>Aloqa uchun telefon raqamini kiriting</i> *";
        if ($lang == 'ru') $text = "<i>Контакты</i> *";

        return $text ;
    }

    static function select_company($lang){
        if ($lang == 'uz') $text = "<i>Vakansiya uchun kompaniya tanlang</i> *";
        if ($lang == 'ru') $text = "<i>Выберите компанию для вакансии</i> *";

        return $text ;
    }

    static function select_plan($lang)
    {
        if ($lang == 'uz') $text = "<i>Tarif tanlang</i> *";
        if ($lang == 'ru') $text = "<i>Выберите тариф</i> *";

        return $text ;
    }

    static function job_sent_to_admin($lang)
    {
        if ($lang == 'uz') $text = "Vakansiya tasdiq uchun jonatildi";
        if ($lang == 'ru') $text = "Вакансия отправлена на подтверждение";

        return $text ;
    }

    static function select_plan_type($lang)
    {
        if ($lang == 'uz') $text = "Tarif muddatini tanlang";
        if ($lang == 'ru') $text = "Выберите срок";

        return $text ;
    }

    static function payment_text($lang, $plan_id)
    {

        $plan_data = db::arr_s("SELECT * FROM `job_plan` WHERE ID = '$plan_id'");

        if ($lang == 'uz') $text = "Siz tanlagan tarif boyicha $plan_data[PRICE] so'm to'lov qilishingizni so'raymiz! \n
To'lov uchun karta raqami: 8600 2656 9878 5665

* Tasdiq uchun to'lov rasmini jo'natishingini so'raymiz!";
        if ($lang == 'ru') $text = "По выбранному тарифному плану Вам потребуется произвести оплату в размере $plan_data[PRICE] сум \n 
Номер карты для оплаты: 8600 2656 9878 5665

* Для подтверждения оплаты просим отправить скрин оплаты";

        return $text;
    }

    static function ne_foto($lang)
    {
        if ($lang == 'uz') $text = "<b>Bu rasm emas, iltimos rasmni togri formatda jo'nating</b>";
        if ($lang == 'ru') $text = "<b>Это не фото, загрузите фото в правильном формате</b>";

        return $text ;
    }

    static function photo_success($lang)
    {
        if ($lang == 'uz') $text = "<b>Rasm yuklandi</b> \nSizning vakansiyangiz tasdiq uchun jo'natildi";
        if ($lang == 'ru') $text = "<b>Фотография загружена!</b> \nВаша вакансия передана на подтверждение";

        return $text ;
    }

    static function logo_success($lang)
    {
        if ($lang == 'uz') $text = "<b>Rasm yuklandi</b> \nKompaniya malumotlari saqlandi!";
        if ($lang == 'ru') $text = "<b>Фотография загружена!</b> \nДанные успешно сохранены!";

        return $text ;
    }

    static function no_vacancies($lang)
    {
        if ($lang == 'uz') $text = "Sizda qoshilgan vakansiyalar yo'q";
        if ($lang == 'ru') $text = "У вас нет добавленных вакансий";

        return $text ;
    }

    static function please_add_copmany($lang)
    {
        if ($lang == 'uz') $text = "Sizda kompaniya mavjud emas, vakansiya qo'shish ucnun iltimos kompaniya qo'shing!";
        if ($lang == 'ru') $text = "У вас нет компаний, пожалуйста сначала добавьте компанию!";

        return $text ;
    }

}
?>