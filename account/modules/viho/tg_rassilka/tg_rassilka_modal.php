<?
$now = date("Y-m-d H:i:s");

if (isset($_POST['addSubmit'])){

$type = $_POST['type_id'];

if ($_FILES["image"]["error"] != UPLOAD_ERR_NO_FILE) {
    $file = db::file_upload("image", "files");
}

$img_src = [
    "file" => $file["url"]
];

$image = json_encode($img_src);

$insert = db::query("INSERT INTO `tg_rassilka` (`CREATED_DATE`, `TEXT`, `FILE_URL`) VALUES ('$now', '$_POST[rassilka]', '$image')");

//$_SESSION['sql_text'] = "INSERT INTO `tg_rassilka` (`CREATED_DATE`, `TEXT`, `FILE_URL`) VALUES ('$now', '$_POST[rassilka]', '$image')";

if($type == 'all'){

$user = db::arr("SELECT * FROM tg_users");

}elseif($type == 'has_code'){

$user = db::arr("SELECT * FROM tg_users WHERE CODE IS NOT NULL");

}else{

$user = db::arr("SELECT * FROM tg_users WHERE CODE IS NULL");

}



foreach($user as $v){

$user_id = $v['ID'];
$chat_id = $v['CHAT_ID'];
$rassilka = $type;
$last_id = $insert['ID'];

db::query("INSERT INTO `message_log` (
`CREATE_DATE`,
`TYPE`,
`RASSILKA_ID`,  
`USER_ID`, 
`CHAT_ID`
) VALUES (
'$now',
'$rassilka',
'$last_id',
'$user_id',
'$chat_id'
)");
}

LocalRedirect("index.php");
}

if(isset($_POST['deleteSubmit'])){

$delete = db::query("DELETE FROM `tg_rassilka` WHERE `ID` = '$_POST[deleteID]'");

$update = db::query("UPDATE `message_log` SET `STATUS` = '2' WHERE `RASSILKA_ID` = '$_POST[deleteID]'");

LocalRedirect("index.php");

}

//$select_user = db::arr("SELECT * FROM tg_users WHERE CODE != NULL");


?>

<div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addModalLabel1">Qo'shish</h4>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" id="addForm" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?  
                            //echo '<pre>'; print_r($update); echo '</pre>'; ?>
                            <? //echo '<pre>'; print_r($group_id); echo '</pre>'; ?>
                            <?php
/*$send_message = "https://api.telegram.org/bot6184134321:AAEmEs19KumiA6oDikus4Upk_dVGJXt8j_c/sendPhoto?chat_id=1586146743&photo=https://demoschool.senet.uz/uploads/2723d092b63885e0d7c260cc007e8b9d.jpg&caption=dfdefwef";

$q[] = file_get_contents($send_message);

$get_id = json_decode($q['0'], true);

foreach($get_id as $v){


}*/

//echo "<pre>"; print_r($_POST); echo "</pre>"; 
?>
                            <label for="standart-select">Guruh</label>
                            <div class="select mb-2">
                                <select class="select2 form-select" name="type_id" style="width: 200px;">
                                    <option>None</option>
                                    <option value="all">Barcha</option>
                                    <option value="has_code">Kodi borlar</option>
                                    <option value="no_code">Kodi yo'qlar</option>
                                </select>
                            </div>
                            <label class="form-label mb-2">Rasimni tanlang</label>
                            <div class="custom-file mb-2">
                                <input type="file" name="image" class="custom-file-input" accept="image/*" onchange="loadFile_2(event)">
                            </div>
                            <div class="center-image"><img id="output1" width="60%" alt="" align="center"></div>
                            <script>
                                var loadFile_2 = function(event) {
                                    var reader = new FileReader();
                                    reader.onload = function() {
                                        var output = document.getElementById('output1');
                                        output.src = reader.result;
                                    };
                                    reader.readAsDataURL(event.target.files[0]);
                                };
                            </script>
                            <div class="mb-3">
                                <label class="label-form">Tekst</label>
                                <textarea name="rassilka" cols="30" rows="10" class="form-control" style="height: 150px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Bekor qilish</button>
                    <button type="submit" form="addForm" name="addSubmit" class="btn btn-primary">Qo'shish</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- VIEW MODAL -->

<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="taskModalLabel">

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
            <h4>Ushbu jo'natmani o'chirib tashlamoqchimisiz?</h4>
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

<style>
    .center-image {
        margin-top: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>