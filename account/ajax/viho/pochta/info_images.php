<?
require $_SERVER["DOCUMENT_ROOT"] . "/bot/db.php";
require $_SERVER["DOCUMENT_ROOT"] . "/bot/class.php";
$data = db::arr_s("SELECT * FROM `ac_zakaz` WHERE ID='$_POST[ID]'");
?>

<a style="width:50%;" href="<?= bot::getFile($data['TOVAR_PHOTO']) ?>" data-lightbox="image-1" data-title="Tovar Rasmi">
  <img style="width: 100%; object-fit:contain;" src="<?= bot::getFile($data["TOVAR_PHOTO"]) ?>" alt="productImage">
</a>
<a style="width:50%;" href="<?= bot::getFile($data['PAYMENT_PHOTO']) ?>" data-lightbox="image-1" data-title="Tolov Rasmi">
  <img style="width: 100%; object-fit:contain;" src="<?= bot::getFile($data["PAYMENT_PHOTO"]) ?>" alt="weightImage">
</a>