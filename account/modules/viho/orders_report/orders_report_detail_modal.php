<div class="modal fade" id="closeOrderModal" tabindex="-1" aria-labelledby="closeOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="closeOrderModalLabel">Buyurtmani Yopish</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="closeOrderForm" method="post">
          <div class="mb-3">
            <label>KG</label>
            <div class="input-group">
              <span class="input-group-text">KG</span>
              <input type="number" step="0.01" name="weight" class="form-control">
            </div>
          </div>
          <div class="mb-3">
            <label>NARXI</label>
            <div class="input-group">
              <span class="input-group-text"><i data-feather="dollar-sign"></i></span>
              <input type="number" name="price" step="0.1" class="form-control">
            </div>
          </div>
          <div class="mb-3">
            <label>POLKA</label>
            <div class="input-group">
              <span class="input-group-text"><i data-feather="package"></i></span>
              <input type="text" name="shelf" class="form-control">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor Qilish</button>
        <button type="submit" class="btn btn-primary" form="closeOrderForm" name="closeOrder">Zakazni Qoshish</button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="deleteModalLabel">Zakazni O'chirish</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="" id="deleteForm" method="post">
          <div class="mb-3">
            <label>Ushbu trak kodni o'chirmoqchimisiz?</label>
            <input type="hidden" name="trackID">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor Qilish</button>
        <button type="submit" class="btn btn-primary" form="deleteForm" name="deleteTrackCode">Tasdiqlash</button>
      </div>
    </div>
  </div>
</div>
<script>
closeOrderModal = function(){
  $("#closeOrderModal").modal("show");
}
deleteModal = function(id){
  $("[name=trackID]").val(id);
  $("#deleteModal").modal("show");
}
</script>
<?
if(isset($_POST["closeOrder"])){
  $price = is_numeric($_POST["price"])? $_POST["price"]:null;
  $weight = is_numeric($_POST["weight"])? $_POST["weight"]:null;
  $shelf = $_POST["shelf"];
  if($price != null and $weight != null and $shelf !=''){
    db::query("UPDATE `ac_zakaz` SET `PRICE`='$price', `WEIGHT`='$weight', `SHELF`='$shelf', `ACTIVE`=0, `STATUS`='new' WHERE ID='$_GET[item_id]'");
    header("Location: ../list");
    exit;
  }
}
if(isset($_POST["deleteTrackCode"])){
  db::query("DELETE FROM `order_item` WHERE ID='$_POST[trackID]'");
  header("Location: ./$_GET[item_id]");
  exit;
}
?>