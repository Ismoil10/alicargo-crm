<?
require $_SERVER["DOCUMENT_ROOT"]."/core/backend.php";
$word =  explode(" " , str_replace("'","",$_POST['word']));
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
tg.ISM_FAMILIYA FROM `ac_zakaz` AS az INNER JOIN `tg_users` AS tg ON tg.CODE=az.CLIENT_CODE WHERE az.DELIVERY_TYPE='pochta' AND az.PAID=1 AND az.PICKUP_DATE IS NULL AND az.POCHTA_PHOTO IS NULL AND (LOWER(az.ID) LIKE LOWER('%$word[0]%') OR LOWER(az.CLIENT_CODE) LIKE LOWER('%$word[0]%') OR LOWER(az.WEIGHT) LIKE LOWER('%$word[0]%') OR LOWER(az.SHELF) LIKE LOWER('%$word[0]%') OR LOWER(az.PRICE) LIKE LOWER('%$word[0]%') OR LOWER(tg.ADRES) LIKE LOWER('%$word[0]%') OR LOWER(tg.PHONE) LIKE LOWER('%$word[0]%') OR LOWER(tg.ISM_FAMILIYA) LIKE LOWER('%$word[0]%')) AND (LOWER(az.ID) LIKE LOWER('%$word[1]%') OR LOWER(az.CLIENT_CODE) LIKE LOWER('%$word[1]%') OR LOWER(az.WEIGHT) LIKE LOWER('%$word[1]%') OR LOWER(az.SHELF) LIKE LOWER('%$word[1]%') OR LOWER(az.PRICE) LIKE LOWER('%$word[1]%') OR LOWER(tg.ADRES) LIKE LOWER('%$word[1]%') OR LOWER(tg.PHONE) LIKE LOWER('%$word[1]%') OR LOWER(tg.ISM_FAMILIYA) LIKE LOWER('%$word[1]%')) AND (LOWER(az.ID) LIKE LOWER('%$word[2]%') OR LOWER(az.CLIENT_CODE) LIKE LOWER('%$word[2]%') OR LOWER(az.WEIGHT) LIKE LOWER('%$word[2]%') OR LOWER(az.SHELF) LIKE LOWER('%$word[2]%') OR LOWER(az.PRICE) LIKE LOWER('%$word[2]%') OR LOWER(tg.ADRES) LIKE LOWER('%$word[2]%') OR LOWER(tg.PHONE) LIKE LOWER('%$word[2]%') OR LOWER(tg.ISM_FAMILIYA) LIKE LOWER('%$word[2]%'))");

echo json_encode($data);
?>