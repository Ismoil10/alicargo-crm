<?

if (isset($_POST["shippedSubmit"])) {
    $now = date("Y-m-d H:i:s");

    $delivery = db::query("UPDATE `ac_location` SET `STATUS`='delivered' WHERE `ORDER_ID`='$_POST[order_id]'");

    $update = db::query("UPDATE `ac_zakaz` SET `TAKEN`='1', `PICKUP_DATE`='$now' WHERE ID='$_POST[order_id]'");

    if ($update["stat"] == "success") {
        LocalRedirect("index.php");
    }
}

?>

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
                <button class="btn btn-primary" type="submit" form="shippedForm" name="shippedSubmit">Ha</button>
            </div>
        </div>
    </div>
</div>