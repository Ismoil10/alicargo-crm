
<?

if(isset($_POST['addSubmit'])){

$createdDate = $_POST['created_date'];
$districtId = $_POST['district_id'];
$driverId = $_POST['employee_id'];

// $getLocations = db::arr("SELECT ID FROM ac_location
// WHERE DISTRICT_ID = '$districtId' 
// AND `TYPE` = 'dostavka' 
// AND `STATUS` = 'new'
// AND `ACTIVE` = 1");


//foreach($getLocations as $v){

db::query("INSERT INTO `ac_marshrut`
(`EMPLOYEE_ID`,
`CREATED_DATE`,
`DISTRICT_ID`,
`ACTIVE`)
VALUES 
('$driverId',
'$createdDate',
'$districtId',
'1')");

//}


LocalRedirect("index.php");
}

$selectDistrict = db::arr("SELECT * FROM ac_rayon WHERE ACTIVE = 1");

$selectEmployee = db::arr("SELECT * FROM gl_sys_users WHERE `STATUS` = 1");

?>

<div class="modal fade text-left" id="addModal" role="dialog" aria-labelledby="addModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <? //echo '<pre>'; print_r($getLocations); echo '</pre>'; ?>
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
                                <input class="form-control" type="datetime-local" name="created_date">
                            </div>
                            <label class="form-label mb-2">Rayon</label>
                            <div class="mb-3">
                                <select class="form-control" name="district_id">
                                    <option></option>
                                    <? foreach($selectDistrict as $v): ?>
                                        <option value="<?=$v['ID']?>"><?=$v['NAME_UZ']?></option>
                                    <? endforeach; ?>
                                </select>
                            </div>
                            <label class="form-label mb-2">Xodim</label>
                            <div class="mb-3">
                                <select class="form-control" name="employee_id">
                                    <option></option>
                                    <? foreach($selectEmployee as $v): ?>
                                        <option value="<?=$v['ID']?>"><?=$v['NAME']?></option>
                                    <? endforeach; ?>
                                </select>       
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