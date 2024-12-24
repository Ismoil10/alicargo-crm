<?php
/*db class start*/
class db {
	
static function conn (){
$conn = new mysqli('localhost','<username>','<password>','<database>');
$conn->set_charset('utf8mb4');
if ($conn->connect_error) {die('Connection faield:'.$conn->connect_error);}
else{$rs = $conn;}
return $rs;}

static function query($sql) {
$conn = db::conn();
if ($conn->query($sql)===TRUE) {$rs['stat']='success';$rs['ID']=$conn->insert_id;}else{$rs=$conn->error;}
return $rs;}

static function arr($sql) {
$conn = db::conn();
$q = $conn->query($sql);
if ($q===FALSE) {$rs=$conn->error;}
if ($q->num_rows>0) {while ($row = $q->fetch_assoc()) {$rs[] = $row;}} 
if ($q->num_rows==0) {$rs='empty';}
return $rs;}

static function arr_s($sql) {
$conn = db::conn();
$q = $conn->query($sql);
if ($q===FALSE) {$rs=$conn->error;}
if ($q->num_rows>0) {while ($row = $q->fetch_assoc()) {$rs = $row;}}
if ($q->num_rows==0) {$rs='empty';}
return $rs;}

static function arr_by_id($sql) {
$conn = db::conn();
$q = $conn->query($sql);
if ($q===FALSE) {$rs=$conn->error;}
if ($q->num_rows>0) {while ($row = $q->fetch_assoc()) {$rs[$row['ID']] = $row;}}
if ($q->num_rows==0) {$rs='empty';}
return $rs;}	
}
/*db class end*/
?>


<?date_default_timezone_set("Asia/Tashkent");?>





<?
/*LOG start*/
$text = ' '.date("Y-m-d H:i:s");
$filename = "log.txt";
$fh = fopen($filename, "a");
fwrite($fh, $text);
fclose($fh);
//bot::sendMessage($output['message']['chat']['id'], json_encode($output),null);
/*LOG end*/
?>

<?php

$now = date("Y-m-d H:i:s");

function isJson($str){
    json_decode($str);
    return (json_last_error() == JSON_ERROR_NONE);
}

