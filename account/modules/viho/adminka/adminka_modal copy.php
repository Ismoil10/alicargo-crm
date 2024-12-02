<?

if (isset($_POST['addSubmit'])) {
  $admin = db::arr_s("SELECT * FROM tg_users WHERE ID = '$_POST[admin_id]'");

  /*$admin_name = filter_input(INPUT_POST, "admin_name", FILTER_SANITIZE_ADD_SLASHES);
  $last_name = filter_input(INPUT_POST, "admin_surname", FILTER_SANITIZE_ADD_SLASHES);
  $phone = $_POST['phone_num'];*/

  /*$formatted = preg_replace('/[^0-9.]+/', '', $phone);
  if (strlen($formatted) == 12) {
  }*/
    db::query("INSERT INTO `ac_adminka` (
`CODE`,
`NAME`, 
`PHONE`,
`ACTIVE`
) VALUES (
'$admin[CODE]',
'$admin[ISM_FAMILIYA]',
'$admin[PHONE]',
'1')");
  

  LocalRedirect("index.php");
}

/*if (isset($_POST['editAdmin'])) {

  $edit_name = filter_input(INPUT_POST, "edit_name", FILTER_SANITIZE_ADD_SLASHES);
  $edit_surname = filter_input(INPUT_POST, "edit_surname", FILTER_SANITIZE_ADD_SLASHES);
  $edit_phone = $_POST['edit_phone'];

  $phone_formatted = preg_replace('/[^0-9.]+/', '', $edit_phone);
  if (strlen($phone_formatted) == 12) {
    db::query("UPDATE `ac_adminka` SET 
`NAME` = '$edit_name',
`SURNAME` = '$edit_surname',
`PHONE` = '$phone_formatted'
WHERE `ID` = '$_POST[edit_id]'");
  }
  LocalRedirect("index.php");
}*/

if (isset($_POST['deleteSubmit'])) {

  db::query("UPDATE `ac_adminka` SET `ACTIVE` = '0' WHERE `ID` = '$_POST[deleteID]'");

  LocalRedirect("index.php");
}


$select_admin = db::arr("SELECT * FROM tg_users WHERE CODE IS NOT NULL");
?>

<div class="modal fade text-left" id="addModal"  role="dialog" aria-labelledby="addModalLabel1" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="addModalLabel1">Qo'shish</h4>
        <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="" method="post" id="addForm">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-12">
              <div class="mb-3">
                <select class="select2 form-select" name="admin_id" id="admin_id" onchange="addAdmin(this.value)">
                <option></option>
                  <? foreach ($select_admin as $v) : ?>
                    <option value="<?= $v['ID'] ?>"><?= $v['CODE'] ?></option>
                  <? endforeach; ?>
                </select>
              </div>
              <div class="mb-3" id="insertData">
                <div class="user-list">

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Bekor qilish</button>
          <button type="submit" id="addButton" form="addForm" onclick="checkInput()" name="addSubmit" class="btn btn-primary">Qo'shish</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
addAdmin = function(id){
    formData = new FormData();
    formData.append("user_id", id);
      js_ajax_post("adminka/adminka_data.php", formData).done(function(data) {
        $(".user-list").html(data);
        //console.log(data);           
    });
  }

  $("#admin_id").select2({
    allowClear: true,
    placeholder: ''
  });
});

  const phoneNum = document.getElementById("phoneNum");
  const submit = $("#addButton");
  const error = $("#error-alert");

 /* checkInput = function() {
    const phoneLen = phoneNum.value.length;

    //console.log(phoneL);
    if (phoneLen == 12 || phoneLen == 13) {
      submit.attr("type", "submit");
    } else {
      submit.attr("type", "button");
      error.show();
    }
  }*/
</script>

<!-- EDIT MODAL -->

<div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel1" aria-hidden="true">

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
          <input type="hidden" name="deleteID">
          <div class="row">
            <div class="col-md-12 p-1 mt-1">
              <h4>Ushbu adminni o'chirib tashlamoqchimisiz?</h4>
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