
<? //echo "<pre>"; print_r($_SESSION['filter_reys']); echo "</pre>";  ?>
<? //echo "<pre>"; print_r($_POST); echo "</pre>";  ?>

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
        <div class="card-header">
          <div class = "row">
            <div class = "col-lg-6 col-md-6 col-sm-6 col-12"> 
              <h5 class = "d-inline-block">Список Заказов</h5><span><?if(isset($_SESSION["filter_order"])){
                    echo "Filter ishlavoti";                      
                  }?></span>
            </div>
            <div class = "col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
              <span class = "d-inline-block">
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
            js_ajax_post("orders_report/mini_kassa.php", form).done(data=>{
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
        
		<?if (isset($_GET['item_id'])):?>
		formData.append('keyword','<?=$_GET['item_id']?>');
		formData.append('search_code','1');
		<?else:?>
		formData.append('keyword',keyword);
		<?endif?>
		
        formData.append('page_num',page_num);
        
        js_ajax_post('orders_report/show_table.php',formData).done(function (data) {	
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



<?
require "orders_report_modal.php";
require "orders_report_js.php";
?>
<!-- Container-fluid Ends-->