<?
class action {
	
	static function create_form($arr){
	$form_start = '<form action=\"'.$arr['action'].'\" method=\"POST\" id=\"'.$arr['id'].'\">';
	foreach ($arr['data'] as $k=>$v){
	$form_input = $form_input.'<input type=\"hidden\" name=\"'.$k.'\" value=\"'.$v.'\">';}	
	$form_end='</form>';
	echo '$(document).ready(function(){
	$("[name=ppf_form]").html("'.htmlspecialchars($form_start.$form_input.$form_end).'");});';}
	
	static function submit_form($arr){
	echo '$(document).ready(function (){
	$( "#'.$arr['id'].'" ).submit();});';}	
	
	static function create_ajax($arr){		
	echo '$(document).ready(function(){
	formData= new FormData();';
	foreach ($arr['data'] as $k=>$v){
	echo 'formData.append("'.$k.'","'.$v.'");';}	
	echo 'js_ajax_post("'.$arr['link'].'",formData).done(function (data){
	'.$arr['success'].'(data);});});';}
	
	static function modal_show($arr){
	if ($arr['success']==NULL) {$arr['success']='';}	
	echo'$(document).ready(function(){
	$("#'.$arr['id'].'").modal("show");
	'.$arr['success'].'();})';}
	
	static function button($arr){	
	if ($arr['js']!=NULL){echo $arr['js'].'()';}	
	if ($arr['modal']!=NULL) {action::modal_show($arr['modal']);}	
	if ($arr['form']!=NULL){
	action::create_form($arr['form']);
	action::submit_form($arr['form']);}	
	if ($arr['ajax']!=NULL){action::create_ajax($arr['ajax']);}}	
	
}
?>

<?
/*
$ajax_arr = [
'ajax'=>[
'link'=>'test_ajax.php',
'success'=>'success_test',
'data'=>['test'=>1,'abs'=>2]]];

$modal_arr = [
'modal'=>[
'id'=>'search_reg_wi',
'success'=>'modal_success']];

$form_arr = [
'form'=>[
'id'=>'my_form',
'action'=>'edit.php',
'data'=>['name1'=>33,'name2'=>53]]];

$js_function = ['js'=>'test_js_function'];

<a onclick='<?=action::button($form_arr)?>'>test</a>
*/
?>
