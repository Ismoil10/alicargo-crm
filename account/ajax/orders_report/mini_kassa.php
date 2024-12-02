<?
  require $_SERVER["DOCUMENT_ROOT"]."/core/backend.php";
  $order = db::arr_s("SELECT * FROM `ac_zakaz` WHERE ID='$_POST[ID]'");
  $transactions = db::arr("SELECT * FROM `ac_transactions` WHERE ORDER_ID='$_POST[ID]'");
  $tg_users = db::arr_s("SELECT * FROM `tg_users` WHERE CODE='$order[CLIENT_CODE]'");
  $kurs = db::arr_s("SELECT * FROM `kurs_valyut` WHERE ACTIVE='1'");
	$som = $kurs['VALUE'] * $order['PRICE'];
?>
<div class="modal-dialog modal-xl">
  <div class="modal-content">
    <div class="modal-header">
      <h1 class="modal-title fs-5" id="miniKassaLabel">Мини Касса</h1>
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
      <div class="row">
        <?if(!empty($order["PAYMENT_PHOTO"])):?>
        <div class="col-md-4 mx-auto" id="tolov_content">
          <img style="width: 100%;" src="/loading.gif" alt="">
        </div>
        <?else:?>
          <div class="col-md-4 mx-auto">
            <img style="width: 100%;" src="/loading.gif" alt="No Image" title="No Image Found">
            <small style="text-align: center;">Нет Фото</small>
          </div>
        <?endif?>
        <div class="col-md-6 mx-auto">
          <form id="paymentForm" action="" method="post" class="mb-4">
            <input type="hidden" name="order_id" value="<?=$order["ID"]?>">
            <div class="mb-3">
              <label class="form-label">Naxt Pul</label>
              <div class="input-group">
                <span class="input-group-text">UZS</span>
                <input type="number" name="cash" id="cash" class="form-control">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Plastik karta</label>
              <div class="input-group">
                <span class="input-group-text">UZS</span>
                <input type="number" name="card" id="card" class="form-control">
              </div>
            </div>
          </form>
          <?if($order["STATUS"] == 'pay_approve'):?>
            <hr>
          <div class="mb-4" id="pay_approve">
            <div class="mb-2">
            <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font p-3">
                  <div class="row">
                    <div class="col-6">
                      <h6>TO'LOV SANASI</h6>
                      <span><?=date('d.m.Y H:i:s', strtotime($order['LAST_MODIFIED']. ' - 3 hours'))?></span>
                    </div>
                    <div class="col-6">
                      <h6>PAYDO BO`LGAN SANA</h6>
                      <span><?=date('d.m.Y H:i:s', strtotime($order['CREATED_DATE']));?></span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font p-3">
                  <div class="row">
                    <div class="col-6">
                      <h6>ZAKAZ NARXI</h6>
                      <h5 class="total-num">$ <?=$order['PRICE']?></h5>
                    </div>
                    <div class="col-6">
                      <h6>KURS:</h6>
                      <h6 class="total-num"><?=number_format($kurs['VALUE'])?></h6>
                    </div>
                  </div>
                </div>
              </div>
              <div class="card ecommerce-widget pro-gress">
                <div class="card-body support-ticket-font p-3">
                  <div class="row">
                    <div class="col-5">
                      <h6>Skrinshotda:</h6>
                      <h4 class="total-num"><?=number_format($som,0,'',' ')?></h4>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mt-3">
                <label class="form-label">Skrinshotdagi summa:</label>
                <input type="hidden" name="kurs" value="<?=$kurs['VALUE']?>">				
                <input type="hidden" name="user_id" value="<?=$tg_users['ID']?>">	
                <input type="text" class="form-control" name="transaction_amount" value="<?=$som;?>" required>
              </div>
            </div>
            <div class="mb-2 float-end">
              <button class="btn btn-sm btn-secondary" name="reject_button" onclick="payment_approve('<?=$_POST['ID']?>', 'reject_button')" type="button">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg></button>
              <button class="btn btn-sm btn-primary" name="approve_button" onclick="payment_approve('<?=$_POST['ID']?>', 'approve_button')" type="button"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check-circle"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></button>
            </div>
          </div>
          <?endif?>
        </div>
      </div>
    </div>
    <div class="modal-body" id="transactions">
      <table class="table">
        <thead>
          <tr>
            <th>Sana</th>
            <th>Summa</th>
            <th>To'lov turi</th>
            <th>O'chirish</th>
          </tr>
        </thead>
        <tbody>
          <?foreach($transactions as $v):
            $total += $v["SUMMA_USD"]; ?>
          <tr id="payments_<?=$v['ID']?>">
            <td><?=date("d.m.Y", strtotime($v["CREATED_DATE"]))?></td>
            <td><?=$v["SUMMA_UZS"].' '.$v["VALYUTA"]?> <small>( USD = <?=$v["SUMMA_USD"]?>)</small></td>
            <td><?=$v["PAYMENT_TYPE"]?></td>
            <td id="deletePayment_<?=$v['ID']?>"><button class="btn btn-danger" onclick="deletePayment('<?=$v['ID']?>')"><span class="fa fa-trash"></span></button></td>
          </tr>
          <?endforeach?>
        </tbody>
      </table>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
      <button type="submit" name="saveSubmit" form="paymentForm" class="btn btn-primary">Saqlash</button>
      <button type="submit" name="takeSubmit" form="paymentForm" class="btn btn-primary">Olib ketdi</button>
    </div>
  </div>
</div>
<script>
$(document).ready(function () {


payment_load  = function () {
formData = new FormData();
formData.append('payment_photo','<?=$order['PAYMENT_PHOTO']?>');
js_ajax_post('viho/orders_report/mini_kassa.php',formData).done(function (data){
$('#tolov_content').html(data);
});}

payment_load();

update_payment_history = function(id){
  form = new FormData();
  form.append("ID", id);
  js_ajax_post("viho/orders_report/transactions.php", form).done(data => {
    $("#transactions").html(data);
  });
}

payment_approve = function (id, method){
  form = new FormData();
  form.append("ID", id);
  form.append("method", method);
  form.append("kurs", $("[name=kurs]").val());
  form.append("transaction_amount", $("[name=transaction_amount]").val());
  form.append("user_id", $("[name=user_id]").val());
  js_ajax_post("viho/orders_report/payment_approve.php",form).done((data)=>{
    res = JSON.parse(data);
    if(res.status){
      $("#pay_approve").hide();
      update_payment_history(id);
    }else{
      alert("ERROR 500");
    }
  });
}
deletePayment = function(id){
      conformButton = `
      <button class="btn btn-secondary" onclick="denyDelete(${id})"><span class="fa fa-times"></span></button>
      <button class="btn btn-primary" onclick="conformDelete(${id})"><span class="fa fa-check"></span></button>
      `;
      $("#deletePayment_"+id).html(conformButton);
    }
    conformDelete = function (id){
      form = new FormData();
      form.append("deletePayment", id);
      js_ajax_post("cashbox/send_order.php", form).done(data=>{
        $("#payments_"+id).remove();
      });
    }
    denyDelete = function(id){
      setButton = `
      <button class="btn btn-danger" onclick="deletePayment('${id}')"><span class="fa fa-trash"></span></button>
      `;
      $("#deletePayment_"+id).html(setButton);
    }

});
</script>