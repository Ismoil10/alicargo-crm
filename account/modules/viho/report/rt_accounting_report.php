<?
$from_date = $_SESSION['report']['from_date'];
$to_date = $_SESSION['report']['to_date'];
$data = db::arr_s("SELECT SUM(SUMMA_UZS) AS UZS, 
(SELECT COUNT(PAYMENT_TYPE) FROM `ac_transactions` WHERE PAYMENT_TYPE='CARD' AND CREATED_DATE BETWEEN '$from_date' AND '$to_date') AS AMOUNT_CARD,
(SELECT SUM(SUMMA_UZS) FROM `ac_transactions` WHERE PAYMENT_TYPE='CARD' AND CREATED_DATE BETWEEN '$from_date' AND '$to_date') AS SUM_CARD,
(SELECT COUNT(PAYMENT_TYPE) FROM `ac_transactions` WHERE PAYMENT_TYPE='CASH' AND CREATED_DATE BETWEEN '$from_date' AND '$to_date') AS AMOUNT_CASH,
(SELECT SUM(SUMMA_UZS) FROM `ac_transactions` WHERE PAYMENT_TYPE='CASH' AND CREATED_DATE BETWEEN '$from_date' AND '$to_date') AS SUM_CASH 
FROM `ac_transactions` WHERE CREATED_DATE BETWEEN '$from_date' AND '$to_date'");

$data_list = db::arr("SELECT act.*, acz.CLIENT_CODE
FROM `ac_transactions` act
LEFT JOIN `ac_zakaz` acz ON act.ORDER_ID=acz.ID
WHERE act.CREATED_DATE BETWEEN '$from_date' AND '$to_date'");

?>
<h5 class="mb-3"><?= date("d.m.Y (H:i)", strtotime($from_date)) . ' dan ' . date("d.m.Y (H:i)", strtotime($to_date)) . ' gacha' ?> Bo'lgan To'lovlar</h5>
<div class="row">
    <div class="col-xl-4 col-sm-6">
        <div class="card ecommerce-widget pro-gress">
            <div class="card-body support-ticket-font">
                <div class="row">
                    <div class="col-5" style="width: 100%;">
                        <h6>Jami</h6>
                        <h4 class="total-num mb-3"><?=number_format($data["UZS"])?> <small>UZS</small></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6">
        <div class="card ecommerce-widget pro-gress">
            <div class="card-body support-ticket-font">
                <div class="row">
                    <div class="col-5" style="width: 100%;">
                        <h6>Karta</h6>
                        <h4 class="total-num"><?=number_format($data["SUM_CARD"])?> <small>UZS</small></h4>
                        <small><?=$data["AMOUNT_CARD"]?> ta</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6">
        <div class="card ecommerce-widget pro-gress">
            <div class="card-body support-ticket-font">
                <div class="row">
                    <div class="col-5" style="width: 100%;">
                        <h6>Naqd</h6>
                        <h4 class="total-num"><?=number_format($data["SUM_CASH"])?> <small>UZS</small></h4>
                        <small><?=$data["AMOUNT_CASH"]?> ta</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="table-responsive">
    <table class="display" id="basic-2">
        <thead>
            <tr>
                <th>SANA</th>
                <th>KLIENT</th>
                <th>ZAKAZ ID</th>
                <th>SUMMA</th>
                <th>TYPE</th>
            </tr>
        </thead>
        <tbody>
            <? foreach ($data_list as $data_value) : ?>
                <tr>
                    <td><?= $data_value['CHANGED_DATE'] ?></td>
                    <td><?= $data_value['CLIENT_CODE'] ?></td>
                    <td><?= $data_value['ID'] ?></td>
                    <td><?= number_format($data_value["SUMMA_UZS"]) ?> UZS</td>
                    <td><?= $data_value['PAYMENT_TYPE'] ?></td>
                </tr>
            <? endforeach; ?>
        </tbody>
    </table>
</div>