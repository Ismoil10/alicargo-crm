<?
$sql = db::arr("SELECT az.*, tg.ADRES, tg.PHONE, tg.ISM_FAMILIYA FROM `ac_zakaz` AS az INNER JOIN `tg_users` AS tg ON tg.CODE=az.CLIENT_CODE WHERE az.DELIVERY_TYPE='pochta' AND az.PAID=1 AND az.PICKUP_DATE IS NULL AND az.POCHTA_PHOTO IS NULL AND CART=1 ORDER BY az.LAST_MODIFIED DESC");
?>
<div class="container-fluid">
  <div class="page-header">
    <div class="row">
      <div class="col-sm-6">
        <h3>ALICARGO</h3>
        <ol class="breadcrumb">
          <li class="breadcrumb-item "><a href="/account/pochta/list">Pochtalar</a></li>
          <li class="breadcrumb-item active"><span>Korzina</span></li>
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
              <h5 class = "d-inline-block">Korzinadagi Pochtalar Ro'yhati</h5>
            </div>
            <!-- <div class = "col-lg-6 col-md-6 col-sm-6 col-12 d-flex justify-content-md-end">
              <span class = "d-inline-block">      
                <button type="button" class="btn btn-outline-primary-2x" data-bs-toggle="modal" data-bs-target="#cartModal"><i class="fa fa-shopping-cart"></i> Karzina (<?=$cart["AMOUNT"]?>)</button>
                <button type="button" class="btn btn-outline-primary-2x" data-original-title="test" onclick="filterModal()"><i class="fa fa-filter"></i>	Filter</button>
              </span>
            </div> -->
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
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
                  foreach ($sql as $v):
                ?>
                <tr <?if (!empty($attr))echo $attr;?>>
                  <td><?=$v['LAST_MODIFIED']?></td>
                  <td><?=$v['ID']?></td>
                  <td><?=$v['CLIENT_CODE']?></td>
                  <td><?=$v['ADRES']?></td>     
                  <td><?=$v['PHONE']?></td>     
                  <td><?=$v['WEIGHT']?></td>  
                  <td><?=$v["SHELF"]?></td>   
                  <td>
                     
                    <form action="" method="post">
                      <button type="button" class="btn btn-primary" onclick="shippedModal('<?=$v['ID']?>')">
                        <span class="fa fa-truck"></span>
                      </button>
                      <button type="button" class="btn btn-primary" onclick="infoModal('<?=$v['ID']?>')"><span class="fa fa-file-text"></span></button>
                      <button type="submit"  name="add_to_cart" value="<?=$v["ID"]?>" class="btn btn-danger"><span class="fa fa-minus"></span></button>
                    </form>
                  </td>                   
                </tr >                
                <? endforeach;?>                
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?require "pochta_modals.php";
if(isset($_POST["add_to_cart"]) and is_numeric($_POST["add_to_cart"])){
  $update = db::query("UPDATE `ac_zakaz` SET CART=0 WHERE ID='$_POST[add_to_cart]'");
  LocalRedirect("index.php");
}
?>
