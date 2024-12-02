<?
require $_SERVER["DOCUMENT_ROOT"].'/core/backend.php';
function get_items(){
  $data = db::arr("SELECT * FROM `order_item` WHERE ORDER_ID='$_POST[order_id]'");
  return json_encode($data);
}
function insert(){
  $insert = db::query("INSERT INTO `order_item` (`ORDER_ID`,`TRACK_CODE`) VALUES ('$_POST[order_id]','$_POST[track_code]')");
  return $insert;
}

if(isset($_POST["order_id"]) and isset($_POST["track_code"]) and $_POST["type"]=="insert"){
  $create = insert();
  if($create["stat"]=="success"){
    echo get_items();
  }
}else{
  echo get_items();
}

?>