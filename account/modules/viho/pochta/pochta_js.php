<script>
  function filterModal(){
    $("#filterModal").modal("show");
  }
  

  function infoModal(id){
    form = new FormData();
    form.append("order_id", id);
    js_ajax_post("pochta/info_modal.php",form).done(data=>{
      $("#infoModal").html(data);
      $("#infoModal").modal("show");
    });
  }
  function shippedModal(id){
    $("[name=order_id]").val(id);
    $("#shippedModal").modal("show");
  }
</script>