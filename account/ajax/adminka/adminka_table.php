<?require $_SERVER["DOCUMENT_ROOT"].'/core/backend.php';?>
<?ini_set('display_errors', 0);?>
<?$role_id=$_SESSION['user']['role_id'];?>
<?session_start();?>


<?
$admin_id = $_SESSION['admin_id'];
$dates = $_SESSION['year_month'];

$get_code = db::arr("SELECT * FROM new_tg_users WHERE ADMIN_ID = '$admin_id' AND ACTIVE = 1");
foreach($get_code as $v){
    if(!empty($v['USER_CODE'])){
        $codes[] = "'".$v['USER_CODE']."'";
    }
}
$sort = implode(",", $codes);
$str = explode(".", $dates);

$month = $str[0];
$year = $str[1];

$last_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$time_start = $year."-".$month."-01 00:00:00";
$time_end = $year."-".$month."-".$last_day." 23:59:59"; 

//$_SESSION['sklad_keyword'] = $keyword; onclick='action::button($item_edit)'
$keyword =  explode(" " , str_replace("'","",$_POST['keyword']));

									
$num = 10;
$_SESSION['user_page_num'] = $_POST['page_num'];
$page = $_SESSION['user_page_num'];
$start = $page * $num - $num;  

$_SESSION['saved_sql_tovar'] = "SELECT * FROM ac_zakaz WHERE $_SESSION[filter_order] 
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%')) AND
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%')) AND
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%')) ORDER BY ID DESC
LIMIT $start,10";


if (isset($_POST['search_code'])){

//echo 'test';

$sql_text = "
SELECT * FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE BETWEEN '$time_start' AND '$time_end') AND `CLIENT_CODE` LIKE '% $_POST[keyword]' ORDER BY ID DESC
LIMIT $start,10";

$data = db::arr("
SELECT * FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE BETWEEN '$time_start' AND '$time_end') AND `CLIENT_CODE` LIKE '% $_POST[keyword]' ORDER BY ID DESC
LIMIT $start,10");

 
$count = db::arr_s("
SELECT COUNT(*) AS COUNT FROM (
SELECT * FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE BETWEEN '$time_start' AND '$time_end') AND `CLIENT_CODE` LIKE '% $_POST[keyword]') as T"); 

} else {

$start_sql ="AND $_SESSION[filter_order] 
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%')) AND
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%')) AND
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%'))";    

$like = "$start_sql ORDER BY ID DESC
LIMIT $start,10";

$number = "$start_sql) as T";

if($dates != 0){

$date_sql = "SELECT * FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE BETWEEN '$time_start' AND '$time_end') $like";
$count_sql = "SELECT COUNT(*) AS COUNT FROM ( SELECT * FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE BETWEEN '$time_start' AND '$time_end') $number"; 

}else{
$now = "2024-05-08";

$date_sql = "SELECT * FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE >= '$now') $like";
$count_sql = "SELECT COUNT(*) AS COUNT FROM ( SELECT * FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE >= '$now') $number";

}
 	
	
$data = db::arr($date_sql);	

$count = db::arr_s($count_sql);
}
 
 
$count = $count['COUNT'];
$max = intval(($count - 1) / $num) + 1;	
if ($start+$num<=$count){$do = $start+$num;}else{$do = $count;}									
								
?>


<?$_SESSION['user_list_keyword'] = implode (" ",$keyword);?>

<?  //echo "<pre>"; print_r($data); echo "</pre>";  ?>
<? //echo "<pre>"; print_r($now); echo "</pre>";  ?>

<div class="table-responsive">
	<div id="basic-1_wrapper" class="dataTables_wrapper no-footer">
		<div class="dataTables_length" id="basic-1_length">
			<label>Show
				<select name="basic-1_length" aria-controls="basic-1" class="">
					<option value="10">10</option>
				</select> entries</label>
		</div>
		<div id="basic-1_filter" class="dataTables_filter">
			<label>
				<input type = "search" class="" placeholder="" aria-controls="basic-1" name="search_zakaz" value="<?=$_SESSION['user_list_keyword']?>">
				<?/*
				<button class="btn btn-primary btn-sm" type="button" onclick="show_user_content(1,'search')"><i class="icofont icofont-search-alt-1"></i> Поиск</button>
				*/?>
			</label> 
		</div>
		
