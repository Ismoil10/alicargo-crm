<script>

$(document).ready(function (){

    addModal = function(){
    $("#addModal").modal("show");
  }
  filterModal = function(){
    $("#filterModal").modal("show");
  }
  editModal = function(jsonData){
    json = JSON.parse(JSON.parse(jsonData));
    $("[name=order_id]").val(json.ID);
    $("[name=client_code]").val(json.CLIENT_CODE);
    $("[name=weight]").val(json.WEIGHT);
    $("[name=price]").val(json.PRICE);
    $("[name=shelf]").val(json.SHELF);
    $("#editModal").modal("show");
  }

// edit_item = function (value) {
//    var jsonValue = JSON.parse(JSON.parse(value));
   
//    $('[name=edit_item_id]').val(jsonValue.ID);
//    $('[name=name_uz]').val(jsonValue.NAME_UZ);
//    $('[name=name_ru]').val(jsonValue.NAME_RU);
//    $('#edit_item').modal("show");
// }

// delete_item  = function (id) {
//     $('[name=del_item_id]').val(id);
//     $('#del_item').modal("show");
// }

report = function(){
    $(".report_info").modal("hide");
}

});


  document.getElementById("client_code").addEventListener("keyup", e=>{
    const re = /^\d+$/;
    const code = document.getElementById("client_code");
    if(!re.test(code.value) && code.value !=""){
      code.classList.add("is-invalid");
    }else{
      code.classList.remove("is-invalid");
    }
  });

</script>