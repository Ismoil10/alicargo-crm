<?
if (isset($_POST['show_report'])) {
  $_SESSION['filter_order_reys'] = $_POST['filter_reys'];

  $_SESSION['report']['type']  = $_POST['report_type'];
  $date = explode("-", $_POST["daterange"]);

  if (empty($date[0])) {
    $from = date("Y/m/d");
  } else {
    $from = $date[0];
  }
  if (empty($date[1])) {
    $to = date("Y/m/d");
  } else {
    $to = $date[1];
  }

 /* if(isset($_SESSION['filter_reys'])){
    $_SESSION['report']['to_date'] = 0;
    $_SESSION['report']['from_date'] = 0; 
  }else{*/

  $_SESSION['report']['from_date'] =  date("Y-m-d 00:00:00", strtotime($from));
  $_SESSION['report']['to_date'] =  date("Y-m-d 23:59:59", strtotime($to));
 // }
 

  LocalRedirect('index.php');
}

?>

<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-sm-8">
        <? 
       // echo '<pre>'; print_r($_SESSION); echo '</pre>'; 
        
        
        ?>
        <h3>Alicargo</h3>
      </div>
      <div class="col-sm-2 d-flex justify-content-md-end">
        <span class="d-inline-block">
          <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" data-bs-target="#report"><i class="fa fa-file-text"></i> Hisobot</button>
        </span>
      </div>
      <div class="col-sm-2">
        <!-- Bookmark Start-->
        <div class="bookmark">
          <ul>
            <li style="padding-right: 40px"><a href="https://t.me/alicargo_bot" target="_blank"><i class="bookmark-search" data-feather="at-sign"></i>alicargo_bot</a>
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
        <?if ($_SESSION['filter_order_reys']>0):?>
          <? $order_info = db::arr_s("SELECT SUM(PRICE) AS PRICE, SUM(`WEIGHT`) AS `WEIGHT`, COUNT(ID) AS AMOUNT, SUM(DEBTS) AS DEBTS FROM `ac_zakaz` WHERE REYS_ID='$_SESSION[filter_order_reys]'");
          
          ?>
          <? $taken_order = db::arr_s("SELECT 
          COUNT(orders.ID) AS TK_ORDER, SUM(ta.SUMMA_USD) AS PRICE 
          FROM `ac_zakaz` AS orders
          LEFT JOIN ac_transactions AS ta ON ta.ORDER_ID = orders.ID
          WHERE orders.REYS_ID='$_SESSION[filter_order_reys]' AND orders.PAID = '1'"); ?>
          
          <? //$not_t = db::arr_s("SELECT COUNT(ID) AS NOT_TAKEN, SUM(`PRICE`) AS PRICE FROM `ac_zakaz` WHERE PAID = '0' AND REYS_ID='$_SESSION[filter_reys]'"); 
          
          $not_taken = $order_info["AMOUNT"] - $taken_order['TK_ORDER'];
          $summa_usd = $order_info['PRICE'] - $taken_order['PRICE'];

          ?>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3">
              <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font">
                  <div class="row">
                    <div class="col-5">
                      <h6>Zakazlar Soni</h6>
                      <h4 class="total-num"><?=$order_info["AMOUNT"]?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font">
                  <div class="row">
                    <div class="col-5">
                      <h6>Zakazlar Vazni</h6>
                      <h4 class="total-num"><?=round($order_info["WEIGHT"], 2)?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font">
                  <div class="row">
                    <div class="col-5">
                      <h6>Zakazlar Narxi</h6>
                      <h4 class="total-num"><?=round($order_info["PRICE"], 2)?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font">
                  <div class="row">
                    <div class="col-5">
                      <h6>Zakazlar Qarzi</h6>
                      <h4 class="total-num"><?=round($order_info["DEBTS"], 2)?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-sm-3">
              <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font">
                  <div class="row">
                    <div class="col-5">
                      <h6>Olib ketilgan</h6>
                      <h4 class="total-num"><?=$taken_order["TK_ORDER"]?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font">
                  <div class="row">
                    <div class="col-5">
                      <h6>Olib ketilmagan</h6>
                      <h4 class="total-num"><?=$not_taken?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font">
                  <div class="row">
                    <div class="col-5">
                      <h6>Tushgan pul</h6>
                      <h4 class="total-num"><?=round($taken_order["PRICE"], 2)?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-3">
              <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font">
                  <div class="row">
                    <div class="col-5">
                      <h6>Tushmagan pul</h6>
                      <h4 class="total-num"><?=round($summa_usd, 2)?></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <?endif?>
 	    </div>
 	  </div>
  </div>	
</div>

<?if ($_SESSION['filter_order_reys']>0):?>
<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class = "row">
            <div class = "col-lg-6 col-md-6 col-sm-6 col-12"> 
              <h5 class = "d-inline-block">Список Заказов</h5><span style="padding-left: 20px;"><b>Filter:</b> <?if(isset($_SESSION["filter_order"])){
                    if($_SESSION['filter_type'] == 'debts'){
                        echo "Qarzi borlar";
                    }
                    if($_SESSION['filter_type'] == 'payments'){
                      echo "To'langanlar";
                    }
                    if($_SESSION['filter_type'] == 'sklatda'){
                      echo "Sklatda borlari";
                    }
                    if($_SESSION['filter_type'] == 'taken'){
                      echo "Olib ketilganlar";
                    }
                    
                    //echo "Filter ishlavoti";                      
                  }?></span>
            </div>
            <div class = "col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
              <span class = "d-inline-block">
                <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" onclick="addModal()"><i class="fa fa-plus"></i>	Yangi qo'shish</button>
                <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" onclick="filterModal()"><i class="fa fa-filter"></i>	Filter qilish</button>
              </span>
            </div>
          </div>
        </div>
        <div class="card-body">
                  	  
                  
        <script>
        $('document').ready(function (){
          miniKassa = function(id){
            form = new FormData();
            form.append("ID", id);
            js_ajax_post("orders/mini_kassa.php", form).done(data=>{
              $("#miniKassa").html(data);
              $("#miniKassa").modal("show");
            });
          }
          
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
        
        js_ajax_post('orders/show_report.php',formData).done(function (data) {	
        $('.user_list_content').html(data);});}
        
        if ($('.user_list_content').html()==''){
          show_user_content(1,'first');
          
          }	
        });
        </script>
              
                        
        <div class="user_list_content"></div>	


        </div>
      </div>
    </div>
  </div>
</div>
<?endif?>


<!-- Container-fluid starts-->
<div class="container-fluid">
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <div class="card-header">
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">
              <h5 class="d-inline-block">Hisobotni tanlang</h5>
            </div>
            <!--<div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
              <span class="d-inline-block">
                <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" data-bs-target="#report"><i class="fa fa-file-text"></i> Hisobot</button>
              </span>
            </div>-->
          </div>
        </div>
        <div class="card-body">
          <!-- Container-fluid Ends-->
          <? if ($_SESSION["report"]['type'] == 'accounting_report'): ?>
            <? require 'rt_accounting_report.php'; ?>
          <? endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>




<? require('modules/viho/report/report_js.php'); ?>
<? require('modules/viho/report/report_modals.php'); ?>