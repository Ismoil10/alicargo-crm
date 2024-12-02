<?
require ($_SERVER['DOCUMENT_ROOT'].'/bot_test/db.php');
require ($_SERVER['DOCUMENT_ROOT'].'/bot_test/class.php');

//bot::sendMessage('277498053', $_POST['channel_id'], null);

if($_POST['sendMessage'] == "ok"){
	$user = db::arr_s("SELECT CHAT_ID, ISM_FAMILIYA, ID, LANG FROM `tg_users` WHERE CODE='$_POST[userid]'");
	$data = db::arr("SELECT * FROM `ac_item` WHERE KAROBKA_ID='$_POST[karobka]' AND CLIENT_CODE='$_POST[userid]'");
	$msg = '';
	if($user != "empty" and $data != "empty"){
		foreach($data as $v){
			//$msg = $msg."- $v[NAME] <b>x $v[AMOUNT]</b> \n";
			$msg = $msg."- <b> $v[TRACK_CODE]</b> \n";
		}
		
		if ($user['LANG']=='uz') {
			$full_message = "Hozirgi paytda bu bot demo rejimda ishlamoqda. \n<b>Agar pastdagi tovarlar sizniki bo`lmasa bizga xabar bering.</b>\n
			\nXurmatli, <b>$user[ISM_FAMILIYA]</b> \nXitoy skladiga quydagi trek kodli buyurtmalariz keldi: \n$msg\n";
		}
		
		if ($user['LANG']=='ru') {
			$full_message = "На данный момент бот работает в режиме дэмо.\n<b>Если последующие товары вам не принадлежат, пожалуйста, сообщите нам.</b>\n
			\nДорогой, <b>$user[ISM_FAMILIYA]</b> \nВаши заказы со следующими трек кодами прибыли в Китайский склад: \n$msg\n";
		}
		
	}else{
		$full_message = "";
	}
	bot::sendMessage($user['CHAT_ID'], $full_message, null);
}

/*  JOB NOTIFICATION TO ADMIN */

if($_POST['status'] == 'notification_to_admin') {

    $gl_sys_users = db::arr("SELECT * FROM `gl_sys_users` WHERE `ROLE_ID` = '1' AND STATUS NOT IN ('0')");

    foreach($gl_sys_users as $v) {

        $admin_phone = preg_replace("/[^0-9]/", "", "$v[PHONE]");

        $admin_tg = db::arr_s("SELECT CHAT_ID FROM `tg_users` WHERE PHONE LIKE '%$admin_phone%'");

        $admin_chat_ids[] = $admin_tg['CHAT_ID'];

    }

    $job_data = db::arr_s("SELECT jl.*, jp.NAME_RU PLAN FROM `job_list` jl LEFT JOIN `job_plan` jp ON jl.PLAN_ID = jp.ID WHERE jl.ID = '$_POST[job_id]'");

    if($_POST['plan_type'] == 'free') {

        $msg = "<b>Вакансия ждет вашего подтверждения!</b>

$job_data[TITLE]

<i>Зарплата:</i>
$job_data[SALARY]   

<i>Описание:</i>     
$job_data[BODY]

<i>Контактное лицо:</i>         
$job_data[CONTACT_NAME] - $job_data[CONTACT_PHONE]

<i>ID вакансии: </i> $job_data[ID]
<i>Тариф: </i> $job_data[PLAN]";

        foreach($admin_chat_ids as $v) bot::sendMessage($v, $msg, null);


    }

    if($_POST['plan_type'] == 'paid') {


        $msg = "<b>Вакансия ждет вашего подтверждения!</b>

$job_data[TITLE]

<i>Зарплата:</i>
$job_data[SALARY]   

<i>Описание:</i>     
$job_data[BODY]

<i>Контактное лицо:</i>         
$job_data[CONTACT_NAME] - $job_data[CONTACT_PHONE]

<i>ID вакансии: </i> $job_data[ID]
<i>Тариф: </i> $job_data[PLAN]";

        foreach($admin_chat_ids as $v) bot::sendPhoto($v, $msg, null, $_POST['url']);


    }




}



/*  STATUS NOTIFICATION TO USER  */

