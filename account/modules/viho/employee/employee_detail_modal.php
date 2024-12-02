<?

if (isset($_POST['addSubmit'])) {

    $insert = db::query("INSERT INTO `ac_expense`
(`EMPLOYEE_ID`,
`AMOUNT`,
`COMMENT`,
`DATE`,
`ACTIVE`)
VALUES
('$user_id',
'$_POST[expense]',
'$_POST[comment]',
'$_POST[date]',
'1')");

    LocalRedirect("index.php");
}

if (isset($_POST['editSubmit'])) {

db::query("UPDATE `ac_expense` SET
`AMOUNT` = '$_POST[edit_expense]',
`COMMENT` = '$_POST[edit_comment]',
`DATE` = '$_POST[edit_data]'
WHERE `ID` = '$_POST[edit_id]'");

LocalRedirect("index.php");
}

if (isset($_POST['deleteSubmit'])) {

    db::query("UPDATE `ac_expense` SET `ACTIVE` = '0' WHERE `ID` = '$_POST[deleteID]'");

    LocalRedirect("index.php");
}

if(isset($_POST['filterSubmit'])){
    
    if($_POST['turn_off'] == 'on'){
        $_SESSION['date_range'] = null;
    }else{
        $_SESSION['date_range'] = $_POST['date_from_to'];
    }

    LocalRedirect("index.php");
}

$time = date("Y-m-d h:i");


?>

<div class="modal fade text-left" id="editModal" role="dialog" aria-labelledby="addModalLabel1" aria-hidden="true">

</div>


<div class="modal fade text-left" id="addExpenceModal" role="dialog" aria-labelledby="addModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <? //echo '<pre>'; print_r($_POST); echo '</pre>'; ?>
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel1">Qo'shish</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="addForm">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <label class="form-label mb-2">Data</label>
                            <div class="mb-3">
                                <input class="form-control" type="datetime-local" value="<?= $time ?>" name="date">
                            </div>
                            <label class="form-label mb-2">Xarajat</label>
                            <div class="mb-3">
                                <input class="form-control" type="number" name="expense" required>
                            </div>
                            <label class="form-label mb-2">Izoh</label>
                            <div class="mb-3">
                                <input class="form-control" type="text" name="comment" required>
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


<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="filterModalLabel">Filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="filterForm" method="post">
                    <label class="form-label mb-2">Data</label>
                    <div class="mb-3 input-container">
                        <input type="text" id="date-range-input" name="date_from_to" value="<? if(!empty($_SESSION['date_range'])){ echo $_SESSION['date_range'];} ?>" placeholder="Sanani tanlang">
                    </div>
                    <div class="checkbox checkbox-dark">
                        <input id="inline-4" type="checkbox" name="turn_off">
                        <label for="inline-4">Filter o'chirish</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Bekor qilish</button>
                <button type="submit" class="btn btn-primary" form="filterForm" name="filterSubmit">Filter</button>
            </div>
        </div>
    </div>
</div>



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
                            <h4>Ushbu xarajatni o'chirib tashlamoqchimisiz?</h4>
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

