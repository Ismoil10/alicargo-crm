<?


$roles = ['guest', 'admin'];
/*ROLES CLASS START*/
foreach ($roles as $v){
require ($_SERVER['DOCUMENT_ROOT'].'/bot/'.$v.'/'.$v.'_msg.php');	
require ($_SERVER['DOCUMENT_ROOT'].'/bot/'.$v.'/'.$v.'_kyb.php');	
}
/*ROLES CLASS END*/

function get_code($id) {
  
  if ($id >= 100) {
	$rs = $id;
  } else {
	$rs = sprintf('%03d', $id);
  }
  
  return "EX ".$rs;
}

/*BOT class start*/
class bot {	

static function request($method_name, $data){
//$token = "5458707059:AAFt8qCjOwKcngKps7zOpb2WDJmdIPPBkyg";
//$token = "5479672894:AAF99blPDAJHCQ5vkF9wn2Q8RHHeWUBbOMY";
//$token = "5726464433:AAFJk3HiWA3InsNtaiad0g6_eXT9veU-laU";
//$token = "5731853605:AAHw1J9uzWv9ZhVA_x944XRWHqUo_RqcI40";
//$token = "5766599313:AAHI7hO_0y19clu2colHcLvtruZv9I_2O4U";
$token = "5766599313:AAHmC_YLtN8L5WHBpDD1KwKsCQVbyr9AWfo";

$rs = file_get_contents("https://api.telegram.org/bot".$token."/".$method_name."?" . http_build_query($data));
return $rs;}

static function setWebhook(){
$data = ['url'=>$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']];	
bot::request('setWebhook',$data);}

static function forwardMessage($chat_id, $from_chat_id, $message_id){
$data = ['chat_id'=>$chat_id, 'from_chat_id'=>$from_chat_id,'message_id'=>$message_id];	
bot::request('forwardMessage',$data);}

static function sendMessage($chat_id, $message, $replyMarkup){
$data = ['chat_id'=>$chat_id, 'parse_mode'=>HTML,'disable_web_page_preview'=>true, 'reply_markup'=>$replyMarkup,'text'=>$message];	
bot::request('sendMessage',$data);}

static function sendPhoto($chat_id, $message, $replyMarkup, $photo_url){
$data = ['chat_id' => $chat_id, 'parse_mode'=>HTML, 'reply_markup'=>$replyMarkup,'caption'=>$message, 'photo'=> $photo_url];
bot::request('sendPhoto', $data);}

static function sendVideo($chat_id, $video_url){
$data = ['chat_id' => $chat_id, 'video'=> $video_url];
bot::request('sendVideo', $data);}

static function getFile($file_id){
$data = ['file_id'=>$file_id];	
$file = bot::request('getFile',$data);
$fd = json_decode($file, true);
$link = "https://api.telegram.org/file/bot5766599313:AAHmC_YLtN8L5WHBpDD1KwKsCQVbyr9AWfo/".$fd['result']['file_path'];
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

//$tmp_name = 'xtreme';
//$tmp_name = 'elite';
//$tmp_name = 'gentella';
//$tmp_name = 'arch';

$tmp_name = 'viho';
$link_type = 'multi';
//$link_type = 'single';

//$tmp_name = 'oreo';  
//$tmp_name = 'fonik';  

//if ($_GET['debug']=='on'){ini_set('display_errors',1);}else{ini_set('display_errors', 0);}

ini_set('display_errors', 0);?>

<?require $_SERVER["DOCUMENT_ROOT"].'/core/backend.php';$_SESSION['tmp_name'] = $tmp_name;
	//session_destroy();
?>

<? //echo "<pre>"; print_r($_SESSION); echo "</pre>";  ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/core/template_".$tmp_name."/header.php");?>


<script>
  /*
  $(document).ready(function (){
  $('[type=submit]').one('submit', function() {
       $(this).attr('disabled','disabled');
   });
 });
 */
</script>
<?ini_set('display_errors', 0);?>

<? //echo "<pre>"; print_r($_SESSION); echo "</pre>";  ?>
<?//echo "<pre>"; print_r(email::send('','test')); echo "</pre>";  ?>

 <?
// session_destroy();
 if (isset($_GET['page'])){$_SESSION['current_page'] = $_SERVER['REQUEST_URI'];
if ($_SESSION['back_url']==''){$_SESSION['back_url']=$_SESSION['current_page'];}}?>
<!-- CONTROLLER -->
<?foreach ($_SESSION['user']['access'] as $k=>$v){require_once 'modules/'.$tmp_name.'/'.$k.'/'.$k.'_controller.php';}?>
<?//require_once 'modules/'.$tmp_name.'/login/login_controller.php';?>  
<?if ($_GET['page']=='edit_profile' AND $_SESSION['user']['id']>0){$_SESSION['page_cc']='edit_profile';//Localredirect('index.php');
	}?> 
<!-- AUTH RULES -->
<?if ($_GET['logout']=='yes'){session_destroy();Localredirect ('index.php');}
if ($_SESSION['user']['id']==NULL){$_SESSION['page_cc']='login';}?>
<!-- LAYOUT MANAGER --> 
<?if ($_SESSION['back_url']!=$_SESSION['current_page']){$_SESSION['back_url']=$_SESSION['current_page'];}?>
<?foreach ($_POST as $k=>$v){$_POST[$k]= str_replace("'","\'",$v);}?>
<?if ($_SESSION['page_cc']=='login'){require_once 'modules/'.$tmp_name.'/login/login_view.php';}
if ($_SESSION['page_cc']=='edit_profile'){require_once 'modules/'.$tmp_name.'/edit_profile/edit_profile_view.php';}
foreach ($_SESSION['user']['access'] as $k=>$v){
if ($_SESSION['page_cc']==$k){require_once 'modules/'.$tmp_name.'/'.$k.'/'.$k.'_view.php';}}?>
<?require($_SERVER["DOCUMENT_ROOT"]."/core/template_".$tmp_name."/footer.php");?>     