<?php

$array_data = ["approved"=>"tasdiqlangan", "paid"=>"pul tolagan", "pay_reject"=>"pul otkaz", "new"=>"yangi foydalanuvchi", "draft"=>"tasdiqlashni kutmoqda", ""];


?>		
		<table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
						
			<thead>
				<tr>
					<th>ID</th>
				  	<th>KLIENT KOD</th>
					<th>DATA</th>
				  	<th>VAZNI</th>              
				  	<th>NARX</th>
					  
				</tr>
			</thead>
			<tbody>
			
			<?if($data != 'empty'):?>
			
		<?foreach($data as $v):?>	    
			<tr role="row" class = "odd">
				<td><?=$v['ID']?></td>
			  	<td><?=$v["CLIENT_CODE"]?></td>
				<td><?=$v['CREATED_DATE']?></td>
			  	<td><?=$v['WEIGHT']?></td>         
			  	<td><?=$v['PRICE']?></td>
				<?/*<td><?=$sale?></td>*/?>
			</tr>						  
						   
		<?endforeach;?>	

			<?else:?>
			
			<tr class="odd"><td valign="top" colspan="6" class="dataTables_empty">No matching records found</td></tr>
			
			<?endif;?>
            </tbody>
			
		
			
		</table>
		
		<div class="dataTables_info" id="basic-1_info" role="status" aria-live="polite">Showing <?=$start+1?> to <?=$do?> of <?=$count?> entries</div>
		
		<div class="dataTables_paginate paging_simple_numbers" id="basic-1_paginate">
		
		<?if ($page<5):?>
		
		<a class="paginate_button previous <?if ($page==1) {echo 'disabled';}?>" <?if ($page==1) {echo 'style = "display:none;"';}?> onclick="show_user_content('<?=$page-1?>')" aria-controls="basic-1" data-dt-idx="0" tabindex="0" id="basic-1_previous" data-bs-original-title="" title="">Previous</a>
		
		<span>
			<a class="paginate_button <?if ($page==1) {echo 'current';}?>" onclick="show_user_content('1')" aria-controls="basic-1" data-dt-idx="1" tabindex="0" data-bs-original-title="" title="">1</a>
			<?if (2<=$max):?>
			<a class="paginate_button <?if ($page==2) {echo 'current';}?>" onclick="show_user_content('2')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title="">2</a>
			<?endif;?>
			<?if (3<=$max):?>
			<a class="paginate_button <?if ($page==3) {echo 'current';}?>" onclick="show_user_content('3')" aria-controls="basic-1" data-dt-idx="3" tabindex="0" data-bs-original-title="" title="">3</a>
			<?endif;?>
			<?if (4<=$max):?>
			<a class="paginate_button <?if ($page==4) {echo 'current';}?>" onclick="show_user_content('4')" aria-controls="basic-1" data-dt-idx="4" tabindex="0" data-bs-original-title="" title="">4</a>
			<?endif;?>
			<?if (5<=$max):?>
			<a class="paginate_button <?if ($page==5) {echo 'current';}?>" onclick="show_user_content('5')" aria-controls="basic-1" data-dt-idx="5" tabindex="0" data-bs-original-title="" title="">5</a>
			<?endif;?>
			
			<?if ($max!=1 AND $max>5):?>
			<span class="ellipsis">…</span>
			<a class="paginate_button " onclick="show_user_content('<?=$max?>')" aria-controls="basic-1" data-dt-idx="6" tabindex="0" data-bs-original-title="" title=""><?=$max?></a>
			<?endif?>
			
			
		</span>
		
		<a class="paginate_button next <?if ($page==$max) {echo 'disabled';}?>" <?if ($page==$max) {echo 'style = "display:none;"';}?> onclick="show_user_content('<?=$page+1?>')" aria-controls="basic-1" data-dt-idx="7" tabindex="0" id="basic-1_next" data-bs-original-title="" title="">Next</a>
			
		<?elseif ($max>($page+3)):?>	
		
		<a class="paginate_button previous" onclick="show_user_content('<?=$page-1?>')" aria-controls="basic-1" data-dt-idx="0" tabindex="0" id="basic-1_previous" data-bs-original-title="" title="">Previous</a>

		<span>
			<a class="paginate_button <?if ($page==1) {echo 'current';}?>" onclick="show_user_content('1')" aria-controls="basic-1" data-dt-idx="1" tabindex="0" data-bs-original-title="" title="">1</a>
			<span class="ellipsis">…</span>
			<a class="paginate_button" onclick="show_user_content('<?=$page-1?>')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title=""><?=$page-1?></a>
			<a class="paginate_button" onclick="show_user_content('<?=$page?>')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title=""><?=$page?></a>
			<a class="paginate_button" onclick="show_user_content('<?=$page+1?>')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title=""><?=$page+1?></a>
			<span class="ellipsis">…</span>
			<a class="paginate_button" onclick="show_user_content('<?=$max?>')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title=""><?=$max?></a>
				
		</span>

		<a class="paginate_button next" onclick="show_user_content('<?=$page+1?>')" aria-controls="basic-1" data-dt-idx="7" tabindex="0" id="basic-1_next" data-bs-original-title="" title="">Next</a>

		<?else:?>
			
			<a class="paginate_button previous" onclick="show_user_content('<?=$page-1?>')" aria-controls="basic-1" data-dt-idx="0" tabindex="0" id="basic-1_previous" data-bs-original-title="" title="">Previous</a>
				<span>
					<a class="paginate_button" onclick="show_user_content('1')" aria-controls="basic-1" data-dt-idx="1" tabindex="0" data-bs-original-title="" title="">1</a>
					<span class="ellipsis">…</span>					
					<a class="paginate_button " onclick="show_user_content('<?=$max-4?>')" aria-controls="basic-1" data-dt-idx="2" tabindex="0" data-bs-original-title="" title=""><?=$max-4?></a>
					<a class="paginate_button <?if ($page==($max-3)) {echo 'current';}?>" onclick="show_user_content('<?=$max-3?>')" aria-controls="basic-1" data-dt-idx="3" tabindex="0" data-bs-original-title="" title=""><?=$max-3?></a>
					<a class="paginate_button <?if ($page==($max-2)) {echo 'current';}?>" onclick="show_user_content('<?=$max-2?>')" aria-controls="basic-1" data-dt-idx="4" tabindex="0" data-bs-original-title="" title=""><?=$max-2?></a>
					<a class="paginate_button <?if ($page==($max-1)) {echo 'current';}?>" onclick="show_user_content('<?=$max-1?>')" aria-controls="basic-1" data-dt-idx="5" tabindex="0" data-bs-original-title="" title=""><?=$max-1?></a>
					<a class="paginate_button <?if ($page==$max) {echo 'current';}?>" onclick="show_user_content('<?=$max?>')" aria-controls="basic-1" data-dt-idx="6" tabindex="0" data-bs-original-title="" title=""><?=$max?></a>
				</span>
			<a class="paginate_button next <?if ($page==$max) {echo 'disabled';}?>" <?if ($page==$max) {echo 'style = "display:none;"';}?> onclick="show_user_content('<?=$page+1?>')" aria-controls="basic-1" data-dt-idx="7" tabindex="0" id="basic-1_next" data-bs-original-title="" title="">Next</a>
		<?endif;?>
		
		</div>
		
		
	</div>
</div>

 
 
 
 

 
 
 

 
 