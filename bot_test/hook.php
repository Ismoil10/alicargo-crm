<?
date_default_timezone_set("Asia/Tashkent");

ini_set('display_errors',1);
$roles = ['guest', 'admin', 'pochta'];
require ($_SERVER['DOCUMENT_ROOT'].'/bot_test/db.php');
require ($_SERVER['DOCUMENT_ROOT'].'/bot_test/class.php');	
require $_SERVER["DOCUMENT_ROOT"]."/report/report_pdf/generate_pdf_func.php";
require $_SERVER["DOCUMENT_ROOT"]."/report/report_pdf/get_track_codes.php";

bot::setWebhook();

$output = json_decode(file_get_contents('php://input'), TRUE);

/*LOG start*/
if ($output['message']['chat']['id'] == '1586146743') {
$text = json_encode($output);
$filename = "log7.txt";
$fh = fopen($filename, "a+");
fwrite($fh, $text);
fclose($fh);
//bot::sendMessage($output['message']['chat']['id'], json_encode($output),null);
/*LOG end*/
}
//if(isset($output['my_chat_member'])) getChannelData($output);

/*message handler start*/
/*$messageIds = [];


if (isset($output['message'])){
    $msg_id = $output['message']['message_id'];
    $messageIds[] = $msg_id;
}*/



if (isset($output['message'])){
$chat_id = $output['message']['chat']['id'];
$message = $output['message']['text'];
$message = str_replace("'", "`", $message);
$file_id = end($output['message']['photo'])['file_id'];

$latitude = $output['message']['location']['latitude'];
$longitude = $output['message']['location']['longitude'];
$from_id = $output['message']['from']['id'];
$msg_id = $output['message']['message_id'];
$video = $output['message']['video']['file_id'];
$doc = $output['message']['document']['file_id'];
$caption = $output['message']['caption'];

if (db::arr_s("SELECT ID FROM `tg_users` WHERE CHAT_ID = '$chat_id'")=='empty'){
$t_name = $output['message']['from']['first_name'].' '.$output['message']['from']['last_name'];
$user_name = $output['message']['from']['username'];

$t_name = str_replace("'", "`", $t_name);

$sql = "INSERT INTO `tg_users` (
`CREATE_DATE`,
`USERNAME`, 
`T_NAME`, 
`EVENT_CODE`, 
`ROLE`, 
`CHAT_ID`,
`LANG`,
`STATUS`)VALUES (
now(),
'$user_name', 
'$t_name',  
'guest_menu',
'guest',
'$chat_id',
'uz',
'new')";
$ins = db::query($sql);}
$tg_users = db::arr_s("SELECT * FROM `tg_users` WHERE CHAT_ID = '$chat_id'");
require ($_SERVER['DOCUMENT_ROOT'].'/bot_test/'.$tg_users['ROLE'].'/'.$tg_users['ROLE'].'_qy_message.php');}
/*message handler end*/

/*callback handler start*/
if (isset($output['callback_query'])){
$callback_query = $output['callback_query'];
$data = $callback_query['data'];
$callback_code = $output['callback_query']['data'];
$message_id = $output['callback_query']['message']['message_id'];
$chat_id_in = $callback_query['message']['chat']['id'];
$tg_users = db::arr_s("SELECT * FROM `tg_users` WHERE CHAT_ID = '$chat_id_in'");

require ($_SERVER['DOCUMENT_ROOT'].'/bot_test/'.$tg_users['ROLE'].'/'.$tg_users['ROLE'].'_qy_callback.php');}
/*callback handler end*/

/*inline handler start*/
if (isset($output['inline_query'])){	
$inline_query_id = $output['inline_query']['id'];
$inline_query_chat_id = $output['inline_query']['from']['id'];
$inline_query_text = $output['inline_query']['query'];
$chat_id_in_qy = $output['inline_query']['from']['id'];
$tg_users = db::arr_s("SELECT * FROM `tg_users` WHERE CHAT_ID = '$chat_id_in_qy'");
require ($_SERVER['DOCUMENT_ROOT'].'/bot_test/'.$tg_users['ROLE'].'/'.$tg_users['ROLE'].'_qy_inline.php');
}
/*inline handler end*/
?>