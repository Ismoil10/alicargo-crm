<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="addModalLabel">Zakaz Qo'shish</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="addForm" method="post">
          <div class="mb-3">
            <label>Klient Raqami</label>
            <div class="input-group">
              <select name="type" class="input-group-text">
                <option value="EX">EX</option>
                <option value="ALI">ALI</option>
              </select>
              <input type="text" name="clientID" id="client_code" class="form-control">
              <div class="invalid-feedback">Haqat raqamlar ruhsat berilgan</div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
        <button type="submit" class="btn btn-primary" form="addForm" name="addOrder">Tasdiqlash</button>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Zakaz Tahrirlash</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <? //echo '<pre>'; print_r($_POST['sale']); echo '</pre>'; ?>
        <form action="" id="editForm" method="post">
          <input type="hidden" name="order_id">
          <div class="mb-3">
            <label class="form-label">Klient Raqami</label>
            <input type="text" class="form-control" name="client_code">
          </div>
          <div class="mb-3">
            <label class="form-label">Og'irligi</label>
            <input type="number" step="0.01" class="form-control" name="weight">
          </div>
          <div class="mb-3">
            <label class="form-label">Narxi</label>
            <input type="number" step="0.01" class="form-control" name="price">
          </div>
          <div class="mb-3">
            <label class="form-label">Polkasi</label>
            <input type="text" class="form-control" name="shelf">
          </div>
          <div class="mb-3">
            <label class="form-label">Sotuv</label>
            <div class="form-check">
              <input class="form-check-input" type="checkbox" name="sale" id="for_sale">
              <label class="form-label" id="sale_label" for="for_sale">
                Sotuvga qoyish
              </label>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
        <button type="submit" class="btn btn-primary" form="editForm" name="editOrder">Tasdiqlash</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="filterModalLabel">Filter</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="filterForm" method="post">
          <div class="mb-3">
            <div class="col" style="display: flex;">
              <div class="form-group m-t-15 m-checkbox-inline mb-0">
                <div class="checkbox checkbox-dark">
                  <input id="inline-1" type="checkbox" name="debts">
                  <label for="inline-1">Qarzi borlar</label>
                </div>
                <div class="checkbox checkbox-dark">
                  <input id="inline-2" type="checkbox" name="payments">
                  <label for="inline-2">To'langanlar</label>
                </div>
              </div>
              <div class="form-group m-t-15 m-checkbox-inline mb-0">
                <div class="checkbox checkbox-dark">
                  <input id="inline-3" type="checkbox" name="sklatda">
                  <label for="inline-3">Sklatda borlari</label>
                </div>
                <div class="checkbox checkbox-dark">
                  <input id="inline-4" type="checkbox" name="taken">
                  <label for="inline-4">Olib ketilganlar</label>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
        <button type="submit" class="btn btn-primary" form="filterForm" name="filterTable">Filter</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="miniKassa" tabindex="-1" aria-labelledby="miniKassaLabel" aria-hidden="true">

</div>

<?
if (isset($_POST["addOrder"])) {

  $client_code = $_POST["type"] . ' ' . $_POST["clientID"];
  $now = date("Y-m-d H:i:s");
  $user_id = $_SESSION["user"]["id"];
  $insert = db::query("INSERT INTO `ac_zakaz` (`REYS_ID`,`CREATED_BY`,`CREATED_DATE`,`CLIENT_CODE`,`ACTIVE`) VALUES ('$_SESSION[filter_reys]','$user_id','$now','$client_code','1')");
  header("Location: ./detail/$insert[ID]");
  exit;
}
if (isset($_POST["editOrder"])) {
  if($_POST['sale'] == 'on'){
    $_POST['sale'] = 1;
  }else{
    $_POST['sale'] = 0;
  }

  $update = db::query("UPDATE `ac_zakaz` SET `CLIENT_CODE`='$_POST[client_code]', `WEIGHT`='$_POST[weight]', `SHELF`='$_POST[shelf]', `PRICE`='$_POST[price]', `SALE` = '$_POST[sale]' WHERE ID='$_POST[order_id]'");
  LocalRedirect("index.php");
}

