<?
if (isset($_POST["change_filter"])){
	
$_SESSION['filter_reys'] = $_POST['filter_reys'];
LocalRedirect('index.php');	
	
	
}
?>



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
            <div class="col-lg-6 col-md-6 col-sm-6 col-12">			
            <?if ($_SESSION['filter_reys']>0):?>
            <?$ac_reys = db::arr_s("SELECT * FROM `ac_reys` WHERE ID = '$_SESSION[filter_reys]'");?>
            <h5 class="d-inline-block">Tanlangan reys: <?=$ac_reys['COMMENT']?> (<?=$ac_reys['DATE']?>)</h5>
			      <?else:?>
              <h5 class="d-inline-block">Reys tanlang</h5>
            <?endif?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
              <span class="d-inline-block">
                <button class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" data-bs-target="#add_item"><span class="fa fa-list"></span> Tanlash </button>
              </span>
            </div>
          </div>
        </div>
        <?if ($_SESSION['filter_reys']>0):?>
          <? $order_info = db::arr_s("SELECT SUM(PRICE) AS PRICE, SUM(`WEIGHT`) AS `WEIGHT`, COUNT(ID) AS AMOUNT, SUM(DEBTS) AS DEBTS FROM `ac_zakaz` WHERE REYS_ID='$_SESSION[filter_reys]'");?>
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
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
            <div class="col-sm-6">
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
            <div class="col-sm-6">
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
            <div class="col-sm-6">
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
        </div>
        <?endif?>
 	    </div>
 	  </div>
  </div>	
</div>

<?if ($_SESSION['filter_reys']>0):?>
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
                <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" onclick="addModal()"><i class="fa fa-plus"></i>	Yangi qo'shish</button>
                <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-original-title="test" onclick="filterModal()"><i class="fa fa-filter"></i>	Filter qilish</button>
              </span>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="display" id="basic-1">
              <thead>                
                <tr>
                  <th>ID</th>
                  <th>KLIENT KOD</th>
                  <th>VAZNI</th>
                  <th>POLKA</th>               
                  <th>NARX</th> 
                  <th>QARZ</th>              
                  <th>PRINT</th>              
                  <th>HARAKAT</th>     
                </tr>                
              </thead>              
              <tbody>                
                <?
                  if(isset($_SESSION["filter_order"])){
                    $sql = db::arr("SELECT * FROM `ac_zakaz` WHERE `REYS_ID`='$_SESSION[filter_reys]' $_SESSION[filter_order]");		                      
                  }else{
                    $sql = db::arr("SELECT * FROM `ac_zakaz` WHERE `REYS_ID`='$_SESSION[filter_reys]' ORDER BY ID DESC");		                      
                  }
                  foreach ($sql as $v):
                ?>
                <tr>
                  <td><?=$v['ID']?></td>
                  <td><?=$v["CLIENT_CODE"]?></td>
                  <td><?=$v['WEIGHT']?></td>     
                  <td><?=$v['SHELF']?></td>     
                  <td><?=$v['PRICE']?></td>
                  <td><?=$v["DEBTS"]?></td>
                  
				  <td>
				  <a href="http://localhost/index.php?zakaz_id=<?=$v['ID']?>&client_code=<?=$v['CLIENT_CODE']?>&ves=<?=$v['WEIGHT']?>&shelf=<?=$v['SHELF']?>&narx=<?=$v['PRICE']?>" target="_blank" style="cursor: pointer;">
				 <button class="btn btn-primary" >PRINT</button>		
				  </a>
				  </td>
                  
				  <td>
                    <a href="./detail/<?=$v['ID']?>" style="padding: 8px 30px;" class="btn btn-primary"><span class="fa fa-chevron-right"></span></a>
                    <button class="btn btn-primary" value="<?=htmlspecialchars(json_encode($v))?>" onclick="editModal(JSON.stringify(value))">
                      <span class="fa fa-edit"></span>
                    </button>
                  </td>                   
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
<?endif?>



<!--  START ADD MODAL  -->

 <div class="modal fade" id="add_item" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="add_item">Reys tanlash</h5>
          <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
		<form method = "post">
        <div class="modal-body">
		
		<div class = "mb-3">
			<label class="form-label">Reyslar</label>
			<div class="input-group">	
			
				<select class="form-control" name="filter_reys" required>
				<option></option>
				<?foreach(db::arr("SELECT * FROM `ac_reys`") as $v):?>				
				<option value="<?=$v['ID']?>" <?if ($_SESSION['filter_reys']==$v['ID']){echo 'selected';}?>><?=$v['COMMENT']?> (<?=$v['DATE']?>)</option> 
				<?endforeach;?>
				</select>
				
			</div>
		</div>
		

		
		</div>
        <div class="modal-footer">          
          <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Chiqish</button>
          <button class="btn btn-primary" name = "change_filter" type="submit">Tanlash</button>
        </div>
		</form>
      </div>
    </div>
</div>

<!-- END ADD MODAL  -->



<?require "orders_modal.php";?>
<!-- Container-fluid Ends-->