if($_POST['status'] == 'notification_to_user')
{
	
	$job_data = db::arr_s("SELECT jl.*, zl.REASON FROM `job_list` jl LEFT JOIN `zapros_list` zl ON jl.ID = zl.JOB_LIST_ID WHERE jl.ID = '$_POST[job_id]'");
	
	if($_POST['job_status'] == 'active'){
		
$mess = "<b>Вакансия подтверждена! </b>
		
$job_data[TITLE]
		
<i>Статус: </i> Подтвержден";
	}

	
	if($_POST['job_status'] == 'rejected'){
		
$mess = "<b>Вакансия отказано! </b>
		
$job_data[TITLE]
		
<i>Статус: </i> Отказан
		
<i>Причина: </i> $job_data[REASON]";
		
	}

	
	bot::sendMessage($job_data['CHAT_ID'], $mess, null);
	
}





/*  SROKI OTGAN VAKANSIYALARGA UVEDOMLENIYA JONATISH  */

if($_POST['status'] == 'job_deactivation')
{
	
	$job_data = db::arr_s("SELECT jl.TITLE, jl.CHAT_ID, tg.LANG FROM `job_list` jl LEFT JOIN `tg_users` tg ON tg.CHAT_ID = jl.CHAT_ID WHERE jl.ID = '$_POST[job_id]'");
	
	if($job_data['LANG'] == 'ru')
	{
$mess = "<b>Вакансия деактевирована</b>

$job_data[TITLE]

Вы можете заново активировать в разделе Мои вакансии";
	}
	
	if($job_data['LANG'] == 'uz')
	{
$mess = "<b>Vakansiya o'chirildi</b>

$job_data[TITLE]

Mening vakansiyalarim bo‘limida qayta faollashtirishingiz mumkin";
	}
	
	bot::sendMessage($job_data['CHAT_ID'], $mess, null);
	
	
}


/* TARIF SROKI OTGANIGA UVEDOMLENIYA  */

if($_POST['status'] == 'job_change_plan')
{
	$job_data = db::arr_s("SELECT jl.TITLE, jl.CHAT_ID, tg.LANG FROM `job_list` jl LEFT JOIN `tg_users` tg ON tg.CHAT_ID = jl.CHAT_ID WHERE jl.ID = '$_POST[job_id]'");
	
	if($job_data['LANG'] == 'ru')
	{
$mess = "<b>Срок по выбранному тарифу истек</b>

$job_data[TITLE]

<i>* Срок по выбранному тарифу истек, и был изменен на бесплатный, Вы можете изменить тариф в разделе Мои вакансии</i>";
	}
	
	if($job_data['LANG'] == 'uz')
	{
$mess = "<b>Tanlangan tarifning amal qilish muddati tugadi</b>

$job_data[TITLE]

<i>* Tanlangan tarifning muddati tugadi va bepul tarifiga o'zgartirildi, Siz tarifni Mening vakansiyalarim bo'limida o'zgartirishingiz mumkin. </i>";
	}
	
	bot::sendMessage($job_data['CHAT_ID'], $mess, null);
}



/* KANAL VA GRUGLARGA VAKANSIYA JO'NATISH */

if($_POST['status'] == 'job_posts')
{
	$cat_ids = $_POST['cat_ids'];
	$job_quantity = $_POST['job_quantity'];
	$channel_id = $_POST['channel_id'];
	
	$job_list = db::arr_s("SELECT * FROM `job_list` WHERE ACTIVE = '1' AND CAT_ID IN ($cat_ids) AND ID NOT IN 
	(SELECT JOB_LIST_ID FROM tg_rassilka WHERE CHANNEL_ID = '$channel_id') ORDER BY ID DESC, PLAN_ID LIMIT $job_quantity");
	

$job_list['BODY'] = preg_replace('/\S*([*])\S*/', '', trim($job_list['BODY']));	
		
$mess = "$job_list[TITLE]

<i>Зарплата:</i>
$job_list[SALARY]   

<i>Описание:</i>     
$job_list[BODY]

<i>Контактное лицо:</i>         
$job_list[CONTACT_NAME] - $job_list[CONTACT_PHONE]";

if ($job_list!='empty'){
bot::sendMessage($channel_id, $mess, null);



$now = date("Y-m-d H:i:s");

$q['ins'] = db::query("INSERT INTO tg_rassilka (CREATED_DATE, CHANNEL_ID, JOB_LIST_ID) VALUES ('$now', '$channel_id', $job_list[ID])");
		
	}
}

?>