<?
  if(strlen($_SESSION["filter_pochta"])>0){
    /*
	$sql = db::arr("SELECT az.*, tg.ADRES, tg.PHONE, tg.ISM_FAMILIYA FROM `ac_zakaz` AS az 
	INNER JOIN `tg_users` AS tg ON tg.CODE=az.CLIENT_CODE 
	WHERE az.DELIVERY_TYPE='pochta' 
	AND az.PAID=1 
	$_SESSION[filter_pochta] 
	AND az.ID<10 ORDER BY az.LAST_MODIFIED DESC");
	*/
	
	/*
	tg.ADRES, 
	tg.PHONE, 
	tg.ISM_FAMILIYA
	*/
	
	$sql = db::arr("SELECT az.*
	FROM `ac_zakaz` AS az 	
	WHERE az.DELIVERY_TYPE='pochta' 
	AND az.PAID=1
  AND az.TAKEN =1	
	AND az.ID<30
	$_SESSION[filter_pochta] 
	ORDER BY az.LAST_MODIFIED DESC");
	
	$sql_text = "SELECT az.*
	FROM `ac_zakaz` AS az 	
	WHERE az.DELIVERY_TYPE='pochta' 
	AND az.PAID=1 	
	AND az.ID<30
	$_SESSION[filter_pochta] 
	ORDER BY az.LAST_MODIFIED DESC";
	
  }else{
	  
	/*

	*/  
	  
	$sql_text = "SELECT az.*,	tg.ADRES, 
	tg.PHONE, 
	tg.ISM_FAMILIYA FROM 	
	`ac_zakaz` AS az 
	INNER JOIN `tg_users` AS tg ON tg.CODE=az.CLIENT_CODE 
	WHERE az.DELIVERY_TYPE='pochta' 
	AND az.PAID=1 AND az.PICKUP_DATE IS NULL 
	AND az.POCHTA_PHOTO IS NULL ORDER BY az.LAST_MODIFIED DESC"; 
	
    $sql = db::arr("SELECT az.*
	FROM `ac_zakaz` AS az 
	WHERE az.DELIVERY_TYPE='pochta' 
	AND az.PAID=1
    AND az.TAKEN =0 
	AND az.PICKUP_DATE IS NULL 
	AND az.POCHTA_PHOTO IS NULL 
	ORDER BY az.LAST_MODIFIED DESC");
	  
	/*
	,
	tg.ADRES, 
	tg.PHONE, 
	tg.ISM_FAMILIYA 
	*/  
	   
	   
	/*   
    $sql = db::arr("SELECT az.*
	FROM `ac_zakaz` AS az 
	WHERE az.DELIVERY_TYPE='pochta' 
	AND az.PAID=1 
	AND az.PICKUP_DATE IS NULL 
	AND az.POCHTA_PHOTO IS NULL 
	ORDER BY az.LAST_MODIFIED DESC");
	*/
	
  }
  $cart = db::arr_s("SELECT COUNT(ID) AS AMOUNT FROM `ac_zakaz` WHERE CART=1 AND DELIVERY_TYPE='pochta' AND PAID=1 AND POCHTA_PHOTO IS NULL");
  
?>

<?
// 10 tali zagruzka qoyish kerak ;
?>


<?
if (isset($_POST['print_submit'])):?>

<?
/*
[print_sana] => 2024-05-13
    [ex] => EX 8513
    [id] => 40037
    [ism] => Shokirova Umida Sultonxója qizi
    [tel] => 998933770344
    [manzil] => Toshkent viloyati sergili tumani qumariq maxallasi obirahmat kôchasi 30-uy
    [kg] => 0.3
    [tovar_soni] => 124
    [print_submit] => 	
*/	
?>	

<?$_POST['print_sana'] = date_var($_POST['print_sana'],'d.m.Y');?>

<script type="text/javascript">
window.open('http://localhost/index.php?data=<?=base64_encode(json_encode($_POST))?>');
  //window.close() ;

</script>
<?unset($_POST);?>

<?endif?>



<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-sm-6">
        <h3>ALICARGO</h3>
        <ol class="breadcrumb">
          <li class="breadcrumb-item active"><a href="/account/reys/list">Pochtalar</a></li>
        </ol>
      </div>
      <div class="col-sm-6">
        <!-- Bookmark Start-->
        <div class="bookmark">
          <ul>
            <li style="padding-right: 40px"><a href="https://t.me/alicargo_bot"><i class="bookmark-search" data-feather="at-sign"></i>alicargo_bot</a>
            </li>
          </ul>
        </div>
        <!-- Bookmark Ends-->
      </div>
    </div>
  </div>
</div>
<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class = "row">
            <div class = "col-lg-6 col-md-6 col-sm-6 col-12"> 
              <h5 class = "d-inline-block">Pochtalar Ro'yhati</h5>
            </div>
            <div class = "col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
              <span class = "d-inline-block">    
                <? /*  
                <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-bs-target="#cartModal"><i class="fa fa-shopping-cart"></i> Karzina (<?=$cart["AMOUNT"]?>)</button>
                */?>
                <button type="button" class="btn btn-outline-primary-2x" data-original-title="test" onclick="filterModal()"><i class="fa fa-filter"></i>	Filter</button>
              </span>
            </div>
          </div>
        </div>
        <div class="card-body">
		
		<? //echo "<pre>"; print_r($sql_text); echo "</pre>";  ?>
		<? //echo "<pre>"; print_r($_SESSION['filter_pochta']); echo "</pre>";  ?>

								<?// echo "<pre>"; print_r($_POST); echo "</pre>";  ?>
								<?// echo "<pre>"; print_r(strlen(base64_encode(json_encode($_POST)))); echo "</pre>";  ?>
										
		
          <div class="table-responsive" id="table">
            <table class="display" id="basic-1">
              <thead>                
                <tr>
                  <th>TUSHGAN SANA</th>
                  <th>ID</th>
                  <th>FOYDALANUVCHI</th>
                  <th>ADDRESS</th>
                  <th>TELEFON RAQAM</th>               
                  <th>OG'IRLIGI</th>   
                  <th>POLKASI</th>            
                  <th>QO'SHIMCHA MA'LUMOTLAR</th>     
                </tr>                
              </thead>              
              <tbody>    

				<?
				
				foreach ($sql as $k => $v){$tg_codes[] = $v['CLIENT_CODE'];}
				$tg_ids = implode("','",$tg_codes);
				
				foreach ( db::arr("SELECT * FROM `tg_users` WHERE CODE IN ('$tg_ids') ") as $k => $v ) { $tg_users[$v['CODE']] = $v ; }
				
				?>	
			  
                <?
                 foreach ($sql as $v):
                    /*
                    $check_for = db::arr_s("SELECT * FROM `ac_zakaz` WHERE CLIENT_CODE='$v[CLIENT_CODE]' AND `TOVAR_PHOTO` IS NOT NULL AND `PAYMENT_PHOTO` IS NULL AND ID <> $v[ID]");
                    if($v['CART'] == 1){
                      $attr = "style=\"display:none;\"";
                    }else{
                      $attr = ""; 
                    }
                    
                    <?if($check_for != "empty") echo 'style="background-color:#ccc;"';?>
                    */
                ?>
                <tr <?if (!empty($attr))echo $attr;?>>
                  <td><?=$v['LAST_MODIFIED']?></td>
                  <td><?=$v['ID']?></td>
                  <td><?=$v['CLIENT_CODE']?></td>
                  <td><?=$tg_users[$v['CLIENT_CODE']]['ADRES']?></td>     
                  <td><?=$tg_users[$v['CLIENT_CODE']]['PHONE']?></td>     
                  <td><?=$v['WEIGHT']?></td>  
                  <td><?=$v["SHELF"]?></td>   
                  <td>
                     
                    <form action="" method="post">
					
                      <button type="button" class="btn btn-primary" onclick="show_print('<?=htmlspecialchars(json_encode($v))?>')">
                        <span class="fa fa-print"></span>
                      </button>                 

					  <button type="button" class="btn btn-primary" onclick="shippedModal('<?=$v['ID']?>')">
                        <span class="fa fa-truck"></span>
                      </button>
					   
                      <button type="button" class="btn btn-primary" onclick="infoModal('<?=$v['ID']?>')"><span class="fa fa-file-text"></span></button>
					            
                      <? /*  
                      <button type="submit"  name="add_to_cart" value="<?=$v["ID"]?>" class="btn btn-primary"><span class="fa fa-plus"></span></button>
					            */ ?>
                    </form>
                  </td>                   
                </tr >                
                <? endforeach;?>                
              </tbody>
            </table>
          </div>
		  
<div class="pochta_content"></div>
	
        </div>
      </div>
    </div>
  </div>
</div>

<? //echo "<pre>"; print_r($_SESSION['filter_pochta']); echo "</pre>";  ?>

<script>
$('document').ready(function () {
	
show_print  = function(data) {
final_data = JSON.parse(data); 


var date    = new Date(final_data.LAST_MODIFIED);
yr      = date.getFullYear();
month   = date.getMonth() < 10 ? '0' + date.getMonth() : date.getMonth();
day     = date.getDate()  < 10 ? '0' + date.getDate()  : date.getDate();
newDate = yr + '-' + month + '-' + day;

//alert(date.getMonth());
//alert(final_data.LAST_MODIFIED.split(" ")[0]);
//alert(newDate);

//new_date = DateToString(new Date(final_data.LAST_MODIFIED),'Y-m-d');

$('[name=print_sana]').val(final_data.LAST_MODIFIED.split(" ")[0]);
$('[name=ex]').val(final_data.CLIENT_CODE);
$('[name=id]').val(final_data.ID);
$('[name=ism]').val(final_data.ISM_FAMILIYA);
$('[name=tel]').val(final_data.PHONE);
$('[name=manzil]').html(final_data.ADRES);
$('[name=kg]').val(final_data.WEIGHT);

 
$("#print").modal("show");



}	
		
	
});
</script>


<?if(strlen($_SESSION["filter_pochta"])>0):?>
<script>
$('document').ready(function (){
	

	
//show_user_content(1,'first');	


show_user_content= function(page_num,type){

//alert('test');

if (type=='search'){	
keyword = $('[name=search_user]').val();}
else if (type=='first'){keyword='';
}else{
//keyword = '<?=$_SESSION['sklad_list_keyword']?>';
keyword = $('[name=search_user]').val();

}

var formData  = new FormData();
formData.append('keyword',keyword);
formData.append('page_num',page_num);

js_ajax_post('pochta/show_table.php',formData).done(function (data) {	
$('.pochta_content').html(data);});}

if ($('.pochta_content').html()==''){
	show_user_content(1,'first');
	$('#table').html('');
	
	}	
});
</script>
<?endif?>


<?require "pochta_modals.php";?>
<?/* $check_for = db::arr_s("SELECT * FROM `ac_zakaz` WHERE CLIENT_CODE='$v[CLIENT_CODE]' AND `TOVAR_PHOTO` IS NOT NULL AND `PAYMENT_PHOTO` IS NULL AND ID <> $v[ID]");
                if($check_for != "empty") echo 'style="background-color:red;"';*/?>
<?
if(isset($_POST["add_to_cart"]) and is_numeric($_POST["add_to_cart"])){
  $update = db::query("UPDATE `ac_zakaz` SET CART=1 WHERE ID='$_POST[add_to_cart]'");
  LocalRedirect("index.php");
}
?>