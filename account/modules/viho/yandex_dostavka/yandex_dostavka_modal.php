<?

if (isset($_POST['filterSubmit'])) {

    if ($_POST['order_type'] == 'taken') {
        $_SESSION['yandex_type'] = 'taken';
    }elseif ($_POST['order_type'] == 'not_taken') {
        $_SESSION['yandex_type'] = 'not_taken';
    }else{
        $_SESSION['yandex_type'] = 'all';
    }

    LocalRedirect("index.php");
}


if (isset($_POST["shippedSubmite"])) {
    $now = date("Y-m-d H:i:s");

    $delivery = db::query("UPDATE `ac_location` SET `STATUS`='delivered', `ACTIVE`='0' WHERE `ORDER_ID`='$_POST[order_id]'");

    $update = db::query("UPDATE `ac_zakaz` SET `TAKEN`='1', `PAID`='1', `PICKUP_DATE`='$now' WHERE ID='$_POST[order_id]'");

    if ($update["stat"] == "success") {
        LocalRedirect("index.php");
    }
}

if (isset($_POST["deleteSubmit"])) {

    $delivery = db::query("UPDATE `ac_location` SET `ACTIVE`='0' WHERE `ID`='$_POST[deleteId]'");
    
    if ($delivery["stat"] == "success") {
        LocalRedirect("index.php");
}
}

?>

<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterModalLabel">Filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="filterForm" method="post">
                    <label>Filter</label>
                    <div class="mb-3">
                        <select class="form-control" name="order_type">
                            <option></option>
                            <option value="all" <? if ($_SESSION['yandex_type'] == 'all') {echo "selected";}?>>Hammasi</option>
                            <option value="taken" <? if ($_SESSION['yandex_type'] == 'taken') {echo "selected";}?>>Olib ketilgan</option>
                            <option value="not_taken" <? if ($_SESSION['yandex_type'] == 'not_taken' or !isset($_SESSION['order_type'])) {echo "selected";}?>>Sklatda borlari</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="submit" class="btn btn-primary" form="filterForm" name="filterSubmit">Filter</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade bd-example-modal-lg" tabindex="-1" id="infoModal" role="dialog" aria-labelledby="infoModalLabel" aria-hidden="true">

</div>

<div class="modal fade bd-example-modal-lg" tabindex="-1" id="shippedModal" role="dialog" aria-labelledby="shippedModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="shippedModalLabel">Zakaz Yetkazib Berildi</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="shippedForm" method="post">
                    <div class="mb-3">
                        <p>Haqiqatan ham buyurtma holatini <b>YETKAZILDI </b> ga oʻzgartirmoqchimisiz?</p>
                        <input type="hidden" name="order_id">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Yo'q</button>
                <button class="btn btn-primary" type="submit" form="shippedForm" name="shippedSubmite">Ha</button>
            </div>
        </div>
    </div>
</div>

<!-- DELETE MODAL -->

<div class="modal fade text-left" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="editModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="editModal">O'chirish</h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
        </button>
      </div>
      <form action="" method="post" id="deleteForm">
      <div class="modal-body">
          <input type="hidden" name="deleteId">
        <div class="row">
          <div class="col-md-12 p-1 mt-1">
            <h4>Ushbu buyurtmani o'chirib tashlamoqchimisiz?</h4>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Bekor Qilish</button>
        <button type="submit" class="btn btn-primary" form="deleteForm" name="deleteSubmit">O'chirish</button>
      </div>
      </form>
    </div>
  </div>
</div>