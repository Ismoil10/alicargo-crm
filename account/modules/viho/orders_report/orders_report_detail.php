<?
$get_reys_id = db::arr_s("SELECT * FROM `ac_zakaz` WHERE ID='$_GET[item_id]'");
 ?>
<?$role_id=$_SESSION['user']['role_id'];?>
		<div class="container-fluid">
      <div class="page-header">
        <div class="row">
          <div class="col-sm-6">
            <h3>ZAKAZ ID: <?=$get_reys_id["ID"]?></h3>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/account/orders/list">Zakaz</a></li>
              <li class="breadcrumb-item active">Zakaz: <?=$get_reys_id["CLIENT_CODE"]?></li>
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
    <div class="container-fluid credit-card payment-details">
      <div class="row">
          <!-- Individual column searching (text inputs) Starts-->
        <div class="col-xxl-12 box-col-12">
          <div class="card">
            <div class="card-header pb-0" style="padding:0;">
              <!--<h5>Общая информация </h5>-->
            </div>
            <div class="card-body" style="padding:20;">
              <div class="row">
                <div class="col-md-3">
                  <label>Trek Raqami</label>
                  <input class="form-control" type="text"  name="track_number" required>
                </div>
                <div class="col-md-6">
                </div>
                <div class="col-md-3 " style="display: flex; justify-content: flex-end; align-items: center;">
                  <button class="btn btn-primary" onclick="closeOrderModal('<?=$_GET['item_id']?>')"><span class="fa fa-upload"></span> BUYURTMANI YOPISH</button>
                </div>
              </div>  
              <div class="alert alert-light dark alert-dismissible fade show mt-3 alert-found" role="alert" style="display: none;"><i data-feather="alert-triangle"></i>
              <p id="error-text"></p>
              <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
            </div>
          </div>
        </div>
        <!-- Individual column searching (text inputs) Ends-->      
				<script>
	        function js_ajax_post(url,data) {	   
            return $.ajax({
		          type: 'POST',
              data: data,		
		          url: "/account/ajax/"+url,
              async: true,
              cache: false,
              contentType: false,
              processData: false
            });
          }
          $("[name=track_number]").focus();
          $(document).on('keypress',function(e) {
            if(e.which == 13){
              var track_number = $("[name=track_number]").val();
              $("[name=tr_number]").val(track_number);
              track_number = track_number.replace(/\s/g, '');
              formData = new FormData();
              formData.append("track_code", track_number);
              formData.append("order_id", '<?=$_GET["item_id"]?>');
              formData.append("type","insert");
              js_ajax_post("orders/add_item.php", formData).done(data=>{
                var codes = JSON.parse(data);
                var tr = '';
                codes.forEach(code => {
                  tr +=`<tr><td>${code.TRACK_CODE}</td>
                  <td><button class="btn btn-danger" onclick="deleteModal('${code.ID}')"><span class="fa fa-trash"></span></button></td></tr>`
                });
                $("#box-products-table").html(tr);
                $("[name=track_number]").val('');
              });
            }
          });
	      </script>				 			  
        <!-- Individual column searching (text inputs) Starts-->
        <div class="col-xxl-12 box-col-12">
          <div class="card" id="content">
            <div class="card-header" style="padding:20;">
              <div class = "row">
                <div class = "col-lg-6 col-md-6 col-sm-6 col-12"> <h5 class = "d-inline-block">Trek Raqamlar</h5><br> <span>Klient kodi: <b><?=$get_reys_id["CLIENT_CODE"]?></b></span>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="table-responsive">
                <table class="table" id="basic-1">
                  <thead>
                    <tr>
                      <th>TREK RAQAM</th>
                      <?if($role_id==1):?>
                      <th>OʻCHIRISH</th>
                      <?endif;?>
                    </tr>
                  </thead>
                  <tbody id="box-products-table">	                        
                    <?
                      $sql = db::arr("SELECT * FROM `order_item` WHERE `ORDER_ID`='$_GET[item_id]'");		                      
                      foreach ($sql as $v):
                    ?>
                    <tr>              
                      <td><?=$v['TRACK_CODE']?></td>
                      <?if($role_id==1):?>
                      <td>
                        <button class="btn btn-danger" onclick="deleteModal('<?=$v['ID']?>')"><span class="fa fa-trash"></span></button>
                      </td>
                      <?endif;?>
                    </tr>
                    <? endforeach;?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>           
    </div>
  </div>         
<?require "orders_report_detail_modal.php";?>