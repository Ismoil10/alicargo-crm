<?

/*sqlite class start*/
class sqlite {

static function arr($sql){
$db = new SQLite3('data.sqlite');
$q = $db->query(SQLite3::escapeString($sql));
while ($row = $q->fetchArray(SQLITE3_ASSOC)){$rs[] = $row;}
return $rs;}

static function arr_s($sql){
$db = new SQLite3('data.sqlite');
$rs =  $db->querySingle(SQLite3::escapeString($sql), true);
return $rs;}

static function query($sql){
$db = new SQLite3('data.sqlite');	
$rs['STATUS'] = $db->exec($sql);
$rs['ID'] =  $db->lastInsertRowID();
return $rs;}}
/*sqlite class end*/

/*BOT class start*/
class bot {	

static function request($method_name, $data){

$token = "7602831559:AAESW5uT4t7nt8Z_2vp2SmbjVegI194zCNQ";
$rs = file_get_contents("https://api.telegram.org/bot".$token."/".$method_name."?" . http_build_query($data));
return $rs;}

static function setWebhook(){
$data = ['url'=>$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']];	
bot::request('setWebhook',$data);}

static function forwardMessage($chat_id, $from_chat_id, $message_id){
$data = ['chat_id'=>$chat_id, 'from_chat_id'=>$from_chat_id,'message_id'=>$message_id];	
bot::request('forwardMessage',$data);}

static function sendMessage($chat_id, $message, $replyMarkup){
$data = ['chat_id'=>$chat_id, 'parse_mode'=>HTML,'disable_web_page_preview'=>false, 'reply_markup'=>$replyMarkup,'text'=>$message];	
bot::request('sendMessage',$data);}

static function sendPhoto($chat_id, $message, $replyMarkup, $photo_url){
$data = ['chat_id' => $chat_id, 'parse_mode'=>HTML, 'reply_markup'=>$replyMarkup,'caption'=>$message, 'photo'=> $photo_url];
bot::request('sendPhoto', $data);}

static function sendVideo($chat_id, $video_url){
$data = ['chat_id' => $chat_id, 'video'=> $video_url];
bot::request('sendVideo', $data);}

static function sendVideoCaption($chat_id, $video_url, $message){
  $data = ['chat_id' => $chat_id, 'video'=> $video_url, 'caption'=>$message];
  bot::request('sendVideo', $data);}
/*
static function sendVideo($chat_id, $video_url, $text){
$data = ['chat_id' => $chat_id, 'video'=> $video_url, 'caption'=>$text];
bot::request('sendVideo', $data);}
*/
static function sendDocument($chat_id, $file_id){
$data = ['chat_id' => $chat_id, 'document'=> $file_id];
bot::request('sendDocument', $data);}

static function sendDocumentCaption($chat_id, $file_id, $message){
  $data = ['chat_id' => $chat_id, 'document'=> $file_id, 'caption'=> $message];
  bot::request('sendDocument', $data);}

static function forwardMessages($chat_id, $from_chat_id, $message_id){
  $data = ['chat_id'=>$chat_id, 'from_chat_id'=>$from_chat_id,'message_ids'=>$message_id];	
  bot::request('forwardMessages',$data);}

static function getFile($file_id){
$data = ['file_id'=>$file_id];	
$file = bot::request('getFile',$data);
$fd = json_decode($file, true);
$link = "https://api.telegram.org/file/bot7602831559:AAESW5uT4t7nt8Z_2vp2SmbjVegI194zCNQ/".$fd['result']['file_path'];
return $link;	
}

static function getHighQuality($q_array) {
	$reverse = array_reverse($q_array);
	return $reverse[0];
}

static function deleteMessage($chat_id, $message_id){
$data = ['chat_id'=>$chat_id, 'message_id'=>$message_id];	
bot::request('deleteMessage',$data);	
}

static function answerInlineQuery($inline_query_id, $results){
$data = ['inline_query_id'=>$inline_query_id,'results'=>json_encode($results)];	
bot::request('answerInlineQuery',$data);}
}
/*BOT class end*/

/*ROLES CLASS START*/
foreach ($roles as $v){
require ($_SERVER['DOCUMENT_ROOT'].'/bot_test/'.$v.'/'.$v.'_msg.php');	
require ($_SERVER['DOCUMENT_ROOT'].'/bot_test/'.$v.'/'.$v.'_kyb.php');	
}
/*ROLES CLASS END*/
?>

<?
class keyboard{
static function main_menu($role){
if ($role=='guest'){$rs = guest_kyb::main_menu();}	
if ($role=='admin'){$rs = admin_kyb::main_menu();}	
return $rs;
}
}

class message{
static function welcome($role){
if ($role=='guest'){$rs = guest_msg::welcome();}	
if ($role=='admin'){$rs = admin_msg::welcome();}	
return $rs;
}
}


function event_code($event_code, $chat_id) {$update_status = db::query("UPDATE `tg_users` SET `EVENT_CODE` = '$event_code' WHERE `CHAT_ID` = '$chat_id'");}

function get_code($id) {
  
  if ($id >= 100) {
    $rs = $id;
  } else {
    $rs = sprintf('%03d', $id);
  }
  
  return "EX ".$rs;
}



function save_file($file_id) {

   $api = "7602831559:AAESW5uT4t7nt8Z_2vp2SmbjVegI194zCNQ";
           
   $data = json_decode(file_get_contents("https://api.telegram.org/bot".$api."/getFile?file_id=".$file_id),true);    
  
   if ($data["ok"]==1){     
   $path = $data['result']['file_path']; 
   $ext_arr = explode('.',$data['result']['file_path']);   

   $ext = 'jpg';  
  
  $q = db::query("INSERT INTO files (FORMAT) VALUES ('$ext');");
  $file_name = md5($q['ID']).'.'.$ext;  

  $url = '/files/'.$file_name;
  $full_url = $_SERVER['DOCUMENT_ROOT'].'/files/'.$file_name;
  $upd = db::query("UPDATE files SET URL='$url' WHERE ID='$q[ID]'");

  $tg_url = 'https://api.telegram.org/file/bot'.$api.'/'.$path;
   
  $a = file_put_contents($full_url, file_get_contents($tg_url));
  $upd = db::query("UPDATE files SET URL='$url' WHERE ID='$q[ID]'");}    
  $rs['url'] = $url;  
  $rs['a'] = $a;  
  $rs['tg_url'] = $tg_url;  
  $rs['url'] = $url;  
  return $rs;
  
  }


function post_query($url,$arr){

    $url = 'https://'.$url;
    $data = $arr;

// use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context  = stream_context_create($options);
    $rs = file_get_contents($url, false, $context);
    if ($rs === FALSE) { $rs = 'no'; }

    return $rs;
}


function getChannelData($data)
{
	if(isset($data['my_chat_member']))
	{
		$channel_name = $data['my_chat_member']['chat']['title'];
		$channel_type= $data['my_chat_member']['chat']['type'];
		$channel_id = $data['my_chat_member']['chat']['id'];
		
		$member_count = json_decode(bot::request('getChatMemberCount', ['chat_id' => $channel_id]), true)['result'];
		$admin_list = json_decode(bot::request('getChatAdministrators', ['chat_id' => $channel_id]), true)['result'];
		
		foreach($admin_list as $v){$admins_array[] = $v['user'];}
		
		$admin_json = json_encode($admins_array);
		
		foreach  (db::arr("SELECT * FROM `job_category` WHERE ACTIVE = 1") as $v){$category[$v['ID']]=0;}
		
		$settings_json = json_encode($category);
		
		if(isset($member_count))
		{
			$q['ins'] = db::query("INSERT INTO `telegram_channels` (`NAME`, `TYPE`, `MEMBER_COUNT`, `ADMIN_JSON`, `SETTINGS_JSON`, `TG_ID`, `ACTIVE`) 
			VALUES ('$channel_name', '$channel_type', '$member_count', '$admin_json', '$settings_json', '$channel_id', '1')");
		}
		
		else
		{
			$q['del'] = db::query("DELETE FROM `telegram_channels` WHERE `TG_ID` = '$channel_id'");
		}
		
	}
}




?>