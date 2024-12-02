<?

require $_SERVER["DOCUMENT_ROOT"].'/core/backend.php';
ini_set('display_errors',1);

?>
<?

$order_id = $_GET['order_id'];

$track_codes = db::arr("SELECT * FROM order_item WHERE ORDER_ID = '$order_id'");

$order = db::arr_s("SELECT * FROM ac_zakaz WHERE ID = '$order_id'");
?>
<? //echo "<pre>"; print_r($track_codes); echo "</pre>";  ?>
<?if ($track_codes !='empty'):?>

<style>
table {
  border-collapse: collapse;
  text-align: center;
}
th {
  border: 1px solid black;
 
}

td {
  border: 1px solid gray;

}
</style>
<table style="width: 1000px;">
  <thead>
    <tr>
      <th style="width: 10%;">ZAKAZ NOMERI</th>
      <th style="width: 10%;">KLIENT KOD</th>
    </tr>
  </thead>
  <tbody>
      <tr>
        <td><?=$order['ID']?></td>
        <td><?=$order['CLIENT_CODE']?></td>
      </tr>
  </tbody>
</table>
<table style="width: 1000px; margin-top: 36px;">
	<thead>
		    <tr>
            <th width="10%">TREK KOD</th>
        </tr>
	</thead>
<tbody>

<?foreach ($track_codes as $v):?>
	<tr>
        <td><?=$v['TRACK_CODE']?></td>
    </tr>
<?endforeach?>
</tbody>
</table>
<p>&nbsp;</p>
<?else:?>
<?echo json_encode($track_codes);?>
<?endif;?>