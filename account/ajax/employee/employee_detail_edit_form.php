<?require $_SERVER["DOCUMENT_ROOT"].'/core/backend.php';?>
<?
$id = $_POST['expenseId'];

$expense = db::arr_s("SELECT * FROM ac_expense WHERE ID = '$id'");


?>

<div class="modal-dialog" role="document">
        <div class="modal-content">
        <? //echo '<pre>'; print_r($id); echo '</pre>'; ?>
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel1">Tahrirlash</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="addForm">
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" name="edit_id" value="<?=$expense['ID']?>">
                        <div class="col-md-12">
                            <label class="form-label mb-2">Data</label>
                            <div class="mb-3">
                                <input class="form-control" type="datetime-local" value="<?=$expense['DATE']?>" name="edit_data" required>
                            </div>
                            <label class="form-label mb-2">Xarajat</label>
                            <div class="mb-3">
                                <input class="form-control" type="number" value="<?=$expense['AMOUNT']?>" name="edit_expense" required>
                            </div>
                            <label class="form-label mb-2">Izoh</label>
                            <div class="mb-3">
                                <input class="form-control" type="text" value="<?=$expense['COMMENT']?>" name="edit_comment" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="submit" id="addButton" form="addForm" name="editSubmit" class="btn btn-primary">Qo'shish</button>
                </div>
            </form>
        </div>
    </div>