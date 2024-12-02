<?
require $_SERVER["DOCUMENT_ROOT"]."/core/backend.php";
$order = db::arr_s("SELECT * FROM `ac_zakaz` WHERE ID='$_POST[ID]'");

if($order["CART"] == '0'){
  $update = db::query("UPDATE `ac_zakaz` SET `CART`='1' WHERE ID='$_POST[ID]'");
}else{
  $update = db::query("UPDATE `ac_zakaz` SET `CART`='0' WHERE ID='$_POST[ID]'");
}
$amount = db::arr_s("SELECT COUNT(ID) AS amount FROM `ac_zakaz` WHERE CART='1'");

$res = ["status"=>$update["stat"],"cart"=>$amount["amount"]];
echo json_encode($res);


?>