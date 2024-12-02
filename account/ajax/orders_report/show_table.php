<?require $_SERVER["DOCUMENT_ROOT"].'/core/backend.php';?>
<?ini_set('display_errors', 0);?>
<?$role_id=$_SESSION['user']['role_id'];?>
<?session_start();?>


<?


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
SELECT * FROM ac_zakaz WHERE `CLIENT_CODE` LIKE '% $_POST[keyword]' ORDER BY ID DESC
LIMIT $start,10";

$data = db::arr("
SELECT * FROM ac_zakaz WHERE `CLIENT_CODE` LIKE '% $_POST[keyword]' ORDER BY ID DESC
LIMIT $start,10");

 
$count = db::arr_s("
SELECT COUNT(*) AS COUNT FROM (
SELECT * FROM ac_zakaz WHERE `CLIENT_CODE` LIKE '% $_POST[keyword]') as T"); 

} else {
	

$data = db::arr("
SELECT * FROM ac_zakaz WHERE $_SESSION[filter_order] 
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%')) AND
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%')) AND
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%')) ORDER BY ID DESC
LIMIT $start,10");

 
$count = db::arr_s("
SELECT COUNT(*) AS COUNT FROM (
SELECT * FROM ac_zakaz WHERE $_SESSION[filter_order] 
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%')) AND
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%')) AND
(LOWER(ID) LIKE  LOWER('%$keyword[0]%') OR LOWER(CLIENT_CODE) LIKE  LOWER('%$keyword[0]%') OR LOWER(SHELF) LIKE  LOWER('%$keyword[0]%') OR LOWER(PRICE) LIKE  LOWER('%$keyword[0]%') OR LOWER(WEIGHT) LIKE  LOWER('%$keyword[0]%'))) as T"); 
	
	
	
	
}
 
 
$count = $count['COUNT'];
$max = intval(($count - 1) / $num) + 1;	
if ($start+$num<=$count){$do = $start+$num;}else{$do = $count;}									
								


?>


<?$_SESSION['user_list_keyword'] = implode (" ",$keyword);?>


<? //echo "<pre>"; print_r($_POST); echo "</pre>";  ?>
<? //echo "<pre>"; print_r($sql_text); echo "</pre>";  ?>

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
				<input type = "search" class="" placeholder="" aria-controls="basic-1" name="search_user" value="<?=$_SESSION['user_list_keyword']?>">
				<button class="btn btn-primary btn-sm" type="button" onclick="show_user_content(1,'search')"><i class="icofont icofont-search-alt-1"></i> Поиск</button>
			</label> 
		</div>
		
<?php

$array_data = ["approved"=>"tasdiqlangan", "paid"=>"pul tolagan", "pay_reject"=>"pul otkaz", "new"=>"yangi foydalanuvchi", "draft"=>"tasdiqlashni kutmoqda", ""];

$reys_names = db::arr_by_id("SELECT * FROM ac_reys");

?>		
		<table class="display dataTable no-footer" id="basic-1" role="grid" aria-describedby="basic-1_info">
						
			<thead>
				<tr>
					<th>ID</th>
				  	<th>KLIENT KOD</th>
					<th>REYS DATA</th>
					<th>REYS</th>
				  	<th>VAZNI</th>
				  	<th>POLKA</th>               
				  	<th>NARX</th>
					<th>HOLATI</th> 
				  	<?/*<th>QARZ</th>*/?>                            
				  	<th>HARAKAT</th> 
				</tr>
			</thead>
			<tbody>
			
			<?if($data != 'empty'):?>
			
		<?foreach($data as $v):?>	
			<? if($v['TAKEN'] != 1){ $sale = "SKLADDA"; }else{ $sale = "OLIB KETILGAN"; } ?>      
			<tr role="row" class = "odd">
				<td><?=$v['ID']?></td>
			  	<td><?=$v["CLIENT_CODE"]?></td>
				<td><?=$reys_names[$v['REYS_ID']]['DATE']?></td>
				<td><?=$reys_names[$v['REYS_ID']]['COMMENT']?></td>
			  	<td><?=$v['WEIGHT']?></td>     
			  	<td><?=$v['SHELF']?></td>     
			  	<td><?=$v['PRICE']?></td>
				<td><?=$sale?></td>
			<?/*<td><?=$v["DEBTS"]?></td>*/?>
			  	
			  	<td>
						<a href="./detail/<?=$v['ID']?>" style="padding: 8px 30px;" class="btn btn-primary"><span class="fa fa-chevron-right"></span></a>
						<?if($role_id==1):?>
						<button class="btn btn-primary" value="<?=htmlspecialchars(json_encode($v))?>" onclick="editModal(JSON.stringify(value))">
							<span class="fa fa-edit"></span>
						</button>
						<?endif;?>
						<button onclick="miniKassa('<?=$v['ID']?>')" class="btn btn-primary">
							<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign">
								<line x1="12" y1="1" x2="12" y2="23"></line>
								<path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
							</svg>
						</button>
			  	</td>
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

 
 
 
 

 
 
 

 
 