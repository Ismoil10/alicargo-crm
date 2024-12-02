<script>

function filterModal() {
    $('#filterModal').modal("show");
}

function infoYandexModal(id){
    form = new FormData();
    form.append("yandex_order_id", id);
    js_ajax_post("yandex_dostavka/yandex_dostavka_info_modal.php",form).done(data=>{
      $("#infoModal").html(data);
      $("#infoModal").modal("show");
    });
  }

function shippedYandexModal(id){
    $("[name=order_id]").val(id);
    $("#shippedModal").modal("show");
  }

function deleteModal(id){
  $("[name=deleteId]").val(id);
  $("#deleteModal").modal("show");
}

</script>