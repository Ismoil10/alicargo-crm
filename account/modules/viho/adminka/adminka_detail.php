<!-- BEGIN: Content-->
<?
if (isset($_GET['item_id'])) {
  $_SESSION['admin_id'] = $_GET['item_id'];
}

$admin_id = $_SESSION['admin_id'];
$dates = $_SESSION['year_month'];

$get_code = db::arr("SELECT * FROM new_tg_users WHERE ADMIN_ID = '$admin_id' AND ACTIVE = 1");
foreach ($get_code as $v) {
  if (!empty($v['USER_CODE'])) {
    $codes[] = "'" . $v['USER_CODE'] . "'";
  }
}
$sort = implode(",", $codes);
$str = explode(".", $dates);

$month = $str[0];
$year = $str[1];

$last_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$time_start = $year . "-" . $month . "-01 00:00:00";
$time_end = $year . "-" . $month . "-" . $last_day . " 23:59:59";


if ($dates != 0) {

  $weight = db::arr_s("SELECT ROUND(SUM(`WEIGHT`), 2) AS LBS FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE BETWEEN '$time_start' AND '$time_end')");
  $price = db::arr_s("SELECT ROUND(SUM(`PRICE`), 2) AS USD FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE BETWEEN '$time_start' AND '$time_end')");
} else {
  $now = "2024-05-08";

  $weight = db::arr_s("SELECT ROUND(SUM(`WEIGHT`), 2) AS LBS FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE >= '$now')");
  $price = db::arr_s("SELECT ROUND(SUM(`PRICE`), 2) AS USD FROM ac_zakaz WHERE CLIENT_CODE IN ($sort) AND (CREATED_DATE >= '$now')");
}
?>
<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-sm-6">
        <h3>ALICARGO</h3>
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
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
                <div class="card ecommerce-widget pro-gress">
                  <div class="card-body support-ticket-font">
                    <div class="row">
                      <h6><i class="fa fa-balance-scale"></i> Umumiy vazn: <? if($price != 'empty'){ echo $weight['LBS']; }else{ echo "0.00"; }?></h6>
                      <span></span>
                    </div>
                  </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card ecommerce-widget pro-gress">
                  <div class="card-body support-ticket-font">
                    <div class="row">
                      <h6><i class="fa fa-money"></i> Umumiy narx: <? if($price != 'empty'){ echo $price['USD']; }else{ echo "0.00"; }?></h6>
                    </div>
                  </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      
      <?/* Таблица заказов - начало */?> 
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
              <h5 class="d-inline-block">Список Заказов</h5>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
              <span class="d-inline-block">
                <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" onclick="filterModal()"><i class="fa fa-filter"></i> Filter qilish</button>
              </span>
            </div>
          </div>
        </div>
        <div class="card-body">

          <script>
            $('document').ready(function() {
              show_user_content = function(page_num, type) {

                if (type == 'search') {
                  keyword = $('[name=search_zakaz]').val();
                } else if (type == 'first') {
                  keyword = '';
                } else {
                  //keyword = '<?= $_SESSION['sklad_list_keyword'] ?>';
                  keyword = $('[name=search_zakaz]').val();

                }

                var formData = new FormData();
                formData.append('keyword',keyword);
                formData.append('page_num', page_num);

                js_ajax_post('adminka/adminka_table.php', formData).done(function(data) {
                  $('.user_list_content').html(data);
                });
              }

              if ($('.user_list_content').html() == '') {
                show_user_content(1, 'first');

              }
            });
          </script>
          <div class="user_list_content"></div>
        </div>
      </div>
     <?/* Таблица заказов - конец */?> 
     
     <?/* Таблица клиентов - начало */?> 
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
              <h5 class="d-inline-block">Список пользователей</h5>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
             
            </div>
          </div>
        </div>
        <div class="card-body">
      
          <script>
          $('document').ready(function (){
            
          show_user_content= function(page_num,type){
          
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
          
          
          js_ajax_post('adminka/show_table.php',formData).done(function (data) {	
          $('.adminka_user_content').html(data);});}
          
          if ($('.adminka_user_content').html()==''){
            show_user_content(1,'first');
            
            }	
          });
          </script>
      
        
          <div class="adminka_user_content"></div>
        </div>
      </div>
      <?/* Таблица клиентов - конец */?> 
      
    </div>
  </div>
</div>
<? require "modules/viho/adminka/adminka_js.php"; ?>
<? require "modules/viho/adminka/adminka_detail_modal.php"; ?>