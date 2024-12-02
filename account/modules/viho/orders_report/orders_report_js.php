<script>
  document.getElementById("client_code").addEventListener("keyup", e=>{
    const re = /^\d+$/;
    const code = document.getElementById("client_code");
    if(!re.test(code.value) && code.value !=""){
      code.classList.add("is-invalid");
    }else{
      code.classList.remove("is-invalid");
    }
  });
$(document).ready(()=>{
  addModal = function(){
    $("#addModal").modal("show");
  }
  filterModal = function(){
    $("#filterModal").modal("show");
  }
  editModal = function(jsonData){
    json = JSON.parse(JSON.parse(jsonData));
    for_sale = json.SALE === "0" ? false : true;
    
    var label_text;
    $('#editModal #for_sale').on("change", function() {
        if ($(this).is(":checked")) {
            text = "Sotuvdan olish";
        } else {
            text = "Sotuvga qoyish";
        }
        $("#sale_label").text(text);
    });
    label_text = for_sale ? "Sotuvdan olish" : "Sotuvga qoyish";
    $("#sale_label").text(label_text);
    $("#editModal #for_sale").prop("checked", for_sale);
    $("[name=order_id]").val(json.ID);
    $("[name=client_code]").val(json.CLIENT_CODE);
    $("[name=weight]").val(json.WEIGHT);
    $("[name=price]").val(json.PRICE);
    $("[name=shelf]").val(json.SHELF);
    $("#editModal").modal("show");
  }
});
</script>