if (isset($_POST["saveSubmit"]) or isset($_POST["takeSubmit"])) {
  $now = date("Y-m-d H:i:s");
  $curdate = date("Y-m-d");
  $user_id = $_SESSION['user']['id'];
  $kurs = db::arr_s("SELECT * FROM `kurs_valyut` WHERE ACTIVE=1");
  $order = db::arr_s("SELECT * FROM `ac_zakaz` WHERE ID='$_POST[order_id]'");

  if (!empty($_POST["card"]) and is_numeric($_POST["card"])) {
    $dollar_summa = round($_POST["card"] / $kurs["VALUE"], 2);
    $insert = db::query("INSERT INTO `ac_transactions`
    (`CREATED_DATE`,`CREATED_BY`,`CHANGED_DATE`,`CHANGED_BY`,`ORDER_ID`,`PAYMENT_TYPE`,`VALYUTA`,`SUMMA_UZS`,`SUMMA_USD`,`KURS`,`STATUS`) VALUES 
    ('$now', '$user_id','$now','$user_id','$_POST[order_id]','CARD','UZS','$_POST[card]','$dollar_summa','$kurs[VALUE]','accept')");
  }

  if (!empty($_POST["cash"]) and is_numeric($_POST["cash"])) {
    $dollar_summa = round($_POST["cash"] / $kurs["VALUE"], 2);
    $insert = db::query("INSERT INTO `ac_transactions`
    (`CREATED_DATE`,`CREATED_BY`,`CHANGED_DATE`,`CHANGED_BY`,`ORDER_ID`,`PAYMENT_TYPE`,`VALYUTA`,`SUMMA_UZS`,`SUMMA_USD`,`KURS`,`STATUS`) VALUES 
    ('$now', '$user_id','$now','$user_id','$_POST[order_id]','CASH','UZS','$_POST[cash]','$dollar_summa','$kurs[VALUE]','accept')");
  }

  $payment_total_amount = db::arr_s("SELECT SUM(SUMMA_USD) AS USD FROM `ac_transactions` WHERE ORDER_ID='$_POST[order_id]'");
  $calculate_left_amount = $order["PRICE"] - $payment_total_amount["USD"];

  if ($calculate_left_amount < 0) {
    $left = 0;
  } else {
    $left = $calculate_left_amount * -1;
  }

  if (isset($_POST["takeSubmit"])) {
    db::query("UPDATE `ac_zakaz` SET `DEBTS`='$left',`TAKEN`=1, `PAID`=1 WHERE ID='$_POST[order_id]'");
  } elseif (isset($_POST["saveSubmit"])) {
    db::query("UPDATE `ac_zakaz` SET `DEBTS`='$left', `PAID`=1 WHERE ID='$_POST[order_id]'");
  }

  LocalRedirect("index.php");
}


if (isset($_POST["filterTable"])) {

  if ($_POST["debts"] == "on") {
    $debts = "DEBTS < 0";
  } else {
    $debts = "";
  }
  if ($_POST["payments"] == "on") {
    $payments = "DEBTS >= 0";
  } else {
    $payments = "";
  }
  if ($_POST["sklatda"] == "on") {
    $sklatda = "TAKEN = 0";
  } else {
    $sklatda = "";
  }
  if ($_POST["taken"] == "on") {
    $taken = "TAKEN = 1";
  } else {
    $taken = "";
  }

  if ($taken != "" and ($payments != "" or $sklatda != "" or $debts != "")) {
    $taken = " AND " . $taken;
  }
  if ($sklatda != "" and ($payments != "" or $debts != "")) {
    $sklatda = " AND " . $sklatda;
  }
  if ($payments != "" and $debts != "") {
    $payments = " AND " . $payments;
  }
  if ($taken != "" or $payments != "" or $sklatda != "" or $debts != "") {

    $_SESSION["filter_order"] = "$debts $payments $sklatda $taken AND";
  } else {
    $_SESSION["filter_order"] = "";
  }
  LocalRedirect("index.php");
}
?>