foreach (db::arr("SELECT * FROM `message_log` WHERE `STATUS`=0  AND `TRY`< 4 LIMIT 50") as $v) {

try
{ 

$rassilka = db::arr_s("SELECT * FROM `tg_rassilka` WHERE ID = '$v[RASSILKA_ID]'");

$get_doc = json_decode($rassilka['FILE_URL'], true);

//$token = "5766599313:AAHI7hO_0y19clu2colHcLvtruZv9I_2O4U";
$token = "<telegram bot token>";

$api_url = "https://api.telegram.org/bot" . $token . "/sendPhoto?";
$video_url = "https://api.telegram.org/bot" . $token . "/sendVideo?";
$message_url = "https://api.telegram.org/bot" . $token . "/sendMessage?";
$forward_url = "https://api.telegram.org/bot" . $token . "/forwardMessage?";
//$media_group = "https://api.telegram.org/bot" . $token . "/sendMediaGroup?";


$text = urlencode($rassilka['TEXT']);

//echo '<pre>'; print_r($get_photo); echo '</pre>';

if(isset($rassilka['FILE_URL'])){
if($get_doc['file'] != null){

$send_message = $api_url."chat_id=".$v['CHAT_ID']."&photo=https://alicargo.senet.uz".$get_doc['file']."&caption=".$text;

}else{

$send_message = $message_url."chat_id=".$v['CHAT_ID']."&text=".$text;	

}
}else{

$check = db::arr_s("SELECT * FROM `message_log` WHERE `CHAT_ID` = '$v[CHAT_ID]' AND `RASSILKA_ID` = '$v[RASSILKA_ID]'");

//if ($check =='empty'){	
$send_message = $forward_url."chat_id=".$v['CHAT_ID']."&from_chat_id=".$rassilka['FROM_CHAT_ID']."&message_id=".$rassilka['MESSAGE_ID'];//}

}

$q = file_get_contents($send_message);

$get_id = json_decode($q, true);

$message_id = $get_id['result']['message_id'];	
$ok = $get_id['ok'];

//$try += $v['TRY'];
$try = $v['TRY'] + 1;

if ($ok == true){$status = 1;}else{$status = 0;}

db::query("UPDATE `message_log` SET
`SEND_DATE` = '$now', 
`MESSAGE_ID` = '$message_id', 
`TRY` = '$try', 
`STATUS` = '$status' 
WHERE ID = '$v[ID]'");

 
}
catch (\Exception $e) 
{
	 "bot Y send me the probable problem in my code....";
}
catch (Throwable $e)
{
	   "bot Y send me the probable problem in telegram such 
	   as blocking ,..";
}


}

foreach (db::arr("SELECT * FROM `message_log` WHERE `STATUS`=2") as $v) {

try
{ 

$token = "telegram bot token";

$api_url = "https://api.telegram.org/bot" . $token . "/deleteMessage?";

$send_message = $api_url."chat_id=".$v['CHAT_ID']."&message_id=".$v['MESSAGE_ID'];

$q = file_get_contents($send_message);

$arr = json_decode($q, true);
//echo '<pre>'; print_r($arr); echo '</pre>';

db::query("DELETE FROM `message_log` WHERE ID = '$v[ID]'");

}
catch (\Exception $e) 
{
	 "bot Y send me the probable problem in my code....";
}
catch (Throwable $e)
{
	   "bot Y send me the probable problem in telegram such 
	   as blocking ,..";
}

}

?>

<?

$url_link = db::arr_s("SELECT * FROM url_link");

if (date('H:i')=='04:00') {
	
foreach (db::arr("SELECT * FROM `telegram_channels` WHERE ACTIVE = 1") as $v){

unset($times);
unset($hours);
	
foreach (json_decode($v['SETTINGS_JSON'],TRUE) as $k2=>$v2){

unset($times);


if ($v2==1){

foreach (range(1,$v['JOB_QUANTITY']) as $v3){
	
$h = rand(8, 20);
$m = rand(1, 59);

if ($h<10) {$h = '0'.$h;}
if ($m<10) {$m = '0'.$m;}
$times[] = $h.':'.$m;

}

$hours[$k2] = $times;
	
	
}	
}

$rs = json_encode($hours);
$q[] = db::query("UPDATE `telegram_channels` SET `HOURS`='$rs' WHERE ID='$v[ID]'");
	
}	
}


// echo "<pre>"; print_r($rs); echo "</pre>";  
// echo "<pre>"; print_r($q); echo "</pre>";  


$now = date('H:i');
$check = db::arr("SELECT * FROM `telegram_channels` WHERE HOURS LIKE '%$now%'");

if ($check!='empty'){

foreach ($check as $v){

foreach (json_decode($v['HOURS'], true) as $k2=>$v2){

if (in_array($now, $v2)) {
	
$q['post'] = post_query($url_link['URL'].'/bot/api.php', ['status' => 'job_posts', 'cat_ids' => $k2, 'job_quantity' => 1, 'channel_id' => $v['TG_ID']]);
	
}	
	
}
	
	
}	
}


if (date('H:i')=='05:00') {

$today = date("Y-m-d 00:00:00");
//$today = date("2022-09-20 00:00:00");

/*  vakansiyalarni sroki otganlarni statusini ozgartirish  va userga uvedomleniya jo'natish */

$job_list = db::arr("SELECT * FROM `job_list` WHERE `EXPIRED_DATE` < '$today' AND `EXPIRED_DATE` != '0000-00-00 00:00:00' AND PLAN_ID IN (0,1) AND STATUS = 'active'");

if ($job_list != 'empty') {
	foreach ($job_list as $v){
		$q['post'] = post_query($url_link['URL'].'/bot/api.php',['job_id'=>$v['ID'], 'status'=>'job_deactivation']); 
		$q['upd'] = db::query("UPDATE `job_list` SET STATUS = 'not_active', ACTIVE = '0' WHERE ID = '$v[ID]'");
	}
}



/*  top tarifdagi vakansiyalarni sroki otganlarini bepul tarifga ozgartirish va userga uvedomleniya jo'natish  */

$top_job_list = db::arr("SELECT * FROM `job_list` WHERE `EXPIRED_DATE` < '$today' AND `EXPIRED_DATE` != '0000-00-00 00:00:00' AND PLAN_ID NOT IN (0,1) AND STATUS = 'active'");

if ($top_job_list != 'empty') {
	foreach ($top_job_list as $v){
		
		$activated_date = date('Y-m-d H:i:s');
		$expired_date = date('Y-m-d H:i:s', strtotime($activated_date. ' + 1 months'));
			
		$q['post'] = post_query($url_link['URL'].'/bot/api.php',['job_id'=>$v['ID'], 'status'=>'job_change_plan']); 
		$q['upd'] = db::query("UPDATE `job_list` SET PLAN_ID = '1', ACIVATED_DATE = '$activated_date', EXPIRED_DATE = '$expired_date' WHERE ID = '$v[ID]'");
	}
}

}

exit();


?>




<?

//ini_set('display_erros',1);

/*
$url_link = db::arr_s("SELECT * FROM url_link");
$q[] = post_query($url_link['URL'].'/bot/api.php',['kimga'=>$chat_id,'xabar_matni'=>$text,'status'=>'qattasan']); */


//echo '<pre>'; print_r($inactive_users); echo '</pre>';
//echo '<pre>'; print_r($users_promo_codes); echo '</pre>';
//echo '<pre>'; print_r($today ); echo '</pre>';
?>
