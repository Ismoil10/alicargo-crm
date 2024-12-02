<?

if (isset($_POST['addSubmit'])) {
 


db::query("INSERT INTO `gl_sys_users`
(`NAME`,
`SURNAME`,
`LOGIN`,
`PHONE`,
`PASSWORD`,
`ROLE_ID`,
`STATUS`)
VALUES
('$_POST[username]',
'$_POST[surname]',
'$_POST[login]',
'$_POST[phone]',
'$_POST[password]',
'$_POST[role_id]',
'1')");
  

  LocalRedirect("index.php");
}


?>

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

<div class="modal fade text-left" id="addModal" role="dialog" aria-labelledby="addModalLabel1" aria-hidden="true">
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
                            <label for="standart-select">Rol</label>
                            <div class="select mb-2">
                                <select class="select2 form-select" name="role_id" style="width: 200px;">
                                    <option>None</option>
                                    <? foreach (db::arr("SELECT * FROM gl_sys_roles") as $v): ?>
                                        <option value="<?=$v['ID']?>"><?=$v['NAME']?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                            <label class="form-label mb-2">Ism</label>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="username">
                            </div>
                            <label class="form-label mb-2">Familiya</label>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="surname">
                            </div>
                            <label class="form-label mb-2">Login</label>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="login">
                            </div>
                            <label class="form-label mb-2">Parol</label>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="password">
                            </div>
                            <label class="form-label mb-2">Telefon</label>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="phone">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="submit" id="addButton" form="addForm" name="addSubmit" class="btn btn-primary">Qo'shish</button>
                </div>
            </form>
        </div>
    </div>
</div>