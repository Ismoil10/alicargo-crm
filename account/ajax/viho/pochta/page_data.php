<? 
require $_SERVER["DOCUMENT_ROOT"].'/core/backend.php';
$page_index = ($_POST["pageNumber"]-1) * 15;

if($_POST["filter_action"] === "conform" and $_POST["method"] === "desc")$method = "DESC";
else if($_POST["filter_action"] === "conform" and $_POST["method"] === "asc") $method = "ASC";

if($_POST["filter_action"]==="conform" and $_POST["filter_option"]==="date")$option = "LAST_MODIFIED";
else if($_POST["filter_action"]==="conform" and $_POST["filter_option"]==="client_code")$option = "CLIENT_CODE";
else if($_POST["filter_action"]==="conform" and $_POST["filter_option"]==="shelf")$option = "SHELF";

if($_POST["filter_action"] === "conform"){
  $data = db::arr("SELECT 
  az.ID,
  az.LAST_MODIFIED,
  az.CLIENT_CODE,
  az.WEIGHT,
  az.SHELF,
  az.PRICE,
  az.ACTIVE,
  az.TAKEN,
  az.CART,
  az.STATUS,
  tg.ADRES, 
  tg.PHONE, 
  tg.ISM_FAMILIYA FROM `ac_zakaz` AS az INNER JOIN `tg_users` AS tg ON tg.CODE=az.CLIENT_CODE WHERE az.DELIVERY_TYPE='pochta' AND az.PAID=1 AND az.PICKUP_DATE IS NULL AND az.POCHTA_PHOTO IS NULL ORDER BY az.$option $method LIMIT $page_index, 15");
}else{
  $data = db::arr("SELECT 
  az.ID,
  az.LAST_MODIFIED,
  az.CLIENT_CODE,
  az.WEIGHT,
  az.SHELF,
  az.PRICE,
  az.ACTIVE,
  az.TAKEN,
  az.CART,
  az.STATUS,
  tg.ADRES, 
  tg.PHONE, 
  tg.ISM_FAMILIYA FROM `ac_zakaz` AS az INNER JOIN `tg_users` AS tg ON tg.CODE=az.CLIENT_CODE WHERE az.DELIVERY_TYPE='pochta' AND az.PAID=1 AND az.PICKUP_DATE IS NULL AND az.POCHTA_PHOTO IS NULL ORDER BY az.LAST_MODIFIED DESC LIMIT $page_index, 15");
}
echo json_encode($data);
?>