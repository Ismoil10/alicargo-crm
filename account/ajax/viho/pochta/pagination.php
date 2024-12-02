<?require $_SERVER["DOCUMENT_ROOT"].'/core/backend.php';
$data = db::arr_s("SELECT COUNT(az.ID) as amount FROM `ac_zakaz` AS az INNER JOIN `tg_users` AS tg ON tg.CODE=az.CLIENT_CODE WHERE az.DELIVERY_TYPE='pochta' AND az.PAID=1 AND az.PICKUP_DATE IS NULL AND az.POCHTA_PHOTO IS NULL ORDER BY az.LAST_MODIFIED DESC");
$number = $data["amount"]/15;
if($number > round($number)){
  $pages = round($number)+1;
}else{
  $pages = round($number);
}

echo '{"pagesAmount":'.$pages.'}';
?>