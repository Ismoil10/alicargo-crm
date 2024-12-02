<? require $_SERVER['DOCUMENT_ROOT'] . '/core/backend.php'; ?>
<?
$admin_id = $_POST['adminId'];

$admin = db::arr_s("SELECT * FROM ac_adminka WHERE ID = '$admin_id'");

?>

   <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel1">O'zgartirish</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="editForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="edit_id" value="<?=$admin['ID']?>">
                            <div class="mb-3">
                                <label class="label-form">Ism</label>
                                <input type="text" class="form-control" name="edit_name" value="<?=$admin['NAME']?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="label-form">Familiya</label>
                                <input type="text" class="form-control" name="edit_surname" value="<?=$admin['SURNAME']?>" required>
                            </div>
                            <div class="mb-3">
                                <label class="label-form">Telefon</label>
                                <input type="text" class="form-control" name="editPhone" placeholder="+998 __ ___ __ __" value="<?=$admin['PHONE']?>" required>
                                <div id="error-alert" class="alert alert-danger mt-1 alert-validation-msg" style="display: none;" role="alert">
                                    <div class="alert-body">
                                        <i data-feather="info" class="mr-50 align-middle"></i>
                                        <span><strong>Xatolik</strong>. Telefonga 12 xonali raqam <strong>" +998 ** *** ** ** "</strong> kiritilishi shart.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="button" form="editForm" onclick="checkEditInput()" id="editButton" name="editAdmin" class="btn btn-primary">Saqlash</button>
                </div>
            </form>
        </div>
    </div>

<?/*
<script>

const editPhone= document.getElementById("editPhone");
const editButton = document.getElementById("editButton");
const errorAlert = document.getElementById("error-alert");

checkEditInput = function(){
  const phoneEditLen = editPhone.value.length;

  //console.log(phoneL);
  if(phoneEditLen == 12 || phoneEditLen == 13){
    editButton.type = "submit";
  }else{
    editButton.type = "button";
    errorAlert.style.display = "block";
  }
}

</script>

*/?>

