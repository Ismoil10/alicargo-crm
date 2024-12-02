<?require $_SERVER["DOCUMENT_ROOT"].'/bot/class.php';?>
<?require $_SERVER["DOCUMENT_ROOT"].'/bot/db.php';?>
<?
$order_id = $_POST['yandex_order_id'];

$data = db::arr_s("SELECT * FROM `ac_zakaz` WHERE ID='$order_id'");
$user = db::arr_s("SELECT * FROM `tg_users` WHERE CODE='$data[CLIENT_CODE]'");

$location = db::arr_s("SELECT * FROM `ac_location` WHERE `ORDER_ID` = '$order_id' AND `TYPE` = 'yandex'");
?>

<div class="modal-dialog modal-lg">
  <div class="modal-content">
    <div class="modal-header">
      <h4 class="modal-title" id="infoModalLabel">Qo'shimcha ma'lumotlar</h4>
      <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body" style="display: flex; justify-content: space-around;">
      <div class="infoBox">
        <?if($user != "empty"):?>
        <div class="mb-3">
          <h6>Hoydalanuvchi</h6>
          <p id="username"><?=$user["ISM_FAMILIYA"].' ('.$user['CODE'].') '?></p>
        </div>
        <div class="mb-3">
          <h6>Hoydalanuvchi Adresi:</h6>
          <p id="usernameAddres"><?=$user["ADRES"]?></p>
        </div>
        <div class="mb-3">
          <h6>Hoydalanuvchi Tel. raqami</h6>
          <p id="usernamePhone"><?=$user["PHONE"]?></p>
        </div>
        <?endif?>
        <div class="mb-3">
          <h6>Zakaz Raqami</h6>
          <p id="orderID"><?=$data["ID"]?></p>
        </div>
        <div class="mb-3">
          <h6>Zakaz Narxi</h6>
          <p id="orderPrice"><?=$data["PRICE"]?></p>
        </div>
        <div class="mb-3">
          <h6>Zakaz Og'irligi</h6>
          <p id="orderWeight"><?=$data["WEIGHT"]?></p>
        </div>
        <div class="mb-3">
          <h6>Zakaz Polkasi</h6>
          <p id="orderShelf"><?=$data["SHELF"]?></p>
        </div>
        <?if($data["PICKUP_DATE"] != null):?>
          <div class="mb-3">
            <h6>Zakaz Olib ketilgan Sana</h6>
            <p id="orderShelf"><?=date("d.m.Y (H:i)", strtotime($data["PICKUP_DATE"]))?></p>
          </div>
        <?endif?>
        <div class="mb-3">
          <h6>Lokatsiya:</h6>
          <p id="orderShelf"><?=$location['LATITUDE'].', '.$location['LONGITUDE'];?></p>
        </div>
      </div>
      <div class="imageBox" style="display: flex; width:50%;">
      <a style="width:100%;" href="/loading.gif" data-lightbox="image-1" data-title="Tovar Rasmi">
        <img style="width: 100%; object-fit:contain;" src="/loading.gif" alt="productImage">
      </a>
      <!-- <a style="width:50%;" href="/loading.gif" data-lightbox="image-1" data-title="Tolov Rasmi">
        <img style="width: 100%; object-fit:contain;" src="/loading.gif" alt="weightImage">
      </a> -->
      </div>
    </div>
  </div>
</div>
<script>
    function getImage(){
    form = new FormData();
    form.append("ID", <?=$_POST['yandex_order_id']?>);
    js_ajax_post("viho/yandex_dostavka/info_images.php",form).done(data=>{
      $(".imageBox").html(data);
    });
  }
  getImage();
</script>