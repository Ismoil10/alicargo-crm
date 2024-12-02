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

<!-- Report -->
<div class="modal fade" id="report" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="add_item">Hisobot</h5>
				<button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST">
				<div class="modal-body">
					<div class="mb-3">
						<label class="form-label">Hisobot</label>
						<div class="input-group">
							<select name="report_type" id="filterId" class="form-select">
								<option value="accounting_report">KASSA</option>
								<option value="order_reys">ZAKAZ REYS</option>
							</select>
						</div>
					</div>
					<div class="mb-3" id="inputReys" style="display: none;">
						<label class="form-label">Reyslar</label>
						<div class="input-group">
							<select class="form-control" id="targetFilter" name="filter_reys">
								<option></option>
								<? foreach (db::arr("SELECT * FROM `ac_reys` ORDER BY ID DESC") as $v): ?>
									<option value="<?= $v['ID'] ?>" <? if ($_SESSION['filter_order_reys'] == $v['ID']) {
																		echo 'selected';
																	} ?>><?= $v['COMMENT'] ?> (<?= $v['DATE'] ?>)</option>
								<? endforeach; ?>
							</select>
						</div>
					</div>
					<div class="mb-3" id="inputCal">
						<div class="form-group">
							<label>Sanani Tanglang</label>
							<input class="datepicker-here form-control digits" autocomplete="off" name="daterange" type="text" data-range="true" data-multiple-dates-separator=" - " data-language="ru">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Bekor qilish</button>
					<button class="btn btn-primary" name="show_report" type="submit">Ko'ring</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- End report -->
<script>
    /*    const selectElement = document.getElementById('targetFilter');

          function targetFilter(){
            const selectedIndex = selectElement.selectedIndex;
            const selectedOption = selectElement.options[selectedIndex];

            const optionsArray = Array.from(selectElement.options);
            
            optionsArray.splice(selectedIndex, 1);
            
            optionsArray.unshift(selectedOption);

            selectElement.innerHTML = '';

            optionsArray.forEach(option => selectElement.appendChild(option));
            selectElement.selectedIndex = 0;
          };

          targetFilter();*/
    </script>
<div class="modal fade" id="miniKassa" tabindex="-1" aria-labelledby="miniKassaLabel" aria-hidden="true">

</div>

<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Zakaz Tahrirlash</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
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
                  <label for="inline-1">To'lov qilmaganlar</label>
                </div>
                <div class="checkbox checkbox-dark">
                  <input id="inline-2" value="payments" type="checkbox" name="payments">
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

<?

if(isset($_POST["addOrder"])){

  $client_code = $_POST["type"].' '.$_POST["clientID"];
  $now= date("Y-m-d H:i:s");
  $user_id = $_SESSION["user"]["id"];
  $insert = db::query("INSERT INTO `ac_zakaz` (`REYS_ID`,`CREATED_BY`,`CREATED_DATE`,`CLIENT_CODE`,`ACTIVE`) VALUES ('$_SESSION[filter_reys]','$user_id','$now','$client_code','1')");
  LocalRedirect("index.php");
  exit;
}
if(isset($_POST["editOrder"])){
  $update = db::query("UPDATE `ac_zakaz` SET `CLIENT_CODE`='$_POST[client_code]', `WEIGHT`='$_POST[weight]', `SHELF`='$_POST[shelf]', `PRICE`='$_POST[price]' WHERE ID='$_POST[order_id]'");
  LocalRedirect("index.php");
}

if(isset($_POST["filterTable"])){

  if($_POST["debts"]=="on"){
    $_SESSION['filter_type'] = "debts";
    $debts = "PAID = 0";
  }else{
    $_SESSION['filter_type'] = "";
    $debts = "";
  }
  if($_POST["payments"]=="on"){
    $_SESSION['filter_type'] = "payments";
    $payments = "DEBTS >= 0";
  }else{
    $_SESSION['filter_type'] = "";
    $payments = "";
  }
  if($_POST["sklatda"]=="on"){
    $_SESSION['filter_type'] = "sklatda";
    $sklatda = "TAKEN = 0";
  }else{
    $_SESSION['filter_type'] = "";
    $sklatda = "";
  }
  if($_POST["taken"]=="on"){
    $_SESSION['filter_type'] = "taken";
    $taken = "PAID = 1";
  }else{
    $_SESSION['filter_type'] = "";
    $taken = "";
  }

  if( $taken != "" and ($payments != "" or $sklatda != "" or $debts != "")){
    $taken = " AND ".$taken;
  }
  if($sklatda != "" and ($payments != "" or $debts != "")){
    $sklatda = " AND ".$sklatda;
  }
  if($payments != "" and $debts != ""){
    $payments = " AND ".$payments;
  }
  if($taken != "" or $payments != "" or $sklatda != "" or $debts != ""){
    
    $_SESSION["filter_data_order"] = " AND $debts $payments $sklatda $taken";
    
    if($taken != ""){
    $_SESSION["taken_order"] = "AND orders.PAID = '1'";
    }else{
    $_SESSION["taken_order"] = "";
    }
  }else{
    $_SESSION["filter_data_order"] = "";
  }
  LocalRedirect("index.php");
}

?>


<script>

$("#filterId").on("change", function(e) {

getReys = $(".modal-dialog #inputReys");
getCal = $(".modal-dialog #inputCal");

getReys.hide();
getCal.hide();

switch (e.target.value) {

	case "accounting_report":
		getCal.show();
		break;
	case "order_reys":
		getReys.show();
		break;
}

});

</script>