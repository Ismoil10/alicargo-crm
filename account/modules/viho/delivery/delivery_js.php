<script>

function filterModal() {
    $('#filterModal').modal("show");
}

function infoModal(id){
    form = new FormData();
    form.append("order_id", id);
    js_ajax_post("delivery/delivery_info_modal.php",form).done(data=>{
      $("#infoModal").html(data);
      $("#infoModal").modal("show");
    });
  }

function deleteModal(id){
  $("[name=deleteId]").val(id);
  $("#deleteModal").modal("show");
}

function shippedModal(id){
    $("[name=order_id]").val(id);
    $("#shippedModal").modal("show");
  }

function deliveryTypeModal(id){
  form = new FormData();
    form.append("deliveryId", id);
    js_ajax_post("delivery/delivery_type_modal.php",form).done(data=>{
      $("#deliveryTypeModal").html(data);
      $("#deliveryTypeModal").modal("show");
    });
}



</script>